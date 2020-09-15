<?php
//chamar a sessão
session_start();
//chamando conexão com o banco
require 'conexao.php';
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
    header('location: index.html');
}elseif ($_SESSION["perfil"] == 2) {
    header('location: error.php');
}

//chamando a header
require 'header.php'
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
            if($_SESSION["perfil"] != 3){
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
<!-- /widget-header -->
<h3 style="color: red;">
    <div class="titulo_check">
        <font style="vertical-align: inherit;" style="margin-top">
            <i class="fas fa-clipboard-list"></i> CHEK-LIST!
        </font>
    </div>
</h3>
<div class="widget-content">
    <div class="tabbable">
        <div id="formulario">
            <form id='edit-profile' class='form-horizontal' action='form_checklist.php' method='post'
                style="margin-left: -12%" autocomplete="off" target="_blank">
                <input name='id_fun' value='<?php echo $_GET['id_fun'] ?>' style='display: none' />
                <div class="control-group">
                    <div class="controls">
                        <h5>1-) Chek-List do funcionário:</h5>
                        <p class="subtitulo"><?php echo $_GET['nome'] ?></p>
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
                                    $equip_check = "SELECT 
                                    MIE.id_equipamento, 
                                    MIE.modelo, 
                                    MIE.numero, 
                                    MIE.tipo_equipamento,
                                    MDE.nome
                                    FROM 
                                    manager_inventario_equipamento MIE
                                    LEFT JOIN
                                    manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                                    WHERE 
                                    id_funcionario = ".$_GET['id_fun']."";
                                    $result_check = mysqli_query($conn, $equip_check);

                                    while($linha_check = mysqli_fetch_assoc($result_check)){
                                        if($linha_check['tipo_equipamento'] == 3){
                                            echo "
                                            <li class='li_equip'>
                                                <input type='checkbox' name='id_equip[]' value='".$linha_check['id_equipamento']."'> ".$linha_check['nome']." | ".$linha_check['numero']."
                                            </li>";
                                        }else{
                                            echo "
                                            <li class='li_equip'>
                                                <input type='checkbox' name='id_equip[]' value='".$linha_check['id_equipamento']."'> ".$linha_check['nome']." | ".$linha_check['modelo']."
                                            </li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" tar class="btn btn-primary pull-right" id="salvarTermo">Emitir</button>
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