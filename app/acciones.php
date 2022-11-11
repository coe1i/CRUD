<?php
function accionDetalles($identificador){
    $usuario = $_SESSION['tuser'][$identificador];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario=$usuario[3];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

function accionAlta(){
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}
function accionPostAlta()
{
    $repe = false;
    limpiarArrayEntrada($_POST); 
    $nuevo = [$_POST['nombre'], $_POST['login'], $_POST['clave'], $_POST['comentario']];
    foreach ($_SESSION["tuser"] as $valor) {
        if (($_POST["login"]) == $valor[1]) {
            $repe = true;
        }
    }
    if ($repe == true) {
        echo "<center><h1 style='background-color:blue;color:white;margin-left:600;margin-right:600;padding:40px'>Ha introducido un usuario repetido</h1></center>";
    } else if ($repe == false) {
        $_SESSION['tuser'][] = $nuevo;
    }
}

function accionBorrar($identificador)
{
    unset($_SESSION['tuser'][$identificador]);
    $_SESSION['tuser'] = array_values($_SESSION['tuser']);
}

function accionModificar($identificador)
{
    $usuario = $_SESSION['tuser'][$identificador];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario = $usuario[3];
    $orden = "Modificar";
    include_once "layout/formulario.php";
    exit();
}
function accionTerminar()
{
    echo "<center><h1 style='background-color:blue;color:white;margin-left:200;margin-right:200;padding:30px'> 📄Fin del registro 📄</h1></center>";
    volcarDatos($_SESSION["tuser"]);
    session_destroy();
}
function accionPostModificar($identificador)
{
    limpiarArrayEntrada($_POST); 
    $mod = [$_POST['nombre'], $_POST['login'], $_POST['clave'], $_POST['comentario']];
    $_SESSION['tuser'][$identificador] = $mod;
}

