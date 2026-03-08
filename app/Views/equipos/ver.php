<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-3">
    <a href="<?= base_url('equipos') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver al listado
    </a>
</div>

<div class="row g-3 mb-3">
    <!-- Datos del equipo -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Datos del Equipo</div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:0.88rem">
                    <tr><th class="text-muted" style="width:45%">Codigo</th><td><strong><?= esc($equipo['codigo']) ?></strong></td></tr>
                    <?php if (!empty($equipo['dominio'])): ?>
                    <tr><th class="text-muted">Dominio / Patente</th><td><strong><?= esc($equipo['dominio']) ?></strong></td></tr>
                    <?php endif; ?>
                    <?php if (!empty($equipo['numero_serie'])): ?>
                    <tr><th class="text-muted">N° de Serie</th><td><?= esc($equipo['numero_serie']) ?></td></tr>
                    <?php endif; ?>
                    <tr><th class="text-muted">Descripcion</th><td><?= esc($equipo['descripcion']) ?></td></tr>
                    <tr><th class="text-muted">Marca</th><td><?= esc($equipo['marca']) ?></td></tr>
                    <tr><th class="text-muted">Modelo</th><td><?= esc($equipo['modelo']) ?></td></tr>
                    <?php if (!empty($equipo['fecha_ingreso'])): ?>
                    <tr><th class="text-muted">Fecha Ingreso</th><td><?= date('d/m/Y', strtotime($equipo['fecha_ingreso'])) ?></td></tr>
                    <?php endif; ?>
                    <?php if (!empty($equipo['fecha_garantia'])): ?>
                    <tr>
                        <th class="text-muted">Garantia hasta</th>
                        <td>
                            <?php
                                $hoyG = new DateTime();
                                $gDate = new DateTime($equipo['fecha_garantia']);
                                $garVencida = $gDate < $hoyG;
                            ?>
                            <span class="<?= $garVencida ? 'text-danger' : 'text-success' ?> fw-semibold">
                                <i class="bi bi-<?= $garVencida ? 'x' : 'check' ?>-circle me-1"></i>
                                <?= date('d/m/Y', strtotime($equipo['fecha_garantia'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th class="text-muted">Estado</th>
                        <td>
                            <?php if ($equipo['estado']): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr><th class="text-muted">Fecha Alta</th><td><?= date('d/m/Y H:i', strtotime($equipo['fecha_alta'])) ?></td></tr>
                    <?php if (!empty($equipo['descripcion_tecnica'])): ?>
                    <tr>
                        <th class="text-muted">Desc. Tecnica</th>
                        <td style="font-size:0.82rem"><?= nl2br(esc($equipo['descripcion_tecnica'])) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
                <hr>
                <a href="<?= base_url('equipos/editar/'.$equipo['id_equipo']) ?>" class="btn btn-warning btn-sm w-100">
                    <i class="bi bi-pencil me-1"></i>Editar Equipo
                </a>
            </div>
        </div>
    </div>

    <!-- Estadisticas rapidas -->
    <div class="col-lg-8">
        <?php
            $hoyObj = new DateTime();
            $totalComp = count($componentes);
            $vencidosComp = 0; $totalCerts = 0; $certsVenc = 0;
            foreach ($componentes as $c) {
                $v = new DateTime($c['fecha_vencimiento']);
                if ($v < $hoyObj) $vencidosComp++;
                $certs = $certificadosPorComponente[$c['id_componente']] ?? [];
                $totalCerts += count($certs);
                foreach ($certs as $cert) {
                    $vc = new DateTime($cert['fecha_vencimiento']);
                    if ($vc < $hoyObj) $certsVenc++;
                }
            }
        ?>
        <div class="row g-2 mb-3">
            <div class="col-6 col-md-3">
                <div class="stat-card text-center py-3" style="background:linear-gradient(135deg,#1a3a5c,#2563eb)">
                    <div style="font-size:1.8rem;font-weight:700"><?= $totalComp ?></div>
                    <div style="font-size:0.75rem;opacity:0.8">Accesorios</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center py-3" style="background:linear-gradient(135deg,<?= $vencidosComp > 0 ? '#991b1b,#ef4444' : '#15803d,#22c55e' ?>)">
                    <div style="font-size:1.8rem;font-weight:700"><?= $vencidosComp ?></div>
                    <div style="font-size:0.75rem;opacity:0.8">Acc. Vencidos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center py-3" style="background:linear-gradient(135deg,#6d28d9,#a78bfa)">
                    <div style="font-size:1.8rem;font-weight:700"><?= $totalCerts ?></div>
                    <div style="font-size:0.75rem;opacity:0.8">Certificados</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center py-3" style="background:linear-gradient(135deg,<?= $certsVenc > 0 ? '#991b1b,#ef4444' : '#b45309,#f59e0b' ?>)">
                    <div style="font-size:1.8rem;font-weight:700"><?= $certsVenc ?></div>
                    <div style="font-size:0.75rem;opacity:0.8">Cert. Vencidos</div>
                </div>
            </div>
        </div>

        <!-- Accesorios en acordion -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-gear-wide-connected me-2"></i>Accesorios del Equipo</span>
                <a href="<?= base_url('componentes/nuevo/'.$equipo['id_equipo']) ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Agregar Accesorio
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($componentes)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-gear-wide-connected fs-1 d-block mb-2"></i>
                        Sin accesorios registrados.
                        <div class="mt-2">
                            <a href="<?= base_url('componentes/nuevo/'.$equipo['id_equipo']) ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Agregar primero
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                <div class="accordion accordion-flush" id="accordionAccesorios">
                <?php foreach ($componentes as $idx => $c): ?>
                <?php
                    $venc    = new DateTime($c['fecha_vencimiento']);
                    $diff    = (int)$hoyObj->diff($venc)->days;
                    $vencido = $venc < $hoyObj;
                    $proximo = !$vencido && $diff <= 30;
                    $certs   = $certificadosPorComponente[$c['id_componente']] ?? [];
                    $certVencCnt = 0; $certProxCnt = 0;
                    foreach ($certs as $cert) {
                        $vc = new DateTime($cert['fecha_vencimiento']);
                        $dv = (int)$hoyObj->diff($vc)->days;
                        if ($vc < $hoyObj) $certVencCnt++;
                        elseif ($dv <= 30) $certProxCnt++;
                    }
                ?>
                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button <?= $idx > 0 ? 'collapsed' : '' ?> py-2 px-3"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#acc<?= $c['id_componente'] ?>">
                            <div class="d-flex align-items-center gap-2 w-100 flex-wrap">
                                <span class="badge <?= $c['tipo'] == 'baterias' ? 'badge-baterias' : 'badge-cubiertas' ?>">
                                    <?= ucfirst($c['tipo']) ?>
                                </span>
                                <span class="badge <?= $c['seccion'] == 'motor' ? 'badge-motor' : ($c['seccion'] == 'tren rodante' ? 'badge-tren' : 'badge-otros') ?>">
                                    <?= ucfirst($c['seccion']) ?>
                                </span>
                                <span class="ms-auto me-3" style="font-size:0.82rem">
                                    Acc. vence:
                                    <?php if ($vencido): ?>
                                        <span class="text-danger fw-semibold"><i class="bi bi-x-circle me-1"></i><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                                    <?php elseif ($proximo): ?>
                                        <span class="text-warning fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                                    <?php else: ?>
                                        <span class="text-success"><?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></span>
                                    <?php endif; ?>
                                </span>
                                <?php if ($certVencCnt > 0): ?>
                                    <span class="badge bg-danger"><i class="bi bi-patch-check me-1"></i><?= $certVencCnt ?> cert. vencido<?= $certVencCnt > 1 ? 's' : '' ?></span>
                                <?php elseif ($certProxCnt > 0): ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-patch-check me-1"></i><?= $certProxCnt ?> por vencer</span>
                                <?php elseif (count($certs) > 0): ?>
                                    <span class="badge bg-success"><i class="bi bi-patch-check me-1"></i><?= count($certs) ?> cert.</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="bi bi-patch-check me-1"></i>Sin cert.</span>
                                <?php endif; ?>
                            </div>
                        </button>
                    </h2>
                    <div id="acc<?= $c['id_componente'] ?>"
                         class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>"
                         data-bs-parent="#accordionAccesorios">
                        <div class="accordion-body p-3 bg-light">
                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                <a href="<?= base_url('componentes/editar/'.$c['id_componente']) ?>"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil me-1"></i>Editar Accesorio
                                </a>
                                <a href="<?= base_url('certificados/nuevo/'.$c['id_componente']) ?>"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-plus-circle me-1"></i>Nuevo Certificado
                                </a>
                                <a href="<?= base_url('certificados/componente/'.$c['id_componente']) ?>"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-patch-check me-1"></i>Ver todos los cert.
                                </a>
                                <a href="<?= base_url('componentes/eliminar/'.$c['id_componente']) ?>"
                                   class="btn btn-sm btn-outline-danger ms-auto"
                                   onclick="return confirm('Eliminar este accesorio y sus certificados?')">
                                    <i class="bi bi-trash me-1"></i>Eliminar
                                </a>
                            </div>

                            <div class="fw-semibold mb-2" style="font-size:0.85rem">
                                <i class="bi bi-patch-check me-1 text-primary"></i>Certificados de Vigencia
                            </div>

                            <?php if (empty($certs)): ?>
                                <div class="text-muted" style="font-size:0.83rem">
                                    <i class="bi bi-info-circle me-1"></i>Sin certificados.
                                    <a href="<?= base_url('certificados/nuevo/'.$c['id_componente']) ?>">Registrar ahora</a>
                                </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered bg-white mb-0" style="font-size:0.82rem">
                                    <thead class="table-light">
                                        <tr>
                                            <th>N° Certificado</th>
                                            <th>Entidad Certificadora</th>
                                            <th>Emision</th>
                                            <th>Vencimiento</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($certs as $cert): ?>
                                    <?php
                                        $vc  = new DateTime($cert['fecha_vencimiento']);
                                        $dvc = (int)$hoyObj->diff($vc)->days;
                                        $cV  = $vc < $hoyObj;
                                        $cP  = !$cV && $dvc <= 30;
                                    ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($cert['numero_certificado']) ?></td>
                                        <td><?= esc($cert['entidad_certificadora']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($cert['fecha_emision'])) ?></td>
                                        <td>
                                            <?php if ($cV): ?>
                                                <span class="text-danger fw-semibold">
                                                    <i class="bi bi-x-circle me-1"></i><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?>
                                                </span>
                                            <?php elseif ($cP): ?>
                                                <span class="text-warning fw-semibold">
                                                    <i class="bi bi-exclamation-triangle me-1"></i><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-success"><?= date('d/m/Y', strtotime($cert['fecha_vencimiento'])) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($cV): ?>
                                                <span class="badge bg-danger">Vencido</span>
                                            <?php elseif ($cP): ?>
                                                <span class="badge bg-warning text-dark">Por vencer</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Vigente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="<?= base_url('certificados/editar/'.$cert['id_certificado']) ?>"
                                               class="btn btn-sm btn-outline-warning py-0 px-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('certificados/eliminar/'.$cert['id_certificado']) ?>"
                                               class="btn btn-sm btn-outline-danger py-0 px-1" title="Eliminar"
                                               onclick="return confirm('Eliminar certificado?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
