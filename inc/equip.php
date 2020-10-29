<?php
//aplicando para usar varialve em outro arquivo
session_start();
/*------------------------------------------------------------------------------------------------------------------*/
//chamando conexão com o banco
require_once('../conexao/conexao.php');
require_once('header.php');
require_once('../query/query.php');
/*------------------------------------------------------------------------------------------------------------------*/
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
   header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {

   header('location: ../front/error.php');
}
/*------------------------------------------------------------------------------------------------------------------*/
//chamandos todos os equipamento do tipo (notebooks, desktops, ramais)
$equipamentos = "SELECT 
                  MIF.id_funcionario,
                  MIE.dominio,
                  MIE.id_equipamento,
                  MIE.modelo,
                  MDEQ.nome AS tipo_equipamento,
                  MIE.tipo_equipamento AS id_tipo_equipamento,
                  MIE.numero AS ramal,
                  MIE.patrimonio,
                  MIE.ip,
                  MIF.nome AS responsavel,
                  MIF.cpf,
                  MIF.status AS id_fun_status,
                  MDSF.nome AS fun_status,
                  MDD.nome AS departamento,
                  MDLB.nome AS locacao,
                  MDE.nome AS empresa,
                  MSO.id AS id_so,
                  MDSO.nome AS versao_so,
                  MSO.serial AS serial_so,
                  MDE.nome AS empresa_so,
                  MDL.nome AS locacao_so,
                  MSO.data_nota AS data_nota_so,
                  MSO.file_nota AS file_nota_so,
                  MSO.file_nota_nome AS file_nome_so,
                  MO.id AS id_office,
                  MDO.nome AS versao_office,
                  MO.serial AS serial_office,
                  MDE.nome AS empresa_office,
                  MDLA.nome AS locacao_office,
                  MO.data_nota AS data_nota_office,
                  MO.file_nota AS file_nota_office,
                  MO.file_nota_nome AS file_nome_office,
                  MSO.file_nota_nome AS win_nota,
                  MO.file_nota_nome AS off_nota,
                  MO.deletar AS delOffice,
                  MSO.deletar AS delWin
               FROM
                  manager_inventario_equipamento MIE
               LEFT JOIN
                  manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
               LEFT JOIN
                  manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
               LEFT JOIN
                  manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
               LEFT JOIN
                  manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
               LEFT JOIN
                  manager_office MO ON MIE.id_equipamento = MO.id_equipamento
               LEFT JOIN
                  manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
               LEFT JOIN
                  manager_dropoffice MDO ON MO.versao = MDO.id
               LEFT JOIN
                  manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
               LEFT JOIN
                  manager_droplocacao MDL ON MSO.locacao = MDL.id_empresa
               LEFT JOIN
                  manager_droplocacao MDLA ON MO.locacao = MDLA.id_empresa
               LEFT JOIN
                  manager_droplocacao MDLB ON MIE.locacao = MDLB.id_empresa
               LEFT JOIN
                  manager_dropstatus MDSF ON MIF.status = MDSF.id_status
               WHERE
                  MIE.deletar = 0 AND
                  MIE.status NOT IN (6 , 10)";

if ($_GET['status'] != NULL) {
   //acresentando item para o select
   if ($_GET['cpu'] == 1) {
      $equipamentos .= "AND MIF.status = " . $_GET['status'] . " AND MIE.tipo_equipamento IN (9 , 5)";
   } else {
      $equipamentos .= "AND MIF.status = " . $_GET['status'] . " AND MIE.tipo_equipamento IN (9 , 5, 8)";
   }
} else {
   $equipamentos .= "AND MIE.tipo_equipamento IN (9 , 5, 8)";
}

$resultado_equip = $conn->query($equipamentos);    

$nenhumfuncionario = $resultado_equip -> fetch_assoc();

if ($nenhumfuncionario['id_funcionario'] == NULL) {//forçando deixar disponivel
   $updateDisponivel = "UPDATE manager_inventario_equipamento SET status = '6' WHERE (id_equipamento = ".$row_equip['id_equipamento'].")";
   $aplicarUpdate = $conn -> query($updateDisponivel);
}

