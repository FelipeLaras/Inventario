<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
       header('location: ../front/error.php');
   }   
   
   require_once('header.php');
   require_once('../query/query_dropdowns.php');

?>
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
            </ul>
        </div>
    </div>
</div>
<div class="widget ">
<?php

   //recebendo a informação e distribuindo nos campos do formulario
   $query_contrato = "SELECT 
   MIE.id_equipamento,
   MIE.id_funcionario,
   MIE.serialnumber,
   MIE.modelo,
   MIE.patrimonio,
   MDE.nome AS empresa,
   MIE.filial AS id_empresa,
   MDL.nome AS locacao,
   MIE.locacao AS id_locacao,
   MIE.fornecedor_scan,
   MIE.data_fim_contrato,
   MIE.numero_nota,
   MIA.nome AS nome_nota,
   MIA.caminho AS caminho_nota,
   MIF.nome AS responsavel,
   MIF.empresa AS id_empresaFUN,
   MDEF.nome AS empresaFUN,
   MIF.funcao AS id_funcao,
   MDF.nome AS funcao,
   MIF.cpf,
   MDD.nome AS departamento,
   MIF.departamento AS id_depart,
   MDS.nome AS situacao,
   MIE.situacao AS id_situacao
FROM
   manager_inventario_equipamento MIE
       LEFT JOIN
   manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
       LEFT JOIN
   manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
       LEFT JOIN
   manager_inventario_anexo MIA ON MIE.id_equipamento = MIA.id_equipamento
       LEFT JOIN
   manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
       LEFT JOIN
   manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
       LEFT JOIN
   manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
       LEFT JOIN
   manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
     LEFT JOIN
  manager_dropempresa MDEF ON MIF.empresa = MDEF.id_empresa
