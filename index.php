<?php 

	include('config.php');

	$homeController = new controller\homeController();
	$perfilControlller = new controller\perfilController();
	$comunidadeController = new controller\comunidadeController();
	$solicitacoesController = new controller\solicitacoesController();

	Router::get('/',function() use ($homeController){
		$homeController->index();
	});

	Router::get('/me', function() use ($perfilControlller) {
		$perfilControlller->index();
	});

	Router::get('/comunidade', function() use ($comunidadeController){
		$comunidadeController->index();
	});

	Router::get('/solicitacoes', function() use ($solicitacoesController) {
		$solicitacoesController->index();
	})
	
?>
