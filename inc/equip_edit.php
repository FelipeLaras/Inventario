<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
require_once('../query/query_dropdowns.php');
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
   header('location: ../index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   header('location: ../error.php');
}
require_once('header.php');

?>
<style>
   #myInput2autocomplete-list {
      margin-left: -72%;
   }

   #myInput1autocomplete-list {
      margin-left: -134%;
   }
</style>
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li>
               <a href="tecnicos_ti.php"><i class="icon-home"></i>
                  <span>Home</span>
               </a>
            </li>
            <li class="active">
               <a href="equip.php"><i class="icon-table"></i>
                  <span>Inventário</span>
               </a>
            </li>
            <li>
               <a href="google.php"><i class="icon-search"></i>
                  <span>Google T.I</span>
               </a>
            </li>                                           
            <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
         </ul>
      </div>
   </div>
</div>
<div class="widget ">
   <?php

   /*---------------------------  FUNCIONÁRIO ---------------------------*/
   $query_funcionario = "SELECT 
                              MIF.id_funcionario,
                              MIF.nome,
                              MIF.cpf,
                              MIF.funcao AS id_funcao,
                              MDF.nome AS funcao,
                              MIF.empresa AS id_empresa,
                              MDE.nome AS empresa,
                              MIF.departamento AS id_departamento,
                              MDD.nome AS departamento
                           FROM 
                              manager_inventario_funcionario MIF
                           LEFT JOIN
                              manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
                           LEFT JOIN
                              manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
                           LEFT JOIN
                              manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
                           WHERE
                              MIF.id_funcionario = " . $_GET['id_fun'] . "";

   $resultado_fun = mysqli_query($conn, $query_funcionario);
   $funcionario = mysqli_fetch_assoc($resultado_fun);

   /*---------------------------  EQUIPAMENTO  ---------------------------*/

   $query_equipamento = "SELECT 
                           MIE.numero,
                           MIE.tipo_equipamento,
                           MIE.patrimonio,
                           MIE.filial AS id_empresa,
                           MDE.nome AS empresa,
                           MIE.locacao AS id_locacao,
                           MDL.nome AS locacao,
                           MIE.departamento AS id_departamento,
                           MDD.nome AS departamento,
                           MIE.hostname,
                           MIE.ip,
                           MIE.modelo,
                           MIE.processador,
                           MIE.hd,
                           MIE.memoria,
                           MIE.situacao AS id_situacao,
                           MDS.nome AS situacao,
                           MIE.serialnumber
                        FROM
                           manager_inventario_equipamento MIE
                        LEFT JOIN
                           manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                        LEFT JOIN
                           manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
                        LEFT JOIN
                           manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                        LEFT JOIN
                           manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
                        WHERE
                           MIE.id_equipamento =" . $_GET['id_equip'] . "";
   $result_equip = mysqli_query($conn, $query_equipamento);
   $equipamento = mysqli_fetch_assoc($result_equip);

   /*---------------------------  WINDOWS  ---------------------------*/

   $query_windows = "SELECT 
                        MSO.id,
                        MSO.versao AS id_versao,
                        MDSO.nome AS versao,
                        MSO.serial,
                        MSO.fornecedor    
                     FROM
                        manager_sistema_operacional MSO
                     LEFT JOIN
                     manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                     WHERE
                     MSO.id_equipamento = " . $_GET['id_equip'] . "";
   $result_windows = mysqli_query($conn, $query_windows);
   $windows = mysqli_fetch_assoc($result_windows);

   /*---------------------------  OFFICE  ---------------------------*/

   $query_office = "SELECT 
                     MOF.id,
                     MOF.versao AS id_versao,
                     MDOF.nome AS versao,
                     MOF.serial,
                     MOF.fornecedor,
                     MOF.empresa AS id_empresa,
                     MDE.nome AS empresa,
                     MOF.locacao AS id_locacao,
                     MDL.nome AS locacao    
                  FROM
                     manager_office MOF
                  LEFT JOIN
                     manager_dropoffice MDOF ON MOF.versao = MDOF.id
                  LEFT JOIN
                     manager_dropempresa MDE ON MOF.empresa = MDE.id_empresa
                  LEFT JOIN
                     manager_droplocacao MDL ON MOF.locacao = MDL.id_empresa
                  WHERE
                  MOF.id_equipamento = " . $_GET['id_equip'] . "";
   $result_office = mysqli_query($conn, $query_office);
   $office = mysqli_fetch_assoc($result_office);
   ?>
   <div class="widget-header">
      <h3>
         <i class="icon-lithe icon-home"></i>&nbsp;
         <a href="manager.php">Home</a>
         /
         <i class="icon-lithe icon-table"></i>&nbsp;
         <a href="equip.php">Inventário</a>
         /
         <i class="icon-lithe fas fa-laptop"></i>&nbsp;&nbsp;
         <?php
         if ($equipamento['tipo_equipamento'] == 5) {
            echo "<a href='javascript:'>" . $equipamento['numero'] . "</a>";
         } else {
            echo "<a href='javascript:'>" . $equipamento['patrimonio'] . "</a>";
         }
         ?>
      </h3>
   </div>


   <!--ALERTAS DE ERROS-->

   <?= ($_GET['erro'] == 1) ? '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></button><h4><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">ATENÇÃO!!!!</font></font></h4><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Dados do funcionarios estão incompletos</font></font></div>' : '' ?>

   <!--FIM ALERTAS DE ERROS-->

   <!-- /widget-header -->
   <div class="widget-content">
      <div class="tabbable">
         <ul class="nav nav-tabs">
            <li class="active">
               <a href="#contratos" data-toggle="tab">Funcionário / Equipamento</a>
            </li>
            <li>
               <a href="#anexos" data-toggle="tab">Notas / Termos</a>
            </li>
         </ul>
         <?php
         switch ($_GET['msn']) {
            case '1':
               echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Dados da nota alterado com sucesso!.</div>";
               break;

            case '2':
               echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Office cadastrado com sucesso!.</div>";
               break;

            case '3':
               echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Office transferido com sucesso!.</div>";
               break;
         }
         ?>
         <div class="tab-content">
            <!--Equipamento-->
            <div class="tab-pane active" id="contratos">
               <form id="formPrincipal" class="form-horizontal" action="equip_add_alter.php" method="post">
                  <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                  <input type="text" name="id_funcionario" style="display: none;" value="<?= $_GET['id_fun']; ?>">
                  <!--fim da gambiarra-->
                  <div class="control-group">
                     <h3 style="color: red;">
                        <font style="vertical-align: inherit;">Funcionário Responsável:</font>
                     </h3>
                  </div>
                  <div class="control-group">
                     <label class="control-label">Nome completo:</label>
                     <div class="controls">
                        <input class="span6" name="nome" type="text" onkeyup='maiuscula(this)' value="<?= $funcionario['nome'] ?>" <?= $_SESSION['editar_cadastroFuncionario'] == 1 ?: "readonly='readonly'" ?> required>
                     </div>
                  </div>
                  <div class="control-group">
                     <label class="control-label">CPF:</label>
                     <div class="controls">
                        <input class="cpfcnpj span2" type="text" name="cnpj_forne" value="<?= $funcionario['cpf']  ?>" <?= $_SESSION['editar_cadastroFuncionario'] == 1 ?: "readonly='readonly'" ?> required>
                     </div>
                  </div>
                  <div class="control-group">
                     <label class="control-label">Função:</label>
                     <div class="controls">
                        <select id="t_cont" name="funcao" class="span2" style="width: 25%" <?= $_SESSION['editar_cadastroFuncionario'] == 1 ?: "readonly='readonly'" ?> required>
                           <option value="<?= $funcionario['id_funcao'] ?>">
                              <?= $funcionario['funcao']  ?>
                           </option>
                           <option value=''>---</option>
                           <?php
                           while ($row_funcao = $resultado_funcao->fetch_assoc()) {
                              echo "<option value='" . $row_funcao['id_funcao'] . "'>" . $row_funcao['nome'] . "</option>";
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="control-group">
                     <label class="control-label">Empresa / Filial:</label>
                     <div class="controls">
                        <select id="t_cob" name="empresa" class="span2" style="width: 25%" <?= $_SESSION['editar_cadastroFuncionario'] == 1 ?: "readonly='readonly'" ?> required>
                           <option value="<?= $funcionario['id_empresa'] ?>">
                              <?= $funcionario['empresa']  ?>
                           </option>
                           <option value=''>---</option>
                           <?php
                           while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                              echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="control-group">
                     <label class="control-label">Departamento:</label>
                     <div class="controls">
                        <select id="setor_1" name="setor" class="span2" style="width: 23%" <?= $_SESSION['editar_cadastroFuncionario'] == 1 ?: "readonly='readonly'" ?> required>
                           <option value="<?= $funcionario['id_departamento'] ?>">
                              <?= $funcionario['departamento']; ?>
                           </option>
                           <option value=''>---</option>
                           <?php
                           while ($row_depart = $resultado_depart->fetch_assoc()) {
                              echo "<option value='" . $row_depart['id_depart'] . "'>" . $row_depart['nome'] . "</option>";
                           } ?>
                        </select>
                     </div>
                  </div>

                  <?php

                  if ($equipamento['tipo_equipamento'] == 8) { //desktop

                     echo "
                    <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Desktop (CPU):</font>
                        </h3>
                    </div>
                    <input value='" . $equipamento['tipo_equipamento'] . "' style='display:none;' name='tipo_equipamento'/>
                    <input value='" . $_GET['id_equip'] . "' style='display:none;' name='id_equipamento'/>
                    <div class='control-group'>
                        <label class='control-label'>Patrimônio:</label>
                        <div class='controls'>
                          <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_cpu' type='text' value='" . $equipamento['patrimonio'] . "'>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Empresa:
                           <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='empresa_cpu' class='span2' style='width: 25%'>
                              <option value='" . $equipamento['id_empresa'] . "'>" . $equipamento['empresa'] . "</option>
                              <option>---</option>";
                                 //empresa
                                 $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
                                 $resultado_empresa = $conn -> query($query_empresa);
                                 while ($row_empresaDesk = $resultado_empresa -> fetch_assoc()) {
                                    echo "<option value='" . $row_empresaDesk['id_empresa'] . "'>" . $row_empresaDesk['nome'] . "</option>";
                                 }
                     echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Locação:
                           <i class='icon-lithe icon-question-sign' title='Onde se encontra o equipamento!'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='locacao_cpu' class='span2' style='width: 25%'>
                              <option value='" . $equipamento['id_locacao'] . "'>" . $equipamento['locacao'] . "</option> 
                              <option>---</option>";
                     while ($row_locacao = $resultado_locacao -> fetch_assoc()) {
                        echo "<option value='" . $row_locacao['id_empresa'] . "'>" . $row_locacao['nome'] . "</option>";
                     }
                     echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Departamento:</label>
                        <div class='controls'>
                           <select id='t_cob' name='depart_cpu' class='span2' style='width: 23%'>
                              <option value='" . $equipamento['id_departamento'] . "'>" . $equipamento['departamento'] . "</option>
                              <option>---</option>";

                              //departamento
                              $query_depart = "SELECT * FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";
                              $resultado_depart = $conn -> query($query_depart);
                        while ($row_departamento = $resultado_depart->fetch_assoc()) {
                        echo "<option value='" . $row_departamento['id_depart'] . "'>" . $row_departamento['nome'] . "</option>";
                     }
                     echo "</select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Nome do computador:</label>
                        <div class='controls'>
                           <input class='span2' name='nome_cpu' type='text' value='" . $equipamento['hostname'] . "'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Endereço IP:</label>
                        <div class='controls'>
                           <input class='span2' name='ip_cpu' type='text' value='" . $equipamento['ip'] . "'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Modelo:</label>
                        <div class='controls'>
                           <input class='span2' name='modelo_cpu' type='text' value='" . $equipamento['modelo'] . "'>                            
                        </div>
                     </div>  
                     <div class='control-group'>
                        <label class='control-label'>Processador:</label>
                        <div class='controls'>
                           <input class='span3' name='processador_cpu' type='text' value='" . $equipamento['processador'] . "'>                            
                        </div>
                     </div>   
                     <div class='control-group'>
                        <label class='control-label'>Hard Disk:</label>
                        <div class='controls'>
                           <input class='span2' name='hd_cpu' type='text' value='" . $equipamento['hd'] . "'>                            
                        </div>
                     </div> 
                     <div class='control-group'>
                        <label class='control-label'>Memória:</label>
                        <div class='controls'>
                           <input class='span1' name='memoria_cpu' type='text' value='" . $equipamento['memoria'] . "'>                            
                        </div>
                     </div>
                      <div class='control-group'>
                        <label class='control-label'>Situacao:</label>
                        <div class='controls'>
                           <select id='setor_1' name='situacao_cpu' class='span1' style='width: 10%'>
                              <option value='" . $equipamento['id_situacao'] . "'>" . $equipamento['situacao'] . "</option>
                              <option>---</option>";
                     while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                        echo "<option value='" . $row_situacao['id_situacao'] . "'>" . $row_situacao['nome'] . "</option>";
                     }
                     echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Número de série:</label>
                        <div class='controls'>
                           <input class='span3' name='serie_cpu' type='text' value='" . $equipamento['serialnumber'] . "'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Sistema operacional:</font>
                        </h3>
                    </div>
                    <div class='control-group'>
                        <label class='control-label'>Versão:</label>
                        <div class='controls'>
                        <select id='t_cob' name='so_cpu' class='span4'>
                              <option value='" . $windows['id_versao'] . "'>" . $windows['versao'] . "</option>
                        </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Chave Key:</label>
                        <div class='controls'>
                           <input class='span3' name='serial_so_cpu' type='text' value='" . $windows['serial'] . "'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Fornecedor:</label>
                        <div class='controls autocomplete'>
                           <input class='span5' id='myInput2' name='fornecedor_so_cpu' type='text' value='" . $windows['fornecedor'] . "' style='margin-left: -155px;'>                            
                        </div>
                     </div>
                   ";

                     if ($office['id'] != NULL) {
                        echo "
                           <div class='control-group'>
                                 <h3 style='color: red;'>
                                    <font style='vertical-align: inherit;'>Office:</font>
                                 </h3>
                           </div>
                           <input value='" . $office['id'] . "' style='display:none' name='id_office' />
                           <div class='control-group'>
                              <label class='control-label'>Office:</label>
                              <div class='controls'>
                              <select id='t_cob' name='tipo_office' class='span4'>
                                    <option value='" . $office['id_versao'] . "'>" . $office['versao'] . "</option>
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Fornecedor:</label>
                              <div class='controls autocomplete'>
                                 <input class='span5' id='myInput1' name='fornecedor_office_cpu' type='text' value='" . $office['fornecedor'] . "' style='margin-left: -155px'>                            
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Locacao:</label>
                              <div class='controls'>
                              <select id='t_cob' name='locacao_office_cpu' class='span3'>
                                    <option value='" . $office['id_locacao'] . "'>" . $office['locacao'] . "</option>
                                    <option>---</option>";
                        while ($office_locacao = $resultado_locacao->fetch_assoc()) {
                           echo "<option value='" . $office_locacao['id_empresa'] . "'>" . $office_locacao['nome'] . "</option>";
                        }
                        echo "
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Empresa:</label>
                              <div class='controls'>
                              <select id='t_cob' name='empresa_office_cpu' class='span3'>
                                    <option value='" . $office['id_empresa'] . "'>" . $office['empresa'] . "</option>
                                    <option>---</option>";
                        while ($row_cpu_officeE = mysqli_fetch_assoc($resultado_empresa)) {
                           echo "<option value='" . $row_cpu_officeE['id_empresa'] . "'>" . $row_cpu_officeE['nome'] . "</option>";
                        }
                        echo "
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Chave Key:</label>
                              <div class='controls'>
                                 <input class='span3' name='serial_nota_office_cpu' type='text' value='" . $office['serial'] . "'>                            
                              </div>
                           </div>
                           ";
                     } //end IF OFFICE DESKTOP
                  } //end IF DESKTOP

                  if ($equipamento['tipo_equipamento'] == 9) { //NOTEBOOK

                     echo "
                <div class='control-group'>
                    <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Notebook:</font>
                    </h3>
                </div>
                <input value='" . $equipamento['tipo_equipamento'] . "' style='display:none;' name='tipo_equipamento'/>
                <input value='" . $_GET['id_equip'] . "' style='display:none;' name='id_equipamento'/>
                <div class='control-group'>
                    <label class='control-label'>Patrimônio:</label>
                    <div class='controls'>
                      <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_notebook' type='text' value='" . $equipamento['patrimonio'] . "'>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Empresa:
                       <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                    </label>
                    <div class='controls'>
                       <select id='t_cob' name='empresa_notebook' class='span2' style='width: 25%'>
                          <option value='" . $equipamento['id_empresa'] . "'>" . $equipamento['empresa'] . "</option>
                          <option>---</option>";
                     while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                        echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                     }
                     echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Locação:
                       <i class='icon-lithe icon-question-sign' title='Onde se encontra o equipamento!'></i>
                    </label>
                    <div class='controls'>
                       <select id='t_cob' name='locacao_notebook' class='span2' style='width: 25%'>
                          <option value='" . $equipamento['id_locacao'] . "'>" . $equipamento['locacao'] . "</option> 
                          <option>---</option>";
                     while ($row_locacao = $resultado_locacao->fetch_assoc()) {
                        echo "<option value='" . $row_locacao['id_empresa'] . "'>" . $row_locacao['nome'] . "</option>";
                     }
                     echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Departamento:</label>
                    <div class='controls'>
                       <select id='t_cob' name='depart_notebook' class='span2' style='width: 23%'>
                          <option value='" . $equipamento['id_departamento'] . "'>" . $equipamento['departamento'] . "</option>
                          <option>---</option>";
                     while ($row_departamento = $resultado_depart->fetch_assoc()){
                        echo "<option value='" . $row_departamento['id_depart'] . "'>" . $row_departamento['nome'] . "</option>";
                     }
                     echo "</select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Nome do computador:</label>
                    <div class='controls'>
                       <input class='span2' name='nome_notebook' type='text' value='" . $equipamento['hostname'] . "'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Endereço IP:</label>
                    <div class='controls'>
                       <input class='span2' name='ip_notebook' type='text' value='" . $equipamento['ip'] . "'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Modelo:</label>
                    <div class='controls'>
                       <input class='span2' name='modelo_notebook' type='text' value='" . $equipamento['modelo'] . "'>                            
                    </div>
                 </div>  
                 <div class='control-group'>
                    <label class='control-label'>Processador:</label>
                    <div class='controls'>
                       <input class='span3' name='processador_notebook' type='text' value='" . $equipamento['processador'] . "'>                            
                    </div>
                 </div>   
                 <div class='control-group'>
                    <label class='control-label'>Hard Disk:</label>
                    <div class='controls'>
                       <input class='span1' name='hd_note' type='text' value='" . $equipamento['hd'] . "'>                            
                    </div>
                 </div> 
                 <div class='control-group'>
                    <label class='control-label'>Memória:</label>
                    <div class='controls'>
                       <input class='span1' name='memoria_note' type='text' value='" . $equipamento['memoria'] . "'>                            
                    </div>
                 </div>
                  <div class='control-group'>
                    <label class='control-label'>Situacao:</label>
                    <div class='controls'>
                       <select id='setor_1' name='situacao_note' class='span1' style='width: 10%'>
                          <option value='" . $equipamento['id_situacao'] . "'>" . $equipamento['situacao'] . "</option>
                          <option>---</option>";
                     while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                        echo "<option value='" . $row_situacao['id_situacao'] . "'>" . $row_situacao['nome'] . "</option>";
                     }
                     echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Número de série:</label>
                    <div class='controls'>
                       <input class='span3' name='serie_notebook' type='text' value='" . $equipamento['serialnumber'] . "'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Sistema operacional:</font>
                    </h3>
                </div>
                <div class='control-group'>
                    <label class='control-label'>Versão:</label>
                    <div class='controls'>
                    <select id='t_cob' name='so_notebook' class='span4'>
                          <option value='" . $windows['id_versao'] . "'>" . $windows['versao'] . "</option>
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Chave Key:</label>
                    <div class='controls'>
                       <input class='span3' name='serial_so_note' type='text' value='" . $windows['serial'] . "'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Fornecedor:</label>
                    <div class='controls'>
                       <input class='span4' name='fornecedor_so_note' type='text' value='" . $windows['fornecedor'] . "'>                            
                    </div>
                 </div>
               ";

                     if ($office['id'] != NULL) {
                        echo "
                       <div class='control-group'>
                             <h3 style='color: red;'>
                                <font style='vertical-align: inherit;'>Office:</font>
                             </h3>
                       </div>
                       <input value='" . $office['id'] . "' style='display:none' name='id_office' />
                       <div class='control-group'>
                          <label class='control-label'>Office:</label>
                          <div class='controls'>
                          <select id='t_cob' name='office_note' class='span4'>
                                <option value='" . $office['id_versao'] . "'>" . $office['versao'] . "</option>
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Fornecedor:</label>
                          <div class='controls'>
                             <input class='span4' name='fornecedor_office_note' type='text' value='" . $office['fornecedor'] . "'>                            
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Locacao:</label>
                          <div class='controls'>
                          <select id='t_cob' name='local_note_office' class='span3'>
                                <option value='" . $office['id_locacao'] . "'>" . $office['locacao'] . "</option>
                                <option>---</option>";
                        while ($row_cpu_officeL = $resultado_locacao ->fetch_assoc()) {
                           echo "<option value='" . $row_cpu_officeL['id_empresa'] . "'>" . $row_cpu_officeL['nome'] . "</option>";
                        }
                        echo "
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Empresa:</label>
                          <div class='controls'>
                          <select id='t_cob' name='empresa_note_office' class='span3'>
                                <option value='" . $office['id_empresa'] . "'>" . $office['empresa'] . "</option>
                                <option>---</option>";
                        while ($row_cpu_officeE = $resultado_empresa->fetch_assoc()) {
                           echo "<option value='" . $row_cpu_officeE['id_empresa'] . "'>" . $row_cpu_officeE['nome'] . "</option>";
                        }
                        echo "
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Chave Key:</label>
                          <div class='controls'>
                             <input class='span3' name='serial_office_note' type='text' value='" . $office['serial'] . "'>                            
                          </div>
                       </div>";
                     } //end IF OFFICE NOTEBOOK
                  } //end IF NOTEBOOK

                  if ($equipamento['tipo_equipamento'] == 5) { //RAMAL

                     echo "
               
               <div class='control-group'>
                     <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Ramal:</font>
                     </h3>
               </div>
               <input value='" . $equipamento['tipo_equipamento'] . "' style='display:none;' name='tipo_equipamento'/>
               <input value='" . $_GET['id_equip'] . "' style='display:none;' name='id_equipamento'/>
               <div class='control-group'>
                  <label class='control-label'>Modelo:</label>
                  <div class='controls'>
                     <input class='span3' id='myInput5' name='modelo_ramal' type='text' value='" . $equipamento['modelo'] . "'>                            
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>Número:</label>
                  <div class='controls'>
                     <input class='span3' name='numero_ramal' type='text' value='" . $equipamento['numero'] . "'>                            
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>Empresa:</label>
                  <div class='controls'>
                  <select id='t_cob' name='empresa_ramal' class='span3'>
                        <option value='" . $equipamento['id_empresa'] . "'>" . $equipamento['empresa'] . "</option>
                        <option>---</option>";
                     while ($row_cpu_officeE = $resultado_empresa->fetch_assoc()) {
                        echo "<option value='" . $row_cpu_officeE['id_empresa'] . "'>" . $row_cpu_officeE['nome'] . "</option>";
                     }
                     echo "
                     </select>
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>Locação:</label>
                  <div class='controls'>
                  <select id='t_cob' name='local_ramal' class='span3'>
                        <option value='" . $equipamento['id_locacao'] . "'>" . $equipamento['locacao'] . "</option>
                        <option>---</option>";
                     while ($row_cpu_officeE = $resultado_locacao->fetch_assoc()) {
                        echo "<option value='" . $row_cpu_officeE['id_empresa'] . "'>" . $row_cpu_officeE['nome'] . "</option>";
                     }
                     echo "
                     </select>
                  </div>
               </div>
               ";
                  } //end IF RAMAL


                  echo " <div class='form-actions'>";

                  if (($_GET['tipo'] == 9) || ($_GET['tipo'] == 8)) { //se for notebook ou desktop

                     if ($office['id'] == NULL) {
                        echo "<a href='#myModalOffice' class='btn btn-warning' data-toggle='modal' style='margin-left: -142px;'>
                                    Adicionar Office
                              </a>";
                     } else {
                        echo "<a href='#myModalOfficeDrop' class='btn btn-danger' data-toggle='modal' style='margin-left: -142px;'>
                                 Transferir Office
                              </a>";
                     } //não tem office

                  } //end IF adicionar office
                  ?>
                  <a href="#modalSalvar" type="submit" class="btn btn-primary pull-right" data-toggle="modal" id="salve">SALVAR</a>
                  <a href="pdf_termo_tecnicos.php?id_funcionario=<?= $_GET['id_fun'] ?>&tipo=<?= $equipamento['tipo_equipamento'] ?>&patrimonio=<?= $equipamento['patrimonio'] ?>" class="btn btn-success pull-right" style="margin-right: 10px;" target="_blanck">EMITIR TERMO</a>
                  <!--Modal alerta salvar-->
                  <div id="modalSalvar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <div id="pai">
                        <div class="modal-body">
                           <h3 id="myModalLabel">
                              <img src="../img/alerta.png" style="width: 10%">
                              Editando Equipamento!
                           </h3>
                           <div class="modal-body">
                              <div id="button_pai">
                                 <h5>tem certeza que deseja editar este equipamento?</h5>
                                 <span style="color:red;font-size:9px;"></span>
                              </div>
                              <div class="modal-footer">
                                 <a class="btn" data-dismiss="modal" aria-hidden="true">NÂO</a>
                                 <button class="btn btn-success" onclick="salvsarModal()">SIM</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Fim Modal-->
            </div>
            </form>
         </div>
         <!--ANEXOS-->
         <div class="tab-pane" id="anexos">
            <div class="span3" style="width: 802px;">
               <div class="widget stacked widget-table action-table">
                  <div class="widget-header">
                     <div class="control-group">
                        <div class="controls">
                           <!-- Button to trigger modal -->
                           <a href="#myModalanexos" role="button" class="btn btn-info pull-left filho" data-toggle="modal" title="Adicionar">Nota Fiscal / Termo</a>
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
                              <th>Nome - Documento</th>
                              <th>Versão</th>
                              <th>Data Nota</th>
                              <th>Ação</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           /*--------------------WINDOWS-------------------------*/
                           //pesquisando os arquivos criados.
                           $query_doc_windows = "SELECT 
                                    MSO.id AS id_windows,
                                    MSO.file_nota AS caminho_so,
                                    MSO.file_nota_nome AS nome_nota_so,
                                    MDS.nome AS versao_so,
                                    MSO.data_nota AS data_nota_so
                                FROM
                                    manager_sistema_operacional MSO
                                        LEFT JOIN
                                    manager_dropsistemaoperacional MDS ON MSO.versao = MDS.id
                                WHERE
                                    MSO.id_equipamento = " . $_GET['id_equip'] . "
                                        AND MSO.data_nota != '9999-12-30'
                                        AND MSO.deletar = 0";

                           $result_cod_windows = mysqli_query($conn, $query_doc_windows);

                           while ($row_windows = mysqli_fetch_assoc($result_cod_windows)) {
                              echo "<tr>
                                                   <td>
                                                      <a href='" . $row_windows['caminho_so'] . "' target='_blank'>" . $row_windows['nome_nota_so'] . "</a>
                                                   </td>
                                                   <td>
                                                      " . $row_windows['versao_so'] . "
                                                   </td>
                                                   <td>
                                                      " . $row_windows['data_nota_so'] . "
                                                   </td>
                                                   <td style='padding-top: 13px;'>
                                                      <!--Editar-->
                                                      <a href='#myModalEditar" . $row_windows['id_windows'] . "' role='button' data-toggle='modal' title='Editar'>
                                                         <i class='btn-icon-only icon-pencil'></i>
                                                      </a>
                                                      <!--Excluir-->
                                                      <a href='#myModalExcluir" . $row_windows['id_windows'] . "' role='button' data-toggle='modal' title='Excluir'>
                                                         <i class='btn-icon-only icon-trash lixeira' ></i>
                                                      </a>
                                                   </td>
                                                </tr>                                                
                                                <!--MODAL EDIÇÃO-->
                                                <div id='myModalEditar" . $row_windows['id_windows'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                   <div class='modal-header'>
                                                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                      <h3 id='myModalLabel'>
                                                         <img src='../img/alerta.png'alerta.png' style='width: 10%'>Alterando dados da Nota Fiscal
                                                      </h3>
                                                   </div>
                                                   <div class='modal-body'>
                                                      <div class='modal-body'>
                                                         <!--Colocar a tabela Aqui!-->
                                                         <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_edit_nota.php'
                                                         method='post'>
                                                            <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                            <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                            <input type='text' name='id_win' style='display:none ;' value='" . $row_windows['id_windows'] . "'>
                                                            <input type='text' name='programa' style='display:none ;' value='1'>
                                                            <input type='text' name='tipo' style='display:none ;' value='" . $_GET['tipo'] . "'>
                                                            <div class='control-group'>
                                                               <label class='control-label'>Tipo da nota:</label>
                                                               <div class='controls'>
                                                                  <input type='text' name='tipo_nota' class='form-control span3' value='" . $row_windows['versao_so'] . "' readonly='true'>
                                                               </div>
                                                            </div>                                                            
                                                            <div class='control-group'>
                                                               <label class='control-label'>Data da nota:</label>
                                                               <div class='controls'>
                                                                  <input type='text' class='form-control span2' name='data_nota' id='outra_data' onkeypress='mascaraData( this, event )' value='" . $row_windows['data_nota_so'] . "'/>
                                                               </div>
                                                            </div>
                                                            <div class='control-group'>
                                                               <label class='control-label'>Alterar anexo:</label>
                                                               <div class='controls'>
                                                                  <input type='file' name='file_nota' class='form-control span2' required>
                                                               </div>
                                                               <h6 style='color: red; font-size: 9px;'>
                                                                  <p>Atenção!!</p>
                                                                  Novo anexo irá substituir o antigo, caso não queira alterar o anexo basta não informar
                                                               </h6>
                                                            </div>
                                                            <div class='modal-footer'>
                                                               <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                               <button class='btn btn-primary'>Salvar</button>
                                                            </div>                                                   
                                                         </form>
                                                      </div>   
                                                   </div>
                                                </div>
                                                <!--FIM EDIÇÃO--> 
                                                <!--MODAL EXCLUIR-->
                                          <div id='myModalExcluir" . $row_windows['id_windows'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                             <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                <h3 id='myModalLabel'>
                                                   <img src='../img/alerta.png'atencao.png' style='width: 10%'>Excluindo Nota Windows
                                                </h3>
                                             </div>
                                             <div class='modal-body'>
                                                <div class='modal-body'>
                                                   <!--Colocar a tabela Aqui!-->
                                                   <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_drop_nota.php'
                                                   method='post'>
                                                      <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                      <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                      <input type='text' name='id_win' style='display:none ;' value='" . $row_windows['id_windows'] . "'>
                                                      <input type='text' name='programa' style='display:none ;' value='1'>   
                                                      <input type='text' name='tipo' style='display:none ;' value='" . $_GET['tipo'] . "'>                                                 
                                                      <h6>
                                                         Deseja excluir a nota do windows citada abaixo ?
                                                      </h6>
                                                      <div class='control-group'>
                                                         <div class='controls'>
                                                            <p class='linha'>Nome do documento: " . $row_windows['nome_nota_so'] . "'</p>
                                                         </div>
                                                      </div>
                                                      </div>
                                                      <div class='modal-footer'>
                                                         <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                         <button class='btn btn-primary'>Sim</button>
                                                      </div>                                                   
                                                   </form>
                                                </div>   
                                             </div>
                                          </div>
                                          <!--FIM EXCLUIR-->                                      
                                                ";
                           } //end WHILE windows
                           /*--------------------OFFICE-------------------------*/
                           //pesquisando os arquivos criados.
                           $query_doc_office = "SELECT 
                                    MO.id AS id_office,
                                    MO.file_nota AS caminho_of,
                                    MO.file_nota_nome AS nome_nota_of,
                                    MDO.nome AS versao_of,
                                    MO.data_nota AS data_nota_of
                                FROM
                                    manager_office MO
                                        LEFT JOIN
                                    manager_dropoffice MDO ON MO.versao = MDO.id
                                WHERE
                                    MO.id_equipamento = " . $_GET['id_equip'] . "
                                        AND MO.data_nota != '9999-12-30'
                                        AND MO.deletar = 0";

                           $result_cod_office = mysqli_query($conn, $query_doc_office);

                           while ($row_office = mysqli_fetch_assoc($result_cod_office)) {
                              echo "<tr>
                                             <td>
                                                <a href='" . $row_office['caminho_of'] . "' target='_blank'>" . $row_office['nome_nota_of'] . "</a>
                                             </td>
                                             <td>
                                                " . $row_office['versao_of'] . "
                                             </td>
                                             <td>
                                                " . $row_office['data_nota_of'] . "
                                             </td>
                                             <td style='padding-top: 13px;'>
                                                      <!--Editar-->
                                                      <a href='#myModalEditar" . $row_office['id_office'] . "' role='button' data-toggle='modal' title='Editar'>
                                                         <i class='btn-icon-only icon-pencil'></i>
                                                      </a>
                                                      <!--Excluir-->
                                                      <a href='#myModalExcluir" . $row_office['id_office'] . "' role='button' data-toggle='modal' title='Excluir'>
                                                         <i class='btn-icon-only icon-trash lixeira' ></i>
                                                      </a>
                                                   </td>
                                          </tr>                                                
                                                <!--MODAL EDIÇÃO-->
                                                <div id='myModalEditar" . $row_office['id_office'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                   <div class='modal-header'>
                                                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                      <h3 id='myModalLabel'>
                                                         <img src='../img/alerta.png'alerta.png' style='width: 10%'>Alterando dados da Nota Fiscal
                                                      </h3>
                                                   </div>
                                                   <div class='modal-body'>
                                                      <div class='modal-body'>
                                                         <!--Colocar a tabela Aqui!-->
                                                         <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_edit_nota.php'
                                                         method='post'>
                                                            <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                            <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                            <input type='text' name='id_win' style='display:none ;' value='" . $row_office['id_office'] . "'>
                                                            <input type='text' name='programa' style='display:none ;' value='2'>
                                                            <input type='text' name='tipo' style='display:none ;' value='" . $_GET['tipo'] . "'>
                                                            <div class='control-group'>
                                                               <label class='control-label'>Tipo da nota:</label>
                                                               <div class='controls'>
                                                                  <input type='text' name='tipo_nota' class='form-control span3' value='" . $row_office['versao_of'] . "' readonly='true'>
                                                               </div>
                                                            </div>                                                            
                                                            <div class='control-group'>
                                                               <label class='control-label'>Data da nota:</label>
                                                               <div class='controls'>
                                                                  <input type='text' class='form-control span2' name='data_nota' id='outra_data' onkeypress='mascaraData( this, event )' value='" . $row_office['data_nota_of'] . "'/>
                                                               </div>
                                                            </div>
                                                            <div class='control-group'>
                                                               <label class='control-label'>Alterar anexo:</label>
                                                               <div class='controls'>
                                                                  <input type='file' name='file_nota' class='form-control span2' required>
                                                               </div>
                                                               <h6 style='color: red; font-size: 9px;'>
                                                                  <p>Atenção!!</p>
                                                                  Novo anexo irá substituir o antigo, caso não queira alterar o anexo basta não informar
                                                               </h6>
                                                            </div>
                                                            <div class='modal-footer'>
                                                               <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                               <button class='btn btn-primary'>Salvar</button>
                                                            </div>                                                   
                                                         </form>
                                                      </div>   
                                                   </div>
                                                <!--FIM EDIÇÃO-->  
                                             </div>
                                             <!--MODAL EXCLUIR-->
                                          <div id='myModalExcluir" . $row_office['id_office'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                             <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                <h3 id='myModalLabel'>
                                                   <img src='../img/alerta.png'atencao.png' style='width: 10%'>Excluindo Nota Office
                                                </h3>
                                             </div>
                                             <div class='modal-body'>
                                                <div class='modal-body'>
                                                   <!--Colocar a tabela Aqui!-->
                                                   <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_drop_nota.php'
                                                   method='post'>
                                                      <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                      <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                      <input type='text' name='id_win' style='display:none ;' value='" . $row_office['id_office'] . "'>
                                                      <input type='text' name='programa' style='display:none ;' value='2'>                                                   
                                                      <h6>
                                                         Deseja excluir a nota do office citada abaixo ?
                                                      </h6>
                                                      <div class='control-group'>
                                                         <div class='controls'>
                                                            <p class='linha'>Nome do documento: " . $row_office['nome_nota_of'] . "'</p>
                                                         </div>
                                                      </div>
                                                      </div>
                                                      <div class='modal-footer'>
                                                         <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                         <button class='btn btn-primary'>Sim</button>
                                                      </div>                                                   
                                                   </form>
                                                </div>   
                                             </div>
                                          </div>
                                          <!--FIM EXCLUIR-->";
                           } //end WHILE OFFICE
                           /*--------------------TERMO-------------------------*/
                           //pesquisando os arquivos criados.
                           $query_doc_termo = "SELECT 
                                    MIA.id_anexo,
                                    MIA.caminho,
                                    MIA.nome,
                                    MIA.data_criacao,
                                    MIA.tipo
                                FROM
                                    manager_inventario_anexo MIA
                                    WHERE
                                    MIA.id_equipamento = " . $_GET['id_equip'] . "
                                        AND MIA.deletar = 0";

                           $result_cod_termo = mysqli_query($conn, $query_doc_termo);

                           while ($row_termo = mysqli_fetch_assoc($result_cod_termo)) {

                              if ($row_termo['tipo'] == 3) {
                                 $tipo = "TERMO DE RESPONSABILIDADE";
                              }

                              //alterando formato da data

                              echo "<tr>
                                             <td>
                                                <a href='" . $row_termo['caminho'] . "' target='_blank'>" . $row_termo['nome'] . "</a>
                                             </td>
                                             <td>
                                               " . $tipo . "
                                             </td>
                                             <td>
                                                " . $row_termo['data_criacao'] . "
                                             </td>
                                             <td style='padding-top: 13px;'>
                                                <!--Editar-->
                                                <a href='#myModalEditar" . $row_termo['id_anexo'] . "' role='button' data-toggle='modal' title='Editar'>
                                                   <i class='btn-icon-only icon-pencil'></i>
                                                </a>
                                                <!--Excluir-->
                                                <a href='#myModalExcluir" . $row_termo['id_anexo'] . "' role='button' data-toggle='modal' title='Excluir'>
                                                   <i class='btn-icon-only icon-trash lixeira' ></i>
                                                </a>
                                             </td>
                                          </tr>
                                          <!--MODAL EDIÇÃO-->
                                          <div id='myModalEditar" . $row_termo['id_anexo'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                             <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                <h3 id='myModalLabel'>
                                                   <img src='../img/alerta.png'alerta.png' style='width: 10%'>Alterando dados da Nota Fiscal
                                                </h3>
                                             </div>
                                             <div class='modal-body'>
                                                <div class='modal-body'>
                                                   <!--Colocar a tabela Aqui!-->
                                                   <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_edit_nota.php'
                                                   method='post'>
                                                      <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                      <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                      <input type='text' name='id_win' style='display:none ;' value='" . $row_termo['id_anexo'] . "'>
                                                      <input type='text' name='programa' style='display:none ;' value='3'>
                                                      <div class='control-group'>
                                                         <label class='control-label'>Tipo da nota:</label>
                                                         <div class='controls'>
                                                            <input type='text' name='tipo_nota' class='form-control span3' value='" . $tipo . "'>
                                                         </div>
                                                      </div>                                                            
                                                      <div class='control-group'>
                                                         <label class='control-label'>Data da nota:</label>
                                                         <div class='controls'>
                                                            <input type='text' class='form-control span2' name='data_nota' id='outra_data' onkeypress='mascaraData( this, event )' value='" . $row_termo['data_criacao'] . "'/>
                                                         </div>
                                                      </div>
                                                      <div class='control-group'>
                                                         <label class='control-label'>Alterar anexo:</label>
                                                         <div class='controls'>
                                                            <input type='file' name='file_nota' class='form-control span2' required>
                                                         </div>
                                                         <h6 style='color: red; font-size: 9px;'>
                                                            <p>Atenção!!</p>
                                                            Novo anexo irá substituir o antigo, caso não queira alterar o anexo basta não informar
                                                         </h6>
                                                      </div>
                                                      <div class='modal-footer'>
                                                         <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                         <button class='btn btn-primary'>Salvar</button>
                                                      </div>                                                   
                                                   </form>
                                                </div>   
                                             </div>
                                          </div>
                                          <!--FIM EDIÇÃO-->
                                          <!--MODAL EXCLUIR-->
                                          <div id='myModalExcluir" . $row_termo['id_anexo'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                             <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>                                                      
                                                <h3 id='myModalLabel'>
                                                   <img src='../img/alerta.png'atencao.png' style='width: 10%'>Excluindo Termo
                                                </h3>
                                             </div>
                                             <div class='modal-body'>
                                                <div class='modal-body'>
                                                   <!--Colocar a tabela Aqui!-->
                                                   <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_drop_nota.php'
                                                   method='post'>
                                                      <input type='text' name='id_equip' style='display:none ;' value='" . $_GET['id_equip'] . "'>
                                                      <input type='text' name='id_fun' style='display:none ;' value='" . $_GET['id_fun'] . "'>
                                                      <input type='text' name='id_win' style='display:none ;' value='" . $row_termo['id_anexo'] . "'>
                                                      <input type='text' name='programa' style='display:none ;' value='3'>                                                      
                                                      <h6>
                                                         Deseja excluir o termo citada abaixo ?
                                                      </h6>
                                                      <div class='control-group'>
                                                         <div class='controls'>
                                                            <p class='linha'>Nome do documento: " . $row_termo['nome'] . "'</p>
                                                         </div>
                                                      </div>
                                                      </div>
                                                      <div class='modal-footer'>
                                                         <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                         <button class='btn btn-primary'>Sim</button>
                                                      </div>                                                   
                                                   </form>
                                                </div>   
                                             </div>
                                          </div>
                                          <!--FIM EXCLUIR-->
                                          ";
                           } //end WHILE windows
                           ?>
                        </tbody>
                     </table>
                  </div>
                  <!-- /widget-content -->
               </div>
               <!-- /widget -->
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<!--MODAIS-->
<!-- Modal ANEXOS ADICIONAR -->
<div id="myModalanexos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Nota Fiscal / Termo</h3>
   </div>
   <div class="modal-body">
      <!--Colocar a tabela Aqui!-->
      <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_add_doc.php" method="post">
         <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
         <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
         <div class="control-group">
         </div>

         <div class="control-group">
            <label class="control-label required">Tipo:</label>
            <div class="controls">
               <select id="nota" name="tipo" class="span2" required="">
                  <?php
                  if ($office['id'] != NULL) {
                     echo "<option value=''>---</option>
                                    <option value='1'>Nota Windows</option>
                                    <option value='2'>Nota Office</option>
                                    <option value='3'>Termo</option>";
                  } else {
                     echo "<option value=''>---</option>
                                    <option value='1'>Nota Windows</option>
                                    <option value='3'>Termo de Responsabilidade</option>";
                  }
                  ?>
               </select>
            </div>
         </div>
         <div class="control-group" style="display:none" id='hidenota'>
            <label class="control-label">Número da Nota:</label>
            <div class="controls">
               <input class="cpfcnpj span2" type="text" name="numero_nota" />
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Data:</label>
            <div class="controls">
               <input class="cpfcnpj span2" type="text" name="data" placeholder="DD/MM/AAAA" required />
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Selecione:</label>
            <div class="controls">
               <input class="cpfcnpj span2" type="file" name="termo" required />
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-primary">Salvar</button>
         </div>
      </form>
   </div>
