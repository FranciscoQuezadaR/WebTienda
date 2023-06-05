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
    <header class="header">
            <div class="navegacion">
                <div class="logo"> <!-- CLASE LOGO NO EXISTE EN CSS -->
                    <a href="../../../proyectoWeb/index.php"><img src="../../../proyectoWeb/img/energia-nuclear.png" alt="logo" title="logo"></a>
                </div>
                <label for="check" class="checkbtn">
                    <img class="nav__img" src="../../../proyectoWeb/img/lista.png" alt="" id="icono-menu">
                </label>
                
                <div class="cont-menu active" id="menu">
                </div>
                    <nav class="navegacion-principal">
                        <ul class="nav">
                            <li><a href="../../../proyectoWeb/index.php" class="nav-item">Inicio</a></li>
                            <li><a href="../../../proyectoWeb/about.php" class="nav-item">Nosotros</a></li>
                            <li><a href="../../../proyectoWeb/categorias.php" class="nav-item display__categorias">Categorias</a>
                                <ul class="sublista">
                                    <li><a href="../../../proyectoWeb/categorias/fantasia.php">Fantasia</a></li>
                                </ul>
                            </li>
                            <li><a href="../../../proyectoWeb/contacto.php" class="nav-item">Contacto</a></li>
                        </ul>
                    </nav>
                    <div class="cuenta-dv">
                        <div class="desplegable">
                            <button class="boton-inicio"><img class="cuenta" src="../../../proyectoWeb/img/cuenta.png" alt=""></button>
                            <div class="links-boton">
                                <a href="../../../proyectoWeb/index.php">Inicio</a>
                                <a href="../../../proyectoWeb/admin/borrar.php">Panel</a>
                                <a href="../../../proyectoWeb/includes/config/logout.php">Cerrar sesion</a>
                            </div>    
                        </div>
                        <div>
                            <a href="../../../proyectoWeb/carrito.php"><img class="cuenta" src="../../../proyectoWeb/img/carrito-de-compras.png" alt=""></a>
                        </div>
                    </div>
                    <div class="buscador">
                        <label for="buscador">
                            <img class="cuenta buscador__icon" src="../../../proyectoWeb/img/buscar.png" alt="">
                        </label>
                        <input class="input_buscador_check" type="checkbox" name="buscador" value="buscador" id="buscador">
                        <div class="div_buscador">
                            <div class="linea__blanca"></div>
                            <input class="input_buscador" type="text">
                            <div class="icon_buscador_div">
                                <a href=""><img class="cuenta buscador__icon__input" src="../../../proyectoWeb/img/buscar1.png" alt=""></a>
                                <!-- IMPLEMENTAR EL BUSCAR -->
                            </div>
                        </div>
                    </div>
                <script src="../../../proyectoWeb/js/app.js"></script>
            </div>
    </header>