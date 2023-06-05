<?php
    include_once 'database.php';

 class User extends DB {

    public function userExist($email, $contrasena) {
        $query = "SELECT id, email, contrasena 
                  FROM usuarios 
                  WHERE email = '${email}' 
                  AND contrasena = '${contrasena}'";
        $resultado = mysqli_query($this -> connect(), $query);
        $id = mysqli_fetch_assoc($resultado);

        $rows = mysqli_num_rows($resultado);

        if ($rows>0) {
            return true;
        } else {
            return false;
        }
    }

    public function userAdmin($email) {
        $query = "SELECT id 
                  FROM usuarios
                  WHERE email = '${email}'";

        $resultado = mysqli_query($this -> connect(), $query);
        $valor = mysqli_fetch_assoc($resultado);
        $valorid = $valor['id'];

        $queryAdmin = "SELECT * 
                       FROM administradores
                       WHERE usuariosid = '${valorid}'";

        $resultadoAdmin = mysqli_query($this -> connect(), $queryAdmin);

        $rows = mysqli_num_rows($resultadoAdmin);

        if ($rows>0) {
            return true;
        } else {
            return false;
        }
    }

    public function setUser($user) {
        $query = "SELECT * FROM usuarios WHERE email = '${user}'";
        $resultado = mysqli_query($this -> connect(), $query);

        foreach ($resultado as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->email = $currentUser['email'];
        }
    }

    public function acutualUserId($email) {
        $query = "SELECT id 
                  FROM usuarios
                  WHERE email = '${email}'";

        $resultado = mysqli_query($this -> connect(), $query);
        $valor = mysqli_fetch_assoc($resultado);
        return $valor['id'];
    }    
 }

?>