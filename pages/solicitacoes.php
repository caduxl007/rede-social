<section class="solicitacoes">
	<div class="container">
		<div class="w100">
			<h2 class="title">Solicitações Pendentes: </h2>
			
			<table class="solicitacoes__table">
				<?php
					$solicitacoesPendentes = \controller\solicitacoesController::listarSolicitacoes();
					foreach ($solicitacoesPendentes as $key => $value) {
						//Puxar informações do solicitante
						$membro = \models\membrosModel::getMembroById($value['id_from']);
				?>
					<tr>
						<td>
							<img src="<?php echo INCLUDE_PATH_PAINEL.'uploads/'.$membro['imagem'] ?>">
							<p><?php echo $membro['nome']; ?></p>
						</td>
						<td>
							<a href="<?php echo INCLUDE_PATH ?>solicitacoes?aceitar=<?php echo $value['id_from'] ?>">Aceitar!</a>
							<a href="<?php echo INCLUDE_PATH ?>solicitacoes?rejeitar=<?php echo $value['id_from'] ?>">Rejeitar!</a>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div><!--w100-->
	</div><!--container-->
</section>