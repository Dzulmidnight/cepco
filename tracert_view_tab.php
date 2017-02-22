 <?php
 
 $limite=20;


$hostname_cepco = "localhost";
$database_cepco = "cepcoorg_SICD15";
$username_cepco = "cepcoorg_SICD15";
$password_cepco = "m!xwOP)vE]xT";
$cepco = mysql_pconnect($hostname_cepco, $username_cepco, $password_cepco) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database_cepco, $cepco);

$query_fotografia = "SELECT * FROM fotografia where descripcion='disponible' order by RAND() limit ".$limite;
$fotografia = mysql_query($query_fotografia, $cepco) or die(mysql_error());
//$row_fotografia = mysql_fetch_assoc($fotografia);
$totalRows_fotografia = mysql_num_rows($fotografia);



$query = "SELECT * FROM organizacion ";
$organizacion = mysql_query($query, $cepco) or die(mysql_error());
//$row_organizacion = mysql_fetch_assoc($organizacion);


if(isset($_POST['idorganizacion'])){
$query = "SELECT * FROM localidad where idlocalidad in(select idlocalidad from inspeccion_detalle where idorganizacion='".$_POST['idorganizacion']."')";
$localidad = mysql_query($query, $cepco) or die(mysql_error());
//$row_localidad = mysql_fetch_assoc($localidad);
}else{
$query = "SELECT * FROM localidad ";
$localidad = mysql_query($query, $cepco) or die(mysql_error());
//$row_localidad = mysql_fetch_assoc($localidad);
}


 
 ?>
 
 <section id="team">
    <div class="container">
      <div class="row">
        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
          <h2>Where did Coffee comes?</h2>
          <p>A continuación te mostramos fotografías capturadas en campo durante el proceso de inspección interna que realizamos cada año para la verificación del cumplimiento de las normas orgánicas con las que cumplen los pequeños productores de café que conforman la CEPCO.</p>
        </div>
      </div>
      
      
      <div class="col-lg-3 well">
      
      <div class="lead">Consulta perzonalizada<br /><small>Tra.cert System</small></div>

<form method="post" action="#team" class="form">
<label for="idorganizacion">Selecciona una Organización:</label>
<select disabled="disabled" onchange="this.form.submit()" class="form-control" name="idorganizacion">
<?php while($row_organizacion = mysql_fetch_assoc($organizacion)
){?>
<option <?php if(isset($_POST['idorganizacion'])){if($_POST['idorganizacion']==$row_organizacion['idorganizacion']){?> selected="selected" <?php }}?> value="<?php echo $row_organizacion['idorganizacion'];?>"><?php echo $row_organizacion['organizacion'];?></option>
<?php }?>
</select>
</form>
<form method="post" action="#team" class="form">
<label for="idlocalidad"><?php if(isset($_POST['idorganizacion'])){?>Comunidades relacionadas a la organización:<?php }else{?>Selecciona una Comunidad:<?php }?></label>
<select disabled="disabled" onchange="this.form.submit()" class="form-control" name="idlocalidad">
<?php while($row_localidad = mysql_fetch_assoc($localidad)
){?>
<option <?php if(isset($_POST['idlocalidad'])){if($_POST['idlocalidad']==$row_localidad['idlocalidad']){?> selected="selected" <?php }}?> value="<?php echo $row_localidad['idlocalidad']?>"><?php echo $row_localidad['localidad'];?></option>
<?php }?>
</select>
<?php if(isset($_POST['idorganizacion'])){?>
<input type="hidden" name="idorganizacion" value="<?php echo $_POST['idorganizacion'];?>" />
<?php }?>
</form>
<form method="post" action="#team" class="form">
<label for="productor">Productor (Nombre o Clave):</label>

<input name="productor" type="text" placeholder="Escribe aquí" readonly="readonly" />

