<?php

session_start();
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
        header('location: index.html');
   
   }elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
       header('location: error.php');
   }

require 'header.php';
require 'conexao.php';

//salvando equipamento no funcionário

$queryInFunEquip = "UPDATE manager_inventario_equipamento SET id_funcionario = '".$_GET['id_funcio']."', status = 1 WHERE id_equipamento = '".$_GET['id_equip']."'";

$resultIncFunEquip = mysqli_query($conn, $queryInFunEquip) or die(mysqli_error($conn));



//trazendo todos os equipamentos DISPONIVEIS
$queryDisponiveis = "SELECT 
                        MIE.id_equipamento,
                        MDE.nome AS tipo_equipamento,
                        MIE.modelo,
                        MIE.patrimonio,
                        MIE.numero,
                        MIE.imei_chip
                        FROM
                        manager_inventario_equipamento MIE
                            LEFT JOIN
                        manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                        WHERE
                        MIE.status IN (6 , 10)
                            AND MIE.tipo_equipamento IN (1 , 3, 4, 2)
                        ORDER BY MDE.nome ASC";
$resultadoDisponiveis = mysqli_query($conn, $queryDisponiveis);

//Trazendo o funcionário

$queryFuncionario = "SELECT nome FROM manager_inventario_funcionario WHERE id_funcionario = ".$_GET['id_funcio']."";
$resultadoFuncionario = mysqli_query($conn, $queryFuncionario);
$linhaFuncionario = mysqli_fetch_assoc($resultadoFuncionario);
?>
<!--MENSAGEM-->
<div class="container">
		<div class="row">
			<div class="span12">
				<div class="error-container">
					<h2>QUASE LÁ!</h2>
					<div class="error-details">
						Deseja salvar mais algum equipamento?
					</div> <!-- /error-details -->
					<div class="error-actions">
						<a href="javascript:" class="btn btn-info" onclick="plus()" id="sim">Sim</a>
						<a href="javascript:" class="btn btn-warning" onclick="finsh()" id="nao">Não</a>
					</div> <!-- /error-actions -->
				</div> <!-- /error-container -->
			</div> <!-- /span12 -->
		</div> <!-- /row -->
    </div>
    
<!--FINALIZANDO-->

<div class="container" style="display: none" id='finalizando'>
		<div class="row">
			<div class="span12">
				<div class="error-container">
					<div class="error-actions">
                        <a href="javascript:" class="btn btn-info" onclick="finalizar()">FINALIZAR</a>
                            <?=                                            
                                '<script>
                                    function finalizar(){
                                        window.location.href = "pdf_termo.php?id_funcionario='.$_GET['id_funcio'].'&pagina=1";
                                    }
                                </script>'
                            ?>
					</div> <!-- /error-actions -->
				</div> <!-- /error-container -->
			</div> <!-- /span12 -->
		</div> <!-- /row -->
    </div>



<!--OUTROS EQUIPAMENTO-->
    <div class="container" style="display: none" id='equipamentos'>
        <div class="row">
            <div class="container">	
                <div class="row">	      	
                    <div class="span12">
                        <div class="widget ">
                            <div class="widget-header">
                                <i class="icon-user"></i>
                                <h3>Selecione os equipamentos que deseja vincular ao usuário: <b style="color: red"><?=$linhaFuncionario['nome']?></b></h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <form action="atrelando_equipamento.php" method="post">
                                    <!--FUCIONARIO-->
                                    <input type="text" value="<?=$_GET['id_funcio']?>" name="id_funcionario" style="display: none">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%; margin-left: 13px;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Tipo equipamento</th>
                                                <th>Modelo</th>
                                                <th>Patrimônio</th>
                                                <th>Número</th>
                                                <th>Imei Chip</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while($linhaDiponiveis = mysqli_fetch_assoc($resultadoDisponiveis)){
                                                    echo '<tr>
                                                            <td><input type="checkbox" name="equipamento[]" value='.$linhaDiponiveis['id_equipamento'].'></td>
                                                            <td>'.$linhaDiponiveis['id_equipamento'].'</td>
                                                            <td>'.$linhaDiponiveis['tipo_equipamento'].'</td>
                                                            <td>'.$linhaDiponiveis['modelo'].'</td>';
                                                    echo ($linhaDiponiveis['patrimonio'] == NULL) ? '<td>---</td>' : '<td>'.$linhaDiponiveis['patrimonio'].'</td>';
                                                    echo ($linhaDiponiveis['numero'] == NULL) ? '<td>---</td>' : '<td>'.$linhaDiponiveis['numero'].'</td>';
                                                    echo   '<td>'.$linhaDiponiveis['imei_chip'].'</td>
                                                        </tr>';
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Tipo equipamento</th>
                                                <th>Modelo</th>
                                                <th>Patrimônio</th>
                                                <th>Número</th>
                                                <th>Imei Chip</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="form-actions" style="margin-right: 32px">
                                        <button type="submit" class="btn btn-primary pull-right" id="salvarTermo" onclick="enviar()">Salvar + Termo</button>
                                        <?=                                            
                                           '<script>
                                           function enviar(){
                                                    setTimeout(function() {
                                                    window.location.href = "inventario_edit.php?id='.$_GET['id_funcio'].'&msn=8";
                                                }, 4000);  
                                                }
                                            </script>';
                                            

                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
function plus(){
   var equipamentos = document.getElementById('equipamentos').style.display;
   var finalizando = document.getElementById('finalizando').style.display;

   if(finalizando == "block"){
    document.getElementById('finalizando').style.display = "none";
   }

    if(equipamentos == "block"){
        document.getElementById('equipamentos').style.display = "none";
    }else{
        document.getElementById('equipamentos').style.display = "block";
    }

}

function finsh(){
    var equipamentos = document.getElementById('equipamentos').style.display;
    var finalizando = document.getElementById('finalizando').style.display;

   if(equipamentos == "block"){
    document.getElementById('equipamentos').style.display = "none";
   }

    if(finalizando == "block"){
        document.getElementById('finalizando').style.display = "none";
    }else{
        document.getElementById('finalizando').style.display = "block";
    }
}

    $(document).ready(function () {
        $('#example').DataTable(

            {

                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                "iDisplayLength": 5
            }
        );
    });


    function checkAll(bx) {
        var cbs = document.getElementsByTagName('input');
        for (var i = 0; i < cbs.length; i++) {
            if (cbs[i].type == 'checkbox') {
                cbs[i].checked = bx.checked;
            }
        }
    }
</script>
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="js/cnpj.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>   
<!--LOGIN-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

</html>