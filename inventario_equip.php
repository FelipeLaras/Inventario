<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
   
       header('location: error.php');
   }
?>
<?php  require 'header.php'?><!--Chamando a Header-->
<style>
.col-sm-12 {
    width: 110%;    
    margin-left: -38px;
}

</style>
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
      <table id="example" class="table table-striped table-bordered" style="width:100%; font-size: 10px; font-weight: bold;">
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
               <th class="titulo" style="width: 85px;">STATUS
                  <i class="icon-large icon-question-sign" 
                  title=" Ativo = Está vinculado a algum usuário; 
                  Branco = Chip Virgem;    
                  Bloqueado = Não está sendo usado por nenhum usuário e não pode vincular ao mesmo; 
                  Disponível = Não está vinculado ao nenhum usuário;
                  Manutenção = Está vinculado a um usuário porém não esta sendo usado;"></i>
               </th>

               <th class="titulo" style="width: 165px;">OBSERVAÇÃO</th>
               <th class="titulo">TERMO</th>
               <th class="titulo acao" style="width: 65px;">AÇÃO</th>
            </tr>
         </thead>
         <tbody>
            <?php
               //conectando com o bando de dados
               //criando a pesquisa 
               $query = "SELECT 
                            MIE.id_funcionario,
                            MIE.id_equipamento,
                            MDE.nome AS tipo_equipamento,
                            MIE.modelo,
                            MIE.patrimonio,
                            MIE.imei_chip,
                            MIE.numero,
                            MIE.planos_voz,
                            MIE.planos_dados,
                            MDO.nome AS operadora,
                            MDSE.nome AS status,
                            MIE.termo,
                            MDSE.id_status,
                            MIE.filial,
                            MDES.nome AS filial,
                            MIE.tipo_equipamento AS id_tipo,
                            MIE.data_nota,
                            MIE.valor,
                            MIF.nome AS funcionario,
                            MDS.nome AS situacao,
                            MDET.nome AS estado
                        FROM
                            manager_inventario_equipamento MIE
                        LEFT JOIN
                            manager_dropempresa MDES ON MIE.filial = MDES.id_empresa
                        LEFT JOIN
                            manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                        LEFT JOIN
                            manager_dropoperadora MDO ON MDO.id_operadora = MIE.operadora
                        LEFT JOIN
                            manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
                        LEFT JOIN
                            manager_inventario_funcionario MIF ON MIF.id_funcionario = MIE.id_funcionario
                        LEFT JOIN
                            manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
                        LEFT JOIN
                            manager_dropestado MDET ON MIE.estado = MDET.id
                        WHERE
                            MIE.deletar = 0 AND
                            MIE.tipo_equipamento in (1, 3, 2, 4) ORDER BY MIE.id_equipamento ASC";
               //Criando a pesquisa para contagem                        

               //aplicando a regra e organizando na tela
               $resultado = mysqli_query($conn, $query);
               
               while($row = mysqli_fetch_assoc($resultado)){

               $data = date("d/m/Y", strtotime($row['data_nota']));     
               
               echo "<tr>
                      <td class='fonte'>".$row['id_equipamento']."</td>
                      <td class='fonte'>".$row['tipo_equipamento']."</td>
                      <td class='fonte'>".$row['modelo']."</td>";
                      //patrimonio
                      if($row['patrimonio'] != NULL){
                        echo "<td class='fonte'>".$row['patrimonio']."</td>";
                      }else{
                        echo "<td class='fonte'>---</td>";
                      }
                      //imei chip
                      if($row['imei_chip'] != NULL){
                        echo "<td class='fonte'>".$row['imei_chip']."</td>";
                      }else{
                        echo "<td class='fonte'>---</td>";
                      }
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
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: green;'></i> ".$row['status']."</td>";
                break;
                case 2://manutenção
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: orange;'></i> ".$row['status']."</td>";
                break;
                case 3:// 3 = inativo
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: black'></i> ".$row['status']."</td>";
                break;
                case 7:// 7 = cancelado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: red;'></i> ".$row['status']."</td>";
                break;
                case 4:// 4 = branco
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: blue;'></i> ".$row['status']."</td>";
                break;
                case 6:// 6 = disponivel ti
                  echo "<td class='fonte'> <i class='fas fa-circle' style='color: #72f91d;'></i> ".$row['status']."</td>";
                break;
                case 10:// 10 = disponivel loja
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #ebef0b;'></i> ".$row['status']."</td>";
                break;
                case 11: // 11 = Condenado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #9a0606;'></i> ".$row['status']."</td>";
                break;
                case 15: //disponivel consorcio
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: pink;'></i> ".$row['status']."</td>";
                break;
                case 16: //Não Devolvido
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #000000;'></i> ".$row['status']."</td>";
                break;
                case 17: //Não Localizado
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #504d4d;'></i> ".$row['status']."</td>";
                break;
              }    
                //buscando as observações
               $query_obs = "SELECT MIO.obs, MIO.data_criacao, MDSE.nome AS status
                            FROM manager_inventario_obs MIO
                            INNER JOIN manager_dropstatusequipamento MDSE ON MIO.id_status = MDSE.id_status
                            where MIO.id_equipamento = ".$row['id_equipamento']." AND MIO.deletar = 0 order by data_criacao DESC limit 1;";

                $resultado_obs = mysqli_query($conn, $query_obs);
                $row_obs = mysqli_fetch_assoc($resultado_obs);
               echo "<td id='obs'>
                <a href='#myModalOBS".$row['id_equipamento']."' data-toggle='modal' class='obs'>
                  ".$row_obs['obs']."
                </a>
               </td>";
               //fim obs

               echo "<td>";
                 if ($row['termo'] == 0) {//tem termo
                    echo "<a href='javascript:;' title='Possui Termo!'><i class='icon-ok tem'></i></a>";
                  } else{
                    echo "<a href='javascript:;' title='Não Possui Termo!'><i class='icon-remove nao_tem'></i></a>";
                  }

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
               </tr>

