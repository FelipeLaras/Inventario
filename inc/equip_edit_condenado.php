<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) && ($_SESSION["perfil"] != 2) && ($_SESSION["perfil"] != 4)) {
       header('location: error.php');
   } 

   require_once('header.php');
   require_once('../conexao/conexao.php');
   require_once('../query/query.php');
   require_once('../query/query_dropdowns.php');

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

   $query_contrato .= "F.deletar = 0 AND F.id_funcionario =".$_GET['id_fun']." AND MIE.id_equipamento = ".$_GET['id_equip']."";

   $resultadoContrato = $conn -> query($query_contrato);
   $row = $resultadoContrato -> fetch_assoc(); 

   ?>
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="manager.php">Home</a>
            /
            <i class="icon-lithe icon-table"></i>&nbsp;
            <a href="equip_condenados.php">Inventário Condenados</a>
            /
            <i class="icon-lithe fas fa-laptop"></i>&nbsp;&nbsp;
            <?php
   if($row['tipo_equipamento'] == 5){
      echo "<a href='javascript:'>".$row['ipdi']."</a>";
   }else{
      echo "<a href='javascript:'>".$row['patrimonio']."</a>";
   }
?>
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#contratos" data-toggle="tab">Funcionário / Equipamento</a>
                </li>
                <li>
                    <a href="#anexos" data-toggle="tab">Notas / Termos</a>
                </li>
            </ul>
            <?php
    if($_GET['msn'] == 1){
       echo "
            <div class='alert alert-success'>
               <button type='button' class='close' data-dismiss='alert'>×</button>
               <strong>Atenção!</strong> Dados da nota alterado com sucesso!.
            </div>";
   }
   if($_GET['msn'] == 2){
      echo "
           <div class='alert alert-success'>
              <button type='button' class='close' data-dismiss='alert'>×</button>
              <strong>Atenção!</strong> Office cadastrado com sucesso!.
           </div>";
  }
  if($_GET['msn'] == 3){
   echo "
        <div class='alert alert-success'>
           <button type='button' class='close' data-dismiss='alert'>×</button>
           <strong>Atenção!</strong> Office transferido com sucesso!.
        </div>";
}
    ?>
            <div class="tab-content">
                <!--Equipamento-->
                <div class="tab-pane active" id="contratos">
                    <form id="edit-profile" class="form-horizontal" action="equip_add_alter.php" method="post">
                        <!--Uma gambiarra para levar o id do contrato para a tela de update-->
                        <input type="text" name="id_funcionario" style="display: none;" value="<?= $_GET['id_fun'] ?>">
                        <!--fim da gambiarra-->
                        <div class="control-group">
                            <h3 style="color: red;">
                                <font style="vertical-align: inherit;">Funcionário Responsável:</font>
                            </h3>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nome completo:</label>
                            <div class="controls">
                                <input class="span6" name="nome" type="text" onkeyup='maiuscula(this)' required
                                    value="<?= $row['nome'] ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">CPF:</label>
                            <div class="controls">
                                <input class="cpfcnpj span2" type="text" name="cnpj_forne" value="<?= $row['cpf']  ?>"
                                    required />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Função:</label>
                            <div class="controls">
                                <select id="t_cont" name="funcao" class="span2">
                                    <option value="<?= $row['id_funcao'] ?>"><?= $row['funcao']  ?></option>
                                    <?php
                                       while ($row_funcao = $resultado_funcao -> fetch_assoc()) {
                                          echo "<option value='".$row_funcao['id_funcao']."'>".$row_funcao['nome']."</option>";
                                       }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Empresa / Filial:</label>
                            <div class="controls">
                                <select id="t_cob" name="empresa" class="span2" required>
                                    <option value="<?= $row['id_empresa'] ?>"><?= $row['empresa']  ?>
                                    </option>
                                    <?php
                                       while ($row_empresa = $resultado_empresa -> fetch_assoc()) {
                                          echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                       }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Departamento:</label>
                            <div class="controls">
                                <select id="setor_1" name="setor" class="span2">
                                    <option value="<?= $row['id_depart'] ?>"><?= $row['departamento']  ?>
                                    </option>
                                    <?php 
                                       while ($row_depart = $resultado_depart -> fetch_assoc()) {
                                          echo "<option value='".$row_depart['id_depart']."'>".$row_depart['nome']."</option>";
                                       } 
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php

                    if($row['tipo_equipamento'] == 8){//desktop

                      echo "
                    <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Desktop (CPU):</font>
                        </h3>
                    </div>
                    <input value='".$row['tipo_equipamento']."' style='display:none;' name='tipo_equipamento'/>
                    <input value='".$_GET['id_equip']."' style='display:none;' name='id_equipamento'/>
                    <div class='control-group'>
                        <label class='control-label'>Patrimônio:</label>
                        <div class='controls'>
                          <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_cpu' type='text' value='".$row['patrimonio']."'>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Empresa:
                           <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='empresa_cpu' class='span2'>
                              <option value='".$row['id_filial']."'>".$row['filial']."</option>
                              <option>---</option>";
                              while ($row_empresa = $resultado_empresa -> fetch_assoc()) {
                                 echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                              }
                        echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Locação:
                           <i class='icon-lithe icon-question-sign' title='Onde se encontra o equipamento!'></i>
                        </label>
                        <div class='controls'>
                           <select id='t_cob' name='locacao_cpu' class='span2'>
                              <option value='".$row['id_locacao']."'>".$row['locacao']."</option> 
                              <option>---</option>"; 
                              while ($row_locacao = $resultado_locacao -> fetch_assoc()) {
                                echo "<option value='".$row_locacao['id_empresa']."'>".$row_locacao['nome']."</option>";
                              }
                        echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Departamento:</label>
                        <div class='controls'>
                           <select id='t_cob' name='depart_cpu' class='span2'>
                              <option value='".$row['id_departamentoE']."'>".$row['departamento_equip']."</option>
                              <option>---</option>";
                              while ($row_departamento = $resultado_depart -> fetch_assoc()) {
                                echo "<option value='".$row_departamento['id_depart']."'>".$row_departamento['nome']."</option>";
                              }
                        echo "</select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Nome do computador:</label>
                        <div class='controls'>
                           <input class='span2' name='nome_cpu' type='text' value='".$row['hostname']."'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Endereço IP:</label>
                        <div class='controls'>
                           <input class='span2' name='ip_cpu' type='text' value='".$row['ip']."'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Modelo:</label>
                        <div class='controls'>
                           <input class='span2' name='modelo_cpu' type='text' value='".$row['modelo']."'>                            
                        </div>
                     </div>  
                     <div class='control-group'>
                        <label class='control-label'>Processador:</label>
                        <div class='controls'>
                           <input class='span3' name='processador_cpu' type='text' value='".$row['processador']."'>                            
                        </div>
                     </div>   
                     <div class='control-group'>
                        <label class='control-label'>Hard Disk:</label>
                        <div class='controls'>
                           <input class='span1' name='hd_cpu' type='text' value='".$row['hd']."'>                            
                        </div>
                     </div> 
                     <div class='control-group'>
                        <label class='control-label'>Memória:</label>
                        <div class='controls'>
                           <input class='span1' name='memoria_cpu' type='text' value='".$row['memoria']."'>                            
                        </div>
                     </div>
                      <div class='control-group'>
                        <label class='control-label'>Situacao:</label>
                        <div class='controls'>
                           <select id='setor_1' name='situacao_cpu' class='span1'>
                              <option value='".$row['id_situacao']."'>".$row['situacao']."</option>
                              <option>---</option>";
                                 while ($row_situacao = $resultado_situacao -> fetch_assoc()) {
                                 echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                 }
                           echo "
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Número de série:</label>
                        <div class='controls'>
                           <input class='span3' name='serie_cpu' type='text' value='".$row['serialnumber']."'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <h3 style='color: red;'>
                            <font style='vertical-align: inherit;'>Sistema operacional:</font>
                        </h3>
                    </div>
                    <div class='control-group'>
                        <label class='control-label'>Versão:</label>
                        <div class='controls'>
                        <select id='t_cob' name='so_cpu' class='span4'>
                              <option value='".$row['id_so']."'>".$row['so']."</option>
                           </select>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Chave Key:</label>
                        <div class='controls'>
                           <input class='span3' name='serial_so_cpu' type='text' value='".$row['serial_so']."'>                            
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Fornecedor:</label>
                        <div class='controls'>
                           <input class='span4' name='fornecedor_so_cpu' type='text' value='".$row['forn_so']."'>                            
                        </div>
                     </div>
                   ";
                  
                   if($row['id_office'] != NULL){
                     echo "
                           <div class='control-group'>
                                 <h3 style='color: red;'>
                                    <font style='vertical-align: inherit;'>Office:</font>
                                 </h3>
                           </div>
                           <input value='".$row['id_office']."' style='display:none' name='id_office' />
                           <div class='control-group'>
                              <label class='control-label'>Office:</label>
                              <div class='controls'>
                              <select id='t_cob' name='tipo_office' class='span4'>
                                    <option value='".$row['id_office']."'>".$row['office']."</option>
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Fornecedor:</label>
                              <div class='controls'>
                                 <input class='span3' name='fornecedor_office_cpu' type='text' value='".$row['forn_office']."'>                            
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Locacao:</label>
                              <div class='controls'>
                              <select id='t_cob' name='locacao_office_cpu' class='span3'>
                                    <option value='".$row['id_locacaoOffice']."'>".$row['locacaoOffice']."</option>
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Empresa:</label>
                              <div class='controls'>
                              <select id='t_cob' name='empresa_office_cpu' class='span3'>
                                    <option value='".$row['id_empresaOffice']."'>".$row['empresaOffice']."</option>
                                    <option>---</option>";
                                       while ($row_cpu_officeE = $resultado_empresa -> fetch_assoc()) {
                                          echo "<option value='".$row_cpu_officeE['id_empresa']."'>".$row_cpu_officeE['nome']."</option>";
                                       }
                                 echo "
                                 </select>
                              </div>
                           </div>
                           <div class='control-group'>
                              <label class='control-label'>Chave Key:</label>
                              <div class='controls'>
                                 <input class='span3' name='serial_nota_office_cpu' type='text' value='".$row['serial_office']."'>                            
                              </div>
                           </div>
                           ";
                   }//end IF OFFICE DESKTOP
               }//end IF DESKTOP

               if($row['tipo_equipamento'] == 9){//NOTEBOOK

                  echo "
                <div class='control-group'>
                    <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Notebook:</font>
                    </h3>
                </div>
                <input value='".$row['tipo_equipamento']."' style='display:none;' name='tipo_equipamento'/>
                <input value='".$_GET['id_equip']."' style='display:none;' name='id_equipamento'/>
                <div class='control-group'>
                    <label class='control-label'>Patrimônio:</label>
                    <div class='controls'>
                      <input class='cpfcnpj span2' id='gols2' name='num_patrimonio_notebook' type='text' value='".$row['patrimonio']."'>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Empresa:
                       <i class='icon-lithe icon-question-sign' title='Quem ta pagando o equipamento?'></i>
                    </label>
                    <div class='controls'>
                       <select id='t_cob' name='empresa_notebook' class='span2'>
                          <option value='".$row['id_filial']."'>".$row['filial']."</option>
                          <option>---</option>";
                           while ($row_empresa = $resultado_empresa -> fetch_assoc()) {
                              echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                           }
                    echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Locação:
                       <i class='icon-lithe icon-question-sign' title='Onde se encontra o equipamento!'></i>
                    </label>
                    <div class='controls'>
                       <select id='t_cob' name='locacao_notebook' class='span2'>
                          <option value='".$row['id_locacao']."'>".$row['locacao']."</option> 
                          <option>---</option>";
                           while ($row_locacao = $resultado_locacao -> fetch_assoc()) {
                              echo "<option value='".$row_locacao['id_empresa']."'>".$row_locacao['nome']."</option>";
                           }
                    echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Departamento:</label>
                    <div class='controls'>
                       <select id='t_cob' name='depart_notebook' class='span2'>
                          <option value='".$row['id_departamentoE']."'>".$row['departamento_equip']."</option>
                          <option>---</option>";
                          while ($row_departamento = $resultado_depart -> fetch_assoc()) {
                            echo "<option value='".$row_departamento['id_depart']."'>".$row_departamento['nome']."</option>";
                          }
                    echo "</select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Nome do computador:</label>
                    <div class='controls'>
                       <input class='span2' name='nome_notebook' type='text' value='".$row['hostname']."'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Endereço IP:</label>
                    <div class='controls'>
                       <input class='span2' name='ip_notebook' type='text' value='".$row['ip']."'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Modelo:</label>
                    <div class='controls'>
                       <input class='span2' name='modelo_notebook' type='text' value='".$row['modelo']."'>                            
                    </div>
                 </div>  
                 <div class='control-group'>
                    <label class='control-label'>Processador:</label>
                    <div class='controls'>
                       <input class='span3' name='processador_notebook' type='text' value='".$row['processador']."'>                            
                    </div>
                 </div>   
                 <div class='control-group'>
                    <label class='control-label'>Hard Disk:</label>
                    <div class='controls'>
                       <input class='span1' name='hd_note' type='text' value='".$row['hd']."'>                            
                    </div>
                 </div> 
                 <div class='control-group'>
                    <label class='control-label'>Memória:</label>
                    <div class='controls'>
                       <input class='span1' name='memoria_note' type='text' value='".$row['memoria']."'>                            
                    </div>
                 </div>
                  <div class='control-group'>
                    <label class='control-label'>Situacao:</label>
                    <div class='controls'>
                       <select id='setor_1' name='situacao_note' class='span1'>
                          <option value='".$row['id_situacao']."'>".$row['situacao']."</option>
                          <option>---</option>";
                             while ($row_situacao= $resultado_situacao -> fetch_assoc()) {
                              echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                             }
                       echo "
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Número de série:</label>
                    <div class='controls'>
                       <input class='span3' name='serie_notebook' type='text' value='".$row['serialnumber']."'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Sistema operacional:</font>
                    </h3>
                </div>
                <div class='control-group'>
                    <label class='control-label'>Versão:</label>
                    <div class='controls'>
                    <select id='t_cob' name='so_notebook' class='span4'>
                          <option value='".$row['id_so']."'>".$row['so']."</option>
                       </select>
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Chave Key:</label>
                    <div class='controls'>
                       <input class='span3' name='serial_so_note' type='text' value='".$row['serial_so']."'>                            
                    </div>
                 </div>
                 <div class='control-group'>
                    <label class='control-label'>Fornecedor:</label>
                    <div class='controls'>
                       <input class='span4' name='fornecedor_so_note' type='text' value='".$row['forn_so']."'>                            
                    </div>
                 </div>
               ";
              
               if($row['id_office'] != NULL){
                 echo "
                       <div class='control-group'>
                             <h3 style='color: red;'>
                                <font style='vertical-align: inherit;'>Office:</font>
                             </h3>
                       </div>
                       <input value='".$row['id_office']."' style='display:none' name='id_office' />
                       <div class='control-group'>
                          <label class='control-label'>Office:</label>
                          <div class='controls'>
                          <select id='t_cob' name='office_note' class='span4'>
                                <option value='".$row['id_office']."'>".$row['office']."</option>
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Fornecedor:</label>
                          <div class='controls'>
                             <input class='span4' name='fornecedor_office_note' type='text' value='".$row['forn_office']."'>                            
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Locacao:</label>
                          <div class='controls'>
                          <select id='t_cob' name='local_note_office' class='span3'>
                                <option value='".$row['id_locacaoOffice']."'>".$row['locacaoOffice']."</option>
                                <option>---</option>";
                                   while ($row_cpu_officeL = $resultado_locacao -> fetch_assoc()) {
                                    echo "<option value='".$row_cpu_officeL['id_empresa']."'>".$row_cpu_officeL['nome']."</option>";
                                   }
                             echo "
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Empresa:</label>
                          <div class='controls'>
                          <select id='t_cob' name='empresa_note_office' class='span3'>
                                <option value='".$row['id_empresaOffice']."'>".$row['empresaOffice']."</option>
                                <option>---</option>";
                                   while ($row_cpu_officeE = $resultado_empresa -> fetch_assoc()) {
                                   echo "<option value='".$row_cpu_officeE['id_empresa']."'>".$row_cpu_officeE['nome']."</option>";
                                   }
                             echo "
                             </select>
                          </div>
                       </div>
                       <div class='control-group'>
                          <label class='control-label'>Chave Key:</label>
                          <div class='controls'>
                             <input class='span3' name='serial_office_note' type='text' value='".$row['serial_office']."'>                            
                          </div>
                       </div>";
               }//end IF OFFICE NOTEBOOK
           }//end IF NOTEBOOK

           if($row['tipo_equipamento'] == 5){//RAMAL

               echo "
               <div class='control-group'>
                     <h3 style='color: red;'>
                        <font style='vertical-align: inherit;'>Ramal:</font>
                     </h3>
               </div>
               <input value='".$row['tipo_equipamento']."' style='display:none;' name='tipo_equipamento'/>
               <input value='".$_GET['id_equip']."' style='display:none;' name='id_equipamento'/>
               <div class='control-group'>
                  <label class='control-label'>Número:</label>
                  <div class='controls'>
                     <input class='span3' name='numero_ramal' type='text' value='".$row['numero']."'>                            
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>Empresa:</label>
                  <div class='controls'>
                  <select id='t_cob' name='empresa_ramal' class='span3'>
                        <option value='".$row['id_filial']."'>".$row['filial']."</option>
                        <option>---</option>";
                           while ($row_cpu_officeE = $resultado_empresa -> fetch_assoc()) {
                              echo "<option value='".$row_cpu_officeE['id_empresa']."'>".$row_cpu_officeE['nome']."</option>";
                           }
                     echo "
                     </select>
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>Locação:</label>
                  <div class='controls'>
                  <select id='t_cob' name='local_ramal' class='span3'>
                        <option value='".$row['id_locacao']."'>".$row['locacao']."</option>
                        <option>---</option>";
                           while ($row_cpu_officeE = mysqli_fetch_assoc($resultado_cpu_officeE)) {
                              echo "<option value='".$row_cpu_officeE['id_empresa']."'>".$row_cpu_officeE['nome']."</option>";
                           }
                     echo "
                     </select>
                  </div>
               </div>
               <div class='control-group'>
                  <label class='control-label'>IPDI:</label>
                  <div class='controls'>
                     <input class='span3' name='ipdi_ramal' type='text' value='".$row['ipdi']."'>                            
                  </div>
               </div>
               ";



           }//end IF RAMAL

