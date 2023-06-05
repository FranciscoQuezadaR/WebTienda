<?php
    include_once '../proyectoWeb/includes/config/database.php';
    include_once '../proyectoWeb/includes/config/user.php';
    include_once '../proyectoWeb/includes/config/user_session.php';
    
    $db = new DB();
    $user = new User();
    $userSession = new userSession();
    $codigo = $_GET['codigo'];

    $query = "SELECT *              
              FROM libro, productos
              WHERE libro.codigo = productos.librocodigo AND libro.codigo = '${codigo}'";

    $resultado = mysqli_query($db -> connect(), $query);
    $libro     = mysqli_fetch_assoc($resultado);

    if (isset($_SESSION['user'])) 
    {
        ?><script>window.location.href = "../../../proyectoWeb/comprar.php";</script><?php
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
        <section class="post__header post__header__producto">
        </section>
        <section class="comprar">
            <section class="finalizar__compra">
                <div class="seccion0__comprar">

                </div>
                <div class="apartado__opciones__compra">
                    <div class="direccion seccion1__comprar">
                        <div class="dire">
                            <h5>Agregar direccion</h5>
                            <label for="agregar">
                                <img src="img/boton-agregar.png" alt=""> 
                            </label>
                        </div>
                        <input class="input__boton__agregar" type="checkbox" name="agregar" id="agregar">
                        <div class="producto agregar__direccion"> <!--
                            <form class="formulario formulario__none">
                                <fieldset>
                                    <div class="contacto">
                                        <div class="direccion__titulo">
                                            <legend>Direccion</legend>
                                        </div>
                                        <div class="campo">
                                            <label for="pais">Pais de residencia</label><br/>
                                            <select class="seleccionar__pais" name="pais" id="pais">
                                                <option value="mexico">Mexico</option>
                                            </select>
                                        </div>
                                        <div class="campo">
                                            <label for="nombre">Nombre completo (nombres y apellidos)</label>
                                            <input type="text" name="nombre" id="nombre">
                                        </div>
                                        <div class="campo">
                                            <label for="calle_numero">Calle y número</label>
                                            <input type="text" name="calle_numero" id="calle_numero" placeholder="Calle, numero">
                                            <input type="text" name="calle_numero" id="calle_numero" placeholder="Apartamento, suite, unidad, edificio, piso, etc.">
                                        </div>
                                        <div class="campo">
                                            <label for="ciudad">Ciudad</label>
                                            <input type="text" name="ciudad">
                                        </div>
                                        <div class="campo">
                                            <label for="estado_provincia_region">Estado/Provincia/Región</label>
                                            <input type="text" name="estado_provincia_region" id="estado_provincia_region">
                                        </div>
                                        <div class="campo">
                                            <label for="cp">Codigo postal</label>
                                            <input type="text" name="cp" id="cp">
                                        </div>
                                        <div class="campo">
                                            <label for="tel">Telefono</label>
                                            <input type="tel" name="tel" id="tel">
                                        </div>
                                        <input class="boton-reg" type="button" value="agregar" name="" id="">
                                    </div>  
                                </fieldset>
                            </form>-->
                        </div> 
                    </div>
                    <div class="direccion">
                        <div class="dire">
                            <h5>Agregar metodo de pago</h5>
                            <label for="agregar__pago">
                                <img src="img/boton-agregar.png" alt=""> 
                            </label>
                        </div>
                        <input class="input__boton__agregar__pago" type="checkbox" name="agregar__pago" id="agregar__pago">
                        <div class="path_forma_pago">
                            <div class="metodos__pago">
                                <h5>Metodos de pago disponibles</h5>
                                <a href=""><img class="paypal paypal__hover" src="img/footer/paypal.png" alt=""></a>
                                <img class="tarjetas tarjetas__hover" src="img/footer/visa.png" alt="">
                            </div>
                        </div>
                        <div class="producto agregar__pago">
                        </div>
                    </div>
                    <div class="totales__compra">

                    </div>
                </div>
            </section>
        </section>
    </main>
    <?php
        include '../proyectoWeb/includes/templates/footer.php';
    ?>
</body>
</html>