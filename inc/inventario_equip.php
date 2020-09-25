<?php
  require_once('header.php');

  require_once('../query/query.php');

  //aplicando para usar varialve em outro arquivo
  session_start();
  unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
  //chamando conexão com o banco
  require_once('conexao.php');
  //Aplicando a regra de login
  if($_SESSION["perfil"] == NULL){  
    header('location: ../front/index.html');

  }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {

    header('location: ../front/error.php');
  }  

  $data = date("d/m/Y", strtotime($row['data_nota']));  

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
                <li>
                    <a href="inventario.php"><i class="icon-group"></i>
                        <span>Colaboradores</span>
                    </a>
                </li>
                <li class="active">
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
<?php 
if ($_GET['msn'] == 1) {
  echo "
    <div class='control-group'>
      <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
          O equipamento editado com sucesso!!
      </div>
    </div>";
}
?>
<div class="widget ">
    <div class="widget-header">
        <h3>
            <a href="inventario_ti.php"><i class="icon-home"></i>&nbsp;
                Home
            </a>
            /
            Equipamentos
        </h3>
        <div id="novo_usuario">
            <a class="btn btn-default btn-xs botao" href="inventario_equip_add.php" title="Adicionar novo Equipamento">
                <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <table id="example" class="table table-striped table-bordered"
            style="width:100%; font-size: 10px; font-weight: bold;">
            <thead>
                <tr>
                    <th class="titulo">ID</th>
                    <th class="titulo" style="width: 90px;">TIPO EQUIP.</th>
                    <th class="titulo">MODELO</th>
                    <th class="titulo">PATRIMÔNIO</th>
                    <th class="titulo">IMEI</th>
                    <th class="titulo" style="width: 75px;">NUMERO</th>
                    <th class="titulo">PLANO</th>
                    <th class="titulo">OPERADORA</th>
                    <th class="titulo">FILIAL</th>
                    <th class="titulo">ESTADO</th>
                    <th class="titulo">SITUAÇÃO</th>
                    <th class="titulo">STATUS</th>
                    <th class="titulo" style="width: 165px;">OBSERVAÇÃO</th>
                    <th class="titulo">TERMO</th>
                    <th class="titulo acao" style="width: 65px;">AÇÃO</th>
                </tr>
            </thead>
            <tbody>
                <?php
               //aplicando a regra e organizando na tela
                             
               while($row = $resultado -> fetch_assoc()){   
               
               echo "<tr>
                      <td class='fonte'>".$row['id_equipamento']."</td>
                      <td class='fonte'>".$row['tipo_equipamento']."</td>
                      <td class='fonte'>".$row['modelo']."</td>";
                      //patrimonio
                      if($row['patrimonio'] != NULL){ echo "<td class='fonte'>".$row['patrimonio']."</td>";}else{ echo "<td class='fonte'>---</td>";}
                      //imei chip
                      if($row['imei_chip'] != NULL){ echo "<td class='fonte'>".$row['imei_chip']."</td>";}else{ echo "<td class='fonte'>---</td>";}
              echo "                              
                      <td class='fonte'>".$row['numero']."</td>
                      <td class='fonte'>".$row['planos_voz'].",".$row['planos_dados']."</td>
                      <td class='fonte'>".$row['operadora']."</td>
                      <td class='fonte'>".$row['filial']."</td>
                      <td class='fonte'>".$row['estado']."</td>
                      <td class='fonte'>".$row['situacao']."</td>";

              //cores dos status
              switch ($row['id_status']){
                case  1:// 1 = ativo
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: green; margin-left: 12px;' title= ".$row['status']."></i></td>";
                break;
                case 2://manutenção
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: orange; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 3:// 3 = inativo
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: black; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 7:// 7 = cancelado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: red; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 4:// 4 = branco
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: blue; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 6:// 6 = disponivel ti
                  echo "<td class='fonte'> <i class='fas fa-circle' style='color: #72f91d; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 10:// 10 = disponivel loja
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #ebef0b; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 11: // 11 = Condenado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #9a0606; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 15: //disponivel consorcio
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: pink; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 16: //Não Devolvido
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #000000; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
                case 17: //Não Localizado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #504d4d; margin-left: 12px;' title=".$row['status']."></i></td>";
                break;
              }    

               //buscando as observações
              $query_obs = "SELECT 
                              MIO.obs, 
                              MIO.data_criacao, 
                              MDSE.nome AS status
                            FROM 
                              manager_inventario_obs MIO
                            LEFT JOIN 
                              manager_dropstatusequipamento MDSE ON MIO.id_status = MDSE.id_status
                            WHERE 
                              MIO.id_equipamento = ".$row['id_equipamento']." AND 
                              MIO.deletar = 0 ORDER BY MIO.data_criacao DESC limit 1";

              $resultado_obs = $conn -> query($query_obs);              
               
              if(!$row_obs = $resultado_obs -> fetch_assoc()){
                echo "<td id=''>algo deu errado</td>";
              }else{
                echo "<td id=''>".$row_obs['obs']."</td>";
               //fim obs
              }

              echo "<td>";

              if($row['termo'] == 0){ echo "<a href='javascript:;' title='Possui Termo!'><i class='icon-ok tem'></i></a>";}else{ echo "<a href='javascript:;' title='Não Possui Termo!'><i class='icon-remove nao_tem'></i></a>";}
              
              //ação
              echo "
                <td class='fonte acao'>
                  <a href='inventario_equip_edit.php?id_equip=".$row['id_equipamento']."&tipo=".$row['id_tipo']."' role='button' class='icon_acao' title='Editar'>
                    <i class='btn-icon-only icon-pencil' style='font-size: 15px;'></i>
                  </a>";

                if (($row['id_status'] == 6) || ($row['id_status'] == 10) || ($row['id_status'] == 15)) {
                  echo "<a href='inventario_add.php?id_equip=".$row['id_equipamento']."' role='button' class='icon_acao' title='Vincular a um usuário'><i class='btn-icon-only icon-plus-sign' style='font-size: 15px;'></i></a>";
                }elseif($row['id_status'] == 1){
                  echo "<a href='inventario_edit.php?id=".$row['id_funcionario']."' role='button' class='icon_acao' title='Funcionario: ".$row['funcionario']."'><i class='btn-icon-only icon-user' style='font-size: 15px;'></i></a>";
                }
                 
              echo "</td>
               </tr>";                             
                  } 

               $conn -> close();

               ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../js/cnpj.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>