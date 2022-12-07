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
        $respuesta=array();
        while($det= mysqli_fetch_array($result)){
          $estudiante=$det['estudiante'];
          $data = array('id' => $estudiante);
          $url = 'https://gewsjsiv6b.execute-api.us-east-1.amazonaws.com/listar-usuarios';
          $ch = curl_init($url);
          $json = json_encode($data);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
          $result = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          $resultado = json_decode($result, true);
          if($httpcode==200)
          {
            $conv=array(
              'id'=>$estudiante,
              'nombre'=> $resultado['nombre'],
              'correo' => $resultado['correo']
            );
            $respuesta[]=$conv;
          }
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
