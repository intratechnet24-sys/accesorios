<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinciaModel extends Model
{
    protected $table            = 'provincias';
    protected $primaryKey       = 'id_provincia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pais', 'provincia'];
    protected $useTimestamps    = false;

    public function getPorPais($id_pais)
    {
        return $this->where('id_pais', $id_pais)->orderBy('provincia', 'ASC')->findAll();
    }
}
