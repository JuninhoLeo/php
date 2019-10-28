<?php

    class Banco
    {
        private static $dbNome    = 'sistema2';
        private static $dbHost    = 'localhost';
        private static $dbUsuario = 'root'; 
        private static $dbsenha   = ''; 

        private static $cont=null; 

        
        public function __construct()
        {
            die('A função init não é permitida!!'); 
        }

        public static function conectar()
        {
            if (null == self::$cont)
            {
                try
                {
                    self::$cont = new PDO(
                    "mysql:host=" .self::$dbHost .";"
                    ."dbname=" .self::$dbNome,
                    self::$dbUsuario, self::$dbsenha
                    );
                } 
                catch(PDOException $exception)
                {
                    die ($exception->getMessage());
                }
            }
        return self::$cont; 
        }

        public static function desconectar()
        {
            self::$cont = null; 
        }

    }

?>
