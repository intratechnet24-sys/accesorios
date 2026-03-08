<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">
        <i class="bi bi-patch-check me-2"></i><?= esc($titulo) ?>
    </div>
    <div class="card-body">

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
        <?php endif; ?>

        <?php
            $action = $certificado
                ? base_url('certificados/actualizar/'.$certificado['id_certificado'])
                : base_url('certificados/guardar');
        ?>

        <?php if ($componente): ?>
        <div class="alert alert-info d-flex align-items-center gap-2 mb-4" style="font-size:0.88rem">
            <i class="bi bi-info-circle fs-5"></i>
            <div>
                Accesorio: <strong><?= ucfirst($componente['tipo']) ?></strong> &mdash;
                Seccion: <strong><?= ucfirst($componente['seccion']) ?></strong>
            </div>
        </div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Accesorio <span class="text-danger">*</span></label>
                <select name="id_componente" class="form-select" required>
                    <option value="">-- Seleccionar accesorio --</option>
                    <?php foreach ($componentes as $comp): ?>
                    <option value="<?= $comp['id_componente'] ?>"
                        <?= (($certificado['id_componente'] ?? $id_componente) == $comp['id_componente']) ? 'selected' : '' ?>>
                        <?= esc($comp['codigo']) ?> — <?= ucfirst($comp['tipo']) ?> / <?= ucfirst($comp['seccion']) ?>
                        (Vence: <?= date('d/m/Y', strtotime($comp['fecha_vencimiento'])) ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Numero de Certificado <span class="text-danger">*</span></label>
                <input type="text"
                       name="numero_certificado"
                       class="form-control"
                       placeholder="Ej: CERT-2024-001"
                       value="<?= esc($certificado['numero_certificado'] ?? old('numero_certificado')) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Entidad Certificadora <span class="text-danger">*</span></label>
                <input type="text"
                       name="entidad_certificadora"
                       class="form-control"
                       placeholder="Ej: Laboratorio XYZ S.A."
                       value="<?= esc($certificado['entidad_certificadora'] ?? old('entidad_certificadora')) ?>"
                       required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de Emision <span class="text-danger">*</span></label>
                    <input type="date"
                           name="fecha_emision"
                           class="form-control"
                           value="<?= esc($certificado['fecha_emision'] ?? old('fecha_emision')) ?>"
                           required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de Vencimiento <span class="text-danger">*</span></label>
                    <input type="date"
                           name="fecha_vencimiento"
                           class="form-control"
                           value="<?= esc($certificado['fecha_vencimiento'] ?? old('fecha_vencimiento')) ?>"
                           required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea name="observaciones"
                          class="form-control"
                          rows="3"
                          placeholder="Notas adicionales sobre el certificado..."><?= esc($certificado['observaciones'] ?? old('observaciones')) ?></textarea>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Guardar
                </button>
                <a href="<?= base_url('certificados') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>
