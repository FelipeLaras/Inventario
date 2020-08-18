<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }
?>
<!DOCTYPE html>
<html>
  <?php  require 'header.php'?><!--Chamando a Header-->
<div class="subnavbar">
    <div class="container">
      <div class="error-container">                
        <h2>Cadastro alterado com Sucesso.!</h2><!-- /error-details -->
        <div class="error-details">
					  Para que se aplique as alterações você deve sair e entrar novamente no sistema!
					</div>
        <div class="error-actions">
          <a href="manager.php" class="btn btn-success">Voltar</a>
        </div>			
      </div> <!-- /error-container -->
    </div>
</div>
        
    <!-- Le javascript
    ================================================== --> 
    <!-- Placed at the end of the document so the pages load faster --> 
    <script src="js/jquery-1.7.2.min.js"></script> 
    <script src="js/excanvas.min.js"></script> 
    <script src="js/chart.min.js" type="text/javascript"></script> 
    <script src="js/bootstrap.js"></script>
    <script src="js/base.js"></script> 
  </body>
</html>