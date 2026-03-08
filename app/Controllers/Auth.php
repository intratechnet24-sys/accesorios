<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CuentaModel;
use App\Models\CuentaUsuarioModel;
use App\Models\InvitacionModel;
use App\Models\PlanModel;

class Auth extends BaseController
{
    // Credenciales del super administrador (hardcodeadas)
    const SUPERADMIN_EMAIL    = 'admin';
    const SUPERADMIN_PASSWORD = 'admin';

    protected $usuarioModel;
    protected $cuentaModel;
    protected $cuModel;
    protected $invModel;
    protected $planModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->cuentaModel  = new CuentaModel();
        $this->cuModel      = new CuentaUsuarioModel();
        $this->invModel     = new InvitacionModel();
        $this->planModel    = new PlanModel();
    }

    public function login()
    {
        if (session()->get('autenticado')) {
            return redirect()->to('/');
        }
        return view('auth/login', ['titulo' => 'Iniciar Sesión']);
    }

    public function procesarLogin()
    {
        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return view('auth/login', [
                'titulo' => 'Iniciar Sesión',
                'error'  => 'Completá email y contraseña.',
            ]);
        }

        // ── Super Administrador (hardcodeado) ──────────────────
        if ($email === self::SUPERADMIN_EMAIL && $password === self::SUPERADMIN_PASSWORD) {
            session()->set([
                'autenticado'   => true,
                'is_superadmin' => true,
                'id_usuario'    => null,
                'nombre'        => 'Super',
                'apellido'      => 'Admin',
                'email'         => 'admin',
                'foto'          => null,
                'id_cuenta'     => null,
                'nombre_cuenta' => 'Sistema',
                'rol_activo'    => 'administrador',
            ]);
            return redirect()->to('/')->with('success', '¡Bienvenido, Super Admin!');
        }

        // ── Usuario regular ────────────────────────────────────
        $usuario = $this->usuarioModel->findByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return view('auth/login', [
                'titulo' => 'Iniciar Sesión',
                'error'  => 'Email o contraseña incorrectos.',
            ]);
        }

        $cuentas      = $this->cuentaModel->getCuentasDeUsuario($usuario['id_usuario']);
        $cuentaActiva = $cuentas[0] ?? null;

        $this->_iniciarSesion($usuario, $cuentaActiva);

        return redirect()->to('/')->with('success', '¡Bienvenido, ' . $usuario['nombre'] . '!');
    }

    public function registro()
    {
        if (session()->get('autenticado')) {
            return redirect()->to('/');
        }
        return view('auth/registro', [
            'titulo' => 'Crear Cuenta',
            'planes' => $this->planModel->getListado(),
        ]);
    }

    public function procesarRegistro()
    {
        $rules = [
            'nombre'        => 'required|min_length[2]|max_length[100]',
            'apellido'      => 'required|min_length[2]|max_length[100]',
            'email'         => 'required|valid_email|is_unique[usuarios.email]',
            'password'      => 'required|min_length[6]',
            'password2'     => 'required|matches[password]',
            'nombre_cuenta' => 'required|min_length[2]|max_length[200]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/registro', [
                'titulo'     => 'Crear Cuenta',
                'planes'     => $this->planModel->getListado(),
                'validation' => $this->validator,
            ]);
        }

        $email   = $this->request->getPost('email');
        $id_plan = $this->request->getPost('id_plan') ?: 1;

        // Crear usuario (username = parte del email antes del @)
        $username = explode('@', $email)[0] . '_' . uniqid();

        $this->usuarioModel->save([
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);
        $id_usuario = $this->usuarioModel->getInsertID();

        // Crear cuenta
        $this->cuentaModel->save([
            'nombre_cuenta'      => $this->request->getPost('nombre_cuenta'),
            'id_plan'            => $id_plan,
            'id_usuario_creador' => $id_usuario,
        ]);
        $id_cuenta = $this->cuentaModel->getInsertID();

        // Asignar como administrador de la cuenta
        $this->cuModel->save([
            'id_cuenta'  => $id_cuenta,
            'id_usuario' => $id_usuario,
            'rol'        => 'administrador',
        ]);

        $usuario      = $this->usuarioModel->find($id_usuario);
        $cuentaActiva = $this->cuentaModel->getConPlan($id_cuenta);
        $cuentaActiva['rol'] = 'administrador';

        $this->_iniciarSesion($usuario, $cuentaActiva);

        return redirect()->to('/')->with('success', '¡Cuenta creada! Bienvenido, ' . $usuario['nombre'] . '.');
    }

    public function invitacion($token)
    {
        $inv = $this->invModel->findByToken($token);

        if (!$inv) {
            return view('auth/login', [
                'titulo' => 'Iniciar Sesión',
                'error'  => 'La invitación no existe, ya fue utilizada o expiró.',
            ]);
        }

        return view('auth/invitacion', [
            'titulo'     => 'Aceptar Invitación',
            'invitacion' => $inv,
        ]);
    }

    public function completarRegistro()
    {
        $token = $this->request->getPost('token');
        $inv   = $this->invModel->findByToken($token);

        if (!$inv) {
            return redirect()->to('/auth/login')->with('error', 'Invitación inválida o expirada.');
        }

        $rules = [
            'password'  => 'required|min_length[6]',
            'password2' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/invitacion', [
                'titulo'     => 'Aceptar Invitación',
                'invitacion' => $inv,
                'validation' => $this->validator,
            ]);
        }

        $existente = $this->usuarioModel->findByEmail($inv['email']);

        if ($existente) {
            $id_usuario = $existente['id_usuario'];
        } else {
            $username = explode('@', $inv['email'])[0] . '_' . uniqid();
            $this->usuarioModel->save([
                'nombre'   => $inv['nombre'],
                'apellido' => $inv['apellido'],
                'email'    => $inv['email'],
                'username' => $username,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
            $id_usuario = $this->usuarioModel->getInsertID();
        }

        if (!$this->cuModel->esMiembro($id_usuario, $inv['id_cuenta'])) {
            $this->cuModel->save([
                'id_cuenta'  => $inv['id_cuenta'],
                'id_usuario' => $id_usuario,
                'rol'        => $inv['rol'],
            ]);
        }

        $this->invModel->update($inv['id_invitacion'], ['estado' => 'aceptada']);

        $usuario      = $this->usuarioModel->find($id_usuario);
        $cuentas      = $this->cuentaModel->getCuentasDeUsuario($id_usuario);
        $cuentaActiva = $cuentas[0] ?? null;

        $this->_iniciarSesion($usuario, $cuentaActiva);

        return redirect()->to('/')->with('success', '¡Bienvenido a ' . $inv['nombre_cuenta'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sesión cerrada correctamente.');
    }

    private function _iniciarSesion(array $usuario, ?array $cuentaActiva)
    {
        session()->set([
            'autenticado'   => true,
            'is_superadmin' => false,
            'id_usuario'    => $usuario['id_usuario'],
            'nombre'        => $usuario['nombre'],
            'apellido'      => $usuario['apellido'],
            'email'         => $usuario['email'],
            'foto'          => $usuario['foto'],
            'id_cuenta'     => $cuentaActiva['id_cuenta']     ?? null,
            'nombre_cuenta' => $cuentaActiva['nombre_cuenta'] ?? 'Sin cuenta',
            'rol_activo'    => $cuentaActiva['rol']           ?? null,
        ]);
    }
}
