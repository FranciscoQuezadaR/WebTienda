<?php
    include_once '../includes/config/database.php';
    include_once '../includes/config/user_session.php';
    include_once '../includes/config/user.php';
    
    $db = new DB();
    $userSession = new userSession();
    $user = new User();

    if (isset($_SESSION['user'])) 
    {
        $user -> setUser($userSession->getCurrentUser());
        if (!($user -> userAdmin($userSession -> getCurrentUser()))) 
        {
            
            ?><script>window.location.href = "../../../../../proyectoWeb/index.php";</script><?php
        } else {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if (!$id) {
                ?><script>window.location.href = "../../../../../proyectoWeb/admin/borrar.php";</script><?php
            }
        }
    } else {
        ?><script>window.location.href = "../../../../../proyectoWeb/iniciosesion.php";</script><?php
    }

    // Valida que la entrada get de actualizar haya sido un entero si no
    // redirecciona a borrar

    // Consulta para obtener los libros
    $consulta = "SELECT * FROM productos, libro
                 WHERE productos.librocodigo = libro.codigo AND productos.id = ${id}";
    $resultado = mysqli_query($db -> connect(), $consulta);
    $libro = mysqli_fetch_assoc($resultado);

    // Arreglo con mensaje de errores
    $errores = [];

    // Informacion general
    $existencias    = $libro [ 'existencias'  ];
    $precioCompra   = $libro [ 'precioCompra' ];
    $precioVenta    = $libro [ 'precioVenta'  ];
    $imagen         = $libro [ 'img'          ];
    $libroCodigo    = $libro [ 'codigo'       ];

    // Libro
    $codigo         = $libro [ 'codigo'       ];
    $titulo         = $libro [ 'titulo'       ];
    $autor          = $libro [ 'autor'        ];
    $editorial      = $libro [ 'editorial'    ];
    $categoria      = $libro [ 'categoria'    ];
    $idioma         = $libro [ 'idioma'       ];
    $noPaginas      = $libro [ 'noPaginas'    ];
    $sinopsis       = $libro [ 'sinopsis'     ];
    $ano            = $libro [ 'ano'          ];
    $formato        = $libro [ 'formato'      ];

    // Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Informacion general
        $existencias    = $_POST [ 'existencias'  ];
        $precioCompra   = $_POST [ 'precioCompra' ];
        $precioVenta    = $_POST [ 'precioVenta'  ];
        $imagen        = $_POST  [ 'imagen'       ];

        // Libro
        $titulo         = $_POST [ 'titulo'       ];
        $autor          = $_POST [ 'autor'        ];
        $editorial      = $_POST [ 'editorial'    ];
        $categoria      = $_POST [ 'categoria'    ];
        $idioma         = $_POST [ 'idioma'       ];
        $noPaginas      = $_POST [ 'noPaginas'    ];
        $sinopsis       = $_POST [ 'sinopsis'     ];
        $ano            = $_POST [ 'ano'          ];
        $formato        = $_POST [ 'formato'      ];

        if (!$existencias) {
            $errores[] = "Faltan las existencias";
        }
        if (!$precioCompra) {
            $errores[] = "Falta el precio de compra";
        }
        if (!$precioVenta) {
            $errores[] = "Falta el precio de venta";
        }
        if (!$imagen) {
            $errores[] = "Falta la url de la imagen";
        }
        if (!$codigo) {
            $errores[] = "Falta el codigo del libro";
        } 
        if (!$titulo) {
            $errores[] = "Falta el titulo del libro";
        } 
        if (!$autor) {
            $errores[] = "Falta autor";
        }
        if (!$editorial) {
            $errores[] = "Falta editorial";
        }
        if (!$idioma) {
            $erorres[] = "Falta idioma";
        }
        if (!$noPaginas) {
            $errores[] = "Falta el número de páginas";
        }
        if (!$sinopsis) {
            $errores[] = "Falta la sinopsis";
        }
        if (!$ano) {
            $errores[] = "Falta el año de publicacion del libro";
        } 
                        
        $queryLibro = "UPDATE libro
                       SET titulo    = '${titulo}',
                       autor         = '${autor}',
                       editorial     = '${editorial}',
                       categoria     = '${categoria}',
                       idioma        = '${idioma}',
                       noPaginas     = ${noPaginas},
                       sinopsis      = '${sinopsis}',
                       ano           = ${ano},
                       formato       = '${formato}'
                       WHERE codigo = (SELECT libroCodigo
                                       FROM productos
                                       WHERE id = ${id})";
        
        $queryProducto = "UPDATE productos
                          SET existencias  = ${existencias},
                          precioCompra     = ${precioCompra},
                          precioVenta      = ${precioVenta},
                          img              = '${imagen}'        
                          WHERE id         = ${id}";
        
        $resultadoLibro    = mysqli_query($db -> connect(), $queryLibro);
        $resultadoProducto = mysqli_query($db -> connect(), $queryProducto);  

        if (($resultadoLibro && $resultadoProducto)) {
            ?><script>window.location.href = "../../../../../proyectoWeb/admin/borrar.php";</script><?php
        }
        /*
        

        

        if (!$resultadoLibro) {
            echo "Error al insertar en la tabla libro";
        }

        $queryProducto = "INSERT INTO productos (existencias, precioCompra, precioVenta, imagen, librocodigo) 
                                    VALUES ('$existencias', '$precioCompra', '$precioVenta', '$imagen', '$libroCodigo')";

        $resultadoProducto = mysqli_query($db, $queryProducto);

        if (!$resultadoProducto) {
            echo "Error al insertar en la tabla producto";
        }*/
    }
    
    include_once '../../proyectoWeb/includes/templates/header_admin_panel.php';
