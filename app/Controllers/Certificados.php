<?php

namespace App\Controllers;

use App\Models\CertificadoModel;
use App\Models\CertificadoDocumentoModel;
use App\Models\ComponenteModel;

class Certificados extends BaseController
{
    protected $certificadoModel;
    protected $componenteModel;
    protected $docModel;

    const MAX_DOCUMENTOS = 5;
    const UPLOAD_PATH    = FCPATH . 'uploads/certificados/';

    public function __construct()
    {
        $this->certificadoModel = new CertificadoModel();
        $this->componenteModel  = new ComponenteModel();
        $this->docModel         = new CertificadoDocumentoModel();
    }

    public function index()
    {
        $data = [
            'titulo'       => 'Certificados de Vigencia',
            'certificados' => $this->certificadoModel->getCertificadosConDetalle(),
            'conteo_docs'  => $this->docModel->getConteosPorCertificados(),
        ];
        return view('certificados/index', $data);
    }

    public function nuevo($id_componente = null)
    {
        $componente = null;
        if ($id_componente) {
            $componente = $this->componenteModel->find($id_componente);
            if (!$componente) {
                return redirect()->to('/certificados')->with('error', 'Accesorio no encontrado.');
            }
        }

        return view('certificados/form', [
            'titulo'        => 'Nuevo Certificado',
            'certificado'   => null,
            'componentes'   => $this->componenteModel->getComponentesConEquipo(),
            'id_componente' => $id_componente,
            'componente'    => $componente,
        ]);
    }

    public function guardar()
    {
        $rules = [
            'id_componente'         => 'required|integer',
            'numero_certificado'    => 'required|min_length[2]|max_length[100]',
            'entidad_certificadora' => 'required|min_length[2]|max_length[200]',
            'fecha_emision'         => 'required|valid_date[Y-m-d]',
            'fecha_vencimiento'     => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            $id_comp = $this->request->getPost('id_componente');
            return view('certificados/form', [
                'titulo'        => 'Nuevo Certificado',
                'certificado'   => null,
                'componentes'   => $this->componenteModel->getComponentesConEquipo(),
                'id_componente' => $id_comp,
                'componente'    => $id_comp ? $this->componenteModel->find($id_comp) : null,
                'validation'    => $this->validator,
            ]);
        }

        $this->certificadoModel->save([
            'id_componente'         => $this->request->getPost('id_componente'),
            'numero_certificado'    => $this->request->getPost('numero_certificado'),
            'entidad_certificadora' => $this->request->getPost('entidad_certificadora'),
            'fecha_emision'         => $this->request->getPost('fecha_emision'),
            'fecha_vencimiento'     => $this->request->getPost('fecha_vencimiento'),
            'observaciones'         => $this->request->getPost('observaciones'),
        ]);

        return redirect()->to('/certificados')->with('success', 'Certificado registrado correctamente.');
    }

    public function editar($id)
    {
        $certificado = $this->certificadoModel->getCertificadoConDetalle($id);
        if (!$certificado) {
            return redirect()->to('/certificados')->with('error', 'Certificado no encontrado.');
        }

        return view('certificados/form', [
            'titulo'        => 'Editar Certificado',
            'certificado'   => $certificado,
            'componentes'   => $this->componenteModel->getComponentesConEquipo(),
            'id_componente' => $certificado['id_componente'],
            'componente'    => $this->componenteModel->find($certificado['id_componente']),
        ]);
    }

    public function actualizar($id)
    {
        $certificado = $this->certificadoModel->find($id);
        if (!$certificado) {
            return redirect()->to('/certificados')->with('error', 'Certificado no encontrado.');
        }

        $rules = [
            'id_componente'         => 'required|integer',
            'numero_certificado'    => 'required|min_length[2]|max_length[100]',
            'entidad_certificadora' => 'required|min_length[2]|max_length[200]',
            'fecha_emision'         => 'required|valid_date[Y-m-d]',
            'fecha_vencimiento'     => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            $full = $this->certificadoModel->getCertificadoConDetalle($id);
            return view('certificados/form', [
                'titulo'        => 'Editar Certificado',
                'certificado'   => $full,
                'componentes'   => $this->componenteModel->getComponentesConEquipo(),
                'id_componente' => $this->request->getPost('id_componente'),
                'componente'    => $this->componenteModel->find($this->request->getPost('id_componente')),
                'validation'    => $this->validator,
            ]);
        }

        $this->certificadoModel->update($id, [
            'id_componente'         => $this->request->getPost('id_componente'),
            'numero_certificado'    => $this->request->getPost('numero_certificado'),
            'entidad_certificadora' => $this->request->getPost('entidad_certificadora'),
            'fecha_emision'         => $this->request->getPost('fecha_emision'),
            'fecha_vencimiento'     => $this->request->getPost('fecha_vencimiento'),
            'observaciones'         => $this->request->getPost('observaciones'),
        ]);

        return redirect()->to('/certificados')->with('success', 'Certificado actualizado correctamente.');
    }

