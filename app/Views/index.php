<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .dropdown-toggle::after { display: none; }
        .acciones-btn { cursor: pointer; font-size: 1.2rem; line-height: 1; }
    </style>
</head>
<body class="p-4 bg-light">

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">⚙️ Gestión de Equipos</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEquipo">
            + Nuevo Equipo
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tablaEquipos" class="table table-hover table-bordered w-100">
                <thead class="table-dark">
                    <tr>
                        <th width="60">Acciones</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Fecha Alta</th>
                        <th>Componentes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipos as $eq): ?>
                    <tr>
                        <!-- Menú tres puntos -->
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border acciones-btn"
                                        data-bs-toggle="dropdown">
                                    &#8942;
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <?php if ($eq['estado'] == 1): ?>
                                    <li>
                                        <a class="dropdown-item text-danger btn-toggle"
                                           href="#"
                                           data-id="<?= $eq['id_equipo'] ?>"
                                           data-estado="1">
                                            🔴 Desactivar
                                        </a>
                                    </li>
                                    <?php else: ?>
                                    <li>
                                        <a class="dropdown-item text-success btn-toggle"
                                           href="#"
                                           data-id="<?= $eq['id_equipo'] ?>"
                                           data-estado="0">
                                            🟢 Activar
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                        <td><?= esc($eq['codigo']) ?></td>
                        <td><?= esc($eq['descripcion']) ?></td>
                        <td><?= esc($eq['marca']) ?></td>
                        <td><?= esc($eq['modelo']) ?></td>
                        <td>
                            <span class="badge bg-<?= $eq['estado'] == 1 ? 'success' : 'secondary' ?>">
                                <?= $eq['estado'] == 1 ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($eq['fecha_alta'])) ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-info btn-componentes"
                                    data-id="<?= $eq['id_equipo'] ?>"
                                    data-codigo="<?= esc($eq['codigo']) ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalComponentes">
                                📦 Ver / Cargar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================================================ -->
<!-- MODAL NUEVO EQUIPO                               -->
<!-- ================================================ -->
<div class="modal fade" id="modalEquipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="erroresEquipo" class="alert alert-danger d-none"></div>
                <div class="mb-3">
                    <label class="form-label">Código <span class="text-danger">*</span></label>
                    <input type="text" id="eq_codigo" class="form-control" placeholder="Ej: EQ-001">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" id="eq_descripcion" class="form-control" placeholder="Descripción del equipo">
                </div>
                <div class="mb-3">
                    <label class="form-label">Marca</label>
                    <input type="text" id="eq_marca" class="form-control" placeholder="Ej: Caterpillar">
                </div>
                <div class="mb-3">
                    <label class="form-label">Modelo</label>
                    <input type="text" id="eq_modelo" class="form-control" placeholder="Ej: 320D">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnGuardarEquipo">💾 Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================ -->
<!-- MODAL COMPONENTES                                -->
<!-- ================================================ -->
<div class="modal fade" id="modalComponentes" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    📦 Componentes del Equipo: <span id="tituloEquipo" class="fw-bold"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Formulario agregar componente -->
                <div class="card mb-4 border-info">
                    <div class="card-header bg-light fw-bold">➕ Agregar Componente</div>
                    <div class="card-body">
                        <div id="erroresComponente" class="alert alert-danger d-none"></div>
                        <input type="hidden" id="comp_id_equipo">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select id="comp_tipo" class="form-select">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="baterias">Baterías</option>
                                    <option value="cubiertas">Cubiertas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sección <span class="text-danger">*</span></label>
                                <select id="comp_seccion" class="form-select">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="motor">Motor</option>
                                    <option value="tren rodante">Tren Rodante</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" id="comp_fecha_venc" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-info w-100 text-white" id="btnGuardarComponente">
                                    + Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla componentes -->
                <table id="tablaComponentes" class="table table-sm table-bordered w-100">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Sección</th>
                            <th>Fecha Alta</th>
                            <th>Fecha Vencimiento</th>
                        </tr>
                    </thead>
                    <tbody id="bodyComponentes">
                        <tr>
                            <td colspan="5" class="text-center text-muted">Seleccioná un equipo para ver sus componentes</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- ================================================ -->
<!-- SCRIPTS                                          -->
<!-- ================================================ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
const BASE_URL = '<?= base_url() ?>';

