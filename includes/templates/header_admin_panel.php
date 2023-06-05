<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FraLu Library</title>
    <link rel="icon" href="img/energia-nuclear.png">
    <link rel="preload" href="/proyectoWeb/css/normalize.css"/>
    <link rel="stylesheet" href="/proyectoWeb/css/normalize.css"/>

    <!-- FUENTES-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p&display=swap" rel="stylesheet"> 

    <script src="https://kit.fontawesome.com/9de6329270.js" crossorigin="anonymous"></script>

    <link rel="preload" href="/proyectoWeb/css/estilos.css">
    <link rel="stylesheet" href="/proyectoWeb/css/estilos.css">
</head>
<body>
    <header class="header__admin">
        <div class="navegacion">
            <div class="logo"> <!-- CLASE LOGO NO EXISTE EN CSS -->
                <a href="../../../proyectoWeb/index.php"><img src="../../../proyectoWeb/img/energia-nuclear.png" alt="logo" title="logo"></a>
            </div>
            
            <div class="paneladmin-dv" style="margin-left: 120px;">
                <h2>PANEL</h2>
                <h2>ADMINISTRADOR</h2>
            </div>

            <label for="check" class="checkbtn">
                <img class="nav__img" src="../../../proyectoWeb/img/lista.png" alt="" id="icono-menu">
            </label>

            <div class="cont-menu active cont-menu__header__admin" id="menu">
            </div>

            <div class="cuenta-dv cuenta__dv__panel">
                <div class="desplegable">
                    <button class="boton-inicio"><img class="cuenta" src="../../../proyectoWeb/img/cuenta.png" alt=""></button>
                    <div class="links-boton links__boton__panel">
                        <a href="../../../proyectoWeb/index.php">Inicio</a>
                        <a href="../../../proyectoWeb/admin/borrar.php">Panel</a>
                        <a href="../../../proyectoWeb/includes/config/logout.php">Cerrar sesion</a>
                    </div>    
                </div>
            </div>
            <script src="../../../proyectoWeb/js/app.js"></script>
        </div>
    </header>