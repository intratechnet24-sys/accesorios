<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="bi bi-truck me-2"></i><?= esc($titulo) ?>
    </div>
    <div class="card-body">

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <?php
            $action = $equipo
                ? base_url('equipos/actualizar/'.$equipo['id_equipo'])
                : base_url('equipos/guardar');
        ?>

        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>

            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">
                Identificacion
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Codigo <span class="text-danger">*</span></label>
                    <input type="text" name="codigo" class="form-control"
                           placeholder="Ej: VH-001"
                           value="<?= esc($equipo['codigo'] ?? old('codigo')) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Dominio / Patente</label>
                    <input type="text" name="dominio" class="form-control"
                           placeholder="Ej: ABC 123"
                           value="<?= esc($equipo['dominio'] ?? old('dominio')) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Numero de Serie</label>
                    <input type="text" name="numero_serie" class="form-control"
                           placeholder="Ej: 1HGCM82633A004352"
                           value="<?= esc($equipo['numero_serie'] ?? old('numero_serie')) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripcion</label>
                <input type="text" name="descripcion" class="form-control"
                       placeholder="Ej: Camion volquete 10 ton"
                       value="<?= esc($equipo['descripcion'] ?? old('descripcion')) ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Marca</label>
                    <select name="id_marca" class="form-select">
                        <option value="">-- Sin especificar --</option>
                        <?php foreach ($marcas as $m): ?>
                        <option value="<?= $m['id_marca'] ?>"
                            <?= (($equipo['id_marca'] ?? old('id_marca')) == $m['id_marca']) ? 'selected' : '' ?>>
                            <?= esc($m['marca']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">
                        <a href="<?= base_url('marcas') ?>" target="_blank">
                            <i class="bi bi-plus-circle me-1"></i>Agregar nueva marca
                        </a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Modelo</label>
                    <input type="text" name="modelo" class="form-control"
                           value="<?= esc($equipo['modelo'] ?? old('modelo')) ?>">
                </div>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">
                Fechas y descripcion tecnica
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" class="form-control"
                           value="<?= esc($equipo['fecha_ingreso'] ?? old('fecha_ingreso')) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de Garantia</label>
                    <input type="date" name="fecha_garantia" class="form-control"
                           value="<?= esc($equipo['fecha_garantia'] ?? old('fecha_garantia')) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripcion Tecnica</label>
                <textarea name="descripcion_tecnica" class="form-control" rows="3"
                          placeholder="Especificaciones tecnicas del vehiculo..."><?= esc($equipo['descripcion_tecnica'] ?? old('descripcion_tecnica')) ?></textarea>
            </div>

            <?php if ($equipo): ?>
            <hr class="my-3">
            <div class="mb-3">
                <label class="form-label fw-semibold">Estado</label>
                <select name="estado" class="form-select">
                    <option value="1" <?= $equipo['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= $equipo['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <?php endif; ?>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Guardar
                </button>
                <a href="<?= base_url('equipos') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>
