<?php
/**
 * connects to database
 * @return mysqli database connection
 */
function db_connect() {
    $databaze = 'ete32e_1920zs_01';
    $uzivatel = 'ete32e_1920zs_01';
    $heslo = 'ncymqC';
    
    $cnn = new mysqli('localhost', $uzivatel, $heslo) or die('Nepodarilo se pripojit k databazovemu serveru.');
    $cnn->select_db($databaze) or die('Nepodarilo se otevrit databazi.');
    
    return $cnn;
}

