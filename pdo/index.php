<?php
//sacar datos para conexion

$datosdeConexion = [];
$respuestaConexion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $dbname = isset($_POST['dbname']) ? $_POST['dbname'] : '';
    $dbuser = isset($_POST['dbuser']) ? $_POST['dbuser'] : '';
    $dbhost = isset($_POST['dbhost']) ? $_POST['dbhost'] : '';
    $dbpassword = isset($_POST['dbpassword']) ?  $_POST['dbpassword'] : '';


    $datosdeConexion = [
        "nombre" => $dbname,
        "user" => $dbuser,
        "host" => $dbhost,
        "password" => $dbpassword
    ];


    
    
    try {
    //instancia de pdo con las credenciales de nuestra base de datos
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
    $respuestaConexion =  "Connected to $dbname at $dbhost successfully.";

    $selectSql = 'SELECT * FROM customer';



    $filas = [];

    $query = $conn->query($selectSql);

   while ($resultado = $query->fetch(PDO::FETCH_ASSOC)) {
    # code...
     $filas[] = [
                "id" => $resultado['custId'] ?? 'null',
                "nombre" => $resultado['companyName'] ?? 'null',
                "contactName" => $resultado['contactName'] ?? 'null',
                "contactTitle" => $resultado['contactTitle'] ?? 'null',
                "address" => $resultado['address'] ?? 'null',
                "city" => $resultado['city'] ?? 'null',
                "region" => $resultado['region'] ?? 'null',
                "postalCode" => $resultado['postalCode'] ?? 'null',
                "country" => $resultado['country'] ?? 'null',
                "phone" => $resultado['phone'] ?? 'null',
                "mobile" => $resultado['mobile'] ?? 'null',
                "email" => $resultado['email'] ?? 'null',
                "fax" => $resultado['fax'] ?? 'null'
            ];
            } 
            
            
            } catch (PDOException $pe) {
                //respuesta conexion fallo
                die("Could not connect to the database $dbname :" . $pe->getMessage());
                }
                
                }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>CONEXIÓN SQLI</h1>
    <div class="formulario" id="formulario">
        <form action="" method="post">
            <label for="databasename">
                Nombre de la Base de Datos:
                <input type="text" name="dbname" id="databasename" required>
            </label>
            <label for="databaseuser">
                Nombre del Usuario:
                <input type="text" name="dbuser" id="databaseuser" required>
            </label>
            <label for="databasehost">
                Servidor de la Base de Datos:
                <input type="text" name="dbhost" id="databasehost" required>
            </label>
            <label for="databasepasswrd">
                Contraseña:
                <input type="password" name="dbpassword" id="databasepasswrd" required>
            </label>
            <input type="submit" value="Conectar">
            <input type="reset" value="Limiar Formulario">
        </form>
    </div>

    <div class="resultado">
        <h2>Estos son los datos para la conexion:</h2>
        <ul>
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {


                foreach ($datosdeConexion as $key => $value) {
                    # code...
                    echo "<li>$key : $value</li>";
                }
            }

          
            ?>
        </ul>

        <h4>Resultado de la conexion:</h4>
        <h5><?php 
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            echo $respuestaConexion;
    
            } ?></h5>

             <h4>Resultado de las consultas:</h4>

        <table>

             
        
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>contactName</th>
                    <th>contactTitle</th>
                    <th>address</th>
                    <th>city</th>
                    <th>region</th>
                    <th>postalCode</th>
                    <th>country</th>
                    <th>phone</th>
                    <th>mobile</th>
                    <th>email</th>
                    <th>fax</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                 if ($filas !== null) {
                    # code...

                    foreach ($filas as $fila) {
                        # code...
                        echo "<tr>";
                        foreach ($fila as $key => $value) {
                            # code...
                            echo "<td>$value</td>";
                        }
                        
                        echo "</tr>";
                    }
                 }
                    
        ?>
            
            </tbody>
        </table>


<?php 

?>
    </div>
</body>

</html>