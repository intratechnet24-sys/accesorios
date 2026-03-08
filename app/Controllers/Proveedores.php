<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use App\Models\LocalidadModel;
use App\Models\ProvinciaModel;

class Proveedores extends BaseController
{
    protected $proveedorModel;
    protected $localidadModel;
    protected $provinciaModel;

    public function __construct()
    {
        $this->proveedorModel = new ProveedorModel();
        $this->localidadModel = new LocalidadModel();
        $this->provinciaModel = new ProvinciaModel();
    }

    public function index()
    {
        return view('proveedores/index', [
            'titulo'      => 'Proveedores',
            'proveedores' => $this->proveedorModel->getListado(),
        ]);
    }

    public function nuevo()
    {
        return view('proveedores/form', [
            'titulo'     => 'Nuevo Proveedor',
            'proveedor'  => null,
            'provincias' => $this->provinciaModel->orderBy('provincia', 'ASC')->findAll(),
            'localidades'=> [],
        ]);
    }

    public function guardar()
    {
        $rules = [
            'razon_social'  => 'required|min_length[2]|max_length[200]',
            'cuit_cuil_dni' => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return view('proveedores/form', [
                'titulo'      => 'Nuevo Proveedor',
                'proveedor'   => null,
                'provincias'  => $this->provinciaModel->orderBy('provincia', 'ASC')->findAll(),
                'localidades' => $this->request->getPost('id_provincia')
                    ? $this->localidadModel->getPorProvincia($this->request->getPost('id_provincia'))
                    : [],
                'validation'  => $this->validator,
            ]);
        }

        $this->proveedorModel->save([
            'razon_social'  => $this->request->getPost('razon_social'),
            'cuit_cuil_dni' => $this->request->getPost('cuit_cuil_dni'),
            'direccion'     => $this->request->getPost('direccion'),
            'id_localidad'  => $this->request->getPost('id_localidad') ?: null,
            'telefono'      => $this->request->getPost('telefono'),
            'whatsapp'      => $this->request->getPost('whatsapp'),
            'email'         => $this->request->getPost('email'),
        ]);

        return redirect()->to('/proveedores')->with('success', 'Proveedor registrado correctamente.');
    }

    public function editar($id)
    {
        $proveedor = $this->proveedorModel->getDetalle($id);
        if (!$proveedor) return redirect()->to('/proveedores')->with('error', 'Proveedor no encontrado.');

        $localidades = $proveedor['id_provincia']
            ? $this->localidadModel->getPorProvincia($proveedor['id_provincia'])
            : [];

        return view('proveedores/form', [
            'titulo'      => 'Editar Proveedor',
            'proveedor'   => $proveedor,
            'provincias'  => $this->provinciaModel->orderBy('provincia', 'ASC')->findAll(),
            'localidades' => $localidades,
        ]);
    }

    public function actualizar($id)
    {
        $rules = [
            'razon_social'  => 'required|min_length[2]|max_length[200]',
            'cuit_cuil_dni' => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            $proveedor   = $this->proveedorModel->getDetalle($id);
            $localidades = $this->request->getPost('id_provincia')
                ? $this->localidadModel->getPorProvincia($this->request->getPost('id_provincia'))
                : [];
            return view('proveedores/form', [
                'titulo'      => 'Editar Proveedor',
                'proveedor'   => $proveedor,
                'provincias'  => $this->provinciaModel->orderBy('provincia', 'ASC')->findAll(),
                'localidades' => $localidades,
                'validation'  => $this->validator,
            ]);
        }

        $this->proveedorModel->update($id, [
            'razon_social'  => $this->request->getPost('razon_social'),
            'cuit_cuil_dni' => $this->request->getPost('cuit_cuil_dni'),
            'direccion'     => $this->request->getPost('direccion'),
            'id_localidad'  => $this->request->getPost('id_localidad') ?: null,
            'telefono'      => $this->request->getPost('telefono'),
            'whatsapp'      => $this->request->getPost('whatsapp'),
            'email'         => $this->request->getPost('email'),
        ]);

        return redirect()->to('/proveedores')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->proveedorModel->delete($id);
        return redirect()->to('/proveedores')->with('success', 'Proveedor eliminado.');
    }

    // AJAX: retorna localidades por provincia
    public function localidadesPorProvincia($id_provincia)
    {
        $localidades = $this->localidadModel->getPorProvincia($id_provincia);
        return $this->response->setJSON($localidades);
    }
}
