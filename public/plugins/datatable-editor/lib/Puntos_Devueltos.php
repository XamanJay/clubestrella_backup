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
Editor::inst( $db, 'devoluciones','id' )
    ->fields(
        Field::inst( 'devoluciones.id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'devoluciones.puntos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'devoluciones.user_id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'devoluciones.created_at' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.regalo_id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'devoluciones.representante' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.nombre' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'devoluciones.puntos_id' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'devoluciones.deleted_at', NULL)
    ->where ('devoluciones.user_id',$_GET['user_id'])
    ->leftJoin( 'redencion_puntos', 'redencion_puntos.id', '=', 'devoluciones.puntos_id')
    ->leftJoin( 'regalos', 'regalos.id', '=', 'redencion_puntos.regalo_id')
    ->process( $_POST )
    ->json();