?>
                        <div class="form-actions">
                            <?php
                              if($_GET['id_equip'] != NULL){
                                 $query_tem_office = "SELECT id FROM manager_office WHERE id_equipamento = ".$_GET['id_equip'] .";";
                                 $result_tem_office = $conn -> query($query_tem_office);
                                 $row_tem_office = $result_tem_office -> fetch_assoc();

                                 if($row_tem_office['id'] != NULL){
                                    echo "<a href='#myModalOfficeDrop' class='btn btn-danger' data-toggle='modal' style='margin-left: -142px;'> Transferir Office</a>";
                                 }
                           }//end IF adicionar office
?>
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
                                            <th>Nome - Documento</th>
                                            <th>Versão</th>
                                            <th>Data Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    /*--------------------WINDOWS-------------------------*/
                                    //pesquisando os arquivos criados.
                                    $query_doc_windows = "SELECT 
                                                               MSO.id AS id_windows,
                                                               MSO.file_nota AS caminho_so,
                                                               MSO.file_nota_nome AS nome_nota_so,
                                                               MDS.nome AS versao_so,
                                                               MSO.data_nota AS data_nota_so
                                                         FROM
                                                               manager_sistema_operacional MSO
                                                         LEFT JOIN
                                                               manager_dropsistemaoperacional MDS ON MSO.versao = MDS.id
                                                         WHERE
                                                               MSO.id_equipamento = ".$_GET['id_equip']." AND MSO.data_nota != '9999-12-30'";

                                    $result_cod_windows = $conn -> query($query_doc_windows);
                                    
                                    while ($row_windows = $result_cod_windows -> fetch_assoc()) {
                                       $date_windows = date('d/m/Y', strtotime($row_windows['data_nota_so']));
                                       echo "<tr>
                                                <td>
                                                   <a href='".$row_windows['caminho_so']."' target='_blank'>".$row_windows['nome_nota_so']."</a>
                                                </td>
                                                <td>
                                                   ".$row_windows['versao_so']."
                                                </td>
                                                <td>
                                                   ".$date_windows."
                                                </td>                                              
                                             ";
                                       }//end WHILE windows
                                     /*--------------------OFFICE-------------------------*/
                                    //pesquisando os arquivos criados.
                                    $query_doc_office = "SELECT 
                                                               MO.id AS id_office,
                                                               MO.file_nota AS caminho_of,
                                                               MO.file_nota_nome AS nome_nota_of,
                                                               MDO.nome AS versao_of,
                                                               MO.data_nota AS data_nota_of
                                                         FROM
                                                               manager_office MO
                                                         LEFT JOIN
                                                               manager_dropoffice MDO ON MO.versao = MDO.id
                                                         WHERE
                                                               MO.id_equipamento = ".$_GET['id_equip']." AND MO.data_nota != '9999-12-30';";

                                    $result_cod_office = $conn -> query($query_doc_office);

                                    while ($row_office = $result_cod_office -> fetch_assoc()) {
                                       $date_office = date('d/m/Y', strtotime($row_office['data_nota_of']));
                                       echo "<tr>
                                                <td>
                                                   <a href='".$row_office['caminho_of']."' target='_blank'>".$row_office['nome_nota_of']."</a>
                                                </td>
                                                <td>
                                                   ".$row_office['versao_of']."
                                                </td>
                                                <td>
                                                   ".$date_office."
                                                </td>                  
                                             </tr>";
                                       }//end WHILE OFFICE
                                    /*--------------------TERMO-------------------------*/
                                    //pesquisando os arquivos criados.
                                    $query_doc_termo = "SELECT 
                                                               MIA.id_anexo,
                                                               MIA.caminho,
                                                               MIA.nome,
                                                               MIA.data_criacao
                                                         FROM
                                                               manager_inventario_anexo MIA
                                                         WHERE
                                                               MIA.id_equipamento = ".$_GET['id_equip']."";

                                                               $result_cod_termo = $conn -> query($query_doc_termo);

                                    while ($row_termo = $result_cod_termo -> fetch_assoc()) {
                                       $date_termo = date('d/m/Y', strtotime($row_termo['data_criacao']));
                                       echo "<tr>
                                                <td>
                                                   <a href='".$row_termo['caminho']."' target='_blank'>".$row_termo['nome']."</a>
                                                </td>
                                                <td>
                                                   TERMO DE RESPOSABILIDADE
                                                </td>
                                                <td>
                                                   ".$date_termo."
                                                </td>
                                             </tr>
                                             ";
                                       }//end WHILE windows
                                       ?>
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
<script src="../java.js"></script>
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
        <h3 id="myModalLabel">Nota Fiscal / Termo</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_add_doc.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <div class="control-group">
            </div>

            <div class="control-group">
                <label class="control-label required">Tipo:</label>
                <div class="controls">
                    <select id="t_cob" name="tipo" class="span2" required="">                       
                    <option value=''>---</option>
                     <?php
                     $query_office = "SELECT id FROM manager_office WHERE id_equipamento = '".$_GET['id_equip']."' ";
                     $result_office = $conn -> query($query_office);
                     $row_office = $result_office -> fetch_assoc();
                     if($row_office['id'] != NULL){
                        echo "
                           <option value='1'>Nota Windows</option>
                           <option value='2'>Nota Office</option>
                           <option value='3'>Termo de Responsabilidade</option>";
                     }else{
                        echo "
                           <option value='1'>Nota Windows</option>
                           <option value='3'>Termo de Responsabilidade</option>";
                     }
                     ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Data:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="date" name="data" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Selecione:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="termo" required />
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
                       while($row = $resultado_office -> fetch_assoc()){
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
                        while ($row_officeNEW= $resultado_locacao -> fetch_assoc()) {
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
                        while ($row_office= $resultado_empresa -> fetch_assoc()) {
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
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_trans.php"
            method="post">
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
                              MO.id_equipamento = ".$_GET['id_equip']."";

               $result_traz_office = $conn -> query($traz_office);

               if($row_traz_office = $result_traz_office -> fetch_assoc()){
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
                                    while ($row_officeE = $resultado_locacao -> fetch_assoc()) {
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
                                    while ($row_officeEM = $resultado_empresa -> fetch_assoc()) {
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
                                                MIE.tipo_equipamento IN (8,9) AND MIE.deletar = 0";

                        $result_search_user = $conn -> query($buscando_usuario);

                        while($row_search = $result_search_user -> fetch_assoc()){

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
<!-- Modal REMOVE Windows -->
<div id="myModalWindowsDrop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">
            <img src="img/alerta.png" style="width: 10%">
            Transferir Windows para outro equipamento
        </h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="equip_trans.php"
            method="post">
            <input type="text" name="id_fun" style="display:none ;" value="<?= $_GET['id_fun']; ?>">
            <input type="text" name="id_equip" style="display:none ;" value="<?= $_GET['id_equip']; ?>">
            <?php
            $traz_windows = "SELECT 
                                 MDSO.nome AS windows,
                                 MSO.fornecedor,
                                 MDL.nome AS locacao_windows,
                                 MSO.locacao AS IDlocacao_windows,
                                 MDE.nome AS empresa_windows,
                                 MSO.empresa AS IDempresa_windows,
                                 MSO.serial
                              FROM
                                 manager_sistema_operacional MSO
                              LEFT JOIN
                                    manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                              LEFT JOIN
                                 manager_dropempresa MDE ON MSO.empresa = MDE.id_empresa
                              LEFT JOIN
                                 manager_droplocacao MDL ON MSO.locacao = MDL.id_empresa
                              WHERE
                                 MSO.id_equipamento = ".$_GET['id_equip']."";

            $result_traz_windows = $conn -> query($traz_windows);

            if($row_traz_windows = $result_traz_windows -> fetch_assoc()){
               echo "<div class='control-group'>
                        <label class='control-label'>Windows:</label>                  
                        <div class='controls'>
                           <input class='span3' type='text' name='windows' value='".$row_traz_windows['windows']."'/>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Fornecedor:</label>                  
                        <div class='controls'>
                           <input class='span4' type='text' name='fornecedor_windows' value='".$row_traz_windows['fornecedor']."'/>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Locacao:</label>
                        <div class='controls'>
                           <select id='t_cob' name='local_windows' class='span3'>
                              <option value='".$row_traz_windows['IDlocacao_windows']."'>".$row_traz_windows['locacao_windows']."</option>
                              <option>---</option>";
                                 while ($row_windowsE= $resultado_locacao -> fetch_assoc()) {
                                    echo "<option value='".$row_windowsE['id_empresa']."'>".$row_windowsE['nome']."</option>";
                                 }
                              echo "   
                           </select>   
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Empresa:</label>
                        <div class='controls'>
                           <select id='t_cob' name='empresa_windows' class='span3'>
                              <option value='".$row_traz_windows['IDempresa_windows']."'>".$row_traz_windows['empresa_windows']."</option>
                              <option>---</option>";
                                 while ($row_windowsEM= $resultado_empresa -> fetch_assoc()) {
                                    echo "<option value='".$row_windowsEM['id_empresa']."'>".$row_windowsEM['nome']."</option>";
                                 }
                              echo "   
                           </select>   
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label'>Chave Key:</label>
                        <div class='controls'>
                           <input class='cpfcnpj span4' type='text' name='serial_windows' value='".$row_traz_windows['serial']."'/>
                        </div>
                     </div>
                              
                     <div class='control-group'>
                     <label class='control-label'>Equipamento:</label>
                     <div class='controls'>
                        <select id='t_cob' name='new_windows' class='span2'>
                           <option value=''>---</option>";
                           $buscando_usuario = "SELECT 
                                                   MSO.id AS id_windows,
                                                   MIE.id_equipamento,
                                                   MIE.patrimonio
                                                FROM
                                                   manager_inventario_equipamento MIE
                                                LEFT JOIN
                                                   manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
                                                WHERE
                                                   MIE.tipo_equipamento IN (8,9) AND MIE.deletar = 0";
                           $result_search_user = $conn -> query($buscando_usuario);

                           while($row_search = $result_search_user -> fetch_assoc()){

                                 if($row_search['id_windows'] == NULL){
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
<?php $conn -> close(); ?>