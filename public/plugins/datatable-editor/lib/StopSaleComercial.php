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
Editor::inst( $db, 'stop_tarifa_comercial','id' )
    ->fields(
        Field::inst( 'id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'startDate' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'endDate' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'created_at' )->validator( 'Validate::notEmpty' ))
        
    ->where( 'deleted_at', NULL)
    ->process( $_POST )
    ->json();