    public function eliminar($id)
    {
        // Eliminar archivos físicos del certificado antes de borrarlo
        $docs = $this->docModel->getPorCertificado($id);
        foreach ($docs as $doc) {
            $ruta = self::UPLOAD_PATH . $doc['nombre_archivo'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
        $this->certificadoModel->delete($id);
        return redirect()->to('/certificados')->with('success', 'Certificado eliminado.');
    }

    public function porComponente($id_componente)
    {
        $componente = $this->componenteModel->find($id_componente);
        if (!$componente) {
            return redirect()->to('/certificados')->with('error', 'Accesorio no encontrado.');
        }

        return view('certificados/por_componente', [
            'titulo'        => 'Certificados del Accesorio',
            'certificados'  => $this->certificadoModel->getCertificadosPorComponente($id_componente),
            'componente'    => $componente,
            'id_componente' => $id_componente,
        ]);
    }

    // -------------------------------------------------------
    // Documentos adjuntos
    // -------------------------------------------------------

    public function documentos($id_certificado)
    {
        $certificado = $this->certificadoModel->getCertificadoConDetalle($id_certificado);
        if (!$certificado) {
            return redirect()->to('/certificados')->with('error', 'Certificado no encontrado.');
        }

        return view('certificados/documentos', [
            'titulo'        => 'Documentos — Cert. ' . $certificado['numero_certificado'],
            'certificado'   => $certificado,
            'documentos'    => $this->docModel->getPorCertificado($id_certificado),
            'max_docs'      => self::MAX_DOCUMENTOS,
        ]);
    }

    public function subirDocumento($id_certificado)
    {
        $certificado = $this->certificadoModel->find($id_certificado);
        if (!$certificado) {
            return redirect()->to('/certificados')->with('error', 'Certificado no encontrado.');
        }

        // Verificar límite
        $actuales = count($this->docModel->getPorCertificado($id_certificado));
        if ($actuales >= self::MAX_DOCUMENTOS) {
            return redirect()->to('certificados/documentos/' . $id_certificado)
                ->with('error', 'Se alcanzó el límite de ' . self::MAX_DOCUMENTOS . ' documentos por certificado.');
        }

        $archivo = $this->request->getFile('pdf');

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->to('certificados/documentos/' . $id_certificado)
                ->with('error', 'El archivo no es válido.');
        }

        if ($archivo->getClientMimeType() !== 'application/pdf') {
            return redirect()->to('certificados/documentos/' . $id_certificado)
                ->with('error', 'Solo se permiten archivos PDF.');
        }

        if ($archivo->getSize() > 10 * 1024 * 1024) {
            return redirect()->to('certificados/documentos/' . $id_certificado)
                ->with('error', 'El archivo supera el tamaño máximo de 10 MB.');
        }

        // Crear directorio si no existe
        if (!is_dir(self::UPLOAD_PATH)) {
            mkdir(self::UPLOAD_PATH, 0755, true);
        }

        $nombreOriginal = $archivo->getClientName();
        $nombreArchivo  = 'cert_' . $id_certificado . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';

        $archivo->move(self::UPLOAD_PATH, $nombreArchivo);

        $this->docModel->save([
            'id_certificado' => $id_certificado,
            'nombre_original'=> $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'tamanio'        => $archivo->getSize(),
        ]);

        return redirect()->to('certificados/documentos/' . $id_certificado)
            ->with('success', 'Documento "' . esc($nombreOriginal) . '" subido correctamente.');
    }

    public function eliminarDocumento($id_documento)
    {
        $doc = $this->docModel->find($id_documento);
        if (!$doc) {
            return redirect()->to('/certificados')->with('error', 'Documento no encontrado.');
        }

        $ruta = self::UPLOAD_PATH . $doc['nombre_archivo'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        $this->docModel->delete($id_documento);

        return redirect()->to('certificados/documentos/' . $doc['id_certificado'])
            ->with('success', 'Documento eliminado.');
    }

    public function verDocumento($id_documento)
    {
        $doc = $this->docModel->find($id_documento);
        if (!$doc) {
            return redirect()->to('/certificados')->with('error', 'Documento no encontrado.');
        }

        $ruta = self::UPLOAD_PATH . $doc['nombre_archivo'];
        if (!file_exists($ruta)) {
            return redirect()->to('certificados/documentos/' . $doc['id_certificado'])
                ->with('error', 'Archivo no encontrado en el servidor.');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $doc['nombre_original'] . '"')
            ->setBody(file_get_contents($ruta));
    }
}
