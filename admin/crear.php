<?php
    // Base de datos
    include_once '../../proyectoWeb/includes/config/database.php';
    include_once '../includes/config/user_session.php';
    include_once '../includes/config/user.php';
   
    $db = new DB();
    $userSession = new userSession();
    $user = new User();
    $error = "";

    if (isset($_SESSION['user'])) 
    {
        $user -> setUser($userSession->getCurrentUser());
        if (!($user -> userAdmin($userSession -> getCurrentUser()))) 
        {
            ?><script>window.location.href = "../../../../../proyectoWeb/index.php";</script><?php
        }
    } else {
        ?><script>window.location.href = "../../../../../proyectoWeb/iniciosesion.php";</script><?php
    }

    // Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Informacion general
        $existencias    = $_POST [ 'existencias'  ];
        $precioCompra   = $_POST [ 'precioCompra' ];
        $precioVenta    = $_POST [ 'precioVenta'  ];
        $img            = $_POST [ 'imagen'       ];
        $libroCodigo    = $_POST [ 'codigo'       ];

        // Libro
        $codigo         = $_POST [ 'codigo'       ];
        $titulo         = $_POST [ 'titulo'       ];
        $autor          = $_POST [ 'autor'        ];
        $editorial      = $_POST [ 'editorial'    ];
        $categoria      = $_POST [ 'categoria'    ];
        $idioma         = $_POST [ 'idioma'       ];
        $nopaginas      = $_POST [ 'nopaginas'    ];
        $sinopsis       = $_POST [ 'sinopsis'     ];
        $ano            = $_POST [ 'ano'          ];
        $formato        = $_POST [ 'formato'      ];

        // Valida que el codigo ingresado no exista en la base de datos
        $queryCodigos = "SELECT * FROM libro WHERE codigo = '${codigo}'";
        $resultadoCodigos = mysqli_query($db -> connect(), $queryCodigos);
        $rowsCodigos = mysqli_num_rows($resultadoCodigos);
        if ($rowsCodigos == 0) {

            // INSERTAR EN LA BASE DE DATOS
            $queryLibro = "INSERT INTO libro (codigo, titulo, autor, editorial, categoria, idioma, noPaginas, sinopsis, ano, formato) 
                                    VALUES ('$codigo', '$titulo', '$autor', '$editorial', '$categoria', '$idioma', '$nopaginas', '$sinopsis', '$ano', '$formato')";

            $resultadoLibro = mysqli_query($db -> connect(), $queryLibro);

            if (!$resultadoLibro) {
                echo "Error al insertar en la tabla libro";
            }

            $queryProducto = "INSERT INTO productos (existencias, precioCompra, precioVenta, img, librocodigo) 
                                        VALUES ('$existencias', '$precioCompra', '$precioVenta', '$img', '$libroCodigo')";

            $resultadoProducto = mysqli_query($db -> connect(), $queryProducto);

            if (!$resultadoProducto) {
                echo "Error al insertar en la tabla producto";
            } else {
                ?><script>window.location.href = "../../../../proyectoWeb/admin/borrar.php";</script><?php
            }
        } else if ( $rowsCodigos > 0 and $codigo != ""){
            ?>
                <script>
                    alert("El codigo del libro ya existe en la base de datos");
                </script>
            <?php
        }
    }
    include_once '../../proyectoWeb/includes/templates/header_admin_panel.php';
