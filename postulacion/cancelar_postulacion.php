<?php
require_once("../util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['postulacion'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $postulacion=strtoupper($data['postulacion']);

  $update="UPDATE postulacion set estado='CERRADA'
                WHERE id=$postulacion";


  if (!$resultado = $con->query($update)) {
          $respuesta=array(
            'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
          );
          echo json_encode($respuesta,http_response_code(500));
          return;
      }
  else{
        $respuesta=array(
          'Mensaje'=> 'POSTULACIÓN CERRADA CORRECTAMENTE'
        );
        echo json_encode($respuesta,http_response_code(200));
        return;
      }
}

else{
  $respuesta=array(
    'Error'=> 'METODO NO VALIDO'
  );
  echo json_encode($respuesta,http_response_code(400));
  return;
}

 ?>