//contagem equipamentos alterados
$cont = "SELECT COUNT(id) AS quantidade FROM manager_comparacao_ocs";
$result_count = $conn->query($cont);
$row_count = $result_count->fetch_assoc();

?>

<style>
   .col-sm-12.col-md-6 {
      width: 10px;
   }
</style>
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
            <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
         </ul>
      </div>
      <!-- /container -->
   </div>
   <!-- /subnavbar-inner -->
</div>

<?php
if ($_GET['msn'] == 1) { //encontrado porém o usuário está desativado
   echo "
                <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                     <b style='color:red'>Equipamento desvinculado</b> com sucesso! 
                </div>";
} //end alerta erro 1
?>
<style>
   select.form-control.form-control-sm {
      margin-bottom: -33px;
   }
</style>
<div class="widget ">
   <div class="widget-header">
      <h3>
         <i class="icon-lithe icon-home"></i>&nbsp;
         <a href="tecnicos_ti.php">Home</a>
         /
         <i class="icon-lithe icon-table"></i>&nbsp;
         Inventário
      </h3>
      <div id="novo_usuario">
         <!--ADICIONAR NOVO EQUIPAMENTO-->
         <a class="btn btn-default btn-xs botao" href="add_new.php" title="Adicionar novo equipamento">
            <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
         </a>
         <!--RELATÓRIOS-->
         <a class="btn btn-default btn-xs botao" href="relatorio_tecnicos.php" title="Relatórios">
            <i class='btn-icon-only icon-bar-chart' style="margin-left: -3px">
               <?php
               if ($row_count['quantidade'] != 0) {

                  if ($row_count['quantidade'] >= 99) {

                     echo "<div id='contador'>+99</div>";
                  } elseif ($row_count['quantidade'] >= 10) {

                     echo "<div id='contador_b'>" . $row_count['quantidade'] . "</div>";
                  } else {
                     echo "<div id='contador_a'>" . $row_count['quantidade'] . "</div>";
                  }                             //end IF mostrando na tela

               } //end IF validando o contador   
               ?>
            </i>
         </a>
         <!--CONDENADOS-->
         <a class="btn btn-default btn-xs botao" href="equip_condenados.php" title="Equipamentos condenados">
            <i class="far fa-trash-alt"></i> = <?= $row_condenados['condenados'] ?>
         </a>
         <!--DISPONIVEIS-->
         <a class="btn btn-default btn-xs botao" href="equip_disponivel.php" title="Equipamentos disponíveis">
            <i class="fas fa-laptop"></i> = <?= $row_disponivel['disponivel'] ?>
         </a>
         <!--SCANNERS-->
         <a class="btn btn-default btn-xs botao" href="scan_disponivel.php" title="Lista de Scanners">
            <i class="fas fa-print"></i> = <?= $row_scanner['scanner'] ?>
         </a>
         <!--OFFICE-->
         <a class="btn btn-default btn-xs botao" href="office_disponivel.php" title="Office Disponivéis">
            <i class="fab fa-windows"></i> = <?= $row_office['office'] ?>
         </a>
      </div>
   </div>
</div>


