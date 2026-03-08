<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table         = 'planes';
    protected $primaryKey    = 'id_plan';
    protected $returnType    = 'array';
    protected $allowedFields = ['nombre', 'monto', 'descripcion', 'funcionalidades'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getListado()
    {
        return $this->orderBy('monto', 'ASC')->findAll();
    }
}
