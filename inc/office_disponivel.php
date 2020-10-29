<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   /*------------------------------------------------------------------------------------------------------------------*/
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }

require_once('../conexao/conexao.php');
require_once('../query/query.php');
require_once('header.php');
?>
<!--Chamando a Header-->
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
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<?php
        if($_GET['msn'] == 2){//encontrado porém o usuário está desativado
            echo "
                <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4>ATENÇÃO</h4>
                     Equipamento<b style='color:red'>  vinculado ao usuário</b> com sucesso! 
                </div>";
        }//end alerta erro 1
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
            <i class="icon-lithe far fa-check-circle"></i>&nbsp;
            <a href="equip_disponivel.php">Disponíveis</a>
        </h3>
        <div id="novo_usuario">
            <!--ADICIONAR NOVO EQUIPAMENTO-->
            <a class="btn btn-default btn-xs botao" href="add_new.php" title="Adicionar novo equipamento">
                <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
            </a>
            <!--RELATÓRIOS-->
            <a class="btn btn-default btn-xs botao" href="relatorio_tecnicos.php" title="Ralatórios">
                <i class='btn-icon-only icon-bar-chart' style="margin-left: -3px"> </i>
            </a>
            <!--CONDENADOS-->
            <a class="btn btn-default btn-xs botao" href="equip_condenados.php" title="Equipamentos condenados">
               <i class="far fa-trash-alt"></i> = <?= $row_condenados['condenados'] ?>
            </a>
            <!--DISPONIVEIS-->
            <a class="btn btn-default btn-xs botao" href="equip_disponivel.php" title="Equipamentos disponíveis">
               <i class="fas fa-laptop"></i> = <?= $row_disponivel['disponivel'] ?>
            </a>
            <!--SCANNERS-->
            <a class="btn btn-default btn-xs botao" href="scan_disponivel.php" title="Lista de Scanners">
               <i class="fas fa-print"></i> = <?= $row_scanner['scanner'] ?>
            </a>
            <!--OFFICE-->
            <a class="btn btn-default btn-xs botao" style="background-color: #00ff4e29;"  href="office_disponivel.php" title="Office Disponivéis">
               <i class="fab fa-windows"></i> = <?= $row_office['office'] ?>
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row" style="width: 111%; margin-left: -3%;">
        <table id="example" class="table table-striped table-bordered" style="font-size: 10px;">
            <thead>
                <tr>
                    <th class="titulo">Office</th>
                    <th class="titulo">Serial</th>
                    <th class="titulo">Locacao</th>
                    <th class="titulo">Empresa</th>
                    <th class="titulo">Fornecedor</th>
                    <th class="titulo">Numero Nota</th>
                    <th class="titulo">Nota Fiscal</th>
                    <th class="titulo">Data Nota</th>
                    <th class="titulo">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
//aplicando a query
while ($offiDisponivel = $resultOfficeDispo->fetch_assoc()) {
      
      echo "<tr>
               <td class='fonte'>".$offiDisponivel['versao']."</td>
               <td class='fonte'>".$offiDisponivel['serial']."</td>
               <td class='fonte'>".$offiDisponivel['locacao']."</td>
               <td class='fonte'>".$offiDisponivel['empresa']."</td>
               <td class='fonte'>".$offiDisponivel['fornecedor']."</td>
               <td class='fonte'>".$offiDisponivel['numero_nota']."</td>
               <td class='fonte  acao'>
                  <a href='office_edit_disponivel.php?id_equip=".$offiDisponivel['id']."' title='Editar' class='icon_acao'>
                     <i class='icon-folder-open' style='font-size: 12px;'></i>
                  </a>
                  <a href='#modalUsuario".$offiDisponivel['id']."' title='Vincular usuário' class='icon_acao' data-toggle='modal'>
                     <i class='fas fa-user-plus' style='font-size: 12px;'></i>
                  </a>
               </td>
            </tr>         
         <!--MODAL OFFICE VINCULAR-->
         <div id='modalUsuario".$offiDisponivel['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>Vincular o OFFICE - ".$offiDisponivel['versao']."</h3>
                  <hr>
                  <form id='edit-profile' class='form-horizontal' action='office_update.php' method='post'>
                     <div class='modal-body'>
                        <h3 id='myModalLabel'>
                           <img src='../img/alerta.png' style='width: 10%'>
                           VINCULAR A UM NOVO EQUIPAMENTO
                        </h3>
                        <div class='modal-body'>
                           <div id='button_pai'>
                              <h5>Deseja vincular o office</h5><p style='padding: 10px;background-color: aliceblue;color: red;'>Versão: ".$offiDisponivel['versao']."</p>
                                 <span style='color:red;font-size:9px;'></span>
                              <h5>a qual equipamento ?</h5>
                              <form class='form-horizontal' action='office_update_disponivel.php' method='POST' autocomplete='off' target='_blank'>
                                 <input type='text' style='display:none;' name='id_office' value='".$offiDisponivel['id']."'>
                                 <div class='control-group'>
                                    <label class='control-label'>Equipamento:</label>
                                    <div class='controls'>
                                       <select class='span2' style='margin-top: -40px; margin-left: 61px;' name='id_equipamento'>
                                       <option value=''>---</option>";
                                       $queryEquipDisponivel = ""
                                       echo "
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         ";//end tabela
}//end while
?>
            </tbody>
        </table>
    </div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
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
<!--MOSTRAR CAMPO ICONE-->
<script language="javascript">
  function abrir(){
    window.open("add_funcionario.php","mywindow","width=500,height=600");
}
</script>
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>
</html>