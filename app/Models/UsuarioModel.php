<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id_usuario';
    protected $returnType    = 'array';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'username', 'password', 'foto'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    protected $validationRules = [
        'email'    => 'required|valid_email',
        'username' => 'required|min_length[3]',
        'password' => 'required|min_length[6]',
    ];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }
}
