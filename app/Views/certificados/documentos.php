<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $total = count($documentos); ?>

<div class="row g-3">

    <!-- Info del certificado -->
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div>
                        <div class="text-muted" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Certificado</div>
                        <div class="fw-bold fs-6"><?= esc($certificado['numero_certificado']) ?></div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="text-muted" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Entidad</div>
                        <div><?= esc($certificado['entidad_certificadora']) ?></div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="text-muted" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Vencimiento</div>
                        <div><?= date('d/m/Y', strtotime($certificado['fecha_vencimiento'])) ?></div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="text-muted" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">Documentos</div>
                        <div>
                            <span class="badge <?= $total >= $max_docs ? 'bg-danger' : 'bg-primary' ?> fs-6">
                                <?= $total ?> / <?= $max_docs ?>
                            </span>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('certificados') ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Volver a Certificados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de subida -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-cloud-upload me-2"></i>Subir Documento PDF
            </div>
            <div class="card-body">
                <?php if ($total >= $max_docs): ?>
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Se alcanzó el límite de <strong><?= $max_docs ?></strong> documentos. Eliminá uno para poder subir otro.
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('certificados/subir-documento/' . $certificado['id_certificado']) ?>"
                          method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Archivo PDF <span class="text-danger">*</span></label>
                            <input type="file" name="pdf" class="form-control" accept=".pdf,application/pdf" required>
                            <div class="form-text">Solo PDF. Tamaño máximo: 10 MB.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i>Subir documento
                            </button>
                        </div>
                    </form>
                    <div class="mt-3 text-muted" style="font-size:0.8rem">
                        Podés subir hasta <?= $max_docs ?> documentos por certificado.
                        Quedan <strong><?= $max_docs - $total ?></strong> lugar(es) disponible(s).
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Listado de documentos -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Documentos Adjuntos
            </div>
            <div class="card-body">
                <?php if (empty($documentos)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-file-earmark-pdf" style="font-size:3rem;opacity:0.3"></i>
                        <p class="mt-2">No hay documentos adjuntos todavía.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($documentos as $i => $doc): ?>
                        <?php
                            $kb = round($doc['tamanio'] / 1024, 1);
                            $mb = $doc['tamanio'] >= 1048576 ? round($doc['tamanio'] / 1048576, 2) . ' MB' : $kb . ' KB';
                        ?>
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-danger flex-shrink-0" style="font-size:2rem">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate" title="<?= esc($doc['nombre_original']) ?>">
                                        <?= esc($doc['nombre_original']) ?>
                                    </div>
                                    <div class="text-muted" style="font-size:0.78rem">
                                        <i class="bi bi-hdd me-1"></i><?= $mb ?>
                                        &nbsp;·&nbsp;
                                        <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y H:i', strtotime($doc['created_at'])) ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 flex-shrink-0">
                                    <a href="<?= base_url('certificados/ver-documento/' . $doc['id_documento']) ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Ver / Abrir PDF">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('certificados/ver-documento/' . $doc['id_documento']) ?>"
                                       download="<?= esc($doc['nombre_original']) ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Descargar">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <a href="<?= base_url('certificados/eliminar-documento/' . $doc['id_documento']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Eliminar documento"
                                       onclick="return confirm('Eliminar el documento \'<?= esc($doc['nombre_original']) ?>\'?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
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
