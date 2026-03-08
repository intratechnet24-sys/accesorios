<?php

namespace App\Models;

use CodeIgniter\Model;

class PaisModel extends Model
{
    protected $table            = 'paises';
    protected $primaryKey       = 'id_pais';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['pais'];
    protected $useTimestamps    = false;
}
