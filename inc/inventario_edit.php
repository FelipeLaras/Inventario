<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
  header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) and ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
  header('location: ../front/error.php');
}

//sessão global para envio de id_usuario para historico 
$_SESSION['id_funcionario_historico'] = $_GET['id'];

require_once('header.php');

?>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li>
          <a href="inventario_ti.php"><i class="icon-home"></i>
            <span>Home</span>
          </a>
        </li>
        <li class="active">
          <a href="inventario.php"><i class="icon-group"></i>
            <span>Colaboradores</span>
          </a>
        </li>
        <li>
          <a href="inventario_equip.php"><i class="icon-cogs"></i>
            <span>Equipamentos</span>
          </a>
        </li>
        <li>
          <a href="relatorio_auditoria.php"><i class="icon-list-alt"></i>
            <span>Relatórios</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php

switch ($_GET['msn']) {
  case '1':
    echo "<div class='control-group'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>O equipamento editado com sucesso!!</div></div>";
    break;

  case '2':
    echo "<div class='control-group'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Anexo salvo com sucesso!!</div></div>";
    break;

  case '3':
    echo "<div class='control-group'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Anexo deletado com sucesso!!</div></div>";
    break;

  case '4':
    echo "<div class='control-group'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Data de vigencia adicionado com sucesso!!</div></div>";
    break;

  case '5':
    echo "<div class='control-group'><div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button><h4 style='color: red'>ATENÇÃO!</h4><u style='color: red;'>&ldquo;Nome do seu documento&rdquo;</u> passou o limite de <u style='color: red;'>20</u> caracteres!.</div></div>";
    break;

  case '6':
    echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Sucesso!</strong> Histórico inserido com sucesso.</div>";
    break;

  case '7':
    echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Sucesso!</strong> Histórico excluido!</div>";
    break;

  case '8':
    echo "<div class='control-group'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>O equipamento cadastrado com sucesso!!</div></div>";
    break;

  case '9':
    echo "<div class='control-group'><div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button><h4 style='color: red'>ATENÇÃO!</h4><u style='color: red;'>Anexo já existe!</u> nome desse arquivo já possui em nosso registros. Por favor renomeie!.</div></div>";
    break;
}

