<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){
  header('location: ../front/index.html');
}

require_once('header.php');


?><!--Chamando a Header-->
    <!-- /subnavbar -->
    <div class="main">
      <div class="main-inner">
        <div class="container">
          <div class="painel">
            <div class="span6">
              <div class="widget">
                <div class="widget-header"> <i class="icon-bookmark"></i>
                  <h3>Inventário diponível - Selecione qual deseja trabalhar!</h3>
                </div>
                <!-- /widget-header -->
                <div class="widget-content">
                  <!--APLICANDO REGRA DE PERFIL -->

                  <?php
                   if ($_SESSION["perfil"] == 0) {//se for administrador
                      echo "
                      <div class='shortcuts'>
                        <a href='contracts.php' class='shortcut'>
                          <i class='fas fa-folder-open fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>Contratos</span>
                        </a>
                        <a href='tecnicos_ti.php' class='shortcut'>
                          <i class='fas fa-laptop fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>CPU / Notebook / Ramal</span>
                        </a>
                        <a href='inventario_ti.php' class='shortcut'>
                          <i class='fas fa-mobile-alt fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>
                            <font style='vertical-align: inherit;''>
                              <font style='vertical-align: inherit;''>Celular / Tablet / Chip</font>
                            </font>
                          </span>
                        </a>
                      </div>";
                    }else if ($_SESSION["perfil"] == 1){// se for usuario
                        echo "
                      <div class='shortcuts'>
                        <a href='contracts.php' class='shortcut'>
                          <i class='fas fa-folder-open fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>Contratos</span>
                        </a>
                        <a href='inventario_ti.php' class='shortcut'>
                          <i class='fas fa-mobile-alt fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>
                            <font style='vertical-align: inherit;''>
                              <font style='vertical-align: inherit;''>Celular / Tablet / Chip</font>
                            </font>
                          </span>
                        </a>

                      </div>";
                    }else if ($_SESSION["perfil"] == 2){// se for tecnicos
                      echo "
                      <div class='shortcuts'>
                        <a href='tecnicos_ti.php' class='shortcut'>
                          <i class='fas fa-laptop fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>CPU / Notebook / Ramal</span>
                        </a>
                      </div>";
                    }elseif($_SESSION["perfil"] == 4){//se for usuarios do tecnicos RS
                      echo "
                      <div class='shortcuts'>
                        <a href='inventario_ti.php' class='shortcut'>
                          <i class='fas fa-mobile-alt fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>
                            <font style='vertical-align: inherit;''>
                              <font style='vertical-align: inherit;''>Celular / Tablet / Chip</font>
                            </font>
                          </span>
                        </a>
                        <a href='tecnicos_ti.php' class='shortcut'>
                          <i class='fas fa-laptop fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>CPU / Notebook / Ramal</span>
                        </a>
                      </div>";
                    }else{
                      echo "
                      <div class='shortcuts'>
                        <a href='inventario_ti.php' class='shortcut'>
                          <i class='fas fa-mobile-alt fa fa-3x' style='margin-bottom: 7px;'></i>
                          <span class='shortcut-label'>
                            <font style='vertical-align: inherit;''>
                              <font style='vertical-align: inherit;''>Celular / Tablet / Chip</font>
                            </font>
                          </span>
                        </a>

                      </div>";
                    }
                    mysqli_close($conn);
                  ?>
                <!-- /shortcuts --> 
                </div>
              <!-- /widget-content --> 
              </div>
            <!-- /widget -->
            </div>
            <!-- /span6 --> 
          </div>
        <!-- /row --> 
        </div>
      <!-- /container --> 
      </div>
      <!-- /main-inner --> 
    </div>
    <!-- Le javascript
    ================================================== --> 
    <!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script> 
<script src="js/base.js"></script> 
</body>
</html>
