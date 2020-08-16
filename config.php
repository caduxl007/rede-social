<?php
	
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	
	$autoload = function($class){
		if($class == 'Email'){
			require_once('classes/phpmailer/PHPMailerAutoLoad.php');
		}
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);

	define('INCLUDE_PATH','http://localhost/Back-End/rede_social/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');
	define('BASE_DIR_PAINEL',__DIR__.'/painel/');

	//Conectando com banco de dados!
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','projeto_01');

	//Constante nome empresa
	define('NOME_EMPRESA','CeStudios');

	//Variavel cargo painel

	//Funções do painel
	function pegaCargo($indice){
		return Painel::$cargos[$indice];
	}

	function selecionadoMenu($par){
		$url = explode('/',@$_GET['url'])[0];
		if($url == $par)
			echo 'class="menu-active"';
	}

	//Funções de permissao no painel
	function verificarPermissaoMenu($permissao){
		if($_SESSION['cargo'] >= $permissao)
			return;
		else
			echo 'style="display:none;"';
	}

	function verificarPermissaoPagina($permissao){
		if($_SESSION['cargo'] >= $permissao)
			return;
		else{
			include('painel/pages/permissao-negada.php');
			die();
		}
	}

	function recoverPost($post){
		if(isset($_POST[$post]))
			echo $_POST[$post];
	}
?>