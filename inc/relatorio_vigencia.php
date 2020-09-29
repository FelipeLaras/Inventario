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

   /*-------------------------------------------------------  TRATANDO AS VARIAVEIS PARA USAR NA QUERY -------------------------------------------------------*/
//equipamentos
   //celular
   if($_GET['ce'] != NULL){
   $id_equipamento = $_GET['ce'];
   }
   //chip
   if($_GET['ch'] != NULL){
   $id_equipamento = $_GET['ch'];
   }
   //cpu
   if($_GET['cp'] != NULL){
   $id_equipamento = $_GET['cp'];
   }
   //moden
   if($_GET['mo'] != NULL){
   $id_equipamento = $_GET['mo'];
   }
   //notebook
   if($_GET['no'] != NULL){
   $id_equipamento = $_GET['no'];
   }
   //ramal
   if($_GET['ra'] != NULL){
   $id_equipamento = $_GET['ra'];
   }
   //scanner
   if($_GET['sc'] != NULL){
   $id_equipamento = $_GET['sc'];
   }
   //tablet
   if($_GET['ta'] != NULL){
   $id_equipamento = $_GET['ta'];
   }

//datas  
   //data inicial
   if($_GET['di'] != NULL){
      $data_inicial = date('d/m/Y', strtotime($_GET['di']));
   }
   //data final
   if($_GET['df'] != NULL){
      $data_final = date('d/m/Y', strtotime($_GET['df']));
   }

   /*-------------------------------------------------------  MONTANDO A PESQUISA PARA O RELATÓRIO -------------------------------------------------------*/
   $query_relatorios = "SELECT 
                           MDV.id,
                           MDV.id_equipamento,
                           MIF.nome AS colaborador,
                           MP.profile_name AS id_usuario,
                           MDV.data_vigencia,
                           MDE.nome AS tipo_equipamento
                        FROM
                           manager_data_vigencia MDV
                        LEFT JOIN
                           manager_inventario_funcionario MIF ON MIF.id_funcionario = MDV.id_funcionario
                        LEFT JOIN
                           manager_profile MP ON MP.id_profile = MDV.id_usuario
                        LEFT JOIN
                           manager_inventario_equipamento MIE ON MIE.id_equipamento = MDV.id_equipamento
                        LEFT JOIN
                           manager_dropequipamentos MDE ON MDE.id_equip = MIE.tipo_equipamento ";
                        
                        if(($_GET['te'] != NULL) AND ($id_equipamento == NULL) AND ($data_inicial == NULL) AND ($data_final == NULL)){
                           $query_relatorios .= "WHERE MIE.tipo_equipamento = ".$_GET['te'];
                        }elseif (($_GET['te'] != NULL)){
                           $query_relatorios .= " WHERE tipo_equipamento = ".$_GET['te'] ." AND ";
                        }elseif(($_GET['te'] == NULL) AND ($id_equipamento == NULL) AND ($data_inicial == NULL) AND ($data_final == NULL)){
                           $query_relatorios .= "";
                        }else{
                           $query_relatorios .= " WHERE";
                        }
                        
                        //quando tiver as opções preenchidas(Equipamento, data inicial e data final)
                        if(($id_equipamento != NULL) AND ($data_inicial != NULL) AND ($data_final != NULL)){
                           $query_relatorios .= " MDV.id_equipamento = ".$id_equipamento." AND MDV.data_vigencia BETWEEN ('".$data_inicial."') AND ('".$data_final."')";
                        }

                        //quando tiver as opções preenchidas(Equipamento)
                        if(($id_equipamento != NULL) AND ($data_inicial == NULL) AND ($data_final == NULL)){
                           $query_relatorios .= " MDV.id_equipamento = ".$id_equipamento."";
                        }

                        //quando tiver as opções preenchidas(data inicial e data final)
                        if(($id_equipamento == NULL) AND ($data_inicial != NULL) AND ($data_final != NULL)){
                           $query_relatorios .= " MDV.data_vigencia BETWEEN ('".$data_inicial."') AND ('".$data_final."')";
                        }
                                               
   $resultado_relatorios = $conn->query($query_relatorios);

   $_SESSION['query_relatorios'] = $query_relatorios;//enviando query para PDF ou EXCEL

require_once('header.php');

?><!--Chamando a Header-->
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
           Histórico de vigência
        </h3>
        <!--PDF-->
        <div id="novo_usuario">
         <a class="botao" href="relatorioV_print.php" title="Imprimir" style="margin-top: 0px;" target="_blank"> 
            <i class="fas fa-print fa-2x" style="margin-left: -3px;"></i>
         </a>
      </div>
      <!--PDF-->
        <div id="novo_usuario">
         <a class="botao" href="relatorioV_excel.php" title="Exportar EXCEL" style="margin-top: 0px;" target="_blank">
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
               <th class="titulo">T. EQUIPAMENTO</th>
               <th class="titulo">COLABORADOR</th>
               <th class="titulo">
                  USUÁRIO
                  <a href="javascript:" title='usuário que fez a alteração'>
                     <i class="fas fa-question-circle"></i>   
                  </a>
               </th>
               <th class="titulo">DATA DA VIGÊNCIA</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($row_relatorio = $resultado_relatorios->fetch_assoc()) {
            echo "
            <tr>";               
               //CÓDIGO DO EQUIPAMENTO 
               if($row_relatorio['tipo_equipamento'] != NULL){
         echo "<td>".$row_relatorio['tipo_equipamento']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //COLABORADOR
               if($row_relatorio['colaborador'] != NULL){
         echo "<td>".$row_relatorio['colaborador']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //USUÁRIO
               if($row_relatorio['id_usuario'] != NULL){
         echo "<td>".$row_relatorio['id_usuario']."</td>";         
               }else{
         echo "<td>---</td>";         
               }
               //DATA DA VIGENCIA
               if($row_relatorio['data_vigencia'] != NULL){
         echo "<td>".$row_relatorio['data_vigencia']."</td>";         
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
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>   
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>
</html>