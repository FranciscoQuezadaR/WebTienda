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

<main> 
    <div class="div__categorias">
    <h2>Todas las categorias</h2>
    <section class="apartado__categorias">
        <a href="../proyectoWeb/categorias/fantasia.php">
            <div class="categoria__fantasia">
                <h5>Fantasia</h5>
            </div>
        </a>
    </section>
    </div>
</main>
<?php
    include '../proyectoWeb/includes/templates/footer.php';
?>
</body>
</html>