WHERE
   MIE.id_equipamento = ".$_GET['id_equip']."";

   $resultado = $conn->query($query_contrato);
   $row = mysqli_fetch_assoc($resultado); 

   //trocando formato da dara fim do contrato
  $data_fim = date('d/m/Y',  strtotime($row['data_fim_contrato']));

   ?>
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="tecnicos_ti.php">Home</a>
            /
            <i class="icon-lithe icon-table"></i>&nbsp;
            <a href="equip.php">Inventário</a>
            /
            <i class="icon-lithe icon-print"></i>&nbsp;
            <a href="scan_disponivel.php">Scanners</a>
            /
            <i class="icon-lithe fas fa-print"></i>&nbsp;
            <?php
            if($row['id_situacao'] == 4){
                echo "<a href='javascript:'>".$row['modelo']."</a>";
            }else{
                echo "<a href='javascript:'>".$row['patrimonio']."</a>";
            }
            ?>
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#contratos" data-toggle="tab">Funcionário / Equipamento</a>
                </li>
                <li>
                    <a href="#anexos" data-toggle="tab">Notas Fiscais</a>
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
                    <form id="edit-profile" class="form-horizontal" action="scan_add_alter.php" method="post">
                        <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                        <input type="text" name="id_funcionario" style="display: none;"
                            value="<?= $row['id_funcionario'] ?>">
                        <!--fim da gambiarra-->
                        <div class="control-group">
                            <h3 style="color: red;">
                                <font style="vertical-align: inherit;">Funcionário Responsável:</font>
                            </h3>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nome completo:</label>
                            <div class="controls">
                                <input class="span6" name="nome" type="text" onkeyup='maiuscula(this)' required
                                    value="<?= $row['responsavel'] ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">CPF:</label>
                            <div class="controls">
                                <input class="cpfcnpj span2" type="text" name="cnpj_forne" value="<?= $row['cpf']  ?>"
                                    required />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Função:</label>
                            <div class="controls">
                                <select id="t_cont" name="funcao" class="span2">
                                    <option value="<?= $row['id_funcao'] ?>"><?= $row['funcao']  ?>
                                    </option>
                                    <?php 
                                        while ($row_funcao = $resultado_funcao->fetch_assoc()) {
                                        echo "<option value='".$row_funcao['id_funcao']."'>".$row_funcao['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Empresa / Filial:</label>
                            <div class="controls">
                                <select id="t_cob" name="empresa" class="span2" required>
                                    <option value="<?= $row['id_empresaFUN'] ?>"> <?= $row['empresaFUN']?> </option>
                                    <?php 
                                        while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                            echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Departamento:</label>
                            <div class="controls">
                                <select id="setor_1" name="setor" class="span2">
                                    <option value="<?= $row['id_depart'] ?>"><?= $row['departamento']  ?>
                                    </option>
                                    <?php
                                        while ($row_depart = $resultado_depart->fetch_assoc()) {
                                            echo "<option value='".$row_depart['id_depart']."'>".$row_depart['nome']."</option>";
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php

                    if($row['id_situacao'] == 4){//alugado

                      echo "
                    <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Scanner - <u>ALUGADO</u>:</font>
                        </h3>
                    </div>
                    <input value='".$_GET['tipo']."' style='display:none;' name='id_situacao'/>
                    <input value='".$_GET['id_equip']."' style='display:none;' name='id_equipamento'/>
                    <div class='control-group'>
                        <label class='control-label'>Patrimônio:</label>
                        <div class='controls'>
                          <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_scan' type='text' value='".$row['patrimonio']."'>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Empresa:
                           <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='empresa_scan' class='span2'>
                              <option value='".$row['id_empresa']."'>".$row['empresa']."</option>
                              <option>---</option>";
                              $query_empresa_cpu = "SELECT * from manager_dropempresa  where deletar = 0 ORDER BY nome";
                               $resultado_empresa_cpu = $conn->query($query_empresa_cpu);
                              while ($row_empresa= mysqli_fetch_assoc($resultado_empresa_cpu)) {
                                echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
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
                           <select id='t_cob' name='locacao_scan' class='span2'>
                              <option value='".$row['id_locacao']."'>".$row['locacao']."</option> 
                              <option>---</option>"; 
                              $query_locacao_cpu = "SELECT * from manager_droplocacao  where deletar = 0 ORDER BY nome";
                               $resultado_locacao_cpu = $conn->query($query_locacao_cpu);
                              while ($row_locacao= mysqli_fetch_assoc($resultado_locacao_cpu)) {
                                echo "<option value='".$row_locacao['id_empresa']."'>".$row_locacao['nome']."</option>";
                              }
                        echo "
                           </select>
                        </div>
                     </div>  
                     <div class='control-group'>
                        <label class='control-label'>Fornecedor</label>
                        <div class='controls'>
                           <input class='span4' name='fornecedor_scan' type='text' value='".$row['fornecedor_scan']."'>                            
                        </div>
                     </div> 
                     <div class='control-group'>
                        <label class='control-label'>Data fim contrato:</label>
                        <div class='controls'>
                           <input class='span2' name='data_fim_scan' type='text' value='".$data_fim."'>                            
                        </div>
                     </div>
                      <div class='control-group'>
                        <label class='control-label'>Situacao:</label>
                        <div class='controls'>
                           <select id='setor_1' name='situacao_scan' class='span2'>
                              <option value='".$row['id_situacao']."'>".$row['situacao']."</option>
                              <option>---</option>";
                              $query_situacao = "SELECT * from manager_dropsituacao  where id_situacao in (4,5) ORDER BY nome";
                                 $resultado_situacao = $conn->query($query_situacao);
                                 while ($row_situacao= mysqli_fetch_assoc($resultado_situacao)) {
                                 echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                 }
                           echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Número de série:</label>
                        <div class='controls'>
                           <input class='span3' name='serie_scan' type='text' value='".$row['serialnumber']."'>                            
                        </div>
                     </div>";                   
               }//end IF Scanner ALUGADO

               if($row['id_situacao'] == 5){//COMPRADO

                  echo "
                    <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Scanner - <u>COMPRADO</u>:</font>
                        </h3>
                    </div>
                    <input value='".$_GET['tipo']."'style='display:none;' name='id_situacao'/>
                    <input value='".$_GET['id_equip']."' style='display:none;' name='id_equipamento'/>
                    <div class='control-group'>
                        <label class='control-label'>Patrimônio:</label>
                        <div class='controls'>
                          <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_scan' type='text' value='".$row['patrimonio']."'>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Empresa:
                           <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='empresa_scan' class='span2'>
                              <option value='".$row['id_empresa']."'>".$row['empresa']."</option>
                              <option>---</option>";
                              while ($row_empresa= $resultado_empresa->fetch_assoc()) {
                                echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
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
                           <select id='t_cob' name='locacao_scan' class='span2'>
                              <option value='".$row['id_locacao']."'>".$row['locacao']."</option> 
                              <option>---</option>"; 
                              while ($row_locacao= $resultado_empresa->fetch_assoc()) {
                                echo "<option value='".$row_locacao['id_empresa']."'>".$row_locacao['nome']."</option>";
                              }
                        echo "
                           </select>
                        </div>
                     </div>  
                     <div class='control-group'>
                        <label class='control-label'>Número nota fiscal</label>
                        <div class='controls'>
                           <input class='span2' name='numero_nota_scan' type='text' value='".$row['numero_nota']."'>                            
                        </div>
                     </div>
                      <div class='control-group'>
                        <label class='control-label'>Situacao:</label>
                        <div class='controls'>
                           <select id='setor_1' name='situacao_scan' class='span2'>
                              <option value='".$row['id_situacao']."'>".$row['situacao']."</option>
                              <option>---</option>";
                                 while ($row_situacao= $resultado_situacao->fetch_assoc()) {
                                 echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                 }
                           echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Número de série:</label>
                        <div class='controls'>
                           <input class='span3' name='serie_scan' type='text' value='".$row['serialnumber']."'>                            
                        </div>
                     </div>";       
           }//end IF COMPRADO
?>
                        <div class="form-actions">
                            <?php
if(($_GET['tipo'] == 9) || ($_GET['tipo'] == 8)){//se for notebook ou desktop

   $query_tem_office = "SELECT id FROM manager_office WHERE id_equipamento = ".$_GET['id_equip'] .";";
   $result_tem_office = $conn->query($query_tem_office);
   $row_tem_office = $result_tem_office->fetch_assoc();

   if($row_tem_office['id'] == NULL){
      echo "<a href='#myModalOffice' class='btn btn-warning' data-toggle='modal' style='margin-left: -142px;'>
                  Adicionar Office
            </a>";
   }else{
      echo "<a href='#myModalOfficeDrop' class='btn btn-danger' data-toggle='modal' style='margin-left: -142px;'>
               Transferir Office
            </a>";
   }//não tem office

}//end IF adicionar office
?>
                            <button type="submit" class="btn btn-primary pull-right">Salvar</button>

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
                                        <a href="#myModalanexos" role="button" class="btn btn-info pull-left filho"
                                            data-toggle="modal" title="Adicionar"> + Nota Fiscal</a>
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
                                            <th>Nome / Documento</th>
                                            <th>Número Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    /*--------------------NOTA-------------------------*/
                                    //pesquisando os arquivos criados.
                                    $query_doc_termo = "SELECT 
                                    MIA.id_anexo, MIA.caminho, MIA.nome, MIE.numero_nota
                                FROM
                                    manager_inventario_anexo MIA
                                        LEFT JOIN
                                    manager_inventario_equipamento MIE ON MIA.id_equipamento = MIE.id_equipamento
                                WHERE
                                    MIA.id_equipamento = ".$_GET['id_equip']."";

                                    $result_cod_termo = $conn->query($query_doc_termo);

                                 while ($row_termo = mysqli_fetch_assoc($result_cod_termo)) {

                                    echo "<tr>
                                             <td>
                                                <a href='".$row_termo['caminho']."' target='_blank'>".$row_termo['nome']."</a>
                                             </td>
                                             <td>
                                                ";
                                                if(empty($row_termo['numero_nota'])){
                                                    echo "Alugado";
                                                }else{
                                                    echo $row_termo['numero_nota'];
                                                }
                                                echo "
                                             </td>
                                          </tr>
                                          ";
                                    }//end WHILE NOTA
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
<script src="../ava.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<!--MODAIS-->
<!-- Modal ANEXOS ADICIONAR -->
<div id="myModalanexos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Adicionando - Nota Fiscal</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_add_doc.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $row['id_funcionario']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">            
            <input type="text" name="tipo" style="display:none ;" value='10'>
            <div class="control-group">
            </div>
            <div class="control-group">
                <label class="control-label">Número da Nota:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="text" name="numero_nota" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nota Fiscal:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="notaFiscal" required />
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
<div id="myModalOffice" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Novo Office</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_new_office.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <?php
      echo "<div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <select id='t_cob' name='tipo_office' class='span3'>
                     <option>---</option>";
                       while($row = $resultado_office->fetch_assoc()){
                        echo "<option value='".$row['id']."'>".$row['nome']."</option>";
                     }//end WHILE office
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
                        while ($row_officeNEW= $resultado_empresa->fetch_assoc()) {
                            echo "<option value='".$row_officeNEW['id_empresa']."'>".$row_officeNEW['nome']."</option>";
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
                        while ($row_office= $resultado_empresa->fetch_assoc()) {
                            echo "<option value='".$row_office['id_empresa']."'>".$row_office['nome']."</option>";
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
               <label class='control-label'>Data da nota:
               </label>
               <div class='controls'>
                     <input type='date' name='data_nota' class='form-control span2'>
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
<div id="myModalOfficeDrop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">
            <img src="img/alerta.png" style="width: 10%">
            Transferir Office para outro usuário
        </h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_trans.php" method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <?php
   $traz_office = "SELECT 
   MDO.nome AS office,
   MO.fornecedor,
   MDL.nome AS locacao_office,
   MO.locacao AS IDlocacao_office,
   MDE.nome AS empresa_office,
   MO.empresa AS IDempresa_office,
   MO.serial
   FROM
   manager_office MO
      LEFT JOIN
   manager_dropoffice MDO ON MO.versao = MDO.id
      LEFT JOIN
   manager_dropempresa MDE ON MO.empresa = MDE.id_empresa
      LEFT JOIN
   manager_droplocacao MDL ON MO.locacao = MDL.id_empresa
   WHERE
   MO.id_equipamento = ".$_GET['id_equip'].";";

   $result_traz_office = $conn->query($traz_office);

   if($row_traz_office = mysqli_fetch_assoc($result_traz_office)){
      echo "<div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <input class='span3' type='text' name='office' value='".$row_traz_office['office']."'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Fornecedor:</label>                  
               <div class='controls'>
                  <input class='span4' type='text' name='fornecedor_office' value='".$row_traz_office['fornecedor']."'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Locacao:</label>
               <div class='controls'>
                  <select id='t_cob' name='local_office' class='span3'>
                     <option value='".$row_traz_office['IDlocacao_office']."'>".$row_traz_office['locacao_office']."</option>
                     <option>---</option>";
                        while ($row_officeE = $resultado_empresa->fetch_assoc()) {
                        echo "<option value='".$row_officeE['id_empresa']."'>".$row_officeE['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Empresa:</label>
               <div class='controls'>
                  <select id='t_cob' name='empresa_office' class='span3'>
                     <option value='".$row_traz_office['IDempresa_office']."'>".$row_traz_office['empresa_office']."</option>
                     <option>---</option>";
                        while ($row_officeEM= $resultado_empresa->fetch_assoc()) {
                        echo "<option value='".$row_officeEM['id_empresa']."'>".$row_officeEM['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Chave Key:</label>
               <div class='controls'>
                  <input class='cpfcnpj span4' type='text' name='serial_office' value='".$row_traz_office['serial']."'/>
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

            echo $buscando_usuario;
            $result_search_user = $conn->query($buscando_usuario);

            while($row_search = mysqli_fetch_assoc($result_search_user)){

                  if($row_search['id_office'] == NULL){
                     echo "<option value='".$row_search['id_equipamento']."'>".$row_search['patrimonio']."</option>";
                  }//end IF equipamento sem office
               }//end While equipamento que recebera o OFFICE   

               echo "</select>                     
               <i class='icon-lithe icon-question-sign' title='Equipamento que irá receber o Office!'></i>
            </div>
         </div>";
   }//end IF trazendo Office



?>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>

        </form>
    </div>
</div>

</html>
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
<!--AUTO PREENCHIMENTO DO CAMPO FORNECEDOR-->
<script src="../js/autocomplete_f.js"></script>
<!--MASCARA MAIUSCULA-->
<script type="text/javascript">
// INICIO FUNÇÃO DE MASCARA MAIUSCULA
function maiuscula(z) {
    v = z.value.toUpperCase();
    z.value = v;
}
//FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>
<?php $conn->close(); ?>