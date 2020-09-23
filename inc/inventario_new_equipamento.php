<?php 
session_start(); 
//incluindo o banco de dados
include 'conexao.php';

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

$resultado = mysqli_query($conn, $query_edit_func) or die(mysqli_error($conn));

//adicionando os equipamentos

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
		
		$resultado_update_cel = mysqli_query($conn, $update_cel) or die(mysqli_error($conn));
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
		$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

		/*_________________________________ FECHANDO O BANCO ______________________________________*/

	}else{

		while ($_POST['modelo_celular'.$cont_equip.''] != NULL) {

			//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
			$query_max_equip = "SELECT max(id_equipamento) AS id FROM manager_inventario_equipamento";
			$resultado_max_equip = mysqli_query($conn, $query_max_equip);
			$row_max_equip = mysqli_fetch_assoc($resultado_max_equip);
			$id_equip = $row_max_equip['id'];
			$id_equip++;
			
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$insert_equipamento = "INSERT INTO manager_inventario_equipamento 
										(id_equipamento, 
										id_funcionario,
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
										('".$id_equip."',
										'".$_POST['id_funcionario']."',
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

			$resultado_equipamento = mysqli_query($conn, $insert_equipamento) or die(mysqli_error($conn));

			if (isset($_POST['acessorio_celular'.$cont_equip.''])) {

				$idAcessorioCelular = $_POST['acessorio_celular'.$cont_equip.''];

				foreach ($idAcessorioCelular as $IdCelular) {
					//montando a query
					$query_acessorios = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ('".$id_equip."','".$IdCelular."')";
					$resultado_acessrios = mysqli_query($conn, $query_acessorios) or die(mysqli_error($conn));
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
			$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

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
		//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
		$query_max_equip = "SELECT max(id_equipamento) AS id_tablet FROM manager_inventario_equipamento";
		$result = mysqli_query($conn, $query_max_equip);
		$row_max_tablet = mysqli_fetch_assoc($result);
		$id_tablet = $row_max_tablet['id_tablet'];
		$id_tablet++;

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$insert_equipamento_tablet = "INSERT INTO manager_inventario_equipamento 
											(id_equipamento, 
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
											(".$id_tablet.",
											".$_POST['id_funcionario'].",
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

		$resultado_equipamento_tablet = mysqli_query($conn, $insert_equipamento_tablet) or die(mysqli_error($conn));

		if (isset($_POST['acessorio_tablet'.$cont_equip_tablet.''])) {

			$idAcessorioTablet = $_POST['acessorio_tablet'.$cont_equip_tablet.''];

			foreach ($idAcessorioTablet as $IdTablet) {
				//montando a query
				$query_tablet = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ('".$id_tablet."','".$IdTablet."')";
				$resultado_tablet = mysqli_query($conn, $query_tablet) or die(mysqli_error($conn));
			}

		}

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_tablet."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

			/*_________________________________ FECHANDO O BANCO ______________________________________*/

		$_SESSION['tablet_id'.$cont_equip_tablet.''] = $id_tablet;//pegando o id do equipamento para emitir um termo só dele
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
		
		$resultado_update = mysqli_query($conn, $update) or die(mysqli_error($conn));
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
			$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

			/*_________________________________ FECHANDO O BANCO ______________________________________*/


	}else{

		while ($_POST['operadora_chip'.$cont_equip_chip.''] != NULL) {
			//pegando a ultima ID_EQUIPAMENTO para preencher o proximo equipamento
			$query_max_equip_chip = "SELECT max(id_equipamento) AS id_max_chip FROM manager_inventario_equipamento";
			$resultado_max_equip_chip = mysqli_query($conn, $query_max_equip_chip);
			$row_max_equip_chip = mysqli_fetch_assoc($resultado_max_equip_chip);
			$id_equip_chip = $row_max_equip_chip['id_max_chip'];
			$id_equip_chip++;
			
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$query_equipamento_chip = "INSERT INTO manager_inventario_equipamento
											(id_equipamento, 
											id_funcionario,
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
											(".$id_equip_chip.",
											".$_POST['id_funcionario'].",
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

			$resultado_equipamento_chip = mysqli_query($conn, $query_equipamento_chip) or die(mysqli_error($conn));

			/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_equip_chip."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

			/*_________________________________ FECHANDO O BANCO ______________________________________*/

			$_SESSION['chip_id'.$cont_equip_chip.''] = $id_equip_chip;//pegando o id do equipamento para emitir um termo só dele

			//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
			$cont_equip_chip++;
		}
	}

}

/*SALVANDO O MODEM*/
if ($_POST['modelo_modem'] != NULL) {		
		//pegando o ultimo ID
		$query_modem = "SELECT max(id_equipamento) AS id_max_moden FROM manager_inventario_equipamento";
		$resultado_max_modem = mysqli_query($conn, $query_modem);
		$row_max_modem = mysqli_fetch_assoc($resultado_max_modem);
		$id_modem = $row_max_modem['id_max_moden'];
		$id_modem++;


		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_modem = "INSERT INTO manager_inventario_equipamento 
							(id_equipamento, 
							id_funcionario, 
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
							(".$id_modem.",
							".$_POST['id_funcionario'].",
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

		$resultado_modem = mysqli_query($conn, $query_modem) or die(mysqli_error($conn));

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje

			$data = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_funcionario']."',
								'".$id_modem."',
								'".$data."',
								'".$_SESSION["id"]."',
								'5')";
			$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

			/*_________________________________ FECHANDO O BANCO ______________________________________*/
		
		$_SESSION['modem_id'] = $id_modem;//pegando o id do equipamento para emitir um termo só dele
}
mysqli_close($conn);


header('location: pdf_new_termo.php?id_fun='.$_POST['id_funcionario'].'');
?>