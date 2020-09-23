<?php
   session_start();
   //aplicando para usar varialve em outro arquivo

   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: error.php');
   }

//recebendo as informações do formulario

//pegando as informações vinda do fomrulario e salvando em sessão para ser usado no EXCEl e na IMPRESSÂO

if ($_POST['nome_funcionario'] != NULL) {
   $nome = $_POST['nome_funcionario'];
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
                        MIE.modelo,
                        MIE.patrimonio, 
                        MIE.imei_chip, 
                        MIE.numero, 
                        MIE.valor, 
                        MDSE.nome AS status,
                        MIE.dominio
                     FROM 
                        manager_inventario_funcionario MIF
                     RIGHT JOIN 
                        manager_inventario_equipamento MIE ON MIF.id_funcionario = MIE.id_funcionario
                     LEFT JOIN 
                        manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
                     LEFT JOIN 
                        manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
                     LEFT JOIN 
                        manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
                     LEFT JOIN 
                        manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                     LEFT JOIN 
                        manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
                     WHERE ";                     
                     
                     if(($_GET['eq'] != NULL) && ($_GET['se'] != NULL)){
                        $query_relatorios .= "MIE.tipo_equipamento = ".$_GET['eq']." AND MIE.status = ".$_GET['se']."";
                     }elseif($_GET['eq'] != NULL){
                        $query_relatorios .= "MIE.tipo_equipamento = ".$_GET['eq']."";
                     }elseif($_GET['se'] != NULL){
                        $query_relatorios .= "MIE.status = ".$_GET['se']." AND MIE.tipo_equipamento in (5, 8, 9, 10)";
                     }else{
                        $query_relatorios .= "MIE.tipo_equipamento in (5, 8, 9, 10)";
                     }

$resultado_relatorios = mysqli_query($conn, $query_relatorios);


$_SESSION['query_relatorios'] = $query_relatorios;//enviando query para PDF ou EXCEL

?>

<!DOCTYPE html>
<html>
<?php  require 'header.php';?>
<style>
   select.form-control.form-control-sm {
      margin-bottom: -34px;
   }
</style>

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
               <th class="titulo">CPF</th>
               <th class="titulo">FUNÇÃO</th>
               <th class="titulo">DEPARTAMENTO</th>
               <th class="titulo">EMPRESA/FILIAL</th>
               <th class="titulo">EQUIPAMENTOS</th>
               <th class="titulo">MODELO</th>
               <th class="titulo">PATRIMÔNIO</th>
               <th class="titulo">NÚMERO</th>
               <th class="titulo">STATUS</th>               
               <th class="titulo">DOMÍNIO</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($row_relatorio = mysqli_fetch_assoc($resultado_relatorios)) {
               echo "
                  <tr>";
                     if($row_relatorio['nome'] != NULL){
                        echo "<td>".$row_relatorio['nome']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['cpf'] != NULL){
                        echo "<td>".$row_relatorio['cpf']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['funcao'] != NULL){
                        echo "<td>".$row_relatorio['funcao']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['departamento'] != NULL){
                        echo "<td>".$row_relatorio['departamento']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['filial'] != NULL){
                        echo "<td>".$row_relatorio['filial']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['tipo_equipamento'] != NULL){
                        echo "<td>".$row_relatorio['tipo_equipamento']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['modelo'] != NULL){
                        echo "<td>".$row_relatorio['modelo']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['patrimonio'] != NULL){
                        echo "<td>".$row_relatorio['patrimonio']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }

                     if($row_relatorio['numero'] != NULL){
                        echo "<td>".$row_relatorio['numero']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }
                     
                     if($row_relatorio['status'] != NULL){
                        echo "<td>".$row_relatorio['status']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }   
                     
                     if($row_relatorio['dominio'] == 1){
                        echo "<td style='color: green'>OK</td>";
                     }else{
                        echo "<td style='color: red;'>OFF</td>";
                     }
                     
         echo "      </tr>";
             }?>
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