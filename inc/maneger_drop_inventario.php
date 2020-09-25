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
  require_once('header.php');
  require_once('../query/query_dropdowns.php');

?>
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li>
                    <a href="maneger_conf.php"><i class="icon-user"></i>
                        <span>Usuários</span>
                    </a>
                </li>
                <li class="active">
                    <a href="maneger_drop.php"><i class="icon-list-alt"></i>
                        <span>Drop-Downs</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="widget ">
<div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i> <a href="maneger.php">&nbsp; Home</a>
            /
            <i class="icon-lithe icon-wrench"></i> <a href="maneger_conf.php">&nbsp; Configurações</a>
            /
            <i class="icon-lithe icon-list-alt"></i> <a href="javascript:">&nbsp; Drop-Downs</a>
        </h3>
    </div>
    <!--ALERTAS-->
    <?php

      if ($_SESSION['id_menu'] != NULL) {
        echo 
          "<div class='alert'>
            <button type='button' class='close' data-dismiss='alert'>×</button>
            <strong>ATENÇÃO!</strong> Esse menu já está cadastrado no sistema.
          </div>";
        unset($_SESSION['id_menu']);
      }

      if ($_SESSION['salvo'] != NULL) {
        echo 
          "<div class='alert alert-success'>
              <button type='button' class='close' data-dismiss='alert'>×</button>
              <strong>ATENÇÃO!</strong> Menu cadastrado com sucesso!.
          </div>";
        unset($_SESSION['salvo']);
      }

      if ($_SESSION['edit'] != NULL) {
        echo 
          "<div class='alert alert-success'>
              <button type='button' class='close' data-dismiss='alert'>×</button>
              <strong>ATENÇÃO!</strong> Menu editado com sucesso!.
          </div>";
        unset($_SESSION['edit']);
      }
      if ($_SESSION['exc'] != NULL) {
        echo 
          "<div class='alert alert-success'>
              <button type='button' class='close' data-dismiss='alert'>×</button>
              <strong>ATENÇÃO!</strong> Menu excluido com sucesso!.
          </div>";
        unset($_SESSION['exc']);
      }
      ?>
    <!--FIM ALERTAS-->
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#funcao" data-toggle="tab">Função</a></li>
                <li><a href="#departamento" data-toggle="tab">Departamento</a></li>
                <li><a href="#empresa_filial" data-toggle="tab">Empresa</a></li>
                <li><a href="#locacao" data-toggle="tab">Locacão</a></li>
                <li><a href="#status_colaborador" data-toggle="tab">Status do Colaborador</a></li>
                <li><a href="#equipamentos" data-toggle="tab">Equipamentos</a></li>
                <li><a href="#situacao" data-toggle="tab">Situação</a></li>
                <li><a href="#estado" data-toggle="tab">Estado</a></li>
                <li><a href="#acessorios" data-toggle="tab">Acessorios</a></li>
                <li><a href="#operadora" data-toggle="tab">Operadora</a></li>
                <li><a href="#status_equipamento" data-toggle="tab">Status de Equipamento</a></li>
                <li><a href="#office" data-toggle="tab">Office</a></li>
                <li><a href="#windows" data-toggle="tab">Sistema Operacional</a></li>
            </ul>
            <br>
            <div class="tab-content">
                <!--FUNÇÃO-->
                <div class="tab-pane active" id="funcao">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddFuncao' role="button" class="btn btn-info pull-left filho"
                                            title="Nova Função" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_equipamento = $resultado_funcao->fetch_assoc()) {                                 
                                      echo "
                                       <tr>
                                          <td>".$row_equipamento['id_funcao']."</td>
                                          <td>".$row_equipamento['nome']."</td>
                                          <!--AÇÃO-->
                                          <td class='td-actions'>
                                            <a href='#modalEditarF".$row_equipamento['id_funcao']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirF".$row_equipamento['id_funcao']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarF".$row_equipamento['id_funcao']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_equipamento['id_funcao']."' style='display:none' name='id_funcao'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Função:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_funcao' onkeyup='maiuscula(this)' value='".$row_equipamento['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirF".$row_equipamento['id_funcao']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_equipamento['id_funcao']."' style='display:none' name='id_funcao'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir a função: <b>".$row_equipamento['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>";
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
                <!--DEPARTAMENTO-->
                <div class="tab-pane" id="departamento">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAdddepart' role="button" class="btn btn-info pull-left filho"
                                            title="Novo Departamento" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_departamento = $resultado_depart->fetch_assoc()) {
                                      echo "
                                       <tr>
                                          <td>".$row_departamento['id_depart']."</td>
                                          <td>".$row_departamento['nome']."</td>
                                          <!--AÇÃO-->
                                          <td class='td-actions'>
                                            <a href='#modalEditarD".$row_departamento['id_depart']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirD".$row_departamento['id_depart']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                        <!-- MODAL EDITAR -->
                                        <div id='modalEditarD".$row_departamento['id_depart']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>Editar</h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                                <input value='".$row_departamento['id_depart']."' style='display:none' name='id_depart'/>
                                                <div class='control-group'>
                                                  <label class='control-label'>Departamento:</label>
                                                  <div class='controls'>
                                                      <input class='span2' type='text' name='name_departamento' onkeyup='maiuscula(this)' value='".$row_departamento['nome']."' required>
                                                  </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                  <button class='btn btn-primary'>Salvar</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- MODAL EXCLUIR -->
                                        <div id='modalExcluirD".$row_departamento['id_depart']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>
                                                <img src='img/alerta.png' style='width: 10%'/>
                                                ANTENÇÃO!
                                              </h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                                <input value='".$row_departamento['id_depart']."' style='display:none' name='id_depart'/>
                                                <div class='control-group'>
                                                  <p>Deseja excluir o departamento: <b>".$row_departamento['nome']."</b></p>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                  <button class='btn btn-danger'>Sim</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                       </tr>";
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
                <!--EMPRESA/FILIAL-->
                <div class="tab-pane" id="empresa_filial">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddempresa' role="button" class="btn btn-info pull-left filho"
                                            title="Nova Empresa" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    while ($row_empresa = $resultado_empresa -> fetch_assoc($resultado_empresa)) {
                                      echo "
                                       <tr>
                                          <td>".$row_empresa['id_empresa']."</td>
                                          <td>".$row_empresa['nome']."</td>
                                          <!--AÇÃO-->
                                          <td class='td-actions'>
                                            <a href='#modalEditarE".$row_empresa['id_empresa']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirE".$row_empresa['id_empresa']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                        <!-- MODAL EDITAR -->
                                        <div id='modalEditarE".$row_empresa['id_empresa']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>Editar</h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                                <input value='".$row_empresa['id_empresa']."' style='display:none' name='id_empresa'/>
                                                <div class='control-group'>
                                                  <label class='control-label'>Empresa/Filial:</label>
                                                  <div class='controls'>
                                                      <input class='span2' type='text' name='name_empresa' onkeyup='maiuscula(this)' value='".$row_empresa['nome']."' required>
                                                  </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                  <button class='btn btn-primary'>Salvar</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- MODAL EXCLUIR -->
                                        <div id='modalExcluirE".$row_empresa['id_empresa']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>
                                                <img src='img/alerta.png' style='width: 10%'/>
                                                ANTENÇÃO!
                                              </h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                                <input value='".$row_empresa['id_empresa']."' style='display:none' name='id_empresa'/>
                                                <div class='control-group'>
                                                  <p>Deseja excluir a empresa/filial: <b>".$row_empresa['nome']."</b></p>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                  <button class='btn btn-danger'>Sim</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                       </tr>";
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
                <!--LOCAÇÃO-->
                <div class="tab-pane" id="locacao">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddlocacao' role="button" class="btn btn-info pull-left filho"
                                            title="Nova Empresa" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    while ($row_locacao = $resultado_empresa->fetch_assoc()) {
                                      echo "
                                       <tr>
                                          <td>".$row_locacao['id_empresa']."</td>
                                          <td>".$row_locacao['nome']."</td>
                                          <!--AÇÃO-->
                                          <td class='td-actions'>
                                            <a href='#modalEditarLo".$row_locacao['id_empresa']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirLo".$row_locacao['id_empresa']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                        <!-- MODAL EDITAR -->
                                        <div id='modalEditarLo".$row_locacao['id_empresa']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>Editar</h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                                <input value='".$row_locacao['id_empresa']."' style='display:none' name='id_locacao'/>
                                                <div class='control-group'>
                                                  <label class='control-label'>Locação:</label>
                                                  <div class='controls'>
                                                      <input class='span2' type='text' name='name_locacao' onkeyup='maiuscula(this)' value='".$row_locacao['nome']."' required>
                                                  </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                  <button class='btn btn-primary'>Salvar</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- MODAL EXCLUIR -->
                                        <div id='modalExcluirLo".$row_locacao['id_empresa']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>
                                                <img src='img/alerta.png' style='width: 10%'/>
                                                ANTENÇÃO!
                                              </h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                                <input value='".$row_locacao['id_empresa']."' style='display:none' name='id_locacao'/>
                                                <div class='control-group'>
                                                  <p>Deseja excluir a locacao: <b>".$row_locacao['nome']."</b></p>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                  <button class='btn btn-danger'>Sim</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                       </tr>";
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
                <!--STATUS DO COLABORADOR-->
                <div class="tab-pane" id="status_colaborador">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddStatusColaborador' role="button"
                                            class="btn btn-info pull-left filho" title="Novo Status"
                                            data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_status = $resultado_statusFun->fetch_assoc()) {
                                       echo "
                                       <tr>
                                          <td>".$row_status['id_status']."</td>
                                          <td>".$row_status['nome']."</td>
                                          <!--AÇÃO-->
                                          <td class='td-actions'>
                                            <a href='#modalEditarSC".$row_status['id_status']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirSC".$row_status['id_status']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                        <!-- MODAL EDITAR -->
                                        <div id='modalEditarSC".$row_status['id_status']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>Editar</h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                                <input value='".$row_status['id_status']."' style='display:none' name='id_status'/>
                                                <div class='control-group'>
                                                  <label class='control-label'>Status Colaborador:</label>
                                                  <div class='controls'>
                                                      <input class='span2' type='text' name='name_status_colaborador' onkeyup='maiuscula(this)' value='".$row_status['nome']."' required>
                                                  </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                  <button class='btn btn-primary'>Salvar</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- MODAL EXCLUIR -->
                                        <div id='modalExcluirSC".$row_status['id_status']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                          <div id='filho'> 
                                            <div class='modal-body'>
                                              <h3 id='myModalLabel'>
                                                <img src='img/alerta.png' style='width: 10%'/>
                                                ANTENÇÃO!
                                              </h3>
                                              <hr>
                                              <br>
                                              <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                                <input value='".$row_status['id_status']."' style='display:none' name='id_status'/>
                                                <div class='control-group'>
                                                  <p>Deseja excluir o Status: <b>".$row_status['nome']."</b></p>
                                                </div>
                                                <br>
                                                <hr>
                                                <div id='button_filho'>
                                                  <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                  <button class='btn btn-danger'>Sim</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                       </tr>";
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
                <!--EQUIPAMENTOS-->
                <div class="tab-pane" id="equipamentos">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddequipamento' role="button"
                                            class="btn btn-info pull-left filho" title="Novo Equipamento"
                                            data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_equipamentos = $resultado_equip->fetch_assoc()) {
                                      echo "
                                     <tr>
                                        <td>".$row_equipamentos['id_equip']."</td>
                                        <td>".$row_equipamentos['nome']."</td>
                                            <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarEQ".$row_equipamentos['id_equip']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirEQ".$row_equipamentos['id_equip']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarEQ".$row_equipamentos['id_equip']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_equipamentos['id_equip']."' style='display:none' name='id_equip'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Equipamento:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_equipamentos' onkeyup='maiuscula(this)' value='".$row_equipamentos['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirEQ".$row_equipamentos['id_equip']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_equipamentos['id_equip']."' style='display:none' name='id_equip'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir o Equipamento: <b>".$row_equipamentos['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
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
                <!--SITUAÇÃO-->
                <div class="tab-pane" id="situacao">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalSituacao' role="button" class="btn btn-info pull-left filho"
                                            title="Nova Situação" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                                      echo "
                                     <tr>
                                        <td>".$row_situacao['id_situacao']."</td>
                                        <td>".$row_situacao['nome']."</td>
                                            <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarST".$row_situacao['id_situacao']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirST".$row_situacao['id_situacao']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarST".$row_situacao['id_situacao']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_situacao['id_situacao']."' style='display:none' name='id_situacao'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Situação:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_situacao' onkeyup='maiuscula(this)' value='".$row_situacao['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirST".$row_situacao['id_situacao']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_situacao['id_situacao']."' style='display:none' name='id_situacao'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir a situação: <b>".$row_situacao['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
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
                <!--ESTADO-->
                <div class="tab-pane" id="estado">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalEstado' role="button" class="btn btn-info pull-left filho"
                                            title="Novo Estado" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    while ($row_estado = $resultado_status->fetch_assoc()) {
                                      echo "
                                     <tr>
                                        <td>".$row_estado['id']."</td>
                                        <td>".$row_estado['nome']."</td>
                                            <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarEST".$row_estado['id']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirEST".$row_estado['id']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarEST".$row_estado['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_estado['id']."' style='display:none' name='id_estado'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Estado:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_estado' onkeyup='maiuscula(this)' value='".$row_estado['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirEST".$row_estado['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_estado['id']."' style='display:none' name='id_estado'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir o estado: <b>".$row_estado['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
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
                <!--ACESSORIOS-->
                <div class="tab-pane" id="acessorios">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddacessorios' role="button" class="btn btn-info pull-left filho"
                                            title="Novo Acessorio" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    while ($row_acessorios = $resultado_acessorio->fetch_assoc()) {
                                    echo "
                                     <tr>
                                        <td>".$row_acessorios['id_acessorio']."</td>
                                        <td>".$row_acessorios['nome']."</td>
                                            <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarA".$row_acessorios['id_acessorio']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirA".$row_acessorios['id_acessorio']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarA".$row_acessorios['id_acessorio']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_acessorios['id_acessorio']."' style='display:none' name='id_acessorio'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Acessorio:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_acessorios' onkeyup='maiuscula(this)' value='".$row_acessorios['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirA".$row_acessorios['id_acessorio']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_acessorios['id_acessorio']."' style='display:none' name='id_acessorio'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir o Acessorio: <b>".$row_acessorios['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
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
                <!--OPERADORA-->
                <div class="tab-pane" id="operadora">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddoperadora' role="button" class="btn btn-info pull-left filho"
                                            title="Nova Operadora" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                   while ($row_operadora = $resultado_operadora -> fetch_assoc()) {
                                    echo "
                                     <tr>
                                        <td>".$row_operadora['id_operadora']."</td>
                                        <td>".$row_operadora['nome']."</td>
                                        <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarA".$row_operadora['id_operadora']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirA".$row_operadora['id_operadora']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarA".$row_operadora['id_operadora']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_operadora['id_operadora']."' style='display:none' name='id_operadora'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Operadora:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_operadora' onkeyup='maiuscula(this)' value='".$row_operadora['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirA".$row_operadora['id_operadora']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_operadora['id_operadora']."' style='display:none' name='id_operadora'/>
                                              <div class='control-group'>
                                                <p>Deseja excluir a operadora: <b>".$row_operadora['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
                                      }
                                  ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--STATUS DE EQUIPAMENTO-->
                <div class="tab-pane" id="status_equipamento">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddStatusEquipamento' role="button"
                                            class="btn btn-info pull-left filho" title="Novo Status"
                                            data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                    while ($row_Sequipamento = $resultado_status_equip->fetch_assoc()) {
                                    echo "
                                     <tr>
                                        <td>".$row_Sequipamento['id_status']."</td>
                                        <td>".$row_Sequipamento['nome']."</td>
                                        <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarSE".$row_Sequipamento['id_status']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirSE".$row_Sequipamento['id_status']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarSE".$row_Sequipamento['id_status']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_Sequipamento['id_status']."' style='display:none' name='id_status'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Status Equipamento:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_status_equipamento' onkeyup='maiuscula(this)' value='".$row_Sequipamento['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirSE".$row_Sequipamento['id_status']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_Sequipamento['id_status']."' style='display:none' name='id_status'/>
                                              <div class='control-group'>
                                                <p>Status Equipamento: <b>".$row_Sequipamento['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
                                     }
                                  ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--OFFICE-->
                <div class="tab-pane" id="office">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddOffice' role="button" class="btn btn-info pull-left filho"
                                            title="Nova versao office" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                    while ($row_office = $resultado_office->fetch_assoc()) {
                                    echo "
                                     <tr>
                                        <td>".$row_office['id']."</td>
                                        <td>".$row_office['nome']."</td>
                                        <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarOF".$row_office['id']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirOF".$row_office['id']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarOF".$row_office['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_office['id']."' style='display:none' name='id_office'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Office:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_office' onkeyup='maiuscula(this)' value='".$row_office['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirOF".$row_office['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_office['id']."' style='display:none' name='id_office'/>
                                              <div class='control-group'>
                                                <p>Office: <b>".$row_office['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
                                     }
                                  ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--WINDOWS-->
                <div class="tab-pane" id="windows">
                    <div class="span3" style="width: 25%;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href='#modalAddWindows' role="button" class="btn btn-info pull-left filho"
                                            title="Novo Sistema Operacional" data-toggle="modal">
                                            <i class='btn-icon-only icon-plus inventario'></i>
                                        </a>
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
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                    while ($row_windows = $resultado_so->fetch_assoc()) {
                                    echo "
                                     <tr>
                                        <td>".$row_windows['id']."</td>
                                        <td>".$row_windows['nome']."</td>
                                        <!--AÇÃO-->
                                        <td class='td-actions'>
                                            <a href='#modalEditarSO".$row_windows['id']."' class='btn btn-small btn-success' title='Editar' data-toggle='modal'>
                                              <i class='btn-icon-only icon-edit'> </i>
                                            </a>
                                            <a href='#modalExcluirSO".$row_windows['id']."' class='btn btn-danger btn-small' title='Excluir' data-toggle='modal'>
                                              <i class='btn-icon-only icon-remove'> </i>
                                            </a>
                                          </td>
                                       </tr>
                                      <!-- MODAL EDITAR -->
                                      <div id='modalEditarSO".$row_windows['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 23%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>Editar</h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='edit_drop.php' method='post'>
                                              <input value='".$row_windows['id']."' style='display:none' name='id_windows'/>
                                              <div class='control-group'>
                                                <label class='control-label'>Sistema Operacional:</label>
                                                <div class='controls'>
                                                    <input class='span2' type='text' name='name_windows' onkeyup='maiuscula(this)' value='".$row_windows['nome']."' required>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                                                <button class='btn btn-primary'>Salvar</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- MODAL EXCLUIR -->
                                      <div id='modalExcluirSO".$row_windows['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='width: 33%;'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <div id='filho'> 
                                          <div class='modal-body'>
                                            <h3 id='myModalLabel'>
                                              <img src='img/alerta.png' style='width: 10%'/>
                                              ANTENÇÃO!
                                            </h3>
                                            <hr>
                                            <br>
                                            <form id='edit-profile' class='form-horizontal' action='exc_drop.php' method='post'>
                                              <input value='".$row_windows['id']."' style='display:none' name='id_windows'/>
                                              <div class='control-group'>
                                                <p>Sistema Operacional: <b>".$row_windows['nome']."</b></p>
                                              </div>
                                              <br>
                                              <hr>
                                              <div id='button_filho'>
                                                <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                <button class='btn btn-danger'>Sim</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                     </tr>";
                                     }
                                  ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--FIM opções-->
            </div>
        </div>
    </div>
</div>


<!--INICIO DOS MODAIS-->
<!-- Adicionar Funcão -->
<div id='modalAddFuncao' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Função</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Função:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_funcao" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Office -->
<div id='modalAddOffice' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Versão - Office</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Office:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_office" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Windows -->
<div id='modalAddWindows' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Versão - Sistema Operacional</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Sistema Operacional:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_windows" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Departamento -->
<div id='modalAdddepart' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Novo Departamento</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Departamento:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_departamento" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Empresa -->
<div id='modalAddempresa' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Empresa / Filial</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Empresa/Filial:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_empresa" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar locacao -->
<div id='modalAddlocacao' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Locacao</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Locacao:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_locacao" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Status Colaborador -->
<div id='modalAddStatusColaborador' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Status Colaborador</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Status Colaborador:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_status_colaborador" onkeyup='maiuscula(this)'
                            required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Equipamento -->
<div id='modalAddequipamento' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Novo Tipo de Equipamento</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Equipamento:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_equipamentos" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Situação -->
<div id='modalSituacao' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Situação</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Situação:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_situacao" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Estado -->
<div id='modalEstado' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Novo Estado</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Estado:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_estado" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Acessorio -->
<div id='modalAddacessorios' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Novo Acessorio</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Acessorio:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_acessorios" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Operadora -->
<div id='modalAddoperadora' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Nova Operadora</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Operadora:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_operadora" onkeyup='maiuscula(this)' required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adicionar Status Equipamento -->
<div id='modalAddStatusEquipamento' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <div id='filho'>
        <div class='modal-body'>
            <h3 id='myModalLabel'>Novo Status de Equipamento</h3>
            <hr>
            <br>
            <form id='edit-profile' class='form-horizontal' action='new_drop.php' method='post'>
                <div class="control-group">
                    <label class="control-label">Estatus Equipamento:</label>
                    <div class="controls">
                        <input class="span2" type="text" name="name_status_equipamento" onkeyup='maiuscula(this)'
                            required>
                    </div>
                </div>
                <br>
                <hr>
                <div id='button_filho'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--FIM MODALS-->
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