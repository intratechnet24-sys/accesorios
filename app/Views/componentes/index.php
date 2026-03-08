<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-gear-wide-connected me-2"></i>Accesorios de Vehículos</span>
        <a href="<?= base_url('componentes/nuevo') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Accesorio
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Equipo</th>
                    <th>Descripcion</th>
                    <th>Tipo</th>
                    <th>Seccion</th>
                    <th>Cod. Trazabilidad</th>
                    <th>Lugar</th>
                    <th>Fecha Alta</th>
                    <th>Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($componentes as $c): ?>
                <?php
                    $hoy   = new DateTime();
                    $venc  = new DateTime($c['fecha_vencimiento']);
                    $diff  = (int)$hoy->diff($venc)->days;
                    $vencido = $venc < $hoy;
                    $proximo = !$vencido && $diff <= 30;
                ?>
                <tr>
                    <td><?= $c['id_componente'] ?></td>
                    <td>
                        <a href="<?= base_url('equipos/ver/'.$c['id_equipo']) ?>" class="text-decoration-none fw-semibold">
                            <?= esc($c['codigo']) ?>
                        </a>
                        <div class="text-muted" style="font-size:0.78rem"><?= esc($c['marca']) ?> <?= esc($c['modelo']) ?></div>
                    </td>
                    <td><?= esc($c['descripcion']) ?></td>
                    <td>
                        <span class="badge <?= $c['tipo'] == 'baterias' ? 'badge-baterias' : 'badge-cubiertas' ?>">
                            <?= ucfirst($c['tipo']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge <?= $c['seccion'] == 'motor' ? 'badge-motor' : ($c['seccion'] == 'tren rodante' ? 'badge-tren' : 'badge-otros') ?>">
                            <?= ucfirst($c['seccion']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if (!empty($c['codigo_trazabilidad'])): ?>
                            <span class="badge bg-light text-dark border"><?= esc($c['codigo_trazabilidad']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= !empty($c['lugar']) ? esc($c['lugar']) : '<span class="text-muted">—</span>' ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($c['fecha_alta'])) ?></td>
                    <td>
                        <?php if ($vencido): ?>
                            <span class="text-danger fw-semibold"><i class="bi bi-x-circle me-1"></i><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                        <?php elseif ($proximo): ?>
                            <span class="text-warning fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                        <?php else: ?>
                            <span class="text-success"><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('certificados/componente/'.$c['id_componente']) ?>"
                           class="btn btn-sm btn-outline-info" title="Ver Certificados">
                            <i class="bi bi-patch-check"></i>
                        </a>
                        <a href="<?= base_url('certificados/nuevo/'.$c['id_componente']) ?>"
                           class="btn btn-sm btn-outline-success" title="Nuevo Certificado">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                        <a href="<?= base_url('componentes/editar/'.$c['id_componente']) ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= base_url('componentes/eliminar/'.$c['id_componente']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           title="Eliminar"
                           onclick="return confirm('¿Eliminar este accesorio?')">
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
