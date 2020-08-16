<section class="comunidade">
	<div class="container">
		<div class="w100">
			<h2 class="title">Comunidade</h2>
			
			<?php
				$select = \Mysql::conectar()->prepare("SELECT * FROM `tb_site.membros` WHERE id != $_SESSION[id_membro]");
				$select->execute();
				$membros = $select->fetchAll();
				foreach ($membros as $key => $value) {
			?>

				<div class="membros-listagem">
					<div class="box-imagem">
						<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>');" class="box-imagem-wraper"></div>
					</div><!--box-imagem-->
					<p><i class="fa fa-user"></i> <?php echo $value['nome'] ?></p>

					<?php 
						if($arr['controller']->isAmigo($value['id'])) {
							echo '<span class="amigo" ><i class="fa fa-check"></i> Amigo</span>';
						}else if($arr['controller']->amigoPendente($value['id']) == false){
					?>
						<a href="<?php echo INCLUDE_PATH ?>comunidade?addFriend=<?php echo $value['id']; ?>">Adicionar como amigo</a>
					<?php }else{ ?>
						<a style="opacity: 0.5;" href="javascript:void(0);">Solicitação pendente</a>
					<?php } ?>

				</div><!--membros-listagem-->

			<?php } ?>
		</div><!--w100-->
	</div><!--container-->
</section><!--comunidade-->