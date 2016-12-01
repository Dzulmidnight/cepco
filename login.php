<?php include("tracert/brain.php");?>
<!DOCTYPE html>
<html lang="en">
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
  <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  
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
            <li class="scroll"><a href="index.php#proyectos">Proyectos</a></li>
            <!--<li class="scroll"><a href="index.php#">Vvienda</a></li>-->
            <li class="scroll"><a href="index.php#contact">Contact</a></li> 
            <li class="scroll active"><a href="login.php">Mi Cuenta</a></li>       
          </ul>
        </div>



<!--        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">                 
            <li class="scroll active"><a href="#home">Inicio</a></li>
            <li class="scroll"><a href="#services">Servicios</a></li> 
            <li class="scroll"><a href="#about-us">Historia</a></li>           
            <li class="scroll"><a href="#">Empresa</a></li>
            <li class="scroll"><a href="#portfolio">Organico y Ambiental</a></li>
            <li class="scroll"><a href="#team">Servicios Ambientales</a></li>
            <li class="scroll"><a href="#">Vivienda</a></li>
            <li class="scroll"><a href="#blog">Blog</a></li>

            <li class="scroll"><a href="#contact">Contact</a></li>       
          </ul>
        </div>
-->



      </div>
    </div><!--/#main-nav-->
  </header><!--/#home-->
  
  
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-4">
            <!---- INCIAR FORMULARIO PARA INCIAR SESIÓN ---->
            <form action="Connections/autentificar.php" method="POST">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title text-center">Mi Cuenta</h3>
                </div>

                  <?php
                  if(isset($_GET['error']) && $_GET['error'] == "si"){
                  ?>
                    <div class="alert alert-warning alert-dismissible text-center" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>Datos Incorrectos</strong>
                    </div>
                  <?php
                  }
                  ?>

                <div class="panel-body">
                  <div class="input-group">
                    <span class="input-group-addon glyphicon glyphicon-user" id="usuario" aria-hidden="true"></span>
                    <input type="text" class="form-control" style="border-color:#bdc3c7" name="username" placeholder="Usuario" aria-describedby="usuario">
                  </div>
                  <hr>
                  <div class="input-group">
                    <span class="input-group-addon glyphicon glyphicon-lock" id="password"></span>
                    <input type="text" class="form-control" style="border-color:#bdc3c7" name="password" placeholder="Password" aria-describedby="password">
                  </div>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-success" style="width:100%;"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar Sesión</button>
                </div>

              </div>
            </form>
            <!---- TERMINA FORMULARIO PARA INCIAR SESIÓN ---->

        </div>
      </div>
    </div>
  </section>


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