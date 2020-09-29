<?php
/*------------------------------------------------------------------------------------------------------------------*/

//aplicando para usar varialve em outro arquivo
session_start();
/*------------------------------------------------------------------------------------------------------------------*/
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
   header('location: ../front/index.html');

}elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {

      header('location: ../front/error.php');
}

/*------------------------------------------------------------------------------------------------------------------*/
require_once('../conexao/conexao.php');
require_once('../query/query.php');
require_once('header.php');

?>
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
                <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
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
            <i class="far fa-trash-alt"></i>&nbsp;
            <a href="equip_condenados.php">Condenados</a>
        </h3>
        <div id="novo_usuario">
            <!--ADICIONAR NOVO EQUIPAMENTO-->
            <a class="btn btn-default btn-xs botao" href="add_new.php" title="Adicionar novo equipamento">
                <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
            </a>
            <!--RELATÓRIOS-->
            <a class="btn btn-default btn-xs botao" href="relatorio_tecnicos.php" title="Ralatórios">
                <i class='btn-icon-only icon-bar-chart' style="margin-left: -3px"> </i>
            </a>
            <!--ATIVOS-->
            <a class="btn btn-default btn-xs botao" href="equip.php" title="Voltar">
               <i class="fas fa-undo-alt"></i>
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row" style="width: 111%; margin-left: -3%;">
        <table id="example" class="table table-striped table-bordered" style="font-size: 10px;">
            <thead>
                <tr>
                    <th class="titulo">Tipo Equipamento</th>
                    <th class="titulo">Voip - Ramal</th>
                    <th class="titulo">I.P.D.I</th>
                    <th class="titulo">Patrimônio</th>
                    <th class="titulo">I.P</th>
                    <th class="titulo">Respónsavel</th>
                    <th class="titulo">C.P.F</th>
                    <th class="titulo">Departamento</th>
                    <th class="titulo">Empresa / Filial</th>
                    <th class="titulo">S.O</th>
                    <th class="titulo">Office</th>
                    <th class="titulo acao">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
