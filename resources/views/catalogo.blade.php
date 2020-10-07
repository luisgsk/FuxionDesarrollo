<?php
use App\Http\Controllers\CatalogoController;

date_default_timezone_set('America/Santiago');
setlocale(LC_ALL, "es_ES");
session_start();

/*********************************
Establezo tiempo de la sesión (Aunque lo manejo desde SQL)
 **********************************/
if (!isset($_SESSION['tiempo'])) {
  $_SESSION['tiempo'] = time();
}
$_SESSION['session_id']  = $service[0]->session_id;

?>
<!DOCTYPE html>

<html lang="es" class="no-js">

<head>
  <!-- Bootstrap Jquery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- Carrito Estilo -->
  <script src="<?php echo asset('carrito_estilo/js/modernizr.js') ?>"></script> <!-- Modernizr -->
  <!-- carrito estilo -->
  <script src="<?php echo asset('carrito_estilo/js/main_min.js') ?>"></script> <!-- Gem jQuery -->

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Fuxion Catálogo Digital</title>
  <meta name="author" content="Luis Guillermo Valbuena" />
  <meta name="description" content="Fuxion Catalogo Digital" />
  <meta name="keywords" content="Fuxion" />
  <meta name="Resource-type" content="Document" />
  <!-- carrito estilo -->
  <link rel="stylesheet" href="<?php echo asset('carrito_estilo/css/style.css') ?>"> <!-- Gem style -->

  <link rel="stylesheet" type="text/css" href="<?php echo asset('dist/fullpage.css?v1') ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo asset('style.css') ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo asset('shop_min.css') ?>" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- Style personalizado -->
  <link rel="stylesheet" type="text/css" href="<?php echo asset('omnistyle.css?v57') ?>" />
  <!--[if IE]>
    <script type="text/javascript">
       var console = { log: function() {} };
    </script>
  <![endif]-->

  <style>
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('<?php echo asset('images/826.gif') ?>') 50% 50% no-repeat rgb(249, 249, 249);
      background-size: 25px !important;
      /*opacity: .8;*/
    }

    #text-loader {
      position: fixed;
      /*left: 0px;*/
      top: 40%;
      z-index: 9999;
      margin-left: 65px !important;
      /*opacity: .8;*/
    }
  </style>

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo asset('favicon/apple-icon-57x57.png') ?>">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo asset('favicon/apple-icon-60x60.png') ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo asset('favicon/apple-icon-72x72.png') ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset('favicon/apple-icon-76x76.png') ?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo asset('favicon/apple-icon-114x114.png') ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo asset('favicon/apple-icon-120x120.png') ?>">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo asset('favicon/apple-icon-144x144.png') ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo asset('favicon/apple-icon-152x152.png') ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('favicon/apple-icon-180x180.png') ?>">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo asset('favicon/android-icon-192x192.png') ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('favicon/favicon-32x32.png') ?>">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo asset('favicon/favicon-96x96.png') ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo asset('favicon/favicon-16x16.png') ?>">
<link rel="manifest" href="<?php echo asset('favicon/manifest.json') ?>">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo asset('favicon/ms-icon-144x144.png') ?>">
<meta name="theme-color" content="#ffffff">
</head>
<!--  descomentar las lineas para evitar 
      click derecho y opciones desarrollador 
      en navegador.                          -->
