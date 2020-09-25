<?php
//aplicando para usar varialve em outro arquivo
session_start();

//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
    header('location: ../front/error.php');
}

require_once('header.php'); 
require_once('../conexao/conexao.php');
require_once('../query/query_dropdowns.php')

?>
<div class="subnavbar">
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
                            <span>Colaborares</span>
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
</div>
<?= $_GET['erro'] == 1 ? "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Você deve escolher algum critério para a busca</div>" : "" ?>

<div class="widget ">
    <div class="widget-header">
        <h3>
            <a href="inventario_ti.php"><i class="icon-lithe icon-home"></i>&nbsp;
                Home
            </a>
            /
            Relatórios
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#colaborador" data-toggle="tab">Colaborador</a>
                </li>
                <li>
                    <a href="#equipamento" data-toggle="tab">Equipamentos</a>
                </li>
                <li>
                    <a href="#vigencia" data-toggle="tab">Data de vigência</a>
                </li>
            </ul>
            <br>
            <div class="tab-content">
                <!--COLABORADOR-->
                <div class="tab-pane active" id="colaborador">
                    <form id="edit-profile" class="form-horizontal" action="relatorio_func.php" method="GET"
                        autocomplete='off'>
                        <div class="control-group">
                            <label class="control-label required">Função:</label>
                            <div class="controls">
                                <select id='t_cob' name='funcao_funcionario' class='span2'>                            
                                    <option value=''>---</option>
                                    <?php
                                        while ($row_funcao = $resultado_funcao -> fetch_assoc()) {
                                            echo "<option value='" . $row_funcao['id_funcao'] . "'>" . $row_funcao['nome'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Departamento:</label>
                            <div class="controls">
                                <select id='t_cob' name='depart_funcionario' class='span2'>                            
                                    <option value=''>---</option>
                                    <?php
                                        while ($row_depart = $resultado_depart -> fetch_assoc()) {
                                            echo "<option value='" . $row_depart['id_depart'] . "'>" . $row_depart['nome'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label required">Empresa/Filial:</label>
                            <div class="controls">
                                <select id='t_cob' name='empresa_funcionario' class='span2'>
                                    <option value=''>---</option>
                                    <?php
                                        while ($row_empresa = $resultado_empresa -> fetch_assoc()) {
                                            echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Status:</label>
                            <div class="controls">
                                <select id='t_cob' name='status_funcionario' class='span2'>
                                    <option value=''>---</option>
                                    <?php
                                        while ($row_statusFun = $resultado_statusFun -> fetch_assoc()) {
                                            echo "<option value='" . $row_statusFun['id_status'] . "'>" . $row_statusFun['nome'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--Campos Escondidos-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                        </div>
                    </form>
                </div>

                <!--EQUIPAMENTOS-->
                <div class="tab-pane" id="equipamento">

                    <form id="edit-profile" class="form-horizontal" action="relatorio_equip.php" method="GET"
                        autocomplete='off'>
                        <div class="control-group">
                            <label class="control-label required">Tipo de equipamento:</label>
                            <div class="controls">

                                <select id='t_cob' name='equipamento' class='span2'>
                                    <option value=''>---</option>
                                    <?php 
                                        while ($row_equip = $resultado_equip -> fetch_assoc()) { 
                                            echo "<option value='" . $row_equip['id_equip'] . "'>" . $row_equip['nome'] . "</option>"; 
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label required">Status:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='status_equipamento' class='span2'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                $query_status = "SELECT * from manager_dropstatusequipamento WHERE deletar = 0 order by nome ASC;";
                                $resultado_status = mysqli_query($conn, $query_status);
                                while ($row_status = mysqli_fetch_assoc($resultado_status)) {
                                    echo "<option value='" . $row_status['id_status'] . "'>" . $row_status['nome'] . "</option>";
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
                <!--VIGENCIA-->
                <div class="tab-pane" id="vigencia">

                    <form id="edit-profile" class="form-horizontal" action="relatorio_vigencia.php" method="GET"
                        autocomplete='off'>
                        <div class="control-group">
                            <label class="control-label">Tipo de equipamento:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='tipo_equipamento' class='span2' name='te'>
                                                <option value=''>---</option>";
                                //BUSCANDO OS TIPOS DE EQUIPAMENTOS NO BANCO
                                $query_equip = "SELECT * from manager_dropequipamentos WHERE deletar = 0 order by nome ASC;";
                                $resultado_equip = mysqli_query($conn, $query_equip);
                                while ($row_equip = mysqli_fetch_assoc($resultado_equip)) {
                                    echo "<option value='" . $row_equip['id_equip'] . "'>" . $row_equip['nome'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--CELULAR-->
                        <div class="control-group" id="celular" style="display: none;">
                            <label class="control-label">Imei's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='ce' class='span2'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS TIPOS DE IMEI'S NO BANCO
                                $query_imei = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.imei_chip
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 1 AND 
                                                                MIE.imei_chip != '' ORDER BY MIE.imei_chip ASC";
                                $resultado_imei = mysqli_query($conn, $query_imei);
                                while ($row_imei = mysqli_fetch_assoc($resultado_imei)) {
                                    echo "<option value='" . $row_imei['id_equipamento'] . "'>" . $row_imei['imei_chip'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--CHIP-->
                        <div class="control-group" id="chip" style="display: none;">
                            <label class="control-label">Chip's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='ch' class='span2'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS CHIP'S NO BANCO
                                $query_chip = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.numero
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 3 AND 
                                                                MIE.numero != '' ORDER BY MIE.numero ASC";
                                $resultado_chip = mysqli_query($conn, $query_chip);
                                while ($row_chip = mysqli_fetch_assoc($resultado_chip)) {
                                    echo "<option value='" . $row_chip['id_equipamento'] . "'>" . $row_chip['numero'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--CPU-->
                        <div class="control-group" id="cpu" style="display: none;">
                            <label class="control-label">Cpu's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='cp' class='span1'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS CPU'S NO BANCO
                                $query_cpu = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.patrimonio
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 8 AND 
                                                                MIE.patrimonio != '' ORDER BY MIE.patrimonio ASC";
                                $resultado_cpu = mysqli_query($conn, $query_cpu);
                                while ($row_cpu = mysqli_fetch_assoc($resultado_cpu)) {
                                    echo "<option value='" . $row_cpu['id_equipamento'] . "'>" . $row_cpu['patrimonio'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--MODEM-->
                        <div class="control-group" id="moden" style="display: none">
                            <label class="control-label">Modens:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='mo' class='span2'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS MODENS NO BANCO
                                $query_modem = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.imei_chip
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 4 AND 
                                                                MIE.imei_chip != '' ORDER BY MIE.imei_chip ASC;";
                                $resultado_modem = mysqli_query($conn, $query_modem);
                                while ($row_modem = mysqli_fetch_assoc($resultado_modem)) {
                                    echo "<option value='" . $row_modem['id_equipamento'] . "'>" . $row_modem['imei_chip'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--NOTEBOOK-->
                        <div class="control-group" id="notebook" style="display: none;">
                            <label class="control-label">Notebook's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='no' class='span1'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS NOTEBOOK'S NO BANCO
                                $query_note = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.patrimonio
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 9 AND 
                                                                MIE.patrimonio != '' ORDER BY MIE.patrimonio ASC";
                                $resultado_note = mysqli_query($conn, $query_note);
                                while ($row_note = mysqli_fetch_assoc($resultado_note)) {
                                    echo "<option value='" . $row_note['id_equipamento'] . "'>" . $row_note['patrimonio'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--RAMAL-->
                        <div class="control-group" id="ramal" style="display: none">
                            <label class="control-label">Ramal's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='ra' class='span1'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS RAMAL'S NO BANCO
                                $query_ramal = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.numero
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 5 AND 
                                                                MIE.numero != '' ORDER BY MIE.numero ASC";
                                $resultado_ramal = mysqli_query($conn, $query_ramal);
                                while ($row_ramal = mysqli_fetch_assoc($resultado_ramal)) {
                                    echo "<option value='" . $row_ramal['id_equipamento'] . "'>" . $row_ramal['numero'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--SCANNER-->
                        <div class="control-group" id="scanner" style="display: none;">
                            <label class="control-label">Scanner's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='sc' class='span1'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS Scanner'S NO BANCO
                                $query_scan = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.patrimonio
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND
                                                                MIE.tipo_equipamento = 10 AND 
                                                                MIE.patrimonio != '' ORDER BY MIE.patrimonio ASC";
                                $resultado_scan = mysqli_query($conn, $query_scan);
                                while ($row_scan = mysqli_fetch_assoc($resultado_scan)) {
                                    echo "<option value='" . $row_scan['id_equipamento'] . "'>" . $row_scan['patrimonio'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--TABLET-->
                        <div class="control-group" id="tablet" style="display: none;">
                            <label class="control-label">Tablet's:</label>
                            <div class="controls">
                                <?php
                                echo "<select id='t_cob' name='ta' class='span1'>
                                            <option value=''>---</option>";
                                //BUSCANDO OS TABLET'S NO BANCO
                                $query_tablet = "SELECT 
                                                                MDV.id_equipamento, 
                                                                MIE.patrimonio,
                                                                MIE.imei_chip
                                                            FROM
                                                                manager_data_vigencia MDV
                                                            LEFT JOIN
                                                                manager_inventario_equipamento MIE ON MDV.id_equipamento = MIE.id_equipamento
                                                            WHERE
                                                                MIE.deletar = 0 AND 
                                                                MIE.tipo_equipamento = 2 ORDER BY MIE.patrimonio ASC";
                                $resultado_tablet = mysqli_query($conn, $query_tablet);
                                while ($row_tablet = mysqli_fetch_assoc($resultado_tablet)) {
                                    if ($row_tablet['patrimonio'] == NULL) {
                                        echo "<option value='" . $row_tablet['id_equipamento'] . "'>" . $row_tablet['imei_chip'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_tablet['id_equipamento'] . "'>" . $row_tablet['patrimonio'] . "</option>";
                                    } //Fim IF
                                } //Fim WHILE
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--PERIODO-->
                        <div class="control-group">
                            <label class="control-label">Período:</label>
                            <div class="controls">
                                <ul id="data_vigencia">
                                    <li class="li_data">
                                        <input type="date" name="di" id="data_inicial" class="span2"
                                            style="width: 130px;" />
                                    </li>
                                    <span id="li_texto">Até</span>
                                    <li class="li_data">
                                        <input type="date" name="df" id="data_final" class="span2"
                                            style="width: 130px;" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Campos Escondidos-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!--FIM DATA VIGÊNCIA-->
            </div>
        </div>
    </div>
</div>
<!--JAVASCRITPS TABELAS-->
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
<!--REGRA PARA MOSTRAR OS CAMPOS NO RELATÓRIOS DE VIGENCIA-->
<script src="../js/vigencia.js"></script>
</body>

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
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript">
// INICIO FUNÇÃO DE MASCARA MAIUSCULA
function maiuscula(z) {
    v = z.value.toUpperCase();
    z.value = v;
}
//FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>
<?php $conn->close(); ?>

</html>