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
    <section class="post-header">
    </section>
    <main>
        <section class="contenedor__inovacion">
            
        </section>
        <section class="nosotros">
            <div class="nosotros__grid1"><h2>Sobre nosotros</h2></div>
            <div class="fotos">
                <div class="luis nosotros__grid2"></div>
            </div>
            
            <div class="descripcion-personal nosotros__grid3">
                <h2>Luis Enrique Batres Martinez</h2>
                <p>
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                </p>
            </div>
            <div class="fotos">
                <div class="frank nosotros__grid4"></div>
            </div>
            
            <div class="descripcion-personal nosotros__grid5">
                <h2>Francisco Quezada Rivera</h2>
                <p>
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                Estudiante de ingernieria en sistemas
                </p>
            </div>
        </section>
        <section class="sobre__empresa">
            <div class="empresa">
                <div><h2>Sobre nuestra empresa</h2></div>
                <div>
                    <p>
                        Fralu library nacio de la idea y la creencia de que la lectura es fundamental para 
                        el desarrollo de nuestra vida social, salud y fortaleza mental. 
                        Fralu labrary nace de los nombres de los creadores Fralu (Francisco) y Lu (Luis).
                    </p>
                </div>
            </div>
                
            <div><h2>Logistica</h2></div>
            <section class="logistica">
                <div class="proceso-entrega">
                    Preparacion.
                    <img class="proceso-logistica" src="img/ubicacion.png" alt=""><br>
                    Preparamos tu pedido <br>con el mayor cuidado.
                </div>
                <img class="flecha-logistica" src="img/flecha.png" alt="">
                <div class="proceso-entrega">
                    Logistica.<br>
                    <img class="proceso-logistica" src="img/logistica.png" alt=""><br>
                    Analizamos tu envio para que llegue seguro lo antes posible.
                </div>
                <img class="flecha-logistica" src="img/flecha.png" alt="">
                <div class="proceso-entrega">
                    Transporte.
                    <img class="proceso-logistica" src="img/camion.png" alt=""><br>
                    Tu pedido 100% seguro en ruta de entrega desde nuestras oficinas.
                </div>
                <img class="flecha-logistica" src="img/flecha.png" alt="">
                <div class="proceso-entrega">
                    Despacho.
                    <img class="proceso-logistica" src="img/entrega.png" alt=""><br>
                    Te llega hasta la puerta de tu casa intacto.
                </div>
            </section>
            
        </section>
        </section>
    </main>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>