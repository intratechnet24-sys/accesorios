<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1a3a5c,#2563eb)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size:0.8rem;opacity:0.8">Equipos Activos</div>
                    <div style="font-size:2rem;font-weight:700"><?= $total_equipos ?></div>
                </div>
                <i class="bi bi-truck" style="font-size:2.5rem;opacity:0.3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#15803d,#22c55e)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size:0.8rem;opacity:0.8">Total Accesorios</div>
                    <div style="font-size:2rem;font-weight:700"><?= $total_accesorios ?></div>
                </div>
                <i class="bi bi-gear-wide-connected" style="font-size:2.5rem;opacity:0.3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#6d28d9,#a78bfa)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size:0.8rem;opacity:0.8">Certificados</div>
                    <div style="font-size:2rem;font-weight:700"><?= $total_certificados ?></div>
                </div>
                <i class="bi bi-patch-check" style="font-size:2.5rem;opacity:0.3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php $alertas_total = count($cert_vencidos) + count($cert_proximos); ?>
        <div class="stat-card" style="background: linear-gradient(135deg,<?= $alertas_total > 0 ? '#991b1b,#ef4444' : '#b45309,#f59e0b' ?>)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size:0.8rem;opacity:0.8">Alertas Certificados</div>
                    <div style="font-size:2rem;font-weight:700"><?= $alertas_total ?></div>
                </div>
                <i class="bi bi-bell<?= $alertas_total > 0 ? '-fill' : '' ?>" style="font-size:2.5rem;opacity:0.3"></i>
            </div>
        </div>
    </div>
</div>

<!-- Fila principal -->
<div class="row g-3 mb-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-truck me-2 text-primary"></i>Ultimos Equipos</span>
                <a href="<?= base_url('equipos/nuevo') ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Nuevo
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Marca</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimos_equipos as $eq): ?>
                        <tr>
                            <td><a href="<?= base_url('equipos/ver/'.$eq['id_equipo']) ?>" class="fw-semibold text-decoration-none"><?= esc($eq['codigo']) ?></a></td>
                            <td><?= esc($eq['descripcion']) ?></td>
                            <td><?= esc($eq['marca']) ?></td>
                            <td>
                                <?php if ($eq['estado']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($ultimos_equipos)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-3">Sin equipos registrados</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-exclamation-triangle text-warning me-2"></i>Vencimientos Accesorios (30 dias)
            </div>
            <div class="card-body p-0">
                <?php if (empty($vencimientos)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle text-success" style="font-size:2rem"></i>
                        <p class="mt-2 mb-0">Sin vencimientos proximos</p>
                    </div>
                <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($vencimientos as $v): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold" style="font-size:0.88rem"><?= esc($v['codigo']) ?> — <?= esc($v['tipo']) ?></div>
                            <small class="text-muted"><?= esc($v['seccion']) ?></small>
                        </div>
                        <span class="badge bg-warning text-dark"><?= date('d/m/Y', strtotime($v['fecha_vencimiento'])) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Alertas de Certificados -->
<div class="row g-3">
    <!-- Certificados Vencidos -->
    <div class="col-lg-6">
        <div class="card border-0" style="border-left: 4px solid #ef4444 !important; box-shadow: 0 1px 4px rgba(0,0,0,0.07);">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-left: 4px solid #ef4444;">
                <span>
                    <i class="bi bi-x-circle-fill text-danger me-2"></i>
                    Certificados Vencidos
                    <?php if (!empty($cert_vencidos)): ?>
                        <span class="badge bg-danger ms-1"><?= count($cert_vencidos) ?></span>
                    <?php endif; ?>
                </span>
                <a href="<?= base_url('certificados') ?>" class="btn btn-sm btn-outline-danger">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($cert_vencidos)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle text-success" style="font-size:2rem"></i>
                        <p class="mt-2 mb-0" style="font-size:0.88rem">Sin certificados vencidos</p>
                    </div>
                <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($cert_vencidos as $cv): ?>
                    <li class="list-group-item px-3 py-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold" style="font-size:0.87rem">
                                    <i class="bi bi-x-circle-fill text-danger me-1"></i>
                                    <?= esc($cv['codigo']) ?> — <?= ucfirst($cv['tipo']) ?>
                                </div>
                                <small class="text-muted"><?= esc($cv['numero_certificado']) ?> | <?= esc($cv['entidad_certificadora']) ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger"><?= date('d/m/Y', strtotime($cv['fecha_vencimiento'])) ?></span>
                                <div>
                                    <a href="<?= base_url('certificados/editar/'.$cv['id_certificado']) ?>"
                                       class="text-decoration-none" style="font-size:0.75rem">Renovar</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Certificados por vencer -->
    <div class="col-lg-6">
        <div class="card border-0" style="box-shadow: 0 1px 4px rgba(0,0,0,0.07);">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-left: 4px solid #f59e0b;">
                <span>
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Por Vencer (30 dias)
                    <?php if (!empty($cert_proximos)): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= count($cert_proximos) ?></span>
                    <?php endif; ?>
                </span>
                <a href="<?= base_url('certificados') ?>" class="btn btn-sm btn-outline-warning">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($cert_proximos)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle text-success" style="font-size:2rem"></i>
                        <p class="mt-2 mb-0" style="font-size:0.88rem">Sin certificados por vencer</p>
                    </div>
                <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($cert_proximos as $cp): ?>
                    <?php
                        $diasRest = (int)(new DateTime())->diff(new DateTime($cp['fecha_vencimiento']))->days;
                    ?>
                    <li class="list-group-item px-3 py-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold" style="font-size:0.87rem">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                                    <?= esc($cp['codigo']) ?> — <?= ucfirst($cp['tipo']) ?>
                                </div>
                                <small class="text-muted"><?= esc($cp['numero_certificado']) ?> | <?= esc($cp['entidad_certificadora']) ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning text-dark"><?= date('d/m/Y', strtotime($cp['fecha_vencimiento'])) ?></span>
                                <div style="font-size:0.75rem" class="text-muted"><?= $diasRest ?> dias restantes</div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
