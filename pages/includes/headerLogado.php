<!DOCTYPE html>
<html>
<head>
    <title>Rede Social</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css">
</head>
<body>
<base base="<?php echo INCLUDE_PATH; ?>"/>

	<header>
		<div class="container">
			<div class="logo"><a href="<?php echo INCLUDE_PATH ?>">REDE SOCIAL</a></div>
			<div class="btn-opt-menu">
				<?php $solicitacoesPendentes = count(\controller\solicitacoesController::listarSolicitacoes()); ?>
				<a href="<?php echo INCLUDE_PATH ?>solicitacoes">Solicitações(<?php echo $solicitacoesPendentes ?>)</a>
				<a href="<?php echo INCLUDE_PATH ?>comunidade">Comunidade</a>
				<a href="<?php echo INCLUDE_PATH ?>me?sair"><i class="fa fa-times"></i> SAIR</a>
			</div>
			<div class="clear"></div>
		</div><!--container-->
	</header>
