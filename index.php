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

<script src="../proyectoWeb/js/jquery.js"></script>
<script src="js/bxslider-4-4.2.12/src/js/jquery.bxslider.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">

<script>
  $(document).ready(function(){
	$('.bxslider').bxSlider(
		{
			auto:false
        }
	);
  });
</script>

    <main>
        <div class="post__header">
            <div class="slider">
                <ul class="bxslider">
                    <li><img src="js/bxslider-4-4.2.12/docs_src/assets/img/photo1.jpeg"/></li>
                    <li><img src="js/bxslider-4-4.2.12/docs_src/assets/img/photo2.jpeg"/></li>
                    <li><img src="js/bxslider-4-4.2.12/docs_src/assets/img/photo3.jpeg"/></li>
                    <li><img src="js/bxslider-4-4.2.12/docs_src/assets/img/photo4.jpeg"/></li>
                </ul>
            </div> 
        </div>

        <div class="contenedor__varios"></div>
        
        <!-- Secciones de categorias -->
        <section class="apartado__cate">
            <div class="apartado__1 apartados apartados__frases">
                <div class="frase">
                    <q><i>Los libros son una incomparable magia portátil</i></q><span>Stephen King.</span>
                </div>
            </div>
            <div class="apartado__2 apartados">
                Lo mas vendido
            </div>
            <div class="apartado__3 apartados">
                Lo mas nuevo
            </div>
            <div class="apartados apartado__4">
                Tu carrito
            </div>
        </section>
        <!-- Fin de secciones de categorias -->
        <section class="ofertas">
            <div class="oferta1">Oferta 1</div>
            <div class="oferta1">Oferta 1</div>
            <div class="oferta1">Oferta 1</div>
        </section>
        <Section class="secciones">
            <div class="grid__seccion1 animadoDI"></div>
            <div class="grid__seccion2 animadoDI">
                <h4>Descubre un mundo totalmente diferente.</h4>
            </div>
            <div class="grid__seccion3 animadoID">
                <img src="img/varios/alice.png" alt="">
            </div>

            <div class="grid__seccion4 animadoID"></div>
            <div class="grid__seccion5 animadoID">
                <h4>Un mundo de magia y fantasia.</h4>
            </div>
            <div class="grid__seccion6 animadoDI">
                <img src="img/varios/harry-potter.png" alt="">
            </div>

            <div class="grid__seccion7 animadoDI"></div>
            <div class="grid__seccion8 animadoDI">
                <h4>Lleno de brujas, magos y criaturas fantasticas.</h4>
            </div>
            <div class="grid__seccion9 animadoID">
                <img src="img/varios/af.png" alt="">
            </div>
        </Section>
        <section class="logistica2">
            <section class="marcas">
                <div class="div-editorial">
                    <img class="salamandra" src="img/editoriales/salamandra.png" alt="">
                </div>
                <div class="div-editorial">
                    <img class="anagrama" src="img/editoriales/anagrama.png" alt="">
                </div>
                <div class="div-editorial">
                    <img class="belac" src="img/editoriales/belacqva.png" alt="">
                </div>
            </section>
    </main>
    <script src="js/animar.js"></script>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>