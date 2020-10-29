<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   /*------------------------------------------------------------------------------------------------------------------*/
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   require_once('../query/query.php');
   /*------------------------------------------------------------------------------------------------------------------*/
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }
/*------------------------------------------------------------------------------------------------------------------*/
//chamandos todos os equipamento do tipo (notebooks, desktops, ramais)
$equipamentos = "SELECT 
MIE.id_equipamento,
MIE.status AS id_status,
MDST.nome AS status,
MIE.id_funcionario,
MIE.serialnumber,
MIE.modelo,
MIE.patrimonio,
MDE.nome AS empresa,
MDL.nome AS locacao,
MIE.fornecedor_scan,
MIE.data_fim_contrato,
MIE.numero_nota,
MIF.nome AS responsavel,
MIF.cpf,
MDD.nome AS departamento,
MDS.nome AS situacao,
MIE.situacao AS id_situacao
FROM
manager_inventario_equipamento MIE
    LEFT JOIN
manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
    LEFT JOIN
manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
    LEFT JOIN
manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
    LEFT JOIN
manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
  LEFT JOIN
manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
   LEFT JOIN
manager_dropstatusequipamento MDST ON MIE.status = MDST.id_status
WHERE
MIE.tipo_equipamento = 10 AND MIE.status != 11";
$resultado_equip = $conn->query($equipamentos);


//contagem equipamentos alterados

