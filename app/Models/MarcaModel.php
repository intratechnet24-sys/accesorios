<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcaModel extends Model
{
    protected $table            = 'marcas';
    protected $primaryKey       = 'id_marca';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['marca'];
    protected $useTimestamps    = false;

    public function getListado()
    {
        return $this->orderBy('marca', 'ASC')->findAll();
    }
}
