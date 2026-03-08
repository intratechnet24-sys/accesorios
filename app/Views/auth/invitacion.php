<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="auth-card">
    <div class="auth-header">
        <h4><i class="bi bi-envelope-check me-2"></i>Invitación</h4>
        <small>Completá tu registro para unirte</small>
    </div>
    <div class="auth-body">
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>
            Fuiste invitado a unirte a la cuenta
            <strong><?= esc($invitacion['nombre_cuenta']) ?></strong>
            como <strong><?= esc($invitacion['rol']) ?></strong>.
        </div>

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/completar-registro') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($invitacion['token']) ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" value="<?= esc($invitacion['nombre']) ?>" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Apellido</label>
                    <input type="text" class="form-control" value="<?= esc($invitacion['apellido']) ?>" disabled>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="text" class="form-control" value="<?= esc($invitacion['email']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de usuario <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control"
                       value="<?= esc(old('username')) ?>" required placeholder="Solo letras, números y guiones">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Repetir contraseña <span class="text-danger">*</span></label>
                <input type="password" name="password2" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Completar Registro
                </button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

<?= $this->endSection() ?>