</div>

<!-- Modal ADICIONAR OFFICE -->
<div id="myModalOffice" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 48%;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Novo Office</h3>
   </div>
   <div class="modal-body">
      <!--Colocar a tabela Aqui!-->
      <?php
      echo "
      <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_new_office.php' method='post'>
            <input type='text' name='id_fun' style='display:none' value='" . $_GET['id_fun'] . "'>
            <input type='text' name='id_equip' style='display:none' value='" . $_GET['id_equip'] . "'>
            <input type='text' name='tipo_equipamento' style='display:none' value='" . $equipamento['tipo_equipamento'] . "'>
           <div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <select id='t_cob' name='tipo_office' class='span3'>
                     <option>---</option>";
      $office_cpu = "SELECT * from manager_dropoffice where deletar = 0 order by nome";
      $resultado = mysqli_query($conn, $office_cpu);
      while ($row = mysqli_fetch_assoc($resultado)) {
         echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
      } //end WHILE office
      echo "   
                  </select>
               </div>
            </div>
            <div class='control-group '>
               <label class='control-label'>Fornecedor:</label>                  
               <div class='controls autocomplete' style='margin-left: 5px;'>
                  <input class='span3' id='myInput1'  type='text' name='fornecedor_office'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Locacao:</label>
               <div class='controls'>
                  <select id='t_cob' name='local_office' class='span3'>
                     <option>---</option>";
      $officeNEW = "SELECT * from manager_droplocacao  where deletar = 0 ORDER BY nome";
      $resultado_officeNEW = mysqli_query($conn, $officeNEW);
      while ($row_officeNEW = mysqli_fetch_assoc($resultado_officeNEW)) {
         echo "<option value='" . $row_officeNEW['id_empresa'] . "'>" . $row_officeNEW['nome'] . "</option>";
      }
      echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Empresa:</label>
               <div class='controls'>
                  <select id='t_cob' name='empresa_office' class='span3'>
                     <option>---</option>";
      $officeEmpresa = "SELECT * from manager_dropempresa  where deletar = 0 ORDER BY nome";
      $resultado_office = mysqli_query($conn, $officeEmpresa);
      while ($row_office = mysqli_fetch_assoc($resultado_office)) {
         echo "<option value='" . $row_office['id_empresa'] . "'>" . $row_office['nome'] . "</option>";
      }
      echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Chave Key:</label>
               <div class='controls'>
                  <input class='cpfcnpj span4' type='text' name='serial_office'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Nota:
               </label>
               <div class='controls'>
                     <input type='file' name='file_nota' class='form-control span2'>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Data da nota:</label>
               <div class='controls'>
                  <input type='text' name='data_nota' class='form-control span2' placeholder='dd / mm / aaaa' style='width: 24%;'>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Número da nota:</label>
               <div class='controls'>
                  <input type='text' name='num_nota' class='form-control span1'>
               </div>
            </div>";
      ?>
      <div class="modal-footer">
         <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
         <button class="btn btn-primary">Salvar</button>
      </div>
      </form>
   </div>
