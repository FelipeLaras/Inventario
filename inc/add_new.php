<?php
   //aplicando para usar variavel em outro arquivo
   session_start();

   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }

    require_once('header.php')

?>
<!--Chamando a Header-->
<!-- /subnavbar -->
<div class="painel">
    <div class="span6">
        <div class="widget">
            <div class="widget-header"> <i class="icon-plus"></i>
                <h3>O que você deseja cadastrar?</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
                <div class='shortcuts'>
                    <a href='add_equip_single.php' class='shortcut' title="Só equipamento">
                        <i class='fas fa-laptop fa fa-3x' style='margin-bottom: 7px;'></i>
                        <span class='shortcut-label'></span>
                    </a>
                    <a href='equip_add.php' class='shortcut' title="Usuário junto com o equipamento">
                        <i class='fas fa-user fa fa-3x' style='margin-bottom: 7px;'></i>
                        <i class="icon-plus"></i>
                        <i class='fas fa-laptop fa fa-3x' style='margin-bottom: 7px;'></i>
                        <span class='shortcut-label'></span>
                    </a>
                    <!--shortcuts-->
                </div>
                <!--widget-->
            </div>
            <!--widget-content-->
        </div>
        <!--span6-->
    </div>
    <!--painel-->
</div>
<!-- Le javascript
================================================== -->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/excanvas.min.js"></script>
<script src="js/chart.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
<script src="js/base.js"></script>
</body>
</html>
<?php require_once('coletando_equip_ocs.php'); ?>