<?php if(isset($_POST['idorganizacion'])){?>
<input type="hidden" name="idorganizacion" value="<?php echo $_POST['idorganizacion'];?>" />
<?php }?>
<?php if(isset($_POST['idlocalidad'])){?>
<input type="hidden" name="idlocalidad" value="<?php echo $_POST['idlocalidad'];?>" />
<?php }?>
<input type="submit" class="btn btn-success" value="Consultar" />
</form>
<h4>*En construcción</h4>
      
      </div>
      
      <div class="col-lg-9">
      
      <div class="team-members">
        <div class="row">
        
        <?php
        
				
				$cont=0;
				
				while($row_fotografia = mysql_fetch_assoc($fotografia)){
				
				if(file_exists("tracert/foto/".$row_fotografia['url'])){
				
				$cont++;
				
				if($cont<$limite){
				
				$loc="";
				$org="";
				
				if(isset($_POST['idlocalidad'])){
					$loc="and idlocalidad='".$_POST['idlocalidad']."'";
				}
				if(isset($_POST['idorganizacion'])){
					$loc="and idorganizacion='".$_POST['idorganizacion']."'";
				}
				
				$query = "SELECT * FROM productor where idproductor='".$row_fotografia['idproductor']."' ".$loc." ".$org." limit 1";
				$productor = mysql_query($query, $cepco) or die(mysql_error());
				//$row_productor = mysql_fetch_assoc($productor);
				while($row_productor = mysql_fetch_assoc($productor)){
				
				
				$query = "SELECT * FROM localidad where idlocalidad='".$row_productor['idlocalidad']."'";
				$localidaddet = mysql_query($query, $cepco) or die(mysql_error());
				$row_localidaddet = mysql_fetch_assoc($localidaddet);
				
				$query = "SELECT * FROM organizacion where idorganizacion='".$row_productor['idorganizacion']."'";
				$organizaciondet = mysql_query($query, $cepco) or die(mysql_error());
				$row_organizaciondet = mysql_fetch_assoc($organizaciondet);
				
				?>
        
        
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
           <table border="1" cellpadding="0" cellspacing="0" width="100%">
           <tr><td width="30%">
              <div class="member-image">
                <img height="180px" src="tracert/foto/<?php echo $row_fotografia['url'];?>" alt="">
              </div>
              </td><td>
              <div class="member-info">
                <h5><?php echo $row_productor['productor'];?></h5>
                <p><?php echo $row_localidaddet['localidad'].", ".$row_organizaciondet['organizacion'];?></p>
              </div>
              </td>
              </tr>
              </table>
            </div>
          </div>
            
          
          <?php }}}}?>
          
          <div class="col-sm-6">
            <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="800ms">
              <div class="member-image">
                <img class="img-responsive" src="tracert/config/logo_tracert.jpg" alt="">
              </div>
              <div class="member-info">
                <h3>tra.cert</h3>
                <h4>inforganic Technologies</h4>
                <p align="justify">Sistema digital de trazabilidad de producto.<br />Información recopilada en campo por tecnicos comunitarios capacitados en tecnologías de última generación, datos e imagenes disponibles al consumidor y público interesado vía internet.</p>
              </div>
              
              <?php /*
              <div class="social-icons">
                <ul>
                  <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                  <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                  <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                  <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                  <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                </ul>
              </div>
              */ ?>
              
            </div>
          </div>
          
          
          
          
        </div>
      </div>  
      
      </div>
      
      
                
    </div>
  </section><!--/#team-->


  <section id="twitter" class="parallax">
    <div>
      <a class="twitter-left-control" href="#twitter-carousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
      <a class="twitter-right-control" href="#twitter-carousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="twitter-icon text-center">
              <i class="fa fa-leaf"></i>
              <h4>Información extra</h4>
            </div>
            <div id="twitter-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                  <p>texto 1 <a href="#"><span>text 2</span> www.cepco.mx</a></p>
                </div>
                <div class="item">
                  <p>texto 1 <a href="#"><span>text 2</span> www.cepco.mx</a></p>
                </div>
                <div class="item">                                
                  <p>texto 1 <a href="#"><span>text 2</span> www.cepco.mx</a></p>
                </div>
              </div>                        
            </div>                    
          </div>
        </div>
      </div>
    </div>
  </section><!--/#twitter-->

  <?php //include("blog.php");?>

  <?php //include("contact.php");?>
