<?php
    class Sql extends PDO{
        private $conn;//Variável para conexão do banco

        //Construtora para conectar ao banco
        //public function __construct(){
       public function __construct($tipoBanco, $nomeBanco, $login, $pass){//Caso haja necessidade de 
        //utilizar outros bancos, em index.php foi configurado no instanciamento de Sql o tipo do banco que é mysql, 
        //nome do banco, usuário e senha

            //$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
            $this->conn = new PDO($tipoBanco.";".$nomeBanco, $login, $pass);
            
            
        }
        
        //Função para associar os parametros com o bindParams
        public function setParams($statment, $parameters = array()){
            foreach($parameters as $key => $value){
                $this->setParam($statment, $key, $value);
            }
        }

        //Função para associar um parametro com o bindParam
        public function setParam($statment, $key, $value){
            $statment->bindParam($key, $value);
        }

        //RawQuery: Query bruta que será trabalhada no index
        public function query($rawQuery, $params = array()){
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParams($stmt, $params);
            
            //Preparando a query para ser executada
            $stmt->execute();//Método é executado e retornado ao STMT
            return $stmt;
        }

        //Função para executar um select
        public function select($rawQuery, $params = array()):array{
            $stmt = $this->query($rawQuery, $params);
            
            //Para exibir o Resultado na tela com fatiamento associativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);//FETCH_ASSOC trás como resultado os valores sem os 
            //indices associtivos
            

        }
    }

?>