<body class="foo" oncontextmenu="/*return false*/" onkeydown="/*return false*/">
  <div class="loader">
    <span class="scandia-regular" id="text-loader" style="text-align: center!important;"></span>
  </div>
  <?php
  echo '<script>';
  echo 'var simboloPais = " '.$productos[0]->simbolo.' ";';
  //Variable para las cabeceras del carrito
  echo "var pais_cart = '" . $datos["pais"] . "';";
  echo 'console.log("ordenVista: ' . $datos["orden"] . '");';
  echo 'console.log("------------------");';
  echo 'console.log("codigoCliente: ' . $datos["token"] . '");';
  echo 'console.log("------------------");';
  echo 'console.log("nombreCliente: ' . $datos["nombre"] . '");';
  echo 'console.log("------------------");';
  echo 'console.log("pais: ' . $datos["pais"] . '");';
  echo 'console.log("------------------");';
  //echo 'console.log("session_id: ' . $service[0]->session_id . '");';
  //echo 'console.log("------------------");';
  echo 'console.log("tiempoSession: ' . date("Y-m-d H:i:s", substr($_SESSION['tiempo'], 0, 10)) . '");';
  echo 'console.log("------------------");';
  //echo 'console.log("trazabilidad: '.$trazabilidad[0]->msg.'");';
  //echo 'console.log("------------------");';
  echo '</script>'
  ?>

  <!-- ================================================ Header  ============================================== -->
  <header id="header">
    <!-- logo -->
    <div id="cd-hamburger-menu"><a class="cd-img-replace" href="#0">Menu</a></div>
    <img src="<?php echo asset('images/logo-blue.png') ?>" class="logo">
    <span id="cart-quantity-resp" class="badge" style="background-color: rgb(245, 134, 52);"><span class="simpleCart_quantity">0</span></span>
    <div id="cd-cart-trigger"><a class="cd-img-replace" href="#0">Cart</a></div>

  </header><!-- end header -->
  <!-- Incluyo Menú de navegación -->
  @include('menu_nav')
  <!-- Incluyo SideBard del carrito -->
  @include('side_carrito')
  <div id="cd-shadow-layer"></div> <!-- fondo al abrir carrito o menú -->


  <!-- ================================================ Footer  ============================================== -->
  <div id="footer">
    <!-- footer -->
    <div class="row">
      <!-- row footer -->
      <div class="col">
        <!-- col footer -->
        <img id="icon-footer" src="" style="margin-right: 10px;"><span class="scandia-regular" style="color: white !important;" id="footer-linea">LÍNEA</span> <span class="scandia-bold" id="footer-title-bold"></span> <span class="scandia-regular" id="footer-title-regular" style="color:white !important;"></span>
        <!--<a class="boton simpleCart_checkout" href="#">Checkout</a>-->
      </div><!-- end col footer -->
    </div><!-- end row footer -->
  </div><!-- end footer-->

  <!-- ================================================ Modals  ============================================== -->
  <?php

    /*==============================================================
  Relleno el Array $lineas_pais con las líneas correspondientes
  al pais de la Vista con el fin de poder condicionar cuando
  muestro o No cada página del catálogo.
  ==============================================================*/
    $lineas_pais = array();
    foreach ($productos as $key => $value) {
      array_push($lineas_pais, $value->linea);
    } //end foreach

  /*==============================================================
  Se incluye modals de info de productos y seleccion de
  variaciones.
  ==============================================================*/
  ?>
  @include('modals')
  @include('modalsVariable')
  <!-- ================================================ Page content  ============================================== -->
  <div id="fullpage">

    <?php
    $orden = $datos["orden"];

    switch ($orden) {

        case 1: //Limpia
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 2: //regenera
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 3: //Revitaliza

          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 4: //Inmunologica
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 5: //Controlpeso
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 6: //Antiedad
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;

        case 7: //Vigormental
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/sport.php');
          break;

        case 8: //Sport
          include('paginasCatalogo/sport.php');
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          break;

        default: //Default Limpia
          include('paginasCatalogo/limpia.php');
          include('paginasCatalogo/regenera.php');
          include('paginasCatalogo/revitaliza.php');
          include('paginasCatalogo/inmunologica.php');
          include('paginasCatalogo/controlpeso.php');
          include('paginasCatalogo/antiedad.php');
          include('paginasCatalogo/vigormental.php');
          include('paginasCatalogo/sport.php');
          break;
      }
    ?>
  </div>
  @include('footer')
 