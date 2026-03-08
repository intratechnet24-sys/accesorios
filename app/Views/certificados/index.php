<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-patch-check me-2"></i>Certificados de Vigencia</span>
        <a href="<?= base_url('certificados/nuevo') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Certificado
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>N° Certificado</th>
                    <th>Accesorio</th>
                    <th>Equipo</th>
                    <th>Entidad Certificadora</th>
                    <th>Emision</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificados as $cert): ?>
                <?php
                    $hoy     = new DateTime();
                    $venc    = new DateTime($cert['fecha_vencimiento']);
                    $diff    = (int)$hoy->diff($venc)->days;
                    $vencido = $venc < $hoy;
                    $proximo = !$vencido && $diff <= 30;
                ?>
                <tr>
                    <td><?= $cert['id_certificado'] ?></td>
                    <td><span class="fw-semibold"><?= esc($cert['numero_certificado']) ?></span></td>
                    <td>
                        <span class="badge <?= $cert['tipo'] == 'baterias' ? 'badge-baterias' : 'badge-cubiertas' ?>">
                            <?= ucfirst($cert['tipo']) ?>
                        </span>
                        <div class="text-muted" style="font-size:0.78rem"><?= ucfirst($cert['seccion']) ?></div>
                    </td>
                    <td>
                        <a href="<?= base_url('equipos/ver/'.$cert['id_equipo'] ?? '#') ?>" class="text-decoration-none fw-semibold">
                            <?= esc($cert['codigo']) ?>
                        </a>
                        <div class="text-muted" style="font-size:0.78rem"><?= esc($cert['marca']) ?> <?= esc($cert['modelo']) ?></div>
                    </td>
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
                        <?php $ndocs = $conteo_docs[$cert['id_certificado']] ?? 0; ?>
                        <a href="<?= base_url('certificados/documentos/'.$cert['id_certificado']) ?>"
                           class="btn btn-sm btn-outline-danger position-relative" title="Documentos PDF adjuntos">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <?php if ($ndocs > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  style="font-size:0.6rem">
                                <?= $ndocs ?>
                            </span>
                            <?php endif; ?>
                        </a>
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
    </div>
</div>

<?= $this->endSection() ?>
