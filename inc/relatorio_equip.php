<?php
   session_start();
   //aplicando para usar varialve em outro arquivo

   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
    //Aplicando a regra de login
    if($_SESSION["perfil"] == NULL){  
      header('location: ../front/index.html');
    
    }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
    
        header('location: ../front/error.php');
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
                        MIE.id_equipamento,
                        MIE.modelo,
                        MDEQ.nome AS tipo_equipamento,
                        MIE.patrimonio,
                        MIE.numero,
                        MDSE.nome AS status,
                        MDD.nome AS departamento,
                        MDE.nome AS filial,
                        MIE.imei_chip,
                        MIF.nome
                    FROM
                        manager_inventario_equipamento MIE
                    LEFT JOIN
                        manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                    LEFT JOIN
                        manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                    LEFT JOIN
                        manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                    LEFT JOIN
                        manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                    LEFT JOIN
                        manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status 
                    WHERE ";

                     if(($_GET['equipamento'] != NULL) && ($_GET['status_equipamento'] != NULL)){

                        $query_relatorios .= "
                        MIE.tipo_equipamento = '".$_GET['equipamento']."' AND 
                        MIE.status = '".$_GET['status_equipamento']."'                        
                        ";
                     }else{

                        if($_GET['equipamento'] != NULL){
                           $query_relatorios .= "MIE.tipo_equipamento = '".$_GET['equipamento']."'";
                        }else{
                           $query_relatorios .= "MIE.status = '".$_GET['status_equipamento']."'";
                        }//Fim IF caso a informação venha separada

                     }//Fim IF caso venha as duas informações
$query_relatorios .= " order by MIF.nome ASC";                     

$resultado_relatorios = $conn->query($query_relatorios);


$_SESSION['query_relatorios'] = $query_relatorios;//enviando query para PDF ou EXCEL

require_once('header.php')

?>
<!--Chamando a Header-->
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
            Equipamento
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
        <table id="example" class="table table-striped table-bordered"
            style="width:100%; font-size: 10px; font-weight: bold;">
            <thead>
                <tr>
                    <th class="titulo">ID</th>
                    <th class="titulo">MODELO</th>
                    <th class="titulo">EQUIPAMENTO</th>
                    <th class="titulo">PATRIMÔNIO</th>
                    <th class="titulo">NÚMERO</th>
                    <th class="titulo">IMEI</th>
                    <th class="titulo">STATUS</th>
                    <th class="titulo">DEPARTAMENTO</th>
                    <th class="titulo">EMPRESA</th>
                    <th class="titulo">FUNCIONÁRIO</th>
                </tr>
            </thead>
            <tbody>
                <?php
            while ($row_relatorio = mysqli_fetch_assoc($resultado_relatorios)) {
            echo "
            <tr>
            <td>".$row_relatorio['id_equipamento']."</td>";
               //nome
               if($row_relatorio['modelo'] != NULL){
         echo "<td>".$row_relatorio['modelo']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //tipo equipamento
               if($row_relatorio['tipo_equipamento'] != NULL){
         echo "<td>".$row_relatorio['tipo_equipamento']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //patrimonio
               if($row_relatorio['patrimonio'] != NULL){
         echo "<td>".$row_relatorio['patrimonio']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //numero
               if($row_relatorio['numero'] != NULL){
         echo "<td>".$row_relatorio['numero']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //status
               if($row_relatorio['status'] != NULL){
         echo "<td>".$row_relatorio['status']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //departamento
               if($row_relatorio['departamento'] != NULL){
         echo "<td>".$row_relatorio['departamento']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //filial
               if($row_relatorio['filial'] != NULL){
         echo "<td>".$row_relatorio['filial']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //imei_chip
               if($row_relatorio['imei_chip'] != NULL){
         echo "<td>".$row_relatorio['imei_chip']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //nome
               if($row_relatorio['nome'] != NULL){
         echo "<td>".$row_relatorio['nome']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
        echo "</tr>";
             } ?>
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