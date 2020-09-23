<?php 
session_start();
require 'conexao.php';
include 'header.php';

//aplicando para usar varialve em outro arquivo
?>
<div class="container">
	<div class="row">
		<div class="span12">
			<div class="error-container">
				<?php 

				if ($_GET['id'] != NULL) {

					$query = "SELECT deletar AS id, nome FROM manager_inventario_funcionario WHERE id_funcionario = ".$_GET['id']."";
					$resultado = mysqli_query($conn, $query);
					$row = mysqli_fetch_assoc($resultado);

					if ($row['id'] == 1) {//1 = desativado

						if($_SESSION["ativar_cpf"] == 0){ //0 - Não permite alterar
							echo "
							<h2 class='titulo_desativado'>
								<img src='img/alerta.png' style='width: 4%'>
								CPF DESATIVADO.!
							</h2>
							<div class='error-details'>
								<b>Nome Funcionário:</b> <u>".$row['nome']."</u></br></br><p>VOCÊ NÃO TEM PERMISSÃO PARA ATIVAR CADASTROS</p>
								<p style='color:red;text-decoration: underline;'>Verifique com o administrador do sistema</p>
							</div> <!-- /error-details -->
							<div class='error-actions'>
								<button type='button' href='active_funcionario.php?id_fun=".$_GET['id']."' class='btn btn-info' disabled>ATIVAR</button>
							</div>";

						}else{//1 - permite alterar

							if($_GET['tela'] == 1){//tela = 1 vem dos técnicos
								echo "
								<h2 class='titulo_desativado'>
									<img src='img/alerta.png' style='width: 4%'>
									CPF DESATIVADO.!
								</h2>
								<div class='error-details'>
									<b>Nome Funcionário:</b> <u>".$row['nome']."</u></br></br><p>SE O NOME CONFERE COM O CNPJ ENTÃO BASTA CLICAR NO BOTÃO ABAIXO.</p>
									<P>CASO CONTRARIO CONTATE O ADMINISTRADOR!</P>
								</div> <!-- /error-details -->
								<div class='error-actions'>
									<a href='active_funcionario.php?id_fun=".$_GET['id']."&tela=1' class='btn btn-info'>ATIVAR</a>
								</div>";
							}else{
								echo "
								<h2 class='titulo_desativado'>
									<img src='img/alerta.png' style='width: 4%'>
									CPF DESATIVADO.!
								</h2>
								<div class='error-details'>
									<b>Nome Funcionário:</b> <u>".$row['nome']."</u></br></br><p>PARA ATIVAR NOVAMENTE BASTA CLICAR NO BOTÃO ABAIXO.</p>
								</div> <!-- /error-details -->
								<div class='error-actions'>
									<a href='active_funcionario.php?id_fun=".$_GET['id']."' class='btn btn-info'>ATIVAR</a>
								</div>";
							}
						}
						
					}elseif($row['id'] == 0){
						echo "
							<h2 class='titulo_desativado'>
								CPF ATIVADO.!
							</h2>
					<div class='error-details'>
						<b>Nome Funcionário:</b> <u>".$row['nome']."</u></br></br><p>ATIVADO COM SUCESSO.</p>
					</div> <!-- /error-details -->
					<div class='error-actions'>
						<a href='inventario.php' class='btn btn-info'>Voltar</a>
					</div>";
					}else{
						header('location: inventario_edit.php?id='.$_GET['id'].'');
					}//0 = ativo
				}elseif($_GET['id_equip'] != NULL){
					echo "	
					<h2>Equipamento enviado para lista de condenados.!</h2>
					<div class='error-details'>
						Caso precise ativar novamente, vá para a tela de <a href='equip_condenados.php'>condenados...</a>
					</div> <!-- /error-details -->
					<div class='error-actions'>
						<a href='equip.php' class='btn btn-success'>OK</a>
					</div>";
				}else{
					echo "	
					<h2>Funcionario Desativado com Sucesso.!</h2>
					<div class='error-details'>
						Caso precise ativar novamente, abra um chamado no GLPI com a categoria <b>&ldquo;GLPI&rdquo;</b> e informe o CPF do funcionário
					</div> <!-- /error-details -->
					<div class='error-actions'>
						<a href='inventario.php' class='btn btn-success'>OK</a>
					</div>";
				}
			?>
			</div> <!-- /error-container -->
		</div> <!-- /span12 -->
	</div> <!-- /row -->
</div>