//aplicando a query
while ($row_equip = $resultado_equip -> fetch_assoc()) {
  
   //se for desktop
   if($row_equip['id_tipo_equipamento'] == 8){//desktop
      
         $data_branco = '9999-12-30';

         if($row_equip['data_nota_so'] != $data_branco){
            //pegando a nota e trocando o formato dela
            $data_so = date('d/m/Y',  strtotime($row_equip['data_nota_so']));
         }else{
            $data_so = '';
         }//end IF validação Windows 

         if($row_equip['data_nota_office'] != $data_branco){
            //pegando a nota e trocando o formato dela
            $data_office = date('d/m/Y',  strtotime($row_equip['data_nota_office']));
         }else{
            $data_office = '';
         }//end IF validação Office 

      echo "<tr>
            <td class='fonte condenado'>".$row_equip['tipo_equipamento']."</td>
            <td class='fonte condenado'>---</td><!--voip-->
            <td class='fonte condenado'>---</td><!--ipdi-->
            <td class='fonte condenado'>".$row_equip['patrimonio']."</td>
            <td class='fonte condenado'>".$row_equip['ip']."</td>
            <td class='fonte condenado'>".$row_equip['responsavel']."</td>
            <td class='fonte condenado'>".$row_equip['cpf']."</td>
            <td class='fonte condenado'>".$row_equip['departamento']."</td>
            <td class='fonte condenado'>".$row_equip['empresa']."</td>";
            
            if($row_equip['id_so'] != NULL){
               echo "<td class='fonte'>
                     <a href='#so".$row_equip['id_so']."' title='Mais Informações' class='icon_acao' data-toggle='modal'>
                     ".$row_equip['versao_so']."
                     </a>
                  </td>";
            }else{
               echo "<td class='fonte'><!--WINDOWS-->
                        <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
                        ---
                        </a>
                     </td>";
            }
            if($row_equip['id_office'] != NULL){
               echo "<td class='fonte'>
                     <a href='#office".$row_equip['id_office']."' title='Mais Informações' class='icon_acao' data-toggle='modal'>
                     ".$row_equip['versao_office']."
                     </a>
                  </td>";
            }else{
               echo "<td class='fonte'><!--office-->
                        <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
                        ---
                        </a>
                     </td>";
            }
     echo "<td class='fonte  acao'>
               <a href='equip_edit_condenado.php?id_equip=".$row_equip['id_equipamento']."&id_fun=".$row_equip['id_funcionario']."' title='Mais Informações' class='icon_acao'>
                  <i class='icon-folder-open'></i>
               </a>
            </td>
         </tr>";        
    
echo    "<!--MODAL WINDOWS-->
         <div id='so".$row_equip['id_so']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - ".$row_equip['versao_so']."</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> ".$row_equip['serial_so']."</p>
                        <p><span class='informacao'>Empresa:</span> ".$row_equip['empresa_so']."</p>
                        <p><span class='informacao'>Locação:</span> ".$row_equip['locacao_so']."</p>
                        <p><span class='informacao'>Data da nota:</span> ".$data_so."</p>
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='".$row_equip['file_nota_so']."' id='nota' target='_blank'>".$row_equip['file_nome_so']." </a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL OFFICE-->
         <div id='office".$row_equip['id_office']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - ".$row_equip['versao_office']."</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> ".$row_equip['serial_office']."</p>
                        <p><span class='informacao'>Empresa:</span> ".$row_equip['empresa_office']."</p>
                        <p><span class='informacao'>Locação:</span> ".$row_equip['locacao_office']."</p>
                        <p><span class='informacao'>Data da nota:</span> ".$data_office."</p>
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='".$row_equip['file_nota_office']."' id='nota' target='_blank'>".$row_equip['file_nome_office']." </a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL EXCLUIR-->
         <div id='modalExcCPU".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/alerta.png' style='width: 10%'>
                        RESTAURAR EQUIPAMENTO!
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja restaurar o equipamento ?</h5>
                           <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='equip_restaurar.php?inativar=1&id_equipamento=".$row_equip['id_equipamento']."' class='btn btn-success' >SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         ";//end tabela
         }//end if = desktop
/*------------------------------------------------------------------------------------------------------------------*/
         //se for notebook
         if($row_equip['id_tipo_equipamento'] == 9){//notebook            
         

    echo "<tr>
            <td class='fonte'>".$row_equip['tipo_equipamento']."</td>
            <td class='fonte'>---</td><!--voip-->
            <td class='fonte'>---</td><!--ipdi-->
            <td class='fonte'>".$row_equip['patrimonio']."</td>
            <td class='fonte'>".$row_equip['ip']."</td>
            <td class='fonte'>".$row_equip['responsavel']."</td>
            <td class='fonte'>".$row_equip['cpf']."</td>
            <td class='fonte'>".$row_equip['departamento']."</td>
            <td class='fonte'>".$row_equip['empresa']."</td>";
            
            if($row_equip['id_so'] != NULL){
               echo "<td class='fonte'>
                        <a href='#so".$row_equip['id_so']."' title='Mais Informações' class='icon_acao' data-toggle='modal'>
                        ".$row_equip['versao_so']."
                        </a>
                     </td>";
            }else{
               echo "<td class='fonte'><!--office-->
                        <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
                        ---
                        </a>
                     </td>";
            }

            if($row_equip['id_office'] != NULL){
               echo "<td class='fonte'>
                        <a href='#office".$row_equip['id_office']."' title='Mais Informações' class='icon_acao' data-toggle='modal'>
                        ".$row_equip['versao']."
                        </a>
                     </td>";
            }else{
               echo "<td class='fonte'><!--office-->
                        <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
                        ---
                        </a>
                     </td>";
            }
            
      echo  "<td class='fonte  acao'>
               <a href='equip_edit_condenado.php?id_equip=".$row_equip['id_equipamento']."&id_fun=".$row_equip['id_funcionario']."' title='Visualizar' class='icon_acao'>
                  <i class='icon-folder-open'></i>
               </a>
               <a href='#modalCheckN".$row_equip['id_equipamento']."' title='Check-List' class='icon_acao' data-toggle='modal'>
                  <i class='icon-large icon-ok'></i>
               </a>
            </td>
         </tr>";
    
echo    "<!--MODAL WINDOWS-->
         <div id='so".$row_equip['id_so']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - ".$row_equip['versao_so']."</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> ".$row_equip['serial_so']."</p>
                        <p><span class='informacao'>Empresa:</span> ".$row_equip['empresa_so']."</p>
                        <p><span class='informacao'>Locação:</span> ".$row_equip['locacao_so']."</p>
                        <p><span class='informacao'>Data da nota:</span> ".$data_so."</p>
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='".$row_equip['file_nota_so']."' id='nota' target='_blank'>".$row_equip['file_nota_nome_so']." </a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL OFFICE-->
         <div id='office".$row_equip['id_office']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - ".$row_equip['versao_office']."</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> ".$row_equip['serial_office']."</p>
                        <p><span class='informacao'>Empresa:</span> ".$row_equip['empresa_office']."</p>
                        <p><span class='informacao'>Locação:</span> ".$row_equip['locacao_office']."</p>
                        <p><span class='informacao'>Data da nota:</span> ".$data_office."</p>
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='".$row_equip['file_nota_office']."' id='nota' target='_blank'>".$row_equip['file_nome_office']." </a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL CHEKLIST-->
         <div id='modalCheckN".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
            <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/alerta.png' style='width: 10%'>
                        RESTAURAR EQUIPAMENTO!
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja restaurar o equipamento ?</h5>
                           <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='equip_restaurar.php?inativar=1&id_equipamento=".$row_equip['id_equipamento']."' class='btn btn-success' >SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>";//end tabela         
         }//end if = notebook

         if($row_equip['id_tipo_equipamento'] == 5){//ramal
            
            echo "<tr>
            <td class='fonte'>".$row_equip['tipo_equipamento']."</td>
            <td class='fonte'>".$row_equip['ramal']."</td>
            <td class='fonte'>".$row_equip['ipdi']."</td>
            <td class='fonte'>---</td><!--patrimonio-->
            <td class='fonte'>---</td><!--ip-->
            <td class='fonte'>".$row_equip['responsavel']."</td>
            <td class='fonte'>".$row_equip['cpf']."</td>
            <td class='fonte'>".$row_equip['departamento']."</td>
            <td class='fonte'>".$row_equip['locacao']."</td>
            
            <td class='fonte'><!--sistema operacional-->
               <a href='javascript:' title='não possui informação' class='icon_acao' data-toggle='modal'>
               ---
               </a>
            </td>
            <td class='fonte'><!--office-->
               <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
               ---
               </a>
            </td>
            <td class='fonte  acao'>
               <a href='equip_edit_condenado.php?id_equip=".$row_equip['id_equipamento']."&id_fun=".$row_equip['id_funcionario']."' title='Visualizar' class='icon_acao'>
                  <i class='icon-folder-open'></i>
               </a>
               <a href='#modalCheckRamal".$row_equip['id_equipamento']."' title='desativar' class='icon_acao' data-toggle='modal'>
                  <i class='icon-large icon-ok'></i>
               </a>
            </td>
         </tr>
         <!--MODAL CHEKLIST->
         <div id='modalCheckRamal".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
            <div class='modal-body'>
            <h3 id='myModalLabel'>
               <img src='../img/alerta.png' style='width: 10%'>
                  RESTAURAR EQUIPAMENTO!
            </h3>
               <div class='modal-body'>
                     <div id='button_pai'>
                        <h5>Deseja restaurar o equipamento ?</h5>
                        <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>
                        <span style='color:red;font-size:9px;'></span>
                     </div>                                                           
                     <div class='modal-footer'>
                        <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                        <a href='equip_restaurar.php?inativar=1&id_equipamento=".$row_equip['id_equipamento']."' class='btn btn-success' >SIM</a>
                     </div>
               </div>
            </div>
            </div>
         </div>";//end tabela  
         }//end if = ramal

         if($row_equip['id_tipo_equipamento'] == 10){//Scanner
            
            echo "<tr>
            <td class='fonte'>".$row_equip['tipo_equipamento']."</td>
            <td class='fonte'>---</td><!--ramal-->
            <td class='fonte'>---</td><!--IPDI-->
            <td class='fonte'>".$row_equip['patrimonio']."</td>
            <td class='fonte'>---</td><!--ip-->
            <td class='fonte'>".$row_equip['responsavel']."</td>
            <td class='fonte'>".$row_equip['cpf']."</td>
            <td class='fonte'>".$row_equip['departamento']."</td>
            <td class='fonte'>".$row_equip['locacao']."</td>
            
            <td class='fonte'><!--sistema operacional-->
               <a href='javascript:' title='não possui informação' class='icon_acao' data-toggle='modal'>
               ---
               </a>
            </td>
            <td class='fonte'><!--office-->
               <a href='javascript:' title='Não possui Informações' class='icon_acao' data-toggle='modal'>
               ---
               </a>
            </td>
            <td class='fonte  acao'>
               <a href='equip_edit_condenado.php?id_equip=".$row_equip['id_equipamento']."&id_fun=".$row_equip['id_funcionario']."' title='Visualizar' class='icon_acao'>
                  <i class='icon-folder-open'></i>
               </a>
               <a href='#modalCheckRamal".$row_equip['id_equipamento']."' title='desativar' class='icon_acao' data-toggle='modal'>
                  <i class='icon-large icon-ok'></i>
               </a>
            </td>
         </tr>
         <!--MODAL CHEKLIST->
         <div id='modalCheckRamal".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
            <div class='modal-body'>
            <h3 id='myModalLabel'>
               <img src='../img/alerta.png' style='width: 10%'>
                  RESTAURAR EQUIPAMENTO!
            </h3>
               <div class='modal-body'>
                     <div id='button_pai'>
                        <h5>Deseja restaurar o equipamento ?</h5>
                        <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>
                        <span style='color:red;font-size:9px;'></span>
                     </div>                                                           
                     <div class='modal-footer'>
                        <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                        <a href='equip_restaurar.php?inativar=1&id_equipamento=".$row_equip['id_equipamento']."' class='btn btn-success' >SIM</a>
                     </div>
               </div>
            </div>
            </div>
         </div>";//end tabela  
         }//end if = ramal
}//end while
?>
            </tbody>
        </table>
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