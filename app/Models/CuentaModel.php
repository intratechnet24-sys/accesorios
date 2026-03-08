<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model
{
    protected $table         = 'cuentas';
    protected $primaryKey    = 'id_cuenta';
    protected $returnType    = 'array';
    protected $allowedFields = ['nombre_cuenta', 'id_plan', 'id_usuario_creador'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getCuentasDeUsuario(int $id_usuario)
    {
        return $this->db->table('cuentas c')
            ->select('c.*, p.nombre as nombre_plan, p.monto, cu.rol')
            ->join('planes p',          'p.id_plan = c.id_plan', 'left')
            ->join('cuenta_usuarios cu', 'cu.id_cuenta = c.id_cuenta AND cu.id_usuario = ' . (int)$id_usuario, 'inner')
            ->orderBy('c.nombre_cuenta', 'ASC')
            ->get()->getResultArray();
    }

    public function getConPlan(int $id_cuenta)
    {
        return $this->db->table('cuentas c')
            ->select('c.*, p.nombre as nombre_plan, p.monto, p.funcionalidades')
            ->join('planes p', 'p.id_plan = c.id_plan', 'left')
            ->where('c.id_cuenta', $id_cuenta)
            ->get()->getRowArray();
    }
}
