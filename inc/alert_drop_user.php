<?php
//aplicando para usar varialve em outro arquivo
session_start();

//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif ($_SESSION["perfil"] != 0) {
       header('location: ../front/error.php');
}
   
require_once('../conexao/conexao.php');   
require_once('header.php');

?>
<!--Chamando a Header-->
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
            </ul>
        </div>
    </div>
</div>
<?php

    if ($_GET['id'] == 0) {//Ativado     
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
    $conn -> close();
    ?>
<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/excanvas.min.js"></script>
<script src="../js/chart.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>

</html>