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
Editor::inst( $db, 'carga_puntos','id' )
    ->fields(
        Field::inst( 'id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'factura_folio' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'rfc' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'fecha_carga' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'puntos' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'deleted_at', NULL)
    ->where ('user_id',$_GET['user_id'])
    ->process( $_POST )
    ->json();