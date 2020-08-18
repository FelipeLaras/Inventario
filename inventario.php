<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif ($_SESSION["perfil"] == 2) {
   
       header('location: error.php');
   }


/* ------------------------------ limando os históricos ------------------------------ */
 
//pegando os funcionarios que estão com o status diferente de 8(Demitido) e 3(Falta termo)

$query_funcionario = "SELECT id_funcionario FROM manager_inventario_funcionario WHERE status NOT IN (8,3)";

$result_funcionario = mysqli_query($conn, $query_funcionario);

while($funcionario = mysqli_fetch_assoc($result_funcionario)){

   $limpar = "SELECT id FROM manager_invent_historico WHERE id_funcionario = ".$funcionario['id_funcionario']."";
   $result_limpar = mysqli_query($conn, $limpar);

   while($limpar_historico = mysqli_fetch_assoc($result_limpar)){

      $deletar = "UPDATE manager_invent_historico SET deletado = 1 WHERE id = ".$limpar_historico['id']."";
      $result_deletar = mysqli_query($conn, $deletar) or die(mysqli_error($conn));
      
   }//fim while deletando

}//fim while verificando usuário


/* ------------------------------ fim limpando os históricos ------------------------------ */

//contador
$contador = 0;
//query para a contagem dos itens ativos, faltaTermo e demitido.
$query_f = "SELECT 
         COUNT(status) AS faltaTermo
         FROM
         manager_inventario_funcionario
         WHERE
         status = 3 AND deletar = 0";
$resultado_f = mysqli_query($conn, $query_f);
$row_f = mysqli_fetch_assoc($resultado_f);

/*-----------------------------------------------------------------------------*/

$query_a = "SELECT 
         COUNT(status) AS ativo
         FROM
         manager_inventario_funcionario
         WHERE
         status = 4 AND deletar = 0";
$resultado_a = mysqli_query($conn, $query_a);
$row_a = mysqli_fetch_assoc($resultado_a);

/*-----------------------------------------------------------------------------*/
         
$query_d = "SELECT 
         COUNT(status) AS demitido
         FROM
         manager_inventario_funcionario
         WHERE
         status = 8 AND deletar = 0";
$resultado_d = mysqli_query($conn, $query_d);
$row_d = mysqli_fetch_assoc($resultado_d);

/*-----------------------------------------------------------------------------*/
         
$query_Squip = "SELECT 
         COUNT(status) AS sem_equip
         FROM
         manager_inventario_funcionario
         WHERE
         status = 9 AND deletar = 0";
$resultado_Squip = mysqli_query($conn, $query_Squip);
$row_Squip = mysqli_fetch_assoc($resultado_Squip);

?>
<?php  require 'header.php';?>
<style>
.col-sm-12.col-md-6 {
    width: 10px;
}

