<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table            = 'proveedores';
    protected $primaryKey       = 'id_proveedor';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['cuit_cuil_dni', 'razon_social', 'direccion', 'id_localidad', 'telefono', 'whatsapp', 'email'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    public function getListado()
    {
        return $this->db->table('proveedores p')
            ->select('p.*, l.localidad, pr.provincia, pr.id_provincia')
            ->join('localidades l',  'l.id_localidad = p.id_localidad', 'left')
            ->join('provincias pr',  'pr.id_provincia = l.id_provincia', 'left')
            ->orderBy('p.razon_social', 'ASC')
            ->get()->getResultArray();
    }

    public function getDetalle($id)
    {
        return $this->db->table('proveedores p')
            ->select('p.*, l.localidad, pr.provincia, pr.id_provincia')
            ->join('localidades l',  'l.id_localidad = p.id_localidad', 'left')
            ->join('provincias pr',  'pr.id_provincia = l.id_provincia', 'left')
            ->where('p.id_proveedor', $id)
            ->get()->getRowArray();
    }
}
