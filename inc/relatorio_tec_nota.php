<?php
session_start();
//aplicando para usar varialve em outro arquivo

unset($_SESSION['id_funcionario']); //LIMPANDO A SESSION
//chamando conexão com o banco
require_once('../conexao/conexao.php');
require_once('../query/query.php');

//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
   header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {

   header('location: ../front/error.php');
}

$_SESSION['query_relatorios'] = $query_rel_fiscal; //enviando query para PDF ou EXCEL

require_once('header.php');

?>
<!--Chamando a Header-->

<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li>
               <a href="tecnicos_ti.php">
                  <i class="icon-home"></i><span>Home</span>
               </a>
            </li>
            <li class="active">
               <a href="equip.php">
                  <i class="icon-table"></i><span>Inventário</span>
               </a>
            </li>
            <li>
               <a href="google.php">
                  <i class="icon-search"></i><span>Google T.I</span>
               </a>
            </li>
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
         /
         <i class="icon-lithe icon-table"></i>&nbsp;
         <a href="equip.php">Inventário</a>
         /
         <i class="icon-lithe icon-list"></i>&nbsp;
         <a href="relatorio_tecnicos.php">Relatórios</a>
      </h3>
      <!--PDF-->
      <div id="novo_usuario">
         <a class="botao" href="relatorio_print.php" title="Imprimir" style="margin-top: 0px;" target="_blank">
            <i class="fas fa-print fa-2x" style="margin-left: -3px;"></i>
         </a>
      </div>
      <!--PDF-->
      <div id="novo_usuario">
         <a class="botao" href="relatorio_excel.php" title="Exportar EXCEL" style="margin-top: 0px;" target="_blank">
            <i class="fas fa-file-excel fa-2x" style="margin-left: -3px;"></i>
         </a>
      </div>
   </div>
</div>
<div class="container">
   <div class="row">
      <table id="example" class="table table-striped table-bordered" style="width:100%; font-size: 10px; font-weight: bold;">
         <thead>
            <tr>
               <th class="titulo">NOME FUNCIONÁRIO</th>
               <th class="titulo">DEPARTAMENTO FUNCIONÁRIO</th>
               <th class="titulo">EMPRESA EQUIPAMENTO</th>
               <th class="titulo">EQUIPAMENTOS</th>
               <th class="titulo">MODELO</th>
               <th class="titulo">IMEI</th>
               <th class="titulo">NÚMERO NOTA FISCAL</th>
               <th class="titulo">DATA NOTA FISCAL</th>
               <th class="titulo">VALOR</th>
               <th class="titulo">STATUS</th>               
               <th class="titulo">NOTA FISCAL</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($row_relatorio = $resultado_rel_fiscal->fetch_assoc()) {
               echo "<tr>";
               if(!empty($row_relatorio['nome'])){
                  echo "<td>" . $row_relatorio['nome'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }

               if(!empty($row_relatorio['DepartamentoFuncionario'])){
                  echo "<td>" . $row_relatorio['DepartamentoFuncionario'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }

               echo"
               <td>" . $row_relatorio['EmpresaEquipamento'] . "</td>
               <td>" . $row_relatorio['tipo_equipamento'] . "</td>
               <td>" . $row_relatorio['modelo'] . "</td>";

               if(!empty($row_relatorio['imei_chip'])){
                  echo "<td>" . $row_relatorio['imei_chip'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }

               if(!empty($row_relatorio['numero_nota'])){
                  echo "<td>" . $row_relatorio['numero_nota'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }

               if(!empty($row_relatorio['data_nota'])){
                  echo "<td>" . $row_relatorio['data_nota'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }   

               if(!empty($row_relatorio['valor'])){
                  echo "<td>" . $row_relatorio['valor'] . "</td>";
               }else{
                  echo "<td>----</td>";
               }    

               echo"
               <td>" . $row_relatorio['status'] . "</td>"; 

               if(!empty($row_relatorio['Nota'])){
                  echo "<td><a href='".$row_relatorio['caminho'] ."' target='_blank'><img src='../img/signin/pdf.png' style='width: 25%;margin-left: 28px;'></a></td>";
               }else{
                  echo "<td>----</td>";
               }

            echo "</tr>";
            }

            ?>
         </tbody>
      </table>
   </div>
</div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>