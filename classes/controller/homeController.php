<?php
    namespace controller;
    use \Views\mainView;

    class homeController{
        public function index(){
        	if(isset($_SESSION['email_membro'])) {
        		\Painel::redirect(INCLUDE_PATH.'me');
        	}

        	if(isset($_POST['login'])) {
        		$email = $_POST['email'];
        		$senha = $_POST['senha'];
        		$verifica = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.membros` WHERE email = ? AND senha = ?");
        		$verifica->execute(array($email,$senha));
        		if($verifica->rowCount() == 1) {
        			$info = $verifica->fetch();
        			$_SESSION['email_membro'] = $email;
        			$_SESSION['nome_membro'] = $info['nome'];
        			$_SESSION['imagem_membro'] = $info['imagem'];
                    $_SESSION['id_membro'] = $info['id'];
        			\Painel::redirect(INCLUDE_PATH.'me');
        		}else{
        			\Painel::alertaJS("O email ou senha estão incorretos!");
        		}
        	}

        	if(isset($_POST['cadastro'])) {
        		$nome = $_POST['nome'];
        		$email = $_POST['email'];
        		$senha = $_POST['senha'];
        		$imagem = $_FILES['imagem'];

        		if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
        			\Painel::alertaJS("O email é invalido");
        		}else if(\Painel::imagemValida($imagem) == false){
        			\Painel::alertaJS("A imagem é invalida");
        		}else{
        			$verifica = \Mysql::conectar()->prepare("SELECT email FROM `tb_site.membros` WHERE email = ?");
        			$verifica->execute(array($email));
        			if($verifica->rowCount() == 1){
        				\Painel::alertaJS("O email já é usado!");
        			}else{
        				//Fazer cadastro
        				$imagem = \Painel::uploadFile($imagem);
        				$sql = \Mysql::conectar()->prepare("INSERT INTO `tb_site.membros` VALUES(null,?,?,?,?)");
        				$sql->execute(array($nome,$email,$senha,$imagem));
        				\Painel::alertaJS("O cadastro foi realizado com sucesso!");
        			}
        		}
        	}

            mainView::render('home.php');
        }
    }
?>