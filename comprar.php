<?php
    include_once '../proyectoWeb/includes/config/database.php';
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';
    
    error_reporting(0);

    $db = new DB();
    $user = new User();
    $userSession = new userSession(); 
    $validador = false;

    $codigo = $_GET['codigo'];

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

    if ($_GET['carrito'] == 'buy') {
        $carrito = $_GET['carrito'];
        $userActual = $userSession->getCurrentUser();
        $id = $user -> acutualUserId($userActual);

        $queryTodo = "SELECT DISTINCT productos.existencias, libro.codigo, carrito.cantProd, productos.precioVenta, productos.img, libro.titulo
                        FROM carrito, productos, libro 
                        WHERE carrito.usuariosid = '${id}' 
                        AND carrito.productosid = productos.id 
                        AND productos.librocodigo = libro.codigo;";
        
        $resultadoTodo = mysqli_query($db -> connect(), $queryTodo);
    
        $validador = true;
           
    } else {
        $codigo = $_GET['codigo'];

        $query = "SELECT *              
                FROM libro, productos
                WHERE libro.codigo = productos.librocodigo AND libro.codigo = ${codigo}";

        $resultado = mysqli_query($db -> connect(), $query);
        $libro     = mysqli_fetch_assoc($resultado);
    }

    $idActualUser = $user -> acutualUserId($userSession -> getCurrentUser());
    $queryDirecciones = "SELECT DISTINCT a.id, a.nombreCompleto, a.calle, a.numero, a.ciudad, a.estado, a.cp, a.telefono, a.colonia, a.entreCalles
                         FROM direcciones AS a, usuarios_direcciones AS b
                         INNER JOIN direcciones AS dire ON (dire.id IN (b.direccionesid))
                         WHERE b.usuariosid = ${idActualUser} AND a.estatus = 'activo'";
                                    
    $resultadoDirecciones = mysqli_query($db -> connect(), $queryDirecciones);
    $fetchDirecciones = mysqli_fetch_assoc($resultadoDirecciones);
    //$rowsDirecciones = mysqli_num_rows($resultadoDirecciones);

    $sumador = 0;
    $descuento = 0;
    $cantidad = 1;
    $numeroProductos = 1; 
    $cadena = "";

    $datos = array();
    $codigos = array();
