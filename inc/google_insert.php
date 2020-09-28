<?php
   //aplicando para usar variavel em outro arquivo
   session_start();

   //chamando conexão com o banco
  require_once('../conexao/conexao.php');

  require_once('../conexao/pesquisa_condb.php');

   if($_SESSION["perfil"] == NULL){  
     header('location: ../front/index.html');
   
   }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 2) AND ($_SESSION["perfil"] != 4)) {
   
       header('location: ../front/error.php');
   }   

 require_once('header.php');
 
 ?>
<!--Chamando a Header-->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li><a href="tecnicos_ti.php"><i class="icon-home"></i><span>Home</span> </a> </li>
                <li><a href="equip.php"><i class="icon-table"></i><span>Inventário</span> </a> </li>
                <li class="active"><a href="google.php"><i class="icon-search"></i><span>Google T.I</span> </a></li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>

<div class="widget ">
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i>&nbsp;
            <a href="tecnicos_ti.php">Home</a>
            /
            <i class="fab fa-google"></i>&nbsp;
            <a href="google.php">Google T.I</a>
            /
            <i class="fas fa-plus"></i>&nbsp;
            Nova Informação
        </h3>
    </div>
</div>
<!-- /widget-header -->
<div class="widget-content">
    <div class="tabbable">
        <div id="formulario">
            <!--Buscando inforação pelo apollo-->
            <form id="form1" class="form-horizontal" action="google_inst.php" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                <!--GAMBI PARA PEGAR O ID-->
                <input type="texte" name="id_funcionario" value="" style="display: none;">
                <div class="control-group">

                    <h3 style="color: red;">
                        <font style="vertical-align: inherit;">Cadastro - Nova Informação</font>
                    </h3>
                </div>
                <label class="control-label required" for="gols1">Título:</label>
                <div class="control-group">
                    <div class="controls">

                        <?php

                    if ($_GET['id_pesquisa'] != NULL) {
                      
                      $query = "SELECT titulo from google WHERE cod_tabela = ".$_GET['id_pesquisa']."";
                      $result_titulo = $conn_db->query($query);
                      $row_titulo = $result_titulo->fetch_assoc();
                      echo "<input type='text' name='titulo' id='gols1' class='cpfcnpj span4' onkeydown='javascript: fMasc( this, mCPF );'' value='".$row_titulo['titulo']."'>";
                    }else{
                      echo "<input type='text' name='titulo' id='gols1' class='cpfcnpj span4' onkeydown='javascript: fMasc( this, mCPF );'' >";
                    }    
                    ?>

                    </div>
                </div>
                <label class="control-label">Arquivo PDF:</label>
                <div class="control-group">
                    <div class="controls">
                        <input type='file' name='file' id='gols1' class='span2'>
                        <span class="pdf">Apenas se for PDF*</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label required">Conteúdo:</label>
                    <div class="controls">
                        <div id="dvCentro">
                            <?php 
                        if ($_GET['id_pesquisa'] != NULL){
                           $query_body = "SELECT body from google WHERE cod_tabela = ".$_GET['id_pesquisa']."";
                           $result_body = $conn_db->query($query_body);
                           $row_body = $result_body->fetch_assoc();
                           echo "<textarea>".$row_body['body']."</textarea>";
                        }else{
                           echo "<textarea> Insira o seu Conteudo aqui! </textarea>";
                        }
                      ?>

                        </div>
                        <input type="text" name="cod_tabela" style="display:none;" value=" <?php 
                      echo $_GET['id_pesquisa']; ?>  " />

                        <script src="ckeditor/ckeditor.js">
                        </script>
                        <script>
                        CKEDITOR.replace('txtArtigo');
                        </script>
                    </div>
                </div>
                <div class="control-group" style="display: none;">
                    <label class="control-label required">Status:</label>
                    <div class="controls">
                        <select id="t_cob" name="status_funcionario" class="span2" required="">
                            <option value="3">PENDENTE</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /widget-content -->
</div>

<!-- Placed at the end of the document so the pages load faster -->
<script>
tinymce.init({
selector: 'textarea',
plugins: '',
toolbar: '',
toolbar_mode: 'floating',
});
</script>
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/excanvas.min.js"></script>
<script src="../js/chart.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../js/full-calendar/fullcalendar.min.js"></script>

<script src="../js/base.js"></script>
</body>

</html>