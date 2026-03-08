<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="<?= base_url('cuentas/nueva') ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Cuenta
    </a>
</div>

<div class="row g-3">
    <?php foreach ($cuentas as $cuenta): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 <?= $cuenta['id_cuenta'] == session('id_cuenta') ? 'border-primary' : '' ?>">
            <?php if ($cuenta['id_cuenta'] == session('id_cuenta')): ?>
            <div class="card-header py-2 bg-primary text-white" style="font-size:0.78rem">
                <i class="bi bi-check-circle me-1"></i>Cuenta activa
            </div>
            <?php endif; ?>
            <div class="card-body">
                <h6 class="fw-bold mb-1"><?= esc($cuenta['nombre_cuenta']) ?></h6>
                <div class="mb-2">
                    <span class="badge <?= $cuenta['rol'] == 'administrador' ? 'bg-primary' : 'bg-secondary' ?>">
                        <?= ucfirst($cuenta['rol']) ?>
                    </span>
                    <span class="badge bg-light text-dark ms-1"><?= esc($cuenta['nombre_plan']) ?></span>
                    <?php if ($cuenta['monto'] > 0): ?>
                    <span class="text-muted ms-1" style="font-size:0.78rem">
                        $<?= number_format($cuenta['monto'], 0, ',', '.') ?>/mes
                    </span>
                    <?php else: ?>
                    <span class="badge bg-success ms-1">Gratis</span>
                    <?php endif; ?>
                </div>
                <div class="text-muted" style="font-size:0.78rem">
                    <i class="bi bi-calendar3 me-1"></i>Desde <?= date('d/m/Y', strtotime($cuenta['created_at'])) ?>
                </div>
            </div>
            <div class="card-footer bg-transparent d-flex gap-2">
                <?php if ($cuenta['id_cuenta'] != session('id_cuenta')): ?>
                <a href="<?= base_url('cuentas/activar/'.$cuenta['id_cuenta']) ?>"
                   class="btn btn-sm btn-outline-primary flex-grow-1">
                    <i class="bi bi-check2-circle me-1"></i>Activar
                </a>
                <?php endif; ?>
                <?php if ($cuenta['rol'] == 'administrador'): ?>
                <a href="<?= base_url('cuentas/usuarios/'.$cuenta['id_cuenta']) ?>"
                   class="btn btn-sm btn-outline-secondary flex-grow-1">
                    <i class="bi bi-people me-1"></i>Usuarios
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if (empty($cuentas)): ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-building" style="font-size:3rem;opacity:0.3"></i>
                <p class="mt-2">No pertenecés a ninguna cuenta todavía.</p>
                <a href="<?= base_url('cuentas/nueva') ?>" class="btn btn-primary">Crear cuenta</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
