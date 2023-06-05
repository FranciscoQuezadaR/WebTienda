<?php
    include_once '../../../proyectoWeb/includes/config/database.php';
    include_once '../../../proyectoWeb/includes/config/user_session.php';

    $db = new DB();
    $userSession = new userSession();
    if (isset($_SESSION['user'])) 
    {
        $actualUser = $userSession->getCurrentUser();
        $queryId = "SELECT id FROM usuarios WHERE email = '${actualUser}'";
        $resultadoId = mysqli_query($db -> connect(), $queryId);
      
        $id = mysqli_fetch_assoc($resultadoId);

        
        $codigoLibro = $_GET['codigo'];
        $usuariosid = $id['id'];

        $uqeryPI = "SELECT id FROM productos WHERE librocodigo = '${codigoLibro}'";
        $resultadoPI = mysqli_query($db -> connect(), $uqeryPI);
        $idP = mysqli_fetch_assoc($resultadoPI);
        $productosId = $idP['id'];

        // Validador de exixstencia en carrito
        $queryVali = "SELECT * FROM carrito WHERE usuariosid = ${usuariosid} AND productosid = ${productosId}";
        $resultadoVali = mysqli_query($db -> connect(), $queryVali);
        $selected = mysqli_fetch_assoc($resultadoVali);
        $rows = mysqli_num_rows($resultadoVali);

        $request = $_GET['request'];
        $code = $_GET['codigo'];

        echo $code;

        if ($rows == 0) {
            $cantProd = $_GET['cantProd'];
            $query = "INSERT INTO carrito (cantProd, usuariosid, productosid)
                  VALUES ('$cantProd', '$usuariosid', '$productosId')";

            $resultado = mysqli_query($db -> connect(), $query);
            if ($resultado && $request == 'fantasy') {
                ?><script>window.location.href = "../../../../../proyectoWeb/categorias/fantasia.php";</script><?php
            } else {
                ?><script>window.location.href = "../../../../../proyectoWeb/producto.php?codigo=<?php echo$code?>";</script><?php
            }
        } else {
            ?><script>window.location.href = "../../../../../proyectoWeb/categorias/fantasia.php";</script><?php
        }

    } else {
        ?><script>window.location.href = "../../../../../proyectoWeb/iniciosesion.php";</script><?php
    }

    

   
?>