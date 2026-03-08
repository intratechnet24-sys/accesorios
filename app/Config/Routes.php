<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -------------------------------------------------------
// Auth (públicas, sin filtro)
// -------------------------------------------------------
$routes->get('auth/login',               'Auth::login');
$routes->post('auth/procesar-login',     'Auth::procesarLogin');
$routes->get('auth/registro',            'Auth::registro');
$routes->post('auth/procesar-registro',  'Auth::procesarRegistro');
$routes->get('auth/invitacion/(:segment)', 'Auth::invitacion/$1');
$routes->post('auth/completar-registro', 'Auth::completarRegistro');
$routes->get('auth/logout',              'Auth::logout');

// -------------------------------------------------------
// Rutas protegidas (requieren sesión activa)
// -------------------------------------------------------
$routes->group('', ['filter' => 'auth'], function($routes) {

    $routes->get('/', 'Home::index');

    // Equipos
    $routes->get('equipos',                          'Equipos::index');
    $routes->get('equipos/nuevo',                    'Equipos::nuevo');
    $routes->post('equipos/guardar',                 'Equipos::guardar');
    $routes->get('equipos/ver/(:num)',               'Equipos::ver/$1');
    $routes->get('equipos/editar/(:num)',             'Equipos::editar/$1');
    $routes->post('equipos/actualizar/(:num)',        'Equipos::actualizar/$1');
    $routes->get('equipos/eliminar/(:num)',           'Equipos::eliminar/$1');

    // Componentes (Accesorios)
    $routes->get('componentes',                      'Componentes::index');
    $routes->get('componentes/nuevo',                'Componentes::nuevo');
    $routes->get('componentes/nuevo/(:num)',         'Componentes::nuevo/$1');
    $routes->post('componentes/guardar',             'Componentes::guardar');
    $routes->get('componentes/editar/(:num)',        'Componentes::editar/$1');
    $routes->post('componentes/actualizar/(:num)',   'Componentes::actualizar/$1');
    $routes->get('componentes/eliminar/(:num)',      'Componentes::eliminar/$1');

    // Certificados de Vigencia
    $routes->get('certificados',                            'Certificados::index');
    $routes->get('certificados/nuevo',                      'Certificados::nuevo');
    $routes->get('certificados/nuevo/(:num)',               'Certificados::nuevo/$1');
    $routes->post('certificados/guardar',                   'Certificados::guardar');
    $routes->get('certificados/editar/(:num)',              'Certificados::editar/$1');
    $routes->post('certificados/actualizar/(:num)',         'Certificados::actualizar/$1');
    $routes->get('certificados/eliminar/(:num)',            'Certificados::eliminar/$1');
    $routes->get('certificados/componente/(:num)',          'Certificados::porComponente/$1');
    $routes->get('certificados/documentos/(:num)',          'Certificados::documentos/$1');
    $routes->post('certificados/subir-documento/(:num)',    'Certificados::subirDocumento/$1');
    $routes->get('certificados/eliminar-documento/(:num)', 'Certificados::eliminarDocumento/$1');
    $routes->get('certificados/ver-documento/(:num)',       'Certificados::verDocumento/$1');

    // Marcas
    $routes->get('marcas',                     'Marcas::index');
    $routes->post('marcas/guardar',            'Marcas::guardar');
    $routes->post('marcas/actualizar/(:num)',  'Marcas::actualizar/$1');
    $routes->get('marcas/eliminar/(:num)',     'Marcas::eliminar/$1');

    // Proveedores
    $routes->get('proveedores',                        'Proveedores::index');
    $routes->get('proveedores/nuevo',                  'Proveedores::nuevo');
    $routes->post('proveedores/guardar',               'Proveedores::guardar');
    $routes->get('proveedores/editar/(:num)',           'Proveedores::editar/$1');
    $routes->post('proveedores/actualizar/(:num)',      'Proveedores::actualizar/$1');
    $routes->get('proveedores/eliminar/(:num)',         'Proveedores::eliminar/$1');
    $routes->get('proveedores/localidades/(:num)',      'Proveedores::localidadesPorProvincia/$1');

    // Perfil
    $routes->get('perfil',                      'Perfil::index');
    $routes->post('perfil/actualizar',          'Perfil::actualizar');
    $routes->post('perfil/subir-foto',          'Perfil::subirFoto');
    $routes->post('perfil/cambiar-password',    'Perfil::cambiarPassword');

    // Cuentas
    $routes->get('cuentas',                         'Cuentas::index');
    $routes->get('cuentas/nueva',                   'Cuentas::nueva');
    $routes->post('cuentas/guardar',                'Cuentas::guardar');
    $routes->get('cuentas/activar/(:num)',           'Cuentas::activar/$1');
    $routes->get('cuentas/usuarios/(:num)',          'Cuentas::usuarios/$1');
    $routes->post('cuentas/invitar/(:num)',          'Cuentas::invitar/$1');
    $routes->post('cuentas/cambiar-rol/(:num)',      'Cuentas::cambiarRol/$1');
    $routes->get('cuentas/quitar-usuario/(:num)',    'Cuentas::quitarUsuario/$1');

    // Planes
    $routes->get('planes',                    'Planes::index');
    $routes->post('planes/guardar',           'Planes::guardar');
    $routes->post('planes/actualizar/(:num)', 'Planes::actualizar/$1');
    $routes->get('planes/eliminar/(:num)',    'Planes::eliminar/$1');
});
