<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use App\Models\ComponenteModel;
use App\Models\CertificadoModel;
use App\Models\MarcaModel;

class Equipos extends BaseController
{
    protected $equipoModel;
    protected $componenteModel;
    protected $certificadoModel;
    protected $marcaModel;

    public function __construct()
    {
        $this->equipoModel      = new EquipoModel();
        $this->componenteModel  = new ComponenteModel();
        $this->certificadoModel = new CertificadoModel();
        $this->marcaModel       = new MarcaModel();
    }

    public function index()
    {
        $data = [
            'titulo'  => 'Gestión de Equipos',
            'equipos' => $this->equipoModel->findAll()
        ];
        return view('equipos/index', $data);
    }

    public function nuevo()
    {
        return view('equipos/form', [
            'titulo' => 'Nuevo Equipo',
            'equipo' => null,
            'marcas' => $this->marcaModel->getListado(),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'codigo'      => 'required|max_length[50]',
            'descripcion' => 'permit_empty|max_length[255]',
            'marca'       => 'permit_empty|max_length[100]',
            'modelo'      => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return view('equipos/form', [
                'titulo'     => 'Nuevo Equipo',
                'equipo'     => null,
                'marcas'     => $this->marcaModel->getListado(),
                'validation' => $this->validator,
            ]);
        }

        $this->equipoModel->save([
            'codigo'              => $this->request->getPost('codigo'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'id_marca'            => $this->request->getPost('id_marca') ?: null,
            'modelo'              => $this->request->getPost('modelo'),
            'dominio'             => $this->request->getPost('dominio'),
            'numero_serie'        => $this->request->getPost('numero_serie'),
            'fecha_garantia'      => $this->request->getPost('fecha_garantia') ?: null,
            'descripcion_tecnica' => $this->request->getPost('descripcion_tecnica'),
            'fecha_ingreso'       => $this->request->getPost('fecha_ingreso') ?: null,
            'estado'              => 1,
        ]);

        return redirect()->to('/equipos')->with('success', 'Equipo registrado correctamente.');
    }

    public function editar($id)
    {
        $equipo = $this->equipoModel->find($id);
        if (!$equipo) return redirect()->to('/equipos')->with('error', 'Equipo no encontrado.');

        return view('equipos/form', [
            'titulo' => 'Editar Equipo',
            'equipo' => $equipo,
            'marcas' => $this->marcaModel->getListado(),
        ]);
    }

    public function actualizar($id)
    {
        $rules = [
            'codigo'      => 'required|max_length[50]',
            'descripcion' => 'permit_empty|max_length[255]',
            'marca'       => 'permit_empty|max_length[100]',
            'modelo'      => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            $equipo = $this->equipoModel->find($id);
            return view('equipos/form', [
                'titulo'     => 'Editar Equipo',
                'equipo'     => $equipo,
                'marcas'     => $this->marcaModel->getListado(),
                'validation' => $this->validator,
            ]);
        }

        $this->equipoModel->update($id, [
            'codigo'              => $this->request->getPost('codigo'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'id_marca'            => $this->request->getPost('id_marca') ?: null,
            'modelo'              => $this->request->getPost('modelo'),
            'dominio'             => $this->request->getPost('dominio'),
            'numero_serie'        => $this->request->getPost('numero_serie'),
            'fecha_garantia'      => $this->request->getPost('fecha_garantia') ?: null,
            'descripcion_tecnica' => $this->request->getPost('descripcion_tecnica'),
            'fecha_ingreso'       => $this->request->getPost('fecha_ingreso') ?: null,
            'estado'              => $this->request->getPost('estado') ?? 1,
        ]);

        return redirect()->to('/equipos')->with('success', 'Equipo actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->equipoModel->update($id, ['estado' => 0]);
        return redirect()->to('/equipos')->with('success', 'Equipo desactivado.');
    }

    public function ver($id)
    {
        $equipo = $this->equipoModel->find($id);
        if (!$equipo) return redirect()->to('/equipos')->with('error', 'Equipo no encontrado.');

        $componentes = $this->componenteModel->getComponentesPorEquipo($id);

        // Para cada accesorio, cargar sus certificados
        $certificadosPorComponente = [];
        foreach ($componentes as $comp) {
            $certificadosPorComponente[$comp['id_componente']] =
                $this->certificadoModel->getCertificadosPorComponente($comp['id_componente']);
        }

        return view('equipos/ver', [
            'titulo'                    => 'Detalle del Equipo',
            'equipo'                    => $equipo,
            'componentes'               => $componentes,
            'certificadosPorComponente' => $certificadosPorComponente,
        ]);
    }
}
