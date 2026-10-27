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


    //configuracion de conexion esta funcion conecta con la base de datos usando las credenciales
    $conn = mysqli_connect($datosdeConexion['host'], $datosdeConexion['user'], $datosdeConexion['password'], $datosdeConexion['nombre']);

    //respuesta conexion fallo
    if (!$conn) {

        //nos da errores de conexion y matamos el proceso
        die("Conexión fallida: " . mysqli_connect_error());
    }





    //respuesta conexion exito
    $respuestaConexion =  "Conectado correctamente a {$datosdeConexion['nombre']}";

    $selectSql = 'SELECT 
    product.productId, 
    product.productName,
    supplier.companyName,
    category.categoryName,
    product.quantityPerUnit,
    product.unitPrice,
    product.unitsOnOrder,
    product.reorderLevel,
    product.discontinued
    FROM product
    INNER JOIN supplier ON product.supplierId = supplier.supplierId
    INNER JOIN category ON product.categoryId = category.categoryId
    ORDER BY product.productId ASC';

    $filas = [];

    $query = $conn->query($selectSql);

    if ($query !== false) {
        # code...
        while ($row = $query->fetch_assoc()) {
            # code...
            $filas[] = [
                "id" => $row['productId'] ?? 'null',
                "nombre" => $row['productName'] ?? 'null',
                "supplier" => $row['companyName'] ?? 'null',
                "categoria" => $row['categoryName'] ?? 'null',
                "cantidadUnitaria" => $row['quantityPerUnit'] ?? 'null',
                "unitPrice" => $row['unitPrice'] ?? 'null',
                "unitsOnOrder" => $row['unitsOnOrder'] ?? 'null',
                "reorderLevel" => $row['reorderLevel'] ?? 'null',
                "discontinued" => $row['discontinued'] ?? 'null'
            ];
        }
    }

    //cierra conexion
    mysqli_close($conn);
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
                    <th>Supplier</th>
                    <th>Categoria</th>
                    <th>CantidadUnitaria</th>
                    <th>unitPrice</th>
                    <th>unitsOnOrder</th>
                    <th>reorderLevel</th>
                    <th>discontinued</th>
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
       
    </div>
</body>

</html>