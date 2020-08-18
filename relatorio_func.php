<?php
   session_start();
   //aplicando para usar varialve em outro arquivo

   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
   
       header('location: error.php');
   }

//recebendo as informações do formulario

//pegando as informações vinda do fomrulario e salvando em sessão para ser usado no EXCEl e na IMPRESSÂO

if ($_GET['nome_funcionario'] != NULL) {
   $nome = $_GET['nome_funcionario'];
}else{
   $nome = 0;
}

//montando a pesquisa para o relatório
$query_relatorios = "SELECT 
MIF.nome, 
MIF.cpf, 
MDF.nome AS funcao, 
MDD.nome AS departamento, 
MDE.nome AS filial, 
MDEQ.nome AS tipo_equipamento, 
MIE.patrimonio,
MIE.modelo, 
MIE.imei_chip,
MIE.numero, 
MIE.valor,
MDSE.nome AS status
FROM manager_inventario_funcionario MIF
LEFT JOIN manager_inventario_equipamento MIE ON MIF.id_funcionario = MIE.id_funcionario
LEFT JOIN manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
LEFT JOIN manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
LEFT JOIN manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
LEFT JOIN manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
LEFT JOIN manager_dropstatus MDSE ON MIF.status = MDSE.id_status
WHERE 
MIF.deletar = 0 AND 
MIE.tipo_equipamento in (1, 3, 4, 2) AND (
MIF.nome LIKE '%".$nome."%' OR 
MIF.status = '".$_GET['status_funcionario']."' OR 
MIF.cpf = '".$_GET['gols1']."' OR 
MIF.funcao = '".$_GET['funcao_funcionario']."' OR 
MIF.departamento = '".$_GET['depart_funcionario']."' OR  
MIF.empresa = '".$_GET['empresa_funcionario']."') ORDER BY MIF.nome ASC
";

$resultado_relatorios = mysqli_query($conn, $query_relatorios);

$_SESSION['query_relatorios'] = $query_relatorios;//enviando query para PDF ou EXCEL

?>

<?php  require 'header.php'?><!--Chamando a Header-->
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li>
               <a href="inventario_ti.php"><i class="icon-home"></i>
               <span>Home</span>
               </a>
            </li>
            <li>
               <a href="inventario.php"><i class="icon-group"></i>
               <span>Colaboradores</span>
               </a>
            </li>
            <li>
               <a href="inventario_equip.php"><i class="icon-cogs"></i>
               <span>Equipamentos</span>
               </a>
            </li>
            <li class="active">
              <a href="relatorio_auditoria.php"><i class="icon-list-alt"></i>
                <span>Relatórios</span>
              </a>
            </li>
         </ul>
      </div>
   </div>
</div>
<div class="widget ">
   <div class="widget-header">
        <h3>
           <i class="icon-home"></i> &nbsp;
           <a href="inventario_ti.php">
                Home
            </a>
            /
            <i class="icon-list-alt"></i> &nbsp;
            <a href="relatorio_auditoria.php">
              Relatórios
            </a>
           / 
           Colaborador
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
         <i class="fas fa-file-excel fa-2x"  style="margin-left: -3px;"></i> 
         </a>
      </div>
      </div>  
</div>
<div class="container">
   <div class="row">
      <table id="example" class="table table-striped table-bordered" style="width:100%; font-size: 10px; font-weight: bold;">
         <thead>
            <tr>
               <th class="titulo">Nome</th>
               <th class="titulo" style="width: 75px;">CPF</th>
               <th class="titulo">FUNÇÃO</th>
               <th class="titulo">DEPARTAMENTO</th>
               <th class="titulo">EMPRESA/FILIAL</th>
               <th class="titulo">EQUIPAMENTOS</th>
               <th class="titulo">PATRIMÔNIO</th>
               <th class="titulo">MODELO</th>
               <th class="titulo">IMEI</th>
               <th class="titulo" style="width: 90px;">NÚMERO</th>
               <th class="titulo" style="width: 60px;">VALOR</th>
               <th class="titulo">STATUS</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($row_relatorio = mysqli_fetch_assoc($resultado_relatorios)) {
            echo "
            <tr>
               <td>".$row_relatorio['nome']."</td>
               <td>".$row_relatorio['cpf']."</td>
               <td>".$row_relatorio['funcao']."</td>
               <td>".$row_relatorio['departamento']."</td>
               <td>".$row_relatorio['filial']."</td>
               <td>".$row_relatorio['tipo_equipamento']."</td>";
               //patrimonio
               if($row_relatorio['patrimonio'] != NULL){
         echo "<td>".$row_relatorio['patrimonio']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //modelo
               if($row_relatorio['modelo'] != NULL){
         echo "<td>".$row_relatorio['modelo']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //imei
               if($row_relatorio['imei_chip'] != NULL){
         echo "<td>".$row_relatorio['imei_chip']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //numero
               if($row_relatorio['numero'] != NULL){
         echo "<td>".$row_relatorio['numero']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //valor
               if($row_relatorio['valor'] != NULL){
            echo "<td>".$row_relatorio['valor']."</td>";         
                  }else{
            echo "<td>---</td>";         
                  }
               //status
               if($row_relatorio['status'] != NULL){
            echo "<td>".$row_relatorio['status']."</td>";         
                  }else{
            echo "<td>---</td>";         
                  }
            echo "
            </tr>
             ";
             } ?>
         </tbody>
      </table>
   </div>
</div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>   
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>
</html>