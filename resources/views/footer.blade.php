<!-- ===================================================================================================================== -->
<?php
if ($datos["pais"] == 'co') {
    echo '
      <style>
        .precio{
         font-size: calc(1em + 1vw) !important;
        }

        .titulo-productos {
          font-size: calc(0.8em + 0.8vw) !important;
        }
      </style>';
}
?>
<style>
    .simpleCart_decrement,
    .simpleCart_increment {
        font-size: 19px !important;
    }

    .item-quantity {
        font-size: 14.5px !important;
    }

    .nombre-muy-largo {
        font-size: 10px !important;
        margin-top: 8px !important;
    }
</style>

<!-- lazy load -->
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<!-- Simple Cart -->
<!-- Agregamos la librería jQuery (Importante)-->
<!--<script src="<?php echo asset('cart/jquery.min.js') ?>"></script>-->
<!-- Agregamos la librería Simple Cart        -->
<script src="<?php echo asset('cart/simpleCart.js?v5') ?>"></script>
<!-- Código JS de inicialización  -->
<script src="<?php echo asset('cart/app.js?v26') ?>"></script>
<!--<script>simpleCart.empty();</script>-->

<script type="text/javascript" src="<?php echo asset('dist/fullpage_min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('dist/fullpage.resetSliders.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('dist/fullpage.extensions.min.js?v1') ?>"></script>
<!--<script type="text/javascript" src="examples.js"></script>-->