?>  
    <main class="comprar"> 
        <section class="comprar__productos">
            
                <h3>Productos</h3>
                <form method="POST" action="../proyectoWeb/includes/config/fpdf/recibo.php" name="fval" onsubmit="validaDir();">
                <?php if ($validador == true) { while ($fetchTodo = mysqli_fetch_assoc($resultadoTodo)) { 
                    if ($fetchTodo['existencias'] > 0) {?>
                    <div class="producto__comprar articulo">
                        <div class="imagen__carrito imagen__comprar">
                            <img src="<?php echo$fetchTodo['img'];?>" alt="">
                        </div>
                        <div class="producto-titulo__comprar">
                                <?php echo$fetchTodo['titulo'];?>
                        </div>
                        <div class="precio__comprar">
                                $<?php echo$fetchTodo['precioVenta']; $sumador += $fetchTodo['precioVenta'];?>
                        </div>
                        <div class="cantidadprod__comprar">
                            Cantidad: <?php echo$fetchTodo['cantProd'];?>
                        </div>
                        <div class="notas__comprar">
                            Compra garantizada y segura.
                        </div>
                        <div class="envio__comprar">
                                Envio: A domicilio
                        </div>
                    </div>

                    <?php
                        $codigos[] = $fetchTodo['codigo'];
                        $datos[] =  $fetchTodo['cantProd'].";".$fetchTodo['titulo'].";$".$fetchTodo['precioVenta'].";$0".";$".$fetchTodo['cantProd'] * $fetchTodo['precioVenta'];
                    ?>

                <?php $numeroProductos++; } } } else if ($fetchTodo['existencias'] > 0 || $validador == false) { {?>
                    <div class="producto__comprar articulo">
                        <div class="imagen__carrito imagen__comprar">
                            <img src="<?php echo$libro['img'];?>" alt="">
                        </div>
                        <div class="producto-titulo__comprar">
                                <?php echo$libro['titulo'];?>
                        </div>
                        <div class="precio__comprar">
                                $<?php echo$libro['precioVenta']; $sumador += $libro['precioVenta'];?>
                        </div>
                        <div class="cantidadprod__comprar">
                            Cantidad: <?php echo$cantidad;?>
                        </div>
                        <div class="notas__comprar">
                                Compra garantizada y segura.
                        </div>
                        <div class="envio__comprar">
                                Envio: A domicilio
                        </div>
                    </div> 

                    <?php 
                        $codigos[] = $libro['codigo'];
                        $datos[] =  $cantidad.";".$libro['titulo'].";$".$libro['precioVenta'].";$0".";$".$cantidad * $libro['precioVenta'];
                    ?>

                <?php $numeroProductos++; 
            
                    $contador = $numeroProductos;} }?>
                    <?php $_SESSION['data'] = $datos; $_SESSION['codes'] = $codigos;?>
            </section>
            <section class="comprar__info">
                <div class="direccion__metodo__pago">
                    <h3>Direccion</h3>
                    <div class="direccion">
                        <?php if (!$fetchDirecciones) { ?>
                            <div class="añadir__dr__c">
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="nombreCompleto" id="nombreCompleto" placeholder="Nombre completo">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="telefono" id="telefono" placeholder="Telefono/Celular">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="calle" id="calle" placeholder="Calle">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="numero" id="numero" placeholder="Numero de casa">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="colonia" id="colonia" placeholder="Colonia">
                                        </div>
                                        
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="ciudad" id="ciudad" placeholder="Ciudad">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="estado" id="estado" placeholder="Estado/Provincia/Región">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="cp" id="cp" placeholder="Codigo postal">
                                        </div>
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="entreCalles" id="entreCalles" placeholder="Entre calles">
                                        </div>
                                        
                                        <div class="campo-reg__c">
                                            <input class="campo__texto__c" type="text" name="email" id="email" placeholder="Email">
                                        </div>
                                    </div>  
                                    <input type="hidden" name="sum" id="sum" value="<?php echo$sumador+100;?>">
                                    <input type="hidden" name="carrito" id="carrito" value="<?php echo$validador?>">
                                    <input type="hidden" name="idUser" id="idUser" value="<?php echo$idActualUser?>">
                                    <input type="submit" class="hidden" name="sub" id="sub">
                            </form>
                        <?php } else { ?>
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
                                    <a class="enlaces cambiar__direccion" href="../proyectoWeb/agregar__direccion.php">Cambiar/Agregar direccion</a>
                                    
                                    <input type="hidden" name="nombreCompleto" id="nombreCompleto" value="<?php echo$fetchDirecciones['nombreCompleto'];?>">
                                    <input type="hidden" name="telefono" id="telefono" value="<?php echo$fetchDirecciones['telefono'];?>">
                                    <input type="hidden" name="calle" id="calle" value="<?php echo$fetchDirecciones['calle'];?>">
                                    <input type="hidden" name="numero" id="numero" value="<?php echo$fetchDirecciones['numero'];?>">
                                    <input type="hidden" name="colonia" id="colonia" value="<?php echo$fetchDirecciones['colonia'];?>">
                                    <input type="hidden" name="ciudad" id="ciudad" value="<?php echo$fetchDirecciones['ciudad'];?>">
                                    <input type="hidden" name="estado" id="estado" value="<?php echo$fetchDirecciones['estado'];?>">
                                    <input type="hidden" name="cp" id="cp" value="<?php echo$fetchDirecciones['cp'];?>">
                                    <input type="hidden" name="entreCalles" id="entreCalles" value="<?php echo$fetchDirecciones['entreCalles'];?>">
                                    <input type="hidden" name="sum" id="sum" value="<?php echo$sumador+100;?>">
                                    <input type="hidden" name="carrito" id="carrito" value="<?php echo$validador?>">
                                    <input type="hidden" name="idUser" id="idUser" value="<?php echo$idActualUser?>">
                                    <input type="submit" class="hidden" name="sub" id="sub">
                                </form>
                        <?php }?>
                    </div>
                    <h3 class="x">Resumen del pedido</h3>
                    <div class="informacion__producto">
                        <div class="totales__comprar">
                            <p>Subtotal:</p>
                            <p>Descuento aplicado:</p>
                            <p>Envio:</p>
                            <hr>
                            <p class="tot">Total (iva incluido):</p>
                        </div>
                        <div class="totales">
                            <p>$<?php echo$sumador;?></p>
                            <p>$0</p>
                            <p>$100</p>
                            <hr>
                            <?php $sumador = $sumador + 100 + $descuento;?>
                            <p class="tot">$<?php echo$sumador;?></p>
                        </div>
                    </div>
                    
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

                    

                    <h3>Pago</h3>
                    
                    <div id="paypal-button-container"></div>
                    <script src="https://www.paypal.com/sdk/js?client-id=Adc1Wf7q7L7RW644ByzG35giHSe3XLRP9Ec38R3ev6f-Iosl2-TCnn-2cQJN5TiAvwnR5Hw6YQqZhe_V&currency=MXN"></script>
                    <script>
                        var validador = 0;
                        
         
                        if (validador == 0) {
                            validador++;
                            const paypalButtonsComponent = paypal.Buttons({
                                    
                                    style: {
                                        color: "blue",
                                        shape: "pill",
                                        layout: "vertical",
                                        label: 'pay'
                                    },

                            // Set up the transaction
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '<?php echo$sumador;?>'
                                        }
                                    }]
                                });                 
                            },

                            // Finalize the transaction
                            onApprove: function(data, actions) {
                                console.log("Aprovado");
                                actions.order.capture().then(function(orderData) {
                                    <?php
                                        $token = bin2hex(random_bytes(16));
                                        $query = "UPDATE usuarios
                                                SET token = '${token}'
                                                WHERE id = '${idActualUser}'";
                                        mysqli_query($db -> connect(), $query);

                                        
                                    ?>
                                    alert("Gracias por su compra");
                                    elemento = document.getElementById("sub").click();
                                });
                            },

                            onCancel: function(data) {
                                alert("Pago cancelado");
                                console.log(data);
                            }

                            }).render('#paypal-button-container');
                        }
            
    </script>
                </div>
        </section>
        
    </main>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>