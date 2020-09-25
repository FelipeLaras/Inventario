<?php
   session_start();
   //chamando conexão com o banco
   require_once('../conexao/conexao.php');
   
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
       header('location: ../front/error.php');
   }
   require_once('header.php');
   require_once('../query/query_dropdowns.php');

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
               <span>Colaborares</span>
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
<!--FOMULARIO DE CONTRARO-->

<?php 
//mostrando erro na tela se caso não for fornecido nenhum equipamento
switch ($_GET['error']) {
   case '1':
      echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Você deve cadastrar no minimo um equipamento</div>";
      break;
   
   case '2':
      echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Arquivo já existe!</strong> O arquivo que vc está anexando já possui com o mesmo nome em nossos registro. Por favor renomeie</div>";
      break;
}
?>
<div class="widget ">
   <div class="widget-header">
      <h3>
      <i class="icon-home"></i> &nbsp;
            <a href="inventario_ti.php">
                Home
            </a>
            /
            <i class="icon-cogs"></i> &nbsp;
            <a href="inventario_equip.php">
                Equipamentos
            </a>
            /
            Novo Equipamento
      </h3>
   </div>
   <!-- /widget-header -->
   <div class="widget-content">
      <div class="tabbable">
         <div id="formulario">
            <!--Buscando inforação pelo apollo-->
                <form id='form1' class='form-horizontal' action='inventario_add_equip.php' method='POST' enctype='multipart/form-data' autocomplete='off'>
              <!--GAMBI PARA PEGAR O ID-->
              <input type="texte" name="id_funcionario" value="<?= $_GET['id_funcio']?>" style="display: none;">
               <div class="control-group">
                  <h3 style="color: red;">
                     <font style="vertical-align: inherit;">Cadastro - Equipamento</font>
                     </font>
                  </h3>
               </div>
               <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Observação!</strong> Neste formulario você irá cadastrar um equipamento sem ter um funcionário, então não terá termo.
              </div>
               <div class="control-group">                                 
                  <div class="controls">
                    <label class="control-label required" for="gols1" style="width: 14%;margin-left: -13%;">Selecione o Equipamento:</label>
                     <!--CELULAR-->
                     <label class="checkbox inline">
                     <a class="icone" href="javascript:;" onclick="mostrar('celular')" title="CELULAR">
                     <i class="fas fa-mobile-alt fa-2x"></i>
                     </a>
                     </label>
                     <!--TABLET-->
                     <label class="checkbox inline">
                     <a href="javascript:;" class="icone" onclick="mostrar('tablet')" title="TABLET">
                     <i class="fas fa-tablet-alt fa-2x"></i>
                     </a>
                     </label>
                     <!--CHIP-->
                     <label class="checkbox inline">
                     <a href="javascript:;" class="icone" onclick="mostrar('chip_celular')" title="CHIP CELULAR">
                     <i class="fas fa-sim-card fa-2x"></i>
                     </a>
                     </label>    
                     <!--MODEM-->
                     <label class="checkbox inline" style="display: none">
                     <a href="javascript:;" class="icone" onclick="mostrar('modem')" title="MODEM 3G CLARO">
                     <i class="fas fa-wifi fa-2x"></i>
                     </a>
                     </label>                               
                  </div>
                  <!-- /controls -->      
               </div>

              <!--CELULAR-->
               <div id="celular" style="display: none;">
                  <hr>
                  <div class="control-group">
                     <h3 style="color: #0029ff;">
                        <font style="vertical-align: inherit;">
                        <span onclick="fechar('celular')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;"> CELULAR</font>
                        </font>
                     </h3>
                  </div>
                  <!--Campos Escondidos-->
                  <label id="campos">
                     <div class="container">
                        <div class="row clearfix" style="width: 111%; margin-left: -5%;">
                           <div class="col-md-12 column" id="tab_logic_c">                                
                              <div class="control-group">                                                                        
                                 <!--MODELO-->
                                 <label class="control-label">Modelo:</label>
                                 <div class="controls">
                                    <input type='text' name='modelo_celular0' class='form-control input-md span2'/>
                                 </div>
                              </div>                                                                                                    
                              <!--FILIAL-->
                              <div class="control-group">  
                                 <label class="control-label">Filial:</label>
                                 <div class="controls">
                                    <select id="t_cob" name="filial_celular0" class="span2">
                                       <option value="">---</option>
                                       <?php
                                          while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                             echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <!--SITUAÇÂO-->
                              <div class="control-group">  
                                 <label class="control-label">Situação:</label>
                                 <div class="controls">
                                    <select id="t_cob" name="situacao_celular0" class="span2">
                                       <option value=''>---</option>
                                       <?php
                                          while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                                             echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <!--ESTADO-->
                              <div class="control-group">  
                                 <label class="control-label">Estado:</label>
                                 <div class="controls">
                                    <select id="t_cob" name="estado_celular0" class="span2">
                                       <option value=''>---</option>
                                       <?php
                                          while ($row_estado = $resultado_status->fetch_assoc()) {
                                             echo "<option value='".$row_estado['id']."'>".$row_estado['nome']."</option>";
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <!--ACESSÓRIOS-->
                              <div class="control-group">  
                                 <label class="control-label">Acessórios:</label>
                                 <div class="controls">
                                    <?php 
                                       while ($row_acessorio = $resultado_acessorio->fetch_assoc()) {
                                          echo "<label class='checkbox inline'>
                                                   <input type='checkbox' name='acessorio_celular0[]' value='".$row_acessorio['id_acessorio']."'> ".$row_acessorio['nome']."
                                                </label></br>";
                                       }
                                    ?>
                                 </div>
                              </div>
                              <!--IMEI-->
                              <div class="control-group">  
                                 <label class="control-label">IMEI:</label>
                                 <div class="controls">
                                    <input type='text' name='imei_celular0' class='form-control span2'/>
                                 </div>
                              </div>
                              <!--STATUS-->
                              <div class="control-group">  
                                 <label class="control-label">Status:</label>
                                 <div class="controls">
                                    <select id="t_cob" name="status_celular0" class="span2">
                                       <option value=''>---</option>
                                       <?php
                                          while ($row_situacao = $resultado_status_equip->fetch_assoc()) {
                                             echo "<option value='".$row_situacao['id_status']."'>".$row_situacao['nome']."</option>";
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>                              
                              <!--VALOR-->
                              <div class="control-group">  
                                 <label class="control-label">Valor:</label>
                                 <div class="controls">
                                    <span class="add-on">$</span>
                                    <input type="text" name='valor0' class='form-control span1' onKeyPress="return(MascaraMoeda(this,'.',',',event))">
                                 </div>
                              </div>
                              <!--DATA NOTA FISCAL-->
                              <div class="control-group">  
                                 <label class="control-label">Data nota fiscal:</label>
                                 <div class="controls">
                                    <input type='text' name='data_nota_celular0' class='form-control span2' placeholder="DD / MM / AAAA"/>
                                 </div>
                              </div>
                              <!--FILE NOTA FISCAL-->
                              <div class="control-group">  
                                 <label class="control-label">nota fiscal:</label>
                                 <div class="controls">
                                    <input type='file' name='file_nota_celular0' class='form-control span2'/>
                                 </div>
                              </div>
                              <!--FIM FORMULARIO-->
                              <div class="col-md-12 column" id='addrC1'></div>
                           </div>
                           <a id="celular_add" class="btn btn-success pull-left" title="Incluir equipamento">
                              <i class="fas fa-plus"></i>
                           </a>
                           <a id="celular_remover" class="pull-right btn btn-danger excluir" title="Excluir equipamento">
                              <i class="fas fa-minus"></i>
                           </a>
                        </div>
                     </label>
                  </div>
               </div>
                                   <!--Campos Escondidos-->
               <!--CAMPO ESCONDIDOS TABLET-->
               <div id="tablet" style="display: none;">
                  <hr>
                  <div class="control-group">
                     <h3 style="color: #0029ff;">
                        <font style="vertical-align: inherit;">
                        <span onclick="fechar('tablet')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;"> TABLET</font>
                        </font>
                     </h3>
                  </div>
                  <!--Campos Escondidos-->
                  <label id="campos">
                     <div class="container">
                        <div class="row clearfix" style="width: 111%; margin-left: -5%;">
                        <div class="col-md-12 column" id="tab_logic_t">                                                                         
                           <!--MODELO-->                               
                           <div class="control-group">
                              <label class="control-label">Modelo:</label>
                              <div class="controls">                              
                                 <input type='text' name='modelo_tablet0' class='form-control input-md span2'/>
                              </div>
                           </div>
                           <!--PATRIMONIO-->                               
                           <div class="control-group">
                              <label class="control-label">Patrimônio:</label>
                              <div class="controls">                              
                                 <input type='text' name='patrimonio_tablet0' class='form-control input-md span1'/>
                              </div>
                           </div>
                           <!--FILIAL-->
                           <div class="control-group">  
                              <label class="control-label">Filial:</label>
                              <div class="controls">
                                 <select id="t_cob" name="filial_tablet0" class="span2">
                                    <option value="">---</option>
                                    <?php
                                       while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                          echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <!--SITUAÇÂO-->
                           <div class="control-group">  
                              <label class="control-label">Situação:</label>
                              <div class="controls">                           
                                 <select id="t_cob" name="situacao_tablet0" class="span2">
                                    <option value=''>---</option>
                                 <?php
                                    while ($row_situacao = $resultado_situacao->fetch_assoc()) {
                                       echo "<option value='".$row_situacao['id_situacao']."'>".$row_situacao['nome']."</option>";
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                           <!--ESTADO-->
                           <div class="control-group">  
                              <label class="control-label">Estado:</label>
                              <div class="controls">
                                 <select id="t_cob" name="estado_tablet0" class="span2">
                                    <option value=''>---</option>
                                    <?php
                                       while ($row_estado = $resultado_empresa->fetch_assoc()) {
                                          echo "<option value='".$row_estado['id']."'>".$row_estado['nome']."</option>";
                                       }
                                    ?>
                                 </select>
                              </div>
                           </div>
                           <!--ACESSÓRIOS-->
                           <div class="control-group">  
                              <label class="control-label">Acessórios:</label>
                              <div class="controls">
                                 <?php 
                                    while ($row_acessorio = $resultado_acessorio->fetch_assoc()) {
                                       echo "<label class='checkbox inline'>
                                       <input type='checkbox' name='acessorio_tablet0[]' value='".$row_acessorio['id_acessorio']."'> ".$row_acessorio['nome']."
                                       </label></br>";
                                    }
                                 ?>
                              </div>
                           </div>
                           <!--IMEI-->
                           <div class="control-group">  
                              <label class="control-label">IMEI:</label>
                              <div class="controls">
                                 <input type='text' name='imei_tablet0' class='form-control span2'/>
                              </div>
                           </div>
                           <!--STATUS-->
                           <div class="control-group">  
                              <label class="control-label">Status:</label>
                              <div class="controls">
                                 <select id="t_cob" name="status_tablet0" class="span2">
                                    <option value=''>---</option>
                                    <?php
                                       while ($row_situacao = $resultado_status_equip->fetch_assoc()) {
                                          echo "<option value='".$row_situacao['id_status']."'>".$row_situacao['nome']."</option>";
                                       }
                                    ?>
                                 </select>
                              </div>
                           </div>
                           <!--DATA NOTA FISCAL-->
                           <div class="control-group">  
                              <label class="control-label">Data nota fiscal:</label>
                              <div class="controls">
                                 <input type='text' name='data_nota_tablet0' class='form-control span2' placeholder="DD / MM / AAAA"/>
                              </div>
                           </div>
                           <!--VALOR-->
                           <div class="control-group">  
                              <label class="control-label">Valor:</label>
                              <div class="controls">
                                 <span class="add-on">$</span>
                                 <input type="text" name='valor_tablet0' class='form-control span1' onKeyPress="return(MascaraMoeda(this,'.',',',event))" />
                              </div>
                           </div>
                           <!--FILE NOTA FISCAL-->
                           <div class="control-group">  
                                 <label class="control-label">nota fiscal:</label>
                                 <div class="controls">
                                    <input type='file' name='file_nota_tablet0' class='form-control span2'/>
                                 </div>
                              </div>
                           <div class="col-md-12 column" id='addrT1'></div>
                        </div>
                     </div>
                     <a id="tablet_row" class="btn btn-success pull-left" title="Incluir equipamento">
                        <i class="fas fa-plus"></i>
                     </a>
                     <a id="tablet_remover" class="pull-right btn btn-danger excluir" title="Excluir equipamento">
                        <i class="fas fa-minus"></i>
                     </a>
                  </div>
               </label>
            </div>
               <!--Campos Escondidos-->         
               <!--CAMPO ESCONDIDOS CHIP-CELULAR-->
               <div id="chip_celular" style="display: none;"> 
                  <hr>
                  <div class="control-group">
                     <h3 style="color: #0029ff;">
                        <font style="vertical-align: inherit;">
                        <span onclick="fechar('chip_celular')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;"> CHIP</font>
                        </font>
                     </h3>
                  </div>
                  <!--Campos Escondidos-->
                  <label id="campos">
                     <div class="container">
                        <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                           <div class="col-md-12 column">
                              <table class="table table-bordered table-hover" id="tab_logic_ch">
                                 <thead>
                                    <tr >
                                       <th class="text-center">
                                          Operadora
                                       </th>
                                       <th class="text-center">
                                          Filial
                                       </th>
                                       <th class="text-center">
                                          Número
                                       </th>
                                       <th class="text-center">
                                          Planos
                                       </th>
                                       <th class="text-center">
                                          Status
                                       </th>
                                       <th class="text-center">
                                          Imei CHIP
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr id='addrCH0'>
                                       <td>
                                          <select id="t_cob" name="operadora_chip0" class="span2">
                                             <option value=''>---</option>
                                          <?php
                                             while ($row_operadora = $resultado_operadora->fetch_assoc()) {
                                               echo "<option value='".$row_operadora['id_operadora']."'>".$row_operadora['nome']."</option>";
                                             }
                                             ?>
                                          </select>
                                       </td>
                                       <td>
                                          <select id="t_cob" name="filial_chip0" class="span2">
                                            <option value="">---</option>
                                          <?php
                                             while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                               echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                             }
                                             ?>
                                          </select>
                                       </td>
                                       <td>
                                          <input type="text" name='numero_chip0' onkeydown="javascript: fMasc( this, mTel );" class='form-control span2'>
                                       </td>
                                       <td>
                                         <label class='checkbox inline'>
                                            <input type='checkbox' name='voz0' value='Voz'>Voz
                                          </label>
                                          <label class='checkbox inline'>
                                            <input type='checkbox' name='dados0' value='Dados'>Dados
                                          </label>
                                        </td>
                                        <td>
                                          <select id="t_cob" name="status_chip0" class="span2">
                                            <option value="5">---</option>
                                            <option value="7">BLOQUEADO</option>
                                            <option value="4">BRANCO</option>                                            
                                            <option value="6">DISPONIVEL</option>
                                          </select>
                                       </td>
                                       <td>
                                          <input type='text' name='imei_chip0' class='form-control span3'/>
                                       </td>
                                    </tr>
                                    <tr id='addrCH1'></tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <a id="chip_row" class="btn btn-success pull-left">Adicionar Linhas</a><a id='chip_remover' class="pull-right btn btn-danger excluir">Excluir Linhas</a>
                     </div>
                  </label>
               </div>
               <!--Campos Escondidos-->
               <!--CAMPO ESCONDIDOS MODEM-->
               <div id="modem" style="display: none;">
                <hr>
                  <div class="control-group">
                     <h3 style="color: #0029ff;">
                        <font style="vertical-align: inherit;">
                        <span onclick="fechar('modem')" style="cursor:pointer; color:red;" title="Fechar">
                        <i class="far fa-window-close" style="float: right;"></i>
                        </span>
                        <font style="vertical-align: inherit;">MODEM</font>
                        </font>
                     </h3>
                  </div>
                  <!--Campos Escondidos-->
                  <label id="campos">
                     <div class="container">
                        <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                           <div class="col-md-12 column">
                              <table class="table table-bordered table-hover" id="tab_logic_m">
                                 <thead>
                                    <tr >
                                       <th class="text-center">
                                          Modelo
                                       </th>
                                       <th class="text-center">
                                         Filial
                                       </th>
                                       <th class="text-center">
                                          Número
                                       </th>
                                       <th class="text-center">
                                          Operadora
                                       </th>
                                       <th class="text-center">
                                          Imei Modem
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr id='addrM0'>
                                       <td>
                                          <input type='text' name='modelo_modem' class='form-control span4'/>
                                       </td>
                                       <td>
                                          <select id="t_cob" name="filial_modem" class="span2">
                                            <option value="">---</option>
                                          <?php
                                             while ($row_empresa = $resultado_empresa->fetch_assoc()) {
                                               echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";
                                             }
                                             ?>
                                          </select>
                                       </td>
                                       <td>
                                          <input type="text" name='numero_modem' onkeydown="javascript: fMasc( this, mTel );" class='form-control span2'>
                                       </td>
                                       <td>
                                          <select id="t_cob" name="operadora_modem" class="span2">
                                          <?php
                                             while ($row_operadora = $resultado_operadora->fetch_assoc()) {
                                               echo "<option value='".$row_operadora['id_operadora']."'>".$row_operadora['nome']."</option>";
                                             }
                                             ?>
                                          </select>
                                       </td>
                                       <td>
                                          <input type='text' name='imei_modem' class='form-control span4'/>
                                       </td>
                                    </tr>
                                    <tr id='addrM1'></tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </label>
               </div>
               <!--Campos Escondidos-->                  
               <div class="form-actions">
                  <button type="submit" class="btn btn-primary pull-right">Salvar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- /widget-content -->
</div>
<!-- /widget -->
<!-- /main-inner -->
</body>
<!-- Le javascript
   ================================================== --> 
<!--MOSTRAR CAMPO ICONE-->
<script>
   function mostrar(id){
       document.getElementById(id).style.display = 'block';
   }
   function fechar(id){
       if(document.getElementById(id).style.display == 'block'){ 
           document.getElementById(id).style.display = 'none';
       }else{
           document.getElementById(id).style.display = 'block';
       }
   }
</script>
<!--MASCARA MAIUSCULA-->
<script type="text/javascript">
   // INICIO FUNÇÃO DE MASCARA MAIUSCULA
   function maiuscula(z){
         v = z.value.toUpperCase();
         z.value = v;
      }
   //FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>
<!--Buscando informação do Apollo-->
<script type="text/javascript">
   //Buscar CNPJ no Apollo
   (function() {
   
   var $gols1 = document.getElementById('gols1');
   
   function handleSubmit(){
    if ($gols1.value)
      document.getElementById('form1').submit();
    }
   $gols1.addEventListener('blur', handleSubmit);
   })();
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="js/cnpj.js"></script>
<script src="js/contrato_filho_equip.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</html>
<?php   $conn->close(); ?>