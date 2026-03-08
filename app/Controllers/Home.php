<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use App\Models\ComponenteModel;
use App\Models\CertificadoModel;

class Home extends BaseController
{
    public function index(): string
    {
        $equipoModel      = new EquipoModel();
        $componenteModel  = new ComponenteModel();
        $certificadoModel = new CertificadoModel();

        $hoy = date('Y-m-d');

        $cert_vencidos = $certificadoModel->db->table('certificados cert')
            ->select('cert.*, c.tipo, c.seccion, e.codigo, e.descripcion')
            ->join('componentes c', 'c.id_componente = cert.id_componente')
            ->join('equipos e', 'e.id_equipo = c.id_equipo')
            ->where('cert.fecha_vencimiento <', $hoy)
            ->orderBy('cert.fecha_vencimiento', 'ASC')
            ->get()->getResultArray();

        $cert_proximos = $certificadoModel->getCertificadosVencimientosProximos(30);

        $data = [
            'titulo'           => 'Dashboard',
            'total_equipos'    => $equipoModel->where('estado', 1)->countAllResults(),
            'total_accesorios' => $componenteModel->countAllResults(),
            'total_certificados' => $certificadoModel->countAllResults(),
            'vencimientos'     => $componenteModel->getVencimientosProximos(30),
            'ultimos_equipos'  => $equipoModel->orderBy('fecha_alta', 'DESC')->limit(5)->findAll(),
            'cert_vencidos'    => $cert_vencidos,
            'cert_proximos'    => $cert_proximos,
        ];

        return view('home/dashboard', $data);
    }
}
