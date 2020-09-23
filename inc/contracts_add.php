<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif ($_SESSION["perfil"] != 0 AND $_SESSION["perfil"] != 1) {
       header('location: ../front/error.php');
   }
   
require_once('header.php'); 

?>
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
<!--FOMULARIO DE CONTRARO-->
<div class="main">
   <div class="main-inner">
      <div class="container">
         <div class="row">
            <div class="span12">
               <div class="widget ">
                  <div class="widget-header">
                     <h3>
                        <i class="icon-lithe icon-home"></i> <a href="manager.php">Home</a> 
                        / 
                        <a href="contracts.php">Contratos</a>
                        / 
                        Novo Contrato
                     </h3>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                     <div class="tabbable">
                        <div id="formulario">
                           <!--Buscando inforação pelo apollo-->                              
                           <form id="form1" class="form-horizontal" action="apollo_cnpj.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                              <div class="control-group">
                                 <h3 style="color: red;">
                                    <font style="vertical-align: inherit;">
                                       <font style="vertical-align: inherit;">Contrato Pai</font>
                                    </font>
                                 </h3>     
                              </div>
                              <label class="control-label required" for='gols1' class="control-label required">CNPJ fornecedor:</label>
                              <div class="control-group">
                                 <div class="controls">
                                    <input name="gols1" id="gols1" class="cpfcnpj span2" type="text" 
                                       value="<?php
                                        if ($_SESSION['cnpj_apollo'] != NULL){
                                          echo $_SESSION['cnpj_apollo'];
                                          unset($_SESSION['cnpj_apollo']);
                                        }else{
                                          echo $_SESSION['vazia'];
                                          unset($_SESSION['vazia']);
                                        }
                                       ?>" required />
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">Nome completo:</label>
                                 <div class="controls">
                                    <input class="span6" name="nome" type="text" onkeyup='maiuscula(this)'required 
                                       value="<?php
                                        if ($_SESSION['nome_apollo'] != NULL){
                                          echo $_SESSION['nome_apollo'];
                                          unset($_SESSION['nome_apollo']);
                                        }else{
                                          echo '';
                                        }
                                       ?>" autofocus/>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">Numero contrato:</label>
                                 <div class="controls">
                                    <input class="span3" type="number" name="numero_contrato" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label">Tipo de contrato:</label>
                                 <div class="controls">
                                    <select id="t_cont" name="t_contrato" class="span2">
                                       <option value="">---</option>
                                       <option value="telefonia">Telefonia</option>
                                       <option value="terceiros">Terceiros</option>
                                       <option value="outros">Outros</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">Tipo de cobrança:</label>
                                 <div class="controls">
                                    <select id="t_cob" name="t_cobranca" class="span2" required>
                                       <option value="">---</option>
                                       <option value="anual">Anual</option>
                                       <option value="mensal">Mensal</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label">CNPJ filial:</label>
                                 <div class="controls">
                                    <input class="cpfcnpj span2" type="text" name="gols2" />
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label">Setor:</label>
                                 <div class="controls">
                                    <select id="setor_1" name="setor" class="span2">
                                       <option value="">---</option>
                                       <option value="cpd">CPD</option>
                                       <option value="csc">CSC</option>
                                       <option value="caixa">Caixa</option>
                                       <option value="vendas novos">Vendas Novos</option>
                                       <option value="vendas seminovos">Vendas Seminovos</option>
                                       <option value="todos">Todos</option>
                                    </select>
                                    <i class="icon-lithe icon-question-sign" title="Setor que irá desfrutar do beneficio"></i>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">Data inicial:</label>
                                 <div class="controls">
                                    <input class="span2" id="data-contrato" type="date" name="data_contrato" required/>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">Responsavel contrato:</label>
                                 <div class="controls">
                                    <input id="responsavel_1" type="text" name="nome_responsavel" onkeyup='maiuscula(this)' required/>
                                    <i class="icon-lithe icon-question-sign" title="Responsavel que irá responder pelo contrato"></i>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label required">E-mail:</label>
                                 <div class="controls">
                                    <input id="email_vencimento" type="email" name="email_responsavel" required/>
                                    <i class="icon-lithe icon-question-sign" title="Irá receber alerta deste contrato"></i>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label">Descrição:</label>
                                 <div class="controls">
                                    <textarea id="desc_resumo" type="text" name="descricao"></textarea>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label">Anexar documento:</label>
                                 <div class="controls">
                                    <input id="anexo_doc" type="file" name="anexo" />
                                 </div>
                              </div>
                              <!---->
                              <hr>
                              <div class="control-group">
                                 <h3 style="color: red;">
                                    <font style="vertical-align: inherit;">
                                       <font style="vertical-align: inherit;">Contrato Filho</font>
                                    </font>
                                 </h3>     
                              </div>
                              <!--Campos Escondidos-->
                              <label id="campos">
                                 <div class="container">
                                    <div class="row clearfix" style="width: 97%;margin-left: 0%;">
                                       <div class="col-md-12 column">
                                          <table class="table table-bordered table-hover" id="tab_logic">
                                             <thead>
                                                <tr >
                                                   <th class="text-center">
                                                      Nº Contrato
                                                   </th>
                                                   <th class="text-center">
                                                      CPNJ Contratante
                                                   </th>
                                                   <th class="text-center">
                                                      Valor R$
                                                   </th>
                                                   <th class="text-center">
                                                      Data Vencimento
                                                   </th>
                                                   <th class="text-center">
                                                      Tempo Carência
                                                   </th>
                                                   <th class="text-center">
                                                      Anexo
                                                   </th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr id='addr0'>
                                                   <td>
                                                      <input type='text' name='number_contract0' class='form-control input-md span2' required/>
                                                   </td>
                                                   <td>
                                                      <input type='text' name='cnpj_filho0' class='cpfcnpj form-control span2'required/>
                                                   </td>
                                                   <td>
                                                      <input type='text' name='valor0' class='dinheiro form-control span1'/>
                                                   </td>
                                                   <td>
                                                      <input type='date' name='data_venc0' class='form-control span2'required/>
                                                   </td>
                                                   <td>
                                                      <input type='number' name='temp_care0' class='form-control span1'required/>
                                                      <i class='icon-lithe icon-question-sign' title="Informe apenas numeros de Dias. Ex: 120"></i>
                                                   </td>
                                                   <td>
                                                      <input type='file' name='file_sun0' class='form-control'/>
                                                   </td>
                                                </tr>
                                                <tr id='addr1'></tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <a id="add_row" class="btn btn-success pull-left">Adicionar Linhas</a><a id='delete_row' class="pull-right btn btn-danger">Excluir Linhas</a>
                                 </div>
                              </label>
                              <!--Campos Escondidos-->                              
                              <div class="form-actions">
                                 <button type="submit" class="btn btn-primary pull-right">Salvar Contrato</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!-- /widget-content -->
               </div>
               <!-- /widget -->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /main-inner -->
</body>
<!-- Le javascript
   ================================================== --> 
<!-- Placed at the end of the document so the pages load faster -->
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
<!--Escondendo Campos-->
<script type="text/javascript">
   function HabCampos() {
           if (document.getElementById('periodo_sim').checked) {
             document.getElementById('campos').style.display = "";
         document.getElementById('textfield').focus();
           }  else {
             document.getElementById('campos').style.display = "none";
           }}
</script>
<!--Mostando novos campos--> 
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="js/cnpj.js"></script>
<script src="js/contrato_filho.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</html>