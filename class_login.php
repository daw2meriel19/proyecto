<?php
    include 'conexion.php';
    session_start();
    //$dbh = DatabaseHandler::getConnection();
    // $nombre = "ee";
    // $log = new Login();
    // $res = $log -> comprueba_rol($nombre);
    
    class Login {
        public $mail;
        public $pass;


        

        public function inf(){

            $inf = $_SESSION["mail"];
            $dbh = DatabaseHandler::getConnection();
            $stmt = $dbh->prepare("SELECT * FROM usuarios WHERE nombre = :inf ");
            $stmt->execute([":inf" => $inf]);
            
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo $row['nombre'];
            }
          
                
        }


        public function comprobar_login($mail, $pass){
            $dbh = DatabaseHandler::getConnection();
            $stmt = $dbh->prepare("SELECT * FROM usuarios WHERE correo = :mail and password = :pass ");
            $stmt->execute([":mail" => $mail,":pass" => $pass]);
            
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION["mail"] = $mail;
                echo '1';
            }else{
                echo '2';
            }
                
            $dbh = null;
            
        }
        
        public function comprueba_rol($nombre){
            
            $dbh = DatabaseHandler::getConnection();
            $stmt = $dbh->prepare("SELECT rol FROM usuarios WHERE nombre = :nombre");
            $stmt->execute([":nombre" => $nombre]);
            
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rol = $row['rol'];
            }
            echo $rol;

        }
        
        public function close_sesion(){
            session_destroy();
        }
        
        public function comprueba_sesion($mail, $pass){
            
            $dbh = DatabaseHandler::getConnection();
            if(isset($_SESSION["mail"])){
                $mail = $_SESSION["mail"];
                $dbh = DatabaseHandler::getConnection();
                $stmt = $dbh->prepare("SELECT nombre FROM usuarios WHERE correo = :mail");
                $stmt->execute([":mail" => $mail]);
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $nombre = $row['nombre'];
                    echo $nombre;
                }
            }else{
                $mail = $_SESSION["mail"];
                echo("<script>window.location = 'index.html';</script>");
            }
        }
        
    }
        
?>