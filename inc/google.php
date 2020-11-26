<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
require_once('header.php');

//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.html');
} elseif (($_SESSION["perfil"] != 0) and ($_SESSION["perfil"] != 2) and ($_SESSION["perfil"] != 4)) {

    header('location: ../front/error.php');
}

?>
<!--Chamando a Header-->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li><a href="tecnicos_ti.php"><i class="icon-home"></i><span>Home</span> </a> </li>
                <li><a href="equip.php"><i class="icon-table"></i><span>Inventário</span> </a> </li>
                <li class="active"><a href="google.php"><i class="icon-search"></i><span>Google T.I</span> </a></li>
                <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<a class="botao" href="google_insert.php" title="Inserir nova Info">
    <i class='btn-icon-only icon-plus fa fa-2x' style="margin-left: -3px;color: #3780ff;"> </i>
</a>
<div class="tab-content">
    <div class="tab-pane active google" id="formcontrols">
        <form id="edit-profile" class="form-horizontal" action="search.php" method="POST" autocomplete="off">
            <fieldset>
                <div class="control-group">
                    <div class="controls">
                        <img src="../img/google_servopa.png" class="rounded mx-auto d-block" style="width: 80%;">
                        <div class="controls" style="margin-top: 30px; margin-left: -14px;">
                            <div class="input-append">
                                <input class="span8 m-wrap"  name="pesquisa" id="appendedInputButton" type="text" style="height: 27px;">
                                <button class="btn" type="submit" style="height: 37px">Buscar</button>
                            </div>
                        </div>
                    </div> <!-- /controls -->
                </div> <!-- /form-actions -->
            </fieldset>
        </form>
    </div>
</div>
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>