<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controllers;
use App\Interaccion;
use App\Producto;
use App\Simbolo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;


class CatalogoController extends Controller
{

  /*=================================================
          Función principal Index
      ================================================*/
  public function index($orden, $token, $nombre, $pais)
  {

    $sql_session = 'SET NOCOUNT ON ; exec SP_GET_INFO_SESSION_OMNI_FUXION "' . $token . '", "' . $nombre . '", "' . $pais . '","' . $orden . '" ';
    $service = DB::select($sql_session);
    $datos = ['orden' => $orden, 'token' => $token, 'nombre' => $nombre, 'pais' => $pais];

    /*=================================================
          Si el País es Peru, por ahora NO traigo el arreglo
          de datos de productos de la Base de datos.
          ================================================*/
    if ($pais == 'pe') {
      return view('catalogo', compact('datos', 'service'));
    } else {
      /*=================================================
          Si el País NO es Perú, traigo el arreglo de datos
          de los productos desde la base de datos y le paso
          el array $productos a la vista.
          ================================================*/
      //$sql_productos = 'SET NOCOUNT ON ; exec SP_GET_DATA_PRODUCTOS_OMNI_FUXION "'.$pais.'" ';
      //$productos = DB::select($sql_productos);
      $simbolo = Simbolo::all()->where('pais', strtoupper($pais))->toArray();
      $productos = Producto::all()->where('pais', strtoupper($pais));
      //return view('catalogo')->with('datos', $datos);
      return view('catalogo', compact('datos', 'service', 'productos', 'simbolo'));
    }
  } //end index()

  /*=================================================
          Función que guarda la trazabilidad de
          interacciones de los usuarios.
      ================================================*/
  public static function setLog($session_id, $accion, $producto, $familia)
  {
    //$sql = 'SET NOCOUNT ON ; exec SP_GET_TRAZABILIZAD_OMNI_FUXION "'.$session_id.'", "'.$accion.'", "'.$producto.'","'.$familia.'" ';
    //return DB::select($sql);
    Interaccion::create([
      'session_id' => $session_id,
      'accion' => $accion,
      'producto' => $producto,
      'familia' => $familia,
      'created' => Carbon::now()->format('Ymd h:i:s')
    ]);
  } //end setLog()

  /*=================================================
          Función que guarda la respuesta del servicio
          Offix.
      ================================================*/
  public static function serviceResponse($session_id, $result, $data, $message)
  {
    $sql = 'SET NOCOUNT ON ; exec SP_GET_SERVICE_RESPONSE_OMNI_FUXION "' . $session_id . '", "' . $result . '", "' . $data . '","' . $message . '" ';
    return DB::select($sql);
  } //end servieResponse()

  /*=================================================
          Función sin usar
      ================================================*/
  public static function serviceResponse_api(Request $request)
  {
    $session_id = $request->input('session_id');
    $result     = $request->input('result');
    $data       = $request->input('data');
    $message    = $request->input('message');
    $sql = 'SET NOCOUNT ON ; exec SP_GET_SERVICE_RESPONSE_OMNI_FUXION "' . $session_id . '", "' . $result . '", "' . $data . '","' . $message . '" ';
    return DB::select($sql);
  } //end servieResponse()


}//end class
