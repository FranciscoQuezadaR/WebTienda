<?php
    include_once '../../../proyectoWeb/includes/config/database.php';
    $db = new DB();

    $id = $_GET['id'];
    $query = "DELETE FROM carrito WHERE productosid = '${id}'";
    mysqli_query($db -> connect(), $query);
    ?><script>window.location.href = "../../../../../proyectoWeb/carrito.php";</script><?php
?>