select.form-control.form-control-sm {
    margin-top: 28px;
}
</style>
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
            if($_SESSION["perfil"] != 3){//perfil 3(RH)
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

<?php
   if($_GET['msn'] == 1){//demitido
      echo "
      <div class='alert'>
         <button type='button' class='close' data-dismiss='alert'>×</button>
         <strong>Atenção!</strong> usuário alterado para <span style'color: red;'>DEMITIDO!</span>.
      </div>
      ";
   }
   
?>
<div class="widget ">
    <div class="widget-header">
        <h3>
            <a href="inventario_ti.php"><i class="icon-home"></i>&nbsp;
                Home
            </a>
            /
            Colaboradores
        </h3>
        <?php
      if($_SESSION["perfil"] != 3){//perfil 3(RH)
         echo "
      <div id='novo_usuario'>
         <a class='btn btn-default btn-xs botao' href='inventario_add.php' title='Adicionar novo funcionário'> 
            <i class='btn-icon-only icon-plus' style='margin-left: -3px'> </i>
         </a>
         
         <!--botões para chamar os status--> 

         <div id='botoes_status'>
         <ul class='list-group list-group-horizontal'>
            <li class='list-group-item'>
               <a class='btn btn-default btn-xs botao' href='inventario.php?status=4' title='Termos Ativos'>  
                  <!--botão que confirma que o termo já foi anexado ao funcionário-->
                  <i class='far fa-check-circle' style='color:green'></i>
               </a>               
            </li>
            <span>Ativo(s): ".$row_a["ativo"]."</span>

            <li class='list-group-item'>            
               <!--botão que informa ao usuário, quantos equipamentos temos sem o termo-->              
               <a class='btn btn-default btn-xs botao' href='inventario.php?status=3' title='Falta Termo'>
               <i class='fas fa-ban' style='color:#f3b37c7a'></i>
               </a>
            </li>
            <span>Falta Termo: ".$row_f["faltaTermo"]."</span>

            <li class='list-group-item'>
               <!--botão que informa quantos usuários foram demitidos-->
               <a class='btn btn-default btn-xs botao' href='inventario.php?status=8' title='Demitidos'>             
                  <i class='far fa-times-circle' style='color:black'></i>
               </a>
            </li>
            <span>Demitido(s): ".$row_d["demitido"]."</span>

            <li class='list-group-item'>
               <!--botão que informa quantos usuários que estão sem equipamento-->
               <a class='btn btn-default btn-xs botao' href='inventario.php?status=9' title='Sem equipamentos'>               
                  <i class='fas fa-desktop' style='color:darkgray'></i>
               </a>
            </li>
            <span>Sem Equipamento(s): ".$row_Squip["sem_equip"]."</span>

            <li class='list-group-item'>
               <a class='btn btn-default btn-xs botao' href='inventario.php' title='Mostrar todos'>
                  <i class='far fa-check-square' style='color:blue'></i>
               </a>
            </li>
            <span>Mostrar todos</span>

         </ul>                
      </div>";
      }//end IF perfil RH
      ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <table id="example" class="table table-striped table-bordered"
            style="width:100%; font-size: 10px; font-weight: bold;">
            <thead>
                <tr>
                    <th class="titulo">ID</th>
                    <th class="titulo">Nome</th>
                    <th class="titulo" style="width: 75px">CPF</th>
                    <th class="titulo">FUNÇÃO</th>
                    <th class="titulo">DEPARTAMENTO</th>
                    <th class="titulo">EMPRESA/FILIAL</th>
                    <th class="titulo" style='width: 140px;'>EQUIPAMENTOS
                        <i class="icon-lithe icon-question-sign" title="| Quantidade - Nome |"></i>
                    </th>
                    <th class="titulo" style='width: 126px'>STATUS</th>
                    <th class="titulo acao">AÇÃO</th>
                </tr>
            </thead>
            <tbody>
                <?php
               //criando a pesquisa dos funcionários
               $query = "SELECT 
               F.id_funcionario,
               F.nome,
               F.cpf,
               Fu.nome AS funcao,
               D.nome AS departamento,
               E.nome AS empresa,
               S.nome AS status,
               F.status AS id_status
           FROM
               manager_inventario_funcionario F
                  LEFT JOIN
               manager_dropfuncao Fu ON F.funcao = Fu.id_funcao
                  LEFT JOIN
               manager_dropdepartamento D ON F.departamento = D.id_depart
                  LEFT JOIN
               manager_dropempresa E ON F.empresa = E.id_empresa
                  LEFT JOIN
               manager_dropstatus S ON F.status = S.id_status
           WHERE
               F.deletar = 0 AND F.funcao IS NOT NULL "; 

            if($_GET['status'] != NULL){
               $query .= "AND F.status = ".$_GET['status']."";
            }
              
               //0 = ativo, 1 = desativado
               //Criando a pesquisa para contagem  

               //aplicando a regra e organizando na tela
               if ($resultado = mysqli_query($conn, $query)){
               
               while($row = mysqli_fetch_assoc($resultado)){


               /*---------------------------- contador para o histórico DEMITIDOS ---------------------------- */      
               $query_HistoricoDemitidos = "SELECT count(id_funcionario) AS historico FROM manager_invent_historico where id_funcionario = ".$row['id_funcionario']." AND status_funcionario = 8 AND deletado = 0";
               $result_HistoricoDemitidos = mysqli_query($conn, $query_HistoricoDemitidos);
               $historico_demitidos = mysqli_fetch_assoc($result_HistoricoDemitidos);    
               /*---------------------------- FIM contador para o histórico demitidos ---------------------------- */    

               /*---------------------------- contador para o histórico FALTA TERMO ---------------------------- */      
               $query_historico = "SELECT count(id_funcionario) AS historico FROM manager_invent_historico where id_funcionario = ".$row['id_funcionario']." AND status_funcionario = 3 AND deletado = 0";
               $result_historico = mysqli_query($conn, $query_historico);
               $historico_fataTermo = mysqli_fetch_assoc($result_historico);    
               /*---------------------------- FIM contador para o histórico FALTA TERMO ---------------------------- */ 

               $query_equipamento = "SELECT 
                     COUNT(*) AS quantidade, DQ.nome AS equipamento
               FROM
                     manager_inventario_equipamento IQ
                        LEFT JOIN
                     manager_dropequipamentos DQ ON IQ.tipo_equipamento = DQ.id_equip
               WHERE
                     IQ.deletar = 0 AND IQ.id_funcionario = ".$row['id_funcionario']." GROUP BY DQ.id_equip";
               $resultado_equipamento = mysqli_query($conn, $query_equipamento); 

/*UM PEQUENO AJUSTE PARA ELIMINAR FUNCIONARIOS QUE NÃO POSSUEM EQUIPAMENTOS*/

$verificar_funcio = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$row['id_funcionario']."'";
$resulado_ver_funci = mysqli_query($conn, $verificar_funcio);
$linha_ver = mysqli_fetch_assoc($resulado_ver_funci);
if ($linha_ver['id_equipamento'] == NULL) {
   $update_ver_funcio = "UPDATE manager_inventario_funcionario SET status = 9 WHERE id_funcionario = '".$row['id_funcionario']."'";
   $resul = mysqli_query($conn, $update_ver_funcio) or die(mysqli_error($conn));
}
      echo "<tr>
               <td class='fonte'>".$row['id_funcionario']."</td>
               <td class='fonte'>".$row['nome']."</td>
               <td class='fonte'>".$row['cpf']."</td>
               <td class='fonte'>".$row['funcao']."</td>                            
               <td class='fonte'>".$row['departamento']."</td>
               <td class='fonte'>".$row['empresa']."</td>
               <td class='fonte'>";

               while ($row_equip = mysqli_fetch_assoc($resultado_equipamento)) {

                  if($_SESSION["perfil"] == 3){
                     if($row_equip['equipamento'] === 'CPU'){
                        //não faz nada
                     }else{
                        echo " |".$row_equip['quantidade']. " - ".$row_equip['equipamento']."| ";
                     }
                  }else{
                     echo " |".$row_equip['quantidade']. " - ".$row_equip['equipamento']."| ";
                  }
               }

               echo "</td>";

               if ($row['id_status'] == 4) {//ativo
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: green;'></i> ".$row['status']."</td>";
               }
               if ($row['id_status'] == 10) {//Ausente
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: blue;'></i> ".$row['status']."</td>";
               }

               if ($row['id_status'] == 3) {//faltando termo
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: #f3b37c7a;'></i> ".$row['status']."";
                  /* ----------- CONTADOR -----------  */                          
                  if($historico_fataTermo['historico'] != 0){//se não conter nenhum historico não precisa aparecer a informação
                     echo 
                     "<div class='numeral' style='margin-left: 81px;'>
                        <span class='contador'>
                           <a href='inventario_edit.php?id=".$row['id_funcionario']."&page=1' title='".$historico_fataTermo['historico']." Mensagens no histórico'>
                              ".$historico_fataTermo['historico']."
                           </a>
                        </span>
                     </div>";
                  } 
                  /* ----------- FIM CONTADOR -----------  */ 
                  echo "</td>";
               }

               if ($row['id_status'] == 8) {//demitido
                  echo "<td class='fonte'>
                           <i class='fas fa-circle' style='color: black;'></i> ".$row['status'].""; 
                           /* ----------- CONTADOR -----------  */                          
                           if($historico_demitidos['historico'] != 0){//se não conter nenhum historico não precisa aparecer a informação
                              echo 
                              "<div class='numeral'>
                                 <span class='contador'>
                                    <a href='inventario_edit.php?id=".$row['id_funcionario']."&page=1' title='".$historico_demitidos['historico']." Mensagens no histórico'>
                                       ".$historico_demitidos['historico']."
                                    </a>
                                 </span>
                              </div>";
                           } 
                           /* ----------- FIM CONTADOR -----------  */                           
                  echo "</td>";
               }

               if ($row['id_status'] == 9) {//sem equipamento
                  echo "<td class='fonte'><i class='fas fa-circle' style='color: darkgray;'></i> ".$row['status']."</td>";
               }

               
         echo "<td class='fonte  acao'>";
         

               if($_SESSION["perfil"] != 3){
                  echo "<a href='inventario_edit.php?id=".$row['id_funcionario']."' title='Editar Colaborador' class='icon_acao'>
                           <i class='fas fa-pencil-alt'></i>
                        </a>";
               }

               if(($_SESSION["perfil"] == 3) || ($_SESSION["emitir_check_list"] == 1)){
                  
                  if(($row['id_status'] != 9)){
                     
                  echo "
                  <a href='emitir_cheklist.php?nome=".$row['nome']."&id_fun=".$row['id_funcionario']."' title='Chek-List' class='icon_acao' data-toggle='modal'>
                  <i class='fas fa-list-ul'></i>
                   </a>";

                  }
               }               
echo "            </td>
               </tr>";                
   
$contador++;
               }//fim WHILE

            }//fim IF                         
               mysqli_close($conn);
               ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</body>

</html>