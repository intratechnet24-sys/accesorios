<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table            = 'equipos';
    protected $primaryKey       = 'id_equipo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'codigo', 'descripcion', 'marca', 'modelo', 'estado',
        'dominio', 'numero_serie', 'fecha_garantia', 'descripcion_tecnica', 'fecha_ingreso'
    ];

    protected $useTimestamps = false;

    public function getEquiposActivos()
    {
        return $this->where('estado', 1)->findAll();
    }
}
