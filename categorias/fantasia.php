<?php
    include_once '../../proyectoWeb/includes/config/database.php';
    include_once '../includes/config/user_session.php';
    include_once '../includes/config/user.php';
    
    $db = new DB();
    $user = new User();
    $userSession = new userSession();

    $query = "SELECT *              
              FROM libro, productos
              WHERE libro.codigo = productos.librocodigo";

    $resultado = mysqli_query($db -> connect(), $query);

    if (isset($_SESSION['user'])) 
    {
        if ($user -> userAdmin($userSession -> getCurrentUser())) {
            include_once '../includes/templates/header_admin.php';
        } else {
            include_once '../includes/templates/header_usuario.php';
        }
    } else {
        include_once '../includes/templates/header.php';
    }
?>

<main>
    <h2 class="fanta">Fantasia</h2>
    <section class="contenedor__fantasia">
        <?php
            $cont=0;
            while ($libro = mysqli_fetch_assoc($resultado)):
                if (($libro ['categoria'] == 'Fantasia') and ($libro['existencias'] > 0)) {
        ?>
            <div class="producto producto-abajo">
                <div class="producto-opciones">
                    <a href="../../proyectoWeb/includes/config/anade_carro.php?cantProd=1&codigo=<?php echo$libro['codigo']?>&request=fantasy"><img src="img/añadirCarrito.png" alt=""></a><br>
                    <a href=""><img src="img/amor.png" alt=""></a><br>
                    <a href="../../proyectoWeb/comprar.php?codigo=<?php echo$libro['codigo']?>"><img src="img/signo-de-dolar.png" alt=""></a>
                </div>
                <form method="GET">
                    <a href="../../proyectoWeb/producto.php?codigo=<?php echo$libro['codigo']?>">
                        <img src="<?php echo $libro ['img'] ?>">
                    </a>
                </form>
                <div class="producto-titulo">
                    <p><?php echo $libro ['titulo'] ?></p>
                </div>
                <div class="producto-precios">
                    $<?php echo $libro ['precioVenta'] ?>
                </div>
            </div>          
        <?php } endwhile; ?>
    </section>
</main>
<?php
    include '../includes/templates/footer.php';
?>
</body>
</html>