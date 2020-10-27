<?php
//aplicando para usar variavel em outro arquivo
session_start();
//chamando conexão com o bancoF
require_once('../conexao/conexao.php');
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
    header('location: ../front/error.php');
}
?>
<?php require 'header.php' ?>
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
    </div>
</div>
<!--FOMULARIO DE CONTRARO-->

<div class="widget ">
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="manager.php">Home</a>
            /
            <i class="icon-lithe icon-table"></i>&nbsp;
            <a href="equip.php">Inventário</a>
            /
            <i class="icon-lithe icon-plus"></i>&nbsp;
            <a href="add_new.php">Novo equipamento</a>

        </h3>
    </div>
    <!--ALERTAS-->
    <?php

    if ($_GET['ok'] == 1) { //Equipamento cadastrado com sucesso
        echo "
                <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <strong>Alerta!</strong> Cadastro realizado com sucesso!.
                </div>";
    } //end alerta ok 1

    if ($_GET['error'] == 2) { //Equipamento não encontrado no OCS
        echo "
                <div class='alert alert-block'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                    Equipamento <b style='color:red'>NÃO ENCONTRADO</b>, verifique no <b>OCS / AGENTE</b> antes de continuar. 
                </div>";
    } //end alerta erro 2

    if ($_GET['error'] == 3) { //Preencher pelomenos um equipamento
        echo "
                <div class='alert alert-block'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                    Preencha pelo menos um equipamento para prosseguir com o cadastro. 
                </div>";
    } //end alerta erro 3

    if ($_GET['error'] == 4) { //Equipamento já cadastrado porém condenado
        echo "
                <div class='alert alert-block'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                    Equipamento <b style='color:red'>CONDENADO</b>. 
                </div>";
    } //end alerta erro 4

    if ($_GET['error'] == 5) { //Equipamento já cadastrado
        echo "
                <div class='alert alert-block'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                    Equipamento <b style='color:red'>JÁ CADASTRADO</b>. 
                </div>";
    } //end alerta erro 4
    ?>
    <!--FIM ALERTAS-->
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <div id="formulario">
                <!--CRIADO FORMULARIO PARA FAZER AS VALIDAÇÕES-->
                <form id='form2' class='form-horizontal' action='equip_single.php' method='POST' enctype='multipart/form-data' autocomplete='off' style="display: none;">
                    <!--PATRIMONIO CPU-->
                    <input type="text" id="cpu_validacao" name="gols2" />
                    <!--PATRIMONIO NOTEBOOK-->
                    <input type="text" id="notebook_validacao" name="gols3" />
                </form>
                <!--Buscando inforação pelo apollo-->
                <form id='form1' class='form-horizontal' action='equip_single_insert.php' method='POST' enctype='multipart/form-data' autocomplete='off'>
                    <div class="control-group">
                        <h3 style="color: red;">
                            <font style="vertical-align: inherit;">SALVANDO APENAS EQUIPAMENTO</font>
                        </h3>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Equipamentos:</label>
                        <div class="controls">
                            <!--DESKTOP-->
                            <label class="checkbox inline">
                                <a class="icone" href="javascript:;" onclick="mostrar('cpu')" title="CPU">
                                    <i class="fas fa-desktop fa-2x"></i>
                                </a>
                            </label>
                            <!--NOTEBOOK-->
                            <label class="checkbox inline">
                                <a href="javascript:;" class="icone" onclick="mostrar('notebook')" title="NOTEBOOK">
                                    <i class="fas fa-laptop fa-2x"></i>
                                </a>
                            </label>


                            <!--SCANNER-->
                            <label class="checkbox inline">
                                <a href="javascript:;" class="icone" onclick="mostrar('scan')" title="SCANNER">
                                    <i class="fas fa-print fa-2x"></i>
                                </a>
                            </label>
                        </div>
                        <!--CAMPO ESCONDIDOS CPU-->
                        <?php
                        if ($_SESSION['numero_patrimonio'] != NULL) {
                            echo "<div id='cpu'>";
                        } else {
                            echo "<div id='cpu' style='display: none;'>";
                        }
                        ?>
                        <hr>
                        <div class="control-group">
                            <h3 style="color: #0029ff;">
                                <font style="vertical-align: inherit;">
                                    <span onclick="fechar('cpu')" style="cursor:pointer; color:red;" title="Fechar">
                                        <i class="far fa-window-close" style="float: right;"></i>
                                    </span>
                                    <font style="vertical-align: inherit;"> C.P.U</font>
                                </font>
                            </h3>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for='gols2'>Número Patrimônio:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['numero_patrimonio'] != NULL) {
                                    echo "<input class='cpfcnpj span2' id='gols2' name='num_patrimonio_cpu' type='text' value='" . $_SESSION['numero_patrimonio'] . "'/>";
                                    unset($_SESSION['numero_patrimonio']);
                                } else {
                                    echo "<input class='cpfcnpj span2' id='gols2' name='num_patrimonio_cpu' type='text'/>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for='gols2'>Domínio:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['dominio'] != NULL) {

                                    if ($_SESSION['dominio'] == 0) { //Cadastrado no AD
                                        echo "<input name='dominio' type='text' value='" . $_SESSION['dominio'] . "' style='display: none;'/>
                                                <input class='span2' id='gols1' type='text' value='Cadastrado no AD' readonly/>
                                                <i class='fas fa-check-circle' style='color: green'></i> ";
                                    } else {
                                        echo "<input name='dominio' type='text' value='" . $_SESSION['dominio'] . "' style='display: none;'/>
                                                <input class='span2' id='gols1' type='text' value='Não cadastrado no AD' readonly/>
                                                <i class='fas fa-times-circle' style='color: red'></i> ";
                                    }
                                    unset($_SESSION['dominio']);
                                } else {
                                    echo "<input class='span1' id='gols2' name='dominio' type='text' disabled/>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Empresa:
                                <i class="icon-lithe icon-question-sign" title="Quem ta pagando o equipamento?"></i>
                            </label>
                            <div class="controls">
                                <select id='t_cob' name='empresa_cpu' class='span2'>
                                    <option value=''>---</option>
                                    <?php
                                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                    $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC;";
                                    $resultado_empresa = mysqli_query($conn, $query_empresa);
                                    while ($row_empresa = mysqli_fetch_assoc($resultado_empresa)) {
                                        echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Locação:
                                <i class="icon-lithe icon-question-sign" title="Onde se encontra o equipamento!"></i>
                            </label>
                            <div class="controls">
                                <select id='t_cob' name='locacao_cpu' class='span2'>
                                    <option value=''>---</option>
                                    <?php
                                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                    $query_empresa = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC;";
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
                                <select id='t_cob' name='depart_cpu' class='span2'>
                                    <option value=''>---</option>
                                    <?php
                                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                    $query_depart_cpu = "SELECT * FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC;";
                                    $resultado_depart_cpu = mysqli_query($conn, $query_depart_cpu);
                                    while ($row_depart_cpu = mysqli_fetch_assoc($resultado_depart_cpu)) {
                                        echo "<option value='" . $row_depart_cpu['id_depart'] . "'>" . $row_depart_cpu['nome'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nome do computador:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['nome_computador'] != NULL) {
                                    echo "<input class='span2' name='nome_cpu' type='text' value='" . $_SESSION['nome_computador'] . "'/>";
                                    unset($_SESSION['nome_computador']);
                                } else {
                                    echo "<input class='span2' name='nome_cpu' type='text'/>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Endereço IP:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['ip'] != NULL) {
                                    echo "<input class='span2' name='ip_cpu' type='text' value='" . $_SESSION['ip'] . "'/>";
                                    unset($_SESSION['ip']);
                                } else {
                                    echo "<input class='span2' name='ip_cpu' type='text' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Modelo:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['modelo'] != NULL) {
                                    echo "<input class='span2' name='modelo_cpu' type='text' value='" . $_SESSION['modelo'] . "'/>";
                                    unset($_SESSION['modelo']);
                                } else {
                                    echo "<input class='span2' name='modelo_cpu' type='text' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Processador:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['processador'] != NULL) {
                                    echo "<input class='span2' name='processador_cpu' type='text' value='" . $_SESSION['processador'] . "'/>";
                                    unset($_SESSION['processador']);
                                } else {
                                    echo "<input class='span2' name='processador_cpu' type='text' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hard Disk:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['hd'] != NULL) {
                                    echo "<input class='span2' name='hd_cpu' type='text' value='" . $_SESSION['hd'] . "'/>";
                                    unset($_SESSION['hd']);
                                } else {
                                    echo "<input class='span2' name='hd_cpu' type='text' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Memória:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['memoria'] != NULL) {
                                    echo "<input class='span2' name='memoria_cpu' type='text' value='" . $_SESSION['memoria'] . "'/>";
                                    unset($_SESSION['memoria']);
                                } else {
                                    echo "<input class='span2' name='memoria_cpu' type='text' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Número de série:</label>
                            <div class="controls">
                                <?php
                                if ($_SESSION['numero_serial'] != NULL) {
                                    echo "<input class='span2' name='serie_cpu' type='text' value='" . $_SESSION['numero_serial'] . "'/>";
                                    unset($_SESSION['numero_serial']);
                                } else {
                                    echo "<input class='span2' name='serie_cpu' type='text' />";
                                }
                                ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Programas:</label>
                            <div class="controls">
                                <!--OFFICE-->
                                <label class="checkbox inline">
                                    <a href="javascript:;" class="icone" onclick="mostrar('office')" title="Office">
                                        <i class="fab fa-windows fa-2x"></i>
                                    </a>
                                </label>
                            </div>
                            <!--OFFICE-->
                            <?php
                            if ($_SESSION['office'] != NULL) {
                                echo "<div id='office'>";
                            } else {
                                echo "<div id='office' style='display: none;'>";
                            }
                            ?>
                            <hr>
                            <div class="control-group">
                                <h3 style="color: #0029ff;">
                                    <font style="vertical-align: inherit;">
                                        <span onclick="fechar('office')" style="cursor:pointer; color:red;" title="Fechar">
                                            <i class="far fa-window-close" style="float: right;"></i>
                                        </span>
                                        <font style="vertical-align: inherit;"> Office</font>
                                    </font>
                                </h3>
                            </div>
                            <label id="campos">
                                <div class="container">
                                    <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                                        <div class="col-md-12 column">
                                            <div class="control-group">
                                                <label class="control-label">Office:
                                                </label>
                                                <div class="controls">
                                                    <select id='t_cob' name='tipo_office' class='span3'>
                                                        <?php
                                                        if ($_SESSION['office'] != NULL) {
                                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                            $query_office = "SELECT * FROM manager_dropoffice WHERE deletar = 0  AND nome like '%".$_SESSION['office']."%'";
                                                            $resultado_query_office = mysqli_query($conn, $query_office);
                                                            $row_so_office = mysqli_fetch_assoc($resultado_query_office);
                                                            echo "<option value='" . $row_so_office['id'] . "'>" . $row_so_office['nome'] . "</option>";
                                                            unset($_SESSION['office']);

                                                            echo "<option value=''>---</option>";
                                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                            $query_office_cpu = "SELECT * FROM manager_dropoffice WHERE deletar = 0 ORDER BY nome ASC;";
                                                            $resultado_so_cpu = mysqli_query($conn, $query_office_cpu);
                                                            while ($row_so_cpu = mysqli_fetch_assoc($resultado_so_cpu)) {
                                                                echo "<option value='" . $row_so_cpu['id'] . "'>" . $row_so_cpu['nome'] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=''>---</option>";
                                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                            $query_office_cpu = "SELECT * FROM manager_dropoffice WHERE deletar = 0 ORDER BY nome ASC;";
                                                            $resultado_so_cpu = mysqli_query($conn, $query_office_cpu);
                                                            while ($row_so_cpu = mysqli_fetch_assoc($resultado_so_cpu)) {
                                                                echo "<option value='" . $row_so_cpu['id'] . "'>" . $row_so_cpu['nome'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Fornecedor:</label>
                                                <div class="controls">
                                                    <div class="autocomplete">
                                                        <input class='span4' id='myInput1' name='fornecedor_cpuOffice' type='text' />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--LOCAÇÃO-->
                                            <div class="control-group">
                                                <label class="control-label">Locacão:
                                                </label>
                                                <div class="controls">
                                                    <select id='t_cob' name='locacao_office_cpu' class='span2'>
                                                        <option value=''>---</option>
                                                        <?php
                                                        //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                        $empresa_locacao_cpu = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC;";
                                                        $result_empresa_local_cpu = mysqli_query($conn, $empresa_locacao_cpu);
                                                        while ($empresa_localCPU = mysqli_fetch_assoc($result_empresa_local_cpu)) {
                                                            echo "<option value='" . $empresa_localCPU['id_empresa'] . "'>" . $empresa_localCPU['nome'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--EMPRESA-->
                                            <div class="control-group">
                                                <label class="control-label">Empresa:
                                                </label>
                                                <div class="controls">
                                                    <select id='t_cob' name='empresa_office_cpu' class='span2'>
                                                        <option value=''>---</option>
                                                        <?php
                                                        //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                        $query_empresa_OfficeCPU = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC;";
                                                        $resultado_empresa_OfficeCPU = mysqli_query($conn, $query_empresa_OfficeCPU);
                                                        while ($row_empresaOfficeCPU = mysqli_fetch_assoc($resultado_empresa_OfficeCPU)) {
                                                            echo "<option value='" . $row_empresaOfficeCPU['id_empresa'] . "'>" . $row_empresaOfficeCPU['nome'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--SERIAL-->
                                            <div class="control-group">
                                                <label class="control-label">Serial:
                                                </label>
                                                <div class="controls">
                                                    <?php
                                                    if ($_SESSION['serial_office'] != NULL) {
                                                        echo "<input type='text' name='serial_nota_office_cpu' class='form-control span4' value='" . $_SESSION['serial_office'] . "'>";
                                                        unset($_SESSION['serial_office']);
                                                    } else {
                                                        echo "<input type='text' name='serial_nota_office_cpu' class='form-control span4'>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Número da Nota:
                                                </label>
                                                <div class="controls">
                                                    <input type='text' name='num_nota_office_cpu' class='form-control span2'>
                                                </div>
                                            </div>
                                            <!--FILE NOTA-->
                                            <div class="control-group">
                                                <label class="control-label">Anexar Nota:
                                                </label>
                                                <div class="controls">
                                                    <input type='file' name='file_nota_office_cpu' class='form-control span2'>
                                                </div>
                                            </div>
                                            <!--DATA NOTA-->
                                            <div class="control-group">
                                                <label class="control-label">Data Nota:
                                                </label>
                                                <div class="controls">
                                                    <input type='text' name='data_nota_office_cpu' class='form-control span2' placeholder='dd / mm / AAAA'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--SISTEMA OPERACIONAL CPU-->
                        <div id='windows'>
                            <hr>
                            <div class="control-group">
                                <h3 style="color: #0029ff;">
                                    <font style="vertical-align: inherit;">
                                        <!--
                                                <span onclick="fechar('windows')" style="cursor:pointer; color:red;"
                                                    title="Fechar">
                                                    <i class="far fa-window-close" style="float: right;"></i>
                                                </span>-->
                                        <font style="vertical-align: inherit;"> Windows</font>
                                    </font>
                                </h3>
                            </div>
                            <label id="campos">
                                <div class="container">
                                    <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                                        <div class="col-md-12 column">

                                            <!--SISTEMA OPERACIONAL-->
                                            <div class="control-group">
                                                <label class="control-label">Sistema Operacional:
                                                </label>
                                                <div class="controls">
                                                    <select id='t_cob' name='so_cpu' class='span3'>
                                                        <?php
                                                        if ($_SESSION['so'] != NULL) {
                                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                            $query_so_cpu = "SELECT * FROM manager_dropsistemaoperacional WHERE deletar = 0 AND nome like '%" . $_SESSION['so'] . "%' ;";

                                                            $resultado_so_cpu = mysqli_query($conn, $query_so_cpu);
                                                            $row_so_cpu = mysqli_fetch_assoc($resultado_so_cpu);
                                                            echo "<option value='" . $row_so_cpu['id'] . "'>" . $row_so_cpu['nome'] . "</option>";
                                                            unset($_SESSION['so']);
                                                        } else {
                                                            echo "<option value=''>---</option>";
                                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                                            $query_so_cpu = "SELECT * FROM manager_dropsistemaoperacional WHERE deletar = 0 ORDER BY nome ASC;";
                                                            $resultado_so_cpu = mysqli_query($conn, $query_so_cpu);
                                                            while ($row_so_cpu = mysqli_fetch_assoc($resultado_so_cpu)) {
                                                                echo "<option value='" . $row_so_cpu['id'] . "'>" . $row_so_cpu['nome'] . "</option>";
                                                            }
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Fornecedor:</label>
                                                <div class="controls">
                                                    <input class='span4' id='myInput2' name='fornecedor_cpu' type='text' />
                                                </div>
                                            </div>
                                        </div>
                                        <!--SERIAL SO CPU-->
                                        <div class="control-group">
                                            <label class="control-label">Serial:
                                            </label>
                                            <div class="controls">
                                                <?php
                                                if ($_SESSION['serial_so'] != NULL) {
                                                    echo "<input type='text' name='serial_so_cpu' class='form-control span4' value='" . $_SESSION['serial_so'] . "'>";
                                                    unset($_SESSION['serial_so']);
                                                } else {
                                                    echo "<input type='text' name='serial_so_cpu' class='form-control span4'>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Número da Nota:
                                            </label>
                                            <div class="controls">
                                                <input type='text' name='num_nota_so_cpu' class='form-control span2'>
                                            </div>
                                        </div>
                                        <!--FILE NOTA-->
                                        <div class="control-group">
                                            <label class="control-label">Anexar Nota:
                                            </label>
                                            <div class="controls">
                                                <input type='file' name='file_nota_so_cpu' class='form-control span2'>
                                            </div>
                                        </div>
                                        <!--DATA NOTA SO CPU-->
                                        <div class="control-group">
                                            <label class="control-label">Data da nota:
                                            </label>
                                            <div class="controls">
                                                <input type='text' name='data_nota_so_cpu' class='form-control span2' placeholder="dd / mm / aaaa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </label>
                    </div>
            </div>
        </div>
        <!--CAMPO ESCONDIDOS NOTEBOOK-->
        <?php
        if ($_SESSION['numero_patrimonio_note'] != NULL) {
            echo "<div id='notebook'>";
        } else {
            echo "<div id='notebook' style='display: none;'>";
        }
        ?>
        <hr>
        <div class="control-group">
            <h3 style="color: #0029ff;">
                <font style="vertical-align: inherit;">
                    <span onclick="fechar('notebook')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                    </span>
                    <font style="vertical-align: inherit;"> NOTEBOOK</font>
                </font>
            </h3>
        </div>
        <div class="control-group">
            <label class="control-label" for='gols3'>Número Patrimônio:</label>
            <div class="controls">
                <?php
                if ($_SESSION['numero_patrimonio_note'] != NULL) {
                    echo "<input class='span2' id='gols3' name='num_patrimonio_notebook' type='text' value='" . $_SESSION['numero_patrimonio_note'] . "'/>";
                    unset($_SESSION['numero_patrimonio_note']);
                } else {
                    echo "<input class='span2' name='num_patrimonio_notebook' type='text' id='gols3'/>";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for='gols2'>Domínio:</label>
            <div class="controls">
                <?php
                if ($_SESSION['dominio_note'] != NULL) {

                    if ($_SESSION['dominio_note'] == 0) { //Cadastrado no AD
                        echo "<input name='dominio_note' type='text' value='" . $_SESSION['dominio_note'] . "' style='display: none;'/>
                                    <input class='span2' id='gols1' type='text' value='Cadastrado no AD' readonly/>
                                    <i class='fas fa-check-circle' style='color: green'></i> ";
                    } else {
                        echo "<input name='dominio_note' type='text' value='" . $_SESSION['dominio_note'] . "' style='display: none;'/>
                                    <input class='span2' id='gols1' type='text' value='Não cadastrado no AD' readonly/>
                                    <i class='fas fa-times-circle' style='color: red'></i> ";
                    }
                    unset($_SESSION['dominio_note']);
                } else {
                    echo "<input class='span1' id='gols2' name='dominio_note' type='text' disabled/>";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Locação:
                <i class="icon-lithe icon-question-sign" title="Onde se encontra o equipamento!"></i>
            </label>

            <div class="controls">
                <select id='t_cob' name='locacao_notebook' class='span2'>
                    <option value=''>---</option>
                    <?php
                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                    $query_local_note = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC;";
                    $resultado_local_note = mysqli_query($conn, $query_local_note);
                    while ($row_local_note = mysqli_fetch_assoc($resultado_local_note)) {
                        echo "<option value='" . $row_local_note['id_empresa'] . "'>" . $row_local_note['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Empresa:
                <i class="icon-lithe icon-question-sign" title="Quem ta pagando o equipamento?"></i>
            </label>
            <div class="controls">
                <select id='t_cob' name='empresa_notebook' class='span2'>
                    <option value=''>---</option>
                    <?php
                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                    $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC;";
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
                <select id='t_cob' name='depart_notebook' class='span2'>
                    <option value=''>---</option>
                    <?php
                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                    $query_depart = "SELECT * FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC;";
                    $resultado_depart = mysqli_query($conn, $query_depart);
                    while ($row_depart = mysqli_fetch_assoc($resultado_depart)) {
                        echo "<option value='" . $row_depart['id_depart'] . "'>" . $row_depart['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nome do computador:</label>
            <div class="controls">
                <?php
                if ($_SESSION['nome_computador_note'] != NULL) {
                    echo "<input class='span2' name='nome_notebook' type='text' value='" . $_SESSION['nome_computador_note'] . "'/>";
                    unset($_SESSION['nome_computador_note']);
                } else {
                    echo "<input class='span2' name='nome_notebook' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Endereço IP:</label>
            <div class="controls">
                <?php
                if ($_SESSION['ip_note'] != NULL) {
                    echo "<input class='span2' name='ip_notebook' type='text' value='" . $_SESSION['ip_note'] . "'/>";
                    unset($_SESSION['ip_note']);
                } else {
                    echo "<input class='span2' name='ip_notebook' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Modelo:</label>
            <div class="controls">
                <?php
                if ($_SESSION['modelo_note'] != NULL) {
                    echo "<input class='span2' name='modelo_notebook' type='text' value='" . $_SESSION['modelo_note'] . "'/>";
                    unset($_SESSION['modelo_note']);
                } else {
                    echo "<input class='span2' name='modelo_notebook' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Processador:</label>
            <div class="controls">
                <?php
                if ($_SESSION['processador_note'] != NULL) {
                    echo "<input class='span2' name='processador_notebook' type='text' value='" . $_SESSION['processador_note'] . "'/>";
                    unset($_SESSION['processador_note']);
                } else {
                    echo "<input class='span2' name='processador_notebook' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Hard Disk:</label>
            <div class="controls">
                <?php
                if ($_SESSION['hd_note'] != NULL) {
                    echo "<input class='span2' name='hd_note' type='text' value='" . $_SESSION['hd_note'] . "'/>";
                    unset($_SESSION['hd_note']);
                } else {
                    echo "<input class='span2' name='hd_note' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Memória:</label>
            <div class="controls">
                <?php
                if ($_SESSION['memoria_note'] != NULL) {
                    echo "<input class='span2' name='memoria_note' type='text' value='" . $_SESSION['memoria_note'] . "'/>";
                    unset($_SESSION['memoria_note']);
                } else {
                    echo "<input class='span2' name='memoria_note' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Situacao:</label>
            <div class="controls">
                <select id='situacao_note' name='situacao_note' class='span2'>
                    <option>---</option>
                    <?php
                    //BUSCANDO OS DEPARTAMENTOS NO BANCO
                    $query_situacao_note = "SELECT * FROM manager_dropsituacao WHERE deletar = 0 ORDER BY nome ASC;";
                    $resultado_situacao_note = mysqli_query($conn, $query_situacao_note);
                    while ($row_situacao_note = mysqli_fetch_assoc($resultado_situacao_note)) {
                        echo "<option value='" . $row_situacao_note['id_situacao'] . "'>" . $row_situacao_note['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group" id="observacao_note" style="display:none;">
            <label class="control-label">Observação:
                <i class="icon-lithe icon-question-sign" title="Se existe alguma informação que queira ir para o termo, ex: tela quebrada, etc..."></i>
            </label>
            <div class="controls">
                <textarea name="observacao_note" type="text"></textarea>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">Número de série:</label>
            <div class="controls">
                <?php
                if ($_SESSION['numero_serial_note'] != NULL) {
                    echo "<input class='span2' name='serie_notebook' type='text' value='" . $_SESSION['numero_serial_note'] . "'/>";
                    unset($_SESSION['numero_serial_note']);
                } else {
                    echo "<input class='span2' name='serie_notebook' type='text' />";
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Programas:</label>
            <div class="controls">
                <!--OFFICE-->
                <label class="checkbox inline">
                    <a href="javascript:;" class="icone" onclick="mostrar('officeN')" title="Office">
                        <i class="fab fa-windows fa-2x"></i>
                    </a>
                </label>
            </div>
            <!--OFFICE-->
            <?php
            if ($_SESSION['office_note'] != NULL) {
                echo "<div id='officeN'>";
            } else {
                echo "<div id='officeN' style='display: none;'>";
            }
            ?>
            <hr>
            <div class="control-group">
                <h3 style="color: #0029ff;">
                    <font style="vertical-align: inherit;">
                        <span onclick="fechar('officeN')" style="cursor:pointer; color:red;" title="Fechar">
                            <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;"> Office</font>
                    </font>
                </h3>
            </div>
            <label id="campos">
                <div class="container">
                    <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                        <div class="col-md-12 column">

                            <!--MODELO OFFICE-->
                            <div class="control-group">
                                <label class="control-label">Office:
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='office_note' class='span3'>
                                        <?php
                                        if ($_SESSION['office_note'] != NULL) {
                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                            $query_office_note = "SELECT * FROM manager_dropoffice WHERE deletar = 0 AND nome LIKE '%" . $_SESSION['office_note'] . "%' ;";

                                            $resultado_office_note = mysqli_query($conn, $query_office_note);
                                            $row_office_note = mysqli_fetch_assoc($resultado_office_note);
                                            echo "<option value='" . $row_office_note['id'] . "'>" . $row_office_note['nome'] . "</option>";
                                            unset($_SESSION['office_note']);
                                        } else {
                                            echo "<option value=''>---</option>";
                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                            $query_office_note = "SELECT * FROM manager_dropoffice WHERE deletar = 0 ORDER BY nome ASC;";
                                            $resultado_office_note = mysqli_query($conn, $query_office_note);
                                            while ($row_office_note = mysqli_fetch_assoc($resultado_office_note)) {
                                                echo "<option value='" . $row_office_note['id'] . "'>" . $row_office_note['nome'] . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Fornecedor:</label>
                                <div class="controls">
                                    <div class="autocomplete">
                                        <?php
                                        if ($_SESSION['fornecedor_noteOffice'] != NULL) {
                                            echo "<input class='span4' name='fornecedor_noteOffice' id='myInput3' type='text' value='" . $_SESSION['fornecedor_noteOffice'] . "'/>";
                                            unset($_SESSION['fornecedor_noteOffice']);
                                        } else {
                                            echo "<input class='span4' id='myInput3' name='fornecedor_noteOffice' type='text'/>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!--LOCAÇÃO OFFICE-->
                            <div class="control-group">
                                <label class="control-label">Locacão:
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='local_note_office' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                        $local_office_noteOFFICE = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC;";
                                        $result_office_noteOFFICE = mysqli_query($conn, $local_office_noteOFFICE);
                                        while ($row_local_noteOFFICE = mysqli_fetch_assoc($result_office_noteOFFICE)) {
                                            echo "<option value='" . $row_local_noteOFFICE['id_empresa'] . "'>" . $row_local_noteOFFICE['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--EMPRESA OFFICE-->
                            <div class="control-group">
                                <label class="control-label">Empresa:
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='empresa_note_office' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                        $query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC;";
                                        $resultado_empresa = mysqli_query($conn, $query_empresa);
                                        while ($row_empresa = mysqli_fetch_assoc($resultado_empresa)) {
                                            echo "<option value='" . $row_empresa['id_empresa'] . "'>" . $row_empresa['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--SERIAL OFFICE NOTE-->
                            <div class="control-group">
                                <label class="control-label">Serial:
                                </label>
                                <div class="controls">
                                    <?php
                                    if ($_SESSION['serial_office_note'] != NULL) {
                                        echo "<input type='text' name='serial_office_note' class='form-control span4' value='" . $_SESSION['serial_office_note'] . "'>";
                                    } else {
                                        echo "<input type='text' name='serial_office_note' class='form-control span4'>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--NUMERO NOTA OFFICE NOTE-->
                            <div class="control-group">
                                <label class="control-label">Número da Nota:
                                </label>
                                <div class="controls">
                                    <input type='text' name='num_office_note' class='form-control span2'>
                                </div>
                            </div>
                            <!--FILE NOTA OFFICE NOTE-->
                            <div class="control-group">
                                <label class="control-label">Anexar Nota:
                                </label>
                                <div class="controls">
                                    <input type='file' name='file_office_note' class='form-control span2'>
                                </div>
                            </div>
                            <!--DATA NOTA OFFICE-->
                            <div class="control-group">
                                <label class="control-label">Data da nota:
                                </label>
                                <div class="controls">
                                    <input type='text' name='data_office_note' class='form-control span2' placeholder="dd / mm / aaaa">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
        </div>
        <!--SISTEMA OPERACIONAL-->
        <div id='windows'>
            <hr>
            <div class="control-group">
                <h3 style="color: #0029ff;">
                    <font style="vertical-align: inherit;">
                        <!--<span onclick="fechar('windows')" style="cursor:pointer; color:red;"
                                                    title="Fechar">
                                                    <i class="far fa-window-close" style="float: right;"></i>
                                                </span>-->
                        <font style="vertical-align: inherit;"> Windows</font>
                    </font>
                </h3>
            </div>
            <label id="campos">
                <div class="container">
                    <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                        <div class="col-md-12 column">
                            <!--SISTEMA OPERACIONAL NOTEBOOK-->
                            <div class="control-group">
                                <label class="control-label">Sistema Operacional:
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='so_notebook' class='span3'>
                                        <?php
                                        if ($_SESSION['so_note'] != NULL) {
                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                            $query_so_note = "SELECT * FROM manager_dropsistemaoperacional WHERE deletar = 0 AND nome LIKE '%" . $_SESSION['so_note'] . "%' ;";
                                            $resultado_so_note = mysqli_query($conn, $query_so_note);
                                            $row_so_note = mysqli_fetch_assoc($resultado_so_note);
                                            echo "<option value='" . $row_so_note['id'] . "'>" . $row_so_note['nome'] . "</option>";
                                            unset($_SESSION['so_note']);
                                        } else {
                                            echo "<option value=''>---</option>";
                                            //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                            $query_so_note = "SELECT * FROM manager_dropsistemaoperacional WHERE deletar = 0 ORDER BY nome ASC;";
                                            $resultado_so_note = mysqli_query($conn, $query_so_note);
                                            while ($row_so_note = mysqli_fetch_assoc($resultado_so_note)) {
                                                echo "<option value='" . $row_so_note['id'] . "'>" . $row_so_note['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Fornecedor:</label>
                                <div class="controls">
                                    <div class="autocomplete">
                                        <input class='span4' id='myInput4' name='fornecedor_note' type='text' />
                                    </div>
                                </div>
                            </div>
                            <!--SERIAL S.O NOTEBOOK-->
                            <div class="control-group">
                                <label class="control-label">Serial:
                                </label>
                                <div class="controls">
                                    <?php
                                    if ($_SESSION['serial_so_note'] != NULL) {
                                        echo "<input type='text' name='serial_so_note' class='form-control span4' value='" . $_SESSION['serial_so_note'] . "'>";
                                        unset($_SESSION['serial_so_note']);
                                    } else {
                                        echo "<input type='text' name='serial_so_note' class='form-control span4'>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--NUMERO NOTA S.O NOTEBOOK-->
                            <div class="control-group">
                                <label class="control-label">Número da Nota:
                                </label>
                                <div class="controls">
                                    <input type='text' name='num_so_note' class='form-control span2'>
                                </div>
                            </div>
                            <!--FILE NOTA S.O NOTEBOOK-->
                            <div class="control-group">
                                <label class="control-label">Anexar Nota:
                                </label>
                                <div class="controls">
                                    <input type='file' name='file_so_note' class='form-control span2'>
                                </div>
                            </div>
                            <!--DATA NOTA S.O NOTEBOOK-->
                            <div class="control-group">
                                <label class="control-label">Data da Nota:
                                </label>
                                <div class="controls">
                                    <input type='text' name='data_so_note' class='form-control span2' placeholder="dd / mm / aaaa">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>
<!--CAMPO ESCONDIDOS RAMAL-->
<div id='ramal' style='display: none;'>
    <hr>
    <div class="control-group">
        <h3 style="color: #0029ff;">
            <font style="vertical-align: inherit;">
                <span onclick="fechar('ramal')" style="cursor:pointer; color:red;" title="Fechar">
                    <i class="far fa-window-close" style="float: right;"></i>
                </span>
                <font style="vertical-align: inherit;"> Ramal</font>
            </font>
        </h3>
    </div>
    <!--Campos Escondidos-->
    <label id="campos">
        <div class="container">
            <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                <div class="col-md-12 column">
                    <table class="table table-bordered table-hover" id="tab_logic_R">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Modelo
                                </th>
                                <th class="text-center">
                                    Número
                                </th>
                                <th class="text-center">
                                    Locação
                                    <i class="icon-lithe icon-question-sign" title="Onde se encontra o equipamento!"></i>
                                </th>
                                <th class="text-center">
                                    Empresa
                                    <i class="icon-lithe icon-question-sign" title="Quem ta pagando o equipamento?"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addrR0'>
                                <!--MODELO DO RAMAL-->
                                <td>
                                    <div class="controls">
                                        <div class="autocomplete">
                                            <input type="text" id="myInput5" name="modelo_ramal0" class='form-control span2' />
                                        </div>
                                    </div>
                                </td>
                                <!--NUMERO DO RAMAL-->
                                <td>
                                    <input type="text" name="numero_ramal0" class='form-control span3' />
                                </td>
                                <!--LOCAÇÃO DO RAMAL-->
                                <td>
                                    <select name="local_ramal0">
                                        <option value="">---</option>
                                        <?php
                                        $query_ramal = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome";
                                        $resultado_ramal = mysqli_query($conn, $query_ramal);
                                        while ($row_ramal = mysqli_fetch_assoc($resultado_ramal)) {
                                            echo "<option value='" . $row_ramal['id_empresa'] . "'>" . $row_ramal['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <!--EMPRESA DO RAMAL-->
                                <td>
                                    <select name="empresa_ramal0">
                                        <option value="">---</option>
                                        <?php
                                        $query_ramalE = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome";
                                        $resultado_ramalE = mysqli_query($conn, $query_ramalE);
                                        while ($row_ramalE = mysqli_fetch_assoc($resultado_ramalE)) {
                                            echo "<option value='" . $row_ramalE['id_empresa'] . "'>" . $row_ramalE['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr id='addrR1'></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a id="ramal_row" class="btn btn-success pull-left">Adicionar Linhas</a>
            <a id='ramal_remover' class="pull-right btn btn-danger excluir">Excluir Linhas</a>
        </div>
    </label>
</div>
<!--CAMPO ESCONDIDOS RAMAL-->
<div id='scan' style='display: none;'>
    <hr>
    <div class="control-group">
        <h3 style="color: #0029ff;">
            <font style="vertical-align: inherit;">
                <span onclick="fechar('scan')" style="cursor:pointer; color:red;" title="Fechar">
                    <i class="far fa-window-close" style="float: right;"></i>
                </span>
                <font style="vertical-align: inherit;"> Scanner</font>
            </font>
        </h3>
    </div>
    <!--Campos Escondidos SCANNER-->
    <label id="campos">
        <div class="container">
            <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                <div class="col-md-12 column">
                    <div id="formulario">
                        <!--CRIADO FORMULARIO PARA FAZER AS VALIDAÇÕES-->
                        <form id='form2' class='form-horizontal' action='equip_validacao.php' method='POST' enctype='multipart/form-data' autocomplete='off'>
                            <!--NUMERO SERIE SCAN-->
                            <div class="control-group">
                                <label class="control-label">Número série:
                                </label>
                                <div class="controls">
                                    <input type='text' name='serie_scan' class='form-control span2'>
                                </div>
                            </div>
                            <!--MODELO-->
                            <div class="control-group">
                                <label class="control-label">Modelo:
                                </label>
                                <div class="controls">
                                    <input type='text' name='modelo_scan' class='form-control span2'>
                                </div>
                            </div>

                            <!--RESPONSÁVEL-->
                            <div class="control-group">
                                <label class="control-label">Responsável: </label>
                                <div class="controls">
                                    <select id='t_cob' name='responsavel_scan' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO NO BANCO
                                        $query_responsavel_scan = "SELECT id_funcionario, nome FROM manager_inventario_funcionario WHERE deletar = 0 ORDER BY nome ASC;";
                                        $resultado_responsavel_scan = mysqli_query($conn, $query_responsavel_scan);
                                        while ($row_responsavel_scan = mysqli_fetch_assoc($resultado_responsavel_scan)) {
                                            echo "<option value='" . $row_responsavel_scan['id_funcionario'] . "'>" . $row_responsavel_scan['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!--EMPRESA-->
                            <div class="control-group">
                                <label class="control-label">Empresa:
                                    <i class="icon-lithe icon-question-sign" title="Quem ta pagando o equipamento?"></i>
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='empresa_scan' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO NO BANCO
                                        $query_empresa_scan = "SELECT id_empresa, nome FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC;";
                                        $resultado_empresa_scan = mysqli_query($conn, $query_empresa_scan);
                                        while ($row_empresa_scan = mysqli_fetch_assoc($resultado_empresa_scan)) {
                                            echo "<option value='" . $row_empresa_scan['id_empresa'] . "'>" . $row_empresa_scan['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--LOCACAO-->
                            <div class="control-group">
                                <label class="control-label">Locacão:
                                    <i class="icon-lithe icon-question-sign" title="Quem ta pagando o equipamento?"></i>
                                </label>
                                <div class="controls">
                                    <select id='t_cob' name='locacao_scan' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO NO BANCO
                                        $query_local_scan = "SELECT id_empresa, nome FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC";
                                        $resultado_local_scan = mysqli_query($conn, $query_local_scan);
                                        while ($row_local_scan = mysqli_fetch_assoc($resultado_local_scan)) {
                                            echo "<option value='" . $row_local_scan['id_empresa'] . "'>" . $row_local_scan['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <!--DEPARTAMENTO-->
                            <div class="control-group">
                                <label class="control-label">Departamento:
                                    <i class="icon-lithe icon-question-sign" title="Departamento onde o Scanner foi instalado!"></i>
                                </label>
                                <div class="controls">
                                    <select id='departamento_scan' name='departamento_scan' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO NO BANCO
                                        $query_departamento_scan = "SELECT id_depart, nome FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";
                                        $resultado_departamento_scan = mysqli_query($conn, $query_departamento_scan);
                                        while ($row_departamento_scan = mysqli_fetch_assoc($resultado_departamento_scan)) {
                                            echo "<option value='" . $row_departamento_scan['id_depart'] . "'>" . $row_departamento_scan['nome'] . "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>


                            <!--TIPO-->
                            <div class="control-group">
                                <label class="control-label">TIPO:</label>
                                <div class="controls">
                                    <select id='tipo_scan' name='tipo_scan' class='span2'>
                                        <option value=''>---</option>
                                        <?php
                                        //BUSCANDO OS DEPARTAMENTOS NO BANCO
                                        $query_situacao_note = "SELECT * FROM manager_dropsituacao WHERE deletar = 0 AND id_situacao IN (4,5) ORDER BY nome ASC;";
                                        $resultado_situacao_note = mysqli_query($conn, $query_situacao_note);
                                        while ($row_situacao_note = mysqli_fetch_assoc($resultado_situacao_note)) {
                                            echo "<option value='" . $row_situacao_note['id_situacao'] . "'>" . $row_situacao_note['nome'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--ALUGADO-->
                            <div id="alugado" style='display: none'>
                                <div class="control-group">
                                    <label class="control-label">Fornecedor:
                                    </label>
                                    <div class="controls">
                                        <input type='text' name='fornecedor_scan' class='form-control span4'>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Data Fim Contrato:
                                    </label>
                                    <div class="controls">
                                        <input type='text' name='data_contrato_scan' class='form-control span2' placeholder="dd / mm / aaaa">
                                    </div>
                                </div>
                            </div>
                            <!--COMPRADO-->
                            <div id="comprado" style='display: none'>
                                <!--Patrimonio-->
                                <div class="control-group">
                                    <label class="control-label">Patrimônio:
                                    </label>
                                    <div class="controls">
                                        <input type='text' name='patrimonio_scan' class='form-control span2'>
                                    </div>
                                </div>
                                <!--Numero nota fiscal-->
                                <div class="control-group">
                                    <label class="control-label">Número Nota Fiscal:
                                    </label>
                                    <div class="controls">
                                        <input type='text' name='num_nota_scan' class='form-control span2'>
                                    </div>
                                </div>
                                <!--Nota fiscal-->
                                <div class="control-group">
                                    <label class="control-label">Nota Fiscal:
                                    </label>
                                    <div class="controls">
                                        <input type='file' name='file_nota_scan' class='form-control span2'>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </label>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-primary pull-right">Cadastrar</button>
</div>
</form>
<!-- /widget-content -->
</div>
</body>
<!-- Le javascript
================================================== -->

<script>
    //Buscar CPU
    (function() {

        var $gols2 = document.getElementById('gols2');

        function handleSubmit() {
            if ($gols2.value) {
                var $cpu_validacao = document.getElementById('cpu_validacao');
                if ($cpu_validacao.value)
                    document.getElementById('form1');
                $cpu_validacao.value = $gols2.value;
                document.getElementById('form2').submit();
            }
        }
        $gols2.addEventListener('blur', handleSubmit);
    })();

    //Buscar NOTEBOOK
    (function() {

        var $gols3 = document.getElementById('gols3');

        function handleSubmit() {
            if ($gols3.value) {
                var $notebook_validacao = document.getElementById('notebook_validacao');
                if ($notebook_validacao.value)
                    document.getElementById('form1');
                $notebook_validacao.value = $gols3.value;
                document.getElementById('form2').submit();
            }
        }
        $gols3.addEventListener('blur', handleSubmit);
    })();
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>
<!--MOSTRAR CAMPO OBSERVAÇÃO-->
<script>
    $("#situacao_note").change(

        function() {
            $('#observacao_note').hide();

            if (this.value == "2") {
                $('#observacao_note').show();
            }

        }

    );

    $("#tipo_scan").change(

        function() {
            $('#alugado').hide();

            if (this.value == "4") {
                $('#alugado').show();
            }

        }

    );

    $("#tipo_scan").change(

        function() {
            $('#comprado').hide();

            if (this.value == "5") {
                $('#comprado').show();
            }

        }

    );
</script>
<script>
    $("#situacao_note").change(

        function() {
            $('#observacao_note').hide();

            if (this.value == "2") {
                $('#observacao_note').show();
            }

        }

    );
</script>
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
<script src="../js/autocomplete_f.js"></script>
<!--PARA FORNECEDOR-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="../js/cnpj.js"></script>
<script src="../js/contrato_filho.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

</html>
<?php $conn->close(); ?>