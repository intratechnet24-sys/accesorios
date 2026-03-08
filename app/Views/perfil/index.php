<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3">

    <!-- Foto y datos básicos -->
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <?php if (!empty($usuario['foto'])): ?>
                    <img src="<?= base_url('uploads/usuarios/'.$usuario['foto']) ?>"
                         class="rounded-circle mb-3" width="100" height="100"
                         style="object-fit:cover;border:3px solid #1a3a5c">
                <?php else: ?>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:100px;height:100px;font-size:2.5rem;font-weight:700">
                        <?= strtoupper(substr($usuario['nombre'],0,1).substr($usuario['apellido'],0,1)) ?>
                    </div>
                <?php endif; ?>
                <h5 class="fw-bold mb-0"><?= esc($usuario['nombre'].' '.$usuario['apellido']) ?></h5>
                <div class="text-muted mb-1">@<?= esc($usuario['username']) ?></div>
                <div class="text-muted" style="font-size:0.82rem"><?= esc($usuario['email']) ?></div>

                <hr>
                <form action="<?= base_url('perfil/subir-foto') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <label class="form-label fw-semibold" style="font-size:0.82rem">Cambiar foto</label>
                    <input type="file" name="foto" class="form-control form-control-sm mb-2"
                           accept="image/jpeg,image/png,image/gif,image/webp">
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-camera me-1"></i>Subir foto
                    </button>
                </form>
            </div>
        </div>

        <!-- Mis cuentas -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="bi bi-building me-2"></i>Mis Cuentas
            </div>
            <div class="card-body p-0">
                <?php foreach ($cuentas as $cuenta): ?>
                <div class="d-flex align-items-center gap-2 px-3 py-2 border-bottom">
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size:0.9rem"><?= esc($cuenta['nombre_cuenta']) ?></div>
                        <div class="text-muted" style="font-size:0.75rem">
                            <span class="badge <?= $cuenta['rol'] == 'administrador' ? 'bg-primary' : 'bg-secondary' ?>">
                                <?= ucfirst($cuenta['rol']) ?>
                            </span>
                            &nbsp;<?= esc($cuenta['nombre_plan']) ?>
                        </div>
                    </div>
                    <?php if ($cuenta['id_cuenta'] == session('id_cuenta')): ?>
                        <span class="badge bg-success">Activa</span>
                    <?php else: ?>
                        <a href="<?= base_url('cuentas/activar/'.$cuenta['id_cuenta']) ?>"
                           class="btn btn-xs btn-outline-primary btn-sm" style="font-size:0.72rem">
                            Activar
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div class="px-3 py-2">
                    <a href="<?= base_url('cuentas/nueva') ?>" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-plus-circle me-1"></i>Nueva cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Editar datos -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-gear me-2"></i>Editar Perfil</div>
            <div class="card-body">
                <?php if (isset($validation)): ?>
                <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>

                <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control"
                                   value="<?= esc($usuario['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" class="form-control"
                                   value="<?= esc($usuario['apellido']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="<?= esc($usuario['email']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>

        <!-- Cambiar contraseña -->
        <div class="card mt-3">
            <div class="card-header"><i class="bi bi-lock me-2"></i>Cambiar Contraseña</div>
            <div class="card-body">
                <form action="<?= base_url('perfil/cambiar-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña actual</label>
                        <input type="password" name="password_actual" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nueva contraseña</label>
                            <input type="password" name="password_nueva" class="form-control"
                                   placeholder="Mínimo 6 caracteres" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Repetir nueva</label>
                            <input type="password" name="password_rep" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="bi bi-key me-1"></i>Cambiar contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
