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
			<div class="form-login">
				<form method="post">
					<input type="text" name="email" placeholder="E-mail...">
					<input type="password" name="senha" placeholder="Senha...">
					<input type="submit" name="login" value="Entrar">
				</form>
			</div><!--form-login-->
			<div class="clear"></div>
		</div><!--container-->
	</header>
