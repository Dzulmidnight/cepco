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
$idarticulo = $_GET['galeria'];
$query_articulo = "SELECT * FROM articulos WHERE idarticulo = $idarticulo";
$row_articulo = mysql_query($query_articulo, $cepco) or die(mysql_error());

$query_img = "SELECT * FROM imagenes WHERE idarticulo = $idarticulo";
$row_img = mysql_query($query_img, $cepco) or die(mysql_error());
$total_img = mysql_num_rows($row_img);
?>
<h4>GALERIA</h4>
<div class="row">
	<div class="col-md-6">
		<table style="font-size:12px" id="tabla_tags">
			<tr>
				<td colspan="2" class="fuente" style="padding-bottom:10px;">
					<button type="button" class="btn btn-default" style="width:100%" onclick="tabla_tags()" data-toggle="tooltip" title="De clic para poder agregar una nueva imagen">
						Agregar Nueva Imagen <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				</td>

			</tr>
			<tr class="text-center">
				<td><input type="file" class="form-control" name="img"></td>
				<td class="fuente"><input type="text" class="form-control" name="titulo[0]" id="" placeholder="Titulo de la imagen"></td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<p><strong>Imagenes actuales</strong><p>
		<?php
		if($total_img){

		}else{
			echo "No se encontraron imagenes disponibles";
		}
		?>
	</div>
</div>
<script>
	var contador=0;
	function tabla_tags()
	{
		contador++;
		var table = document.getElementById("tabla_tags");
		var row = table.insertRow(2);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.innerHTML = '<input type="file" class="form-control" name="img['+contador+']" id="">';
		cell2.innerHTML = '<input type="text" class="form-control" name="titulo['+contador+']" id="" placeholder="Titulo de la imagen">';
	}
</script>