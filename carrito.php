<?php
    include_once '../proyectoWeb/includes/config/database.php';
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';

    $userClass = new User();
    $userSession = new userSession(); 

    $db = new DB();
    $carroVacio = true;

    if (isset($_SESSION['user'])) {
        $user = $userSession->getCurrentUser();
        $query = "SELECT id FROM usuarios WHERE email = '${user}'";
        $resultado = mysqli_query($db->connect(), $query);
        $id = mysqli_fetch_assoc($resultado);
        $id = $id ['id'];
        
        $queryCarrito = "SELECT * FROM carrito WHERE usuariosid = '${id}'";
        $resultadoCarrito = mysqli_query($db -> connect(), $queryCarrito);
        $rows = mysqli_num_rows($resultadoCarrito);

        if ($rows > 0) {
            $carroVacio = false;
        }

        if ($userClass -> userAdmin($user)) {
            include_once '../proyectoWeb/includes/templates/header_admin.php';
        } else {
            include_once '../proyectoWeb/includes/templates/header_usuario.php';
        }

    } else {
        ?><script>window.location.href = "../../../proyectoWeb/iniciosesion.php";</script><?php
    }

    /*
    $contador = 1;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valor = $_POST['cant'];
        $id = $_POST['id'];

        $query = "UPDATE carrito
                    SET cantProd = '${valor}'
                    WHERE id = '${id}'";

        $resultado = mysqli_query($db -> connect(), $query);

        echo("<meta http-equiv='refresh' content='1'>");
    }
       */                 
?>
<main class="main__contacto main__carrito">
    <section class="seccion__carrito secc__car2">
        <?php
            if ($carroVacio) {?>
                <div class="carrito__vacio">
                    <h5>Tu carrito esta vacio</h5>
                </div>
            <?php
            } else {  }
            $sumador = 0;
            while($productos = mysqli_fetch_assoc($resultadoCarrito)) {

                $queryEliminaCarro = "SELECT DISTINCT c.id
                                      FROM carrito AS c, productos AS p
                                      INNER JOIN carrito AS carro ON (carro.productosid IN (p.id))
                                      WHERE c.usuariosid = '${id}'";
                $resultadoEliminaCarro = mysqli_query($db -> connect(), $queryEliminaCarro);
                $fetchEliminaCarro = mysqli_fetch_assoc($resultadoEliminaCarro);
                /*
                while ($fetchEliminaCarro = mysqli_fetch_assoc($resultadoEliminaCarro)) {
                    $idCarro = $fetchEliminaCarro['id'];
                    $queryEliminaCarro = " DELETE FROM carrito
                                           WHERE usuariosid = '${id}' AND
                                           id = '${idCarro}';";

                    $resultadoEliminaCarro = mysqli_query($db -> connect(), $queryEliminaCarro);
                }*/

                $resultadoEliminaCarro = mysqli_query($db -> connect(), $queryEliminaCarro);
                
                $prodid = $productos ['productosid'];
                $querylibroCod = "SELECT librocodigo FROM productos WHERE id = ${prodid}";
                $resultadoLibroCod = mysqli_query($db -> connect(), $querylibroCod);
                $codigo = mysqli_fetch_assoc($resultadoLibroCod);
                $prodCod = $codigo['librocodigo'];
                $queryLibro = "SELECT titulo, formato, existencias, precioVenta, img
                               FROM productos, libro
                               WHERE productos.id = ${prodid}
                               AND (libro.codigo = ${prodCod})";
                $resultadoLibro = mysqli_query($db -> connect(), $queryLibro);
                $finalResult = mysqli_fetch_assoc($resultadoLibro);

                $idU = $productos ['usuariosid'];
                $idC = $productos ['id'];
                $exis = $finalResult['existencias'];
                $queryEliminaCarro = "DELETE FROM carrito
                                      WHERE usuariosid = '${idU}' 
                                      AND productosid = (SELECT id FROM productos 
                                                         WHERE id = '${prodid}' AND existencias = '0');";

                $resultadoEliminaCarro = mysqli_query($db -> connect(), $queryEliminaCarro);

                if ($finalResult ['existencias'] > 0) {
        ?>
                <div class="articulo articulo__carrito">

                <!--
                    <div class="checkbox__carro">
                        <input type="checkbox" name="" id="" checked>
                    </div>
                -->

                    <div class="imagen__carrito">
                        <img src="<?php echo$finalResult['img']?>" alt="">
                    </div>
                    <div class="producto__info">
                        <div class="producto-titulo producto-titulo__carro">
                            <p><?php echo$finalResult['titulo']?></p>
                        </div>
                        <div class="producto-precios producto__precio__carro">
                            <p>$<?php echo$finalResult['precioVenta']; $sumador += $finalResult['precioVenta']?></p>
                        </div>
                        <div class="producto-precios tipo__producto__carro">
                            <p class="tpc"><?php echo$finalResult['formato']?></p>
                        </div>
                        <!--
                        <div class="producto-precios tipo__producto__carro cantidad__producto">
                            <p>Cantidad:</p>
                            <form method="POST">
                                <select id="" class="selectCantidad" name="cant" onchange="clickear()"> 
                                    <?php /* 
                                           while( $contador <= $finalResult['existencias']) {
                                                if ($productos['cantProd'] == $contador) {
                                                    ?>
                                                    <option value="<?php echo $contador?>" selected><?php echo $contador?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $contador?>"><?php echo $contador?></option>

                                            <?php } $contador++; }*/ ?>
                                </select>&nbsp;
                                <input type="hidden" value="<?php /*echo$productos['id']*/?>" name="id">
                                <input type="submit" class="hidden" onclick="" id="click">
                            </form> -->
                            <p class="x">(Existencias <?php echo$finalResult['existencias']?>)<span class="z">|<span>
                            <a class="enlaces" href="../proyectoWeb/includes/config/elimina_carro.php?id=<?php echo$prodid?>">Eliminar</a>
                            </p>
                            
                        </div>
                    </div>
                </div>
                <script>
                    function clickear() {
                        document.getElementById("click").click();
                    }
                </script>
        <?php
            } } if (!$carroVacio) {
        ?>
                    <section class="articulo total__carrito">
                        <div>
                            <h5>Subtotal</h5>
                            <h5>Envio</h5>
                            <h5>Total</h5>
                        </div>
                        <div class="div__totales__valores">
                            <h5>$<?php echo$sumador?></h5>
                            <h5>$100.00</h5>
                            <h5>$<?php echo$sumador+100;?></h5>
                        </div>
                    </section>
                    <section class="botones__comprar">
                        <form action="../proyectoWeb/comprar.php" method="GET">
                            <div class="boton__ir_a_pagar">
                                <input type="hidden" name="carrito" value="buy">
                                <input class="boton-in" type="submit" value="Ir a pagar">
                            </div>
                        </form>
                    </section>
        <?php }?>
    </section>
</main>
    <?php include '../proyectoWeb/includes/templates/footer.php'; ?>
</body>
</html>