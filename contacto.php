<?php
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';

    $user = new User();
    $userSession = new userSession();
    
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
    <main class="main__contacto">
        <section class="section__form">
            <form class="formulario">
                <fieldset class="fset-con">
                    <div class="contacto">
                        <div class="legend">
                            <legend class="legends">Contactanos</legend>
                        </div>
                        <div class="campo-con">
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre">
                        </div>
                        <div class="campo-con">
                            <input type="email" name="email" placeholder="Email">
                        </div>
                        <div class="campo-con">
                            <textarea name="" id="" placeholder="Cuentanos, ¿que paso?"></textarea>
                        </div>
                        <div class="campo-conb">
                            <a class="boton enlace-boton" href="">Enviar</a>
                        </div>
                    </div>  
                </fieldset>
            </form>
        </section>
    </main>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>