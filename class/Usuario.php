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

        
        //Função auxiliar no carregamento do usuario por ID 
        public function loadById($id){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
                ":ID"=>$id
            ));
            //var_dump($results);
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

        //Query Select do login e senha do usuario
        public function login($login, $pass){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS", array(
                ":LOGIN"=>$login, ':PASS'=>$pass
            ));
            //var_dump($results);
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

        //Inserindo novo usuario
        public function insert(){
            $sql = new Sql();
            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASS)", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASS'=>$this->getDessenha()
            ));
            //var_dump($results);
            if(count($results) > 0){
                $this->setData($results[0]);
            }
        }

        //Atualizando dados dos usuario
        public function update($login, $pass){
            $this->setDeslogin($login);
            $this->setDessenha($pass);
            $sql = new Sql();
            $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASS WHERE idusuario = :ID", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASS'=>$this->getDessenha(),
                'ID'=>$this->getIdusuario()
            ));
            //var_dump($sql);
        }

        //Deletando usuario
        public function delete(){
            $sql = new Sql();
            $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
                ':ID'=>$this->getIdusuario()
            ));
            //Zerando os dados do objeto
            $this->setIdusuario(0);
            $this->setDeslogin("");
            $this->setDessenha("");
            $this->setDtcadastro(new DateTime());
        }

        //Construtor para atribuição de login e senha
        public function __construct($login = "", $senha = ""){
            $this->setDeslogin($login);
            $this->setDessenha($senha);
        }

        //Exibir em formato JSON os dados do objeto
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