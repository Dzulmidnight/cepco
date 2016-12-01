<?php require_once('Connections/cepco.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_cepco, $cepco);


$query_fotografia = "SELECT * FROM fotografia where descripcion='disponible' order by RAND() limit 8";
$fotografia = mysql_query($query_fotografia, $cepco) or die(mysql_error());
//$row_fotografia = mysql_fetch_assoc($fotografia);
$totalRows_fotografia = mysql_num_rows($fotografia);



$query = "SELECT * FROM organizacion limit 1";
$organizacion = mysql_query($query, $cepco) or die(mysql_error());
//$row_organizacion = mysql_fetch_assoc($organizacion);


if(isset($_POST['idorganizacion'])){
$query = "SELECT * FROM localidad where idlocalidad in(select idlocalidad from inspeccion_detalle where idorganizacion='".$_POST['idorganizacion']."')";
$localidad = mysql_query($query, $cepco) or die(mysql_error());
//$row_localidad = mysql_fetch_assoc($localidad);
}else{
$query = "SELECT * FROM localidad limit 1";
$localidad = mysql_query($query, $cepco) or die(mysql_error());
//$row_localidad = mysql_fetch_assoc($localidad);
}


?>
