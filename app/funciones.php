<?php
include_once 'app/config.php';
function cargarDatos(){
    $cargo = __FUNCTION__ . TIPO;
    return $cargo();
}

function volcarDatos($valores){
    $datos = __FUNCTION__ . TIPO;
    $datos($valores);
}
// ----------------------------------------------------
// FICHERO DE TEXT 
//Carga los datos de un fichero de texto
function cargarDatostxt(){
    $tabla = [];
    $arraytabla = [];
    if (!is_readable(FILEUSER)) {
        $ficherorw = @fopen(FILEUSER, "w") or die("ERROR: no se puede crear el fichero.");
        fclose($ficherorw);
    }
    $ficherorw = @fopen(FILEUSER, 'r') or die("ERROR: no podemos abrir el fichero de los usuarios"); 

    while ($linea = fgets($ficherorw)) {
        $trozo = explode('|', trim($linea));
        $tabla = [$trozo[0], $trozo[1], $trozo[2], $trozo[3]];
        array_push($arraytabla, $tabla);
    }
    fclose($ficherorw);
    return $arraytabla;
}
function volcarDatostxt($valores){
    $ficherotxt = @fopen(FILEUSER, "w");
    foreach ($valores as $trozo) {

        $trozo = implode("|",$trozo)."\n";
        fwrite($ficherotxt, $trozo);
    }

    fclose($ficherotxt);
}

// ----------------------------------------------------
// FICHERO DE CSV

function cargarDatoscsv(){
    $tablacsv = [];
    if (!is_readable(FILEUSER)) {
        $ficherocsv = @fopen(FILEUSER, "w") or die("Error al crear el fichero.");
        fclose($ficherocsv);
    }
    $ficherocsv = @fopen(FILEUSER, 'r') or die("ERROR al abrir fichero de usuarios");
    while (($trozo = fgetcsv($ficherocsv))) {
        array_push($tablacsv, $trozo);
    }
    fclose($ficherocsv);
    return $tablacsv;
}

function volcarDatoscsv($valores){
    $ficherocsv = @fopen(FILEUSER, "w");
    foreach ($valores as $trozo) {
        fputcsv($ficherocsv, $trozo);
    }
    fclose($ficherocsv);
}
// ----------------------------------------------------

// FICHERO DE JSON
function cargarDatosjson(){
    $data = file_get_contents("dat/usuarios.json");
    $jsonfichero = json_decode($data, true);

    return $jsonfichero;
}

function volcarDatosjson($valores){
    $valoresjson = json_encode($valores);
    $fichero = FILEUSER;
    file_put_contents($fichero, $valoresjson);
}

// MOSTRAR LOS DATOS DE LA TABLA DE ALMACENADA EN AL SESSION 
function mostrarDatos(){
    $titulos = ["nombre", "usuario", "contraseña", "comentario"];
    $msg = "<table>\n";
    $msg .= "<tr>";
    for ($j = 0; $j < CAMPOSVISIBLES; $j++) {
        $msg .= "<th>$titulos[$j]</th>";
    }
    $msg .= "</tr>";
    $auto = $_SERVER['PHP_SELF'];
    $id = 0;
    $nusuarios = count($_SESSION['tuser']);
    for ($id = 0; $id < $nusuarios; $id++) {
        $msg .= "<tr>";
        $datosusuario = $_SESSION['tuser'][$id];
        for ($j = 0; $j < CAMPOSVISIBLES; $j++) {
            $msg .= "<td>$datosusuario[$j]</td>";
        }
        $msg .= "<td><a href=\"#\" onclick=\"confirmarBorrar('$datosusuario[0]',$id);\" >Borrar</a></td>\n";
        $msg .= "<td><a href=\"" . $auto . "?orden=Modificar&id=$id\">Modificar</a></td>\n";
        $msg .= "<td><a href=\"" . $auto . "?orden=Detalles&id=$id\" >Detalles</a></td>\n";
        $msg .= "</tr>\n";
    }
    $msg .= "</table>";
    return $msg;
}

function limpiarArrayEntrada(array &$entrada){
    foreach ($entrada as $valor) {
        $valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripslashes($valor);
    }
}