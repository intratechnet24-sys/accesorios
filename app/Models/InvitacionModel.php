<?php

namespace App\Models;

use CodeIgniter\Model;

class InvitacionModel extends Model
{
    protected $table         = 'invitaciones';
    protected $primaryKey    = 'id_invitacion';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_cuenta', 'nombre', 'apellido', 'email', 'rol', 'token', 'estado'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function findByToken(string $token)
    {
        return $this->db->table('invitaciones i')
            ->select('i.*, c.nombre_cuenta')
            ->join('cuentas c', 'c.id_cuenta = i.id_cuenta', 'left')
            ->where('i.token', $token)
            ->where('i.estado', 'pendiente')
            ->get()->getRowArray();
    }

    public function getPendientesDeCuenta(int $id_cuenta)
    {
        return $this->where('id_cuenta', $id_cuenta)
                    ->where('estado', 'pendiente')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
