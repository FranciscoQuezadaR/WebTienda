<?php
    include_once '../proyectoWeb/includes/config/database.php';
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';

    $db = new DB();
    $user = new User();
    $userSession = new userSession();
    
    if (isset($_SESSION['user'])) 
    {
        ?><script>window.location.href = "../../../proyectoWeb/index.php";</script><?php
    } else {
        $db = new DB();
    
        // Ejecuta el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre     = $_POST ['nombre'     ];
            $apellidoP  = $_POST ['pa'         ];
            $apellidoM  = $_POST ['sa'         ];
            $email      = $_POST ['email'      ];
            $telefono   = $_POST ['tel'        ];
            $contasena  = $_POST ['contrasena' ];
            $genero     = $_POST ['genero'     ];
    
            if ($genero == "hombre") {
                $genero = "H";
            } else if ($genero == "mujer") {
                $genero = "M";
            } else {
                $genero = "N";
            }
    
            $query = "INSERT INTO usuarios(nombre, apellidoP, apellidoM, email, telefono, contrasena, genero)
                        VALUES ('$nombre', '$apellidoP', '$apellidoM', '$email', '$telefono', '$contasena', '$genero')";
    
            $resultado = mysqli_query($db -> connect(), $query);

            if ($resultado) {
                ?><script>window.location.href = "../../../proyectoWeb/iniciosesion.php";</script><?php
            } else {
                echo "Algo salio mal, intentalo de nuevo en unos minutos o ponte en contacto con nosotros";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FraLu Library | Registrar</title>
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
        <main>
            <section>
                <form class="formulario" method="post" onsubmit="return validaForm()">
                    <fieldset class="fset">
                        <div class="contacto">
                            <div class="legend">
                                <legend>Registrarse</legend>
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="nombre" id="nombre" placeholder="Nombre (es)">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="pa" id="pa" placeholder="Apellido paterno">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="sa" id="sa" placeholder="Apellido materno">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="email" id="email" placeholder="Email">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="tel" id="tel" placeholder="Telefono">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="password" name="contrasena" id="contrasena" placeholder="Contraseña">
                            </div>
                            <!-- Validar las contraseñas -->
                            <div class="campo-reg">
                                <input class="campo__texto" type="password" name="" id="contrasenaRepeat" placeholder="Repite la contraseña">
                            </div>
                            <div class="campo-genero">
                                <label class="genero" for="">Genero</label><br><br>
                                <select name="genero" id="">
                                    <option value="sinEscojer">Prefiero no decirlo</option>
                                    <option value="hombre">Hombre</option>
                                    <option value="mujer">Mujer</option>
                                </select>
                            </div>
                            <input class="boton-reg" type="submit" value="Registrarme">
                        </div>  
                    </fieldset>
                </form>
                <script>
                    function validaForm() {
                        mayusculas = /^[A-ZÑa-zñáéíóúÁÉÍÓÚ'° ]{5,50}$/;
                        mayusculas2 = /^[A-ZÑa-zñáéíóúÁÉÍÓÚ'° ]{5,30}$/;
                        numeroTelefonico = /^[0-9]{10}$/;
                        contraseña = /(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=|:;"'<>,./?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,20}$/;
                        correo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;

                        nombre = document.getElementById("nombre").value;
                        if (!mayusculas.test(nombre.toUpperCase())) {
                            alert ("Tu nombre debe contener min. 5 caracteres y max. 50, no se admiten numeros ni simbolos.");
                            return false;
                        }

                        apellPa = document.getElementById("pa").value;
                        if (!mayusculas2.test(apellPa.toUpperCase())) {
                            alert ("Tu apeliido paterno debe contener min. 5 caracteres y max. 30, no se admiten numeros ni simbolos.");
                            return false;
                        }

                        apellMa = document.getElementById("sa").value;
                        if (!mayusculas2.test(apellMa.toUpperCase())) {
                            alert ("Tu apellido materno debe contener min. 5 caracteres y max. 30, no se admiten numeros ni simbolos.");
                            return false;
                        }

                        email = document.getElementById("email").value;
                        if (!correo.test(email)) {
                            alert("Email invalido");
                            return false;
                        }

                        tel = document.getElementById("tel").value;
                        if (!numeroTelefonico.test(tel)) {
                            alert("Numero telefonico invalido");
                            return false;
                        } 

                        password = document.getElementById("contrasena").value;
                        passwordRepeat = document.getElementById("contrasenaRepeat").value;

                        if (password == passwordRepeat) {
                            if (!contraseña.test(password)) {
                                alert("La contraseña debe contener una letra minúscula, una letra mayúscula, un número, un carácter especial y mínimo 8 caracteres.");
                                return false;
                            }
                        } else  {
                            alert("Las contraseñas no coinciden");
                            return false;
                        }
                    }
                </script>
            </section>
        </main>
        <?php
            include '../proyectoWeb/includes/templates/footer.php';
        ?>
</body>
</html>