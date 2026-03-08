<?php

namespace App\Controllers;

use App\Models\PlanModel;

class Planes extends BaseController
{
    protected $planModel;

    public function __construct()
    {
        $this->planModel = new PlanModel();
    }

    public function index()
    {
        return view('planes/index', [
            'titulo' => 'Planes de Suscripción',
            'planes' => $this->planModel->getListado(),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'monto'  => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/planes')->with('error', $this->validator->listErrors());
        }

        $this->planModel->save([
            'nombre'          => $this->request->getPost('nombre'),
            'monto'           => $this->request->getPost('monto'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'funcionalidades' => $this->request->getPost('funcionalidades'),
        ]);

        return redirect()->to('/planes')->with('success', 'Plan creado.');
    }

    public function actualizar($id)
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'monto'  => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/planes')->with('error', $this->validator->listErrors());
        }

        $this->planModel->update($id, [
            'nombre'          => $this->request->getPost('nombre'),
            'monto'           => $this->request->getPost('monto'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'funcionalidades' => $this->request->getPost('funcionalidades'),
        ]);

        return redirect()->to('/planes')->with('success', 'Plan actualizado.');
    }

    public function eliminar($id)
    {
        $this->planModel->delete($id);
        return redirect()->to('/planes')->with('success', 'Plan eliminado.');
    }
}
