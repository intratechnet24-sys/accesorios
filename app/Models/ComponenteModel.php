<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponenteModel extends Model
{
    protected $table            = 'componentes';
    protected $primaryKey       = 'id_componente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'id_equipo', 'tipo', 'seccion', 'fecha_vencimiento',
        'codigo_trazabilidad', 'lugar', 'id_marca', 'id_proveedor',
        'descripcion'
    ];

    protected $useTimestamps = false;

    public function getComponentesPorEquipo($id_equipo)
    {
        return $this->where('id_equipo', $id_equipo)->findAll();
    }

    public function getComponentesConEquipo()
    {
        return $this->db->table('componentes c')
            ->select('c.*, e.codigo, e.descripcion, e.marca, e.modelo')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->orderBy('c.fecha_vencimiento', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getVencimientosProximos($dias = 30)
    {
        return $this->db->table('componentes c')
            ->select('c.*, e.codigo, e.descripcion, e.marca, e.modelo')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('c.fecha_vencimiento <=', date('Y-m-d', strtotime("+{$dias} days")))
            ->where('c.fecha_vencimiento >=', date('Y-m-d'))
            ->orderBy('c.fecha_vencimiento', 'ASC')
            ->get()
            ->getResultArray();
    }
}