$(document).ready(function () {

    // ── Inicializar DataTable ────────────────────────
    $('#tablaEquipos').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        order: [[6, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 7] }
        ]
    });

    // ── GUARDAR EQUIPO ───────────────────────────────
    $('#btnGuardarEquipo').on('click', function () {
        $('#erroresEquipo').addClass('d-none');

        const data = {
            codigo:      $('#eq_codigo').val().trim(),
            descripcion: $('#eq_descripcion').val().trim(),
            marca:       $('#eq_marca').val().trim(),
            modelo:      $('#eq_modelo').val().trim(),
        };

        $.ajax({
            url:         BASE_URL + 'equipos/store',
            method:      'POST',
            contentType: 'application/json',
            data:        JSON.stringify(data),
            success: function (res) {
                if (res.success) {
                    $('#modalEquipo').modal('hide');
                    location.reload();
                } else {
                    mostrarErrores('#erroresEquipo', res.errors);
                }
            },
            error: function () {
                alert('Error al conectar con el servidor.');
            }
        });
    });

    // ── TOGGLE ESTADO (Activar/Desactivar) ───────────
    $(document).on('click', '.btn-toggle', function (e) {
        e.preventDefault();
        const id     = $(this).data('id');
        const estado = $(this).data('estado');
        const accion = estado == 1 ? 'desactivar' : 'activar';

        if (!confirm(`¿Desea ${accion} este equipo?`)) return;

        $.ajax({
            url:    BASE_URL + `equipos/toggle/${id}`,
            method: 'POST',
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert('No se pudo actualizar el estado.');
                }
            }
        });
    });

    // ── ABRIR MODAL COMPONENTES ──────────────────────
    $(document).on('click', '.btn-componentes', function () {
        const idEquipo = $(this).data('id');
        const codigo   = $(this).data('codigo');

        $('#comp_id_equipo').val(idEquipo);
        $('#tituloEquipo').text(codigo);
        $('#erroresComponente').addClass('d-none');
        cargarComponentes(idEquipo);
    });

    // ── GUARDAR COMPONENTE ───────────────────────────
    $('#btnGuardarComponente').on('click', function () {
        $('#erroresComponente').addClass('d-none');

        const data = {
            id_equipo:         parseInt($('#comp_id_equipo').val()),
            tipo:              $('#comp_tipo').val(),
            seccion:           $('#comp_seccion').val(),
            fecha_vencimiento: $('#comp_fecha_venc').val(),
        };

        $.ajax({
            url:         BASE_URL + 'equipos/componente/store',
            method:      'POST',
            contentType: 'application/json',
            data:        JSON.stringify(data),
            success: function (res) {
                if (res.success) {
                    // Limpiar formulario
                    $('#comp_tipo, #comp_seccion, #comp_fecha_venc').val('');
                    cargarComponentes($('#comp_id_equipo').val());
                } else {
                    mostrarErrores('#erroresComponente', res.errors);
                }
            },
            error: function () {
                alert('Error al conectar con el servidor.');
            }
        });
    });

    // ── FUNCIÓN: Cargar componentes en tabla ─────────
    function cargarComponentes(idEquipo) {
        $('#bodyComponentes').html('<tr><td colspan="5" class="text-center">Cargando...</td></tr>');

        $.get(BASE_URL + `equipos/componentes/${idEquipo}`, function (res) {
            const tbody = $('#bodyComponentes');
            tbody.empty();

            if (!res.data || res.data.length === 0) {
                tbody.html('<tr><td colspan="5" class="text-center text-muted">Sin componentes registrados</td></tr>');
                return;
            }

            res.data.forEach((c, i) => {
                tbody.append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td class="text-capitalize">${c.tipo}</td>
                        <td class="text-capitalize">${c.seccion}</td>
                        <td>${formatFecha(c.fecha_alta)}</td>
                        <td>${formatFecha(c.fecha_vencimiento)}</td>
                    </tr>
                `);
            });
        });
    }

    // ── HELPERS ──────────────────────────────────────
    function mostrarErrores(selector, errors) {
        const el  = $(selector);
        let   msg = '<ul class="mb-0">';
        for (const k in errors) {
            msg += `<li>${errors[k]}</li>`;
        }
        msg += '</ul>';
        el.html(msg).removeClass('d-none');
    }

    function formatFecha(fecha) {
        if (!fecha) return '-';
        const d = new Date(fecha + 'T00:00:00');
        return d.toLocaleDateString('es-AR');
    }

});
</script>
</body>
</html>
