<?php 
session_start(); 
//incluindo o banco de dados
require_once('../conexao/conexao.php');

//VALIDAÇÃO EQUIPAMENTO

if ($_POST['modelo_celular0'] != NULL) {

} elseif ($_POST['modelo_tablet0']) {
	

}elseif($_POST['numero_chip0']){
	

}elseif($_POST['modelo_modem']){
		
}else{//esqueceu de selecionar um item!
	header('location: inventario_add.php?id_funcio='.$_POST['id_funcionario'].'&error=1');
	exit;
}

//DATA DE HOJE APRA COLOCAR NO CAMPO DATA_CADASTRO
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y');

//usuario

$query_edit_func = "UPDATE 
						manager_inventario_funcionario 
					SET 
						cpf = '".$_POST['gols1']."',
    					nome = '".$_POST['nome_funcionario']."', 
						funcao = '".$_POST['funcao_funcionario']."', 
						departamento = '".$_POST['depart_funcionario']."', 
						empresa = '".$_POST['empresa_funcionario']."',
						status = 3
					WHERE 
					(id_funcionario = '".$_POST['id_funcionario']."')";

$resultado = $conn->query($query_edit_func);

//celular
$cont_equip = 0;
$cont_acessorios = 0;

if ($_POST['modelo_celular0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	if ($_POST['id_equip'] != NULL) {

		$update_cel = "UPDATE 
							manager_inventario_equipamento 
						SET 
							id_funcionario = '".$_POST['id_funcionario']."', 
							data_criacao = '".$date."',
							status = 1  
						WHERE 
							id_equipamento = ".$_POST['id_equip']."";
		
		$resultado_update_cel = $conn->query($update_cel);
		$_SESSION['celular_id'.$cont_equip.''] = $_POST['id_equip'];
		
		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

		//data de hoje

		$data = date('d/m/Y G:i:s');

		//query para salvar log

		$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
					VALUES ('".$_POST['id_funcionario']."',
							'".$_POST['id_equip']."',
							'".$data."',
							'".$_SESSION["id"]."',
							'5')";
		$result_log = $conn->query($log_query);

		/*_________________________________ FECHANDO O BANCO ______________________________________*/

	}else{

		while ($_POST['modelo_celular'.$cont_equip.''] != NULL) {
			
			
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$insert_equipamento = "INSERT INTO manager_inventario_equipamento
										(id_funcionario,
										usuario, 
										tipo_equipamento, 
										filial, 
										modelo, 
										operadora,
										situacao, 
										estado,
										imei_chip,  
										data_criacao, 
										data_nota, 
										valor) 
									VALUES 
										('".$_POST['id_funcionario']."',
										'".$_SESSION['id']."', 
										'1', 
										'".$_POST['filial_celular'.$cont_equip.'']."',
										'".$_POST['modelo_celular'.$cont_equip.'']."', 
										'5',
										'".$_POST['situacao_celular'.$cont_equip.'']."',
										'".$_POST['status_celular'.$cont_equip.'']."',
										'".$_POST['imei_celular'.$cont_equip.'']."', 
										'".$date."',
										'".$_POST['data_nota_celular'.$cont_equip.'']."',
										'".$_POST['valor'.$cont_equip.'']."')";
										
			if(!$conn->query($insert_equipamento)){

				printf("Ops! DEU ERRO (01) - PRINTA ESSE ERRO E MANDE PARA O E-MAIL DO felipe.lara@servopa.com.br<br /> Mensagem do erro: %s\n", $conn->error);
				exit;
			}

			
			//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
			$query_max_equip = "SELECT max(id_equipamento) AS id FROM manager_inventario_equipamento";
			$resultado_max_equip = $conn->query($query_max_equip);

			$row_max_equip = mysqli_fetch_assoc($resultado_max_equip);
			$id_equip = $row_max_equip['id'];

			if (isset($_POST['acessorio_celular'.$cont_equip.''])) {

				$idAcessorioCelular = $_POST['acessorio_celular'.$cont_equip.''];

				foreach ($idAcessorioCelular as $IdCelular) {
					//montando a query
					$query_acessorios = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ('".$id_equip."','".$IdCelular."')";
					$resultado_acessrios = $conn->query($query_acessorios);
				}

			}

			$_SESSION['celular_id'.$cont_equip.''] = $id_equip;//pegando o id do equipamento para emitir um termo só dele
			//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
			$cont_equip++;

			/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_equip."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/
			
		}
	}	
}


/*SALVANDO TABLET*/
//variaveis de contagem
$cont_equip_tablet = 0;
$cont_tablet = 0;


