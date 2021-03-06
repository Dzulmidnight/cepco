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

	if(isset($_POST['eliminar_articulo']) && $_POST['eliminar_articulo'] == 1){
		$idarticulo = $_POST['idarticulo'];
		$img = $_POST['img_articulo'];

		unlink($img);
		$deleteSQL = sprintf("DELETE FROM articulos WHERE idarticulo = %s",
			GetSQLValueString($idarticulo, "int"));		
		$eliminar = mysql_query($deleteSQL,$cepco) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idarticulo = %s",
			GetSQLValueString($idarticulo, "int"));
		$eliminar = mysql_query($deleteSQL,$cepco) or die(mysql_error());

		$mensaje = "Articulo Eliminado Correctamente";

	}
	//$query = "SELECT nota.*,  usuario.username FROM nota INNER JOIN usuario ON nota.idusuario = usuario.idusuario";
	$query = "SELECT articulos.*, usuarios.username FROM articulos INNER JOIN usuarios ON articulos.autor = usuarios.idusuario";
	$row_articulo = mysql_query($query,$cepco) or die(mysql_error());
	$total_articulo = mysql_num_rows($row_articulo);
?>
<h4>Listado Articulos</h4>
<table class="table table-striped table-bordered" style="font-size:11px;">
	<thead>
		<tr>
			<th class="text-left">Id</th>
			<th class="text-left">Título</th>
			<th class="text-left">Descripción</th>
			<th class="text-left">Imagen</th>
			<th class="text-left">Tag(s)</th>
			<th class="text-left">Autor</th>
			<th class="text-center"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($total_articulo == 0){
			echo "<tr class='text-center'><td colspan='7'>No Se Encontraron Articulos</td></tr>";
		}else{
			while($articulo = mysql_fetch_assoc($row_articulo)){
				$fecha = date('d/m/Y',$articulo['fecha_registro']);
			?>
				<tr>
					<td>
						<?php echo $articulo['idarticulo']; ?>
					</td>
					<td><?php echo $articulo['titulo']; ?></td>
					<td><?php echo substr($articulo['contenido'], 0,200); ?></td>
					<td><img style="width:50px;" src="<?php echo $articulo['img'] ?>" class="img-thumbnail" alt=""></td>
					<td>
					<?php 
					$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idarticulo = $articulo[idarticulo]";
					$row_tags = mysql_query($query_tags,$cepco) or die(mysql_error());
					while($tags = mysql_fetch_assoc($row_tags)){
						echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
					}
					 ?>
					</td>
					<td><?php echo $articulo['username']; ?></td>
					<td>
						<!-- EDITAR ARTICULO -->
						<!-- ELIMINAR NOTA -->
						<form action="" method="POST">
							<button class="btn btn-sm btn-primary" type="button" data-toggle="modal"  data-target="#myModal<?php echo $articulo['idarticulo'];?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
							<a class="btn btn-sm btn-default" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=articulo&add_articulo&detalle=<?php echo $articulo['idarticulo']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Articulo" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_articulo" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>

							<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
							<input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
							<input type="hidden" name="img_articulo" value="<?php echo $articulo['img']; ?>">
						</form>
					</td>

				</tr>


				<!-- Modal -->
				<div class="modal fade" id="myModal<?php echo $articulo['idarticulo'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel" style="color:#2c3e50"><?php echo $articulo['titulo']; ?></h4>
				      </div>
				      <div class="modal-body" style="color:#34495e">
				      	<div class="row">
				      		<div class="col-md-12">
						      <?php //nl2br

						      	echo "<div class='col-xs-12'><p class='text-justify'>".$articulo['contenido']."</p></div>";



						      /*$nota = sprintf("SELECT contenido,contenido_descripcion,descripcion_img  FROM nota WHERE idarticulo = %s",
						        GetSQLValueString($articulo['idarticulo'],"int"));
						      $ejecutar = mysql_query($nota,$cepco) or die(mysql_error());
						      $titulo_nota = mysql_fetch_assoc($ejecutar);

						      $query_segmento = sprintf("SELECT * FROM nota_segmento WHERE idarticulo  = %s",
						      GetSQLValueString($articulo['idarticulo'],"int"));

						      $ejecutar = mysql_query($query_segmento,$cepco) or die(mysql_error());*/


							?>	
				      		</div>
				      	</div>
				      </div>
				      <div class=" modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				  </div>
				</div>
			<?php
			}
		}
		?>
	</tbody>
</table>