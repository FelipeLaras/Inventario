<?php
   //aplicando para usar variavel em outro arquivo
   session_start();
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4) && ($_SESSION["perfil"] != 3)) {
   
       header('location: error.php');
   }
   mysqli_close($conn);
   ?>
<?php  require 'header.php'?><!--Chamando a Header-->
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li class="active"><a href="inventario_ti.php"><i class="icon-home"></i><span>Home</span></a></li>
            <li><a href="inventario.php"><i class="icon-group"></i><span>Colaborador</span></a> </li>
            <li><a href="inventario_equip.php"><i class="icon-cogs"></i><span>Equipamentos</span></a></li>
            <li><a href="relatorio_auditoria.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
         </ul>
      </div>
      <!-- /container --> 
   </div>
   <!-- /subnavbar-inner --> 
</div>
<div class="widget ">
   <div class="widget-header">
      <h3>
         <i class="icon-lithe icon-home"></i>&nbsp;
         Home         
      </h3>
   </div>   
</div>
<!-- /subnavbar -->
<div class="main">
   <div class="main-inner">
      <div class="container">
         <div class="row">
            <div id="notepad">
               <div class="span6">           
                  <div id="teste">
                     <img src="img/home_inventario.png" class="home_img"/>
                  </div>
               </div>
            </div>
         <!-- /span6 --> 
         </div>
      <!-- /row --> 
      </div>
   <!-- /container --> 
   </div>
<!-- /main-inner --> 
</div>

<!-- /extra -->
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