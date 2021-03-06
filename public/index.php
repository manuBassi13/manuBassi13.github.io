<?php 

mb_internal_encoding('UTF-8');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try{
	require_once('app/modelos/contacto.php');
		
	if($_POST !== array()){

		$con = new Contacto();
		$con->setNombre(isset($_POST['txtNombre'])? $_POST['txtNombre'] : '');
		$con->setEmail(isset($_POST['txtEmail'])? $_POST['txtEmail'] : '');
		$con->setMensaje(isset($_POST['txtMensaje'])? $_POST['txtMensaje'] : '');

		$con->isNombre(1,50);
		$con->isEmail(1,254);
		$con->isMensaje(1,1000);
		if ($con->getContError() !== 0){
			throw new \Exception($con->getArregloMsje());
		}

		if(isset($_POST['g-recaptcha-response'])){
			$captcha=$_POST['g-recaptcha-response'];
		}
		 if(!$captcha){
			throw new \Exception("Falta verificar reCAPTCHA");
		}
		 /*$secretKey = "6Lccz0IaAAAAAP6OmsF1y3exhArgE0ALZZDAu7sD";
		 $ip = $_SERVER['REMOTE_ADDR'];
		 //Chequear captcha con Google
		 $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		 $responseKeys = json_decode($response,true);
		 if(intval($responseKeys["success"]) !== 1) {
			throw new \Exception("Falta captcha 2");;
			 } else {
			echo '<p>OK</p>';}*/
		

		require_once('app/librerias/PHPMailer-6.2.0/PHPMailer-master/src/PHPMailer.php');
		require_once('app/librerias/PHPMailer-6.2.0/PHPMailer-master/src/SMTP.php');
		require_once('app/librerias/PHPMailer-6.2.0/PHPMailer-master/src/Exception.php');
		$mail = new PHPMailer(true);
		$mail->CharSet = 'utf-8';
		$mail->SetLanguage('es');
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPOption = array(
			'ssl'=> array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'pruebaSMTP1303@gmail.com';						//Cuenta SMTP  						QUITAR
		$mail->Password = 'A_12345678';										//Password SMTP
		$mail->setFrom($con->getEmail(), $con->getNombre());				//Cuenta EMISORA
		$mail->AddReplyTo($con->getEmail(), $con->getNombre());				//Email y nombre A RESPONDER
		$mail->AddAddress('manuelbassi_8@hotmail.com', 'Manuel');			//Email y nombre RECEPTOR
		$mail->Subject = 'Mensaje desde sitio web';
		$mail->Body = ''
		. 'Nombre: ' . $con->getNombre() . '<br>'
		. 'Email: ' . $con->getEmail() . '<br>'
		. 'Mensaje: ' . $con->getMensaje() . '<br>';
		$mail->AltBody = ''
		. 'Nombre: ' . $con->getNombre() . "\r\n"
		. 'Email: ' . $con->getEmail() . "\r\n"
		. 'Mensaje: ' . $con->getMensaje() . "\r\n";
		
		$mail->Send();

		header('Location: mensaje-enviado.html', true, 302);
		exit;

	} else {
		$con = new Contacto();
		$con->setNombre('');
		$con->setEmail('');
		$con->setMensaje('');
	}
	} catch (Exception $e){
		$mensaje = $e->getMessage();
	} catch (\Exception $e){
		$mensaje = $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Arenera del Puerto | San Pedro</title>
	<link rel="shortcut icon" href="img/iconoSilos.png">
	<link rel="stylesheet" href="css/estilos.css" type="text/css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.gotop.min.js"></script>
	<script src="js/validaForm.js"></script>
	<script src="https://kit.fontawesome.com/a0183d84ac.js"></script>
</head>
<body>
<script>
   $(function () {
	$('#goTop').goTop({
		 "width" : 50,
		 "scrolltime" : 500,
		 "marginY" : 3,
		 "marginX" : 3,
		 "src" : "fas fa-arrow-circle-up",
		 "color" : "white !important",
		 "opacity":0.85
      });
   });

   $(document).ready(function(){
		var altura = $('.top-menu').offset().top;
	
		$(window).on('scroll', function(){
			if ( $(window).scrollTop() > altura ){
				$('.top-menu').addClass('menu-fixed');
			} else {
				$('.top-menu').removeClass('menu-fixed');
			}
		});
	});


	var onloadCallback = function() {
        grecaptcha.render('recaptcha', {
			'sitekey' : '6Lccz0IaAAAAAP6OmsF1y3exhArgE0ALZZDAu7sD'
        });
      };
</script>

<span class="whatsapp"><a href="https://api.whatsapp.com/send?phone=5493329410850"><img src="img/wapp.png" alt="Icono Whatsapp"></a></span>

	<a class="menu-toggle" id="menu-toggle" href="#">
    	<i class="fas fa-bars"></i>
  	</a>
	<nav id="sidebar-wrapper">
		<ul class="sidebar-nav">
		<li class="sidebar-brand">
        	<a class="js-scroll-trigger" href="#page-top">Menu</a>
      	</li>
		<!-- Navigation-->
		<li class="sidebar-nav-item">
			<a class="" href="#inicio">Inicio</a>
		</li>
		<li class="sidebar-nav-item">
			<a class="" href="#servicios">Servicios</a>
		</li>
		<li class="sidebar-nav-item">
			<a class="" href="#empresa">La Empresa</a>
		</li>

		<li class="sidebar-nav-item">
			<a class="" href="#ubicacion">Ubicación</a>
		</li>

		<li class="sidebar-nav-item">
			<a class="" href="#contacto">Contacto</a>
		</li>

		</ul>
	</nav>

<div class="header" id="head">	
	
		<div class="header-top">
			<h1 class="logo">																			
				<a href="index.php"><img src="img/areneraLogo.png" alt="Logo Arenera del Puerto"></a>
			</h1>
			
		</div>
																																	
</div>

<div class="top-menu">
	<nav>
		<ul>
			<li><a href="#inicio"><span>inicio</span></a></li>
			<li><a href="#servicios"><span>servicios</span></a></li>
			<li><a href="#empresa"><span>la empresa</span></a></li>
			<li><a href="#ubicacion"><span>ubicación</span></a></li>
			<li><a href="#contacto"><span>contacto</span></a></li>
		</ul>
	</nav>
</div>

	
		<!-- INICIO -->
 
<section class="inicio-section" id="inicio">
	<h2>INICIO</h2>

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
			<li data-target="#myCarousel" data-slide-to="4"></li>
			<li data-target="#myCarousel" data-slide-to="5"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="img/extraccion0.jpg" alt="Extracción de arena">
				<div class="carousel-caption">
					<h3>Extracción con zaranda para limpieza</h3>
					<p>Extracción con zaranda para limpieza</p>
				</div>
			</div>

			<div class="item">
				<img src="img/descarga0.jpg" alt="Descarga de arena">
				<div class="carousel-caption">
					<h3>Descarga en puerto</h3>
					<p>Descarga en puerto</p>
				</div>
			</div>

			<div class="item">
				<img src="img/bombeo0.jpg" alt="Bombeo a silos">
				<div class="carousel-caption">
					<h3>Bombeo de arena a los silos</h3>
					<p>Bombeo de arena a los silos</p>
				</div>
			</div>

			<div class="item">
				<img src="img/secado0.jpg" alt="Secado de arena">
				<div class="carousel-caption">
					<h3>Filtrado y secado por drenaje</h3>
					<p>Filtrado y secado por drenaje</p>
				</div>
			</div>

			<div class="item">
				<img src="img/carga0.jpg" alt="Carga de camiones">
				<div class="carousel-caption">
					<h3>Carga automatizada de camiones</h3>
					<p>Carga automatizada de camiones</p>
				</div>
			</div>
			
			<div class="item">
				<img src="img/pesaje0.jpg" alt="Pesaje con balanza">
				<div class="carousel-caption">
					<h3>Pesaje con balanza electrónica</h3>
					<p>Pesaje con balanza electrónica</p>
				</div>
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

</section>
	
	  <!-- SERVICIOS -->

<section class="servicios-section" id="servicios">
	<h2>SERVICIOS</h2>
	<p>En la actualidad, la empresa tiene una capacidad de producción propia de 30.000 toneladas mensuales.
		<br><br>
		Sus instalaciones están formadas por:
		<br><br>
		- 4 silos con una capacidad de abastecimiento de 760 toneladas.
		<br><br>
		- 1 pileta de acopio de 500 mts3.
		<br><br>
		- 1 barco arenero equipado cuya capacidad total de producción es de 1300 toneladas diarias.
		<br><br>
		- Maquinaria de última generación para responder a las exigencias actuales del mercado (palas cargadoras, balanza electrónica, etc.)
	 logrando disminuir los tiempos de espera en la playa, optimizar la carga de equipos, y la calidad del producto final.
	</p>
</section>
		
		<!-- LA EMPRESA -->

<section class="empresa-section" id="empresa">
	<h2>LA EMPRESA</h2>
	<p>Arenera del Puerto está ubicada en la ciudad de San Pedro, Prov. de Buenos Aires.<br> Inició sus actividades en el año 1967. En aquel año,
	 sus fundadores, Juan de la Cruz y Pedro Spósito se asociaron para cubrir una creciente necesidad en una región en la que no existían areneras. 
	 Para este fin se instalan en un predio concesionado por el puerto de San Pedro, cuya concesión aún sigue vigente, cumpliendo más de 50 años de constante actividad.
	</p>

	<p>El primer barco que refuló arena en esta cabecera fue el b/m "Balotta".<br>Una vez instalados en el predio
	comenzaron la construcción de 4 silos de 140 mts3 c/u, totalizando una carga de 560 mts3 de arena.<br>
	Construyeron además, 1 pileta de acopio de 500 mts3.<br>Con el tiempo la demanda y el crecimiento de la empresa
	motivó la construcción de un galpón de 500 mts2 para guardar las palas cargadoras y otros elementos de uso cotidiano.
	</p>

	<p>Durante todos estos años se trabajo de manera ininterrumpida, hecho que se ve reflejado en la cartera 
		de clientes, de la cual más del 70% operan con la firma desde los inicios de la actividad como arenera.
	</p>

	<p>Actualmente la empresa esta siendo operada por lo herederos del sr. Juan de la Cruz, siendo ellos los responsables de la operatoria total de la compañía.
	</p>
	
</section>
	
		<!-- UBICACION -->

<section class="ubicacion-section" id="ubicacion">
	<h2>UBICACIÓN</h2>
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3319.89376862123!2d-59.64367928483839!3d-33.685814780707275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95ba3ce9ece204f9%3A0x28d7037d62122251!2sARENERA%20DEL%20PUERTO%20SA%20San%20Pedro!5e0!3m2!1ses-419!2sar!4v1609960332079!5m2!1ses-419!2sar" width="80%" height="500"  allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</section>

		<!-- CONTACTO -->

<section class="contacto-section" id="contacto">
	<h2>CONTACTO</h2>
																									
		<?php if(isset($mensaje)) { ?>
			<span class="mensaje" id="mensaje"> ¡ ERROR ! <br><br><?php echo $mensaje; ?></span>															
		<?php } ?>

		<div class="contacto-form">
			<form id="contacto-form" name="contactoForm" action="#contacto" method="post" class="formulario">
				<p id="pNombre"><label for="txtNombre">Nombre <abbr class="contacto-requerido" title="Campo requerido.">*</abbr>
				<input type="text" id="txtNombre" name="txtNombre" maxlength="50" value="<?php echo htmlspecialchars($con->getNombre(), ENT_QUOTES); ?>" required></label></p>
				<p id="pEmail"><label for="txtEmail">Email <abbr class="contacto-requerido" title="Campo requerido.">*</abbr>
				<input type="email" id="txtEmail" name="txtEmail" maxlength="254" value="<?php echo htmlspecialchars($con->getEmail(), ENT_QUOTES); ?>" required ></label></p>
				<p id="pMensaje"><label for="txtMensaje">Mensaje <abbr class="contacto-requerido" title="Campo requerido.">*</abbr>
				<textarea id="txtMensaje" name="txtMensaje" required rows="9" cols="30" maxlength="1000"><?php echo htmlspecialchars($con->getMensaje(), ENT_QUOTES); ?></textarea></label></p>
				<p>* Campo requerido.</p>
				<p id="pCaptcha"></p>
				<div id="recaptcha" class="g-recaptcha"></div>
				
				<p><input type="submit" name="btnEnviar" value="Enviar"></p>	
			</form>
		</div>
		
</section>

<div id="goTop"></div>		<!--  GO TOP -->

<footer>
	<div class="contacto-datos">
		<h3>Arenera del Puerto S.A</h3>
		<p>Tel.: 03329.426624<br><br>
		Cel.: 03329.15410850<br><br>
		Puerto San Pedro C.P. 2930, Bs. As.<br><br>
		areneradelpuerto@yahoo.com<br><br>
		Lunes a Viernes (06:00 - 20:00) <br>
		 Sábados (06:00 - 13:00)</p>
	</div>

	<hr>

	<div class="footer-copyright text-center py-3">
		<span class="font-weight-bold"><i class="fas fa-at"></i>  UCEL - ISI - Entornos Web - 2020 - Trabajo final: Bassi Capurro, Manuel </span>
	</div>
</footer>

	<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
	<script src="js/menu.js"></script>
</body>
</html>