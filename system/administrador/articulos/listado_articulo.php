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
	$query = "SELECT articulos.*, usuarios.username FROM articulos INNER JOIN usuarios ON articulos.autor = usuarios.idusuario ORDER BY articulos.fecha_registro DESC";
	$row_articulo = mysql_query($query,$cepco) or die(mysql_error());
	$total_articulo = mysql_num_rows($row_articulo);

	/* INICIA PAGINACION */
		//limitamos la consulta
		$regXPag = 10;
		$pagina = false; //cuando se ingresa al menu no tiene ningun valor

		//Examinar la pagina a mostrar y el inicio del registro a mostrar
		if(isset($_GET['p'])){
			$pagina = $_GET['p'];
		}
		if(!$pagina){ //si la pagina es falsa
			$inicio = 0;
			$pagina = 1;
		}else{
			$inicio = ($pagina - 1) * $regXPag;
		}
		//calculamos el total de páginas
		$total_paginas = ceil($total_articulo / $regXPag);

	$query .= " LIMIT ".$inicio.",".$regXPag;

	$paginacion = "<p style='margin-bottom:-20px;'>";
		$paginacion .= "Número de resultados: <b>$total_articulo</b>. ";
		$paginacion .= "Mostrando <b>$regXPag</b> resultados por página. ";
		$paginacion .= "Página <b>$pagina</b> de <b>$total_paginas</b>. ";
	$paginacion .= "</p>";

	if($total_paginas > 1){
		$paginacion .= '<nav aria-label="Page navigation">';
		  $paginacion .= '<ul class="pagination">';
		  	$paginacion .= ($pagina != 1)?'<li><a href="?menu=articulo&p='.($pagina-1).'" aria-label="Previous"> <span aria-hidden="true">&laquo;</span></a></li>':'';

			for ($i=1; $i <= $total_paginas; $i++) {
				//si muestro el indice de la pagina actual, no coloco enlace
				$actual = "<li class='active'><a href='#'>".$pagina."</a></li>";
				//si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
				$enlace = '<li><a href="?menu=articulo&p='.$i.'">'.$i.'</a></li>';

				$paginacion .= ($pagina == $i)?$actual:$enlace;
			}
			$paginacion .= ($pagina!=$total_paginas)?"<li><a href='?menu=articulo&p=".($pagina+1)."' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>":"";
		  $paginacion .= "</ul>";
		$paginacion .= "</nav>";
	}
	$row_articulo = mysql_query($query,$cepco) or die(mysql_error());

	/* TERMINA PAGINACIÓN*/
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
			<th class="text-left">Galeria</th>
			<th class="text-left">Archivos</th>
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
					<td ><?php echo substr(strip_tags($articulo['contenido']), 0,200)." [...]"; ?></td>
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
					<td class="text-center">
						<a class="btn btn-sm btn-default" href="?menu=articulo&listado&galeria=<?php echo $articulo['idarticulo']; ?>"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></a>
					</td>
					<td class="text-center">
						<a class="btn btn-sm btn-default" href="?menu=articulo&listado&archivos=<?php echo $articulo['idarticulo']; ?>"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a>
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
<?php 
	echo $paginacion;
 ?>
		<!--<nav aria-label="Page navigation">
		  <ul class="pagination">
		    <li>
		      <a href="#" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <li><a href="#">1</a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		    <li><a href="#">5</a></li>
		    <li>
		      <a href="#" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>-->