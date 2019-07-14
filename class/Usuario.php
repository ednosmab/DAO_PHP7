<?php
    require_once "Sql.php";
    class Usuario extends Sql{
        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;
        

        public function getIdusuario(){
            return $this->idusuario;
        }
        public function setIdusuario($value){
            $this->idusuario = $value;
        }

        public function getDeslogin(){
            return $this->deslogin;
        }
        public function setDeslogin($value){
            $this->deslogin = $value;
        }

        public function getDessenha(){
            return $this->dessenha;
        }
        public function setDessenha($value){
            $this->dessenha = $value;
        }

        public function getDtcadastro(){
            return $this->dtcadastro;
        }
        public function setDtcadastro($value){
            $this->dtcadastro = $value;
        }

        
        
        public function loadById($id){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
                ":ID"=>$id
            ));
            if(count($results) > 0){
                $this->setData($results[0]);
                /*
                $row = $results[0];
                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));
                 */
            }
        }

        //Lista todos os usuários do banco
        public static function getList(){
            $sql = new Sql();
            return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
        }

        //Lita usuarios que tiverem algo em comum a pesquisa
        public static function getSearch($login){
            $sql = new Sql();
            return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY idusuario", array(
                ":SEARCH"=>"%".$login."%"
            ));
        }

        public function login($login, $pass){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS", array(
                ":LOGIN"=>$login, ':PASS'=>$pass
            ));
            if(count($results) > 0){
                $this->setData($results[0]);
                /*
                $row = $results[0];
                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));
                */
            }else{
                throw new Exception("Login ou Senha inválidos");
            }
        
        }
        
        public function setData($data){
            $this->setIdusuario($data['idusuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));
        }
        public function insert(){
            $sql = new Sql();
            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASS)", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASS'=>$this->getDessenha()
            ));
            if(count($results) > 0){
                $this->setData($results[0]);
            }
        }


        public function __construct($login = "", $senha = ""){
            $this->setDeslogin($login);
            $this->setDessenha($senha);
        }
        public function __toString(){
            return json_encode(array(
                "idusuario"=>$this->getIdusuario(),
                "deslogin"=>$this->getDeslogin(),
                "dessenha"=>$this->getDessenha(),
                "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
            ));
        }
    }

?>