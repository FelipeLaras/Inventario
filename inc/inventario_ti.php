<?php
   //aplicando para usar variavel em outro arquivo
   session_start();
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4) && ($_SESSION["perfil"] != 3)) {
   
       header('location: ../front/error.php');
   }


/* ------------------------------ limando os históricos ------------------------------ */
 
//pegando os funcionarios que estão com o status diferente de 8(Demitido) e 3(Falta termo)

$query_funcionario = "SELECT id_funcionario FROM manager_inventario_funcionario WHERE status NOT IN (8,3)";

$result_funcionario = $conn->query($query_funcionario);

while($funcionario = mysqli_fetch_assoc($result_funcionario)){

   $limpar = "SELECT id FROM manager_invent_historico WHERE id_funcionario = ".$funcionario['id_funcionario']."";
   $result_limpar = $conn->query($limpar);

   while($limpar_historico = mysqli_fetch_assoc($result_limpar)){

      $deletar = "UPDATE manager_invent_historico SET deletado = 1 WHERE id = ".$limpar_historico['id']."";
      $result_deletar = $conn->query($deletar);
      
   }//fim while deletando

}//fim while verificando usuário

/*UM PEQUENO AJUSTE PARA ELIMINAR FUNCIONARIOS QUE NÃO POSSUEM EQUIPAMENTOS*/

$queryInativar = "SELECT MIF.nome, MIF.id_funcionario, MIE.id_equipamento, MIF.deletar FROM manager_inventario_funcionario MIF
                  LEFT JOIN manager_inventario_equipamento MIE ON (MIF.id_funcionario = MIE.id_funcionario)
                  WHERE MIF.deletar = 0 AND MIF.status = 8 AND MIE.id_equipamento IS NULL";
                  
$resultInativar = $conn->query($queryInativar);


while($inativar = $resultInativar->fetch_assoc()){
   $updateInativar = "UPDATE manager_inventario_funcionario SET deletar = 1 WHERE id_funcionario = ".$inativar['id_funcionario']."";

   printf($updateInativar);
   $inativar = $conn->query($updateInativar);
}


$conn -> close();

require_once('header.php')

?><!--Chamando a Header-->
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li class="active"><a href="inventario_ti.php"><i class="icon-home"></i><span>Home</span></a></li>
            <li><a href="inventario.php"><i class="icon-group"></i><span>Colaborador</span></a> </li>
            <?php 
               if(($_SESSION["perfil"] != 3)){
                  echo '
                  <li><a href="inventario_equip.php"><i class="icon-cogs"></i><span>Equipamentos</span></a></li>
                  <li><a href="relatorio_auditoria.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>';
               }            
            ?>
            
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
                     <img src="../img/home_inventario.png" class="home_img"/>
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