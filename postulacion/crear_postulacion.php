<?php
require_once("../util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['estudiante'])||!isset($data['descripcion'])||!isset($data['convocatoria'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $estudiante=strtoupper($data['estudiante']);
  $descripcion=strtoupper($data['descripcion']);
  $convocatoria=strtoupper($data['convocatoria']);

  $insert="INSERT INTO postulacion(estudiante, convocatoria, descripcion, estado)
                VALUES ($estudiante,$convocatoria,'$descripcion','ABIERTA')";


  if (!$resultado = $con->query($insert)) {
          $respuesta=array(
            'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE '
          );
          echo json_encode($respuesta,http_response_code(500));
          return;
      }
  else{
        $respuesta=array(
          'Mensaje'=> 'POSTULACIÓN CREADA CORRECTAMENTE'
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
