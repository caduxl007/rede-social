<?php

	namespace controller;
    use \Views\mainView;

    class solicitacoesController {
    	public function index() {
    		if(!isset($_SESSION['email_membro'])){
    			\Painel::redirect(INCLUDE_PATH);
            }

            if(isset($_GET['aceitar'])) {
                //Aceitar a solicitação de amizade
                $idSolicitante = (int)$_GET['aceitar'];
                $sql = \Mysql::conectar()->prepare("UPDATE `tb_site.solicitacoes` SET status = 1 WHERE id_from = ? AND id_to = ?");
                $sql->execute(array($idSolicitante,$_SESSION['id_membro']));
                \Painel::redirect(INCLUDE_PATH.'solicitacoes');
            }else if(isset($_GET['rejeitar'])) {
                //Rejeitar a solicitação de amizade
                $idSolicitante = (int)$_GET['rejeitar'];
                $sql = \Mysql::conectar()->prepare("DELETE FROM `tb_site.solicitacoes` WHERE id_from = ? AND id_to = ?");
                $sql->execute(array($idSolicitante,$_SESSION['id_membro']));
                \Painel::redirect(INCLUDE_PATH.'solicitacoes');
            }

            mainView::render('solicitacoes.php',['controller'=>$this],'pages/includes/headerLogado.php');

    	}

        public static function listarSolicitacoes() {
            $sql = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.solicitacoes` WHERE id_to = ? AND status = ?");
            $sql->execute(array($_SESSION['id_membro'],0));

            return $sql->fetchAll();
        }

    }

?>