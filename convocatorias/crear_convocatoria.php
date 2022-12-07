<?php
require_once("../util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['docente'])||!isset($data['descripcion'])||!isset($data['proyecto'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $docente=strtoupper($data['docente']);
  $descripcion=strtoupper($data['descripcion']);
  $proyecto=strtoupper($data['proyecto']);

  $insert="INSERT INTO convocatoria(docente, nombre_proyecto, descripcion, estado)
                VALUES ('$docente','$proyecto','$descripcion','ABIERTA')";


  if (!$resultado = $con->query($insert)) {
          $respuesta=array(
            'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
          );
          echo json_encode($respuesta,http_response_code(500));
          return;
      }
  else{
        $respuesta=array(
          'Mensaje'=> 'CONVOCATORIA CREADA CORRECTAMENTE'
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
