<?php 
session_start();
require_once('header.php');

if($_GET['msn'] == 1){//1 = DESKTOP
	echo "<div class='container'>
			<div class='row'>
				<div class='span12'>
					<div class='error-container'>
						<h2>Equipamento Salvo com Sucesso!</h2>
						<div class='error-actions'>
							<div class='widget'>
								<div class='widget-header'>
									<h3>O QUE DESEJA FAZER AGORA ?</h3>
								</div>
								<!-- /widget-header -->
								<div class='widget-content'>
									<div class='shortcuts'> 
										<a href='javascript:;' onclick=mostrar('termo') id='modelo' class='shortcut' data-toggle='modal'>
											<i class='shortcut-icon fas fa-file-download'></i>
											<span class='shortcut-label'>Emitir Modelo</span> 
										</a>
										<a href='add_new.php' class='shortcut'>
											<i class='shortcut-icon fas fa-plus-square'></i>
											<span class='shortcut-label'>Novo Equipamento</span> 
										</a>
										<a href='equip.php' class='shortcut'>
											<i class='shortcut-icon fas fa-list-alt'></i> 
											<span class='shortcut-label'>Listar equipamentos</span> 
										</a>								
									</div>
									<!-- /widget-content --> 
								</div>
							</div> <!-- /error-actions -->
						</div> <!-- /error-container -->
					</div> <!-- /span12 -->
				</div> <!-- /row -->
			</div>
		</div>";
}
if($_GET['msn'] == 2){//NOTEBOOK
	echo "<div class='container'>
			<div class='row'>
				<div class='span12'>
					<div class='error-container'>
						<h2>Equipamento Salvo com Sucesso!</h2>
						<div class='error-actions'>
							<div class='widget'>
								<div class='widget-header'>
									<h3>O QUE DESEJA FAZER AGORA ?</h3>
								</div>
								<!-- /widget-header -->
								<div class='widget-content'>
									<div class='shortcuts'> 
										<a href='javascript:;' onclick=mostrar('termo') id='modelo' class='shortcut' data-toggle='modal'>
											<i class='shortcut-icon fas fa-file-download'></i>
											<span class='shortcut-label'>Emitir Modelo</span> 
										</a>

										<a href='pdf_termo_tecnicos.php?id_funcionario=".$_GET['id_funcionario']."&tipo=9' class='shortcut' target='_blank'>
											<i class='shortcut-icon fas fa-file-signature'></i> 
											<span class='shortcut-label'>Termo Responsabilidade</span> 
										</a>
										<a href='add_new.php' class='shortcut'>
											<i class='shortcut-icon fas fa-plus-square'></i>
											<span class='shortcut-label'>Novo Equipamento</span> 
										</a>
										<a href='equip.php' class='shortcut'>
											<i class='shortcut-icon fas fa-list-alt'></i> 
											<span class='shortcut-label'>Listar equipamentos</span> 
										</a>								
									</div>
									<!-- /widget-content --> 
								</div>
							</div> <!-- /error-actions -->
						</div> <!-- /error-container -->
					</div> <!-- /span12 -->
				</div> <!-- /row -->
			</div>
		</div>";
}

if($_GET['msn'] == 3){//caso seja algum equipamento dos inventarios usuário
	echo "
	<div class='container'>
			<div class='row'>
				<div class='span12'>
					<div class='error-container'>
						<h2>Equipamento Salvo com Sucesso!</h2>
						<div class='error-actions'>
							<div class='widget'>
								<div class='widget-header'>
									<h3>O QUE DESEJA FAZER AGORA ?</h3>
								</div>
								<!-- /widget-header -->
								<div class='widget-content'>
									<div class='shortcuts'> 										
										<a href='inventario_equip_add.php' class='shortcut'>
											<i class='shortcut-icon fas fa-plus-square'></i>
											<span class='shortcut-label'>Novo Equipamento</span> 
										</a>
										<a href='inventario_equip.php' class='shortcut'>
											<i class='shortcut-icon fas fa-list-alt'></i> 
											<span class='shortcut-label'>Listar equipamentos</span> 
										</a>								
									</div>
									<!-- /widget-content --> 
								</div>
							</div> <!-- /error-actions -->
						</div> <!-- /error-container -->
					</div> <!-- /span12 -->
				</div> <!-- /row -->
			</div>
		</div>";
}//end if = msn:3