<!-- Script General -->
<?php
echo '<script>';
echo 'var clienteid = "' . $datos["token"] . '";';
echo 'var orden     = "' . $datos["orden"] . '";';
echo 'var pais      = "' . $datos["pais"] . '";';
echo '</script>';
?>
<script>
    lazyload(); //Activo LazyLoad

    /*======================================================
        Quitar pantalla cargando cuando la app esté cargada
        ======================================================*/
    $(window).on("load", function() {
        jQuery(".loader").fadeOut("slow");

    });

    /*======================================================
    Función que muestra el modal de info de productos.
    ======================================================*/
    function verInfo(idmodal) {
        $('#' + idmodal).modal('show');
    }

    /*======================================================
        Función que muestra el modal variable de productos.
        ======================================================*/
    function selectproduct(idmodal) {
        $('#' + idmodal).modal('show');
    }

    /*======================================================
    Trazabilidad
    =====================================================*/

    function setTrazabilizad(sessionid, accion, producto, familia) {
        var producto = producto.replace('+', 'X'); // Debido a error en la url
        var producto = producto.replace('&', 'X'); // Debido a error en la url
        var producto = producto.replace('/', 'X'); // Debido a error en la url
        var ruta = "https://i.ibrlatam.com/fuxion/desa/public/setlog/" + sessionid + "/" + accion + "/" + producto + "/" + familia
        //console.log("ruta: "+ruta);
        $.ajax({
            url: ruta,
            dataType: "json",
            type: "get",
            beforeSend: function(xhr) {xhr.setRequestHeader('api_key', '$2y$10$c.1XGUOfVL2HUAGCkGzT5u1cmyDRdZ7SpaWRme0nk9d9xtg8y85mu');},
            success: function(response) {
                //console.log(response);

            } //end success
        });

    } // end setTrazabilidad()

    /*======================================================
          Laravel token para funciones ajax's
        =====================================================*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*======================================================
    Para los nombres de productos largos, aplico la clase 
    nombre-largo la cual reduce el tamaño e la fuente a 15px.
    Esto evita que se desajuste.
    =======================================================*/
    Array.from(document.querySelectorAll('.titulo-productos')).forEach((element, index) => {
        var titulo = element.innerHTML;
        if (titulo.length > 14 && titulo.length < 16) {
            element.classList.add('nombre-largo');
        } //end if
        else if (titulo.length >= 23) {
            element.classList.add('nombre-muy-largo');
        }
    }); //end foreach

    //onReady
    $(document).ready(function() {
        //Se guarda el inicio de sesión (link abierto)
        setTrazabilizad('<?php echo $service[0]->session_id; ?>', 'iniciarSesion', 'n-a', 'n-a');

        /*======================================================
           Reemplazar el separador decimal por coma.
          ======================================================*/
        if ("<?php echo strtoupper($datos['pais']); ?>" == "ES" || "BO") {
            //En caso de españa reemplazo por coma el separador decimal.
            var decimales = document.getElementsByClassName('precio-decimal');
            for (var i = 0; i < decimales.length; ++i) {
                decimales[i].innerHTML = decimales[i].innerHTML.replace(".", ",");
            }
        } //end if paises

        //Elimino comentarios del DOM 
        $('*').contents().each(function() {
            if (this.nodeType === Node.COMMENT_NODE) {
                $(this).remove();
            }
        });
        //Disabled click derecho
        //document.oncontextmenu = function(){return false;}
        //default image de poco peso para ser reemplazada al cargar la original por Lazy Load
        $(".lazyload").attr("src", "<?php echo asset('images/productos/default-min.png') ?>");
    });

    /*======================================================
          Botón seguir comprando carrito
        =====================================================*/
    $("#seguircomprando").click(function() {
        $('#cd-cart-trigger').removeClass('speed-in');
        toggle_panel_visibility($('#cd-cart'), $('#cd-shadow-layer'), $('body'));

    });

    /*======================================================
      Botón Checkout / Finalizar comprar
      Envío variables: clienteId,sessionId,csrftoken,ordenVista
      a simpleCart para enviarlas hacia post.php.
      ======================================================*/

    $("#checkout").click(function(e) {
        e.preventDefault(); //Para evitar doble submit
        $('#checkout').disabled = true; //desactivo para resguardo
        setTrazabilizad('<?php echo $service[0]->session_id; ?>', 'checkout', 'n-a', 'n-a');
        simpleCart.checkout(
            clienteid //clienteId
            , "<?php echo $service[0]->session_id; ?>" //sessionId
            , $('meta[name="csrf-token"]').attr('content') //crsftoken
            , orden //ordenVista
            , pais); //pais
        $('#text-loader').html('');
        jQuery(".loader").fadeIn("slow");
        //simpleCart.empty();
    });

    /*======================================================
          Funciones SimpleCart Js
        ======================================================*/

    simpleCart.ready(function() {
        // get the checkout button into var
        var button = $('.simpleCart_checkout');
        // hide the checkout button
        $(button).prop('disabled', true);
        $('#cart-quantity-resp').hide();
        // get the cart quantity
        var quantity = simpleCart.quantity();

        // do something if item added to cart
        //Al hacer click en añadir carrito / comprar
        simpleCart.bind('afterAdd', function() {
            //Panel Carrito
            $('#cd-cart-trigger').removeClass('speed-in');
            toggle_panel_visibility($('#cd-cart'), $('#cd-shadow-layer'), $('body'));

            if (quantity > 0) {
                //button.show(); // shows the button

            }
        });

        /**** Cuando se suma o resta ****/
        simpleCart.bind('update', function() {
            var total = simpleCart.total();
            if (total > 0) {
                $(button).prop('disabled', false);
                $('.text-cartable').show();
                $('.checkout-btn').show();
                $('.simpleCart_empty').show();
                $('.carrito').show();
                $('.cd-cart-items').show();
                $('#cartempty').hide();
                $('#cart-quantity-resp').show();
                //console.log("se muestra carrito");
            } else {
                //var pais_msg = "<?php echo  strtoupper($datos["pais"]); ?>";
                var msg_vacio
                switch (pais) {
                    case 'us':
                        msg_vacio = "Your cart is empty.";
                        break;
                    case 'US':
                        msg_vacio = "Your cart is empty.";
                        break;
                    default:
                        msg_vacio = "Tu carrito está vacio.";
                        break;
                } //end switch
                //console.log ("carrito vacio");
                $(button).prop('disabled', true);
                $('.text-cartable').hide();
                $('.checkout-btn').hide();
                $('.simpleCart_empty').hide();
                $('.carrito').hide();
                $('.cd-cart-items').hide();
                $('#cartempty').html('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + msg_vacio + '');
                $('#cart-quantity-resp').hide();
            }
        }); //fin


    }); //end simpleCart functions

    /*======================================================
          Botón Menú
        ======================================================*/
    $('.click-menu').on('click', function() {
        $('#cd-shadow-layer').removeClass('is-visible');
        $('#main-nav').removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
            $('body').removeClass('overflow-hidden');
        });

    });

    /*======================================================
        Custom Fullpage.js
      ======================================================*/
    var deleteLog = false;

    /*function addToLog(callbackName, params){
          var callbackData = '<h4>' + callbackName + '</h4>';
          Object.keys(params).forEach(function(key){
              var content =  params[key];

              if(content !== null && typeof content === 'object'){
                  content = JSON.stringify(content);
              }
              callbackData += '<p><b>' + key + '</b>: ' + content + '</p>';
          });
          callbackData += '<br />';

          document.getElementById('callbacksDiv').innerHTML += callbackData;
      }*/

    var myFullpage = new fullpage('#fullpage', {
        //v2compatible: true,
        //anchors: ['controlPeso', 'limpia', '3rdPage'],
        //sectionsColor: ['#FFF', '#1BBC9B', '#e7e7e7'],
        verticalCentered: true,
        menu: '#main-nav',
        css3: true,
        resetSlidersKey: 'aS5pYnJsYXRhbS5jb21fNTJZY21WelpYUlRiR2xrWlhKejlZQw==',
        resetSliders: true,
        scrollingSpeed: 1100,
        normalScrollElements: '#cd-cart,.modal-dialog',

        /*======================================================
          Al cargar la página
          ======================================================*/
        afterLoad: function(origin, destination, direction) {
            var params = {
                origin: origin,
                destination: destination,
                direction: direction
            };
            //jQuery(".loader").fadeIn("slow");
            /*console.log(params['origin']['anchor']);
            console.log(params['destination']['anchor']);*/


            /*======================================================
              Cargo el fondo cuando la familia de producto es la primera al
              verse al cargar la página.
              ======================================================*/
            if (params['origin']['anchor'] === params['destination']['anchor']) { //Pregunto si el origen es igual que el destino
                ////////////////////////////////////////////
                var rutaimage = '<?php echo asset('images/portadas/' . $datos["pais"] . '/') ?>/' + pais + '_' + params['destination']['anchor'];
                ////////////////////////////////////////////
                var slide1 = params['destination']['anchor'] + '_slide1'; //variable para el div del slide
                ///////Slide 1////////////////////////////////
                jQuery('#' + slide1).css("background-image", "url(" + rutaimage + '_01.jpg' + ")"); /*.addClass('load-background');*/ //Cargo Fondo
                ///////Slide 2////////////////////////////////
                var slide2 = params['destination']['anchor'] + '_slide2'; //variable para el div del slide
                jQuery('#' + slide2).css("background-image", "url(" + rutaimage + '_02.jpg' + ")");
            }



            var actualPage = params['destination']['anchor'];
            switch (actualPage) {
                case 'controlpeso':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'WEIGHT MANAGEMENT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'CONTROL DE PESO Y MEDIDAS';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-peso.png') ?>');
                    $('#footer').css("background-color", "#1fb7ee");
                    break;

                case 'limpia':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'CLEANSING';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'LIMPIA';
                        document.getElementById('footer-title-regular').innerHTML = 'TU CUERPO';
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-limpia.png') ?>');
                    $('#footer').css("background-color", "#95c11f");
                    $('#footer-linea').hide(); //escondo palabra LÍNEA

                    break;

                case 'regenera':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'NUTRITION & REGENERATION';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'REGENERA';
                        document.getElementById('footer-title-regular').innerHTML = 'TUS CÉLULAS';
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-regenera.png') ?>');
                    $('#footer').css("background-color", "#1f599d");
                    $('#footer-linea').hide(); //escondo palabra LÍNEA
                    break;

                case 'revitaliza':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'ENERGY & REVITALIZATION';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'REVITALIZA';
                        document.getElementById('footer-title-regular').innerHTML = 'TU ENERGÍA';
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-revitaliza.png') ?>');
                    $('#footer').css("background-color", "#ed7004");
                    $('#footer-linea').hide(); //escondo palabra LÍNEA
                    break;

                case 'inmunologica':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'IMMUNE SUPPORT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'INMUNOLÓGICA';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-inmuno.png') ?>');
                    $('#footer').css("background-color", "#009d7b");
                    break;

                case 'antiedad':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'ANTI-AGE';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'ANTI-EDAD';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-antiedad.png') ?>');
                    $('#footer').css("background-color", "#a3137b");
                    break;

                case 'vigormental':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'MENTAL POWER';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'VIGOR MENTAL';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-vigormental.png') ?>');
                    $('#footer').css("background-color", "#e42313");
                    break;

                case 'sport':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'SPORT PERFORMANCE';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'SPORT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-SPORT.png') ?>');
                    $('#footer').css("background-color", "#7c909b");
                    break;
                    //default:
            }
            //addToLog('afterLoad', params);
            //console.log("--- afterLoad ---");
            //console.log(params);
            //console.log('===============');

            //deleteLog = true;
        },
        /*======================================================
          Al bajar o Subir
          ======================================================*/
        onLeave: function(origin, destination, direction) {
            var params = {
                origin: origin,
                destination: destination,
                direction: direction
            };

            var pais = "<?php echo  strtoupper($datos["pais"]); ?>";
            /*======================================================
              Cargo el fondo del resto de las familias mientras se hace swipe
              ======================================================*/
            if (params['origin']['anchor'] != params['destination']['anchor']) { //Mientras el origen sea distinto del destino
                ////////////////////////////////////////////
                var rutaimage = '<?php echo asset('images/portadas/' . $datos["pais"] . '/') ?>/' + pais + '_' + params['destination']['anchor'];
                ////////////////////////////////////////////
                var slide1 = params['destination']['anchor'] + '_slide1'; //variable para el div del slide
                ///////Slide 1////////////////////////////////
                jQuery('#' + slide1).addClass('fade-in'); //FadeIn
                jQuery('#' + slide1).css("background-image", "url(" + rutaimage + '_01.jpg' + ")"); /*.addClass('load-background');*/ //Cargo Fondo
                ///////Slide 2////////////////////////////////
                var slide2 = params['destination']['anchor'] + '_slide2'; //variable para el div del slide
                jQuery('#' + slide2).css("background-image", "url(" + rutaimage + '_02.jpg' + ")");

            }

            //clearing the logging in the screen
            /*if(deleteLog){
                document.getElementById('callbacksDiv').innerHTML = '';
            }*/

            //document.getElementById(params['destination']['anchor']+'_slide1').classList.add('load-background');

            //addToLog('onLeave', params);
            var actualPage = params['destination']['anchor'];
            switch (actualPage) {
                case 'controlpeso':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'WEIGHT MANAGEMENT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'CONTROL DE PESO Y MEDIDAS';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-peso.png') ?>');
                    $('#footer').css("background-color", "#1fb7ee");
                    break;

                case 'limpia':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'CLEANSING';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'LIMPIA';
                        document.getElementById('footer-title-regular').innerHTML = 'TU CUERPO';
                        $('#footer-linea').hide(); //escondo palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-limpia.png') ?>');
                    $('#footer').css("background-color", "#95c11f");

                    break;

                case 'regenera':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'NUTRITION & REGENERATION';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'REGENERA';
                        document.getElementById('footer-title-regular').innerHTML = 'TUS CÉLULAS';
                        $('#footer-linea').hide(); //escondo palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-regenera.png') ?>');
                    $('#footer').css("background-color", "#1f599d");
                    break;

                case 'revitaliza':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'ENERGY & REVITALIZATION';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'REVITALIZA';
                        document.getElementById('footer-title-regular').innerHTML = 'TU ENERGÍA';
                        $('#footer-linea').hide(); //escondo palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-revitaliza.png') ?>');
                    $('#footer').css("background-color", "#ed7004");
                    break;

                case 'inmunologica':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'IMMUNE SUPPORT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'INMUNOLÓGICA';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-inmuno.png') ?>');
                    $('#footer').css("background-color", "#009d7b");
                    break;

                case 'antiedad':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'ANTI-AGE';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'ANTI-EDAD';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-antiedad.png') ?>');
                    $('#footer').css("background-color", "#a3137b");
                    break;

                case 'vigormental':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'MENTAL POWER';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'VIGOR MENTAL';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-vigormental.png') ?>');
                    $('#footer').css("background-color", "#e42313");
                    break;

                case 'sport':
                    /*======================================================================*/
                    if (pais == 'US') {
                        $('#footer-linea').hide(); //escondo palabra LÍNEA  
                        document.getElementById('footer-title-bold').innerHTML = 'SPORT PERFORMANCE';
                        document.getElementById('footer-title-regular').innerHTML = '';
                    } /*end if US*/
                    else {
                        document.getElementById('footer-title-bold').innerHTML = 'SPORT';
                        document.getElementById('footer-title-regular').innerHTML = '';
                        $('#footer-linea').show(); //muestro palabra LÍNEA
                    } //end else
                    /*======================================================================*/
                    $('#icon-footer').attr('src', '<?php echo asset('images/icons/icon-SPORT.png') ?>');
                    $('#footer').css("background-color", "#7c909b");
                    break;
                    //default:
            } //end Switch

            //console.log("--- onLeave ---");
            //console.log(params);
        },
        /*======================================================
          Al cambiar Slide
          ======================================================*/
        onSlideLeave: function(section, origin, destination, direction) {
            var params = {
                section: section,
                origin: origin,
                destination: destination,
                direction: direction
            };
            var actualSection = params['section']['anchor'];
            var actualSlide = params['destination']['index'];

            /* if(actualSection == 'controlPeso' && actualSlide == 1){
             //document.getElementById('footer-title').innerHTML += ' '+1
             alert("estas en control peso slide 2")  
             }*/

            //clearing the logging in the screen

            /*document.getElementById('callbacksDiv').innerHTML = '';
              
  
              addToLog('onSlideLeave', params);*/

            //console.log("--- onSlideLeave ---");
            //console.log(params);
        }

    });
</script>

<!-- botstrap -->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>