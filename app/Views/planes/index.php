<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3">

    <!-- Formulario nuevo plan -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-plus-circle me-2"></i>Nuevo Plan</div>
            <div class="card-body">
                <form action="<?= base_url('planes/guardar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Avanzado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Monto ($/mes) <span class="text-danger">*</span></label>
                        <input type="number" name="monto" class="form-control" step="0.01" min="0"
                               placeholder="0.00" required>
                        <div class="form-text">Ingresá 0 para plan gratuito.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"
                                  placeholder="Breve descripción del plan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Funcionalidades</label>
                        <textarea name="funcionalidades" class="form-control" rows="3"
                                  placeholder="Ej: Hasta 50 equipos · 5 usuarios · Reportes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Guardar Plan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Listado de planes -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-list-check me-2"></i>Planes Registrados</div>
            <div class="card-body p-0">
                <?php if (empty($planes)): ?>
                <div class="text-center text-muted py-4">No hay planes cargados.</div>
                <?php endif; ?>
                <?php foreach ($planes as $plan): ?>
                <div class="px-3 py-3 border-bottom" id="plan-row-<?= $plan['id_plan'] ?>">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div class="flex-grow-1" id="plan-view-<?= $plan['id_plan'] ?>">
                            <div class="fw-bold fs-6">
                                <?= esc($plan['nombre']) ?>
                                <span class="ms-2 <?= $plan['monto']==0?'badge bg-success':'text-primary fw-semibold' ?>">
                                    <?= $plan['monto']==0 ? 'Gratis' : '$'.number_format($plan['monto'],0,',','.').'<small class="text-muted">/mes</small>' ?>
                                </span>
                            </div>
                            <?php if ($plan['descripcion']): ?>
                            <div class="text-muted" style="font-size:0.82rem"><?= esc($plan['descripcion']) ?></div>
                            <?php endif; ?>
                            <?php if ($plan['funcionalidades']): ?>
                            <div class="mt-1" style="font-size:0.78rem;color:#555">
                                <i class="bi bi-check2-all me-1 text-success"></i><?= esc($plan['funcionalidades']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-warning"
                                    onclick="editarPlan(<?= $plan['id_plan'] ?>)" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="<?= base_url('planes/eliminar/'.$plan['id_plan']) ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Eliminar plan <?= esc($plan['nombre']) ?>?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Formulario edición inline (oculto) -->
                    <div id="plan-edit-<?= $plan['id_plan'] ?>" class="mt-3 d-none">
                        <form action="<?= base_url('planes/actualizar/'.$plan['id_plan']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <input type="text" name="nombre" class="form-control form-control-sm"
                                           value="<?= esc($plan['nombre']) ?>" required placeholder="Nombre">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="monto" class="form-control form-control-sm"
                                           value="<?= $plan['monto'] ?>" step="0.01" min="0" required placeholder="Monto">
                                </div>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="descripcion" class="form-control form-control-sm"
                                       value="<?= esc($plan['descripcion']) ?>" placeholder="Descripción">
                            </div>
                            <div class="mb-2">
                                <textarea name="funcionalidades" class="form-control form-control-sm" rows="2"
                                          placeholder="Funcionalidades"><?= esc($plan['funcionalidades']) ?></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-save me-1"></i>Guardar
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="cancelarEdicion(<?= $plan['id_plan'] ?>)">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
function editarPlan(id) {
    document.getElementById('plan-view-'+id).classList.add('d-none');
    document.getElementById('plan-edit-'+id).classList.remove('d-none');
}
function cancelarEdicion(id) {
    document.getElementById('plan-view-'+id).classList.remove('d-none');
    document.getElementById('plan-edit-'+id).classList.add('d-none');
}
</script>
<?= $this->endSection() ?>
