<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="bi bi-gear-wide-connected me-2"></i><?= esc($titulo) ?>
    </div>
    <div class="card-body">

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
        <?php endif; ?>

        <?php
            $action = $componente
                ? base_url('componentes/actualizar/'.$componente['id_componente'])
                : base_url('componentes/guardar');
        ?>

        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>

            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">
                Asignacion
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Vehiculo / Equipo <span class="text-danger">*</span></label>
                <select name="id_equipo" class="form-select" required>
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($equipos as $eq): ?>
                    <option value="<?= $eq['id_equipo'] ?>"
                        <?= (($componente['id_equipo'] ?? $id_equipo) == $eq['id_equipo']) ? 'selected' : '' ?>>
                        <?= esc($eq['codigo']) ?><?= !empty($eq['dominio']) ? ' ('.$eq['dominio'].')' : '' ?> — <?= esc($eq['descripcion']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripcion</label>
                <input type="text" name="descripcion" class="form-control"
                       placeholder="Ej: Bateria 12V 100Ah"
                       value="<?= esc($componente['descripcion'] ?? old('descripcion')) ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tipo de Accesorio <span class="text-danger">*</span></label>
                    <select name="tipo" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <option value="baterias"  <?= (($componente['tipo'] ?? old('tipo')) == 'baterias')  ? 'selected' : '' ?>>Baterias</option>
                        <option value="cubiertas" <?= (($componente['tipo'] ?? old('tipo')) == 'cubiertas') ? 'selected' : '' ?>>Cubiertas</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Seccion <span class="text-danger">*</span></label>
                    <select name="seccion" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <option value="motor"        <?= (($componente['seccion'] ?? old('seccion')) == 'motor')        ? 'selected' : '' ?>>Motor</option>
                        <option value="tren rodante" <?= (($componente['seccion'] ?? old('seccion')) == 'tren rodante') ? 'selected' : '' ?>>Tren Rodante</option>
                        <option value="otros"        <?= (($componente['seccion'] ?? old('seccion')) == 'otros')        ? 'selected' : '' ?>>Otros</option>
                    </select>
                </div>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">
                Marca y Proveedor
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Marca</label>
                    <select name="id_marca" class="form-select">
                        <option value="">-- Sin especificar --</option>
                        <?php foreach ($marcas as $m): ?>
                        <option value="<?= $m['id_marca'] ?>"
                            <?= (($componente['id_marca'] ?? old('id_marca')) == $m['id_marca']) ? 'selected' : '' ?>>
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
                    <label class="form-label fw-semibold">Proveedor</label>
                    <select name="id_proveedor" class="form-select">
                        <option value="">-- Sin especificar --</option>
                        <?php foreach ($proveedores as $p): ?>
                        <option value="<?= $p['id_proveedor'] ?>"
                            <?= (($componente['id_proveedor'] ?? old('id_proveedor')) == $p['id_proveedor']) ? 'selected' : '' ?>>
                            <?= esc($p['razon_social']) ?><?= !empty($p['cuit_cuil_dni']) ? ' — '.$p['cuit_cuil_dni'] : '' ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">
                        <a href="<?= base_url('proveedores/nuevo') ?>" target="_blank">
                            <i class="bi bi-plus-circle me-1"></i>Agregar nuevo proveedor
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">
                Identificacion y Vencimiento
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Codigo de Trazabilidad</label>
                    <input type="text" name="codigo_trazabilidad" class="form-control"
                           placeholder="Ej: TRAZ-2024-001"
                           value="<?= esc($componente['codigo_trazabilidad'] ?? old('codigo_trazabilidad')) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Lugar / Ubicacion</label>
                    <input type="text" name="lugar" class="form-control"
                           placeholder="Ej: Deposito Norte - Estante 3"
                           value="<?= esc($componente['lugar'] ?? old('lugar')) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fecha de Vencimiento <span class="text-danger">*</span></label>
                <input type="date" name="fecha_vencimiento" class="form-control"
                       value="<?= esc($componente['fecha_vencimiento'] ?? old('fecha_vencimiento')) ?>" required>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Guardar
                </button>
                <a href="<?= base_url('componentes') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>
