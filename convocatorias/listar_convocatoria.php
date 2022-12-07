<?php
require_once("../util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET'){
  $data = json_decode(file_get_contents('php://input'), true);
  $consulta='';
  if(isset($data['docente'])){
    $docente=strtoupper($data['docente']);
    $consulta="SELECT docente,nombre_proyecto,descripcion,id, estado, fecha_apertura FROM  convocatoria
                  WHERE docente=$docente";
  }
  else if(isset($data['convocatoria'])){
    $id=strtoupper($data['convocatoria']);
    $consulta="SELECT docente,nombre_proyecto,descripcion,id, estado, fecha_apertura FROM  convocatoria
                  WHERE id=$id";
  }
  else{
    $consulta="SELECT docente,nombre_proyecto,descripcion,id, estado, fecha_apertura FROM  convocatoria
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
            'docente'=>$det['docente'],
            'nombre_proyecto'=> $det['nombre_proyecto'],
            'descripcion' => $det['descripcion'],
            'id'=>$det['id'],
            'fecha_creacion'=>$det['fecha_creacion'],
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
