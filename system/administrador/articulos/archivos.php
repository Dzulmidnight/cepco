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

$idarticulo = $_GET['archivos'];

if(isset($_POST['guardar_documento']) && $_POST['guardar_documento'] == 1){

  if(isset($_POST['contador_documento'])){
    $contador_documento = $_POST['contador_documento'];
  }else{
    $contador_documento = NULL;
  }
  if(isset($_FILES['documento']['name'])){
    $documento = $_FILES['documento']['name'];
  }else{
    $documento = NULL;
  }
  if(isset($_POST['titulo'])){
    $titulo = $_POST['titulo'];
  }else{
    $titulo = NULL;
  }
  if(isset($_POST['descripcion_documento'])){
    $descripcion_documento = $_POST['descripcion_documento'];
  }else{
    $descripcion_documento = NULL;
  }


  for($i=0;$i<count($contador_documento);$i++){

    if(!empty($_FILES['documento'.$i]['name'])){
      $ruta_documento = "../img/biblioteca/";
      $ruta_documento = $ruta_documento . basename( $_FILES['documento'.$i]['name']); 
      move_uploaded_file($_FILES['documento'.$i]['tmp_name'], $ruta_documento);

      $insertSQL = sprintf("INSERT INTO archivos(titulo, descripcion, ruta, idarticulo) VALUES(%s, %s, %s, %s)",
        GetSQLValueString($titulo[$i], "text"),
        GetSQLValueString($descripcion_documento[$i], "text"),
        GetSQLValueString($ruta_documento, "text"),
        GetSQLValueString($idarticulo, "int"));

      $insertar = mysql_query($insertSQL,$cepco) or die(mysql_error());

      $mensaje = "Nuevos documentos agregados";
    }else{
      $mensaje = "No se encontraron documentos";
    }
  }



}


$query_articulo = "SELECT * FROM articulos WHERE idarticulo = $idarticulo";
$row_articulo = mysql_query($query_articulo, $cepco) or die(mysql_error());
$articulo = mysql_fetch_assoc($row_articulo);

$query_documentos = "SELECT * FROM archivos WHERE idarticulo = $idarticulo";
$row_documentos = mysql_query($query_documentos, $cepco) or die(mysql_error());
$total_documentos = mysql_num_rows($row_documentos);
?>
<h4>ARCHIVOS DEL ARTICULO: <span style="color:#2980b9"><?php echo $articulo['titulo']; ?></span></h4>
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
      <table class="table" style="font-size:12px" id="tabla_documentos">
        <tr>
          <td colspan="2" class="fuente" style="padding-bottom:10px;">
            <button type="button" class="btn btn-default" style="width:100%" onclick="tabla_documentos()" data-toggle="tooltip" title="De clic para poder agregar un nuevo documento">
              Agregar Nuevo Documento <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
          </td>

        </tr>
        <tr class="text-center">
          <td>
            <input type="file" class="form-control" name="documento0">
            <input type="text" class="form-control" name="titulo[0]" id="" placeholder="Titulo del documento">
            <input type="hidden" name="contador_documento[0]" value="0">
          </td>
          <td>
            <textarea name="descripcion_documento[0]" class="form-control" id="" cols="" rows="3" placeholder="Descripción del documento"></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <button type="submit" class="btn btn-success" style="width:100%; margin-top:10px;" name="guardar_documento" value="1"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Guardar Documento(s)</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <div class="col-md-6">
    <p><strong>Documentos actuales</strong><p>
    <?php
    if($total_documentos){
      while($documentos = mysql_fetch_assoc($row_documentos)){
      ?>  
        <div class="col-xs-3" style="padding:0px;">
          <?php 
          if(empty($documentos['titulo']) && empty($documentos['descripcion'])){
          ?>
            <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="disabled btn btn-sm btn-default" style="height:30px;"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></button>
              <a class="btn btn-sm btn-success" href="<?php echo $documentos['ruta']; ?>" target="_new">Descargar</a>
            </div>

          <?php
          }else{
          ?>
            <div class="btn-group" role="group" aria-label="...">
              <button tabindex="0" type="button" class="btn btn-sm btn-info" style="height:30px;" role="button" data-toggle="popover" data-trigger="hover" data-placement="top" title="<?php echo $documentos['titulo'] ?>" data-content="<?php echo $documentos['descripcion']; ?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
              <a class="btn btn-sm btn-success" href="<?php echo $documentos['ruta']; ?>" target="_new">Descargar</a>

            </div>

          <?php
          }
           ?>

        </div>
      <?php
      }
    }else{
      echo "No se encontraron documentos disponibles";
    }
    ?>
  </div>
</div>
<script>

  var contador=1;
  function tabla_documentos()
  {

    var table = document.getElementById("tabla_documentos");
    var row = table.insertRow(2);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = '<input type="file" class="form-control" name="documento'+contador+'" id=""> <input type="text" class="form-control" name="titulo['+contador+']" id="" placeholder="Titulo del documento"> <input type="hidden" name="contador_documento['+contador+']" value="'+contador+'">';
    cell2.innerHTML = '<textarea name="descripcion_documento['+contador+']" class="form-control" id="" cols="" rows="3" placeholder="Descripción del documento"></textarea>';
    contador++;

  }
</script>