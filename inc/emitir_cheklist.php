<?php
//chamar a sessão
session_start();
//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.php');
} elseif ($_SESSION["perfil"] == 2) {
    header('location: ../front/error.php');
}

//chamando conexão com o banco
require_once('../conexao/conexao.php');
//chamando a header
require_once('header.php');

//informações sobre o equipamento
$equip_check = "SELECT 
                    MIE.id_equipamento, 
                    MIE.modelo, 
                    MIE.numero, 
                    MIE.tipo_equipamento,
                    MIE.imei_chip,
                    MDE.nome
                FROM 
                    manager_inventario_equipamento MIE
                LEFT JOIN
                    manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                WHERE 
                    id_funcionario = " . $_GET['id_fun'] . "";

$result_check = $conn->query($equip_check);
?>

<!--Chamando a Header-->
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
                <?php
                if ($_SESSION["perfil"] != 3) {
                    echo "
               <li>
                  <a href='inventario_equip.php'><i class='icon-cogs'></i>
                     <span>Equipamentos</span>
                  </a>
               </li>
               <li>
                  <a href='relatorio_auditoria.php'><i class='icon-list-alt'></i>
                     <span>Relatórios</span>
                  </a>
               </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<!--MODAL CHEK LIST-->
<div class="widget-header">
    <h3>
        <a href="inventario_ti.php"><i class="icon-home"></i> &nbsp; Home</a>
        /
        <a href="inventario.php"><i class="icon-group"></i> &nbsp; Colaboradores</a>
        /
        <a href="inventario_edit.php?id=<?= $_GET['id_fun'] ?>"><i class="icon-user"></i> &nbsp;
            <?= $_GET['nome'] ?></a>
        /
        <i class="fas fa-clipboard-list"></i> &nbsp;
        Chek-List
    </h3>
</div>
<?php
switch ($_GET['status']) {
    case '1':
        echo '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">×</button><h4>Atenção!</h4>Preencha o campo "3"!</div>';
        break;
}
?>
<!-- /widget-header -->
<h3 style="color: red;">
    <div class="titulo_check">
        <font style="vertical-align: inherit;">
            <i class="fas fa-clipboard-list"></i> CHECK-LIST!
        </font>
    </div>
</h3>
<div class="widget-content">
    <div class="tabbable">
        <div id="formulario">
            <form id='edit-profile' class='form-horizontal' action='form_checklist.php' method='post' autocomplete="off" target="_blank">
                <input name='id_fun' value='<?= $_GET['id_fun'] ?>' style='display: none' />
                <div class="control-group">
                    <div class="controls">
                        <h5>1-) Chek-List do funcionário:</h5>
                        <p class="subtitulo"><?= $_GET['nome'] ?></p>
                        <input name='nomeFuncionario' value='<?= $_GET['nome'] ?>' style='display: none' />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <h5>2-) Todos os equipamentos ?</h5>
                        <select class='span1 subtitulo' id='selectEquip' required>
                            <option value=''>---</option>
                            <option value='0'>Sim</option>
                            <option value='1'>Não</option>
                        </select>
                    </div>
                </div>

                <div id='equip_select' style='display: none'>
                    <div class="control-group">
                        <div class="controls">
                            <h5>3-) Escolha os equipamentos:</h5>
                            <ul class='ul_equip' id='list0'>
                                <?php
                                while ($linha_check = $result_check->fetch_assoc()) {
                                    if ($linha_check['tipo_equipamento'] == 3) {
                                        echo "
                                            <li class='li_equip'>
                                                <input type='checkbox' name='id_equip[]' value='" . $linha_check['id_equipamento'] . "'> " . $linha_check['nome'] . " | " . $linha_check['numero'] . "
                                            </li>";
                                    } else {
                                        echo "
                                            <li class='li_equip'>
                                                <input type='checkbox' name='id_equip[]' value='" . $linha_check['id_equipamento'] . "'> " . $linha_check['nome'] . " | " . $linha_check['modelo'] . " | " . $linha_check['imei_chip'] . "
                                            </li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <h5 style="color: red; font-weight: bold;">3-) Funcionário foi demitido ?</h5>
                        <select class="span1 subtitulo" id="selectEquip" name="demitido" required>
                            <option value="">---</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                        $queryLiberar = "SELECT distinct tipo_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$_GET['id_fun']."' AND tipo_equipamento != 8 LIMIT 1";
                        $resultLiberar = $conn -> query($queryLiberar);

                        if(!empty($liberar = $resultLiberar->fetch_assoc())){
                            echo '<button type="submit" tar="" class="btn btn-primary pull-right" id="salvarTermo">Emitir</button>';
                        }else{
                            echo '<div class="liberar">Funcionario possui equipamentos que não precisa emitir check-list</div>
                            <button type="submit" class="btn btn-primary pull-right" id="salvarTermo" disabled>Emitir</button>';
                        }
                    ?>                    
                </div>
            </form>
        </div>
    </div>
</div>

<!--ESCONDER UL-->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js' type='text/javascript'></script>
<script>
    $('#selectEquip').change(
        function() {
            $('#equip_select').hide();

            if (this.value == '1') {
                $('#equip_select').show();
            }
        }
    );
</script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>