$cont = "SELECT COUNT(id) AS quantidade FROM manager_comparacao_ocs";
$result_count = $conn->query($cont);
$row_count = $result_count->fetch_assoc();

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
switch ($_GET['msn']){
   case '1':
      echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><h4>ATENÇÃO</h4><b style='color:red'>Data de vigencia</b> aplicado com sucesso!</div>";
   break;

   case '2':
      echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><h4>ATENÇÃO</h4><b style='color:red'>Condenado</b> com sucesso!</div>";
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
            <i class="icon-lithe icon-print"></i>&nbsp;
            <a href="scan_disponivel.php">Scanners</a>
        </h3>
        <div id="novo_usuario">
            <!--ADICIONAR NOVO EQUIPAMENTO-->
            <a class="btn btn-default btn-xs botao" href="add_new.php" title="Adicionar novo equipamento">
                <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
            </a>
            <!--RELATÓRIOS-->
            <a class="btn btn-default btn-xs botao" href="relatorio_tecnicos.php" title="Ralatórios">
                <i class='btn-icon-only icon-bar-chart' style="margin-left: -3px">
                     <?php 
                        if($row_count['quantidade'] != 0){
                           if ($row_count['quantidade'] >= 99){
                              echo "<div id='contador'>+99</div>";   
                           }elseif($row_count['quantidade'] >= 10){   
                              echo "<div id='contador_b'>".$row_count['quantidade']."</div>";   
                           }else{
                              echo "<div id='contador_a'>".$row_count['quantidade']."</div>";
                           }                           
                        }//end IF validando o contador   
                     ?>
                </i>
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
               <a class="btn btn-default btn-xs botao" style="background-color: #00ff4e29;" href="scan_disponivel.php" title="Lista de Scanners">
                  <i class="fas fa-print"></i> = <?= $row_scanner['scanner'] ?>
               </a>
               <!--OFFICE-->
               <a class="btn btn-default btn-xs botao" href="office_disponivel.php" title="Office Disponivéis">
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
                    <th class="titulo">Situação</th> 
                    <th class="titulo">Modelo</th>
                    <th class="titulo">N. Série</th>
                    <th class="titulo">Patrimônio</th>
                    <th class="titulo">Respónsavel</th>
                    <th class="titulo">C.P.F</th>
                    <th class="titulo">Departamento</th>
                    <th class="titulo">Empresa</th>
                    <th class="titulo">Locação</th>                    
                    <th class="titulo">Fornecedor</th>
                    <th class="titulo">Data Fim Contrato</th>
                    <th class="titulo">Status</th>
                    <th class="titulo acao">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
//aplicando a query
while ($row_equip = $resultado_equip->fetch_assoc()) {
   
   //trocando formato da data fim do contrato
   $data_fim = $row_equip['data_fim_contrato'];
      
      echo "<tr>";

      switch ($row_equip['id_situacao']) {
         case '4':
            echo "<td class='fonte'><a href='javascript:' title='ALUGADO' style='margin-left: 20px;'><i class='fas fa-circle' style='color: blue;'></i></a></td>";
         break;
         
         case '5':
            echo "<td class='fonte'><a href='javascript:' title='COMPRADO' style='margin-left: 20px;'><i class='fas fa-circle' style='color: green;' title='COMPRADO'></i></a></td>";
         break;
      }

      echo " 
               <td class='fonte'>".$row_equip['modelo']."</td>
               <td class='fonte'>".$row_equip['serialnumber']."</td>
               <td class='fonte'>".$row_equip['patrimonio']."</td>
               <td class='fonte'>".$row_equip['responsavel']."</td>
               <td class='fonte'>".$row_equip['cpf']."</td>
               <td class='fonte'>".$row_equip['departamento']."</td>
               <td class='fonte'>".$row_equip['empresa']."</td>
               <td class='fonte'>".$row_equip['locacao']."</td>
               <td class='fonte'>".$row_equip['fornecedor_scan']."</td>           
               <td class='fonte'>".$data_fim."</td>";

               switch ($row_equip['id_status'] ){
                  case '1':
                     echo "<td class='fonte'><a href='javascript:' title='ATIVO' style='margin-left: 15px;'><i class='fas fa-circle' style='color: #72f91d;'></i></a></td>";
                  break;
                     
                  case '6':
                     echo "<td class='fonte'><a href='javascript:' title='DISPONÍVEL' style='margin-left: 15px;'><i class='fas fa-circle' style='color: orange;'></i></a></td>";
                  break;

                  case '11':
                     echo "<td class='fonte'><a href='javascript:' title='CONDENADO' style='margin-left: 15px;'><i class='fas fa-circle' style='color: red;'></i></a></td>";
                  break;

               }

         echo "
               <td class='fonte  acao'>
               <a href='scan_edit.php?id_equip=".$row_equip['id_equipamento']."&tipo=".$row_equip['id_situacao']."' title='Editar' class='icon_acao'>
                  <i class='icon-folder-open' style='font-size: 12px;'></i>
               </a>";

            /*--------------------------------ALUGADO--------------------------------------------*/
            if(($row_equip['id_situacao'] == 4) && ($row_equip['id_status'] == 1) ){//alugado + ativo
               echo "
               <a href='#modalVigencia".$row_equip['id_equipamento']."' title='Data vigência' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-calendar-times' style='font-size: 12px;'></i>
               </a>";

            }elseif(($row_equip['id_situacao'] == 4) && ($row_equip['id_status'] == 6)){//Alugado + disponivel
               echo "
               <a href='#modalVincular".$row_equip['id_equipamento']."' title='Vincular Usuário' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-user' style='font-size: 12px;'></i>
               </a>";
            }


            /*--------------------------------COMPRADO--------------------------------------------*/
            if(($row_equip['id_situacao'] == 5) && ($row_equip['id_status'] == 1)){//Comprado + ativo
               echo "
               <a href='#modalVigencia".$row_equip['id_equipamento']."' title='Data vigência' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-calendar-times' style='font-size: 12px;'></i>
               </a>
               <a href='#modalExc".$row_equip['id_equipamento']."' title='Desativar' class='icon_acao' data-toggle='modal'>
                  <i class='icon-remove' style='font-size: 12px;'></i>
               </a>";
            }

            if(($row_equip['id_situacao'] == 5) && ($row_equip['id_status'] == 6)){//Comprado + disponivel
               echo "
               <a href='#modalVincular".$row_equip['id_equipamento']."' title='Vincular Usuário' class='icon_acao' data-toggle='modal'>
                  <i class='far fa-user' style='font-size: 12px;'></i>
               </a>
               <a href='#modalExc".$row_equip['id_equipamento']."' title='Desativar' class='icon_acao' data-toggle='modal'>
                  <i class='icon-remove' style='font-size: 12px;'></i>
               </a>";
            }

            echo "
            </td>
         </tr>";        
    
echo    "<!--MODAL VINCULAR AO USUÁRIO-->
            <div id='modalVincular".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/alerta.png' style='width: 10%'>
                        VINCULAR USUÁRIO DISPONÍVEL
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>1 - Confira se o equipamento é o que dejesa vincular a um novo usuário!</h5><br />";
                           
                           if($row_equip['id_situacao'] == 4){//alugado
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Modelo: ".$row_equip['modelo']."";
                           }else{
                              echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>";
                           }
                           echo "
                           <h5>2 - Agora selecione o usuário que desejar!</h5>
                           <div class='tabbable'>
                              <div id='formulario'>
                                 <form class='form-horizontal' action='scan_alter.php' method='POST' autocomplete='off' >
                                 <input type='text' style='display:none;' name='id_equip' value='".$row_equip['id_equipamento']."' />
                                 <input type='text' style='display:none;' name='use' value='1' />
                                    <div class='control-group'>
                                       <label class='control-label'>Usuário:</label>
                                       <div class='controls' style='margin-left: 11px;'>
                                          <select class='span2' style='margin-top: -40px; margin-left: 50px;' name='id_fun' required>
                                             <option value=''>---</option>";
                                             $status = "SELECT id_funcionario, nome FROM manager_inventario_funcionario WHERE deletar = 0 order by nome asc";
                                             $result_status = $conn->query($status);

                                             while($row_status = mysqli_fetch_assoc($result_status)){
                                                echo "<option value='".$row_status['id_funcionario']."'>".$row_status['nome']."</option>";
                                             }                                             
                                             echo"
                                          </select>
                                       </div>
                                    </div>                                                                                               
                                       <div class='modal-footer'>
                                       <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                                       <button type='submit' class='btn btn-success' target='_blank'>SIM</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
            </div>
         <!--MODAL EXCLUIR-->
         <div id='modalExc".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/atencao.png' style='width: 10%'>
                        DESATIVAR EQUIPAMENTO!
                  </h3>
                  <div class='modal-body'>
                        <div id='button_pai'>
                           <h5>Deseja condenar o equipamento ?</h5>
                           <p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>
                           <span style='color:red;font-size:9px;'></span>
                        </div>                                                           
                        <div class='modal-footer'>
                           <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                           <a href='scan_alter.php?id_equip=".$row_equip['id_equipamento']."&del=1' class='btn btn-success' >SIM</a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <!--MODAL VIGÊNCIA-->
         <div id='modalVigencia".$row_equip['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <div id='pai'>
               <div class='modal-body'>
                  <h3 id='myModalLabel'>
                     <img src='../img/atencao.png' style='width: 10%'>
                     DATA DE VIGÊNCIA
                  </h3>
                  <div class='modal-body'>
                     <div id='button_pai'>
                        <h5>1 - Inserindo a data de vigência, você estará informando que o usuário <span style='color: red'>&ldquo;".$row_equip['responsavel']."&rdquo;</span> não será mais responsavel pelo equipamento...</h5><br />";

                        if($row_equip['id_situacao'] == 4){//alugado
                           echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Modelo: ".$row_equip['modelo']."";
                        }else{
                           echo "<p style='padding: 10px;background-color: aliceblue;color: red;'>Patrimônio: ".$row_equip['patrimonio']."</p>";
                        }
                        echo "
                     </div>
                  </div>
               </div>
               <div class='modal-footer'>
                  <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                  <a href='scan_alter.php?id_equip=".$row_equip['id_equipamento']."&alter=1' class='btn btn-success' target='_blank'>SIM</a>
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
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>