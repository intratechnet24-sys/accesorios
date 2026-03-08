<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'Sistema') ?> | GestiónAccesorios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 240px;
            --primary: #1a3a5c;
            --accent: #e8a020;
        }
        body { background: #f0f4f8; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--primary);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h5 {
            color: var(--accent);
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .sidebar-brand small { color: rgba(255,255,255,0.5); font-size: 0.72rem; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section {
            padding: 0.4rem 1.2rem;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 0.5rem;
        }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 0.55rem 1.2rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--accent);
        }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar h4 { margin: 0; font-size: 1.1rem; font-weight: 600; color: #1e293b; }
        .content-area { padding: 1.5rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: #14304f; border-color: #14304f; }
        .btn-warning { background: var(--accent); border-color: var(--accent); color: #fff; }
        .badge-baterias { background: #dbeafe; color: #1d4ed8; }
        .badge-cubiertas { background: #dcfce7; color: #15803d; }
        .badge-motor { background: #fef3c7; color: #b45309; }
        .badge-tren { background: #ede9fe; color: #7c3aed; }
        .badge-otros { background: #f1f5f9; color: #475569; }
        .stat-card { border-radius: 12px; padding: 1.2rem 1.5rem; color: #fff; }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-tools me-2"></i>GestAccesorios</h5>
        <small>Sistema de Gestión</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Principal</div>
        <a href="<?= base_url('/') ?>" class="nav-link <?= (current_url() == base_url('/')) ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-section">Gestión</div>
        <a href="<?= base_url('equipos') ?>" class="nav-link <?= (strpos(current_url(), 'equipos') !== false) ? 'active' : '' ?>">
            <i class="bi bi-truck"></i> Vehículos / Equipos
        </a>
        <a href="<?= base_url('componentes') ?>" class="nav-link <?= (strpos(current_url(), 'componentes') !== false) ? 'active' : '' ?>">
            <i class="bi bi-gear-wide-connected"></i> Accesorios
        </a>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <h4><i class="bi bi-chevron-right me-2 text-muted" style="font-size:0.8rem"></i><?= esc($titulo ?? '') ?></h4>
        <span class="text-muted" style="font-size:0.82rem"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y') ?></span>
    </div>
    <div class="content-area">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true
            });
        }
    });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
