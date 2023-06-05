<?php

    
    require 'includes/templates/header_admin_panel.php';
    require 'includes/config/database.php';
    
    require 'includes/config/user.php';
   
    $db = new DB();
    
    $user = new User();

    if (isset($_SESSION['user'])) 
    {
        $user -> setUser($userSession->getCurrentUser());
        if (!($user -> userAdmin($userSession -> getCurrentUser()))) 
        {
            
        }
    } else {
       
    }

    // Escribir el query
    $query = "SELECT * FROM productos, libro
              WHERE productos.librocodigo = libro.codigo";

    //Consultar la BD
    $resultado = mysqli_query($db -> connect(), $query);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST ['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            $query = "DELETE FROM libro WHERE id = ${id}";
            echo $query;
        }
    }
?>
<main class="main__admin">
    <a href="../../proyectoWeb/admin/crear.php"><div class="crear__producto boton-in">Nuevo</div></a>
    <h2 class="marg__pad">Eliminar productos</h2>
    <section class="seccion__borrar">
        <table class="libros">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Existencias</th>
                    <th>Precio compra</th>
                    <th>Precio de venta</th>
                    <th>Formato</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($libro = mysqli_fetch_assoc($resultado)):
                ?>
                        <tr>
                            <td data-titulo="id"><?php echo$libro['id'];?></td>
                            <td data-titulo="titulo"><?php echo$libro['titulo'];?></td>
                            <td class="c1"><?php echo$libro['existencias'];?></td>
                            <td class="c2"><?php echo$libro['precioCompra']?></td>
                            <td class="c3"><?php echo$libro['precioVenta'];?></td>
                            <td class="c4"><?php echo$libro['formato'];?></td>
                            <td>
                                <img class="img__libro__borrar" src="<?php echo$libro['img']?>" alt="">
                            </td>
                            <td class="acciones">
                                <div class="boton__acciones boton__eliminar"><a href="../../../proyectoWeb/includes/config/eliminar.php?id=<?php echo$libro['id']; ?>">Eliminar</a></div>
                                <div class="boton__acciones boton__actualizar"><a href="../../../proyectoWeb/admin/actualizar.php?id=<?php echo$libro['id']; ?>">Actualizar</a></div>
                            </td>
                        </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>   
<?php
    include 'includes/templates/footer.php';
?>