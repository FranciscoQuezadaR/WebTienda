<?php
    require '../proyectoWeb/includes/config/database.php';
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';
    
    $db = new DB();
    $user = new User();
    $userSession = new userSession();
    $codigo = $_GET['codigo'];

    $query = "SELECT *              
              FROM libro, productos
              WHERE libro.codigo = productos.librocodigo AND libro.codigo = ${codigo}";

    $resultado = mysqli_query($db -> connect(), $query);
    $libro     = mysqli_fetch_assoc($resultado);

    if (isset($_SESSION['user'])) 
    {
        if ($user -> userAdmin($userSession -> getCurrentUser())) {
            include_once '../proyectoWeb/includes/templates/header_admin.php';
        } else {
            include_once '../proyectoWeb/includes/templates/header_usuario.php';
        }
    } else {
        include_once '../proyectoWeb/includes/templates/header.php';
    }
?>  
    <main>
        <section class="post__header post__header__producto">

        </section>
        <section class="producto__seleccionado">
            <div class="producto producto__seleccionado__imagen grid__ps1">
                <img src="" alt="">
                <img class="img__estandar" src="<?php echo$libro['img']?>" alt="">
                <img src="img/" alt="">
            </div>
            <div class="producto producto__seleccionado__principal grid__ps2">
                <h5 class="producto__seleccionado__titulo"><?php echo$libro['titulo']?></h5>
                <h5 class="texto__left">$<?php echo$libro['precioVenta']?></h5>
                <h5 class="texto__left">envio $100.00</h5>
                <div class="cantidad__producto">
                    <h5 class="texto__left">cantidad</h5>
                    <input type="number" name="" id="" min="1">
                    <h6>&nbsp;&nbsp;Existencias: <?php echo$libro['existencias']?></h6>
                </div>
                <h5 class="marg__pad">Caracteristicas del producto</h5>
                <div class="producto__seleccionado__descripcion">
                    <h5 class="texto__left">Autor: <?php echo$libro[ 'autor' ];?></h5>
                    <h5 class="texto__left">Editorial: <?php echo$libro[ 'editorial' ];?></h5>
                    <h5 class="texto__left">Idioma: <?php echo$libro[ 'idioma' ];?></h5>
                    <h5 class="texto__left">Numero de páginas: <?php echo$libro[ 'noPaginas' ];?></h5>
                    <h5 class="texto__left">Formato: <?php echo$libro[ 'formato' ];?></h5>
                    <h5 class="texto__left">Año de publicacion: <?php echo$libro[ 'ano' ];?></h5>
                    <h5 class="texto__left">Sinopsis: <?php echo$libro[ 'sinopsis' ];?></h5>
                </div>
            </div>
            <div class="producto__seleccionado__opciones grid__ps3">
                <div class="producto__seleccionado__op">
                    <a href="../../proyectoWeb/includes/config/anade_carro.php?cantProd=1&codigo=<?php echo$codigo?>&request=product"><img class="imagen__opciones" src="../proyectoWeb/categorias/img/añadirCarrito.png" alt=""></a>
                    <h5>añadir a carrito</h5>
                </div>
                <div class="producto__seleccionado__op">
                    <img class="imagen__opciones" src="../proyectoWeb/categorias/img/amor.png" alt="">
                    <h5>Añadir a favoritos</h5>
                </div>
                <div class="producto__seleccionado__op">
                    <form action="">
                        <a href="../../proyectoWeb/comprar.php?codigo=<?php echo$codigo?>"><img class="imagen__opciones" src="../proyectoWeb/categorias/img/signo-de-dolar.png" alt=""></a>
                    </form>
                    <h5>Comprar ahora</h5>
                </div>
                
                <script>
            alert(Math.round(Math.random()*10));
        </script>
            </div>
        </section>

        <section class="productos__recomendados">
            <div class="producto"></div>
            <div class="producto"></div>
            <div class="producto"></div>
            <div class="producto"></div>
        </section>
       
    </main>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>