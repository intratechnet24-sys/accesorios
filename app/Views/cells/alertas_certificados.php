<?php
$total = count($vencidos) + count($proximos);
?>

<div class="dropdown me-3">
    <button class="btn btn-sm position-relative" id="btnCampanita" data-bs-toggle="dropdown" aria-expanded="false"
            style="background:none; border:none; padding:0.3rem 0.5rem;">
        <i class="bi bi-bell-fill fs-5 <?= $total > 0 ? 'text-warning' : 'text-muted' ?>"></i>
        <?php if ($total > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              style="font-size:0.65rem">
            <?= $total ?>
        </span>
        <?php endif; ?>
    </button>

    <div class="dropdown-menu dropdown-menu-end shadow" style="min-width:340px; max-height:420px; overflow-y:auto;">
        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-semibold" style="font-size:0.9rem">
                <i class="bi bi-bell me-1"></i>Alertas de Certificados
            </span>
            <a href="<?= base_url('certificados') ?>" class="text-decoration-none" style="font-size:0.78rem">Ver todos</a>
        </div>

        <?php if ($total === 0): ?>
            <div class="text-center text-muted py-4" style="font-size:0.85rem">
                <i class="bi bi-check-circle text-success d-block fs-4 mb-1"></i>
                Sin alertas pendientes
            </div>
        <?php endif; ?>

        <?php if (!empty($vencidos)): ?>
        <div class="px-3 pt-2 pb-1" style="font-size:0.72rem;color:#b91c1c;text-transform:uppercase;letter-spacing:1px;font-weight:600">
            Vencidos (<?= count($vencidos) ?>)
        </div>
        <?php foreach ($vencidos as $v): ?>
        <a href="<?= base_url('certificados/editar/'.$v['id_certificado']) ?>"
           class="dropdown-item py-2 px-3 border-bottom" style="font-size:0.83rem">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <i class="bi bi-x-circle-fill text-danger me-1"></i>
                    <strong><?= esc($v['codigo']) ?></strong> — <?= ucfirst($v['tipo']) ?>
                    <div class="text-muted" style="font-size:0.76rem"><?= esc($v['numero_certificado']) ?> | <?= esc($v['entidad_certificadora']) ?></div>
                </div>
                <span class="badge bg-danger ms-2 text-nowrap"><?= date('d/m/Y', strtotime($v['fecha_vencimiento'])) ?></span>
            </div>
        </a>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($proximos)): ?>
        <div class="px-3 pt-2 pb-1" style="font-size:0.72rem;color:#b45309;text-transform:uppercase;letter-spacing:1px;font-weight:600">
            Por vencer en 30 dias (<?= count($proximos) ?>)
        </div>
        <?php foreach ($proximos as $p): ?>
        <a href="<?= base_url('certificados/editar/'.$p['id_certificado']) ?>"
           class="dropdown-item py-2 px-3 border-bottom" style="font-size:0.83rem">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                    <strong><?= esc($p['codigo']) ?></strong> — <?= ucfirst($p['tipo']) ?>
                    <div class="text-muted" style="font-size:0.76rem"><?= esc($p['numero_certificado']) ?> | <?= esc($p['entidad_certificadora']) ?></div>
                </div>
                <span class="badge bg-warning text-dark ms-2 text-nowrap"><?= date('d/m/Y', strtotime($p['fecha_vencimiento'])) ?></span>
            </div>
        </a>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
