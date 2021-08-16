<?php
 
/*
 * Example PHP implementation used for the index.html example
 */
 
// DataTables PHP library
include("DataTables.php");
 
// Alias Editor classes so they are easy to use
use
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Options,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate;
 
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'clientes','id' )
    ->fields(
        Field::inst( 'users.id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.nombre' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.apellidos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.email' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'puntos.puntos_totales' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'clientes.numero_socio' )->validator( 'Validate::notEmpty' ))
        
    ->where('clientes.deleted_at', NULL)
    ->where('users.deleted_at',NULL)
    ->leftJoin( 'users', 'users.id', '=', 'clientes.user_id')
    ->leftJoin( 'puntos', 'puntos.user_id', '=', 'clientes.user_id')
    ->process( $_POST )
    ->json();