<?php 
//aplicando para usar variavel em outro arquivo
session_start();
//ocultando erros do PHP
error_reporting(0);
ini_set(“display_errors”, 0 );

//chamando conexão com o banco
require 'conexao.php';
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
   header('location: index.html');

}elseif ($_SESSION["perfil"] != 0 AND $_SESSION["perfil"] != 2) {
   header('location: error.php');
}

//LIMITE POR PAGINA
$pagina = 20;


//colentando as mensagens
$mensagem = "SELECT * FROM maneger_comparacao_ocs limit ".$pagina." ";
$resultado_mensagem = mysqli_query($conn, $mensagem);

//contando quantos mensagens existem
$contador_msn = "SELECT COUNT(id) AS quantidade FROM maneger_comparacao_ocs";
$result_contador = mysqli_query($conn, $contador_msn);
$row_contador = mysqli_fetch_assoc($result_contador);

?>
<!DOCTYPE html>
<html>
<?php  require 'header.php';?>
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
                    <a href="#mensagem" data-toggle="tab">Mensagens</a>
                </li>
                <li>
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

                <!--MENSAGEM-->
                <div class="tab-pane active" id="mensagem" style='margin-top: -1px;'>
                    <div class="container">
                        <div class="row">
                            <div class="container">
                                <div class="row">
                                    <form action="relatorio_tecnicos_msn.php" method="POST" id="mensagem">
                                        <table id="example" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="check" onclick="checkAll(this)"></th>
                                                    <th>MENSAGEM</th>
                                                    <th>PATRIMÔNIO</th>
                                                    <th>SOFTWARE</th>
                                                    <th>MEMORIA</th>
                                                    <th>HD</th>
                                                    <th>PROCESSADOR</th>
                                                    <th>INSTALAÇÃO</th>
                                                    <th>OCS AGENT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                        //QUERY QUE IRÁ BUSCAR AS MENSAGENS
                        $buscar_mensagem = "SELECT 
                                                MCO.id,
                                                MCO.mensagem,
                                                MCO.patrimonio,
                                                MCO.software_atual,
                                                MCO.memoria,
                                                MCO.hd,
                                                MCO.processador,
                                                MCO.data_instalacao,
                                                MCO.data_last_agente
                                            FROM
                                                maneger_comparacao_ocs MCO limit 1000";
                        $resultado_buscar_mensagem = mysqli_query($conn, $buscar_mensagem);

                        //variavel para contagem das linhas
                        $contador = 1;

                        while($row_buscar_mensagem = mysqli_fetch_assoc($resultado_buscar_mensagem)){
                            echo "                           
                            <tr>
                                        <td><input type='checkbox' id='check_msn' name='mensagem[]' 
                                        onclick='checkOne(".$contador.")' value='".$row_buscar_mensagem['id']."'></td>";
                                            if($row_buscar_mensagem['mensagem'] == 0){
                                                echo "<td>Software</td>";
                                            }elseif($row_buscar_mensagem['mensagem'] == 1){
                                                echo "<td>+ 2 meses</td>";
                                            }else{
                                                echo "<td>Equipamento</td>";
                                            }
                            echo "
                                        <td>".$row_buscar_mensagem['patrimonio']."</td>
                                        <td>".$row_buscar_mensagem['software_atual']."</td>
                                        <td>".$row_buscar_mensagem['memoria']."</td>
                                        <td>".$row_buscar_mensagem['hd']."</td>
                                        <td>".$row_buscar_mensagem['processador']."</td>
                                        <td>".$row_buscar_mensagem['data_instalacao']."</td>
                                        <td>".$row_buscar_mensagem['data_last_agente']."</td>                                        
                                    </tr>";
                            $contador++;           
                        }//end WHILE resultado busca mensagem
                    ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>MENSAGEM</th>
                                                    <th>PATRIMÔNIO</th>
                                                    <th>SOFTWARE</th>
                                                    <th>MEMORIA</th>
                                                    <th>HD</th>
                                                    <th>PROCESSADOR</th>
                                                    <th>INSTALAÇÃO</th>
                                                    <th>OCS AGENT</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id='botao'>
                                            <button class="confirmar btn btn-info" type="submit" id="confirmar"
                                                for='mensagem' style="display:block; margin-top: -13px">Confirmar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--ALERTAS-->
                <?php
                if($_GET['msn'] == 1 ){
                    echo "
                    <body onload='load()'>
                    <div class='alert alert-info'>
                            <button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>Informação!</strong> Ocorrência resolvida com sucesso!
                        </div>

                            <script type='text/javascript'>
                            // INICIO FUNÇÃO DE MASCARA MAIUSCULA
                            function maiuscula(z) {
                                v = z.value.toUpperCase();
                                z.value = v;
                            }
                            //FIM DA FUNÇÃO MASCARA MAIUSCULA
                            </script>";
                }
                    ?>
                <!--POR COLABORADOR-->
                <div class="tab-pane" id="contratos">
                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_func.php" method="GET"
                        autocomplete='off'>
                        <div class="control-group">
                            <label class="control-label required">Nome Completo:</label>
                            <div class="controls">
                                <input class='span6' name='nome' type='text' onkeyup='maiuscula(this)'
                                    value='' />
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
                           //BUSCANDO OS DEPARTAMENTOS NO BANCO
                            $query_funcao = "SELECT * from maneger_dropfuncao WHERE deletar = 0 order by nome ASC;";
                            $resultado_funcao = mysqli_query($conn, $query_funcao);
                            while ($row_funcao = mysqli_fetch_assoc($resultado_funcao)) {
                              echo "<option value='".$row_funcao['id_funcao']."'>".$row_funcao['nome']."</option>";
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
                           //BUSCANDO OS DEPARTAMENTOS NO BANCO
                            $query_depart = "SELECT * from maneger_dropdepartamento WHERE deletar = 0 order by nome ASC;";
                            $resultado_depart = mysqli_query($conn, $query_depart);
                            while ($row_depart = mysqli_fetch_assoc($resultado_depart)) {
                              echo "<option value='".$row_depart['id_depart']."'>".$row_depart['nome']."</option>";
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
                           //BUSCANDO OS DEPARTAMENTOS NO BANCO
                            $query_empresa = "SELECT * from maneger_dropempresa WHERE deletar = 0 order by nome ASC;";
                            $resultado_empresa = mysqli_query($conn, $query_empresa);
                            while ($row_empresa = mysqli_fetch_assoc($resultado_empresa)) {
                              echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
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

                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_equip.php" method="GET"
                        autocomplete='off'>
                        <div class="control-group">
                            <label class="control-label required">Tipo de equipamento:</label>
                            <div class="controls">
                                <?php                     
                     echo "<select id='t_cob' name='eq' class='span2'>
                              <option value=''>---</option>";
                           //BUSCANDO OS DEPARTAMENTOS NO BANCO
                            $query_equip = "SELECT * from maneger_dropequipamentos WHERE id_equip IN (9, 5, 8) AND deletar = 0 order by nome ASC;";
                            $resultado_equip = mysqli_query($conn, $query_equip);
                            while ($row_equip = mysqli_fetch_assoc($resultado_equip)) {
                              echo "<option value='".$row_equip['id_equip']."'>".$row_equip['nome']."</option>";
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
                            $query_status = "SELECT * from maneger_dropstatusequipamento WHERE id_status IN (1, 10, 6) AND deletar = 0 order by nome ASC;";
                            $resultado_status = mysqli_query($conn, $query_status);
                            while ($row_status = mysqli_fetch_assoc($resultado_status)) {
                              echo "<option value='".$row_status['id_status']."'>".$row_status['nome']."</option>";
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

                    <form id="edit-profile" class="form-horizontal" action="relatorio_tec_nota.php" method="GET"
                        autocomplete='off'>

                        <div class="control-group">
                            <label class="control-label">Data:</label>
                            <div class="controls">
                                <input class='span2' name='in_date' type='date' /> até
                                <input class='span2' name='fi_date' type='date' />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Número:</label>
                            <div class="controls">
                                <input class='span2' name='nn' type='text' />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tipo:</label>
                            <div class="controls">
                                <select id='t_cob' name='tipo' class='span2'>
                                    <option value=''>---</option>
                                    <option value='0'>WINDOWS</option>
                                    <option value='1'>OFFICE</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Filial:</label>
                            <div class="controls">
                                <?php                     
                     echo "<select id='t_cob' name='fi' class='span2'>
                              <option value=''>---</option>";
                           //BUSCANDO OS DEPARTAMENTOS NO BANCO
                            $query_empresa = "SELECT * from maneger_dropempresa WHERE deletar = 0 order by nome ASC;";
                            $resultado_empresa = mysqli_query($conn, $query_empresa);
                            while ($row_empresa = mysqli_fetch_assoc($resultado_empresa)) {
                              echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
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

            </div>
        </div>
    </div>
</div>
</body>
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela_mensagem1.js"></script>
<script src="js/tabela_mensagem.js"></script>

<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="java.js"></script>
<script src="js/cnpj.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
</body>
<script src="js/tabela_relatorio_tecnico.js"></script>
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

<?php mysqli_close($conn); ?>

</html>