</div>

<!-- Modal REMOVE OFFICE -->
<div id="myModalOfficeDrop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">
         <img src="../img/alerta.png" style="width: 10%">
         Transferir Office para outro usuário
      </h3>
   </div>
   <div class="modal-body">
      <?php
      echo "
        <form id='edit-profile' class='form-horizontal' enctype='multipart/form-data' action='equip_trans.php'
            method='post'>
            <input type='text' name='id_fun' style='display:none' value='" . $_GET['id_fun'] . "'>
            <input type='text' name='id_equip' style='display:none' value='" . $_GET['id_equip'] . "'>
            <input type='text' name='tipo_equipamento' style='display:none' value='" . $equipamento['tipo_equipamento'] . "'>
           <div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <input class='span3' type='text' name='office' value='" . $office['versao'] . "'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Fornecedor:</label>                  
               <div class='controls'>
                  <input class='span4' type='text' name='fornecedor_office' value='" . $office['fornecedor'] . "'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Locacao:</label>
               <div class='controls'>
                  <select id='t_cob' name='local_office' class='span3'>
                     <option value='" . $office['id_locacao'] . "'>" . $office['locacao'] . "</option>
                     <option>---</option>";
      $officeE = "SELECT * from manager_droplocacao  where deletar = 0 ORDER BY nome";
      $resultado_officeE = mysqli_query($conn, $officeE);
      while ($row_officeE = mysqli_fetch_assoc($resultado_officeE)) {
         echo "<option value='" . $row_officeE['id_empresa'] . "'>" . $row_officeE['nome'] . "</option>";
      }
      echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Empresa:</label>
               <div class='controls'>
                  <select id='t_cob' name='empresa_office' class='span3'>
                     <option value='" . $office['id_empresa'] . "'>" . $office['empresa'] . "</option>
                     <option>---</option>";
      $officeEM = "SELECT * from manager_dropempresa  where deletar = 0 ORDER BY nome";
      $resultado_officeEM = mysqli_query($conn, $officeEM);
      while ($row_officeEM = mysqli_fetch_assoc($resultado_officeEM)) {
         echo "<option value='" . $row_officeEM['id_empresa'] . "'>" . $row_officeEM['nome'] . "</option>";
      }
      echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Chave Key:</label>
               <div class='controls'>
                  <input class='cpfcnpj span4' type='text' name='serial_office' value='" . $office['serial'] . "'/>
               </div>
            </div>
                      
            <div class='control-group'>
            <label class='control-label'>Equipamento:</label>
            <div class='controls'>
               <select id='t_cob' name='new_office' class='span2'>
                  <option value=''>---</option>";
      $buscando_usuario = "SELECT 
            MO.id AS id_office,
            MIE.id_equipamento,
            MIE.patrimonio
            FROM
            manager_inventario_equipamento MIE
               LEFT JOIN
            manager_office MO ON MIE.id_equipamento = MO.id_equipamento
            WHERE
            MIE.tipo_equipamento IN (8,9)";

      $result_search_user = mysqli_query($conn, $buscando_usuario);

      while ($row_search = mysqli_fetch_assoc($result_search_user)) {

         if ($row_search['id_office'] == NULL) {
            echo "<option value='" . $row_search['id_equipamento'] . "'>" . $row_search['patrimonio'] . "</option>";
         } //end IF equipamento sem office
      } //end While equipamento que recebera o OFFICE   

      echo "</select>                     
               <i class='icon-lithe icon-question-sign' title='Equipamento que irá receber o Office!'></i>
            </div>
         </div>";
      ?>
      <div class="modal-footer">
         <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
         <button class="btn btn-primary">Salvar</button>
      </div>
      </form>
   </div>
