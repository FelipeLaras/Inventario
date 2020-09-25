<?php
   //aplicando para usar variavel em outro arquivo
   session_start();
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }
   $conn->close();
   
   require_once('header.php')
   
?><!--Chamando a Header-->
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li class="active"><a href="tecnicos_ti.php"><i class="icon-home"></i><span>Home</span> </a> </li>
            <li><a href="equip.php"><i class="icon-table"></i><span>Inventário</span> </a> </li>
            <li><a href="google.php"><i class="icon-search"></i><span>Google T.I</span> </a></li>
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
         <a href="tecnicos_ti.php">Home</a>         
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
                     <img src="../img/Informatica.png" class="home_img" style="width: 61%; margin-left: 70%;"/>
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
<script src="../js/jquery-1.7.2.min.js"></script> 
<script src="../js/excanvas.min.js"></script> 
<script src="../js/chart.min.js" type="text/javascript"></script> 
<script src="../js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../js/full-calendar/fullcalendar.min.js"></script>
<script src="../js/base.js"></script> 
</body>
</html>