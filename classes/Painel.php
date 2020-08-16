<?php

	class Painel
	{
		public static $cargos = [
			'0' => 'Normal',
			'1' => 'Sub Administrador',
			'2' => 'Adminstrador'];

		public static function loadJS($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach ($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH_PAINEL.'js/'.$value.'"></script>';
				}
			}
		}

		public static function formatarMoedaBd($valor){
			$valor = str_replace('.','',$valor);
			$valor = str_replace(',','.',$valor);

			return $valor;
		}

		public static function convertMoney($valor){
			return number_format($valor,2,',','.');
		}

		public static function generateSlug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
			$str = preg_replace('/( )/', '-',$str);
			$str = preg_replace('/ç/','c',$str);
			$str = preg_replace('/(-[-]{1,})/','-',$str);
			$str = preg_replace('/(,)/','-',$str);
			$str=strtolower($str);
			return $str;
		}

		public static function logado(){
			return isset($_SESSION['login']) ? true : false;
		}

		public static function loggout(){
			setcookie('lembrar','true',time()-1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH_PAINEL);
		}

		public static function carregarPagina(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					//Sistema de rotas
					if(Router::get('visualizar-empreendimento/?',function($par){
						include('views/visualizar-empreendimento.php');
					})){
					}else if(Router::post('visualizar-empreendimento/?',function($par){
						include('views/visualizar-empreendimento.php');
					})){
					}else{
						//Página e sistema de rotas nao existe
						header('Location: '.INCLUDE_PATH_PAINEL);
					}
				}
			}else{
				include('pages/home.php');
			}
		}

		public static function listarUsuariosOnline(){
			self::limparUsuariosOnline();
			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
			$sql->execute();

			return $sql->fetchAll();
		}

		public static function limparUsuariosOnline(){
			$date = date('Y-m-d H:i:s');
			$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
		}

		public static function alerta($tipo,$mensagem){
			if($tipo == 'sucesso'){
				echo '<div class="box-alerta sucesso">'.$mensagem.'</div>';
			}else if($tipo == 'erro'){
				echo '<div class="box-alerta erro">'.$mensagem.'</div>';
			}else if($tipo == 'atencao'){
				echo '<div class="box-alerta atencao">'.$mensagem.'</div>';
			}
		}

		public static function alertaJS($msg){
			echo '<script>alert("'.$msg.'")</script>';
		}

		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/jpeg' ||
				$imagem['type'] == 'image/jpg' ||
				$imagem['type'] == 'image/png'){

				//Pegar tamamho da imagem em KB
				$tamanho = intval($imagem['size']/1024);
				if($tamanho < 900)
					return true;
				else 
					return false;
			}else{
				return false;
			}
		}

		public static function uploadFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome))
				return $imagemNome;
			else
				return false;
		}

		//Deletar uma imagem
		public static function deleteFile($file){
			@unlink('uploads/'.$file);
		}

		//inserir dados na tabela através do POST['acao'];
		public static function insert($arr){
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nome_tabela` VALUES(null";
			foreach ($arr as $key => $value) {
				if($key == 'acao' || $key == 'nome_tabela')
					continue;
				if($value == ''){
					$certo = false;
					break;
				}
				$query.=",?";
				$parametros[] = $value;	
			}

			$query.=")";
			if($certo == true){
				$sql = Mysql::conectar()->prepare($query);
				$sql->execute($parametros);
				$lastId = Mysql::conectar()->lastInsertId();
				$sql = Mysql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
				$sql->execute(array($lastId));
			}

			return $certo;
		}

		public static function selectAll($tabela,$start = null,$end = null){
			if($start == null && $end == null)
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
			else
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");

			$sql->execute();

			return $sql->fetchAll();
		}

		public static function deletarDepoimento($tabela,$id = false){
			if($id == false){
				$sql = Mysql::conectar()->prepare("DELETE FROM `$tabela`");
			}else{
				$sql = Mysql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
			}

			$sql->execute();
		}

		public static function redirect($url){

			echo '<script>location.href="'.$url.'"</script>';
			die();
		}

		//Metodo especifico para selecionar apenas 1 registro.
		public static function select($tabela,$query = '',$arr = ''){
			if($query != false){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}

			return $sql->fetch();
		}

		//Metodo especifico para selecionar varios registros.
		public static function selectTudo($tabela,$query = '',$arr = ''){
			if($query != false){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}

			return $sql->fetchAll();
		}

		//Essa função serve para atualizar varias tabelas, nao só a depoimento.
		public static function atualizarDepoimento($arr, $single = false){
			$certo = true;
			$first = false;
			$nome_tabela = $arr['nome_tabela'];

			$query = "UPDATE `$nome_tabela` SET ";
			foreach ($arr as $key => $value){
				if($key == 'acao' || $key == 'nome_tabela' || $key == 'id')
					continue;
				if($value == ''){
					$certo = false;
					break;
				}

				if($first == false){
					$first = true;
					$query.="$key=?";
				}else{
					$query.=",$key=?";
				}

				$parametros[] = $value;
			}

			if($certo == true){
				if($single == false){
					$parametros[] = $arr['id'];
					$sql = Mysql::conectar()->prepare($query.' WHERE id=?');
					$sql->execute($parametros);
				}else{
					$sql = Mysql::conectar()->prepare($query);
					$sql->execute($parametros);
				}
			}

			return $certo;
		}

		//Ordenando os depoimentos de acordo com subir ou descer
		public static function orderItem($tabela,$orderType,$idItem){
			if($orderType == 'up'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;

				$itemBefore = $itemBefore->fetch();
				Painel::atualizarDepoimento(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::atualizarDepoimento(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));

			}else if($orderType == 'down'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemAfter = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
				$itemAfter->execute();
				if($itemAfter->rowCount() == 0)
					return;

				$itemAfter = $itemAfter->fetch();
				Painel::atualizarDepoimento(array('nome_tabela'=>$tabela,'id'=>$itemAfter['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::atualizarDepoimento(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemAfter['order_id']));
			}
		}
	}
?>