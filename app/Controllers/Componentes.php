<?php

namespace App\Controllers;

use App\Models\ComponenteModel;
use App\Models\EquipoModel;
use App\Models\MarcaModel;
use App\Models\ProveedorModel;

class Componentes extends BaseController
{
    protected $componenteModel;
    protected $equipoModel;
    protected $marcaModel;
    protected $proveedorModel;

    public function __construct()
    {
        $this->componenteModel = new ComponenteModel();
        $this->equipoModel     = new EquipoModel();
        $this->marcaModel      = new MarcaModel();
        $this->proveedorModel  = new ProveedorModel();
    }

    public function index()
    {
        $data = [
            'titulo'      => 'Accesorios de Vehículos',
            'componentes' => $this->componenteModel->getComponentesConEquipo()
        ];
        return view('componentes/index', $data);
    }

    public function nuevo($id_equipo = null)
    {
        return view('componentes/form', [
            'titulo'     => 'Nuevo Accesorio',
            'componente' => null,
            'equipos'    => $this->equipoModel->getEquiposActivos(),
            'marcas'     => $this->marcaModel->getListado(),
            'proveedores'=> $this->proveedorModel->getListado(),
            'id_equipo'  => $id_equipo
        ]);
    }

    public function guardar()
    {
        $rules = [
            'id_equipo'         => 'required|integer',
            'tipo'              => 'required|in_list[baterias,cubiertas]',
            'seccion'           => 'required|in_list[motor,tren rodante,otros]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return view('componentes/form', [
                'titulo'     => 'Nuevo Accesorio',
                'componente' => null,
                'equipos'    => $this->equipoModel->getEquiposActivos(),
                'marcas'     => $this->marcaModel->getListado(),
                'proveedores'=> $this->proveedorModel->getListado(),
                'id_equipo'  => $this->request->getPost('id_equipo'),
                'validation' => $this->validator
            ]);
        }

        $this->componenteModel->save([
            'id_equipo'           => $this->request->getPost('id_equipo'),
            'tipo'                => $this->request->getPost('tipo'),
            'seccion'             => $this->request->getPost('seccion'),
            'fecha_vencimiento'   => $this->request->getPost('fecha_vencimiento'),
            'codigo_trazabilidad' => $this->request->getPost('codigo_trazabilidad'),
            'lugar'               => $this->request->getPost('lugar'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'id_marca'            => $this->request->getPost('id_marca') ?: null,
            'id_proveedor'        => $this->request->getPost('id_proveedor') ?: null,
        ]);

        return redirect()->to('/componentes')->with('success', 'Accesorio registrado correctamente.');
    }

    public function editar($id)
    {
        $componente = $this->componenteModel->find($id);
        if (!$componente) return redirect()->to('/componentes')->with('error', 'Accesorio no encontrado.');

        return view('componentes/form', [
            'titulo'     => 'Editar Accesorio',
            'componente' => $componente,
            'equipos'    => $this->equipoModel->getEquiposActivos(),
            'marcas'     => $this->marcaModel->getListado(),
            'proveedores'=> $this->proveedorModel->getListado(),
            'id_equipo'  => $componente['id_equipo']
        ]);
    }

    public function actualizar($id)
    {
        $rules = [
            'id_equipo'         => 'required|integer',
            'tipo'              => 'required|in_list[baterias,cubiertas]',
            'seccion'           => 'required|in_list[motor,tren rodante,otros]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            $componente = $this->componenteModel->find($id);
            return view('componentes/form', [
                'titulo'     => 'Editar Accesorio',
                'componente' => $componente,
                'equipos'    => $this->equipoModel->getEquiposActivos(),
                'marcas'     => $this->marcaModel->getListado(),
                'proveedores'=> $this->proveedorModel->getListado(),
                'id_equipo'  => $this->request->getPost('id_equipo'),
                'validation' => $this->validator
            ]);
        }

        $this->componenteModel->update($id, [
            'id_equipo'           => $this->request->getPost('id_equipo'),
            'tipo'                => $this->request->getPost('tipo'),
            'seccion'             => $this->request->getPost('seccion'),
            'fecha_vencimiento'   => $this->request->getPost('fecha_vencimiento'),
            'codigo_trazabilidad' => $this->request->getPost('codigo_trazabilidad'),
            'lugar'               => $this->request->getPost('lugar'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'id_marca'            => $this->request->getPost('id_marca') ?: null,
            'id_proveedor'        => $this->request->getPost('id_proveedor') ?: null,
        ]);

        return redirect()->to('/componentes')->with('success', 'Accesorio actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->componenteModel->delete($id);
        return redirect()->to('/componentes')->with('success', 'Accesorio eliminado.');
    }
}
