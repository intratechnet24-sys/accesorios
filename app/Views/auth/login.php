<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-5 col-lg-4">
<div class="auth-card">
    <div class="auth-header">
        <h4><i class="bi bi-tools me-2"></i>GestAccesorios</h4>
        <small>Sistema de Gestión de Accesorios</small>
    </div>
    <div class="auth-body">
        <h5 class="mb-4 text-center fw-semibold">Iniciar Sesión</h5>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/procesar-login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="text" name="email" class="form-control"
                           placeholder="tu@email.com" autofocus
                           value="<?= esc(old('email')) ?>">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••">
                </div>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                </button>
            </div>
        </form>

        <hr>
        <div class="text-center text-muted" style="font-size:0.9rem">
            ¿No tenés cuenta?
            <a href="<?= base_url('auth/registro') ?>" class="fw-semibold">Registrate aquí</a>
        </div>
    </div>
</div>
</div>
</div>
</div>

<?= $this->endSection() ?>
