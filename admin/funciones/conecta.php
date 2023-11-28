<?php
// Ubicacion del archivo:
//  ./funciones/conecta.php

define("HOST", 'localhost:3316');
define("BD", 'empresa01');
define("USER_BD",'root'); // Usuario de la base de datos
define("PASS_BD", '');

function conecta(){
    $con = new mysqli(HOST, USER_BD, PASS_BD, BD);
    return $con;
}
?>