</div>

</html>

<!--------------JAVA SCRIPTS------------>
<!--MOSTRAR CAMPO ICONE-->
<script>
   //alerta do apertar o enter
   jQuery('#formPrincipal').keypress(function(event) {

      var keycode = (event.keyCode ? event.keyCode : event.which);
      if (keycode == '13') {
         alert('Clique em "SALVAR" no final do formulário');
         location.reload();

         $("#formPrincipal").submit(function() {
            return false;
         });
      }
   });
   //Fim alerta do apertar o enter

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
<!--MASCARÁS CPF/DATA-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/cnpj.js"></script>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script language="javascript">
   $(document).ready(function() {
      $('#outra_data').mask('99/99/9999');
      return false;
   });
</script>

<!--AUTO PREENCHIMENTO DO CAMPO FORNECEDOR-->
<script src="../js/autocomplete_f.js"></script>
<!--MASCARA MAIUSCULA-->
<script type="text/javascript">
   function maiuscula(z) {
      v = z.value.toUpperCase();
      z.value = v;
   }
</script>

<script>
   $("#nota").change(

      function() {
         $('#hidenota').hide();

         if (this.value == "1") {
            $('#hidenota').show();
         }

      }

   );
</script>

<!-------------- FIM JAVA SCRIPTS------------>
<?php mysqli_close($conn); ?>