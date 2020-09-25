<?php
   session_start();
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
        header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
       header('location: ../front/error.php');
   }

require_once('header.php');

require_once('../conexao/conexao.php');

require_once('../query/query_dropdowns.php');

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
                        <span>Colaborares</span>
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
<!--FOMULARIO DE CONTRARO-->

<?php 
switch ($_GET['error']) {
    case '1':
        echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Você deve cadastrar no minimo um equipamento</div>";
        break;
    case '2':
        echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> NF com esse nome já existe. Por favor renomeie com outro nome!</div>";
        break;
}
?>
<div class="widget ">
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
            Novo Colaborador
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <div id="formulario">
                <!--Buscando inforação pelo apollo-->
                <?php
                if ($_GET['id_funcio'] != NULL) {//Quando For Edição
                    echo "<form id='form1' class='form-horizontal' action='inventario_new_equipamento.php' method='POST' enctype='multipart/form-data' autocomplete='off'>";
                }else{//Quando For Novo
                    echo "<form id='form1' class='form-horizontal' action='inventario_new.php' method='POST' enctype='multipart/form-data' autocomplete='off'>";
                }
                ?>
                <!--GAMBI PARA PEGAR O ID-->
                <input type="texte" name="id_funcionario" value="<?= $_GET['id_funcio']?>" style="display: none;">
                <input type="texte" name="id_equip" value="<?= $_GET['id_equip']?>" style="display: none;">
                <!--vai servir se caso o usuário ja é cadastrado ao vincular um equipamento-->
                <div class="control-group">

                    <h3 style="color: red;">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Cadastro - Colaborador / Responsável</font>
                        </font>
                    </h3>
                </div>
                <label class="control-label required" for='gols1' class="control-label required">CPF
                    Funcionário:</label>
                <div class="control-group">
                    <div class="controls">
                        <?php
                    if($_GET['id_funcio'] != NULL){//Se for ADICONAR UM EQUIPAMENTO
                        echo "<input name='gols1' id='CPF' class='cpfcnpj span2' type='text' value='".$_SESSION['new_cpf']."' required/> ";
                        unset($_SESSION['new_cpf']);

                    }elseif($_SESSION['cpf_vazia'] != NULL){ 
                        echo "<input name='gols1' id='gols1' class='cpfcnpj span2' type=text' value='".$_SESSION['cpf_vazia']."' onkeydown='javascript: fMasc( this, mCPF );'/>";
                            unset($_SESSION['cpf_vazia']);
                    }else{
                        echo "<input type='text' name='gols1' id='gols1' class='cpfcnpj span2' onkeydown='javascript: fMasc( this, mCPF );' autofocus>";
                    }   
                    ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Nome Completo:</label>
                    <div class="controls">
                        <?php 
                    if ($_GET['id_funcio']) {
                      echo "<input class='span6' name='nome_funcionario' type='text' value='".$_SESSION['new_nome']."' onkeypress='bloqueiaEspeciais()' />";
                      
                      }else{
                      echo "<input class='span6' name='nome_funcionario' type='text' onkeyup='maiuscula(this)' onkeypress='bloqueiaEspeciais()' value=''/>";
                    }
                    ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Função:</label>
                    <div class="controls">
                        <?php 
                    if ($_GET['id_funcio']) {
                      echo "<select id='t_cob' name='funcao_funcionario' class='span2' /> 
                              <option value='".$_SESSION['id_funcao']."'>".$_SESSION['new_funcao']."</option>
                            </select>";                      
                    }else{                    
                     echo "<select id='t_cob' name='funcao_funcionario' class='span2' required>                            
                              <option value=''>---</option>";
                            while ($row_funcao = $resultado_funcao->fetch_assoc()) {
                              echo "<option value='".$row_funcao['id_funcao']."'>".$row_funcao['nome']."</option>";
                            }
                            }
                      echo "</select>"
                          ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Departamento:</label>
                    <div class="controls">
                        <?php 
                            if ($_GET['id_funcio']) {
                                echo "<select id='t_cob' name='depart_funcionario' class='span2'>
                                        <option value='".$_SESSION['id_departamento']."'>".$_SESSION['new_departamento']."</option>";                      
                            }else{                    
                                echo "<select id='t_cob' name='depart_funcionario' class='span2' required>                            
                                    <option value=''>---</option>";
                                    while ($row_depart = $resultado_depart->fetch_assoc()) {
                                        echo "<option value='".$row_depart['id_depart']."'>".$row_depart['nome']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Empresa/Filial:</label>
                    <div class="controls">
                        <?php 
                        if ($_GET['id_funcio']) {
                            echo "<select id='t_cob' name='empresa_funcionario' class='span2' /><option value='".$_SESSION['id_empresa']."'>".$_SESSION['new_empresa']."</option>";
                        }else{                    
                            echo "<select id='t_cob' name='empresa_funcionario' class='span2' required><option value=''>---</option>";
                            while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label for="exampleFormControlTextarea1" class="control-label" style="margin-left: 7px;">
                        Observação:
                        <i class="icon-lithe icon-question-sign"
                            title="Caso queira colocar alguma observação no termo de responsabilidade, basta informar aqui!"></i>
                    </label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                        name="obs_termo"></textarea>
                </div>
                <div class="control-group" style="display: none;">
                    <label class="control-label required">Status:</label>
                    <div class="controls">
                        <select id="t_cob" name="status_funcionario" class="span2" required>
                            <option value="3">Falta Termo</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Equipamentos:</label>
                    <div class="controls">
                        <!--CELULAR-->
                        <label class="checkbox inline">
                            <a class="icone" href="javascript:;" onclick="mostrar('celular')" title="CELULAR">
                                <i class="fas fa-mobile-alt fa-2x"></i>
                            </a>
                        </label>
                        <!--TABLET-->
                        <label class="checkbox inline">
                            <a href="javascript:;" class="icone" onclick="mostrar('tablet')" title="TABLET">
                                <i class="fas fa-tablet-alt fa-2x"></i>
                            </a>
                        </label>
                        <!--CHIP-->
                        <label class="checkbox inline">
                            <a href="javascript:;" class="icone" onclick="mostrar('chip_celular')" title="CHIP CELULAR">
                                <i class="fas fa-sim-card fa-2x"></i>
                            </a>
                        </label>
                        <!--MODEM-->
                        <label class="checkbox inline">
                            <a href="javascript:;" class="icone" onclick="mostrar('modem')" title="MODEM 3G CLARO">
                                <i class="fas fa-wifi fa-2x"></i>
                            </a>
                        </label>
                    </div>
                    <!-- /controls -->
                </div>
                <!--CAMPO ESCONDIDOS CELULAR-->
                <?php
                 if ($_GET['id_equip'] != NULL) {

                   $celular = "SELECT 
                                    modelo, 
                                    MDS.nome AS situacao, 
                                    MIE.id_equipamento, 
                                    MIE.tipo_equipamento, 
                                    MDS.id_situacao, 
                                    MIE.imei_chip, 
                                    MIE.data_nota, 
                                    MIE.valor,
                                    MIE.estado AS id_estado,
                                    MDES.nome AS estado,
                                    MDE.nome AS filial, 
                                    MIE.filial AS id_filial
                                FROM manager_inventario_equipamento MIE
                                LEFT JOIN 
                                    manager_dropoperadora MDO ON MIE.operadora = MDO.id_operadora
                                LEFT JOIN 
                                    manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao 
                                LEFT JOIN 
                                    manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                                LEFT JOIN 
                                    manager_dropestado MDES ON MIE.estado = MDES.id
                                WHERE 
                                    MIE.id_equipamento = ".$_GET['id_equip']."";

                   $result_celular = $conn->query($celular);

                   $row_celular = $result_celular->fetch_assoc();

                    if ($row_celular['tipo_equipamento'] == 1) {//1=celular
                     echo "<div id='celular'>";
                     }else{
                      echo "<div id='celular' style='display: none;'>";
                    }

                  }else{
                     echo "<div id='celular' style='display: none;'>";
                  }
               ?>
                <hr>
                <div class="control-group">
                    <h3 style="color: #0029ff;">
                        <font style="vertical-align: inherit;">
                            <span onclick="fechar('celular')" style="cursor:pointer; color:red;" title="Fechar celular">
                                <i class="far fa-window-close" style="float: right;"></i>
                            </span>
                            <font style="vertical-align: inherit;"> CELULAR</font>
                        </font>
                    </h3>
                </div>
                <!--Campos Escondidos-->
                <label id="campos">
                    <div class="container">
                        <div class="row clearfix" style="width: 102%; margin-left: 0%;">
                            <div class="col-md-12 column" id="tab_logic_c">
                                <div class="control-group">
                                    <!--MODELO-->
                                    <label class="control-label">Modelo:</label>
                                    <div class="controls">
                                        <?php
                                            if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<input type='text' name='modelo_celular0' class='form-control input-md span3' value='".$row_celular['modelo']."' />
                                                <!--gambiarra-->
                                                <input type='text' value='".$_GET['id_equip']."' name='id_equip' style='display:none'/>";
                                                
                                            }else{
                                                echo "
                                                <div class='autocomplete' style='width:200px;'>
                                                    <input type='text' id='myInput1' name='modelo_celular0' class='form-control input-md span2'/>
                                                </div>
                                                ";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!--FILIAL-->
                                <div class="control-group">
                                    <label class="control-label">Filial:</label>
                                    <div class="controls">
                                        <select id="t_cob" name="filial_celular0" class="span2">
                                            <?php
                                                if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<option value='".$row_celular['id_filial']."'>".$row_celular['filial']."</option>                                                
                                                        <option>---</option>";
                                                    while ($row_cel_filial = $resultado_empresa->fetch_assoc()) {
                                                        echo "<option value='".$row_cel_filial['id_empresa']."'>".$row_cel_filial['nome']."</option>";
                                                    }
                                                }else{
                                                    echo "<option>---</option>";
                                                    while ($row_cel_filial = $resultado_empresa->fetch_assoc()) {
                                                        echo "<option value='".$row_cel_filial['id_empresa']."'>".$row_cel_filial['nome']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--SITUAÇÃO-->
                                <div class="control-group">
                                    <label class="control-label">Situação:</label>
                                    <div class="controls">
                                        <select id="t_cob" name="situacao_celular0" class="span2">
                                            <?php
                                                if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<option value='".$row_celular['id_situacao']."'>".$row_celular['situacao']."</option>
                                                      <option>---</option>";
                                                    while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                                                        echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                                    }
                                                }else{
                                                    echo "<option>---</option>";
                                                    while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                                                        echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--STATUS-->
                                <div class="control-group">
                                    <label class="control-label">Estado:</label>
                                    <div class="controls">
                                        <select id="t_cob" name="status_celular0" class="span2">
                                            <?php
                                                if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<option value='".$row_celular['id_estado']."'>".$row_celular['estado']."</option>
                                                        <option>---</option>";
                                                        while ($row_status = $resultado_status->fetch_assoc()) {
                                                            echo "<option value='".$row_status['id']."'>".$row_status['nome']."</option>";
                                                        }
                                                }else{
                                                    echo "<option>---</option>";
                                                    while ($row_status = $resultado_status->fetch_assoc()) {
                                                    echo "<option value='".$row_status['id']."'>".$row_status['nome']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--ACESSORIOS-->
                                <div class="control-group">
                                    <label class="control-label">Acessórios:</label>
                                    <div class="controls">
                                        <?php 
                                        if ($row_celular['tipo_equipamento'] == 1) {

                                            $query_acessorio_cel = "SELECT
                                                                        MDA.id_acessorio,  
                                                                        MIA.tipo_acessorio, 
                                                                        MDA.nome AS acessorios
                                                                    FROM 
                                                                        manager_inventario_acessorios MIA
                                                                    LEFT JOIN 
                                                                        manager_dropacessorios MDA ON MIA.tipo_acessorio = MDA.id_acessorio
                                                                    WHERE 
                                                                        MIA.id_equipamento =".$row_celular['id_equipamento']."  ORDER BY MDA.nome ASC";

                                            $resultado_acessorio_cel = $conn->query($query_acessorio_cel);

                                            while ($row_acessorio_cel = $resultado_acessorio_cel->fetch_assoc()) {
                                            echo "
                                            <label class='checkbox inline'>
                                                <input type='checkbox' name='acessorio_celular0[]' value='".$row_acessorio_cel['id_acessorio']."' checked='checked'> ".$row_acessorio_cel['acessorios']."
                                            </label>
                                            </br>";
                                            }

                                            $res_query = "SELECT
                                                                MDA.id_acessorio
                                                            FROM 
                                                                manager_dropacessorios MDA
                                                            LEFT JOIN 
                                                                manager_inventario_acessorios MIA ON MIA.tipo_acessorio = MDA.id_acessorio
                                                            WHERE 
                                                                MIA.id_equipamento = ".$row_celular['id_equipamento']."";

                                            $res = $conn->query($res_query);
                                            //mostrando acessórios que não fazem parte deste equipamento
                                            $mostrar_acessorios = "SELECT
                                                                        *
                                                                    FROM 
                                                                        manager_dropacessorios
                                                                    WHERE 
                                                                        id_acessorio NOT IN (";

                                            while($row_acessorio = $res->fetch_assoc()){

                                                $mostrar_acessorios .= $row_acessorio['id_acessorio'].",";

                                            }

                                            $mostrar_acessorios .= "'') AND deletar = 0";

                                            $result_acess = $conn->query($mostrar_acessorios);

                                            while($row_acess = $result_acess->fetch_assoc()){
                                            echo "
                                                <label class='checkbox inline'>
                                                    <input type='checkbox' name='acessorio_celular0[]' value='".$row_acess['id_acessorio']."' > ".$row_acess['nome']."
                                                </label>
                                                </br>";
                                            }
                                        }else{
                                            
                                            while ($row_acessorio_cel = $resultado_acessorio->fetch_assoc()) {
                                                echo "<label class='checkbox inline'>
                                                        <input type='checkbox' name='acessorio_celular0[]' value='".$row_acessorio_cel['id_acessorio']."'> ".$row_acessorio_cel['nome']."
                                                    </label></br>";
                                            }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!--IMEI-->
                                <div class="control-group">
                                    <label class="control-label">Imei:</label>
                                    <div class="controls">
                                        <?php 
                                            if ($row_celular['tipo_equipamento'] == 1) {
                                            echo "<input type='text' name='imei_celular0' class='form-control span2' value='".$row_celular['imei_chip']."' />";                        
                                            }else{
                                            echo "<input type='text' name='imei_celular0' class='form-control span2'/>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!--VALOR-->
                                <div class="control-group">
                                    <label class="control-label">Valor:</label>
                                    <div class="controls">
                                        <span class="add-on">$</span>
                                        <?php
                                            if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<input type='text' name='valor0' class='form-control span1' value='".$row_celular['valor']."' onKeyPress=return(MascaraMoeda(this,'.',',',event))>";                        
                                            }else{
                                                echo "<input type='text' name='valor0' class='form-control span1' onKeyPress=return(MascaraMoeda(this,'.',',',event)) />";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!--DATA DA NOTA-->
                                <div class="control-group">
                                    <label class="control-label">Data nota fiscal:</label>
                                    <div class="controls">
                                        <?php 
                                            $date_nota_cel = date("d/m/Y", strtotime($row_celular['data_nota']));
                                            if ($row_celular['tipo_equipamento'] == 1) {
                                                echo "<input type='text' name='data_nota_celular0' class='form-control span2' value='".$date_nota_cel."' />";                        
                                            }else{
                                                echo "<input type='text' name='data_nota_celular0' class='form-control span2' placeholder='DD / MM / AAAA'/>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!--FILE DA NOTA-->
                                <div class="control-group">
                                    <label class="control-label">Nota fiscal:</label>
                                    <div class="controls">
                                        <input type='file' name='file_nota_celular0' class='form-control-file span2' />
                                    </div>
                                </div>
                                <div class="col-md-12 column" id='addrC1'></div>
                            </div>
                        </div>
                        <a id='celular_add' class='btn btn-success pull-left' title="Incluir equipamento">
                            <i class='fas fa-plus'></i>
                        </a>
                        <a id='celular_remover' class='pull-right btn btn-danger excluir' title='Excluir equipamento'>
                            <i class="fas fa-minus"></i>
                        </a>
                    </div>
                </label>
            </div>
            <!--Campos Escondidos-->
            <!--CAMPO ESCONDIDOS TABLET-->
            <?php
                 if ($_GET['id_equip'] != NULL) {

                   $tablet = "SELECT 
                                modelo, 
                                MDST.nome AS situacao, 
                                MIE.id_equipamento, 
                                MIE.tipo_equipamento, 
                                MDST.id_situacao, 
                                MIE.imei_chip, 
                                MIE.data_nota, 
                                MIE.valor,
                                MIE.patrimonio,
                                MIE.estado AS id_estado, 
                                MDES.nome AS estado,
                                MDE.nome AS filial, 
                                MIE.filial AS id_filial
                            FROM 
                                manager_inventario_equipamento MIE
                            LEFT JOIN 
                                manager_dropoperadora MDO ON MIE.operadora = MDO.id_operadora
                            LEFT JOIN 
                                manager_dropsituacao MDST ON MIE.situacao = MDST.id_situacao 
                            LEFT JOIN 
                                manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                            LEFT JOIN
                                manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
                            LEFT JOIN
                                manager_dropestado MDES ON MIE.estado = MDES.id
                            WHERE 
                                MIE.id_equipamento = ".$_GET['id_equip']."";

                   $result_tablet = $conn->query($tablet);
                   $row_tablet = $result_tablet->fetch_assoc();

                    if ($row_tablet['tipo_equipamento'] == 2) {//2=tablet
                     echo "<div id='tablet'>";
                     }else{
                      echo "<div id='tablet' style='display: none;'>";
                    }
                  }else{
                     echo "<div id='tablet' style='display: none;'>";
                  }
               ?>
            <hr>
            <div class="control-group">
                <h3 style="color: #0029ff;">
                    <font style="vertical-align: inherit;">
                        <span onclick="fechar('tablet')" style="cursor:pointer; color:red;" title="Fechar">
                            <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;"> TABLET</font>
                    </font>
                </h3>
            </div>
            <!--Campos Escondidos-->
            <label id="campos">
                <div class="container">
                    <div class="row clearfix" style="width: 102%;margin-left: 0%;">
                        <div class="col-md-12 column" id="tab_logic_t">
                            <!--MODELO-->
                            <div class="control-group">
                                <label class="control-label">Modelo:</label>
                                <div class="controls">
                                    <?php
                                        if ($row_tablet['tipo_equipamento'] == 2) {
                                            echo "<input type='text' name='modelo_tablet0' class='form-control input-md span3' value='".$row_tablet['modelo']."' />
                                            <!--gambiarra-->
                                            <input type='text' value='".$_GET['id_equip']."' name='id_equip' style='display:none'/>";
                                        }else{
                                            echo "
                                            <div class='autocomplete' style='width:200px;'>
                                                <input type='text' id='myInput' name='modelo_tablet0' class='form-control input-md span2'/>
                                            </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--PATRIMONIO-->
                            <div class="control-group">
                                <label class="control-label">Patrimônio:</label>
                                <div class="controls">
                                    <?php
                                        if ($row_tablet['tipo_equipamento'] == 2) {
                                            echo "<input type='text' name='patrimonio_tablet0' class='form-control input-md span3' value='".$row_tablet['patrimonio']."' />
                                            <!--gambiarra-->
                                            <input type='text' value='".$_GET['id_equip']."' name='id_equip' style='display:none'/>";
                                        }else{
                                            echo "
                                            <div class='autocomplete' style='width:200px;'>
                                                <input type='text' id='myInput' name='patrimonio_tablet0' class='form-control input-md span1'/>
                                            </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--FILIAL-->
                            <div class="control-group">
                                <label class="control-label">Filial:</label>
                                <div class="controls">
                                    <select id="t_cob" name="filial_tablet0" class="span2">
                                        <?php
                                            if ($row_tablet['tipo_equipamento'] == 2) {
                                                echo "<option value='".$row_tablet['id_filial']."'>".$row_tablet['filial']."</option>
                                                    <option>---<option>";
                                                    while ($row_tablet_filial = $resultado_empresa->fetch_assoc()) {
                                                    echo "<option value='".$row_tablet_filial['id_empresa']."'>".$row_tablet_filial['nome']."</option>";
                                                }
                                            }else{
                                                echo "<option>---</option>";
                                                    while ($row_tablet_filial = $resultado_empresa->fetch_assoc()) {
                                                    echo "<option value='".$row_tablet_filial['id_empresa']."'>".$row_tablet_filial['nome']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--SITUAÇÃO-->
                            <div class="control-group">
                                <label class="control-label">Situação:</label>
                                <div class="controls">
                                    <select id="t_cob" name="situacao_tablet0" class="span2">
                                        <?php
                                            if ($row_tablet['tipo_equipamento'] == 2) {
                                                echo "<option value='".$row_tablet['id_situacao']."'>".$row_tablet['situacao']."</option>                                                
                                                <option>---<option>";
                                                while ($row_situacao_tablet = $resultado_situacao->fetch_assoc()) {
                                                    echo "<option value='".$row_situacao_tablet['id_situacao']."'>".$row_situacao_tablet['nome']."</option>";
                                                }
                                            }else{
                                                echo "<option>---</option>";
                                                while ($row_situacao_tablet = $resultado_situacao->fetch_assoc()) {
                                                    echo "<option value='".$row_situacao_tablet['id_situacao']."'>".$row_situacao_tablet['nome']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--ESTADO-->
                            <div class="control-group">
                                <label class="control-label">Estado:</label>
                                <div class="controls">
                                    <select id="t_cob" name="status_tablet0" class="span2">
                                        <?php
                                                if ($row_tablet['tipo_equipamento'] == 2) {
                                                echo "<option value='".$row_tablet['id_estado']."'>".$row_tablet['estado']."</option>
                                                        <option>---</option>";
                                                    while ($row_status_tablet = $resultado_status->fetch_assoc()) {
                                                    echo "<option value='".$row_status_tablet['id']."'>".$row_status_tablet['nome']."</option>";
                                                    }
                                                }else{
                                                    echo "<option>---</option>";
                                                    while ($row_status_tablet = $resultado_status->fetch_assoc()) {
                                                    echo "<option value='".$row_status_tablet['id']."'>".$row_status_tablet['nome']."</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <!--ACESSORIOS-->
                            <div class="control-group">
                                <label class="control-label">Acessórios:</label>
                                <div class="controls">
                                    <?php 
                                        if ($row_tablet['tipo_equipamento'] == 2) {

                                            $query_acessorio_tab = "SELECT
                                                                        MDA.id_acessorio,  
                                                                        MIA.tipo_acessorio, 
                                                                        MDA.nome AS acessorios
                                                                    FROM 
                                                                        manager_inventario_acessorios MIA
                                                                    LEFT JOIN 
                                                                        manager_dropacessorios MDA ON MIA.tipo_acessorio = MDA.id_acessorio
                                                                    WHERE 
                                                                        MIA.id_equipamento =".$row_tablet['id_equipamento']."  ORDER BY MDA.nome ASC";

                                            $resultado_acessorio_tab = $conn->query($query_acessorio_tab);

                                            while ($row_acessorio_tab = mysqli_fetch_assoc($resultado_acessorio_tab)) {
                                            echo "
                                            <label class='checkbox inline'>
                                                <input type='checkbox' name='acessorio_tablet0[]' value='".$row_acessorio_tab['id_acessorio']."' checked='checked'> ".$row_acessorio_tab['acessorios']."
                                            </label>
                                            </br>";
                                            }

                                            $res_query = "SELECT
                                                                MDA.id_acessorio
                                                            FROM 
                                                                manager_dropacessorios MDA
                                                            LEFT JOIN 
                                                                manager_inventario_acessorios MIA ON MIA.tipo_acessorio = MDA.id_acessorio
                                                            WHERE 
                                                                MIA.id_equipamento = ".$row_celular['id_equipamento']."";

                                            $res = $conn->query($res_query);
                                            //mostrando acessórios que não fazem parte deste equipamento
                                            $mostrar_acessorios = "SELECT
                                                                        *
                                                                    FROM 
                                                                        manager_dropacessorios
                                                                    WHERE 
                                                                        id_acessorio NOT IN (";

                                            while($row_acessorio = $res->fetch_assoc()){

                                                $mostrar_acessorios .= $row_acessorio['id_acessorio'].",";

                                            }

                                            $mostrar_acessorios .= "'') AND deletar = 0";

                                            $result_acess = $conn->query($mostrar_acessorios);

                                            while($row_acess = $result_acess->fetch_assoc()){
                                            echo "
                                                <label class='checkbox inline'>
                                                    <input type='checkbox' name='acessorio_tablet0[]' value='".$row_acess['id_acessorio']."' > ".$row_acess['nome']."
                                                </label>
                                                </br>";
                                            }
                                        }else{
                                            while ($row_acessorio_tab = $resultado_acessorio->fetch_assoc()) {
                                                echo "<label class='checkbox inline'>
                                                <input type='checkbox' name='acessorio_tablet0[]' value='".$row_acessorio_tab['id_acessorio']."'> ".$row_acessorio_tab['nome']."
                                                </label></br>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--IMEI-->
                            <div class="control-group">
                                <label class="control-label">Imei:</label>
                                <div class="controls">
                                    <?php 
                                        if ($row_tablet['tipo_equipamento'] == 2) {
                                            echo "<input type='text' name='imei_tablet0' class='form-control span2' value='".$row_tablet['imei_chip']."' />";                        
                                        }else{
                                            echo "<input type='text' name='imei_tablet0' class='form-control span2'/>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--VALOR-->
                            <div class="control-group">
                                <label class="control-label">Valor:</label>
                                <div class="controls">
                                    <span class="add-on">$</span>
                                    <?php
                                        if ($row_tablet['tipo_equipamento'] == 2) {
                                            echo "<input type='text' name='valor_tablet0' class='form-control span1' value='".$row_tablet['valor']."' onKeyPress=return(MascaraMoeda(this,'.',',',event))>";                        
                                        }else{
                                            echo "<input type='text' name='valor_tablet0' class='form-control span1' onKeyPress=return(MascaraMoeda(this,'.',',',event)) />";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--DATA NOTA-->
                            <div class="control-group">
                                <label class="control-label">Data nota fiscal:</label>
                                <div class="controls">
                                    <?php 
                                        $date_nota_tablet = date("d/m/Y", strtotime($row_tablet['data_nota']));
                                        if ($row_tablet['tipo_equipamento'] == 2) {
                                            echo "<input type='text' name='data_nota_tablet0' class='form-control span2'/ value='".$date_nota_tablet."' />";                        
                                        }else{
                                            echo "<input type='text' name='data_nota_tablet0' class='form-control span2' placeholder='DD / MM / AAAA' />";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!--FILE DA NOTA-->
                            <div class="control-group">
                                <label class="control-label">Nota fiscal:</label>
                                <div class="controls">
                                    <input type='file' name='file_nota_tablet0' class='form-control-file span2' />
                                </div>
                            </div>
                            <div class="col-md-12 column" id='addrT1'></div>
                        </div>
                    </div>
                    <a id="tablet_row" class="btn btn-success pull-left" title="Incluir equipamento">
                        <i class='fas fa-plus'></i>
                    </a>
                    <a id='tablet_remover' class="pull-right btn btn-danger excluir" title='Excluir equipamento'>
                        <i class="fas fa-minus"></i>
                    </a>
                </div>
            </label>
        </div>
        <!--Campos Escondidos-->
        <!--CAMPO ESCONDIDOS CHIP-CELULAR-->
        <?php
               if (isset($_GET['id_equip'])) {                 
                    $chip = "SELECT 
                        MIE.operadora AS id_operadora, 
                        MDO.nome AS nome_operadora, 
                        MIE.numero, 
                        MIE.planos_voz, 
                        MIE.planos_dados, 
                        MIE.status, 
                        MIE.imei_chip, 
                        MIE.tipo_equipamento
                    FROM 
                        manager_inventario_equipamento MIE
                    LEFT JOIN 
                        manager_dropoperadora MDO ON MIE.operadora = MDO.id_operadora 
                    WHERE 
                        MIE.id_equipamento = ".$_GET['id_equip']."";
                    $result_chip = $conn->query($chip);
                    $row_chip = $result_chip->fetch_assoc();

                    if ($row_chip['tipo_equipamento'] == 3) {//3=chip
                        echo "<div id='chip_celular'>";
                    }else{echo "<div id='chip_celular' style='display: none;'>";}

                }else{
                    echo "<div id='chip_celular' style='display: none;'>";
                } 
            ?>
        <hr>
        <div class="control-group">
            <h3 style="color: #0029ff;">
                <font style="vertical-align: inherit;">
                    <span onclick="fechar('chip_celular')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                    </span>
                    <font style="vertical-align: inherit;"> CHIP</font>
                </font>
            </h3>
        </div>
        <!--Campos Escondidos-->
        <label id="campos">
            <div class="container">
                <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                    <div class="col-md-12 column">
                        <table class="table table-bordered table-hover" id="tab_logic_ch">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Operadora
                                    </th>
                                    <th class="text-center">
                                        Número
                                    </th>
                                    <th class="text-center">
                                        Planos
                                    </th>
                                    <th class="text-center">
                                        Imei CHIP
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addrCH0'>
                                    <td>
                                        <select id="t_cob" name="operadora_chip0" class="span2">
                                            <?php
                                            if ($row_chip['tipo_equipamento'] == 3) {
                                                echo "<option value='".$row_chip['id_operadora']."'>".$row_chip['nome_operadora']."</option>";
                                            }else{                                            
                                                while ($row_operadora = $resultado_operadora->fetch_assoc()) {
                                                    echo "<option value='".$row_operadora['id_operadora']."'>".$row_operadora['nome']."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if ($row_chip['tipo_equipamento'] == 3) {
                                            echo "<input type='text' name='numero_chip0' onkeydown='javascript: fMasc( this, mTel );' class='form-control span2' value='".$row_chip['numero']."' ><input type='text' value='".$_GET['id_equip']."' name='id_equip' style='display:none'/>";
                                          }else{
                                            echo "<input type='text' name='numero_chip0' onkeydown='javascript: fMasc( this, mTel );' class='form-control span2'>";
                                          } ?>
                                    </td>
                                    <td>
                                        <?php 
                                          if ($row_chip['tipo_equipamento'] == 3) {
                                            //voz
                                            if ($row_chip['planos_voz'] != NULL) {
                                              echo "<label class='checkbox inline'>
                                                        <input type='checkbox' name='voz0' value='".$row_chip['planos_voz']."' checked='checked' onclick='return false;'>Voz
                                                    </label>";
                                            }else{
                                              echo "<label class='checkbox inline'>
                                                        <input type='checkbox' name='voz0' value='Voz' onclick='return false;'>Voz
                                                    </label>";
                                            }
                                            //dados
                                           if ($row_chip['planos_dados'] != NULL) {
                                              echo "
                                              <label class='checkbox inline'>
                                                <input type='checkbox' name='dados0' value='".$row_chip['planos_dados']."' checked='checked' onclick='return false;'>Dados
                                              </label>";
                                            } else{
                                              echo "<label class='checkbox inline'>
                                            <input type='checkbox' name='dados0' value='Dados' onclick='return false;'>Dados
                                          </label>";
                                            }

                                          }else{
                                            echo "<label class='checkbox inline'>
                                            <input type='checkbox' name='voz0' value='Voz'>Voz
                                          </label>
                                          <label class='checkbox inline'>
                                            <input type='checkbox' name='dados0' value='Dados'>Dados
                                          </label>";
                                          }?>

                                    </td>
                                    <td style="display: none;">
                                        <?php if ($row_chip['tipo_equipamento'] == 3) {
                                          echo "<input type='text' name='status_chip0' class='form-control span3' value='".$row_chip['status']."'/>";
                                        }else{
                                          echo "<input type='text' name='status_chip0' class='form-control span3' />";
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($row_chip['tipo_equipamento'] == 3) {
                                          echo "<input type='text' name='imei_chip0' class='form-control span3' value='".$row_chip['imei_chip']."' />";
                                        }else{
                                          echo "<input type='text' name='imei_chip0' class='form-control span3'/>";
                                        } ?>
                                    </td>
                                </tr>
                                <tr id='addrCH1'></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <a id="chip_row" class="btn btn-success pull-left">Adicionar Linhas</a><a id='chip_remover'
                    class="pull-right btn btn-danger excluir">Excluir Linhas</a>
            </div>
        </label>
    </div>
    <!--Campos Escondidos-->
    <!--CAMPO ESCONDIDOS MODEM-->
    <div id="modem" style="display: none;">
        <hr>
        <div class="control-group">
            <h3 style="color: #0029ff;">
                <font style="vertical-align: inherit;">
                    <span onclick="fechar('modem')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                    </span>
                    <font style="vertical-align: inherit;">MODEM</font>
                </font>
            </h3>
        </div>
        <!--Campos Escondidos-->
        <label id="campos">
            <div class="container">
                <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                    <div class="col-md-12 column">
                        <table class="table table-bordered table-hover" id="tab_logic_m">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Modelo
                                    </th>
                                    <th class="text-center">
                                        Número
                                    </th>
                                    <th class="text-center">
                                        Operadora
                                    </th>
                                    <th class="text-center">
                                        Imei Modem
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addrM0'>
                                    <td>
                                        <input type='text' name='modelo_modem' class='form-control span4' />
                                    </td>
                                    <td>
                                        <input type="text" name='numero_modem'
                                            onkeydown="javascript: fMasc( this, mTel );" class='form-control span2'>
                                    </td>
                                    <td>
                                        <select id="t_cob" name="operadora_modem" class="span2">
                                            <?php
                                             while ($row_operadora = $resultado_operadora->fetch_assoc()) {
                                               echo "<option value='".$row_operadora['id_operadora']."'>".$row_operadora['nome']."</option>";
                                             }
                                             ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type='text' name='imei_modem' class='form-control span4' />
                                    </td>
                                </tr>
                                <tr id='addrM1'></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </label>
    </div>
    <!--Campos Escondidos-->
    <div class="form-actions">
        <?= ($_GET['id_equip'] != NULL && $_GET['id_funcio'] != NULL) ? '<a href="inventario_add_plus.php?id_funcio='.$_GET['id_funcio'].'&id_equip='.$_GET['id_equip'].'" class="btn btn-primary pull-right" id="salvarTermo">Salvar + Termo</a>' : '<button type="submit" class="btn btn-primary pull-right" id="salvarTermo">Salvar + Termo</button>' ?>
    </div>
    </form>
</div>
</div>
</div>
</div>
</body>
<!-- BLOQUEAR BOTÃO SALVAR QUANDO CLICAR MAIS DE UM VEZ!! -->
<script>
document.getElementById("salvarTermo").onclick = function() {
    this.disabled = true;
    document.getElementById("form1").submit();
}
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

<script>
function bloqueiaEspeciais(e) {
    //Bloqueia os caracteres acentuados e especiais
    if (!e) e = event;
    if (e.keyCode) {
        //IE
        tecla = e.keyCode;
    } else {
        //Firefox
        tecla = e.which;
    }
    if ((tecla >= 32 && tecla <= 90) ||
        (tecla >= 97 && tecla <= 122) ||
        (tecla >= 48 && tecla <= 57) ||
        (tecla == 46)) {
        //Não bloqueia
    } else {
        //Bloqueia
        if (e.keyCode) {
            e.returnValue = false;
            alert("Não é permitido acentuação!")
        } else {
            e.preventDefault();
        }
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
<!--Buscando informação do Apollo-->
<script type="text/javascript">
//Buscar CNPJ no Apollo
(function() {

    var $gols1 = document.getElementById('gols1');

    function handleSubmit() {
        if ($gols1.value)
            document.getElementById('form1').submit();
    }
    $gols1.addEventListener('blur', handleSubmit);
})();
</script>
<script src="../js/autocomplete.js"></script>
<!--PARA MODELOS CELULAR-->
<script src="../js/autocomplete_t.js"></script>
<!--PARA MODELOS TABLET-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="../js/cnpj.js"></script>
<script src="../js/contrato_filho.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

</html>
<?php   $conn->close(); ?>