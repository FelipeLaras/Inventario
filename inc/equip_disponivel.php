<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   /*------------------------------------------------------------------------------------------------------------------*/
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }

require_once('../conexao/conexao.php');
require_once('header.php');
require_once('query.php');


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
<?php
        if($_GET['msn'] == 2){//encontrado porém o usuário está desativado
            echo "
                <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                     Equipamento<b style='color:red'>  vinculado ao usuário</b> com sucesso! 
                </div>";
        }//end alerta erro 1
        ?>
<div class="widget ">
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="tecnicos_ti.php">Home</a>
            /
            <i class="icon-lithe icon-table"></i>&nbsp;
            <a href="equip.php">Inventário</a>
            /
            <i class="icon-lithe far fa-check-circle"></i>&nbsp;
            <a href="equip_disponivel.php">Disponíveis</a>
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
            <!--CONDENADOS-->
            <a class="btn btn-default btn-xs botao" style="background-color: #ff000029;" href="equip_condenados.php"
                title="Equipamentos condenados">
                <i class="far fa-trash-alt"></i>
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
                    <th class="titulo">T. Equip.</th>
                    <th class="titulo">Número</th>
                    <th class="titulo">Patrimônio</th>
                    <th class="titulo">I.P</th>
                    <th class="titulo">Departamento</th>
                    <th class="titulo">Empresa / Filial</th>
                    <th class="titulo">S.O</th>
                    <th class="titulo">Office</th>
                    <th class="titulo acao">Status</th>
                    <th class="titulo acao">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
//aplicando a query
while ($row_equip = $resultadoEquipDisponivel -> fetch_assoc()) {

   empty($row_equip['data_nota_so']) ? $data_so = "semNota" : $data_so = $row_equip['data_nota_so'];//data nota do sistema operacional 

   empty($row_equip['data_nota_office']) ? $data_office = "semNota" : $data_office = $row_equip['data_nota_office'];;//data nota do office
      
      echo "<tr>
            <td class='fonte'>".$row_equip['tipo_equipamento']."</td>
            <td class='fonte'>";if ($row_equip['ramal'] != NULL){ echo $row_equip['ramal'];}else{ echo "---";} echo "</td>
            <td class='fonte'>".$row_equip['patrimonio']."</td>
            <td class='fonte'>".$row_equip['ip']."</td>
            <td class='fonte'>".$row_equip['departamento']."</td>
            <td class='fonte'>".$row_equip['empresa']."</td>";
            
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
            
            if ($row_equip['id_status'] == 6) {// 6 = disponivel
               echo "<td class='fonte'> <i class='fas fa-circle' style='color: #72f91d;'></i> ".$row_equip['status']."</td>";
             }elseif ($row_equip['id_status'] == 10) {// 10 = reservado
               echo "<td class='fonte'><i class='fas fa-circle' style='color: #ebef0b;'></i> ".$row_equip['status']."</td>";
             }  

             echo "
            <td class='fonte  acao'>
               <a href='equip_edit_disponivel.php?id_equip=".$row_equip['id_equipamento']."&tipo=".$row_equip['id_tipo_equipamento']."' title='Mais informações' class='icon_acao'>
                  <i class='icon-folder-open' style='font-size: 12px;'></i>
               </a>
               <a href='#modalUsuario".$row_equip['id_equipamento']."' title='Vincular usuário' class='icon_acao' data-toggle='modal'>
                  <i class='fas fa-user-plus' style='font-size: 12px;'></i>
               </a>
            </td>
         </tr>
         
         <!--MODAL WINDOWS-->
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
                        <p><span class='informacao'>Modelo:</span>
                           <a href='equip_modelo.php?id_win=".$row_equip['id_so']."' id='nota' target='_blank'>Imprimir</a>
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
                        <p><span class='informacao'>Modelo:</span>
                           <a href='equip_modelof.php?id_off=".$row_equip['id_office']."' id='nota' target='_blank'>Imprimir</a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL EXCLUIR-->
         <div id='modalUsuario".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='img/alerta.png' style='width: 10%'>
                        VINCULAR A UM NOVO USUÁRIO
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja vincular o equipamento</h5>";
                           if($row_equip['id_tipo_equipamento'] == 5){
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Ramal: ".$row_equip['ramal']."";
                           }else{
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>";
                           }
                           echo "
                           <span style='color:red;font-size:9px;'></span>
                           <h5>a qual usuário ?</h5>
                           <div class='add_funcionario_tecnicos'>
                              <input type='button' name='alert' id='alert' class='btn btn-success' value='+' onclick='abrir();' title='adicionar funcionário'>
                           </div>
                        </div> 
                        <form class='form-horizontal' action='equip_update_disponivel.php' method='POST' autocomplete='off' target='_blank'>
                           <input type='text' style='display:none;' name='id_equip' value='".$row_equip['id_equipamento']."' />
                           <div class='control-group'>
                              <label class='control-label'>Usuário:</label>
                              <div class='controls'>
                                 <select class='span2' style='margin-top: -40px; margin-left: 61px;' name='id_funcionario' required>
                                    <option value=''>---</option>";
                                          while($row_status = $result_status -> fetch_assoc()){
                                             echo "<option value='".$row_status['id_funcionario']."'>".$row_status['nome']."</option>";
                                          }                                             
                                    echo"
                                 </select>
                              </div>
                           </div>                                                                                               
                              <div class='modal-footer'>
                              <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                              <button type='submit' class='btn btn-success' target='_blank'>SIM</button>
                           </div>
                        </form>
                  </div>
               </div>
            </div>
         </div>
         <!--MODAL CHEKLIST-->
         <div id='modalChelist".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='img/alerta.png' style='width: 10%'>
                        CHEKLIST
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja emitir para o equipamento ?</h5>";
                           if($row_equip['id_tipo_equipamento'] == 5){
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Ramal: ".$row_equip['ramal']."</p>";
                           }else{
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>";
                           }
                           echo "
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='pdf_cheqlist_tecnicos.php?id_fun=".$row_equip['id_funcionario']."' class='btn btn-success' target='_blank'>SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <!--MODAL VIGÊNCIA-->
         <div id='modalVigencia".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='img/atencao.png' style='width: 10%'>
                        DATA DE VIGÊNCIA
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Inserindo a data de vigencia, você estará informando que o usuário ".$row_equip['responsavel']." não será mais responsável pelo equipamento...</h5><br />";
                           
                           if($row_equip['id_tipo_equipamento'] == 5){
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Ramal: ".$row_equip['ramal']."";
                           }else{
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>";
                           }
                           echo "
                           <h5>Deseja continuar com a solicitação?</h5>
                           <br />
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='pdf_cheqlist_tecnicos.php?id_fun=".$row_equip['id_funcionario']."' class='btn btn-success' target='_blank'>SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         ";//end tabela
}//end while
?>
            </tbody>
        </table>
    </div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
<!--MOSTRAR CAMPO ICONE-->
<script>
function mostrar(id) {
    document.getElementById(id).style.display = 'block';
}

function fechar(id) {
    if (document.getElementById(id).style.display == 'block') {
        document.getElementById(id).style.display = 'none';
    } else {
        document.getElementById(id).style.display = 'block';
    }
}
</script>
<!--MOSTRAR CAMPO ICONE-->
<script language="javascript">
  function abrir(){
    window.open("add_funcionario.php","mywindow","width=500,height=600");
}
</script>
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>
</html>