<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificadoModel extends Model
{
    protected $table            = 'certificados';
    protected $primaryKey       = 'id_certificado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'id_componente',
        'numero_certificado',
        'entidad_certificadora',
        'fecha_emision',
        'fecha_vencimiento',
        'observaciones',
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = '';

    public function getCertificadosPorComponente($id_componente)
    {
        return $this->where('id_componente', $id_componente)
                    ->orderBy('fecha_vencimiento', 'ASC')
                    ->findAll();
    }

    public function getCertificadosConDetalle()
    {
        return $this->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, c.fecha_vencimiento AS venc_componente, e.id_equipo, e.codigo, e.descripcion, e.marca, e.modelo')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->orderBy('cert.fecha_vencimiento', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getCertificadoConDetalle($id_certificado)
    {
        return $this->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, e.codigo, e.descripcion, e.marca, e.modelo, e.id_equipo')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('cert.id_certificado', $id_certificado)
            ->get()
            ->getRowArray();
    }

    public function getCertificadosVencimientosProximos($dias = 30)
    {
        return $this->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, e.codigo, e.descripcion, e.marca, e.modelo')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('cert.fecha_vencimiento <=', date('Y-m-d', strtotime("+{$dias} days")))
            ->where('cert.fecha_vencimiento >=', date('Y-m-d'))
            ->orderBy('cert.fecha_vencimiento', 'ASC')
            ->get()
            ->getResultArray();
    }
}
