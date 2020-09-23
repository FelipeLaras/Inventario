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


/* ------------------------------ limando os históricos ------------------------------ */
 
//pegando os funcionarios que estão com o status diferente de 8(Demitido) e 3(Falta termo)

$query_funcionario = "SELECT id_funcionario FROM manager_inventario_funcionario WHERE status NOT IN (8,3)";

$result_funcionario = mysqli_query($conn, $query_funcionario);

while($funcionario = mysqli_fetch_assoc($result_funcionario)){

   $limpar = "SELECT id FROM manager_invent_historico WHERE id_funcionario = ".$funcionario['id_funcionario']."";
   $result_limpar = mysqli_query($conn, $limpar);

   while($limpar_historico = mysqli_fetch_assoc($result_limpar)){

      $deletar = "UPDATE manager_invent_historico SET deletado = 1 WHERE id = ".$limpar_historico['id']."";
      $result_deletar = mysqli_query($conn, $deletar) or die(mysqli_error($conn));
      
   }//fim while deletando

}//fim while verificando usuário

/*UM PEQUENO AJUSTE PARA ELIMINAR FUNCIONARIOS QUE NÃO POSSUEM EQUIPAMENTOS*/

$verificar_funcio = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$row['id_funcionario']."'";
$resulado_ver_funci = mysqli_query($conn, $verificar_funcio);
$linha_ver = mysqli_fetch_assoc($resulado_ver_funci);
if ($linha_ver['id_equipamento'] == NULL) {
   $update_ver_funcio = "UPDATE manager_inventario_funcionario SET status = 9 WHERE id_funcionario = '".$row['id_funcionario']."'";
   $resul = mysqli_query($conn, $update_ver_funcio) or die(mysqli_error($conn));
}

   $conn -> close();
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