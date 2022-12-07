<?php
require_once("../util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET'){
  $data = json_decode(file_get_contents('php://input'), true);
  $consulta='';
  if(isset($data['convocatoria'])){
    $convocatoria=strtoupper($data['convocatoria']);
    $consulta="SELECT estudiante,convocatoria,descripcion,id, estado, fecha FROM  postulacion
                  WHERE convocatoria=$convocatoria";
  }
  else if(isset($data['estudiante'])){
    $estudiante=strtoupper($data['estudiante']);
    $consulta="SELECT estudiante,convocatoria,descripcion,id, estado, fecha FROM  postulacion
                  WHERE estudiante=$estudiante";
  }
  else{
    $consulta="SELECT estudiante,convocatoria,descripcion,id, estado, fecha FROM  postulacion
                  WHERE estado = 'ABIERTA'";
  }

  $result = mysqli_query($con,$consulta);

  if($result=== false){
    $respuesta=array(
      'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
    );
    echo json_encode($respuesta,http_response_code(500));
    return;
  }

  else{
        $respuesta=[];
        while($det= mysqli_fetch_array($result)){
          $conv=array(
            'estudiante'=>$det['estudiante'],
            'convocatoria'=> $det['convocatoria'],
            'descripcion' => $det['descripcion'],
            'id'=>$det['id'],
            'fecha'=>$det['fecha'],
            'estado'=>$det['estado']
          );
          $respuesta[]=$conv;
        }
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
