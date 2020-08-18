<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif ($_SESSION["perfil"] != 0) {
       header('location: error.php');
   }
?>
<!DOCTYPE html>
<html>
    <?php  require 'header.php'?><!--Chamando a Header-->
    <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li class="active">
              <a href="manager_conf.php"><i class="icon-user"></i>
                <span>Usuários</span>
              </a>
            </li>
            <li>
              <a href='manager_drop.php'><i class='icon-list-alt'></i>
                <span>Drop-Downs</span>
              </a>
            </li>
            <!--
            <li>
              <a href="#"><i class="icon-facetime-video"></i>
                <span>App Tour</span>
              </a>
            </li>
            <li>
              <a href="#"><i class="icon-bar-chart"></i>
                <span>Charts</span>
              </a>
            </li>
            <li>
              <a href="#"><i class="icon-code"></i>
                <span>Shortcodes</span>
              </a>
            </li>-->
          </ul>
        </div> 
      </div>
    </div>
    <?php

    $id = $_SESSION['id_user'];

    if ($id == 0) {//Ativado     
    echo "<div class='accordion' id='accordion2'>
            <div class='accordion-group'>
              <div class='accordion-heading'>
                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#'>
                Mensagem!
                </a>
              </div>
              <div id='collapseOne' class='accordion-body collapse in'>
                <div class='accordion-inner'>
                  Usuário foi ativado com Sucesso!
                  <a href='manager_conf.php'>Voltar</a>
                </div>
              </div>
            </div>
          </div>";
    }else{//desativado
      echo "<div class='accordion' id='accordion2'>
            <div class='accordion-group'>
              <div class='accordion-heading'>
                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#'>
                Mensagem!
                </a>
              </div>
              <div id='collapseOne' class='accordion-body collapse in'>
                <div class='accordion-inner'>
                  Usuário foi desativado com Sucesso!
                  <a href='manager_conf.php'>Voltar</a>
                </div>
              </div>
            </div>
          </div>";
    }
    mysqli_close($conn);
    ?>
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