<?php
// *** Validate request to login to this site.
  //require_once("../../connections/mail.php");
  require_once("Connections/cepco_2.php");
  mysql_select_db($database_cepco, $cepco);

  $row_articulos = mysql_query("SELECT * FROM articulos", $cepco) or die(mysql_error());

  while($articulos = mysql_fetch_assoc($row_articulos)){
    $descripcion = strip_tags($articulos['contenido']);
  ?>
  <div align="center" class="col-lg-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="550ms">
    <div class="service-icon">
      <a href="system/img/<?php echo $articulos['img']; ?>" target="_new"><img style="font-size:10px;" src="system/img/<?php echo $articulos['img']; ?>" alt="<?php echo $articulos['descripcion_img']; ?>" width="90px" height="90px"></a>
      
    </div>
    <div class="service-info text-justify">
      <h3 style="color: #2c3e50;"><?php echo $articulos['titulo']; ?></h3>
      <p><?php echo substr(strip_tags($articulos['contenido']), 0,200)." [... <a href='articulos.php?articulo=$articulos[idarticulo]'>Conoce más</a>]"; ?></p>
    </div>
  </div>
  <?php
  }
?>


  
  <!--<div align="center" class="col-lg-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
    <div class="service-icon">
      <i class="fa fa-coffee"></i>
    </div>
    <div class="service-info">
      <h3>De b</h3>
      <p>Descripción texto, descripción texto descripción texto descripción texto descripción texto descripción..</p>
    </div>
  </div>
  
  <div align="center" class="col-lg-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
    <div class="service-icon">
      <i class="fa fa-leaf"></i>
    </div>
    <div class="service-info">
      <h3>c</h3>
      <p>Descripción texto, descripción texto descripción texto descripción texto descripción texto descripción..</p>
    </div>
  </div>
  
  <div align="center" class="col-lg-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
    <div class="service-icon">
      <i class="fa fa-users"></i>
    </div>
    <div class="service-info">
      <h3>c</h3>
      <p>Descripción texto, descripción texto descripción texto descripción texto descripción texto descripción..</p>
    </div>
  </div>-->
  <div align="center" class="col-lg-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
    <button class="btn btn-lg btn-success">Conocer Más</button>
  </div>
  