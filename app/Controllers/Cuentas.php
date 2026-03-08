<?php

namespace App\Controllers;

use App\Models\CuentaModel;
use App\Models\CuentaUsuarioModel;
use App\Models\InvitacionModel;
use App\Models\PlanModel;

class Cuentas extends BaseController
{
    protected $cuentaModel;
    protected $cuModel;
    protected $invModel;
    protected $planModel;

    public function __construct()
    {
        $this->cuentaModel = new CuentaModel();
        $this->cuModel     = new CuentaUsuarioModel();
        $this->invModel    = new InvitacionModel();
        $this->planModel   = new PlanModel();
    }

    public function index()
    {
        $id_usuario = session('id_usuario');
        return view('cuentas/index', [
            'titulo'  => 'Mis Cuentas',
            'cuentas' => $this->cuentaModel->getCuentasDeUsuario($id_usuario),
        ]);
    }

    public function nueva()
    {
        return view('cuentas/form', [
            'titulo' => 'Nueva Cuenta',
            'cuenta' => null,
            'planes' => $this->planModel->getListado(),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'nombre_cuenta' => 'required|min_length[2]|max_length[200]',
            'id_plan'       => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return view('cuentas/form', [
                'titulo'     => 'Nueva Cuenta',
                'cuenta'     => null,
                'planes'     => $this->planModel->getListado(),
                'validation' => $this->validator,
            ]);
        }

        $id_usuario = session('id_usuario');

        $this->cuentaModel->save([
            'nombre_cuenta'      => $this->request->getPost('nombre_cuenta'),
            'id_plan'            => $this->request->getPost('id_plan'),
            'id_usuario_creador' => $id_usuario,
        ]);
        $id_cuenta = $this->cuentaModel->getInsertID();

        $this->cuModel->save([
            'id_cuenta'  => $id_cuenta,
            'id_usuario' => $id_usuario,
            'rol'        => 'administrador',
        ]);

        return redirect()->to('/cuentas')->with('success', 'Cuenta creada correctamente.');
    }

    public function activar($id_cuenta)
    {
        $id_usuario = session('id_usuario');

        if (!$this->cuModel->esMiembro($id_usuario, $id_cuenta)) {
            return redirect()->to('/cuentas')->with('error', 'No tenés acceso a esa cuenta.');
        }

        $cuenta = $this->cuentaModel->getConPlan($id_cuenta);
        $rol    = $this->cuModel->getRolEnCuenta($id_usuario, $id_cuenta);

        session()->set([
            'id_cuenta'     => $cuenta['id_cuenta'],
            'nombre_cuenta' => $cuenta['nombre_cuenta'],
            'rol_activo'    => $rol,
        ]);

        return redirect()->to('/')->with('success', 'Cuenta activa: ' . $cuenta['nombre_cuenta']);
    }

    public function usuarios($id_cuenta)
    {
        $id_usuario = session('id_usuario');

        if (!$this->cuModel->esMiembro($id_usuario, $id_cuenta)) {
            return redirect()->to('/cuentas')->with('error', 'Sin acceso.');
        }

        $cuenta = $this->cuentaModel->getConPlan($id_cuenta);
        $rol    = $this->cuModel->getRolEnCuenta($id_usuario, $id_cuenta);

        return view('cuentas/usuarios', [
            'titulo'      => 'Usuarios — ' . $cuenta['nombre_cuenta'],
            'cuenta'      => $cuenta,
            'usuarios'    => $this->cuModel->getUsuariosDeCuenta($id_cuenta),
            'invitaciones'=> $this->invModel->getPendientesDeCuenta($id_cuenta),
            'es_admin'    => $rol === 'administrador',
            'mi_id'       => $id_usuario,
        ]);
    }

    public function invitar($id_cuenta)
    {
        $id_usuario = session('id_usuario');
        $rol_actual = $this->cuModel->getRolEnCuenta($id_usuario, $id_cuenta);

        if ($rol_actual !== 'administrador') {
            return redirect()->to('/cuentas/usuarios/' . $id_cuenta)->with('error', 'Solo los administradores pueden enviar invitaciones.');
        }

        $rules = [
            'nombre'   => 'required|min_length[2]',
            'apellido' => 'required|min_length[2]',
            'email'    => 'required|valid_email',
            'rol'      => 'required|in_list[administrador,colaborador]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/cuentas/usuarios/' . $id_cuenta)->with('error', $this->validator->listErrors());
        }

        $token = bin2hex(random_bytes(32));

        $this->invModel->save([
            'id_cuenta' => $id_cuenta,
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'email'     => $this->request->getPost('email'),
            'rol'       => $this->request->getPost('rol'),
            'token'     => $token,
            'estado'    => 'pendiente',
        ]);

        $link = base_url('auth/invitacion/' . $token);

        return redirect()->to('/cuentas/usuarios/' . $id_cuenta)
            ->with('success', 'Invitación creada. Enlace de registro: ' . $link);
    }

    public function cambiarRol($id)
    {
        $id_usuario = session('id_usuario');

        // El registro cu tiene id_cuenta implícito — necesitamos validar
        $cu = (new CuentaUsuarioModel())->find($id);
        if (!$cu) {
            return redirect()->to('/cuentas')->with('error', 'Registro no encontrado.');
        }

        $rol_actual = $this->cuModel->getRolEnCuenta($id_usuario, $cu['id_cuenta']);
        if ($rol_actual !== 'administrador') {
            return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('error', 'Sin permisos.');
        }

        // No se puede cambiar el propio rol
        if ($cu['id_usuario'] == $id_usuario) {
            return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('error', 'No podés cambiar tu propio rol.');
        }

        $nuevo_rol = $this->request->getPost('rol');
        if (!in_array($nuevo_rol, ['administrador', 'colaborador'])) {
            return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('error', 'Rol inválido.');
        }

        $this->cuModel->update($id, ['rol' => $nuevo_rol]);

        return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('success', 'Rol actualizado.');
    }

    public function quitarUsuario($id)
    {
        $id_usuario = session('id_usuario');
        $cu         = (new CuentaUsuarioModel())->find($id);

        if (!$cu) {
            return redirect()->to('/cuentas')->with('error', 'Registro no encontrado.');
        }

        $rol_actual = $this->cuModel->getRolEnCuenta($id_usuario, $cu['id_cuenta']);
        if ($rol_actual !== 'administrador') {
            return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('error', 'Sin permisos.');
        }

        if ($cu['id_usuario'] == $id_usuario) {
            return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('error', 'No podés quitarte a ti mismo.');
        }

        $this->cuModel->delete($id);
        return redirect()->to('/cuentas/usuarios/' . $cu['id_cuenta'])->with('success', 'Usuario removido de la cuenta.');
    }
}
