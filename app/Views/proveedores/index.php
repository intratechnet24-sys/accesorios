<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-building me-2"></i>Proveedores</span>
        <a href="<?= base_url('proveedores/nuevo') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Proveedor
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Razon Social</th>
                    <th>CUIT / CUIL / DNI</th>
                    <th>Telefono</th>
                    <th>Contacto</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $p): ?>
                <tr>
                    <td><?= $p['id_proveedor'] ?></td>
                    <td class="fw-semibold"><?= esc($p['razon_social']) ?></td>
                    <td><?= esc($p['cuit_cuil_dni'] ?? '—') ?></td>
                    <td><?= !empty($p['telefono']) ? esc($p['telefono']) : '<span class="text-muted">—</span>' ?></td>
                    <td>
                        <?php
                            $wa  = preg_replace('/\D/', '', $p['whatsapp'] ?? '');
                            $mail = trim($p['email'] ?? '');
                        ?>
                        <?php if ($wa): ?>
                            <a href="https://wa.me/<?= $wa ?>" target="_blank"
                               class="btn btn-sm btn-success me-1" title="Enviar WhatsApp a <?= esc($p['razon_social']) ?>">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        <?php else: ?>
                            <span class="btn btn-sm btn-outline-secondary disabled me-1" title="Sin WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </span>
                        <?php endif; ?>
                        <?php if ($mail): ?>
                            <a href="mailto:<?= esc($mail) ?>"
                               class="btn btn-sm btn-primary" title="Enviar email a <?= esc($mail) ?>">
                                <i class="bi bi-envelope"></i>
                            </a>
                        <?php else: ?>
                            <span class="btn btn-sm btn-outline-secondary disabled" title="Sin email">
                                <i class="bi bi-envelope"></i>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($p['localidad'] ?? '—') ?></td>
                    <td><?= esc($p['provincia'] ?? '—') ?></td>
                    <td>
                        <a href="<?= base_url('proveedores/editar/'.$p['id_proveedor']) ?>"
                           class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= base_url('proveedores/eliminar/'.$p['id_proveedor']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Eliminar proveedor <?= esc($p['razon_social']) ?>?')"
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

<?= $this->endSection() ?>
