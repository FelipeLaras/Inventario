<?php
   session_start();
   //ocultando erros do PHP
   error_reporting(0);
   ini_set(“display_errors”, 0 );
   //aplicando para usar varialve em outro arquivo

   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif ($_SESSION["perfil"] != 0 AND $_SESSION["perfil"] != 2) {
   
       header('location: error.php');
   }

//recebendo as informações do formulario

//pegando as informações vinda do fomrulario e salvando em sessão para ser usado no EXCEl e na IMPRESSÂO

if ($_GET['in_date'] != NULL){   
   $inicio = date('d/m/Y', strtotime($_GET['in_date']));  
}

if($_GET['fi_date'] != NULL){
   $fim = date('d/m/Y', strtotime($_GET['fi_date']));
}

/*--------------------------------------------- WINODWS ---------------------------------------------*/
$windows =
"SELECT 
   MSO.file_nota_nome AS nome,
   MDSO.nome AS windows,
   MSO.numero_nota,
   MSO.file_nota AS caminho,
   MDL.nome AS locacao,
   MDE.nome AS empresa,
   MSO.data_nota
FROM
   maneger_sistema_operacional MSO
LEFT JOIN
   maneger_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
LEFT JOIN
   maneger_inventario_equipamento MIE ON MSO.id_equipamento = MIE.id_equipamento
LEFT JOIN
   maneger_droplocacao MDL ON MIE.locacao = MDL.id_empresa
LEFT JOIN
   maneger_dropempresa MDE ON MIE.filial = MDE.id_empresa
WHERE ";

if(($_GET['in_date'] == NULL) && ($_GET['fi_date'] == NULL) && ($_GET['nn'] == NULL) && ($_GET['fi'] == NULL) ){   
   $windows .= "MIE.tipo_equipamento in (5, 8, 9, 10)";
}

if(($_GET['in_date'] != NULL) && ($_GET['fi_date'] != NULL)){
   $windows .= "MIE.tipo_equipamento in (5, 8, 9, 10) AND MSO.data_nota between '".$inicio."' AND '".$fim."'";
}

$resultado_windows = mysqli_query($conn, $windows);

$_SESSION['query_windows'] = $windows;//enviando query para PDF ou EXCEL


/*--------------------------------------------- OFFICE ---------------------------------------------*/

$office =
"SELECT 
   MOF.file_nota_nome AS nome,
   MDSO.nome AS office,
   MOF.numero_nota,
   MOF.file_nota AS caminho,
   MDL.nome AS locacao,
   MDE.nome AS empresa,
   MOF.data_nota
FROM
   maneger_office MOF
LEFT JOIN
   maneger_dropsistemaoperacional MDSO ON MOF.versao = MDSO.id
LEFT JOIN
   maneger_inventario_equipamento MIE ON MOF.id_equipamento = MIE.id_equipamento
LEFT JOIN
   maneger_droplocacao MDL ON MIE.locacao = MDL.id_empresa
LEFT JOIN
   maneger_dropempresa MDE ON MIE.filial = MDE.id_empresa
WHERE ";
   
if(($_GET['in_date'] == NULL) && ($_GET['fi_date'] == NULL) && ($_GET['nn'] == NULL) && ($_GET['fi'] == NULL) ){    
   $office .= "MIE.tipo_equipamento in (5, 8, 9, 10)";
}

if(($_GET['in_date'] != NULL) && ($_GET['fi_date'] != NULL)){
   $office .= "MIE.tipo_equipamento in (5, 8, 9, 10) AND MOF.data_nota between '".$inicio."' AND '".$fim."'";
}

$resultado_office = mysqli_query($conn, $office);

