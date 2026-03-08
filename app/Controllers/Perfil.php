<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CuentaModel;

class Perfil extends BaseController
{
    protected $usuarioModel;
    protected $cuentaModel;

    const FOTO_PATH = FCPATH . 'uploads/usuarios/';

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->cuentaModel  = new CuentaModel();
    }

    public function index()
    {
        $id_usuario = session('id_usuario');
        $usuario    = $this->usuarioModel->find($id_usuario);
        $cuentas    = $this->cuentaModel->getCuentasDeUsuario($id_usuario);

        return view('perfil/index', [
            'titulo'   => 'Mi Perfil',
            'usuario'  => $usuario,
            'cuentas'  => $cuentas,
        ]);
    }

    public function actualizar()
    {
        $id_usuario = session('id_usuario');

        $rules = [
            'nombre'   => 'required|min_length[2]|max_length[100]',
            'apellido' => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[usuarios.email,id_usuario,' . $id_usuario . ']',
        ];

        if (!$this->validate($rules)) {
            $usuario = $this->usuarioModel->find($id_usuario);
            $cuentas = $this->cuentaModel->getCuentasDeUsuario($id_usuario);
            return view('perfil/index', [
                'titulo'     => 'Mi Perfil',
                'usuario'    => $usuario,
                'cuentas'    => $cuentas,
                'validation' => $this->validator,
            ]);
        }

        $this->usuarioModel->update($id_usuario, [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $this->request->getPost('email'),
        ]);

        // Actualizar sesión
        session()->set([
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $this->request->getPost('email'),
        ]);

        return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function subirFoto()
    {
        $id_usuario = session('id_usuario');
        $foto       = $this->request->getFile('foto');

        if (!$foto || !$foto->isValid()) {
            return redirect()->to('/perfil')->with('error', 'Archivo inválido.');
        }

        $mime = $foto->getClientMimeType();
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return redirect()->to('/perfil')->with('error', 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP).');
        }

        if (!is_dir(self::FOTO_PATH)) {
            mkdir(self::FOTO_PATH, 0755, true);
        }

        // Eliminar foto anterior
        $usuario    = $this->usuarioModel->find($id_usuario);
        $fotoActual = self::FOTO_PATH . ($usuario['foto'] ?? '');
        if ($usuario['foto'] && file_exists($fotoActual)) {
            unlink($fotoActual);
        }

        $nombreFoto = 'usuario_' . $id_usuario . '_' . time() . '.' . $foto->getClientExtension();
        $foto->move(self::FOTO_PATH, $nombreFoto);

        $this->usuarioModel->update($id_usuario, ['foto' => $nombreFoto]);
        session()->set('foto', $nombreFoto);

        return redirect()->to('/perfil')->with('success', 'Foto de perfil actualizada.');
    }

    public function cambiarPassword()
    {
        $id_usuario = session('id_usuario');
        $usuario    = $this->usuarioModel->find($id_usuario);

        $actual = $this->request->getPost('password_actual');
        $nueva  = $this->request->getPost('password_nueva');
        $rep    = $this->request->getPost('password_rep');

        if (!password_verify($actual, $usuario['password'])) {
            return redirect()->to('/perfil')->with('error', 'La contraseña actual es incorrecta.');
        }
        if (strlen($nueva) < 6) {
            return redirect()->to('/perfil')->with('error', 'La nueva contraseña debe tener al menos 6 caracteres.');
        }
        if ($nueva !== $rep) {
            return redirect()->to('/perfil')->with('error', 'Las contraseñas no coinciden.');
        }

        $this->usuarioModel->update($id_usuario, [
            'password' => password_hash($nueva, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente.');
    }
}
