<?php
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';
    include_once '../proyectoWeb/includes/config/database.php';

    error_reporting(0);

    $user = new User();
    $userSession = new userSession();
    $db = new DB();
    $error = "";
    

    if (isset($_SESSION['user'])) 
    {
        if ($user -> userAdmin($userSession -> getCurrentUser())) {
            include_once '../proyectoWeb/includes/templates/header_admin.php';
        } else {
            include_once '../proyectoWeb/includes/templates/header_usuario.php';
        }

        $idActualUser = $user -> acutualUserId($userSession -> getCurrentUser());
        echo $idActualUser;
        $queryDirecciones = "SELECT * FROM direcciones, usuarios_direcciones
                             WHERE usuarios_direcciones.direccionesid = direcciones.id 
                             AND usuarios_direcciones.usuariosid = '${idActualUser}'";
                                        
        $resultadoDirecciones = mysqli_query($db -> connect(), $queryDirecciones);
        $renglones = mysqli_num_rows($resultadoDirecciones);

        if ($renglones > 0) {
            $queryIdSelected = "SELECT DISTINCT a.id
                                FROM direcciones AS a, usuarios_direcciones AS b
                                INNER JOIN direcciones AS dire ON (dire.id IN (b.direccionesid))
                                WHERE b.usuariosid = '${idActualUser}' AND a.estatus = 'activo'";

            $resultadoIdSelected = mysqli_query($db -> connect(), $queryIdSelected);
            $fetchi = mysqli_fetch_assoc($resultadoIdSelected);
            $idSelected = $fetchi['id'];
        }
    } else {
        ?><script>window.location.href = "../proyectoWeb/index.php";</script><?php
    }

    $posted = $_POST ['posted'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($posted == "true") {
            $query = "UPDATE direcciones SET estatus = 'inactivo'";
            $resultado = mysqli_query($db -> connect(), $query);
            
            $seleccion = $_POST['seleccion'];
            $query = "UPDATE direcciones SET estatus = 'activo' WHERE id = '${seleccion}'";
            $resultado = mysqli_query($db -> connect(), $query);

            ?><script>window.location.href = "../proyectoWeb/agregar__direccion.php";</script><?php
        } else if ($posted == "false"){
            
            $nombre                   = $_POST ['nombre'                  ];
            $calle                    = $_POST ['calle'                   ];
            $numero                   = $_POST ['numero'                  ];
            $ciudad                   = $_POST ['ciudad'                  ];
            $colonia                  = $_POST ['colonia'                 ];
            $estado_provincia_region  = $_POST ['estado_provincia_region' ];
            $cp                       = $_POST ['cp'                      ];
            $tel                      = $_POST ['tel'                     ];
            $entreCalles              = $_POST ['entreCalles'             ];

            $query = "SELECT id FROM direcciones 
                        WHERE (nombreCompleto = '${nombre}' AND calle = '${calle}'
                        AND numero = '${numero}' AND ciudad = '${ciudad}' 
                        AND estado = '${estado_provincia_region}' AND cp = '${cp}' 
                        AND telefono = '${tel}' AND colonia = '${colonia}' 
                        AND entreCalles = '${entreCalles}')";

            $resultado = mysqli_query($db -> connect(), $query);
            $rows = mysqli_num_rows($resultado);

            if ($rows == 0) {
                $query = "INSERT INTO direcciones (paisResidencia, nombreCompleto, calle, numero, ciudad, estado, cp, telefono, colonia, entreCalles)
                        VALUES ('Mexico', '$nombre', '$calle', '$numero', '$ciudad', '$estado_provincia_region', '$cp', '$tel', '$colonia', '$entreCalles')";

                $resultado = mysqli_query($db -> connect(), $query);

                if ($resultado) {
                    $query = "SELECT * FROM direcciones 
                            WHERE nombreCompleto = '${nombre}' AND calle = '${calle}'
                            AND numero = '${numero}' AND ciudad = '${ciudad}' 
                            AND estado = '${estado_provincia_region}' AND cp = '${cp}' 
                            AND telefono = '${tel}' AND colonia = '${colonia}' 
                            AND entreCalles = '${entreCalles}'";

                    $resultado = mysqli_query($db -> connect(), $query);
                    $rows = mysqli_num_rows($resultado);

                    $fetch = mysqli_fetch_assoc($resultado);
        
                
                    $id = $fetch['id'];
                    $query = "INSERT INTO usuarios_direcciones (usuariosid, direccionesid)
                            VALUES ('$idActualUser', '$id')";
                    $resultado = mysqli_query($db -> connect(), $query);
                    ?><script>window.location.href = "../proyectoWeb/agregar__direccion.php";</script><?php
                } else {
                    $error = "Algo salio mal, intentalo de nuevo en unos minutos o ponte en contacto con nosotros";
                }
            } else { ?>
                <Script>alert("Una direccion igual ya existe");</Script>
            <?php
            }
        }

        
    } 
