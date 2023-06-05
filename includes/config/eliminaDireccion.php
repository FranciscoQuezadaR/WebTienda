<?php
    include_once '../../../proyectoWeb/includes/config/database.php';
    $db = new DB();

    $id = $_GET['id'];

    $query = "DELETE FROM direcciones 
              WHERE id = '${id}'";

    $resultado = mysqli_query($db -> connect(), $query);

    if ($resultado) {
        ?><script>window.location.href = "../../../proyectoWeb/agregar__direccion.php";</script><?php
    } else {
        echo "Error";
    }
?>