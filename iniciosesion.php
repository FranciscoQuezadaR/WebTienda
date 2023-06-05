<?php
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';

    $userSession = new userSession();
    $user = new User();
    $errorLogin = "";

    if (isset($_SESSION['user'])) 
    {
        ?><script>window.location.href = "../../../proyectoWeb/index.php";</script><?php
    } 
    else if (isset($_POST['email']) && isset($_POST['contrasena'])) 
    {
        if ($_POST['email'] != "" && $_POST['contrasena'] != "") 
        {
            $userForm = $_POST['email'];
            $passForm = $_POST['contrasena'];

            if ($user -> userExist($userForm, $passForm)) 
            {
                $userSession -> setCurrentUser($userForm);
                $user -> setUser($userForm);
                include_once '../proyectoWeb/index.php';
            } 
            else 
            {
                $errorLogin = "Nombre de usuario y/o contraseña incorrectos";
                include_once '../proyectoWeb/iniciosesion.php';
            }
        }
        else {
            $errorLogin = "Nombre de usuario y/o contraseña incorrectos";
        }    
    } else 
    {
        include_once '../proyectoWeb/iniciosesion.php';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FraLu Library | Inicia Sesion</title>
    <link rel="icon" href="img/energia-nuclear.png">
    <link rel="preload" href="css/normalize.css"/>
    <link rel="stylesheet" href="css/normalize.css"/>
    

    <!-- FUENTES-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p&display=swap" rel="stylesheet"> 

    <script src="https://kit.fontawesome.com/9de6329270.js" crossorigin="anonymous"></script>

    <link rel="preload" href="css/estilos.css">
    <link rel="stylesheet" href="css/estilos.css">

    <script type="text/javascript">vali</script>
</head>
<body>
    <header class="header-sesion-registro-contacto header__padding__bottom">
        <div class="navegacion">
            <div class="logo logo_"> <!-- CLASE LOGO NO EXISTE EN CSS -->
                <a href="../../../proyectoWeb/index.php"><img src="img/energia-nuclear.png" alt="logo" title="logo"></a>
            </div>
        </div>
    </header>
    <main>
        <section>

            <form class="formulario" method="post">
                <div class="login__bienvenido">
                </div>
                <div id="error">
                    <h3 class="error"><?php echo$errorLogin?></h3>
                </div>
                <fieldset class="fieldset__sesion">
                    <div class="inicio__sesion">
                        <div class="campo-in">
                            <input class="campo__texto" type="text" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="campo-in">
                            <input class="campo__texto" type="password" name="contrasena" id="contrasena" placeholder="Contraseña">
                        </div>
                        <div class="campo-ins botones">
                            <input class="boton-in" type="submit" value="Iniciar sesion" name="" id="">
                            <a href="registro.php"><input class="boton-in" type="button" value="Registrarme" name="" id=""></a>
                        </div>
                        <div class="contraseña-olvidada">
                            <!-- <a href="#">Olvide mi contraseña!</a> -->
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