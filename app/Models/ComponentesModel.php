<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponentesModel extends Model
{
    protected $table      = 'componentes';
    protected $primaryKey = 'id_componente';
    protected $allowedFields = [
        'id_equipo', 'tipo', 'seccion', 'fecha_alta', 'fecha_vencimiento'
    ];
    protected $useTimestamps = false;

    public function getByEquipo(int $idEquipo)
    {
        return $this->where('id_equipo', $idEquipo)->findAll();
    }
}
