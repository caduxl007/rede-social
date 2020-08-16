<?php

	namespace controller;
    use \Views\mainView;

    class perfilController {
    	public function index() {
            if(!isset($_SESSION['email_membro'])) {
                \Painel::redirect(INCLUDE_PATH);
            }

            if(isset($_GET['sair'])) {
                session_unset();
                session_destroy();
                \Painel::redirect(INCLUDE_PATH);
            }

            if(isset($_POST['feed_post'])){
                $mensagem = strip_tags($_POST['mensagem']);
                if($mensagem == ''){
                    \Painel::alertaJS("Você precisa digitar algo");
                    \Painel::redirect(INCLUDE_PATH.'me');
                }else{
                    //Cadastrar mensagem
                    $sql = \Mysql::conectar()->prepare("INSERT INTO `tb_site.feed` VALUES(null,?,?)");
                    $sql->execute(array($_SESSION['id_membro'],$mensagem));
                }

            }

            mainView::render('me.php',[],'pages/includes/headerLogado.php');
    	}
    }

?>