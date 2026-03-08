<?php

namespace App\Models;

use CodeIgniter\Model;

class LocalidadModel extends Model
{
    protected $table            = 'localidades';
    protected $primaryKey       = 'id_localidad';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_provincia', 'localidad'];
    protected $useTimestamps    = false;

    public function getPorProvincia($id_provincia)
    {
        return $this->where('id_provincia', $id_provincia)->orderBy('localidad', 'ASC')->findAll();
    }

    public function getConProvincia()
    {
        return $this->db->table('localidades l')
            ->select('l.id_localidad, l.localidad, p.provincia, p.id_provincia')
            ->join('provincias p', 'p.id_provincia = l.id_provincia')
            ->orderBy('p.provincia', 'ASC')
            ->orderBy('l.localidad', 'ASC')
            ->get()->getResultArray();
    }
}
