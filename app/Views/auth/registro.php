<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-md-8 col-lg-7">
<div class="auth-card">
    <div class="auth-header">
        <h4><i class="bi bi-tools me-2"></i>GestAccesorios</h4>
        <small>Crear nueva cuenta</small>
    </div>
    <div class="auth-body">
        <h5 class="mb-4 fw-semibold">Registro</h5>

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/procesar-registro') ?>" method="post">
            <?= csrf_field() ?>

            <div class="fw-semibold text-muted mb-2" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Datos personales</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control" value="<?= esc(old('nombre')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                    <input type="text" name="apellido" class="form-control" value="<?= esc(old('apellido')) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-2" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Contraseña</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Repetir contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password2" class="form-control" required>
                </div>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-2" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Tu cuenta</div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la cuenta / Empresa <span class="text-danger">*</span></label>
                <input type="text" name="nombre_cuenta" class="form-control"
                       placeholder="Ej: Transportes García S.A."
                       value="<?= esc(old('nombre_cuenta')) ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Plan</label>
                <div class="row g-2">
                    <?php foreach ($planes as $plan): ?>
                    <div class="col-md-4">
                        <input type="radio" class="btn-check" name="id_plan"
                               id="plan_<?= $plan['id_plan'] ?>"
                               value="<?= $plan['id_plan'] ?>"
                               <?= $plan['monto'] == 0 ? 'checked' : '' ?>>
                        <label class="btn btn-outline-primary w-100 text-start p-3"
                               for="plan_<?= $plan['id_plan'] ?>">
                            <div class="fw-bold"><?= esc($plan['nombre']) ?></div>
                            <div class="text-muted" style="font-size:0.8rem">
                                <?= $plan['monto'] == 0 ? 'Gratis' : '$' . number_format($plan['monto'], 0, ',', '.') . '/mes' ?>
                            </div>
                            <?php if ($plan['funcionalidades']): ?>
                            <div style="font-size:0.72rem;margin-top:4px;color:#555"><?= esc($plan['funcionalidades']) ?></div>
                            <?php endif; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Crear Cuenta
                </button>
            </div>
        </form>

        <hr>
        <div class="text-center text-muted" style="font-size:0.9rem">
            ¿Ya tenés cuenta?
            <a href="<?= base_url('auth/login') ?>" class="fw-semibold">Iniciá sesión</a>
        </div>
    </div>
</div>
</div>
</div>
</div>

<?= $this->endSection() ?>