<div class="container">

   <!--botões para chamar os status-->
   <div class="row" style="width: 111%;  margin-left: -4%;">
      <table id="example" class="table table-striped table-bordered" style="font-size: 10px;">
         <thead>
            <tr>
               <th class="titulo">ID</th>
               <th class="titulo">Equipamento</th>
               <th class="titulo">Nº</th>
               <th class="titulo">Patrimônio</th>
               <th class="titulo">I.P</th>
               <th class="titulo">Respónsavel</th>
               <th class="titulo">C.P.F</th>
               <th class="titulo">Filial</th>
               <th class="titulo">S.O</th>
               <th class="titulo">Office</th>
               <th class="titulo">A.D</th>
               <th class="titulo">Status</th>
               <th class="titulo acao">Ação</th>
            </tr>
         </thead>
         <tbody>
            <?php
            //aplicando a query
            while ($row_equip = $resultado_equip->fetch_assoc()) {

               echo "<tr><td class='fonte'>" . $row_equip['id_equipamento'] . "</td>";
               echo ($row_equip['id_tipo_equipamento'] == 5) ? "<td class='fonte'>" . $row_equip['modelo'] . "</td>" : "<td class='fonte'>" . $row_equip['tipo_equipamento'] . "</td>";
               echo ($row_equip['ramal'] != NULL) ? "<td class='fonte'>" . $row_equip['ramal'] . "</td>" : "<td class='fonte'>---</td>";
               echo ($row_equip['patrimonio'] != NULL) ? "<td class='fonte'>" . $row_equip['patrimonio'] . "</td>" : "<td class='fonte'>---</td>";
               echo ($row_equip['ip'] != NULL) ? "<td class='fonte'>" . $row_equip['ip'] . "</td>" : "<td class='fonte'>---</td>";
               echo "<td class='fonte'>" . $row_equip['responsavel'] . "</td>
                     <td class='fonte'>" . $row_equip['cpf'] . "</td>
                     <td class='fonte'>" . $row_equip['empresa'] . "</td>";
               echo ($row_equip['id_so'] != NULL) ? "<td class='fonte'><a href='#so" . $row_equip['id_so'] . "' title='Mais Informações' class='icon_acao' data-toggle='modal'>" . $row_equip['versao_so'] . "</a></td>" : "<td class='fonte'>---</td>";
               echo ($row_equip['id_office'] != NULL) ? "<td class='fonte'><a href='#office" . $row_equip['id_office'] . "' title='Mais Informações' class='icon_acao' data-toggle='modal'>" . $row_equip['versao_office'] . "</a></td>" : "<td class='fonte'>---</td>";
               echo ($row_equip['dominio'] == 1) ? "<td><i class='fas fa-times-circle fa-2x' style='color: red' title='Não está no domínio'></i></td>" : "<td><i class='fas fa-check-circle fa-2x' style='color: green' title='Está no domínio'></i></td>";


               //STATUS
               if ($row_equip['id_fun_status'] == 9) { //SEM EQUIPAMENTO
                  $upt = "UPDATE manager_inventario_funcionario SET status = 4 WHERE id_funcionario = " . $row_equip['id_funcionario'] . "";
                  $result_upt = $conn->query($upt);
                  echo "<script type='text/javascript'>window.location.reload()</script>";
               }

               if ($row_equip['id_fun_status'] == 8) { //Demitido
                  echo "<td>
                        <i class='fas fa-circle' style='color: black;'></i> " . $row_equip['fun_status'] . "<br />";

                  if ($row_equip['win_nota'] != NULL && $row_equip['delWin'] == 0) { //NOTA WINDOWS

                     if ($row_equip['versao_office'] != NULL) { //Possui OFFICE

                        if ($row_equip['off_nota'] != NULL && $row_equip['delOffice'] == 0) { //NOTA OFFICE
                           //sim possui, então não faz nada!
                        } else {
                           echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                        } //Fim IF possui nota office

                     } //fim IF possui office

                  } elseif ($row_equip['id_tipo_equipamento'] != 5) {
                     echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                  } //Fim IF nota windows
                  echo "</td>";
               }

               if ($row_equip['id_fun_status'] == 4) { //Ativo
                  echo "<td>
                        <i class='fas fa-circle' style='color: green;'></i> " . $row_equip['fun_status'] . "<br />";

                  if ($row_equip['win_nota'] != NULL && $row_equip['delWin'] == 0) { //NOTA WINDOWS

                     if ($row_equip['versao_office'] != NULL) { //Possui OFFICE

                        if ($row_equip['off_nota'] != NULL && $row_equip['delOffice'] == 0) { //NOTA OFFICE
                           //sim possui, então não faz nada!
                        } else {
                           echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                        } //Fim IF possui nota office

                     } //fim IF possui office

                  } elseif ($row_equip['id_tipo_equipamento'] != 5) {
                     echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                  } //Fim IF nota windows
                  echo "</td>";
               }

               if ($row_equip['id_fun_status'] == 3) { //falta termo
                  echo "<td>                 
                  <i class='fas fa-circle' style='color: #f3b37c7a;'></i> " . $row_equip['fun_status'] . "<br />";

                  if ($row_equip['win_nota'] != NULL && $row_equip['delWin'] == 0) { //NOTA WINDOWS

                     if ($row_equip['versao_office'] != NULL) { //Possui OFFICE

                        if ($row_equip['off_nota'] != NULL && $row_equip['delOffice'] == 0) { //NOTA OFFICE
                           //sim possui, então não faz nada!
                        } else {
                           echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                        } //Fim IF possui nota office

                     } //fim IF possui office

                  } elseif ($row_equip['id_tipo_equipamento'] != 5) {
                     echo "<i class='fas fa-circle' style='color: red;'></i> Falta Nota Fiscal";
                  } //Fim IF nota windows//Fim IF nota windows
                  echo "</td>";
               }


               //AÇÂO
               echo "<td class='fonte  acao'><!--AÇÃO-->
               <!--EDITAR EQUIPAMENTO-->
               <a href='equip_edit.php?id_equip=" . $row_equip['id_equipamento'] . "&id_fun=" . $row_equip['id_funcionario'] . "&tipo=" . $row_equip['id_tipo_equipamento'] . "' title='Visualizar' class='icon_acao'>
                  <i class='icon-folder-open icone_acao'></i>
               </a>";

               if (($row_equip['id_tipo_equipamento'] == 9) || ($row_equip['id_tipo_equipamento'] == 5)) { // 9 = Notebook --- 5 = Ramal
                  echo "
               <!--TERMO-->
               <a href='pdf_termo_tecnicos.php?id_funcionario=" . $row_equip['id_funcionario'] . "&tipo=" . $row_equip['id_tipo_equipamento'] . "&patrimonio=" . $row_equip['patrimonio'] . "' title='Emitir Termo' class='icon_acao' target='_blank'>
                  <i class='fas fa-file-signature icone_acao'></i>
               </a>
               <!--CHECK-LIST-->
               <a href='#modalChelist" . $row_equip['id_equipamento'] . "' title='Emitir Cheklist' class='icon_acao' data-toggle='modal'>
                  <i class='icon-th-list icone_acao' ></i>
               </a>
               <!--DESVINCULAR FUNCIONARIO-->
               <a href='#modalVigencia" . $row_equip['id_equipamento'] . "' title='Desvincular usuário' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-calendar-times icone_acao'></i>
               </a>";
               } else {
                  echo "
               <!--EXCLUIR EQUIPAMENTO-->
               <a href='#modalExcCPU" . $row_equip['id_equipamento'] . "' title='Desativar' class='icon_acao' data-toggle='modal'>
                  <i class='icon-remove icone_acao'></i>
               </a>
               <!--DESVINCULAR FUNCIONARIO-->
               <a href='#modalVigencia" . $row_equip['id_equipamento'] . "' title='Desvincular usuário' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-calendar-times icone_acao'></i>
               </a>";
               }

               echo "
            </td><!--FIM AÇÃO-->
         </tr>";

               echo    "<!--MODAL WINDOWS-->
         <div id='so" . $row_equip['id_so'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - " . $row_equip['versao_so'] . "</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> " . $row_equip['serial_so'] . "</p>
                        <p><span class='informacao'>Empresa:</span> " . $row_equip['empresa_so'] . "</p>
                        <p><span class='informacao'>Locação:</span> " . $row_equip['locacao_so'] . "</p>";
               if ($row_equip['data_nota_so'] == '9999-12-30') {
                  echo "<p><span class='informacao'>Data da nota:</span></p>";
               } else {
                  echo "<p><span class='informacao'>Data da nota:</span> " . $row_equip['data_nota_so'] . "</p>";
               }
               echo "                        
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='" . $row_equip['file_nota_so'] . "' id='nota' target='_blank'>" . $row_equip['file_nome_so'] . " </a>
                        </p>
                        <p><span class='informacao'>Modelo:</span>
                           <a href='equip_modelo.php?id_win=" . $row_equip['id_so'] . "' id='nota' target='_blank'>Imprimir</a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL OFFICE-->
         <div id='office" . $row_equip['id_office'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Informações Gerais - " . $row_equip['versao_office'] . "</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                     <div id='button_pai'>
                        <p><span class='informacao'>Serial:</span> " . $row_equip['serial_office'] . "</p>
                        <p><span class='informacao'>Empresa:</span> " . $row_equip['empresa_office'] . "</p>
                        <p><span class='informacao'>Locação:</span> " . $row_equip['locacao_office'] . "</p>";
               if ($row_equip['data_nota_office'] == '9999-12-30') {
                  echo "<p><span class='informacao'>Data da nota:</span></p>";
               } else {
                  echo "<p><span class='informacao'>Data da nota:</span> " . $row_equip['data_nota_office'] . "</p>";
               }
               echo "
                        <p><span class='informacao'>Nota Fiscal:</span>
                           <a href='" . $row_equip['file_nota_office'] . "' id='nota' target='_blank'>" . $row_equip['file_nome_office'] . " </a>
                        </p>
                        <p><span class='informacao'>Modelo:</span>
                           <a href='equip_modelof.php?id_off=" . $row_equip['id_office'] . "' id='nota' target='_blank'>Imprimir</a>
                        </p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!--MODAL EXCLUIR-->
         <div id='modalExcCPU" . $row_equip['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/atencao.png' style='width: 10%'>
                        DESATIVAR EQUIPAMENTO!
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja condenar o equipamento ?</h5>
                           <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: " . $row_equip['patrimonio'] . "</p>
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='equip_add_alter.php?inativar=1&id_equipamento=" . $row_equip['id_equipamento'] . "' class='btn btn-success' >SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <!--MODAL CHEKLIST-->
         <div id='modalChelist" . $row_equip['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/alerta.png' style='width: 10%'>
                        CHEKLIST
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja emitir para o equipamento ?</h5>";
               if ($row_equip['id_tipo_equipamento'] == 5) {
                  echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Ramal: " . $row_equip['ramal'] . "</p>";
               } else {
                  echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: " . $row_equip['patrimonio'] . "</p>";
               }
               echo "
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='pdf_cheqlist_tecnicos.php?id_fun=" . $row_equip['id_funcionario'] . "' class='btn btn-success' target='_blank'>SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <!--MODAL VIGÊNCIA-->
         <div id='modalVigencia" . $row_equip['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/atencao.png' style='width: 10%'>
                        DATA DE VIGÊNCIA
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>1 - Inserindo a data de vigência, você estará informando que o usuário <span style='color: red'>&ldquo;" . $row_equip['responsavel'] . "&rdquo;</span> não será mais responsavel pelo equipamento...</h5><br />";

               if ($row_equip['id_tipo_equipamento'] == 5) {
                  echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Ramal: " . $row_equip['ramal'] . "";
               } else {
                  echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: " . $row_equip['patrimonio'] . "</p>";
               }
               echo "
                           <h5>2 - Qual será o status que o equipamento citado acima Ficará!</h5>
                           <div class='tabbable'>
                              <div id='formulario'>
                                 <form class='form-horizontal' action='equip_update_disponivel.php' method='post' autocomplete='off' target='_blank' >
                                    <input type='text' style='display:none;' name='id_equip' value='" . $row_equip['id_equipamento'] . "' />
                                    <input type='text' style='display:none;' name='id_funcionario' value='" . $row_equip['id_funcionario'] . "' />
                                    <!--PAGINA 1-->
                                    <input type='text' style='display:none;' name='pageone' value='" . $row_equip['id_funcionario'] . "' />
                                    <div class='control-group'>
                                       <label class='control-label'>Status:</label>
                                       <div class='controls'>
                                          <select class='span2' style='margin-top: -40px; margin-left: 50px;' name='id_status' required>
                                             <option value=''>---</option>";
               $status = "SELECT id_status, nome FROM manager_dropstatusequipamento WHERE id_status in (6,10)";
               $result_status = $conn->query($status);

               while ($row_status = $result_status->fetch_assoc()) {
                  echo "<option value='" . $row_status['id_status'] . "'>" . $row_status['nome'] . "</option>";
               }
               echo "
                                          </select>
                                       </div>
                                    </div>                                                                                               
                                       <div class='modal-footer'>
                                       <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                                       <button type='submit' class='btn btn-success'>SIM</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         "; //end tabela
      } //end while
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
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>