<!-- Modal Observação-->
<div id='myModalOBS".$row['id_equipamento']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
    <h3 id='myModalLabel'>
        Observações      
    </h3>
  </div>
  <div class='modal-body'>
    <div class='control-group'>
      <div class='controls'>
        <div class='accordion' id='accordion2'>";
          $add_obs = 0;
           $query_OBS = "SELECT MIO.obs, MIO.data_criacao, MDSE.nome AS status
                        FROM manager_inventario_obs MIO
                        INNER JOIN manager_dropstatusequipamento MDSE ON MIO.id_status = MDSE.id_status
                        where MIO.id_equipamento = ".$row['id_equipamento']." AND MIO.deletar = 0 order by data_criacao DESC";

            $resultado_OBS = mysqli_query($conn, $query_OBS);

            while ($row_OBS = mysqli_fetch_assoc($resultado_OBS)) {

             $date_obs = date('d/m/Y H:i:s', strtotime($row_OBS['data_criacao']));

             echo "<div class='accordion-group'>
             <label class='control-label'><b>Status:</b> ".$row_OBS['status']."</label>
            <div class='accordion-heading'>
              <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse".$add_obs.$row['id_equipamento']."'>
                <b>Data da postagem:</b> ".$date_obs."
              </a>
            </div>
            <div id='collapse".$add_obs.$row['id_equipamento']."' class='accordion-body collapse' style='height: 0px;'>
              <div class='accordion-inner'>
                 ".$row_OBS['obs']."
              </div>
            </div>
          </div></br>";
          $add_obs++;
            }
echo "
        </div>
      </div> 
    </div>
  </div>
</div>";                                 
                  }                    
               mysqli_close($conn);
               ?>
         </tbody>
      </table>
   </div>
</div>
</div>
<!-- Le javascript
   ================================================== -->
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="js/cnpj.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>   
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>
</html>