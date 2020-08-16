<section class="perfil-info">
	<div class="container">
		<div class="w40">
			<h2 class="title">Bem vindo <b><?php echo $_SESSION['nome_membro'] ?></b></h2>
			<div class="container-img">
				<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $_SESSION['imagem_membro'] ?>">
			</div><!--container-img-->
			<div class="lista-amigos">
				<?php
					$amigos = \models\membrosModel::listarAmigos();
				?>
				<h3><i class="fa fa-users"></i> Minhas amizades(<?php echo count($amigos) ?>)</h3>

				<?php
					foreach ($amigos as $key => $value) {
						$membro = \models\membrosModel::getMembroById($value);
				?>
				<div class="img-single-amigo">
					<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL.'uploads/'.$membro['imagem'] ?>');" class="img-single-amigo-wraper"></div>
				</div>

				<?php } ?>
			</div><!--lista-amigos-->
		</div><!--w40-->
	</div><!--container-->
</section>

<section class="feed">
	<div class="container">
		<div class="w60">
			<h2 class="title">O que está pensando hoje?</h2>
			<form method="post">
				<textarea name="mensagem" placeholder="Sua mensagem..."></textarea>
				<input type="submit" name="feed_post" value="Publicar!">
			</form>

			<?php
				$postsFeed = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.feed` ORDER BY id DESC");
				$postsFeed->execute();
				$postsFeed = $postsFeed->fetchAll();
				$aux = 0;
				foreach ($postsFeed as $key => $value) {
					foreach ($amigos as $key => $value2) {
						if($value['membro_id'] == $value2 OR $value['membro_id'] == $_SESSION['id_membro']){
							$membro = \models\membrosModel::getMembroById($value['membro_id']);
							$aux = 1;
							break;
						}
					}

					if($aux == 1){
					
			?>

			<div class="post-single-user">
				<div class="img-user-post">
					<img src="<?php echo INCLUDE_PATH_PAINEL.'uploads/'.$membro['imagem']; ?>">
				</div><!--img-user-post-->
				<div class="post-user-single">
					<p style="color: blue;"><?php echo $membro['nome']; ?></p>
					<p><?php echo $value['post']; ?></p>
				</div><!--post-user-single-->
				<div class="clear"></div>
			</div><!--post-single-user-->
					<?php } ?>
			<?php } ?>
		</div><!--w60-->
		<div class="clear"></div>
	</div><!--container-->
</section>