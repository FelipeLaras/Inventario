<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){
  header('location: ../front/index.html');
}

require_once('header.php')

?><!--Chamando a Header-->
  <!-- /subnavbar -->
  <body>
    <div class="main">
      <div class="main-inner">
        <div class="container">
          <div class="painel">
            <div class="span6">
              <div class="widget">
                <div class="widget-header"> <i class="icon-bookmark"></i>
                  <h3>Selecione o programa</h3>
                </div>
                <!-- /widget-header -->
                <div class="widget-content">
                  <!--APLICANDO REGRA DE PERFIL -->
                  <div class='shortcuts'>
                    <a href='#' class='shortcut'>
                      <i class='shortcut-icon icon-folder-open'></i>
                      <span class='shortcut-label'>Contratos</span>
                    </a>
                    <a href='#' class='shortcut'>
                      <i class='shortcut-icon icon-cogs'></i>
                      <span class='shortcut-label'>Robo</span>
                    </a>
                    <a href='#' class='shortcut'>
                      <i class='shortcut-icon icon-wrench'></i>
                      <span class='shortcut-label'>Tecnicos</span>
                    </a>
                    <a href='manager_drop_inventario.php' class='shortcut'>
                      <i class='shortcut-icon icon-bar-chart'></i> 
                      <span class='shortcut-label'>
                        <font style='vertical-align: inherit;'>Inventário</font>
                      </span>
                    </a>
                  </div>
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
