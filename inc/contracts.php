<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif ($_SESSION["perfil"] != 0 AND $_SESSION["perfil"] != 1) {
   
       header('location: error.php');
   }
   ?>
<?php  require 'header.php'?><!--Chamando a Header-->
<div class="subnavbar">
   <div class="subnavbar-inner">
      <div class="container">
         <ul class="mainnav">
            <li class="active">
               <a href="contracts.php"><i class="icon-folder-close"></i>
               <span>Contratos</span>
               </a>
            </li>
            <li>
               <a href="error.php"><i class="icon-list-alt"></i>
               <span>Relatórios</span>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>
<div class="widget ">
   <div class="widget-header">
      <h3>
         <i class="icon-lithe icon-home"></i> 
         <a href="manager.php">Home</a> / Contratos         
      </h3>
      <div id="novo_usuario">
         <a class="btn btn-default btn-xs botao" href="contracts_add.php" title="Adicionar novo funcionário"> 
            <i class='btn-icon-only icon-plus' style="margin-left: -3px"> </i>
         </a>
      </div>
   </div>   
</div>
      <div class="container">
         <div class="row">
            <table id="example" class="table table-striped table-bordered" style="width:98%">
               <thead>
                  <tr>
                     <th class="titulo">Nome</th>
                     <th class="titulo">CNPJ</th>
                     <th class="titulo">Numero Contrato</th>
                     <th class="titulo">Tipo</th>
                     <th class="titulo">Tipo de Cobrança</th>
                     <th class="titulo">Departamento</th>
                     <th class="titulo">Data</th>
                     <th class="titulo">Ação</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     //conectando com o bando de dados
                     //criando a pesquisa 
                     $query = "SELECT * FROM manager_contracts WHERE deleted = 0"; //0 = ativo, 1 = desativado
                     //Criando a pesquisa para contagem  
                     
                     //aplicando a regra e organizando na tela
                     if ($resultado = mysqli_query($conn, $query)){
                         
                             while($row = mysqli_fetch_assoc($resultado)){
                                 
                                 echo "<tr>
                                         <td class='fonte'>".$row['name']."</td>
                                         <td class='fonte'>".$row['cnpj']."</td>
                                         <td class='fonte'>".$row['number']."</td>                            
                                         <td class='fonte'>".$row['type']."</td>
                                         <td class='fonte'>".$row['type_collection']."</td>
                                         <td class='fonte'>".$row['department']."</td>
                                         <td class='fonte'>".$row['date_start']."</td>
                                         <td class='fonte'>
                                             <a href='contracts_edit.php?id=".$row['id']."' title='Ver Contrato' class='icon_acao'>
                                               <i class='icon-folder-open'></i>
                                             </a> 
                                             <a href='#myModalexcluir".$row['id']."' title='Excluir' class='icon_acao' data-toggle='modal'>
                                               <i class='icon-remove-circle'></i>
                                             </a>
                                         </td>
                                     </tr>
                                    <!-- Modal FILHO EXCLUIR -->
                                    <div id='myModalexcluir".$row['id']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                      <div id='pai'>
                                        <div class='modal-body'>
                                          <h3 id='myModalLabel'>Deseja Excluir o contrato <br>".$row['name']."?</h3>
                                          <form id='edit-profile' class='form-horizontal' action='contracts_update.php' method='post'>
                                            <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                                            <input type='text' name='id_contrato_father' style='display: none' value='".$row['id']."' />
                                            <div id='button_pai'>
                                              <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                              <button class='btn btn-danger'>Sim</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>";
                                 
                             }
                         }
                         
                     mysqli_close($conn);
                     ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- Le javascript
   ================================================== -->
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