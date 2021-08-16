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
Editor::inst( $db, 'cuenta_comercial','id' )
    ->fields(
        Field::inst( 'id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'codigo' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'nombre_cuenta' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'limite_credito' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'company_rfc' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'credito_habitacion' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'credito_alimentos' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'deleted_at', NULL)
    ->process( $_POST )
    ->json();