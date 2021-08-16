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
Editor::inst( $db, 'redencion_puntos','id' )
    ->fields(
        Field::inst( 'redencion_puntos.id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.fecha_redencion' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.fecha_inicio' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.fecha_salida' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.cuartos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.noches' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.regalo_id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.puntos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.comentarios' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.cantidad' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'redencion_puntos.representante' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.nombre' )->validator( 'Validate::notEmpty' ))
    
    ->where( 'redencion_puntos.deleted_at', NULL)
    ->where ('user_id',$_GET['user_id'])
    ->leftJoin( 'regalos', 'regalos.id', '=', 'redencion_puntos.regalo_id')
    ->process( $_POST )
    ->json();