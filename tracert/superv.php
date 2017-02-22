<?php require_once('../Connections/cepco.php'); ?>
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


$query_fotografia = "SELECT * FROM fotografia";
$fotografia = mysql_query($query_fotografia, $cepco) or die(mysql_error());
//$row_fotografia = mysql_fetch_assoc($fotografia);
$totalRows_fotografia = mysql_num_rows($fotografia);
echo "before while, tot: ".$totalRows_fotografia;
$cont1=0;
$cont2=0;
while($row_fotografia = mysql_fetch_assoc($fotografia)){

	if(file_exists("foto/".$row_fotografia['url'])){
		$cont1++;
		$query="update fotografia set descripcion='disponible' where idfotografia='".$row_fotografia['idfotografia']."'";
		$ejecutar = mysql_query($query, $cepco) or die(mysql_error());
	}else{
		$cont2++;
		$query="update fotografia set descripcion=NULL where idfotografia='".$row_fotografia['idfotografia']."'";
		$ejecutar = mysql_query($query, $cepco) or die(mysql_error());
	}

}
echo "<br>disponibles: ".$cont1."<br>";
echo "no disponibles: ".$cont2."<br>";

?>
