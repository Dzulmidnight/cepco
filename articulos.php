<?php 
  require_once("Connections/cepco_2.php");
  mysql_select_db($database_cepco, $cepco);
  $row_articulo = mysql_query("SELECT * FROM articulos ORDER BY articulos.fecha_registro DESC", $cepco) or die(mysql_error());
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
            <li class="scroll"><a href="#home">Inicio</a></li>
            <li class="scroll"><a href="#about-us">Historia</a></li>                     
            <li class="scroll"><a href="#portfolio">En movimiento</a></li>
            <li class="scroll"><a href="#organic">Organico y Ambiental</a></li>
            <li class="scroll"><a href="#team">Trazabilidad!</a></li>
            <li class="scroll active"><a href="#proyectos">Proyectos</a></li>
            <!--<li class="scroll"><a href="#">Vvienda</a></li>-->
            <li class="scroll"><a href="#contact">Contact</a></li> 
            <li class="scroll"><a href="login.php">Mi Cuenta</a></li>       
          </ul>
        </div>

      </div>
    </div><!--/#main-nav-->
  </header><!--/#home-->
  
<?php //include("servicios.php")?>

<section id="about-us" class="fuente parallax">
    <div class="container" id="proyectos">
      <div class="row">
        <h2 class="text-center" style="color:#2c3e50;">Nuestros Proyectos</h2>
        <?php 
        while($articulos = mysql_fetch_assoc($row_articulo)){
        ?>
          <div align="center" class="col-lg-4 col-md-4 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="550ms">
            <div class="service-icon">
              <a href="system/img/<?php echo $articulos['img']; ?>" target="_new"><img style="font-size:10px;" src="system/img/<?php echo $articulos['img']; ?>" alt="<?php echo $articulos['descripcion_img']; ?>" width="90px" height="90px"></a>
              
            </div>
            <div class="service-info text-justify col-md-12">
              <h3 style="color: #2c3e50;"><?php echo $articulos['titulo']; ?></h3>
              <p><?php echo substr(strip_tags($articulos['contenido']), 0,200)." [... <a href='informacion_articulo.php?articulo=$articulos[idarticulo]'>Conoce más</a>]"; ?></p>
            </div>
          </div>
        <?php
        }
         ?>
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