?>
<div class="widget ">
  <?php

  //CASO O USUARIO VENHA DO FORMULARIO DE CADASTRO
  if ($_SESSION['id_funcionario'] != NULL) {
    $sessao_id =  $_SESSION['id_funcionario']; //VEIO DO FORMULARIO INVENTARIO_ADD.PHP
    unset($_SESSION['id_funcionario']); //LIMPANDO A SESSION
    echo "
      <div class='alert alert-info'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
        <strong>ALERTA!</strong> - Funcionario já está cadastrado, segue abaixo os dados dele !!!
      </div>";
  } else {
    $sessao_id = $_GET['id']; //VEIO DA TELA INICIAL INVENTARIO.PHP
  }

  //recebendo a informação e distribuindo nos campos do formulario
  $query_contrato = "SELECT 
                            F.id_funcionario,
                            F.nome,
                            F.cpf,
                            Fu.nome AS funcao,
                            Fu.id_funcao,
                            D.nome AS departamento,
                            D.id_depart,
                            E.nome AS empresa,
                            E.id_empresa,
                            S.nome AS status,
                            S.id_status
                          FROM
                            manager_inventario_funcionario F
                                LEFT JOIN
                            manager_dropfuncao Fu ON F.funcao = Fu.id_funcao
                                LEFT JOIN
                            manager_dropdepartamento D ON F.departamento = D.id_depart
                                LEFT JOIN
                            manager_dropempresa E ON F.empresa = E.id_empresa
                                LEFT JOIN
                            manager_dropstatus S ON F.status = S.id_status
                          WHERE
                            F.deletar = 0 AND F.id_funcionario = " . $sessao_id . "";
  $resultado = mysqli_query($conn, $query_contrato);
  $row = mysqli_fetch_assoc($resultado);

  ?>
  <div class="widget-header">
    <h3>
      <i class="icon-home"></i> &nbsp;
      <a href="inventario_ti.php">
        Home
      </a>
      /
      <i class="icon-group"></i> &nbsp;
      <a href="inventario.php">
        Colaboradores
      </a>
      /
      <?= $row['nome']; ?>
    </h3>
  </div>
  <!-- /widget-header -->
  <div class="widget-content">
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <?= ($_GET['page'] != 1) ? "<li class='active'><a href='#contratos' data-toggle='tab'>Funcionário</a></li>" : "<li><a href='#contratos' data-toggle='tab'>Funcionário</a></li>"; ?>
        <li>
          <a href="#equipamento" data-toggle="tab">Equipamentos</a>
        </li>
        <li>
          <a href="#anexos" data-toggle="tab">Notas / Termos</a>
        </li>
        <?php
        if (($row['id_status'] == 8) || ($row['id_status'] == 3)) { // status demitido ou faltando termo
          echo ($_GET['page'] == 1) ? "<li class='active'><a href='#historico' data-toggle='tab'>Histórico</a>" : "<li><a href='#historico' data-toggle='tab'>Histórico</a>";
          //aplicando o active caso venha page = 1
        } //mocando o histórico
        ?>
        </li>
      </ul>
      <br>
      <div class="tab-content">
        <!--CONTRATOS-->
        <!--ALERTA ANTES DE DESATIVAR UM USUÁRIO-->
        <?php

        if ($_GET['id_equip'] != NULL) {
          echo "<div class='alert alert-block'>
                 <button type='button' class='close' data-dismiss='alert'>×</button>
                 <h4>Atenção! Este usuário possui equipamentos em seu dominio</h4>
                 Antes de desativa-lo vá na aba &ldquo;Equipamentos&rdquo; e determine uma data de <u>vigência</u> para cada um deles!...
               </div>";
        }

        echo ($_GET['page'] == 1) ? "<div class='tab-pane' id='contratos'>" : "<div class='tab-pane active' id='contratos'>";

        //aplicando o active caso venha page = 1
        ?>
        <form id="edit-profile" class="form-horizontal" action="edit_func.php" method="post">
          <!--Uma gambiarra para levar o id do contrato para a tela de update-->
          <input type="text" name="id_funcionario" style="display: none;" value="<?= $sessao_id ?>">
          <!--fim da gambiarra-->
          <div class="control-group">
            <label class="control-label">Nome completo:</label>
            <div class="controls">
              <input class="span6" name="nome" type="text" onkeyup='maiuscula(this)' required value="<?= $row['nome'] ?>" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">CPF:</label>
            <div class="controls">
              <input class="cpfcnpj span2" type="text" name="cnpj_forne" value="<?= $row['cpf']  ?>" maxlength="14" onblur="ValidarCPF(this)" required />

              <span style="display: none; color: red;" id="cpfInvalido"><i class="fas fa-times-circle"></i> CPF Invalido!</span>
              <span style="display: none; color: green" id="cpfValido"><i class="fas fa-check-circle"></i> CPF OK!</span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Função:</label>
            <div class="controls">
              <select id="t_cont" name="funcao" class="span2">
                <option value="<?= $row['id_funcao'] ?>"><?= $row['funcao']  ?></option>
                <option value="">---</option>
                <?php
                $query_funcao = "SELECT * from manager_dropfuncao WHERE deletar = 0 ORDER BY nome ASC";
                $resultado_funcao = mysqli_query($conn, $query_funcao);
                while ($row_funcao = mysqli_fetch_assoc($resultado_funcao)) {
                  echo "<option value='" . $row_funcao['id_funcao'] . "'>" . $row_funcao['nome'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Empresa / Filial:</label>
            <div class="controls">
              <select id="t_cob" name="empresa" class="span2" required>
                <option value="<?= $row['id_empresa'] ?>"><?= $row['empresa']  ?></option>
                <option value="">---</option>
                <?php
                $query_empresa = "SELECT * from manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
                $resultado_empresa = mysqli_query($conn, $query_empresa);
                while ($row_empresa = mysqli_fetch_assoc($resultado_empresa)) {
                  echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Departamento:</label>
            <div class="controls">
              <select id="setor_1" name="setor" class="span2">
                <option value="<?= $row['id_depart'] ?>"><?= $row['departamento']  ?></option>
                <option value="">---</option>
                <?php
                $query_depart = "SELECT * from manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";
                $resultado_depart = mysqli_query($conn, $query_depart);
                while ($row_depart = mysqli_fetch_assoc($resultado_depart)) {
                  echo "<option value='" . $row_depart['id_depart'] . "'>" . $row_depart['nome'] . "</option>";
                } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Status:</label>
            <div class="controls">
              <select id="setor_1" name="status" class="span2">
                <option value="<?= $row['id_status'] ?>"><?= $row['status'] ?></option>
                <option value="">---</option>
                <?php
                $query_statusFun = "SELECT * FROM manager_dropstatus WHERE id_status IN (4, 3, 8, 10) AND deletar = 0 ORDER BY nome ASC";
                $resultado_statusFun = mysqli_query($conn, $query_statusFun);
                while ($row_statusFu = mysqli_fetch_assoc($resultado_statusFun)) {
                  echo "<option value='" . $row_statusFu['id_status'] . "'>" . $row_statusFu['nome'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Inativar</label>
            <div class="controls">
              <label class="checkbox inline">
                <input type="checkbox" name="inativar">
                <?= ($_SESSION["desativar_cpf"] == 0) ? "<input type='checkbox' name='inativar'  disabled>" : "<input type='checkbox' name='inativar'>" ?>
              </label>
            </div> <!-- /controls -->
          </div>
          <div class="form-actions">
            <?php
            if (!empty($_SESSION["emitir_check_list"])) {
              echo '<a href="emitir_cheklist.php?nome=' . $row["nome"] . '&id_fun=' . $sessao_id . '" class="btn btn-warning pull-left" style="margin-left: -132px;">Check-List</a>';
            }
            ?>
            <button type="submit" id="procurar" class="btn btn-primary pull-right">Salvar</button>
          </div>
        </form>
      </div>
      <!--EQUIPAMENTOS-->
      <div class="tab-pane" id="equipamento">
        <div class="span3" style="width: 95%;">
          <div class="widget stacked widget-table action-table">
            <div class="widget-header">
              <div class="control-group">
                <div class="controls">
                  <!-- Button to trigger modal -->
                  <a href='new_equipamento.php?id_func=<?= $sessao_id; ?>' role="button" class="btn btn-info pull-left filho" title="Novo Equipamento">
                    <i class='btn-icon-only icon-plus inventario'></i>
                  </a>
                  <a href='#emitirTermo' role="button" class="btn btn-info pull-left filho" title="Emitir Termo" data-toggle="modal">
                    <i class='btn-icon-only icon-file inventario'></i>
                  </a>
                  <!-- Modal Emitir Termo-->
                  <div id='emitirTermo' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
                    <div class=' modal-header'>
                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                      <h3 id='myModalLabel' style="text-decoration: underline;font-size: 18px;">
                        <i class="fas fa-file-signature"></i>
                        <u>Termo de Responsabilidade</u>
                      </h3>
                    </div>
                    <div class='modal-body'>
                      <form id='edit-profile' class='form-horizontal' action='pdf_termo.php' enctype='multipart/form-data' method='post' name="formTermo">
                        <div id='button_pai'>
                          <h4>
                            <i class="fas fa-angle-double-right"></i>
                            Selecione os Equipamentos.
                          </h4>
                        </div>
                        <div class="control-group">
                          <div class="controls">
                            <?php
                            $termoQueryEquip = "SELECT 
                                                      MIE.id_equipamento, 
                                                      MIE.modelo, 
                                                      MIE.imei_chip, 
                                                      MIE.numero, 
                                                      MDE.nome AS tipo_equipamento
                                                  FROM
                                                      manager_inventario_equipamento MIE
                                                  LEFT JOIN
                                                    manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                                                  WHERE
                                                    MIE.id_funcionario = " . $_GET['id'] . " AND MIE.deletar = 0 AND MIE.tipo_equipamento NOT IN (8, 9, 5, 10)";

                            $resut = $conn->query($termoQueryEquip);

                            while ($termoEquip = $resut->fetch_assoc()) {

                              echo '<label class="checkbox line">
                                        <input type="checkbox" name="termoEquipamento[]" id="equipCheck' . $termoEquip['id_equipamento'] . '" onclick="liberarTermo' . $termoEquip['id_equipamento'] . '()" value="' . $termoEquip['id_equipamento'] . '">';

                              if (empty($termoEquip['imei_chip'])) {
                                echo $termoEquip['tipo_equipamento'] . " [ " . $termoEquip['numero'] . " ]";
                              } else {
                                echo $termoEquip['tipo_equipamento'] . " [ " . $termoEquip['modelo'] . " | " . $termoEquip['imei_chip'] . " ]";
                              }


                              echo '</label>
                                
                                <script type="text/javascript">
                                  function liberarTermo' . $termoEquip['id_equipamento'] . '(){

                                    if(document.getElementById("equipCheck' . $termoEquip['id_equipamento'] . '").checked == true){
                                      document.getElementById("buttonTermo").disabled = false;
                                    }
                                  }
                                </script>';
                            }
                            ?>
                          </div> <!-- /controls -->
                        </div>
                        <hr>
                        <div id='button_pai'>
                          <h4>
                            <i class="fas fa-angle-double-right"></i>
                            Observação!<i class="icon-lithe icon-question-sign" title="Essa observação irá para o Termo de Responsabilidade"></i>
                          </h4>
                        </div>
                        <div class="control-group">
                          <div class="controls">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_termo"></textarea>
                          </div>
                        </div>
                        <br>
                        <input type='text' style='display:none;' value='<?= $sessao_id; ?>' name='id_funcionario' />
                        <!--gambiarra-->
                        <div class='modal-footer'>
                          <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                          <button class='btn btn-primary' formtarget="_blank" id='buttonTermo' disabled><i class="fas fa-plus"></i> Termo</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- Modal Emitir Termo-->
                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered" style="font-size: 10px">
                <thead>
                  <tr>
                    <th>Equipamento</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>Filial</th>
                    <th>Operadora</th>
                    <th>Número</th>
                    <th>Imei</th>
                    <th>Planos</th>
                    <th>Valor</th>
                    <th>Estado</th>
                    <th>Situação</th>
                    <th>Status</th>
                    <th>Termo</th>
                    <th>ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //pesquisando os arquivos criados.
                  $query_files = "SELECT 
                                    IQ.id_equipamento,
                                    IQ.id_funcionario,
                                    IQ.patrimonio,
                                    IQ.tipo_equipamento,
                                    IQ.data_nota,
                                    IQ.modelo,
                                    IQ.operadora AS id_operadora,
                                    IQ.numero,
                                    IQ.imei_chip,
                                    IQ.valor,
                                    IQ.status AS id_status,
                                    IQ.termo,
                                    IQ.planos_voz,
                                    IQ.planos_dados,                                                      
                                    IQ.filial AS id_filial,
                                    MDES.nome AS estado,
                                    MDST.nome AS situacao,                                                      
                                    MDSE.nome AS status,                                                      
                                    MDE.nome AS filial,                                                      
                                    DO.nome AS operadora,                                                      
                                    DQ.nome AS equipamento,
                                    IQ.liberado_rh
                                    FROM
                                    manager_inventario_equipamento IQ
                                    LEFT JOIN
                                    manager_dropequipamentos DQ ON IQ.tipo_equipamento = DQ.id_equip
                                    LEFT JOIN
                                    manager_dropoperadora DO ON IQ.operadora = DO.id_operadora
                                    LEFT JOIN
                                    manager_dropstatusequipamento MDSE ON IQ.status = MDSE.id_status
                                    LEFT JOIN
                                    manager_dropempresa MDE ON MDE.id_empresa = IQ.filial
                                    LEFT JOIN
                                    manager_dropestado MDES ON IQ.estado = MDES.id
                                    LEFT JOIN
                                    manager_dropsituacao MDST ON IQ.situacao = MDST.id_situacao
                                    WHERE
                                    IQ.deletar = 0 AND 
                                    IQ.id_funcionario = " . $sessao_id . "";

                  if ($resultado_files = mysqli_query($conn, $query_files)) {
                    $cont = 0;
                    while ($row_files = mysqli_fetch_assoc($resultado_files)) {

                      $data = date("d/m/Y", strtotime($row_files['data_nota']));

                      echo "    
                                          <tr>
                                             <td>
                                                " . $row_files['equipamento'] . "
                                             </td>

                                             <td>
                                                " . $row_files['modelo'] . "
                                             </td>";
                      if ($row_files['patrimonio'] != NULL) {
                        echo "<td>" . $row_files['patrimonio'] . "</td>";
                      } else {
                        echo "<td>---</td>";
                      }
                      echo " <td>
                                                " . $row_files['filial'] . "
                                             </td>

                                             <td>
                                                " . $row_files['operadora'] . "
                                             </td>
                                             <td>
                                                " . $row_files['numero'] . "
                                             </td>

                                             <td> 
                                             " . $row_files['imei_chip'] . " 
                                             </td>
                                             <td> 
                                             " . $row_files['planos_voz'] . "," . $row_files['planos_dados'] . " 
                                             </td>
                                             <td> 
                                             " . $row_files['valor'] . " 
                                             </td>
                                             <td> 
                                             " . $row_files['estado'] . " 
                                             </td>
                                             <td> 
                                             " . $row_files['situacao'] . " 
                                             </td>";
                      if ($row_files['id_status'] == 1) { //1 = ATIVO; 2 = MANUTENÇÂO
                        echo  "<td style='color: green'> 
                                                     " . $row_files['status'] . " 
                                                     </td>";
                      } else {
                        echo  "<td style='color: orange'> 
                                                     " . $row_files['status'] . " 
                                                   </td>";
                      }

                      echo "<td>";
                      if ($row_files['termo'] == '0') { //tem termo
                        echo "<a href='javascript:;' title='Possui Termo!'><i class='icon-ok tem'></i></a>";
                      } else {
                        echo "<a href='javascript:;' title='Não Possui Termo!'><i class='icon-remove nao_tem'></i></a>";
                      } //end IF termo

                      echo "</td>
                                                  <td>";

                      if (($row_files['tipo_equipamento'] == 1) || ($row_files['tipo_equipamento'] == 2) || ($row_files['tipo_equipamento'] == 3)) {

                        if ($row_files['liberado_rh'] == 0) { //0 = não liberado
                          echo "<!--vigencia-->
                          <a href='javascript:;' class='botaoChecklist' role='button' data-toggle='modal' title='Não foi emitido o Check-List, por esse motivo não é permitido desvincular o equipamento!'>
                            <i class='fas fa-user-alt-slash' style='font-size: 15px; color: red; margin-right: 6px;'></i>
                          </a>";
                        } else { // 1 = liberado
                          echo "<!--vigencia-->
                        <a href='#myModalVi" . $row_files['id_equipamento'] . "' role='button' data-toggle='modal' title='Desvincular equipamento do funcionário'>
                          <i class='fas fa-user-minus' style='font-size: 15px; color: green;     margin-right: 6px;'></i>
                        </a>";
                        }
                        echo " <!--Termo Asssinado-->
                          <a href='#myModalanexos' role='button' data-toggle='modal' title='Anexar Termo Assinado'>
                          </a>
                          <a href='inventario_equip_edit.php?id_equip=" . $row_files['id_equipamento'] . "&tipo=" . $row_files['tipo_equipamento'] . "' role='button' title='Editar'>
                            <i class='icon-pencil' style='font-size: 15px;     margin-right: 6px;'></i>
                          </a>";
                      } else {
                        echo "Equipamento Gerenciado pelos Técnicos";
                      } // end IF mostrar botão ação

                      echo "</td>

<!-- Modal ANEXOS ADICIONAR -->
<div id='myModalanexos' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <h3 id='myModalLabel'>Adicionar Anexo</h3>
  </div>
  <div class='modal-body'>
    <!--Colocar a tabela Aqui!-->
    <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='termo_doc.php' method='post'>
      <!--Uma gambiarra para levar o id do contrato para a tela de update-->
      <input type='text' name='id_equipamento' style='display:none' value='" . $row_files['id_equipamento'] . "'>
      <input type='text' name='id_fun' style='display:none' value='" . $sessao_id . "' />
      <div class='control-group'>
        <label class='control-label required'>Tipo:</label>
        <div class='controls'>
          <select id='t_cob' name='tipo' class='span2' required>
            <option value=''>---</option>
            <option value='4'>Nota Fiscal</option>";
                      if ($row_files['termo'] == 1) {
                        echo "<option value='3'>Termo responsabilidade</option>";
                      }
                      echo "
          </select>
        </div>
      </div>   
      <div class='control-group'>
        <label class='control-label'>Selecione:</label>
        <div class='controls'>
          <input class='cpfcnpj span2' type='file' name='termo' required/>
        </div>
      </div>
      <div class='modal-footer'>
        <button class='btn' data-dismiss='modal' aria-hidden='true'>Fechar</button>
        <button class='btn btn-primary'>Salvar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Vigencia-->
<div id='myModalVi" . $row_files['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <h3 id='myModalLabel'>
      <img src='../img/atencao.png' style='width: 10%' />
      ATENCÃO!
    </h3>
  </div>
  <div class='modal-body'>

    <form id='edit-profile' class='form-horizontal' action='inventario_date.php' enctype='multipart/form-data'  method='post'>
      <div id='button_pai'>
        <h4>Ao inserir uma &#34;Data de Vigência&#34; o usuário deixa-rá de usar o equipamento.</h4>        
      </div>
      <br>      
        <div class='controls'>
        <label class='control-label'><i class='fas fa-angle-double-right'></i> Deseja atribuir a um NOVO FUNCIONÁRIO ?</label>
        <div class='controls'>
          <label class='radio inline'>
            <input type='radio' name='fun' value='0' onclick=mostrar_list" . $cont . "('listFuncionario" . $cont . "') /> Sim
          </label>
          <label class='radio inline'>
            <input type='radio' name='fun' value='1' onclick=fechar_list" . $cont . "('listFuncionario" . $cont . "') checked='checked' /> Não
          </label>
        </div>
      </div>      
      <hr />
      <div class='controls' id='listFuncionario" . $cont . "' style='display: none;'>
        <label class='control-label' for='gols1' style='margin-top: 11px;'><i class='fas fa-angle-right'></i> Escolha o Funcionário:</label>
        <select id='t_cob' name='list_fun' class='span2'>
          <option value=''>---</option>";
                      $query_fun = "SELECT id_funcionario, nome FROM manager_inventario_funcionario WHERE deletar = 0 AND empresa != '' order by nome ASC";
                      $resultado_fun = mysqli_query($conn, $query_fun);

                      while ($row_fun = mysqli_fetch_assoc($resultado_fun)) {
                        echo "<option value='" . $row_fun['id_funcionario'] . "'>" . $row_fun['nome'] . "</option>";
                      }

                      echo "</select>
        <div class='add_funcionario'>
          <input type='button' name='alert' id='alert' class='btn btn-success' value='+' onclick='abrir();' title='adicionar funcionário'>
        </div>  
      </div>
      <div class='controls'>
        <label class='control-label'><i class='fas fa-angle-double-right'></i> Mais algum equipamento ?</label>
        <div class='controls'>
          <label class='radio inline'>
            <input type='radio' name='equip' value='0' onclick=mostrar_list" . $cont . "('list" . $cont . "') /> Sim
          </label>
          <label class='radio inline'>
            <input type='radio' name='equip' value='1' onclick=fechar_list" . $cont . "('list" . $cont . "') checked='checked' /> Não
          </label>
        </div>

        <!--LISTA DOS EQUIPAMENTOS-->
        <ul class='ul_equip' id='list" . $cont . "' style='display: none;'>";
                      $list_equip = "SELECT  
                        MIE.id_equipamento,
                        MDE.nome AS tipo_equipamento,
                        MIE.tipo_equipamento AS id_tipo,
                        MIE.modelo,
                        MIE.numero
                      FROM 
                        manager_inventario_equipamento MIE
                      LEFT JOIN
                        manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                      WHERE id_funcionario = " . $_GET['id'] . " AND
                      MIE.tipo_equipamento NOT IN (9, 2, 10, 8)";
                      $result_list = mysqli_query($conn, $list_equip);

                      while ($linha_list = mysqli_fetch_assoc($result_list)) {
                        if ($linha_list['id_tipo'] == 3) { //chip
                          echo "<li class='li_equip'><input type='checkbox' name='list_equip[]' value='" . $linha_list['id_equipamento'] . "' /> | CHIP - " . $linha_list['numero'] . "</li>";
                        } else {
                          echo "<li class='li_equip'>
                    <input type='checkbox' name='list_equip[]' value='" . $linha_list['id_equipamento'] . "' /> | " . $linha_list['tipo_equipamento'] . " - " . $linha_list['modelo'] . "
                  </li>";
                        } //end IF chip          
                      } //end WHILE lista equipamentos

                      echo "</ul>
        <!--FIM LISTA-->         
        <hr />     
      <div class='control' id='status'>
        <label class='control-label required' for='gols1'><i class='fas fa-angle-double-right'></i> Qual status ficará o equipamento? </label>
        <select id='t_cob' name='status_equip' class='span2' required>
          <option value='" . $row_files['id_status'] . "'>" . $row_files['status'] . "</option>
          <option value=''></option>";

                      $query_status = "SELECT * FROM manager_dropstatusequipamento WHERE deletar = 0 order by nome";
                      $resultado_status = mysqli_query($conn, $query_status);

                      while ($row_status = mysqli_fetch_assoc($resultado_status)) {
                        echo "<option value='" . $row_status['id_status'] . "'>" . $row_status['nome'] . "</option>";
                      }

                      echo "</select>
      </div>
      
      <hr />      

      <div class='controls'>
        <label class='control-label required' for='gols1'><i class='fas fa-angle-double-right'></i> Filial:</label>
        <select id='t_cob' name='filial_equip' class='span2' required>
          <option value='" . $row_files['id_filial'] . "'>" . $row_files['filial'] . "</option>
          <option value=''></option>";

                      $query_empresa_equip = "SELECT * FROM manager_dropempresa order by nome";
                      $resultado_empresa_equip = mysqli_query($conn, $query_empresa_equip);

                      while ($row_empresa_equip = mysqli_fetch_assoc($resultado_empresa_equip)) {
                        echo "<option value='" . $row_empresa_equip['id_empresa'] . "'>" . $row_empresa_equip['nome'] . "</option>";
                      }

                      echo "</select>
      </div>
      <hr />
      <div class='control-group'>
        <div class='controls'>
          <label for='inputState'><i class='fas fa-angle-double-right'></i> Check-List:</label>
          <input class='cpfcnpj span2 termo' type='file' name='checklist' />
          <input type='text' name='tipo' value='5' style='display: none' />
        </div>
      </div>
      <hr />
      <div class='form-group col-md-6'>
        <label for='inputState'><i class='fas fa-angle-double-right'></i> Qual é o motivo ?</label>
        <textarea class='form-control' id='exampleFormControlTextarea1' rows='3' name='obs' required></textarea>
      </div>
      <input type='text' style='display:none;' value='" . $row_files['id_equipamento'] . "' name='id_equipamento' /><!--gambiarra-->
      <input type='text' style='display:none;' value='" . $sessao_id . "' name='id_funcionario' /><!--gambiarra-->
      <div class='modal-footer'>
        <span style='color:red;font-size:9px;'>Obs: Data será colocada automanticante = " . date('d/m/Y') . "</span>
        <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
        <button class='btn btn-primary'>Sim</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Termo-->
<div id='myModalTermo" . $row_files['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <h3 id='myModalLabel'>Termo Assinado</h3>
  </div>
  <div class='modal-body'>
    <div class='tab-content'>
      <div class='tab-pane active' id='contratos'>
        <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='termo_doc.php' method='post'>
        <!--gambiarra pegar id funcionario id equipamento-->
        <input type='text' value='" . $row_files['id_equipamento'] . "' name='id_equipamento' style='display:none;'/>
        <input type='text' value='" . $sessao_id . "' name='id_fun' style='display:none;'/>
        <!--gambiarra pegar id funcionario id equipamento-->
          <div class='control-group'>
            <div class='controls'>
              <input class='cpfcnpj span2 termo' type='file' name='termo' required/>
            </div>
          </div>                                                        
          <div class='modal-footer'>
            <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
            <button class='btn btn-primary'>Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Observação-->
<div id='myModalOBS" . $row_files['id_equipamento'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <h3 id='myModalLabel'>
        Observações      
    </h3>
  </div>
  <div class='modal-body'>
    

    <div class='control-group'>
      <div class='controls'>
        <div class='accordion' id='accordion2'>";
                      $add_obs = 0;
                      $query_OBS = "SELECT MIO.obs, MIO.data_criacao, MDSE.nome AS status
                        FROM manager_inventario_obs MIO
                        LEFT JOIN manager_dropstatusequipamento MDSE ON MIO.id_status = MDSE.id_status
                        where MIO.id_equipamento = " . $row_files['id_equipamento'] . " AND MIO.deletar = 0 order by MIO.data_criacao DESC";

                      $resultado_OBS = mysqli_query($conn, $query_OBS);

                      while ($row_OBS = mysqli_fetch_assoc($resultado_OBS)) {

                        $date_obs = date('d/m/Y H:i:s', strtotime($row_OBS['data_criacao']));

                        echo "<div class='accordion-group'>
             <label class='control-label'><b>Status:</b> " . $row_OBS['status'] . "</label>
            <div class='accordion-heading'>
              <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse" . $add_obs . $row_files['id_equipamento'] . "'>
                <b>Data da postagem:</b> " . $date_obs . "
              </a>
            </div>
            <div id='collapse" . $add_obs . $row_files['id_equipamento'] . "' class='accordion-body collapse' style='height: 0px;'>
              <div class='accordion-inner'>
                 " . $row_OBS['obs'] . "
              </div>
            </div>
          </div></br>";
                        $add_obs++;
                      }
                      echo "
        </div>
      </div> 
    </div>
  </div>
</div>";

                      echo "<script>
      function mostrar_list" . $cont . "(id) {
          document.getElementById(id).style.display = 'block';
          if (id == 'listFuncionario') {
              document.getElementById('status').style.display = 'none';
          }
      }

      function fechar_list" . $cont . "(id) {
          document.getElementById(id).style.display = 'none';
          if (id == 'listFuncionario') {
              document.getElementById('status').style.display = 'block';
          }
      }
      </script>";

                      $cont++;
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /widget-content -->
          </div>
          <!-- /widget -->
        </div>
      </div>
      <!--ANEXOS-->
      <div class="tab-pane" id="anexos">
        <div class="span3" style="width: 1000px;">
          <div class="widget stacked widget-table action-table">
            <div class="widget-header">
              <div class="control-group">
                <div class="controls">
                  <!-- Button to trigger modal -->
                  <a href="#editar" role="button" class="btn btn-info pull-left filho" data-toggle="modal">Adicionar Nota Fiscal / Termo</a>
                </div>
                <!-- Modal ANEXOS ADICIONAR -->
                <div id='editar' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h3 id='myModalLabel'>Adicionar Anexo</h3>
                  </div>
                  <div class='modal-body'>
                    <!--Colocar a tabela Aqui!-->
                    <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='termo_doc.php' method='post'>
                      <input type='text' name='id_fun' style='display:none' value='<?= $_GET['id']; ?>' />
                      <div class='control-group'>
                        <label class='control-label'>Tipo:</label>
                        <div class='controls'>
                          <select id='t_cob' name='tipo' class='span2'>
                            <option value=''>---</option>
                            <option value='4'>Nota Fiscal</option>";
                            if($row_filess['termo'] == 1){
                            echo "<option value='3'>Termo responsabilidade</option>";
                            }
                            echo "
                          </select>
                        </div>
                      </div>
                      <div class='control-group'>
                        <label class='control-label'>Equipamento:</label>
                        <div class='controls'>
                          <select id='t_cob' name='id_equipamento' class='span2'>
                            <option value=''>---</option>
                            <?php
                            $mostra_equip = "SELECT id_equipamento, modelo, numero, tipo_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = " . $_GET['id'] . "";
                            $result_equip = mysqli_query($conn, $mostra_equip);
                            while ($row_mostrar = mysqli_fetch_assoc($result_equip)) {

                              if ($row_mostrar['tipo_equipamento'] == 3) {
                                echo "<option value='" . $row_mostrar['id_equipamento'] . "'>Chip - " . $row_mostrar['numero'] . "</option>";
                              } else {
                                echo "
                                                                <option value='" . $row_mostrar['id_equipamento'] . "'>" . $row_mostrar['modelo'] . "</option>
                                                              ";
                              } //end IF equipamento
                            } //end WHile equipamento
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class='control-group'>
                        <label class='control-label'>Selecione:</label>
                        <div class='controls'>
                          <input class='cpfcnpj span2' type='file' name='termo' required />
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button class='btn' data-dismiss='modal' aria-hidden='true'>Fechar</button>
                        <button class='btn btn-primary'>Salvar</button>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th>Equipamento</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>IMEI</th>
                    <th>Data</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //pesquisando os arquivos criados.
                  $query_files = "SELECT
                                      MIA.id_anexo,
                                      MIE.id_equipamento,
                                      MIA.nome,
                                      MDE.nome AS tipo_equipamento,
                                      MIE.modelo,
                                      MIE.patrimonio,
                                      MIE.imei_chip,
                                      MIA.data_criacao,
                                      MIA.caminho,
                                      MIA.tipo
                                  FROM
                                    manager_inventario_anexo MIA
                                  LEFT JOIN
                                    manager_inventario_equipamento MIE ON MIA.id_equipamento = MIE.id_equipamento
                                  LEFT JOIN
                                    manager_inventario_funcionario MIF ON MIA.id_funcionario = MIF.id_funcionario
                                  LEFT JOIN
                                    manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                                  WHERE
                                    MIA.id_funcionario = " . $_GET['id'] . " AND 
                                    MIA.deletar = 0";

                  if ($resultado_files = mysqli_query($conn, $query_files)) {
                    while ($row_filess = mysqli_fetch_assoc($resultado_files)) {

                      echo "<tr>
                                             <td>
                                                <a href='" . $row_filess['caminho'] . "' target='_blank'>" . $row_filess['nome'] . "</a>
                                             </td>
                                             <td>";
                      if ($row_filess['tipo'] == 3) {
                        echo "TERMO RESPONSABILIDADE";
                      }
                      if ($row_filess['tipo'] == 4) {
                        echo "NOTA FISCAL";
                      }
                      if ($row_filess['tipo'] == 5) {
                        echo "CHECK-LIST";
                      }
                      echo "
                                             </td>";

                      if ($row_filess['tipo_equipamento'] != NULL) {
                        echo "<td>
                                                        " . $row_filess['tipo_equipamento'] . "
                                                      </td>";
                      } else {
                        echo "<td>---</td>";
                      }

                      if ($row_filess['modelo'] != NULL) {
                        echo "<td>
                                                        " . $row_filess['modelo'] . "
                                                      </td>";
                      } else {
                        echo "<td>---</td>";
                      }

                      if ($row_filess['patrimonio'] != NULL) {
                        echo "<td>
                                                        " . $row_filess['patrimonio'] . "
                                                      </td>";
                      } else {
                        echo "<td>---</td>";
                      }

                      echo "      <td>
                                                " . $row_filess['imei_chip'] . "
                                             </td>
                                             <td>
                                                " . $row_filess['data_criacao'] . "
                                             </td>
                                             <td>
                                              <a href='#myModalDel" . $row_filess['id_anexo'] . "' role='button' data-toggle='modal' title='Excluir anexo'>
                                                <i class='btn-icon-only icon-trash' style='color: red;'></i>
                                              </a>
                                             </td>
                                           </tr>
                                           
                                            <!-- Modal EXCLUIR ANEXO-->
                                            <div id='myModalDel" . $row_filess['id_anexo'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                                              <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                <h3 id='myModalLabel'>
                                                  <img src='../img/atencao.png' style='width: 10%' />
                                                  ATENCÃO - EXCLUIR ANEXO!
                                                </h3>
                                              </div>
                                              <div class='modal-body'>
                                                <form id='edit-profile' class='form-horizontal' action='inventario_date.php' method='post'>
                                                  <div id='button_pai'>
                                                    <h4>Deseja exluir o anexo ?<p class='linha'>" . $row_filess['nome'] . "</p></h4>        
                                                  </div>
                                                  <br />
                                                  <input type='text' style='display:none;' value='" . $row_filess['id_anexo'] . "' name='id_anexo' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='" . $row_filess['id_equipamento'] . "' name='id_equipamento' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='" . $_GET['id'] . "' name='id_funcionario' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='1' name='drop' /><!--gambiarra-->
                                                  <div class='modal-footer'>
                                                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                    <button class='btn btn-primary'>Sim</button>
                                                  </div>
                                                </form>
                                              </div>
                                            </div>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /widget-content -->
          </div>
          <!-- /widget -->
        </div>
      </div>
      <!--Historico-->
      <?php
      if ($_GET['page'] == 1) {
        echo "<div class='tab-pane active' id='historico'>";
      } else {
        echo "<div class='tab-pane' id='historico'>";
      } //aplicando o active caso venha page = 1
      ?>
      <div class="control-group">
        <div class="control">
          <a href="#modalHistorico" role="button" class="btn btn-info filho" data-toggle="modal" style="float: none;margin-left: 2px;margin-bottom: 10px;">Adicionar Novo Histórico</a>
        </div>
        <!--modal histórico-->
        <div id="modalHistorico" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Insira seu histórico</h3>
          </div>
          <form id="adc-historico" class="form-horizontal" action="invent_historico.php" method="post">
            <div class="modal-body">
              <div class="control-group">
                <label class="control-label required">CONTEÚDO:</label>
                <textarea name="msg_hist" class="form-control" rows="4"></textarea>
              </div>
            </div>
            <input name="id_funcionario" style="display:none" value="<?= $_GET['id']; ?>" />
            <input name="status_funcionario" style="display:none" value="<?= $row['id_status']; ?>" />
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
              <button class="btn btn-primary">Salvar informações</button>
            </div>
          </form>
        </div>
        <!--fim modal-->
        <!--Inicio da tabela-->
        <div id='tabelaHistorico'>
          <table class="table table-striped table-bordered" style="width:1000px">
            <thead>
              <tr>
                <th>ID</th>
                <th>STATUS</th>
                <th>USUÁRIO</th>
                <th>MENSAGEM</th>
                <th>DATA DO HISTÓRICO</th>
                <th>AÇÃO</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tableHistorico = "SELECT 
                                                  MIH.id,
                                                  MIH.historico,
                                                  MIH.id_usuario,
                                                  MP.profile_name,
                                                  MIH.data_historico,
                                                  MDS.nome AS status,
                                                  MIH.status_funcionario AS id_status
                                              FROM
                                                  manager_invent_historico AS MIH
                                              LEFT JOIN
                                                  manager_inventario_funcionario AS MIF ON MIH.id_funcionario = MIF.id_funcionario  
                                              LEFT JOIN 
                                                  manager_profile AS MP ON MIH.id_usuario = MP.id_profile
                                              LEFT JOIN
                                                  manager_dropstatus MDS ON MIH.status_funcionario = MDS.id_status
                                              WHERE
                                                  MIH.deletado = 0 AND 
                                                  MIH.id_funcionario = " . $_GET['id'] . " ORDER BY MIH.id DESC";
              $result_table = mysqli_query($conn, $tableHistorico);
              while ($rowtableHistorico = mysqli_fetch_assoc($result_table)) {

                echo "
                                <tr>
                                  <th scope='row'>" . $rowtableHistorico['id'] . "</th>
                                  <td style='font-size: 9px;width: 8%;'>" . $rowtableHistorico['status'] . "</td>
                                  <td>" . $rowtableHistorico['profile_name'] . "</td>
                                  <td>" . $rowtableHistorico['historico'] . "</td>
                                  <td>" . $rowtableHistorico['data_historico'] . "</td>";

                if (($rowtableHistorico['id_usuario'] == $_SESSION['id']) || ($_SESSION['editar_historico'] == 1)) {
                  echo
                  "<td>
                                      <a href='#modalEditHistorico" . $rowtableHistorico['id'] . "' role='button' data-toggle='modal' title='Editar histórico'>
                                        <i class='icon-large icon-edit' style='color: blue'></i></i>
                                      <a href='#modalDelHistorico" . $rowtableHistorico['id'] . "' role='button' data-toggle='modal' title='Excluir histórico'>    
                                        <i class='btn-icon-only icon-trash' style='color: black'></i>
                                      </a>
                                    </td>";
                } else {
                  echo "<td></td>";
                }
                echo "</tr>



                                <!--modal editar histórico-->     
                              <div id='modalEditHistorico" . $rowtableHistorico['id'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                                <div class='modal-header'>                                
                                  <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>x</button>
                                    <h3 id='myModalLabel'>Edite seu histórico</h3>
                                </div>
                                <div class='modal-body'>                                
                                    <form id='edit-historico' class='form-horizontal' action='invent_historico.php' method='POST'>
                                      <div class='control-group'>
                                        <label class='control-label required'>CONTEÚDO:</label>
                                          <textarea class='form-control' rows='4' name='edit_form'>" . $rowtableHistorico['historico'] . "</textarea>     
                                    </div>
                                  </div>
                                  <input name='id_historico' style='display:none' value='" . $rowtableHistorico['id'] . "'></input>
                                  <input name='status_funcionario' style='display:none' value='" . $rowtableHistorico['id_status'] . "'></input>
                                  <div class='modal-footer'>
                                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Fechar</button>
                                    <button class='btn btn-primary'>Salvar informações</button>
                                  </div>
                                  </form>
                                </div>    
                              <!--fim modal editar histórico-->
                              <!--modal excluir histórico-->
                              <div id='modalDelHistorico" . $rowtableHistorico['id'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                                <div class='modal-header'>
                                  <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                    <h3 id='myModalLabel'>
                                      <img src='../img/atencao.png' style='width: 10%'/>
                                          ATENCÃO - EXCLUIR HISTÓRICO!
                                    </h3>
                                </div>
                                <div class='modal-body'>
                                  <form id='edit-profile' class='form-horizontal' action='inventario_date.php' method='post'>
                                    <div id='button_pai'>
                                      <h4>Deseja exluir o histórico?</h4>        
                                    </div>
                                    <br />
                                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                    <a href='invent_historico.php?dell=1&id=" . $rowtableHistorico['id'] . "' class='btn btn-primary'>Sim</a>                            
                                  </form>
                                </div>
                              </div>   
                            <!--fim modal excluir histórico-->
                            ";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--FIM HISTORICO-->
  </div>
</div>
</div>
</div>

<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>

<!--Paginação entre filho arquivo e pai-->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<!--MODAIS-->

</html>

<!--MOSTRAR CAMPO ICONE-->
<script>
  function ValidarCPF(cpf) {

    cpf = cpf.value.replace(".", "")
    cpf = cpf.replace(".", "")
    cpf = cpf.replace("-", "")

    var Soma;
    var Resto;
    Soma = 0;

    var strCPF = cpf;

    if (strCPF == "00000000000") {
      var retorno = false;
    }

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))) {
      var retorno = false;
    }

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))) {
      var retorno = false;
    } else {
      var retorno = true;
    }

    if (retorno == true) {

      document.getElementById("cpfValido").style.display = "block";

      document.getElementById("cpfInvalido").style.display = "none";

      document.getElementById("procurar").disabled = false;

    } else {

      document.getElementById("cpfValido").style.display = "none";

      document.getElementById("cpfInvalido").style.display = "block";

      document.getElementById("procurar").disabled = true;
    }
  }
</script>
<script src="../js/cnpj.js"></script>

<script language="javascript">
  function abrir() {
    window.open("add_funcionario.php", "mywindow", "width=500,height=600");
  }
</script>

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

<?= $conn->close() ?>