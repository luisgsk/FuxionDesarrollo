<?php session_start(); print_r($_POST);?>

<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

    @font-face {
    font-family: 'Scandia-Regular';
    src: url('src/fonts/scandia_web/Scandia-Regular.eot');
    src: url('src/fonts/scandia_web/Scandia-Regular.eot?#iefix') format('embedded-opentype'),
        url('src/fonts/scandia_web/Scandia-Regular.woff') format('woff'),
        url('src/fonts/scandia_web/Scandia-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.scandia-regular {
        font-family: 'Scandia-Regular' !important;
        font-size: 35px;
        color: #535353 !important;
    }

    .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/826.gif') 50% 50% no-repeat rgb(249,249,249);
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
</head>
<body>

<div class="loader">
  <span class="scandia-regular" id="text-loader" style="text-align: center!important;">
        <?php if ($_POST["pais"] == 'us' || $_POST["pais"] == 'US'){
            echo "Please wait, we are processing your request..";
          }else {
            echo "Espera por favor, estamos procesando tu solicitud..";
          }

          ?></span>
</div>

</body>
</html>
<script> var simboloPais = "$"; </script>
<!------------------------------------------------------------------------------------------------------------------>
<script src="cart/jquery.min.js"></script>
        <script src="cart/simpleCart.js"></script>
        <script src="cart/app.js"></script>
        <script>
        /*$(document).ready(function(){
        simpleCart.empty();
    });*/
</script>
<script>
    /*function serviceResponse_old(sessionid,result,data,message){
    
    var ruta = "https://i.ibrlatam.com/fuxion/desa/public/serviceresponse/"+sessionid+"/"+result+"/"+data+"/"+message
    console.log("ruta: "+ruta);
    $.ajax({
        url: ruta,
        dataType:"json",
        type: "get",
        beforeSend: function(){console.log("esperando respuesta del servicio..")},
        success: function(response){
               //console.log(response);
               console.log("respuesta del servicio obtenida.")
           
        }//end success
    });
    
}// end serviceResponse()*/
<?php $tk = md5('serviceresponse'); ?>
/************************************************************
    Función que guarda el response del servicio.
************************************************************/
 function serviceResponse(sessionid,result,data,message,link){
    //var ruta = "https://i.ibrlatam.com/fuxion/desa/public/api/serviceresponse"
    var ruta = "https://i.ibrlatam.com/fuxion/desa/public/serviceresponse/"+sessionid+"/"+result+"/"+data+"/"+message
    //console.log("ruta: "+ruta);
    $.ajax({
        url: ruta,
        //data: {sessionid : sessionid, result : result, data : data, message : message},
        dataType:"json",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': "<?php echo $_POST["csrftoken"]; ?>" },
        beforeSend: function(){console.log("esperando respuesta del servicio..")},
        success: function(response){
               //console.log(response);
                console.log("respuesta del servicio obtenida.");
                simpleCart.empty();
               $(window).attr('location',link);   
        }//end success
    });
    
}// end serviceResponse()
</script>



<?php
/************************************************************
    Armo el Json y lo envío mediante CURL al service.
************************************************************/
use App\Http\Controllers\CatalogoController;
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo 'cantidad de productos: '.$_POST["itemCount"].'<br><hr>';
echo '<pre>';
print_r($_POST);
echo '</pre>';
die();*/
$json = '{
    "customerId" : "'.$_POST["clienteId"].'",
    "catalogoId" : "'.$_POST["sessionId"].'",
    "codCat"     : "'.$_POST["ordenVista"].'",
    "productos"	 :[';

for ($i=1; $i <= $_POST["itemCount"]; $i++) {
	//echo $_POST["item_name_".$i].'<br>';
	//echo str_replace('number: ','',$_POST["item_options_".$i]).'<br>';
	if($i > 1) { $json .= ',';}
	$json .= '
	{"itemCode": "'.str_replace('number: ','',$_POST["item_options_".$i]).'",
     "cantidad": '.$_POST["item_quantity_".$i].'}
	';
}
$json .= ']}';

//print_r($json);die();
// Prepare new cURL resource
$ch = curl_init("https://offix.fuxion.com/api/Omni/generateToken");

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Accept: application/json',
'Content-Type: application/json',
'Content-Length: ' . strlen($json))
);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);

//Disable CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER by
//setting them to false.
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLINFO_HEADER_OUT, false);

//execute the POST request
$result = curl_exec($ch);
curl_close($ch);
$array=json_decode($result,true);

    /*===================================================
        Guardo response del servicio
    ====================================================*/
    $response = str_replace('https://offix.fuxion.com/loginomni/?', '', $array["data"]);

    /*===================================================
        Si el response es Ok, redirijo a la url retornada
    ====================================================*/
	if($array["result"] == 1){
		//header('location: '.$array["data"]);
        echo '<script>
            $(document).ready(function(){
            simpleCart.empty();
            serviceResponse("'.$_POST["sessionId"].'","'.$array["result"].'","'.$response.'","'.$array["message"].'","'.$array["data"].'");
            });
          </script>';
		//echo $array["data"];
	}
    
    /*===================================================
        Si el response es Error, retorno al catálogo
    ====================================================*/
    else {
        header('location: https://i.ibrlatam.com/fuxion/desa/public/errorservice/'.$_POST["clienteId"].'/service/error');
    }

//Ejemplo:
/*$json = '{
    "customerId" : "864004",
    "catalogoId" : "A123A55s4",
    "productos" : [{
                    "itemCode":"144404",
                    "cantidad": 2
                  },
                  {
                    "itemCode":"144175"
                  }
                ]
}';*/

?>