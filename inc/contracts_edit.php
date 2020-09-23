<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif ($_SESSION["perfil"] != 0 AND $_SESSION["perfil"] != 1) {
       header('location: ../front/error.php');
   }
   
   //recebendo a informação e distribuindo nos campos do formulario
   $query_contrato = "SELECT * FROM manager_contracts WHERE id = ".$_GET['id']."";
   $resultado = $conn -> query($query_contrato);
   $row = $resultado -> fetch_assoc();

   require_once('header.php');

?>
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="active">
                    <a href="contracts.php"><i class="icon-folder-close"></i>
                        <span>Contratos</span>
                    </a>
                </li>
                <li>
                    <a href="error.php"><i class="icon-list-alt"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <h3>
                                <i class="icon-lithe icon-home"></i> <a href="manager.php">Home</a>
                                /
                                <a href="contracts.php">Contratos</a>
                                /
                                <?= $row['name'] ?>
                            </h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#contratos" data-toggle="tab">Contrato</a>
                                    </li>
                                    <li><a href="#contFilhos" data-toggle="tab">Contratos Filhos</a></li>
                                    <li><a href="#anexos" data-toggle="tab">Anexos</a></li>
                                </ul>
                                <br>
                                <div class="tab-content">
                                    <!--CONTRATOS-->
                                    <div class="tab-pane active" id="contratos">
                                        <form id="edit-profile" class="form-horizontal" action="contracts_update.php"
                                            method="post">
                                            <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                                            <input type="text" name="id_contrato" style="display: none;"
                                                value="<?= $_GET['id'] ?>">
                                            <!--fim da gambiarra-->
                                            <div class="control-group">
                                                <label class="control-label">Nome completo:</label>
                                                <div class="controls">
                                                    <input class="span6" name="nome" type="text"
                                                        onkeyup='maiuscula(this)' required
                                                        value="<?= $row['name'] ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Numero:</label>
                                                <div class="controls">
                                                    <input class="span3" type="number" name="numero_contrato"
                                                        value="<?= $row['number'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipo de contrato:</label>
                                                <div class="controls">
                                                    <select id="t_cont" name="t_contrato" class="span2">
                                                        <option value="<?= $row['type'] ?>"><?= $row['type'] ?></option>
                                                        <option value="Telefonia">Telefonia</option>
                                                        <option value="Terceiros">Terceiros</option>
                                                        <option value="Outros">Outros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">CNPJ fornecedor:</label>
                                                <div class="controls">
                                                    <input class="cpfcnpj span2" type="text" name="cnpj_forne"
                                                        value="<?= $row['cnpj_branch'] ?>" required />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">CNPJ master:</label>
                                                <div class="controls">
                                                    <input class="cpfcnpj span2" type="text" name="cnpj_master"
                                                        value="<?= $row['cnpj'] ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipo de cobrança:</label>
                                                <div class="controls">
                                                    <select id="t_cob" name="t_cobranca" class="span2" required>
                                                        <option value="<?= $row['type_collection'] ?>">
                                                            <?= $row['type_collection'] ?></option>
                                                        <option value="Anual">Anual</option>
                                                        <option value="Mensal">Mensal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Setor:</label>
                                                <div class="controls">
                                                    <select id="setor_1" name="setor" class="span2">
                                                        <option value="<?= $row['department'] ?>">
                                                            <?= $row['department']  ?></option>
                                                        <option value="CPD">CPD</option>
                                                        <option value="CSC">CSC</option>
                                                        <option value="Caixa">Caixa</option>
                                                        <option value="Vendas Novos">Vendas Novos</option>
                                                        <option value="Vendas Seminovos">Vendas Seminovos</option>
                                                        <option value="Todos">Todos</option>
                                                    </select>
                                                    <i class="icon-lithe icon-question-sign"
                                                        title="Setor que irá desfrutar do beneficio"></i>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Data inicial:</label>
                                                <div class="controls">
                                                    <input class="span2" id="data-contrato" type="date"
                                                        name="data_contrato" value="<?= $row['date_start'] ?>"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Responsavel contrato:</label>
                                                <div class="controls">
                                                    <input id="responsavel_1" type="text" name="responsavel"
                                                        onkeyup='maiuscula(this)'
                                                        value="<?= $row['contracts_responsible'] ?>" required />
                                                    <i class="icon-lithe icon-question-sign"
                                                        title="Responsavel que irá responder pelo contrato"></i>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">E-mail:</label>
                                                <div class="controls">
                                                    <input id="email_vencimento" type="email" name="email_v"
                                                        value="<?= $row['mail_responsible'] ?>" required />
                                                    <i class="icon-lithe icon-question-sign"
                                                        title="Irá receber alerta deste contrato"></i>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Descrição:</label>
                                                <div class="controls">
                                                    <textarea id="desc_resumo" type="text"
                                                        name="desc_resumo"><?= $row['description'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--CONTRATOS FILHOS-->
                                    <div class="tab-pane" id="contFilhos">
                                        <div class="span12" style="width: 1080px;">
                                            <div class="widget stacked widget-table action-table">
                                                <div class="widget-header">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <!-- Button to trigger modal -->
                                                            <a href="#myModalfilho" role="button"
                                                                class="btn btn-info pull-left filho"
                                                                data-toggle="modal">Adicionar Novo</a>
                                                        </div>
                                                        <!-- /control-group -->
                                                    </div>
                                                </div>
                                                <!-- /widget-header -->
                                                <div class="widget-content">
                                                    <table id="example" class="table table-striped table-bordered"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="titulo">Nº Contrato</th>
                                                                <th class="titulo">CNPJ</th>
                                                                <th class="titulo">Valor</th>
                                                                <th class="titulo">Data</th>
                                                                <th class="titulo">Tempo de Carência</th>
                                                                <th class="titulo">Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                   //conectando com o bando de dados
                                                   //criando a pesquisa 
                                                   $query = "SELECT * FROM manager_contracts_son WHERE contracts_father = ".$_GET['id']." AND deleted = 0"; //0 = ativo, 1 = desativado
                                                   //Criando a pesquisa para contagem
                                                   //aplicando a regra e organizando na tela
                                                   if ($resultado = $conn -> query($query)){
                                                       
                                                           while($row = $resultado -> fetch_assoc()){
                                                               
                                                               echo "<tr>
                                                                       <td class='fonte'>".$row['number_contract']."</td>
                                                                       <td class='fonte'>".$row['cnpj']."</td>
                                                                       <td class='fonte'>".$row['value']."</td>                            
                                                                       <td class='fonte'>".$row['data_due']."</td>
                                                                       <td class='fonte'>".$row['temp_lack']."</td>
                                                                       <td class='fonte'>
                                                                        <a href='#myModalfilhoeditar".$row['id_son']."' class='btn btn-small btn-primary' title='Editar' data-toggle='modal'>
                                                                         <i class='btn-icon-only icon-edit'></i>
                                                                         </a>
                                                                         <a href='#myModalfilhoexcluir".$row['id_son']."' class='btn btn-small' title='Excluir' data-toggle='modal'>
                                                                         <i class='btn-icon-only icon-remove'></i>
                                                                         </a>
                                                                       </td>
                                                                   </tr>
                                                                    <!-- Modal FILHO EDITAR -->
                                                   <div id='myModalfilhoeditar".$row['id_son']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                   <div class='modal-header'>
                                                   <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                   <h3 id='myModalLabel'>Editando o Contrato numero: ".$row['number_contract']."</h3>
                                                   </div>
                                                   <div class='modal-body'>
                                                   <!--Colocar a tabela Aqui!-->
                                                   <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                                                   <!--GAMBIARRA BASICA-->
                                                   <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                                                   <input type='text' name='id_contrato' style='display: none' value='".$_GET['id']."'>
                                                   <input name='id_son' value='".$row['id_son']."' style='display: none;'/>
                                                   <div class='control-group'>
                                                   <label class='control-label'>Nº Contrato</label>
                                                   <div class='controls'>
                                                   <input class='cpfcnpj span2' type='text' name='number_son' value='".$row['number_contract']."' required/>
                                                   </div>
                                                   </div>
                                                   <div class='control-group'>
                                                   <label class='control-label'>CNPJ fornecedor:</label>
                                                   <div class='controls'>
                                                   <input class='cpfcnpj span2' type='text' name='cnpj_son' value='".$row['cnpj']."' required/>
                                                   </div>
                                                   </div>
                                                   <div class='control-group'>
                                                   <label class='control-label'>Valor:</label>
                                                   <div class='controls'>
                                                   <input class='cpfcnpj span2' type='text' name='value_son' value='".$row['value']."' required/>
                                                   </div>
                                                   </div>
                                                   <div class='control-group'>
                                                   <label class='control-label'>Data Vencimento:</label>
                                                   <div class='controls'>
                                                   <input class='cpfcnpj span2' type='date' name='data_son' value='".$row['data_due']."' required/>
                                                   </div>
                                                   </div>
                                                   <div class='control-group'>
                                                   <label class='control-label'>Tempo Carência:</label>
                                                   <div class='controls'>
                                                   <input class='cpfcnpj span2' type='number' name='temp_son' value='".$row['temp_lack']."' required/>
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
                                                   
                                                   <!-- Modal FILHO EXCLUIR -->
                                                   <div id='myModalfilhoexcluir".$row['id_son']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                                                                           
                                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                            <div id='filho'> 
                                                         <div class='modal-body'>
                                                            <h3 id='myModalLabel'>Deseja Excluir o Contrato <br>".$row['number_contract']."?</h3>
                                                         <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                                                   <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                                                   <input type='text' name='id_contrato' style='display: none' value='".$_GET['id']."'>
                                                   <!--GAMBIARRA BASICA-->
                                                   <input name='id_son_deleted' value='".$row['id_son']."' style='display: none;'/>
                                                   <div id='button_filho'>
                                                   <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                   <button class='btn btn-danger'>Sim</button>
                                                   </div>
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
                                    <!--ANEXOS-->
                                    <div class="tab-pane" id="anexos">
                                        <div class="span3" style="width: 802px;">
                                            <div class="widget stacked widget-table action-table">
                                                <div class="widget-header">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <!-- Button to trigger modal -->
                                                            <a href="#myModalanexos" role="button"
                                                                class="btn btn-info pull-left filho"
                                                                data-toggle="modal">Adicionar Novo</a>
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
                                                                <th>Documento</th>
                                                                <th>N. Contrato</th>
                                                                <th>CNPJ</th>
                                                                <th>Tipo</th>
                                                                <th>Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                //pesquisando os arquivos criados.
                                                $query_files = "SELECT id_file, name AS nome, number_contract AS numero, cnpj, type, file_way AS caminho FROM manager_contracts_file WHERE contracts_father = ".$_GET['id']." AND deleted = 0";
                                                 //identificando o tipo e selecionando uma imagem para ela
                                                   $type_pdf = 'application/pdf';
                                                   $type_word = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                                                if ($resultado_files = $conn -> query($query_files)) {
                                                  while ($row_files = $resultado_files -> fetch_assoc()) {
                                                     echo "    
                                                      <tr>
                                                         <td>
                                                            <a href='".$row_files['caminho']."' target='_blank'>".$row_files['nome']."</a>
                                                         </td>
                                                         <td>
                                                            ".$row_files['numero']."
                                                         </td>
                                                         <td>
                                                            ".$row_files['cnpj']."
                                                         </td>";
                                                         if ($row_files['type'] == $type_pdf) {// se for pdf mostra essa imagem
                                                            echo "<td class='type_doc_campo'>
                                                            <img src='img/signin/pdf.png' class='type_doc'/>
                                                         </td>";
                                                         }elseif ($row_files['type'] == $type_word) {
                                                            echo "<td class='type_doc_campo'>
                                                            <img src='img/signin/word.png' class='type_doc'/>
                                                         </td>";}// se for word mostra essa imagem
                                                           echo "<td class='td-actions'>                             
                                                            </a>
                                                            <a href='#myModalanexosedit".$row_files['id_file']."' class='btn btn-small' title='Excluir' data-toggle='modal'>
                                                            <i class='btn-icon-only icon-remove'></i>                            
                                                            </a>
                                                         </td>";
                                                         
                                                      echo "
                                                      </tr>

                                                      <!-- Modal FILE EXCLUIR -->
                                                   <div id='myModalanexosedit".$row_files['id_file']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                                                                           
                                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                            <div id='name_file'> 
                                                         <div class='modal-body'>
                                                            <h3 id='myModalLabel'>Deseja Excluir o anexo <br> ".$row_files['nome']."?</h3>
                                                         <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                                                   <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                                                   <input type='text' name='id_contrato' style='display: none' value='".$_GET['id']."'>
                                                   <!--GAMBIARRA BASICA-->
                                                   <input name='id_file_deleted' value='".$row_files['id_file']."' style='display: none;'/>
                                                   <div id='button_file'>
                                                   <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                   <button class='btn btn-danger'>Sim</button>
                                                   </div>
                                                   </div>
                                                   </form>
                                                         </div>
                                                         </div>



                                                      ";
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /widget-content -->
                </div>
                <!-- /widget -->
            </div>
            <!-- /span8 -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /main-inner -->
</div>
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
</body>
<!--MODAIS-->
<!-- Modal FILHO ADICIONAR -->
<div id="myModalfilho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Novo Contrato</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" enctype="multipart/form-data" class="form-horizontal" action="contracts_update.php"
            method="post">
            <!--Uma gambiarra para levar o id do contrato para a tela de update-->
            <input type="text" name="id_contrato" style="display: none;" value="<?=$_GET['id'] ?>">
            <div class="control-group">
                <label class="control-label">Nº Contrato</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="number" name="number_new_son" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">CNPJ fornecedor:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="text" name="new_cnpj_son" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Valor:</label>
                <div class="controls">
                    <input class="dinheiro span2" type="money" name="value_new" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Data Vencimento:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="date" name="date_new" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tempo Carência:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="number" name="temp_new" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Anexar Documento:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="file_new_son" />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
<!-- /controls -->

<!-- Modal ANEXOS ADICIONAR -->
<div id="myModalanexos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Novo Anexo</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="contracts_update.php"
            method="post">
            <!--Uma gambiarra para levar o id do contrato para a tela de update-->
            <input type="text" name="id_contrato" style="display:none ;" value="<?=$_GET['id'] ?>">
            <div class="control-group">
                <label class="control-label">Nº Contrato Filho:</label>
                <div class="controls">
                    <select name="contrato_filho_new">
                        <?php
                     $query_filhos = "SELECT number_contract FROM manager_contracts_son WHERE contracts_father = ".$_GET['id']." AND deleted = 0";
                     if ($resultado_filhos = $conn -> query($query_filhos)) {
                           echo "<option value=''>------<option>";
                        while ($row_filho = $resultado_filhos -> fetch_assoc()) {
                           echo "<option value='".$row_filho['number_contract']."'>".$row_filho['number_contract']."</option>";
                        }
                     }

                     $conn -> close() 
                     ?>
                    </select><i class="icon-lithe icon-question-sign"
                        title="Caso o documento não seja de um contrato filho, basta ignorar este campo"></i>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Anexo:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="file_new" required />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>

    </div>
</div>
</html>