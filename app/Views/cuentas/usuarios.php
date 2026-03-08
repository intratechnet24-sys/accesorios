<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3">

    <!-- Usuarios de la cuenta -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Usuarios de la cuenta</span>
                <a href="<?= base_url('cuentas') ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-0">
                <?php foreach ($usuarios as $u): ?>
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom">
                    <?php if (!empty($u['foto'])): ?>
                        <img src="<?= base_url('uploads/usuarios/'.$u['foto']) ?>"
                             class="rounded-circle" width="40" height="40" style="object-fit:cover">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:40px;height:40px;font-size:0.9rem;font-weight:700">
                            <?= strtoupper(substr($u['nombre'],0,1).substr($u['apellido'],0,1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            <?= esc($u['nombre'].' '.$u['apellido']) ?>
                            <?php if ($u['id_usuario'] == $mi_id): ?>
                            <span class="badge bg-success ms-1" style="font-size:0.65rem">Yo</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted" style="font-size:0.78rem">
                            <?= esc($u['email']) ?> &nbsp;·&nbsp; @<?= esc($u['username']) ?>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <?php if ($es_admin && $u['id_usuario'] != $mi_id): ?>
                        <form action="<?= base_url('cuentas/cambiar-rol/'.$u['id']) ?>" method="post" class="d-flex gap-1">
                            <?= csrf_field() ?>
                            <select name="rol" class="form-select form-select-sm" style="width:130px">
                                <option value="administrador" <?= $u['rol']=='administrador'?'selected':'' ?>>Administrador</option>
                                <option value="colaborador"   <?= $u['rol']=='colaborador'  ?'selected':'' ?>>Colaborador</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Guardar rol">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        <a href="<?= base_url('cuentas/quitar-usuario/'.$u['id']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           title="Quitar de la cuenta"
                           onclick="return confirm('¿Quitar a <?= esc($u['nombre']) ?> de esta cuenta?')">
                            <i class="bi bi-person-x"></i>
                        </a>
                        <?php else: ?>
                        <span class="badge <?= $u['rol']=='administrador'?'bg-primary':'bg-secondary' ?>">
                            <?= ucfirst($u['rol']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Invitaciones pendientes -->
        <?php if (!empty($invitaciones)): ?>
        <div class="card mt-3">
            <div class="card-header"><i class="bi bi-envelope-open me-2"></i>Invitaciones Pendientes</div>
            <div class="card-body p-0">
                <?php foreach ($invitaciones as $inv): ?>
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom">
                    <div class="flex-grow-1">
                        <div class="fw-semibold"><?= esc($inv['nombre'].' '.$inv['apellido']) ?></div>
                        <div class="text-muted" style="font-size:0.78rem">
                            <?= esc($inv['email']) ?>
                            &nbsp;·&nbsp;
                            <span class="badge <?= $inv['rol']=='administrador'?'bg-primary':'bg-secondary' ?>">
                                <?= ucfirst($inv['rol']) ?>
                            </span>
                            &nbsp;·&nbsp;
                            <?= date('d/m/Y', strtotime($inv['created_at'])) ?>
                        </div>
                        <div class="mt-1" style="font-size:0.75rem">
                            <span class="text-muted me-1">Enlace:</span>
                            <code><?= base_url('auth/invitacion/'.$inv['token']) ?></code>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark">Pendiente</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Formulario invitar -->
    <?php if ($es_admin): ?>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-plus me-2"></i>Invitar Usuario</div>
            <div class="card-body">
                <form action="<?= base_url('cuentas/invitar/'.$cuenta['id_cuenta']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rol</label>
                        <select name="rol" class="form-select">
                            <option value="colaborador">Colaborador</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>Generar enlace de invitación
                        </button>
                    </div>
                    <div class="text-muted mt-2" style="font-size:0.78rem">
                        <i class="bi bi-info-circle me-1"></i>
                        Se generará un enlace que deberás enviarle al usuario para que complete su registro.
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