?>
    <main class="main__actualizar">
    <a href="../../proyectoWeb/admin/borrar.php"><div class="crear__producto boton-in">Atras</div></a>
        <h2 class="marg__pad">Actualizar producto</h2>
        <form class="form__actualizar" method="POST" name="fvalida" onsubmit="return validaUp()">
            <fieldset class="fieldset__crear">
                <legend>Descripcion del libro</legend>
                
                <div>
                    <label for="codigo">Codigo:</label>
                    <input class="fset__UC_input" type="text" name="codigo" id="codigo" placeholder="Codigo de barras" value="<?php echo $libroCodigo ?>" disabled>
                </div>
                <div>
                    <label for="titulo">Titulo:</label>
                    <input class="fset__UC_input" type="text" name="titulo" id="titulo" placeholder="Titulo del libro" value="<?php echo $titulo ?>">
                </div>
                <div>
                    <label for="autor">Autor:</label>
                    <input class="fset__UC_input" type="text" name="autor" id="autor" placeholder="Autor del libro" value="<?php echo $autor ?>">
                </div>
                <div>
                    <label for="editorial">Editorial:</label>
                    <input class="fset__UC_input" type="text" name="editorial" id="editorial" placeholder="Editorial" value="<?php echo $editorial ?>">
                </div>
                <div>
                    <?php
                        $valor = 0;
                        switch ($categoria) {
                            case 'Fantasia':
                                $valor = 1;
                            break;
                        }
                    ?>

                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                        <?php if ($valor == 0) { ?>
                            <option value="Sin categoria" selected>Sin categoria</option>
                        <?php } else {?>
                            <option value="Sin categoria">Sin categoria</option>
                        <?php } if ($valor == 1) { ?> 
                            <option value="Fantasia" selected>Fantasia</option>
                        <?php } else {?>
                            <option value="Fantasia">Fantasia</option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="idioma">Idioma:</label>
                    <input class="fset__UC_input" type="text" name="idioma" id="idioma" placeholder="Idioma" value="<?php echo $idioma ?>">
                </div>
                <div>
                    <label for="noPaginas">No. Páginas:</label>
                    <input class="fset__UC_input" type="text" name="noPaginas" id="noPaginas" placeholder="Ej: 100" min="1" value="<?php echo $noPaginas?>">
                </div>
                <div>
                    <label for="sinopsis">Sinopsis:</label>
                    <input class="fset__UC_input" type="text" name="sinopsis" id="sinopsis" placeholder="Trata de..." value="<?php echo $sinopsis ?>">
                </div>
                <div>
                    <label for="ano">Año de publicacion:</label>
                    <input class="fset__UC_input" type="text" name="ano" id="ano" placeholder="Ej: 2022" value="<?php echo $ano ?>">
                </div>
                <div>
                    <?php
                        $valor = 0;
                        switch ($formato) {
                            case 'Digital':
                                $valor = 1;
                            break;
                            case 'De bolsillo':
                                $valor = 2;
                            break;
                            case 'Pasta blanda':
                                $valor = 3;
                            break;
                            case 'Pasta dura':
                                $valor = 4;
                            break;
                        }
                    ?>

                    <label for="formato">Formato:</label>
                    <select name="formato" id="formato">
                        <?php if($valor == 0) { ?>
                            <option value="Sin categoria" selected>Sin categoria</option>
                        <?php } else { ?>
                            <option value="Sin categoria">Sin categoria</option>
                        <?php } if($valor == 1) { ?>
                            <option value="Digital" selected>Digital</option>
                        <?php } else { ?>
                            <option value="Digital">Digital</option>
                        <?php } if($valor == 2) { ?>
                            <option value="De bolsillo" selected>De bolsillo</option>
                        <?php } else { ?>
                            <option value="De bolsillo">De bolsillo</option>
                        <?php } if($valor == 3) { ?>
                            <option value="Pasta blanda" selected>Pasta blanda</option>
                        <?php } else { ?>
                            <option value="Pasta blanda">Pasta blanda</option>
                        <?php } if($valor == 4) { ?>
                            <option value="Pasta dura" selected>Pasta dura</option>
                        <?php } else { ?>
                            <option value="Pasta dura">Pasta dura</option>
                        <?php }?>
                    </select>
                </div>                
            </fieldset>
            <fieldset class="fieldset__crear">
                <legend>Informacion general</legend>

                <div>
                    <label for="existencias">Existencias:</label>
                    <input class="fset__UC_input" type="text" name="existencias" id="existencias" placeholder="Existencias Libro" value="<?php echo $existencias ?>">
                </div>
                <div>
                    <label for="precioCompra">Precio de compra:</label>
                    <input class="fset__UC_input" type="text" name="precioCompra" step="0.01" name="precioCompra" id="precioCompra" placeholder="Precio Compra" value="<?php echo $precioCompra ?>">
                </div>
                <div>
                    <label for="precioVenta">Precio de venta:</label>
                    <input class="fset__UC_input" type="text" name="precioVenta" step="0.01" name="precioVenta" id="precioVenta" placeholder="Precio Compra" value="<?php echo $precioVenta ?>">
                </div>
                <div>
                    <label for="imagen">Imagen:</label>
                    <input class="fset__UC_input" type="text" name="imagen" id="imagen" placeholder="URL de imagen" value="<?php echo $imagen ?>">
                </div>
            </fieldset>
            <div class="div__botones">
                <input type="submit" value="Actualizar" class="boton-in cr">
            </div>
        </form>
    </main>

    <script languaje = "JavaScript">
        function validaUp()
        {
            vacio = /^[^]+$/;
            cero = /^[0]+$/;
            re = /^[a-zA-ZÀ-ÿ ]+$/;
            num = /^[0-9]+$/;
            año = /^[0-9]{4}$/;
            doble = /^[0-9]+([.])?([0-9]+)?$/;
            url = /^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;

            var codigo = document.getElementById("codigo").value;
            var titulo = document.getElementById("titulo").value;
            var autor = document.getElementById("autor").value;
            var editorial = document.getElementById("editorial").value;
            var categoria = document.getElementById("categoria").selectedIndex;
            var idioma = document.getElementById("idioma").value;
            var nopaginas = document.getElementById("noPaginas").value;
            var sinopsis = document.getElementById("sinopsis").value;
            var ano = document.getElementById("ano").value;
            var formato = document.getElementById("formato").selectedIndex;
            var existencias = document.getElementById("existencias").value;
            var precioCompra = document.getElementById("precioCompra").value;
            var precioVenta = document.getElementById("precioVenta").value;
            var imagen = document.getElementById("imagen").value;

            if( !vacio.test(codigo) || /^\s+$/.test(codigo) ) { 
                alert("Debe ingresar el codigo")
                document.fvalida.codigo.focus();
                return false;
            } 
            else if (!num.test(codigo)){
                alert("Debe ingresar numeros enteros para el codigo (sin espacio)")
                document.fvalida.codigo.focus();
                return false;
            } 
            else if (codigo.length > 12){
                alert("El codigo que ingreso tiene mas de 12 digitos")
                document.fvalida.codigo.focus();
                return false;
            }
            else if( !vacio.test(titulo) || /^\s+$/.test(titulo) ) { 
                alert("Debe ingresar el titulo")
                document.fvalida.titulo.focus();
                return false;
            } 
            else if(titulo.length > 50){
                alert("Ingreso un titulo muy largo")
                document.fvalida.titulo.focus();
                return false;
            }
            else if( !vacio.test(autor) || /^\s+$/.test(autor) ) { 
                alert("Debe ingresar el autor")
                document.fvalida.autor.focus();
                return false;
            } 
            else if(!re.test(autor)){
                alert("Debe ingresar un nombre valido al autor (sin numeros)")
                document.fvalida.autor.focus();
                return false;
            }
            else if(autor.length > 50){
                alert("El nombre del autor es demasiado largo (revisar)")
                document.fvalida.titulo.focus();
                return false;
            }
            else if( !vacio.test(editorial) || /^\s+$/.test(editorial) ) { 
                alert("Debe ingresar el editorial")
                document.fvalida.editorial.focus();
                return false;
            } 
            else if (editorial.length > 25){
                alert("El nombre del editorial es demasiado largo (revisar)")
                document.fvalida.editorial.focus();
                return false;
            }
            else if( cero.test(categoria) ) { 
                alert("Debe seleccionar la categoria")
                document.fvalida.categoria.focus();
                return false;
            } 
            else if( !vacio.test(idioma) || /^\s+$/.test(idioma) ) { 
                alert("Debe ingresar el idioma")
                document.fvalida.idioma.focus();
                return false;
            } 
            else if (!re.test(idioma)){
                alert("No debe ingresar numeros en el idioma")
                document.fvalida.idioma.focus();
                return false;
            }
            else if(idioma.length > 25){
                alert("El nombre del idioma es demasiado largo (revisar)")
                document.fvalida.idioma.focus();
                return false;
            }
            else if( !vacio.test(noPaginas) || /^\s+$/.test(noPaginas) ) { 
                alert("Debe ingresar el numero de paginas")
                document.fvalida.noPaginas.focus();
                return false;
            } 
            else if (!isNaN(noPaginas)){
                alert("Debe ingresar numeros enteros para el numero de paginas (sin espacio)")
                document.fvalida.noPaginas.focus();
                return false;
            }
            else if (noPaginas.length > 11){
                alert("Tiene demasiados digitos (revisar)")
                document.fvalida.noPaginas.focus();
                return false;
            }
            else if( !vacio.test(sinopsis) || /^\s+$/.test(sinopsis) ) { 
                alert("Debe ingresar la sinopsis")
                document.fvalida.sinopsis.focus();
                return false;
            } 
            else if (sinopsis.length > 250){
                alert("La sinopsis tiene mas de 250 caracteres (revisar)")
                document.fvalida.sinopsis.focus();
                return false;
            }
            else if( !vacio.test(ano) || /^\s+$/.test(ano) ) { 
                alert("Debe ingresar el año de publicacion")
                document.fvalida.ano.focus();
                return false;
            } 
            else if (!año.test(ano)){
                alert("Debe ingresar 4 numeros enteros para el año (sin espacio)")
                document.fvalida.ano.focus();
                return false;
            }
            else if( cero.test(formato) ) { 
                alert("Debe seleccionar el formato")
                document.fvalida.formato.focus();
                return false;
            } 
            else if( !vacio.test(existencias) || /^\s+$/.test(existencias) ) { 
                alert("Debe ingresar el numero de existencias")
                document.fvalida.existencias.focus();
                return false;
            } 
            else if (!num.test(existencias)){
                alert("Debe ingresar numeros enteros para las existencias (sin espacio)")
                document.fvalida.existencias.focus();
                return false;
            }
            else if (existencias.length > 10){
                alert("El numero de existencias tiene mas de 11 digitos (revisar)")
                document.fvalida.existencias.focus();
                return false;
            }
            else if( !vacio.test(precioCompra) || /^\s+$/.test(precioCompra) ) { 
                alert("Debe ingresar el precio de compra")
                document.fvalida.precioCompra.focus();
                return false;
            } 
            else if(!doble.test(precioCompra)){
                alert("Debe ingresar solamente numeros en precio de compra")
                document.fvalida.precioCompra.focus();
                return false;
            }
            else if( !vacio.test(precioVenta) || /^\s+$/.test(precioVenta) ) { 
                alert("Debe ingresar el precio de venta")
                document.fvalida.precioVenta.focus();
                return false;
            } 
            else if(!doble.test(precioVenta)){
                alert("Debe ingresar solamente numeros en precio de venta")
                document.fvalida.precioVenta.focus();
                return false;
            }
            else if( !vacio.test(imagen) || /^\s+$/.test(imagen) ) { 
                alert("Debe ingresar el URL de la imagen del libro")
                document.fvalida.imagen.focus();
                return false;
            }
            /*else if (!url.test(imagen)){
                alert("No es un URL valido")
                document.fvalida.imagen.focus();
                return false;
            }*/
        }
    </script>
<?php
    include '../../proyectoWeb/includes/templates/footer.php';
?>