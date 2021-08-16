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
Editor::inst( $db, 'regalos','id' )
    ->fields(
        Field::inst( 'regalos.id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.nombre' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.puntos' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.tag' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'categorias.nombre' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'regalos.categoria_id' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'regalos.deleted_at', NULL)
    ->where( 'regalos.custom', NULL,'!=')
    ->leftJoin( 'categorias', 'categorias.id', '=', 'regalos.categoria_id')
    ->process( $_POST )
    ->json();