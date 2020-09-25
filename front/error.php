<!DOCTYPE html>
<html lang="pt-br">
  
<?php
//aplicando para usar varialve em outro arquivo
session_start(); 

require_once('../inc/header.php');

?><!--Chamando a Header-->

<div class="container">
	
	<div class="row">
		
		<div class="span12">
			
			<div class="error-container">
				<h1>404</h1>
				
				<h2>Opa! Alguma coisa de ruim aconteceu.</h2>
				
				<div class="error-details">
					Contate o TI e relate o erro que esta acontecendo!
					
				</div> <!-- /error-details -->
				
				<div class="error-actions">
					<a href="manager.php" class="btn btn-large btn-primary">
						Voltar
					</a>
					
					
					
				</div> <!-- /error-actions -->
							
			</div> <!-- /error-container -->			
			
		</div> <!-- /span12 -->
		
	</div> <!-- /row -->
	
</div> <!-- /container -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>

</body>

</html>
