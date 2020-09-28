<?php
//aplicando para usar variavel em outro arquivo
session_start();

//chamando conexão com o banco
require_once('../conexao/conexao.php');
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
    header('location: ../front/error.php');
}

//LIMITE POR PAGINA
$pagina = 20;


//colentando as mensagens
$mensagem = "SELECT * FROM manager_comparacao_ocs limit " . $pagina . " ";
$resultado_mensagem = $conn->query($mensagem);

//contando quantos mensagens existem
$contador_msn = "SELECT COUNT(id) AS quantidade FROM manager_comparacao_ocs";
$result_contador = $conn->query($contador_msn);
$row_contador = $result_contador->fetch_assoc();

require_once('header.php');
require_once('../query/query_dropdowns.php');

?>
<style>
    select.form-control.form-control-sm {
        margin-bottom: -51px;
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

<?php

switch ($_GET['msn']) {
    case '1':
        echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Informação!</strong> Ocorrência resolvida com sucesso!</div>";
        break;

    case '2':
        echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>ATENÇÃO!</strong> Você deverá escolher no minimo um critério para pesquisa</div>";
        break;
}

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
            <i class="icon-lithe icon-list"></i>&nbsp;
            Relatórios
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#contratos" data-toggle="tab">Por Colaborador</a>
                </li>
                <li>
                    <a href="#equipamento" data-toggle="tab">Por Equipamentos</a>
                </li>
                <li>
                    <a href="#nota" data-toggle="tab">Por Nota Fiscal</a>
                </li>
            </ul>
            <br>
            <div class="tab-content">
                <!--POR COLABORADOR-->
                <div class="tab-pane active" id="contratos">
                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_func.php" method="GET" autocomplete='off'>
                        <input value="2" type="text" style="display: none;" name="relatorios">
                        <div class="control-group">
                            <label class="control-label required">Nome Completo:</label>
                            <div class="controls">
                                <input class='span6' name='nome' type='text' onkeyup='maiuscula(this)' value='' />
                            </div>
                        </div>
                        <label class="control-label required" for='gols1' class="control-label">CPF Funcionário:</label>
                        <div class="control-group">
                            <div class="controls">
                                <input name='cpf' id='cpf' class='cpfcnpj span2' type='text' onkeydown='javascript: fMasc( this, mCPF );' />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Função:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='func' class='span2'>                            
                              <option value=''>---</option>";
                                while ($row_funcao = $resultado_funcao->fetch_assoc()) {
                                    echo "<option value='" . $row_funcao['id_funcao'] . "'>" . $row_funcao['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Departamento:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='dep' class='span2'>                            
                              <option value=''>---</option>";
                                while ($row_depart = $resultado_depart->fetch_assoc()) {
                                    echo "<option value='" . $row_depart['id_depart'] . "'>" . $row_depart['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label required">Empresa/Filial:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='em' class='span2'>
                            <option value=''>---</option>";
                                while ($row_emp = $resultado_empresa->fetch_assoc()) {
                                    echo "<option value='" . $row_emp['id_empresa'] . "'>" . $row_emp['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--Campos Escondidos-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                        </div>
                    </form>
                </div>

                <!--POR EQUIPAMENTOS-->
                <div class="tab-pane" id="equipamento">

                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_equip.php" method="GET" autocomplete='off'>
                        <input value="1" type="text" style="display: none;" name="relatorios">
                        <div class="control-group">
                            <label class="control-label required">Tipo de equipamento:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='eq' class='span2'>
                              <option value=''>---</option>";
                                //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                $query_equip = "SELECT * from manager_dropequipamentos WHERE id_equip IN (9, 5, 8) AND deletar = 0 order by nome ASC;";
                                $resultado_equip = $conn->query($query_equip);
                                while ($row_equip = mysqli_fetch_assoc($resultado_equip)) {
                                    echo "<option value='" . $row_equip['id_equip'] . "'>" . $row_equip['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Status:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='se' class='span2'>
                              <option value=''>---</option>";
                                //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                $query_status = "SELECT * from manager_dropstatusequipamento WHERE id_status IN (1, 10, 6) AND deletar = 0 order by nome ASC;";
                                $resultado_status = $conn->query($query_status);
                                while ($row_status = mysqli_fetch_assoc($resultado_status)) {
                                    echo "<option value='" . $row_status['id_status'] . "'>" . $row_status['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Filial / Empresa:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='fi' class='span2'>
                              <option value=''>---</option>";
                                $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
                                $resultado_filial = $conn->query($query_empresa);
                                while ($row_filial = $resultado_filial->fetch_assoc()) {
                                    echo "<option value='" . $row_filial['id_empresa'] . "'>" . $row_filial['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--Campos Escondidos-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!--POR NOTA FISCAL-->
                <div class="tab-pane" id="nota">

                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_nota.php" method="GET" autocomplete='off'>
                        <input value="3" type="text" style="display: none;" name="relatorios">
                        <div class="control-group">
                            <label class="control-label required">Número Nota Fiscal:</label>
                            <div class="controls">
                                <input class='span2' name='numero_nota' type='text' />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Filial:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='filial' class='span2'>
                              <option value=''>---</option>";

                                $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
                                $resultado_empresa = $conn->query($query_empresa);
                                while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                    echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label required">Data Nota Fiscal:</label>
                            <div class="controls">
                                <input class='span2' oninput="datahabilitar()" name='inicio_data' type='date' /> até
                                <input class='span2' id="btn1" name='fim_data' type='date' disabled/>
                            </div>
                        </div>
                        <!--Campos Escondidos-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela_mensagem1.js"></script>
<script src="../js/tabela_mensagem.js"></script>

<script>
function datahabilitar(e) { document.getElementById('btn1').disabled = false; }
</script>
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../js/cnpj.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<script src="../js/tabela_relatorio_tecnico.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable(

            {

                "aLengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "All"]
                ],
                "iDisplayLength": 5
            }
        );
    });


    function checkAll(bx) {

        var cbs = document.getElementsByTagName('input');

        for (var i = 0; i < cbs.length; i++) {
            if (cbs[i].type == 'checkbox') {
                cbs[i].checked = bx.checked;
            }
        }

        var text = document.getElementById('confirmar');
        var checkBox = document.getElementById('check');

        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }

    function checkOne(id) {
        var check = document.getElementById('check_msn');
        var confirmar = document.getElementById('confirmar');

        if (check.checked == true) {
            confirmar.style.display = "block";
        } else {
            confirmar.style.display = "none";
        }
    }
</script>

<?php $conn->close(); ?>

</html>