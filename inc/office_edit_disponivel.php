<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
       header('location: ../front/error.php');
   }   
    
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');   
   require_once('../query/query_dropdowns.php');  
   require_once('header.php');

?>
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li>
                    <a href="tecnicos_ti.php"><i class="icon-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="active">
                    <a href="equip.php"><i class="icon-table"></i>
                        <span>Inventário</span>
                    </a>
                </li>
                <li>
                    <a href="google.php"><i class="icon-search"></i>
                        <span>Google T.I</span>
                    </a>
                </li>
                <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="widget ">
<?php

   //recebendo a informação e distribuindo nos campos do formulario
   $query_contrato = "SELECT 
                        OF.id,
                        OF.status,
                        OF.locacao AS id_locacao,
                        MDL.nome AS locacao,
                        OF.empresa AS id_empresa,
                        MDE.nome AS empresa,
                        MDOF.nome AS versao,
                        OF.versao AS id_versao,
                        OF.serial,
                        OF.fornecedor,
                        OF.numero_nota,
                        OF.file_nota,
                        OF.file_nota_nome AS nomeNota,
                        OF.data_nota
                    FROM 
                        manager_office OF
                    LEFT JOIN 
                        manager_droplocacao MDL ON OF.locacao = MDL.id_empresa
                    LEFT JOIN 
                        manager_dropempresa MDE ON OF.empresa = MDE.id_empresa
                    LEFT JOIN 
                        manager_dropoffice MDOF ON OF.versao = MDOF.id
                    WHERE OF.id = ".$_GET['id']."";

   $resultado = $conn->query($query_contrato);
   $row = $resultado->fetch_assoc(); 

   ?>
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="tecnicos_ti.php">Home</a>
            /
            <i class="icon-lithe icon-table"></i>&nbsp;
            <a href="equip.php">Inventário</a>
            /
            <i class="fab fa-windows"></i>&nbsp;
            <a href="office_disponivel.php">Offices Disponiveis</a>
            /
            <i class="fab fa-windows"></i>&nbsp;
            <?=  "<a href='javascript:'>".$row['versao']."</a>" ?>
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#contratos" data-toggle="tab">Software</a>
                </li>
                <li>
                    <a href="#anexos" data-toggle="tab">Notas Fiscais</a>
                </li>
            </ul>
            <?php
                switch ($_GET['msn']) {
                    case '1':
                        echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Dados da nota alterado com sucesso!.</div>";
                    break;
                    case '2':
                        echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Office cadastrado com sucesso!.</div>";
                    break;
                    case '3':
                        echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Office transferido com sucesso!.</div>";
                    break;
                }
            ?>
            <div class="tab-content">
                <!--Equipamento-->
                <div class="tab-pane active" id="contratos">
                    <form id="edit-profile" class="form-horizontal" action="office_add_alter.php" method="post">
                        <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                        <!--fim da gambiarra-->
                        <div class="control-group">
                            <h3 style="color: red;">
                                <font style="vertical-align: inherit;">Software:</font>
                            </h3>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Versao:</label>
                            <div class="controls">
                                <input class="span4" name="id" type="text" onkeyup='maiuscula(this)' value="<?= $row['id'] ?>"  style="display: none;"/>
                                <select id="t_cont" name="versao" class="span4">
                                    <option value="<?= $row['id_versao'] ?>"><?= $row['versao']  ?></option>
                                    <option value="">---</option>
                                    <?php 
                                        while ($row_office = $resultado_office->fetch_assoc()) {
                                        echo "<option value='".$row_office['id']."'>".$row_office['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Serial:</label>
                            <div class="controls">
                                <input class="cpfcnpj span3" type="text" name="serial" value="<?= $row['serial']  ?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Locacão:</label>
                            <div class="controls">
                                <select id="t_cont" name="locacao" class="span2">
                                    <option value="<?= $row['id_locacao'] ?>"><?= $row['locacao']  ?></option>
                                    <option value="">---</option>
                                    <?php 
                                        while ($row_funcao = $resultado_locacao->fetch_assoc()) {
                                        echo "<option value='".$row_funcao['id_empresa']."'>".$row_funcao['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Empresa:</label>
                            <div class="controls">
                                <select id="t_cob" name="empresa" class="span2" required>
                                    <option value="<?= $row['id_empresa'] ?>"> <?= $row['empresa']?> </option>
                                    <option value="">---</option>
                                    <?php 
                                        while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                            echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Fornecedor:</label>
                            <div class="controls">
                                <input class="cpfcnpj span4" type="text" name="fornecedor" value="<?= $row['fornecedor']  ?>"/>
                            </div>
                        </div>
                        <div class="form-actions">                            
                            <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                        </div>
                    </form>
                </div>
                <!--ANEXOS-->
                <div class="tab-pane" id="anexos">
                    <div class="span3" style="width: 802px;">
                        <div class="widget stacked widget-table action-table">
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nota Fiscal</th>
                                            <th>Número Nota</th>
                                            <th>Data Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="<?= $row['file_nota']  ?>" target='_blank'><?= $row['nomeNota']  ?></a></td>
                                            <td><?= $row['numero_nota']  ?></td>
                                            <td><?= $row['data_nota']  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../ava.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<!--MODAIS-->
<!-- Modal ANEXOS ADICIONAR -->
<div id="myModalanexos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Adicionando - Nota Fiscal</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_add_doc.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $row['id_funcionario']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">            
            <input type="text" name="tipo" style="display:none ;" value='10'>
            <div class="control-group">
            </div>
            <div class="control-group">
                <label class="control-label">Número da Nota:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="text" name="numero_nota" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nota Fiscal:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="notaFiscal" required />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal ADICIONAR OFFICE -->
<div id="myModalOffice" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Novo Office</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_new_office.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <?php
      echo "<div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <select id='t_cob' name='tipo_office' class='span3'>
                     <option>---</option>";
                       while($row = $resultado_office->fetch_assoc()){
                        echo "<option value='".$row['id']."'>".$row['nome']."</option>";
                     }//end WHILE office
                  echo "   
                  </select>
               </div>
            </div>
            <div class='control-group '>
               <label class='control-label'>Fornecedor:</label>                  
               <div class='controls autocomplete' style='margin-left: 5px;'>
                  <input class='span3' id='myInput1'  type='text' name='fornecedor_office'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Locacao:</label>
               <div class='controls'>
                  <select id='t_cob' name='local_office' class='span3'>
                     <option>---</option>";
                        while ($row_officeNEW= $resultado_empresa->fetch_assoc()) {
                            echo "<option value='".$row_officeNEW['id_empresa']."'>".$row_officeNEW['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Empresa:</label>
               <div class='controls'>
                  <select id='t_cob' name='empresa_office' class='span3'>
                     <option>---</option>";
                        while ($row_office= $resultado_empresa->fetch_assoc()) {
                            echo "<option value='".$row_office['id_empresa']."'>".$row_office['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Chave Key:</label>
               <div class='controls'>
                  <input class='cpfcnpj span4' type='text' name='serial_office'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Nota:
               </label>
               <div class='controls'>
                     <input type='file' name='file_nota' class='form-control span2'>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Data da nota:
               </label>
               <div class='controls'>
                     <input type='date' name='data_nota' class='form-control span2'>
               </div>
            </div>";
?>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal REMOVE OFFICE -->
<div id="myModalOfficeDrop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">
            <img src="img/alerta.png" style="width: 10%">
            Transferir Office para outro usuário
        </h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_trans.php" method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <?php
   $traz_office = "SELECT 
   MDO.nome AS office,
   MO.fornecedor,
   MDL.nome AS locacao_office,
   MO.locacao AS IDlocacao_office,
   MDE.nome AS empresa_office,
   MO.empresa AS IDempresa_office,
   MO.serial
   FROM
   manager_office MO
      LEFT JOIN
   manager_dropoffice MDO ON MO.versao = MDO.id
      LEFT JOIN
   manager_dropempresa MDE ON MO.empresa = MDE.id_empresa
      LEFT JOIN
   manager_droplocacao MDL ON MO.locacao = MDL.id_empresa
   WHERE
   MO.id_equipamento = ".$_GET['id_equip'].";";

   $result_traz_office = $conn->query($traz_office);

   if($row_traz_office = mysqli_fetch_assoc($result_traz_office)){
      echo "<div class='control-group'>
               <label class='control-label'>Office:</label>                  
               <div class='controls'>
                  <input class='span3' type='text' name='office' value='".$row_traz_office['office']."'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Fornecedor:</label>                  
               <div class='controls'>
                  <input class='span4' type='text' name='fornecedor_office' value='".$row_traz_office['fornecedor']."'/>
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Locacao:</label>
               <div class='controls'>
                  <select id='t_cob' name='local_office' class='span3'>
                     <option value='".$row_traz_office['IDlocacao_office']."'>".$row_traz_office['locacao_office']."</option>
                     <option>---</option>";
                        while ($row_officeE = $resultado_empresa->fetch_assoc()) {
                        echo "<option value='".$row_officeE['id_empresa']."'>".$row_officeE['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Empresa:</label>
               <div class='controls'>
                  <select id='t_cob' name='empresa_office' class='span3'>
                     <option value='".$row_traz_office['IDempresa_office']."'>".$row_traz_office['empresa_office']."</option>
                     <option>---</option>";
                        while ($row_officeEM= $resultado_empresa->fetch_assoc()) {
                        echo "<option value='".$row_officeEM['id_empresa']."'>".$row_officeEM['nome']."</option>";
                        }
                     echo "   
                  </select>   
               </div>
            </div>
            <div class='control-group'>
               <label class='control-label'>Chave Key:</label>
               <div class='controls'>
                  <input class='cpfcnpj span4' type='text' name='serial_office' value='".$row_traz_office['serial']."'/>
               </div>
            </div>
                      
            <div class='control-group'>
            <label class='control-label'>Equipamento:</label>
            <div class='controls'>
               <select id='t_cob' name='new_office' class='span2'>
                  <option value=''>---</option>";
            $buscando_usuario = "SELECT 
            MO.id AS id_office,
            MIE.id_equipamento,
            MIE.patrimonio
            FROM
            manager_inventario_equipamento MIE
               LEFT JOIN
            manager_office MO ON MIE.id_equipamento = MO.id_equipamento
            WHERE
            MIE.tipo_equipamento IN (8,9)";

            echo $buscando_usuario;
            $result_search_user = $conn->query($buscando_usuario);

            while($row_search = mysqli_fetch_assoc($result_search_user)){

                  if($row_search['id_office'] == NULL){
                     echo "<option value='".$row_search['id_equipamento']."'>".$row_search['patrimonio']."</option>";
                  }//end IF equipamento sem office
               }//end While equipamento que recebera o OFFICE   

               echo "</select>                     
               <i class='icon-lithe icon-question-sign' title='Equipamento que irá receber o Office!'></i>
            </div>
         </div>";
   }//end IF trazendo Office



?>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>

        </form>
    </div>
</div>

</html>
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
<!--AUTO PREENCHIMENTO DO CAMPO FORNECEDOR-->
<script src="../js/autocomplete_f.js"></script>
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