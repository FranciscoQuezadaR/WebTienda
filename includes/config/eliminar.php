<?php
    include_once '../../../proyectoWeb/includes/config/database.php';
    $db = new DB();

    $id = $_GET['id'];

    $query = "DELETE FROM libro 
              WHERE codigo = (SELECT librocodigo 
                              FROM productos
                              WHERE id = '${id}')";

    $resultado = mysqli_query($db -> connect(), $query);

    if ($resultado) {
        ?><script>window.location.href = "../../../../../proyectoWeb/admin/borrar.php";</script><?php
    } else {
        echo "Error";
    }
?>