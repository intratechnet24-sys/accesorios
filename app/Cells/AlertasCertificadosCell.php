<?php

namespace App\Cells;

use App\Models\CertificadoModel;
use CodeIgniter\View\Cells\Cell;

class AlertasCertificadosCell extends Cell
{
    public function render(): string
    {
        $model = new CertificadoModel();

        $hoy = date('Y-m-d');

        // Certificados vencidos
        $vencidos = $model->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, e.codigo, e.descripcion')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('cert.fecha_vencimiento <', $hoy)
            ->orderBy('cert.fecha_vencimiento', 'ASC')
            ->get()->getResultArray();

        // Certificados por vencer en 30 dias
        $proximos = $model->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, e.codigo, e.descripcion')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('cert.fecha_vencimiento >=', $hoy)
            ->where('cert.fecha_vencimiento <=', date('Y-m-d', strtotime('+30 days')))
            ->orderBy('cert.fecha_vencimiento', 'ASC')
            ->get()->getResultArray();

        return view('cells/alertas_certificados', [
            'vencidos' => $vencidos,
            'proximos' => $proximos,
        ]);
    }
}
