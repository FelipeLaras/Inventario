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
   require_once('../conexao/pesquisa_condb.php');
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
                <li><a href="relatorio_tecnicos.php"><i class="icon-list-alt"></i><span>Relatórios</span></a></li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>

<div class="row">	      	
    <div class="span12"> 
        <div class="widget ">
            <div class="widget-header">
                <h3>
                    <i class="icon-lithe icon-home"></i>&nbsp;
                    <a href="tecnicos_ti.php">Home</a>
                    /
                    <i class="fab fa-google"></i>&nbsp;
                    <a href="google.php">Google T.I</a>
                    /
                    <i class="fas fa-search"></i>&nbsp;
                    Pesquisa
                </h3>
            </div>
        </div>

        <div class="widget-content">
            <div class="tabbable">
                <div class="tab-content">
                    <div class="controls">
                        <?php 
                    $query_pesquisa = " SELECT 
                                            titulo, 
                                            body,
                                            caminho_arquivo, 
                                            cod_tabela 
                                        FROM 
                                            google 
                                        WHERE 
                                            deleted = 0 AND (titulo LIKE '%".$_POST['pesquisa']."%' OR body LIKE '%".$_POST['pesquisa']."%')";

                    //query que retorna as informações do banco
                    $result_pesquisa = $conn_db->query($query_pesquisa);

                    $contador = 0;
                    //laço de repetição para que todas as pesquisas sejam mostradas na pagina search.php

                if($result_pesquisa->fetch_assoc()){
                    while ($row_pequisa = $result_pesquisa->fetch_assoc()) {
                        echo"
                        <div class='accordion' id='accordion".$contador."'>
                            <div class='accordion-group'>
                            <div class='accordion-heading'>
                                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion".$contador."' href='#collapse".$contador."'>"
                                .$row_pequisa['titulo']."
                                        <div class='icone' style='margin-top: -43px;'>
                                            <a href='google_upt.php?id_pesquisa=".$row_pequisa['cod_tabela']."' class='ajuste_botao' title='Editar Manual'><i class='icon-large icon-pencil'></i></a>
                                            <a href='google_pdf.php?id_pesquisa=".$row_pequisa['cod_tabela']."' class='ajuste_botao' title='Editar' target='_blank'><i class='icon-large icon-print'></i></a>
                                            <a href='#myModal".$row_pequisa['cod_tabela']."' data-toggle='modal' class='ajuste_botao'><i class='icon-large icon-trash'></i></a>
                                        </div>
                                </a>
                            </div>  
                                <!--BODY-->
                                <div id='collapse".$contador."' class='accordion-body collapse' style='height: 0px;'>
                                    <div class='accordion-inner'>";
                                    echo $row_pequisa['body'];

                                    if($row_pequisa['caminho_arquivo'] != NULL){//caso tenho um PDF
                                        echo "<iframe src='".$row_pequisa['caminho_arquivo']."' frameborder='0' height='600px' width='100%'></iframe>";
                                    }
                                    echo "
                                    </div>
                                </div>
                            </div>
                            </div>

                            <!-- Modal -->
                            <div id='myModal".$row_pequisa['cod_tabela']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                <h3 id='myModalLabel'>
                                    <img src='../img/atencao.png' style='width: 10%'>
                                        EXCLUIR UMA INFORMAÇÃO!
                                </h3>
                            </div>
                            <div class='modal-body'>
                                <div id='button_pai'>
                                    <h5>Tem certeza que deseja excluir a informação:</h5>
                                    <p style='margin-top: 14px; font-weight: bold;'>Titulo = <span  style='padding: 10px;background-color: aliceblue;color: red;'>".$row_pequisa['titulo']."</span></p>
                                    <span style='color:red;font-size:9px;'></span>
                                </div>                                                           
                                <div class='modal-footer'>
                                    <a class='btn' data-dismiss='modal' aria-hidden='true'>NÂO</a>
                                    <a href='google_update.php?cod=".$row_pequisa['cod_tabela']."' class='btn btn-success'>SIM</a>
                                </div>
                            </div>
                            </div>
                        ";

                    $contador ++; 

                    }//end while

                }else{ echo "Não foi encontrado nenhum manual com a seguinte informação '".$_POST['pesquisa']."'"; }
                ?>
                <!--TITUlO-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="tab-content">
    
</div>

<fim>


<div class="tab-pane active" id="formcontrols">
    <fieldset>
        <div class="form-actions">
            <a href="google.php" class="btn btn-large btn-primary">Voltar</a>
        </div> <!-- /form-actions -->
    </fieldset>
</div>

<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<script src="../js/jquery-1.7.2.min.js"></script>

<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>

</body>

</html>