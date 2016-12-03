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

if(isset($_POST['guardar_img']) && $_POST['guardar_img'] == 1){

	if(isset($_POST['contador_img'])){
		$contador_img = $_POST['contador_img'];
	}else{
		$contador_img = NULL;
	}
	if(isset($_FILES['img']['name'])){
		$img = $_FILES['img']['name'];
	}else{
		$img = NULL;
	}
	if(isset($_POST['titulo'])){
		$titulo = $_POST['titulo'];
	}else{
		$titulo = NULL;
	}
	if(isset($_POST['descripcion_img'])){
		$descripcion_img = $_POST['descripcion_img'];
	}else{
		$descripcion_img = NULL;
	}


			/*$ruta_img = "../img/articulos/";
			$ruta_img = $ruta_img . basename( $_FILES['nueva_img']['name']); 
			if(move_uploaded_file($_FILES['nueva_img']['tmp_name'], $ruta_img)){ 
				unlink($_POST['img_actual']);
			} */
	for($i=0;$i<count($contador_img);$i++){

		if(!empty($_FILES['img'.$i]['name'])){
			$ruta_img = "../img/galeria/";
			$ruta_img = $ruta_img . basename( $_FILES['img'.$i]['name']); 
			move_uploaded_file($_FILES['img'.$i]['tmp_name'], $ruta_img);

			$insertSQL = sprintf("INSERT INTO imagenes(titulo, descripcion, ruta, idarticulo) VALUES(%s, %s, %s, %s)",
				GetSQLValueString($titulo[$i], "text"),
				GetSQLValueString($descripcion_img[$i], "text"),
				GetSQLValueString($ruta_img, "text"),
				GetSQLValueString($idarticulo, "int"));

			$insertar = mysql_query($insertSQL,$cepco) or die(mysql_error());

			$mensaje = "Nuevas imagenes agregadas";
		}else{
			$mensaje = "No se encontraron imagenes";
		}
	}



}


$query_articulo = "SELECT * FROM articulos WHERE idarticulo = $idarticulo";
$row_articulo = mysql_query($query_articulo, $cepco) or die(mysql_error());
$articulo = mysql_fetch_assoc($row_articulo);

$query_img = "SELECT * FROM imagenes WHERE idarticulo = $idarticulo";
$row_img = mysql_query($query_img, $cepco) or die(mysql_error());
$total_img = mysql_num_rows($row_img);
?>
<h4><h4>GALERIA DEL ARTICULO: <span style="color:#2980b9"><?php echo $articulo['titulo']; ?></span></h4></h4>
<div class="row">
	<div class="col-lg-12">
 		<?php 
 		if(isset($mensaje)){
 		?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $mensaje; ?>
			</div>
		<?php
 		}
 		 ?>
	</div>

	<div class="col-md-6">
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="table" style="font-size:12px" id="tabla_img">
				<tr>
					<td colspan="2" class="fuente" style="padding-bottom:10px;">
						<button type="button" class="btn btn-default" style="width:100%" onclick="tabla_img()" data-toggle="tooltip" title="De clic para poder agregar una nueva imagen">
							Agregar Nueva Imagen <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</td>

				</tr>
				<tr class="text-center">
					<td>
						<input type="file" class="form-control" name="img0">
						<input type="text" class="form-control" name="titulo[0]" id="" placeholder="Titulo de la imagen">
						<input type="hidden" name="contador_img[0]" value="0">
					</td>
					<td>
						<textarea name="descripcion_img[0]" class="form-control" id="" cols="" rows="3" placeholder="Descripción de la imagen"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="submit" class="btn btn-success" style="width:100%; margin-top:10px;" name="guardar_img" value="1"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Guardar Imagen(es)</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-6">
		<p><strong>Imagenes actuales</strong><p>
		<?php
		if($total_img){
			while($imagenes = mysql_fetch_assoc($row_img)){
			?>	
				<div class="col-xs-2" style="padding:0px;">
					<?php 
					if(empty($imagenes['titulo']) && empty($imagenes['descripcion'])){
						echo '<a class="disabled btn btn-xs btn-default" style="width:60px;"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a>';
					}else{
					?>
						<a tabindex="0" class="btn btn-xs btn-info" style="width:60px;" role="button" data-toggle="popover" data-trigger="hover" data-placement="top" title="<?php echo $imagenes['titulo'] ?>" data-content="<?php echo $imagenes['descripcion']; ?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
					<?php
					}
					 ?>
					<br>
					<img src="<?php echo $imagenes['ruta']; ?>" alt="<?php echo $imagenes['titulo']; ?>" class="img-thumbnail" style="width:60px;height:60px;">

				</div>
			<?php
			}
		}else{
			echo "No se encontraron imagenes disponibles";
		}
		?>
	</div>
</div>
<script>

	var contador=1;
	function tabla_img()
	{

		var table = document.getElementById("tabla_img");
		var row = table.insertRow(2);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.innerHTML = '<input type="file" class="form-control" name="img'+contador+'" id=""> <input type="text" class="form-control" name="titulo['+contador+']" id="" placeholder="Titulo de la imagen"> <input type="hidden" name="contador_img['+contador+']" value="'+contador+'">';
		cell2.innerHTML = '<textarea name="descripcion_img['+contador+']" class="form-control" id="" cols="" rows="3" placeholder="Descripción de la imagen"></textarea>';
		contador++;

	}
</script>