<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header"><i class="bi bi-building me-2"></i><?= esc($titulo) ?></div>
    <div class="card-body">
        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('cuentas/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la Cuenta / Empresa <span class="text-danger">*</span></label>
                <input type="text" name="nombre_cuenta" class="form-control"
                       placeholder="Ej: Transportes García S.A."
                       value="<?= esc($cuenta['nombre_cuenta'] ?? old('nombre_cuenta')) ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Plan</label>
                <div class="row g-2">
                    <?php foreach ($planes as $plan): ?>
                    <div class="col-12">
                        <input type="radio" class="btn-check" name="id_plan"
                               id="plan_<?= $plan['id_plan'] ?>"
                               value="<?= $plan['id_plan'] ?>"
                               <?= ($cuenta['id_plan'] ?? 1) == $plan['id_plan'] ? 'checked' : ($plan['monto'] == 0 ? 'checked' : '') ?>>
                        <label class="btn btn-outline-primary w-100 text-start p-3" for="plan_<?= $plan['id_plan'] ?>">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold"><?= esc($plan['nombre']) ?></span>
                                <span><?= $plan['monto'] == 0 ? '<span class="badge bg-success">Gratis</span>' : '$'.number_format($plan['monto'],0,',','.').'<small>/mes</small>' ?></span>
                            </div>
                            <?php if ($plan['descripcion']): ?>
                            <div class="text-muted mt-1" style="font-size:0.82rem"><?= esc($plan['descripcion']) ?></div>
                            <?php endif; ?>
                            <?php if ($plan['funcionalidades']): ?>
                            <div style="font-size:0.75rem;margin-top:4px;color:#555"><?= esc($plan['funcionalidades']) ?></div>
                            <?php endif; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Crear Cuenta</button>
                <a href="<?= base_url('cuentas') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>
