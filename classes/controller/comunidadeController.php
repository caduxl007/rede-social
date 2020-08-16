<?php

	namespace controller;
    use \Views\mainView;

    class comunidadeController {
    	public function index() {
    		if(!isset($_SESSION['email_membro'])) {
    			\Painel::redirect(INCLUDE_PATH);
    		}

            if(isset($_GET['addFriend'])) {
                $idAmigo = (int)$_GET['addFriend'];
                if($this->amigoPendente($idAmigo) == false){
                    $this->solicitarAmizade($idAmigo);
                }
            }

            mainView::render('comunidade.php',['controller'=>$this],'pages/includes/headerLogado.php');
    	}

        public function solicitarAmizade($idAmigo) {
            $sql = \Mysql::conectar()->prepare("INSERT INTO `tb_site.solicitacoes` VALUES(null,?,?,?)");
            $sql->execute(array($_SESSION['id_membro'],$idAmigo,0));
            \Painel::alertaJS("Pedido de amizade enviada com sucesso!");
            \Painel::redirect(INCLUDE_PATH.'comunidade');
        }

        public function amigoPendente($idAmigo) {
            $sql = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ? AND status = ?) OR (id_from = ? AND id_to = ? AND status = ?)");
            $sql->execute(array($_SESSION['id_membro'],$idAmigo,0,$idAmigo,$_SESSION['id_membro'],0));
            if($sql->rowCount() == 1)
                return true;
            else
                return false;
        }

        public function isAmigo($idAmigo) {
            $sql = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ? AND status = ?) OR (id_from = ? AND id_to = ? AND status = ?)");
            $sql->execute(array($_SESSION['id_membro'],$idAmigo,1,$idAmigo,$_SESSION['id_membro'],1));

            if($sql->rowCount() == 1)
                return true;
            else
                return false;
        }
    }

?>