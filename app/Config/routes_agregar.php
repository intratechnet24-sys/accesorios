<?php

// ============================================
// RUTAS - Agregar en app/Config/Routes.php
// dentro del bloque existente
// ============================================

$routes->get('equipos',                    'Equipos::index');
$routes->post('equipos/store',             'Equipos::store');
$routes->post('equipos/toggle/(:num)',     'Equipos::toggleEstado/$1');
$routes->post('equipos/componente/store',  'Equipos::storeComponente');
$routes->get('equipos/componentes/(:num)', 'Equipos::getComponentes/$1');
