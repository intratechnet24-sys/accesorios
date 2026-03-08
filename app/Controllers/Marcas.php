<?php

namespace App\Controllers;

use App\Models\MarcaModel;

class Marcas extends BaseController
{
    protected $marcaModel;

    public function __construct()
    {
        $this->marcaModel = new MarcaModel();
    }

    public function index()
    {
        return view('marcas/index', [
            'titulo'  => 'Marcas',
            'marcas'  => $this->marcaModel->getListado(),
        ]);
    }

    public function guardar()
    {
        $marca = trim($this->request->getPost('marca'));
        if (!$marca) {
            return redirect()->to('/marcas')->with('error', 'El nombre de la marca es requerido.');
        }
        $this->marcaModel->save(['marca' => $marca]);
        return redirect()->to('/marcas')->with('success', 'Marca registrada.');
    }

    public function actualizar($id)
    {
        $marca = trim($this->request->getPost('marca'));
        if (!$marca) {
            return redirect()->to('/marcas')->with('error', 'El nombre de la marca es requerido.');
        }
        $this->marcaModel->update($id, ['marca' => $marca]);
        return redirect()->to('/marcas')->with('success', 'Marca actualizada.');
    }

    public function eliminar($id)
    {
        $this->marcaModel->delete($id);
        return redirect()->to('/marcas')->with('success', 'Marca eliminada.');
    }
}
