<?php 
session_start();
include 'header.php';
?>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="error-container">
					<h2>Contrato Salvo com Sucesso!</h2>
					<div class="error-details">
						O que deseja fazer agora?
					</div> <!-- /error-details -->
					<div class="error-actions">
						<a href="contracts_add.php" class="btn btn-info">Novo</a>
						<a href="contracts_edit.php?id=<?php echo $_SESSION['number_father'] ?>" class="btn btn-warning">Exibir</a>
					</div> <!-- /error-actions -->
				</div> <!-- /error-container -->
			</div> <!-- /span12 -->
		</div> <!-- /row -->
	</div>