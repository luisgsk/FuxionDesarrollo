<?php session_start(); ?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="cart/jquery.min.js"></script>
        <script src="cart/simpleCart.js"></script>
        <script src="cart/app.js"></script>
        <script>
        $(document).ready(function(){
        simpleCart.empty();
    });
</script>
<script>
    function serviceResponse_old(sessionid,result,data,message){
    
    var ruta = "https://i.ibrlatam.com/fuxion/fuxionApp/public/serviceresponse/"+sessionid+"/"+result+"/"+data+"/"+message
    console.log("ruta: "+ruta);
    $.ajax({
        url: ruta,
        dataType:"json",
        type: "get",
        beforeSend: function(){},
        success: function(response){
               console.log(response);
           
        }//end success
    });
    
}// end serviceResponse()
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 function serviceResponse(sessionid,result,data,message,link){
    
    var ruta = "https://i.ibrlatam.com/fuxion/fuxionApp/public/api/serviceresponse/"
    console.log("ruta: "+ruta);
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: ruta,
        data: {sessionid : sessionid, result : result, data : data, message : message},
        dataType:"json",
        type: "post",
        beforeSend: function(){},
        success: function(response){
               //console.log(response);
               $(window).attr('location',link)   
        }//end success
    });
    
}// end serviceResponse()
</script>

<?php
return
//use App\Http\Controllers\CatalogoController;
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
    "productos"	 :[';

for ($i=1; $i <= $_POST["itemCount"]; $i++) {
	//echo $_POST["item_name_".$i].'<br>';
	//echo str_replace('number: ','',$_POST["item_options_".$i]).'<br>';
	if($i > 1) { $json .= ',';}
	$json .= '
	{"itemCode": "'.str_replace('number: ','',$_POST["item_options_".$i]).'"}
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
            serviceResponse("'.$_POST["sessionId"].'","'.$array["result"].'","'.$response.'","'.$array["message"].'","'.$array["data"].'");
            });
          </script>';
		//echo $array["data"];
	}
    
    /*===================================================
        Si el response es Error, retorno al catálogo
    ====================================================*/
    else {
        header('location: https://i.ibrlatam.com/fuxion/fuxionApp/public/errorservice/'.$_POST["clienteId"].'/service/error');
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