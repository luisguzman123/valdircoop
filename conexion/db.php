<?php

Class DB {
    //variables o atributos de la clase
    private $host;
    private $usuario;
    private $pass;
    private $base_de_datos;
    private $charset;
    private $port;
    
    public function __construct() {

        $this->host = 'localhost';
        $this->base_de_datos = 'cpcc';
        $this->usuario = 'root';
        $this->pass = '';
        $this->charset = 'utf8mb4';  
    }
    
    public function  conectar(){
       
        try{
////            
//            $connection = "mysql:host=" . $this->host .
//                    ";dbname=" . $this->base_de_datos . 
//                   ";port=".$this->port.";charset=" . $this->charset;
            $connection = "mysql:host=" . $this->host .
                    ";dbname=" . $this->base_de_datos . 
                    ";charset=" . $this->charset;
//            mysql
//            mysqli
//            PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES=> false,
                PDO::ATTR_PERSISTENT => TRUE
            ];
           
            $pdo = new PDO($connection, $this->usuario, $this->pass,
                    $options);
//            echo "conectado";
            return $pdo;
        }catch(PDOException $ext){
            print_r('Error connection: ' . $ext->getMessage());
        }   
    }
    
}

