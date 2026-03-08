<?php

namespace App\Models;

use CodeIgniter\Model;

class EquiposModel extends Model
{
    protected $table      = 'equipos';
    protected $primaryKey = 'id_equipo';
    protected $allowedFields = [
        'codigo', 'descripcion', 'marca', 'modelo', 'estado', 'fecha_alta'
    ];
    protected $useTimestamps = false;

    public function getActivos()
    {
        return $this->where('estado', 1)->findAll();
    }

    public function toggleEstado(int $id, int $estadoActual)
    {
        $nuevoEstado = $estadoActual == 1 ? 0 : 1;
        return $this->update($id, ['estado' => $nuevoEstado]);
    }
}