if ($_POST['modelo_tablet0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	while ($_POST['modelo_tablet'.$cont_equip_tablet.''] != NULL) {

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$insert_equipamento_tablet = "INSERT INTO manager_inventario_equipamento (		
											id_funcionario,
											usuario, 
											tipo_equipamento, 
											patrimonio,
											filial, 
											modelo, 
											operadora,
											situacao,
											estado, 
											imei_chip,
											data_criacao, 
											data_nota, 
											valor) 
										VALUES 
											(".$_POST['id_funcionario'].",
											'".$_SESSION['id']."', 
											'2',
											'".$_POST['patrimonio_tablet'.$cont_equip_tablet.'']."',
											'".$_POST['filial_tablet'.$cont_equip_tablet.'']."',
											'".$_POST['modelo_tablet'.$cont_equip_tablet.'']."', 
											'5',
											'".$_POST['situacao_tablet'.$cont_equip_tablet.'']."',
											'".$_POST['status_tablet'.$cont_equip_tablet.'']."',
											'".$_POST['imei_tablet'.$cont_equip_tablet.'']."',
											'".$date."',
											'".$_POST['data_nota_tablet'.$cont_equip_tablet.'']."', 
											'".$_POST['valor_tablet'.$cont_tablet.'']."')";

		if(!$conn->query($insert_equipamento_tablet)){

			printf("Ops! DEU ERRO (02) PRINTA ESSE ERRO E MANDE PARA O E-MAIL DO felipe.lara@servopa.com.br<br /> Mensagem do erro: %s\n", $conn->error);
			exit;
		}

		//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
		$query_max_equip = "SELECT max(id_equipamento) AS id FROM manager_inventario_equipamento";
		$resultado_max_equip = $conn->query($query_max_equip);

		$row_max_equip = mysqli_fetch_assoc($resultado_max_equip);
		$id_equip = $row_max_equip['id'];

		if (isset($_POST['acessorio_tablet'.$cont_equip_tablet.''])) {

			$idAcessorioTablet = $_POST['acessorio_tablet'.$cont_equip_tablet.''];

			foreach ($idAcessorioTablet as $IdTablet) {
				//montando a query
				$query_tablet = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ('".$id_equip."','".$IdTablet."')";
				
				if(!$conn->query($query_tablet)){

					printf("Ops! DEU ERRO (03) - PRINTA ESSE ERRO E MANDE PARA O E-MAIL DO felipe.lara@servopa.com.br<br /> Mensagem do erro: %s\n", $conn->error);
					exit;
				}
			}

		}

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_equip."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/

		$_SESSION['tablet_id'.$cont_equip_tablet.''] = $id_equip;//pegando o id do equipamento para emitir um termo só dele
		//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
		$cont_equip_tablet++;


	}
}

/*SALVANDO CHIP*/
$cont_equip_chip=0;

if ($_POST['numero_chip0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	if ($_POST['id_equip'] != NULL) {

		$update = "UPDATE 
						manager_inventario_equipamento 
					SET 
						id_funcionario = '".$_POST['id_funcionario']."', 
						data_criacao = '".$date."',
						status = 1 
					WHERE 
						id_equipamento = ".$_POST['id_equip']."";
		
		$resultado_update = $conn->query($update);
		$_SESSION['chip_id'.$cont_equip_chip.''] = $_POST['id_equip'];

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$_POST['id_equip']."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/


	}else{

		while ($_POST['operadora_chip'.$cont_equip_chip.''] != NULL) {
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$query_equipamento_chip = "INSERT INTO manager_inventario_equipamento
											(id_funcionario,
											usuario, 
											tipo_equipamento,
											filial,
											modelo, 
											operadora, 
											numero, 
											planos_voz, 
											planos_dados, 
											imei_chip,
											data_criacao, 
											valor) 
										VALUES 
											(".$_POST['id_funcionario'].",
											'".$_SESSION['id']."', 
											'3',
											'".$_POST['empresa_funcionario']."', 
											'---', 
											'".$_POST['operadora_chip'.$cont_equip_chip.'']."',
											'".$_POST['numero_chip'.$cont_equip_chip.'']."', 
											'".$_POST['voz'.$cont_equip_chip.'']."', 
											'".$_POST['dados'.$cont_equip_chip.'']."', 
											'".$_POST['imei_chip'.$cont_equip_chip.'']."',
											'".$date."', 
											'---')";

			if(!$conn->query($query_equipamento_chip)){

				printf("Ops! DEU ERRO (04) - PRINTA ESSE ERRO E MANDE PARA O E-MAIL DO felipe.lara@servopa.com.br<br /> Mensagem do erro: %s\n", $conn->error);
				exit;
			}

			/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
			$query_max_equip = "SELECT max(id_equipamento) AS id FROM manager_inventario_equipamento";
			$resultado_max_equip = $conn->query($query_max_equip);

			$row_max_equip = mysqli_fetch_assoc($resultado_max_equip);
			$id_equip = $row_max_equip['id'];

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_equip."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/

			$_SESSION['chip_id'.$cont_equip_chip.''] = $id_equip;//pegando o id do equipamento para emitir um termo só dele

			//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
			$cont_equip_chip++;
		}
	}

}

/*SALVANDO O MODEM*/
if ($_POST['modelo_modem'] != NULL) {


		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_modem = "INSERT INTO manager_inventario_equipamento 
							(id_funcionario, 
							usuario,
							tipo_equipamento, 
							modelo, 
							operadora, 
							numero, 
							planos_voz, 
							planos_dados, 
							imei_chip, 
							data_criacao, 
							valor) 
						VALUES 
							(".$_POST['id_funcionario'].",
							'".$_SESSION['id']."', 
							'4', 
							'".$_POST['modelo_modem']."', 
							'".$_POST['operadora_modem']."',
							'".$_POST['numero_modem']."', 
							'---',
							'---', 
							'".$_POST['imei_modem']."',
							'".$date."', 
							'---')";

		if(!$conn->query($query_modem)){

			printf("Ops! DEU ERRO (05) - PRINTA ESSE ERRO E MANDE PARA O E-MAIL DO felipe.lara@servopa.com.br<br /> Mensagem do erro: %s\n", $conn->error);
			exit;
		}

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
			$query_max_equip = "SELECT max(id_equipamento) AS id FROM manager_inventario_equipamento";
			$resultado_max_equip = $conn->query($query_max_equip);

			$row_max_equip = mysqli_fetch_assoc($resultado_max_equip);
			$id_equip = $row_max_equip['id'];

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_equip."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/
		
		$_SESSION['modem_id'] = $id_equip;//pegando o id do equipamento para emitir um termo só dele
}
$conn->close();


header('location: pdf_new_termo.php?id_fun='.$_POST['id_funcionario'].'');
?>