$_SESSION['query_office'] = $office;//enviando query para PDF ou EXCEL

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
               <th class="titulo">NOME</th>
               <th class="titulo">TIPO</th>
               <th class="titulo">VERSÃO</th>
               <th class="titulo">NÚMERO</th>
               <th class="titulo">LOCALIDADE</th>
               <th class="titulo">EMPRESA FINANCEIRA</th>
               <th class="titulo">DATA</th>
            </tr>
         </thead>
         <tbody>
            <!--TABELA-->
            <?php
            if($_GET['tipo'] == 0){//windows
               while ($row_windows = mysqli_fetch_assoc($resultado_windows)) {
                  echo "
                  <tr>";
                  if($row_windows['nome'] != NULL){
                     echo "<td>
                              <a href='".$row_windows['caminho']."' target='_blank'>
                                 ".$row_windows['nome']."
                              </a>
                           </td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  echo "<td>WINDOWS</td>";
      
                  if($row_windows['windows'] != NULL){
                     echo "<td>".$row_windows['windows']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_windows['numero_nota'] != NULL){
                     echo "<td>".$row_windows['numero_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_windows['locacao'] != NULL){
                     echo "<td>".$row_windows['locacao']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_windows['empresa'] != NULL){
                     echo "<td>".$row_windows['empresa']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_windows['data_nota'] != NULL){
                     echo "<td>".$row_windows['data_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }         
           echo "   </tr>";
                   }//FIM WHILE

            }
            
            if($_GET['tipo'] == 1){//office
               while ($row_office = mysqli_fetch_assoc($resultado_office)) {
                  echo "
                  <tr>";
                  if($row_office['nome'] != NULL){
                     echo "<td>
                              <a href='".$row_office['caminho']."' target='_blank'>
                                 ".$row_office['nome']."
                              </a>
                           </td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  echo "<td>OFFICE</td>";
      
                  if($row_office['office'] != NULL){
                     echo "<td>".$row_office['office']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['numero_nota'] != NULL){
                     echo "<td>".$row_office['numero_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['locacao'] != NULL){
                     echo "<td>".$row_office['locacao']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['empresa'] != NULL){
                     echo "<td>".$row_office['empresa']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['data_nota'] != NULL){
                     echo "<td>".$row_office['data_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }         
           echo "   </tr>";
                   }//FIM WHILE

            }
            
            if($_GET['tipo'] == NULL){//CASO TENHA OS DOIS
               while ($row_office = mysqli_fetch_assoc($resultado_office)) {
                  echo "
                  <tr>";
                  if($row_office['nome'] != NULL){
                     echo "<td>
                              <a href='".$row_office['caminho']."' target='_blank'>
                                 ".$row_office['nome']."
                              </a>
                           </td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  echo "<td>OFFICE</td>";
      
                  if($row_office['office'] != NULL){
                     echo "<td>".$row_office['office']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['numero_nota'] != NULL){
                     echo "<td>".$row_office['numero_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['locacao'] != NULL){
                     echo "<td>".$row_office['locacao']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['empresa'] != NULL){
                     echo "<td>".$row_office['empresa']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }
      
                  if($row_office['data_nota'] != NULL){
                     echo "<td>".$row_office['data_nota']."</td>";
                  }else{
                     echo "<td>---</td>";
                  }         
           echo "   </tr>";
                   }//FIM WHILE
                   
                   while ($row_windows = mysqli_fetch_assoc($resultado_windows)) {
                     echo "
                     <tr>";
                     if($row_windows['nome'] != NULL){
                        echo "<td>
                                 <a href='".$row_windows['caminho']."' target='_blank'>
                                    ".$row_windows['nome']."
                                 </a>
                              </td>";
                     }else{
                        echo "<td>---</td>";
                     }
         
                     echo "<td>WINDOWS</td>";
         
                     if($row_windows['windows'] != NULL){
                        echo "<td>".$row_windows['windows']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }
         
                     if($row_windows['numero_nota'] != NULL){
                        echo "<td>".$row_windows['numero_nota']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }
         
                     if($row_windows['locacao'] != NULL){
                        echo "<td>".$row_windows['locacao']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }
         
                     if($row_windows['empresa'] != NULL){
                        echo "<td>".$row_windows['empresa']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }
         
                     if($row_windows['data_nota'] != NULL){
                        echo "<td>".$row_windows['data_nota']."</td>";
                     }else{
                        echo "<td>---</td>";
                     }         
              echo "   </tr>";
                      }//FIM WHILE
            }//FIM IF
             ?>
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