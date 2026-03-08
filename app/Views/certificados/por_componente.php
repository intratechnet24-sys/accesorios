<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    $hoyObj  = new DateTime();
    $vencComp = new DateTime($componente['fecha_vencimiento']);
    $diffComp = (int)$hoyObj->diff($vencComp)->days;
    $vencidoComp = $vencComp < $hoyObj;
    $proximoComp = !$vencidoComp && $diffComp <= 30;
?>

<div class="mb-3">
    <a href="<?= base_url('componentes') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver a Accesorios
    </a>
</div>

<!-- Info del accesorio -->
<div class="card mb-3">
    <div class="card-body py-3">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div>
                <span class="badge <?= $componente['tipo'] == 'baterias' ? 'badge-baterias' : 'badge-cubiertas' ?> fs-6">
                    <?= ucfirst($componente['tipo']) ?>
                </span>
            </div>
            <div>
                <span class="badge <?= $componente['seccion'] == 'motor' ? 'badge-motor' : ($componente['seccion'] == 'tren rodante' ? 'badge-tren' : 'badge-otros') ?>">
                    <?= ucfirst($componente['seccion']) ?>
                </span>
            </div>
            <div class="text-muted" style="font-size:0.85rem">
                Vencimiento del accesorio:
                <?php if ($vencidoComp): ?>
                    <span class="text-danger fw-semibold"><i class="bi bi-x-circle me-1"></i><?= date('d/m/Y', strtotime($componente['fecha_vencimiento'])) ?></span>
                <?php elseif ($proximoComp): ?>
                    <span class="text-warning fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i><?= date('d/m/Y', strtotime($componente['fecha_vencimiento'])) ?></span>
                <?php else: ?>
                    <span class="text-success"><?= date('d/m/Y', strtotime($componente['fecha_vencimiento'])) ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de certificados -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-patch-check me-2"></i>Certificados del Accesorio</span>
        <a href="<?= base_url('certificados/nuevo/'.$id_componente) ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Certificado
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($certificados)): ?>
            <div class="text-center text-muted py-4">
                <i class="bi bi-patch-check fs-1 d-block mb-2"></i>
                No hay certificados registrados para este accesorio.
                <div class="mt-3">
                    <a href="<?= base_url('certificados/nuevo/'.$id_componente) ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Registrar primer certificado
                    </a>
                </div>
            </div>
        <?php else: ?>
        <table class="table table-hover datatable w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>N° Certificado</th>
                    <th>Entidad Certificadora</th>
                    <th>Emision</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificados as $cert): ?>
                <?php
                    $venc    = new DateTime($cert['fecha_vencimiento']);
                    $diff    = (int)$hoyObj->diff($venc)->days;
                    $vencido = $venc < $hoyObj;
                    $proximo = !$vencido && $diff <= 30;
                ?>
                <tr>
                    <td><?= $cert['id_certificado'] ?></td>
                    <td><span class="fw-semibold"><?= esc($cert['numero_certificado']) ?></span></td>
                    <td><?= esc($cert['entidad_certificadora']) ?></td>
                    <td><?= date('d/m/Y', strtotime($cert['fecha_emision'])) ?></td>
                    <td>
                        <?php if ($vencido): ?>
                            <span class="text-danger fw-semibold">
                                <i class="bi bi-x-circle me-1"></i><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?>
                            </span>
                        <?php elseif ($proximo): ?>
                            <span class="text-warning fw-semibold">
                                <i class="bi bi-exclamation-triangle me-1"></i><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-success">
                                <i class="bi bi-check-circle me-1"></i><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($vencido): ?>
                            <span class="badge bg-danger">Vencido</span>
                        <?php elseif ($proximo): ?>
                            <span class="badge bg-warning text-dark">Por vencer</span>
                        <?php else: ?>
                            <span class="badge bg-success">Vigente</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($cert['observaciones']): ?>
                            <span title="<?= esc($cert['observaciones']) ?>" style="cursor:help">
                                <i class="bi bi-chat-text text-muted"></i>
                            </span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('certificados/editar/'.$cert['id_certificado']) ?>"
                           class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= base_url('certificados/eliminar/'.$cert['id_certificado']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           title="Eliminar"
                           onclick="return confirm('Eliminar este certificado?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
