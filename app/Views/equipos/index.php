<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-truck me-2"></i>Listado de Vehículos / Equipos</span>
        <a href="<?= base_url('equipos/nuevo') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Equipo
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Dominio</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipos as $eq): ?>
                <tr style="cursor:pointer" onclick="window.location='<?= base_url('equipos/ver/'.$eq['id_equipo']) ?>'">
                    <td><?= $eq['id_equipo'] ?></td>
                    <td>
                        <a href="<?= base_url('equipos/ver/'.$eq['id_equipo']) ?>"
                           class="fw-semibold text-decoration-none text-primary"
                           onclick="event.stopPropagation()">
                            <?= esc($eq['codigo']) ?>
                        </a>
                    </td>
                    <td><?= !empty($eq['dominio']) ? esc($eq['dominio']) : '<span class="text-muted">—</span>' ?></td>
                    <td><?= esc($eq['descripcion']) ?></td>
                    <td><?= !empty($eq['marca']) ? esc($eq['marca']) : '<span class="text-muted">—</span>' ?></td>
                    <td><?= esc($eq['modelo']) ?></td>
                    <td>
                        <?php if ($eq['estado']): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($eq['fecha_alta'])) ?></td>
                    <td>
                        <a href="<?= base_url('equipos/ver/'.$eq['id_equipo']) ?>" class="btn btn-sm btn-outline-info" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?= base_url('equipos/editar/'.$eq['id_equipo']) ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= base_url('equipos/eliminar/'.$eq['id_equipo']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           title="Desactivar"
                           onclick="return confirm('¿Desactivar este equipo?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
