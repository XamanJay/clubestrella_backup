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
Editor::inst( $db, 'temporada_comercial','id' )
    ->fields(
        Field::inst( 'temporada_comercial.id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.fecha_inicio' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.fecha_termino' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.tarifa_base' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.tarifa_pax' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.tarifa_alimentos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'hoteles_gph.nombre' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'temporada_comercial.tarifa_upgrade_habitacion' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'temporada_comercial.deleted_at', NULL)
    ->leftJoin( 'hoteles_gph', 'hoteles_gph.id', '=', 'temporada_comercial.hotel_id')
    ->process( $_POST )
    ->json();