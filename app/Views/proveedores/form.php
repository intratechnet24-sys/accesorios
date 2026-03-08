<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">
        <i class="bi bi-building me-2"></i><?= esc($titulo) ?>
    </div>
    <div class="card-body">

        <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <?php
            $action = $proveedor
                ? base_url('proveedores/actualizar/'.$proveedor['id_proveedor'])
                : base_url('proveedores/guardar');
        ?>

        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Razon Social <span class="text-danger">*</span></label>
                <input type="text" name="razon_social" class="form-control"
                       placeholder="Nombre o razon social"
                       value="<?= esc($proveedor['razon_social'] ?? old('razon_social')) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">CUIT / CUIL / DNI</label>
                <input type="text" name="cuit_cuil_dni" class="form-control"
                       placeholder="Ej: 20-12345678-9"
                       value="<?= esc($proveedor['cuit_cuil_dni'] ?? old('cuit_cuil_dni')) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Direccion</label>
                <input type="text" name="direccion" class="form-control"
                       placeholder="Calle, numero, piso..."
                       value="<?= esc($proveedor['direccion'] ?? old('direccion')) ?>">
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">Contacto</div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-telephone me-1"></i>Telefono</label>
                    <input type="text" name="telefono" class="form-control"
                           placeholder="Ej: 0291-4123456"
                           value="<?= esc($proveedor['telefono'] ?? old('telefono')) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-whatsapp me-1 text-success"></i>WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control"
                           placeholder="Ej: 5492914123456 (con codigo pais)"
                           value="<?= esc($proveedor['whatsapp'] ?? old('whatsapp')) ?>">
                    <div class="form-text">Solo numeros con codigo de pais. Ej: <strong>5492914123456</strong></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-envelope me-1 text-primary"></i>Email</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="proveedor@mail.com"
                           value="<?= esc($proveedor['email'] ?? old('email')) ?>">
                </div>
            </div>

            <hr class="my-3">
            <div class="fw-semibold text-muted mb-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1px">Ubicacion</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Provincia</label>
                    <select name="id_provincia" id="selectProvincia" class="form-select">
                        <option value="">-- Seleccionar provincia --</option>
                        <?php foreach ($provincias as $prov): ?>
                        <option value="<?= $prov['id_provincia'] ?>"
                            <?= (($proveedor['id_provincia'] ?? '') == $prov['id_provincia']) ? 'selected' : '' ?>>
                            <?= esc($prov['provincia']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Localidad</label>
                    <select name="id_localidad" id="selectLocalidad" class="form-select">
                        <option value="">-- Seleccionar localidad --</option>
                        <?php foreach ($localidades as $loc): ?>
                        <option value="<?= $loc['id_localidad'] ?>"
                            <?= (($proveedor['id_localidad'] ?? '') == $loc['id_localidad']) ? 'selected' : '' ?>>
                            <?= esc($loc['localidad']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Guardar
                </button>
                <a href="<?= base_url('proveedores') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('selectProvincia').addEventListener('change', function() {
    const id_provincia = this.value;
    const sel = document.getElementById('selectLocalidad');
    sel.innerHTML = '<option value="">Cargando...</option>';
    if (!id_provincia) {
        sel.innerHTML = '<option value="">-- Seleccionar localidad --</option>';
        return;
    }
    fetch('<?= base_url('proveedores/localidades') ?>/' + id_provincia)
        .then(r => r.json())
        .then(data => {
            sel.innerHTML = '<option value="">-- Seleccionar localidad --</option>';
            data.forEach(l => {
                sel.innerHTML += `<option value="${l.id_localidad}">${l.localidad}</option>`;
            });
        });
});
</script>
<?= $this->endSection() ?>
