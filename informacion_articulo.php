<?php 
  if(isset($_GET['articulo']) && !empty($_GET['articulo'])){
  
  require_once("Connections/cepco_2.php");
  mysql_select_db($database_cepco, $cepco);
  $idarticulo = $_GET['articulo'];
  $row_articulo = mysql_query("SELECT * FROM articulos WHERE idarticulo = $idarticulo", $cepco) or die(mysql_error());
  $articulo = mysql_fetch_assoc($row_articulo);
  ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>CEPCO - Coordinadora Estatal de Productores de Café de Oaxaca</title>
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/animate.min.css" rel="stylesheet"> 
      <link href="css/font-awesome.min.css" rel="stylesheet">
      <link href="css/lightbox.css" rel="stylesheet">
      <link href="css/main.css" rel="stylesheet">
      <link href="css/estilos.css" rel="stylesheet">
      <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
      <link href="css/responsive.css" rel="stylesheet">

      <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
      <![endif]-->
      
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
      <link rel="shortcut icon" href="images/cepco.ico">
    </head><!--/head-->

    <body>

      <!--.preloader-->
      <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
      <!--/.preloader-->

      <header id="home">
        <div class="main-nav">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a style="margin-top:-20px" class="navbar-brand" href="index.php">
                <h1><img class="img-responsive" src="images/logo-cepco.jpg" alt="logo"></h1>
              </a>                    
            </div>
            <div class="collapse navbar-collapse">
              <ul class="nav navbar-nav navbar-right">                 
                <li class="scroll"><a href="index.php">Inicio</a></li>
                <li class="scroll"><a href="index.php#about-us">Historia</a></li>                     
                <li class="scroll"><a href="index.php#portfolio">En movimiento</a></li>
                <li class="scroll"><a href="index.php#organic">Organico y Ambiental</a></li>
                <li class="scroll"><a href="index.php#team">Trazabilidad!</a></li>
                <li class="scroll active"><a href="#proyectos">Proyectos</a></li>
                <!--<li class="scroll"><a href="#">Vvienda</a></li>-->
                <li class="scroll"><a href="index.php#contact">Contact</a></li> 
                <li class="scroll"><a href="login.php">Mi Cuenta</a></li>       
              </ul>
            </div>
          </div>
        </div><!--/#main-nav-->
      </header><!--/#home-->
    

    <section id="about-us2" class="fuente parallax">
        <div class="container" id="proyectos">
          <div class="row">
            <div class="col-lg-8">
              <div style="text-align:justify" class="lead wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">

                <h5 class="" style="color:#7f8c8d">Tags</h5>
                <?php 
                  $row_tags = mysql_query("SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idarticulo = $articulo[idarticulo]", $cepco) or die(mysql_error());
                  while($tags = mysql_fetch_assoc($row_tags)){
                  ?>
                  <a style='margin:1px;font-size:12px;' href='articulos.php?tag=<?php echo $tags['idtag']; ?>'><span class='glyphicon glyphicon-tags'></span> <?php echo $tags['nombre']; ?></a>
                  <?php
                  }
                 ?>

                <h2 style="color: #2c3e50;"><?php echo $articulo['titulo']; ?></h2>

                <?php 
                echo $articulo['contenido'];
                echo "<p>Fuente: ".$articulo['fuente']."</p>";
                 ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="col-lg-12 hidden-xs hidden-sm">
                <h2 class="text-center" style="color:#7f8c8d">Galería</h2>
            <?php
              $row_galeria = mysql_query("SELECT * FROM imagenes WHERE idarticulo = $articulo[idarticulo]", $cepco) or die(mysql_error());

              while($galeria = mysql_fetch_assoc($row_galeria)){
              ?>
                <div align="center" class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="550ms">
                  <div class="img-thumbnail">
                    <a href="#" target="_new"><img style="font-size:10px;" src="system/img/<?php echo $galeria['ruta']; ?>" alt="<?php echo $galeria['descripcion_img']; ?>" width="90px" height="90px"></a>
                    
                  </div>
                </div>
              <?php
              }
            ?>
              <div align="center" class="col-lg-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
                <button class="btn btn-success">Ver Más</button>
              </div>
                  
              </div>
              <div class="col-lg-12" style="margin-top:4em;">
                <h2 class="text-center" style="color:#7f8c8d">Biblioteca</h2>
            <?php
              $row_biblioteca = mysql_query("SELECT * FROM archivos WHERE idarticulo = $articulo[idarticulo]", $cepco) or die(mysql_error());

              while($biblioteca = mysql_fetch_assoc($row_biblioteca)){
              ?>
              <a href="system/img/<?php echo $biblioteca['ruta']; ?>" target="_new"><p style="font-size:13px;"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> <?php echo $biblioteca['titulo']; ?></p></a>
              <?php
              }
            ?>
              <div align="center" class="col-lg-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
                <button class="btn btn-success">Ver Más</button>
              </div>
              
              </div> 
            </div>
            <div class="col-lg-12">
              <hr>
              <h2 style="color: #2c3e50;" class="text-center">Otros Articulos</h2>
              <?php 
              $row_articulos = mysql_query("SELECT * FROM articulos WHERE idarticulo != $idarticulo ORDER BY articulos.fecha_registro DESC LIMIT 4", $cepco) or die(mysql_error());
              while($articulos = mysql_fetch_assoc($row_articulos)){
              ?>
            <div align="center" class="col-lg-3 col-md-3 col-sm-6  wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="550ms">
              <div class="service-icon">
                <a href="system/img/<?php echo $articulos['img']; ?>" target="_new"><img style="font-size:10px;" src="system/img/<?php echo $articulos['img']; ?>" alt="<?php echo $articulos['descripcion_img']; ?>" width="90px" height="90px"></a>
              </div>
              <div class="service-info text-justify">
                <h3 style="color: #2c3e50;"><?php echo $articulos['titulo']; ?></h3>
                <p><?php echo substr(strip_tags($articulos['contenido']), 0,200)." [... <a href='informacion_articulo.php?articulo=$articulos[idarticulo]'>Conoce más</a>]"; ?></p>
              </div>
            </div>
              <?php
              }
               ?>
            </div>

            <div class="col-lg-12 text-center"><a href="articulos.php" class="btn btn-success" style="width:300px;">Ver Más</a></div>

          </div>
        </div>
      </section>

      
      <footer id="footer">
        <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
          <div class="container text-center">
            <div class="footer-logo">
              <!--<a href="index.html"><img class="img-responsive" src="images/logo.png" alt=""></a>-->
              <a href="">CEPCO</a>
            </div>
            <div class="social-icons">
              <ul>
                <li><a class="envelope" href="#"><i class="fa fa-envelope"></i></a></li>
                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li> 
                <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a class="tumblr" href="#"><i class="fa fa-tumblr-square"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p>&copy; CEPCO 2016.</p>
              </div>
              <div class="col-sm-6">
                <p class="pull-right">Design by <a href="http://inforganic.net/">Inforganic</a></p>
              </div>
            </div>
          </div>
        </div>
      </footer>

      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/jquery.inview.min.js"></script>
      <script type="text/javascript" src="js/wow.min.js"></script>
      <script type="text/javascript" src="js/mousescroll.js"></script>
      <script type="text/javascript" src="js/smoothscroll.js"></script>
      <script type="text/javascript" src="js/jquery.countTo.js"></script>
      <script type="text/javascript" src="js/lightbox.min.js"></script>
      <script type="text/javascript" src="js/main.js"></script>

    </body>
    </html>  
  <?php
  }else{
    header('Location: articulos.php');
  }
 ?>