?>
    <main class="main__crear">
    <a href="../../proyectoWeb/admin/borrar.php"><div class="crear__producto boton-in">Atras</div></a>
        <h2 class="marg__pad">Agregar nuevo producto</h2>
        <form class="forms" method="POST" action="/proyectoWeb/admin/crear.php" name="fvalida" onsubmit="return valida()">
            <fieldset class="fieldset__crear">
                <legend>Descripcion del libro</legend>

                <div>
                    <label for="codigo">Codigo:</label>
                    <input class="fset__UC_input" type="text" name="codigo" id="codigo" placeholder="Codigo de barras">
                </div>
                <div>
                    <label for="titulo">Titulo:</label>
                    <input class="fset__UC_input" type="text" name="titulo" id="titulo" placeholder="Titulo del libro">
                </div>
                <div>
                    <label for="autor">Autor:</label>
                    <input class="fset__UC_input" type="text" name="autor" id="autor" placeholder="Autor del libro">
                </div>
                <div>
                    <label for="editorial">Editorial:</label>
                    <input class="fset__UC_input" type="text" name="editorial" id="editorial" placeholder="Editorial">
                </div>
                <div>
                    <label for="idioma">Idioma:</label>
                    <input class="fset__UC_input" type="text" name="idioma" id="idioma" placeholder="Idioma">
                </div>
                <div>
                    <label for="nopaginas">No. Páginas:</label>
                    <input class="fset__UC_input" type="text" name="nopaginas" id="nopaginas" placeholder="Ej: 100" min="1">
                </div>
                <div>
                    <label for="ano">Año de publicacion:</label>
                    <input class="fset__UC_input" type="text" name="ano" id="ano" placeholder="Ej: 2022" class="input__especial">
                </div>
                <div>
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                        <option value="Sin categoria">Sin categoria</option>
                        <option value="Fantasia">Fantasia</option>
                    </select>    
                </div>
                <div>
                    <label for="formato">Formato:</label>
                    <select name="formato" id="formato">
                        <option value="Sin categoria">Sin categoria</option>
                        <option value="Digital">Digital</option>
                        <option value="De bolsillo">De bolsillo</option>
                        <option value="Pasta blanda">Pasta blanda</option>
                        <option value="Pasta dura">Pasta dura</option>
                    </select>
                </div>       
                <div class="div__sinopsis">
                    <textarea class="textArea__sinopsis" name="sinopsis" id="sinopsis" placeholder="Sinopsis"></textarea>
                </div>         
            </fieldset>
            <fieldset class="fieldset__crear">
                <legend>Informacion general</legend>

                <div>
                    <label for="existencias">Existencias:</label>
                    <input class="fset__UC_input" type="text" name="existencias" id="existencias" placeholder="Existencias Libro">
                </div>
                <div>
                    <label for="precioCompra">Precio de compra:</label>
                    <input class="fset__UC_input" type="text" name="precioCompra" step="0.01" name="precioCompra" id="precioCompra" placeholder="$" class="input__especial">
                </div>
                <div>
                    <label for="precioVenta">Precio de venta:</label>
                    <input class="fset__UC_input" type="text" name="precioVenta" step="0.01" name="precioVenta" id="precioVenta" placeholder="$" class="input__especial">
                </div>
                <div>
                <label for="imagen">Imagen:</label>
                <input class="fset__UC_input" type="text" name="imagen" id="imagen" placeholder="URL de imagen">
                </div>
            </fieldset>
            <div class="div__botones"> 
                <input type="submit" value="Crear Libro" class="boton-in cr">
            </div>
        </form>
    </main>

    <script languaje = "JavaScript">
        function valida(){
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
            var idioma = document.getElementById("idioma").value;
            var nopaginas = document.getElementById("nopaginas").value;
            var ano = document.getElementById("ano").value;
            var categoria = document.getElementById("categoria").selectedIndex;
            var formato = document.getElementById("formato").selectedIndex;
            var sinopsis = document.getElementById("sinopsis").value;
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
            else if( !vacio.test(nopaginas) || /^\s+$/.test(nopaginas) ) { 
                alert("Debe ingresar el numero de paginas")
                document.fvalida.nopaginas.focus();
                return false;
            } 
            else if (!num.test(nopaginas)){
                alert("Debe ingresar numeros enteros para el numero de paginas (sin espacio)")
                document.fvalida.nopaginas.focus();
                return false;
            }
            else if (nopaginas.length > 11){
                alert("Tiene demasiados digitos (revisar)")
                document.fvalida.nopaginas.focus();
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
            else if (ano.length > 4){
                alert("El año tiene mas de 4 digitos")
                document.fvalida.ano.focus();
                return false;
            }
            else if( cero.test(categoria) ) { 
                alert("Debe seleccionar la categoria")
                document.fvalida.categoria.focus();
                return false;
            } 
            else if( cero.test(formato) ) { 
                alert("Debe seleccionar el formato")
                document.fvalida.formato.focus();
                return false;
            } 
            else if(!vacio.test(sinopsis) || /^\s+$/.test(sinopsis) ) { 
                alert("Debe ingresar la sinopsis")
                document.fvalida.sinopsis.focus();
                return false;
            } 
            else if (sinopsis.length > 250){
                alert("La sinopsis tiene mas de 250 caracteres (revisar)")
                document.fvalida.sinopsis.focus();
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
    include_once '../../proyectoWeb/includes/templates/footer.php';
?>