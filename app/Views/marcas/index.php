<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3">
    <!-- Formulario nueva marca -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-tag me-2"></i>Nueva Marca</div>
            <div class="card-body">
                <form action="<?= base_url('marcas/guardar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre de la Marca <span class="text-danger">*</span></label>
                        <input type="text" name="marca" class="form-control" placeholder="Ej: Toyota" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Agregar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Listado de marcas -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-tags me-2"></i>Marcas Registradas</div>
            <div class="card-body p-0">
                <table class="table table-hover datatable w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Marca</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($marcas as $m): ?>
                        <tr>
                            <td><?= $m['id_marca'] ?></td>
                            <td>
                                <!-- Edicion inline -->
                                <span class="marca-texto-<?= $m['id_marca'] ?>"><?= esc($m['marca']) ?></span>
                                <form class="d-none marca-form-<?= $m['id_marca'] ?>"
                                      action="<?= base_url('marcas/actualizar/'.$m['id_marca']) ?>"
                                      method="post" style="max-width:250px">
                                    <?= csrf_field() ?>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="marca" class="form-control"
                                               value="<?= esc($m['marca']) ?>" required>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary"
                                                onclick="cancelarEdit(<?= $m['id_marca'] ?>)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-warning"
                                        onclick="editarMarca(<?= $m['id_marca'] ?>)" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="<?= base_url('marcas/eliminar/'.$m['id_marca']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Eliminar la marca <?= esc($m['marca']) ?>?')"
                                   title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function editarMarca(id) {
    document.querySelector('.marca-texto-' + id).classList.add('d-none');
    document.querySelector('.marca-form-' + id).classList.remove('d-none');
}
function cancelarEdit(id) {
    document.querySelector('.marca-texto-' + id).classList.remove('d-none');
    document.querySelector('.marca-form-' + id).classList.add('d-none');
}
</script>
<?= $this->endSection() ?>
