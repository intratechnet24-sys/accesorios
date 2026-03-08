<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentaUsuarioModel extends Model
{
    protected $table         = 'cuenta_usuarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_cuenta', 'id_usuario', 'rol'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getUsuariosDeCuenta(int $id_cuenta)
    {
        return $this->db->table('cuenta_usuarios cu')
            ->select('cu.id, cu.rol, cu.created_at, u.id_usuario, u.nombre, u.apellido, u.email, u.username, u.foto')
            ->join('usuarios u', 'u.id_usuario = cu.id_usuario')
            ->where('cu.id_cuenta', $id_cuenta)
            ->orderBy('cu.rol', 'ASC')
            ->orderBy('u.nombre', 'ASC')
            ->get()->getResultArray();
    }

    public function getRolEnCuenta(int $id_usuario, int $id_cuenta): ?string
    {
        $row = $this->where('id_usuario', $id_usuario)
                    ->where('id_cuenta', $id_cuenta)
                    ->first();
        return $row ? $row['rol'] : null;
    }

    public function esMiembro(int $id_usuario, int $id_cuenta): bool
    {
        return $this->where('id_usuario', $id_usuario)->where('id_cuenta', $id_cuenta)->countAllResults() > 0;
    }
}