?>
    <main class="main__agregar__direccion">
        <section class="seccion__agregar__direccion">
            <form method="POST">
                <fieldset class="fset__ad">
                    <?php
                        if ($renglones > 0) {
                            while ($fetchDirecciones = mysqli_fetch_assoc($resultadoDirecciones)) {?>
                                <div class="direccion">
                                    <p><strong>Nombre:</strong> <?php echo$fetchDirecciones['nombreCompleto'];?></p>
                                    <p><strong>Telefono:</strong> <?php echo$fetchDirecciones['telefono'];?></p>
                                    <p>
                                        <?php 
                                            echo$fetchDirecciones['calle']."&nbsp;";
                                            echo$fetchDirecciones['numero']."&nbsp;"; 
                                            echo$fetchDirecciones['colonia'].",";?>
                                        <?php    
                                            echo$fetchDirecciones['ciudad']."&nbsp;";
                                            echo$fetchDirecciones['estado']."&nbsp;";
                                            echo$fetchDirecciones['paisResidencia'].",";?>
                                        <?php
                                            echo$fetchDirecciones['cp'].".";?>
                                    </p>
                                    <p><strong>Entre: </strong><?php echo$fetchDirecciones['entreCalles'].".";?></p>
                                    <a class="enlaces cambiar__direccion" href="../proyectoWeb/includes/config/eliminaDireccion.php?id=<?php echo$fetchDirecciones['id']?>">Eliminar</a>
                                    <input type="hidden" name="posted" id="" value="true">
                                    <?php if($fetchDirecciones['id'] == $idSelected) {?>
                                        <input type="radio" class="seleccion" name="seleccion" id="" value="<?php echo$fetchDirecciones['id']?>" checked>
                                    <?php } else {?>
                                        <input type="radio" class="seleccion" name="seleccion" id="" value="<?php echo$fetchDirecciones['id']?>">
                                    <?php }?> 
                                </div>
                            <?php } ?>
                    <input class="boton-reg btn__guardar__direccion" type="submit" value="Guardar">
                    <?php } else { ?>
                        <h3>No hay direcciones</h3>
                    <?php }?>
                </fieldset>
            </form>
        </section>
        <script>
            function seleccionado() {
                let seleccionado = document.getElementById
            }
        </script>
        <section>
            <div class="direccion direccion__agregar">
                <form class="formulario formulario__agregar_direccion" method="POST" name="fval" onsubmit="return validaDir()">
                    <fieldset class="fset">
                        <div class="añadir__dr">
                            <div>
                                <legend>Añadir nueva direccion</legend>
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="nombre" id="nombre" placeholder="Nombre completo">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="calle" id="calle" placeholder="Calle">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="colonia" id="colonia" placeholder="Colonia">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="numero" id="numero" placeholder="Numero de casa">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="ciudad" id="ciudad" placeholder="Ciudad">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="estado_provincia_region" id="estado_provincia_region" placeholder="Estado/Provincia/Región">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="cp" id="cp" placeholder="Codigo postal">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="entreCalles" id="entreCalles" placeholder="Entre calles">
                            </div>
                            <div class="campo-reg">
                                <input class="campo__texto" type="text" name="tel" id="tel" placeholder="Telefono/Celular">
                            </div>
                            <input type="hidden" name="posted" id="" value="false">
                            <input class="boton-reg btn__agregar__direccion" type="submit" value="agregar" name="" id="">
                        </div>  
                    </fieldset>
                </form>
            </section>
            </div>
        </section>
    </main>

    <script languaje = "JavaScript">
        function validaDir()
        {
            numeroTel = /^[0-9]{10}$/;
            num = /^[0-9]+$/;
            cadena = /^[a-zA-ZÀ-ÿ ]+$/;

            var nombre = document.getElementById("nombre").value;
            var calle = document.getElementById("calle").value;
            var colonia = document.getElementById("colonia").value;
            var numero = document.getElementById("numero").value;
            var ciudad = document.getElementById("ciudad").value;
            var estado = document.getElementById("estado_provincia_region").value;
            var cp = document.getElementById("cp").value;
            var entreCalles = document.getElementById("entreCalles").value;
            var tel = document.getElementById("tel").value;

            if( nombre == null || nombre.length == 0 || /^\s+$/.test(nombre) ) { 
                alert("Ingrese su nombre completo")
                document.fval.nombre.focus();
                return false;
            } else if (!cadena.test(nombre)){
                alert("No se aceptan numeros en el nombre (revisar)")
                document.fval.nombre.focus();
                return false;
            } else if( calle == null || calle.length == 0 || /^\s+$/.test(calle) ) { 
                alert("Ingrese la calle")
                document.fval.calle.focus();
                return false;
            } else if( colonia == null || colonia.length == 0 || /^\s+$/.test(colonia) ) { 
                alert("Ingrese la colonia")
                document.fval.colonia.focus();
                return false;
            } else if (!cadena.test(colonia)){
                alert("No se aceptan numeros en colonia (revisar)")
                document.fval.colonia.focus();
                return false;
            } else if( numero == null || numero.length == 0 || /^\s+$/.test(numero) ) { 
                alert("Ingrese su numero de casa")
                document.fval.numero.focus();
                return false;
            } else if(!num.test(numero)){
                alert("Ingrese solamente numeros enteros para el numero de su casa")
                document.fval.numero.focus();
                return false;
            } else if( ciudad == null || ciudad.length == 0 || /^\s+$/.test(ciudad) ) { 
                alert("Ingrese la ciudad")
                document.fval.ciudad.focus();
                return false;
            } else if (!cadena.test(ciudad)){
                alert("No se aceptan numeros en ciudad (revisar)")
                document.fval.ciudad.focus();
                return false;
            } else if( estado == null || estado.length == 0 || /^\s+$/.test(estado) ) { 
                alert("Ingrese la estado")
                document.fval.estado.focus();
                return false;
            } else if (!cadena.test(estado)){
                alert("No se aceptan numeros en estado (revisar)")
                document.fval.estado.focus();
                return false;
            } else if( cp == null || cp.length == 0 || /^\s+$/.test(cp) ) { 
                alert("Ingrese su codigo postal")
                document.fval.cp.focus();
                return false;
            } else if(!num.test(cp)){
                alert("Ingrese solamente numeros enteros para el codigo postal")
                document.fval.cp.focus();
                return false;
            } else if( entreCalles == null || entreCalles.length == 0 || /^\s+$/.test(entreCalles) ) { 
                alert("Ingrese entre cuales calles vive")
                document.fval.entreCalles.focus();
                return false;
            } else if( tel == null || tel.length == 0 || /^\s+$/.test(tel) ) { 
                alert("Ingrese su numero telefonico/celular")
                document.fval.tel.focus();
                return false;
            } else if(!numeroTel.test(tel)){
                alert("Ingrese solamente 10 numeros enteros para su numero tel/cel")
                document.fval.tel.focus();
                return false;
            }
        }
    </script>

    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>