if($_GET['ramal'] == 1){// RAMAL
	echo "<div class='container'>
			<div class='row'>
				<div class='span12'>
					<div class='error-container'>
						<h2>Equipamento Salvo com Sucesso!</h2>
						<div class='error-actions'>
							<div class='widget'>
								<div class='widget-header'>
									<h3>O QUE DESEJA FAZER AGORA ?</h3>
								</div>
								<!-- /widget-header -->
								<div class='widget-content'>
									<div class='shortcuts'> 
										<a href='pdf_termo_tecnicos.php?id_funcionario=".$_GET['id_funcionario']."&tipo=5' class='shortcut' target='_blank'>
											<i class='shortcut-icon fas fa-file-signature'></i> 
											<span class='shortcut-label'>Termo Responsabilidade</span> 
										</a>										
										<a href='add_new.php' class='shortcut'>
											<i class='shortcut-icon fas fa-plus-square'></i>
											<span class='shortcut-label'>Novo Equipamento</span> 
										</a>
										<a href='equip.php' class='shortcut'>
											<i class='shortcut-icon fas fa-list-alt'></i> 
											<span class='shortcut-label'>Listar equipamentos</span> 
										</a>								
									</div>
									<!-- /widget-content --> 
								</div>
							</div> <!-- /error-actions -->
						</div> <!-- /error-container -->
					</div> <!-- /span12 -->
				</div> <!-- /row -->
			</div>
		</div>";
}//end if = msn:1

if($_GET['scan'] == 1){// SCANNER
	echo "<div class='container'>
			<div class='row'>
				<div class='span12'>
					<div class='error-container'>
						<h2>Equipamento Salvo com Sucesso!</h2>
						<div class='error-actions'>
							<div class='widget'>
								<div class='widget-header'>
									<h3>O QUE DESEJA FAZER AGORA ?</h3>
								</div>
								<!-- /widget-header -->
								<div class='widget-content'>
									<div class='shortcuts'> 										
										<a href='add_new.php' class='shortcut'>
											<i class='shortcut-icon fas fa-plus-square'></i>
											<span class='shortcut-label'>Novo Equipamento</span> 
										</a>
										<a href='equip.php' class='shortcut'>
											<i class='shortcut-icon fas fa-list-alt'></i> 
											<span class='shortcut-label'>Listar equipamentos</span> 
										</a>								
									</div>
									<!-- /widget-content --> 
								</div>
							</div> <!-- /error-actions -->
						</div> <!-- /error-container -->
					</div> <!-- /span12 -->
				</div> <!-- /row -->
			</div>
		</div>";
}


?>

<div class='container' id='termo' style='display: none;'>
    <h3 style="color: #0029ff;">
        <font style="vertical-align: inherit;">
            <span onclick="fechar('termo')" style="cursor:pointer; color:red;float: right;margin-top: -27px;"
                title="Fechar">
                <i class="far fa-window-close"></i>
            </span>
        </font>
    </h3>
    <!--Campos Escondidos-->
    <div class='row'>
        <div class='span12'>
            <div class='error-container'>
                <div class='error-actions'>
                    <div class="control-group">
                        <div class='widget-header'>
                            <h3>Termos Disponíveis!</h3>
                        </div>
                    </div>
                    <div class='widget'>
                        <!-- /widget-header -->
                        <div class='widget-content' style="background-color: #bdb3b3">
                            <div class='shortcuts'>
                                <?php							
								if($_GET['win'] != NULL){
									echo "
									<a href='equip_modelo.php?id_win=".$_GET['win']."' class='shortcut' target='_blank'>
										<span class='shortcut-label'>WINDOWS</span>
									</a>";
								}//end IF botao modelo
								if($_GET['off'] != NULL){
													echo "
									<a href='equip_modelof.php?id_off=".$_GET['off']."' class='shortcut' target='_blank'>
										<span class='shortcut-label'>OFFICE</span> 
									</a>";
								}//end IF office
								?>

                            </div>
                            <!-- /widget-content -->
                        </div>
                    </div> <!-- /error-actions -->
                </div> <!-- /error-container -->
            </div> <!-- /span12 -->
        </div> <!-- /row -->
    </div>
</div>
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

<?php unset($_SESSION['patrimonio']); ?>
<!--FIM CAMPOS DO PATRIMONIO-->