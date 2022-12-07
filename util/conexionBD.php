<?php
          $serverName = "bj9tboqbgxbengvmzl6c-mysql.services.clever-cloud.com";
          $USERNAME="usoda15gbwnvopft";
          $PASSWORD="QWYdk4AWttj4TzWxCm7x";
          $con = mysqli_connect($serverName, $USERNAME, $PASSWORD,"bj9tboqbgxbengvmzl6c");

          if ($con){
              //echo "<h1>Conexión Exitosa desde conexionIcaro.php</h1>";
            } else{
                echo "Falló la Conexión: Póngase en contacto con el administrador del sistema ! </br></br>";
                die( print_r( sqlsrv_errors(), true));
                }
                /*********************************************/
 ?>
