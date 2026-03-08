<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificadoDocumentoModel extends Model
{
    protected $table            = 'certificado_documentos';
    protected $primaryKey       = 'id_documento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_certificado', 'nombre_original', 'nombre_archivo', 'tamanio'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    public function getPorCertificado($id_certificado)
    {
        return $this->where('id_certificado', $id_certificado)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function getConteosPorCertificados()
    {
        $rows = $this->db->table('certificado_documentos')
            ->select('id_certificado, COUNT(*) as total')
            ->groupBy('id_certificado')
            ->get()->getResultArray();

        $conteos = [];
        foreach ($rows as $r) {
            $conteos[$r['id_certificado']] = (int)$r['total'];
        }
        return $conteos;
    }
}
