<?php 
//chamando a sessão
session_start();

//chamando o banco de dados
require_once('../conexao/conexao.php');

//DATA DE HOJE PARA COLOCAR NO CAMPO DATA_CADASTRO E OBSERVAÇÃO
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y G:i:s');

/*----------------------CELULAR---------------------- */
if($_POST['tipo_equipamento'] == 1 ){

	//alterando formato da data nota
	$data_nota = date('d/m/Y',  strtotime($_POST['data_nota_cel']));

	//alterando o status do equipamento no banco
	$update = "UPDATE manager_inventario_equipamento SET
	 
    modelo='".$_POST['modelo']."', 
	situacao = '".$_POST['situacao_equip']."',
	estado = '".$_POST['estado_equip']."',
	filial = '".$_POST['empresa_equip']."',
	imei_chip = '".$_POST['imei_chip']."',	
	status ='".$_POST['status_equip']."',
	data_nota = '".$data_nota."',
	valor = '".$_POST['valor_cel']."'
	WHERE id_equipamento ='".$_POST['id_equipamento']."'";
	$resultado = $conn->query($update);
	
	/*----------------------SALVANDO ACESSÓRIOS DO CELULAR---------------------- */

	foreach($_POST['acessorio_celular'] as $tipo_acessario) {//inventario.equip.php

		//VERIFICANDO SE JÁ ESTÁ CADASTRADO AO EQUIPAMENTO
		$verificar_acessorio = "SELECT id_equipamento, tipo_acessorio FROM manager_inventario_acessorios 
		WHERE  id_equipamento = ".$_POST['id_equipamento']." AND tipo_acessorio = ".$tipo_acessario."";
		$result_verificar = $conn->query($verificar_acessorio);
		$row_verificar = $result_verificar->fetch_assoc();

		if(empty($row_verificar['id_equipamento'])){//insert

			$insert_acessorios = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES (".$_POST['id_equipamento'].", ".$tipo_acessario.")";
			$result_insertA = $conn->query($insert_acessorios);
			
		}//end IF insert

	}//end FOREACH

	/*----------------------DELETANDO ACESSÓRIOS DO CELULAR---------------------- */

	$deletar_acessorios = "DELETE FROM manager_inventario_acessorios WHERE id_equipamento = ".$_POST['id_equipamento']."  AND tipo_acessorio NOT IN (";

	foreach ($_POST['acessorio_celular'] as $tipo_acessario) {
		$deletar_acessorios .= $tipo_acessario.",";
	}
	$deletar_acessorios .= "'')";
	$result_deletarA = $conn->query($deletar_acessorios );

	/*----------------------OBSERVAÇÃO DO CELULAR---------------------- */

	if($_POST['page'] == 2){
		//montando o log de alteração		
		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_equipamento']."',
						'".$date."',
						'".$_SESSION["id"]."',
						'0')";
		$result_log = $conn->query($log_query);

	}else{		
		//inserindo a observação do equipamento
		$insert = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, data_criacao, usuario)
		VALUES ('".$_POST['id_equipamento']."', '".$_POST['status_equip']."', '".$_POST['obs_cel']."', '".$date."','".$_SESSION['id']."')";
		$resultado_insert = $conn->query($insert);
	}

	
	/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

	//data de hoje
	$dataLog = date('d/m/Y G:i:s');

	//query para salvar log

	$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
					VALUES ('".$_POST['id_equipamento']."',
							'".$dataLog."',
							'".$_SESSION["id"]."',
							'0')";
	$result_log = $conn->query($log_query);

	/*_________________________________ FECHANDO O BANCO ______________________________________*/
}//end IF celular


/*----------------------TABLET---------------------- */

if($_POST['tipo_equipamento'] == 2){

	//alterando formato da data nota
	$data_nota = date('d/m/Y',  strtotime($_POST['data_nota_cel']));

	//alterando o status do equipamento no banco
	$update = "UPDATE manager_inventario_equipamento SET
	 
    modelo = '".$_POST['modelo']."', 
	patrimonio = '".$_POST['patrimonio']."', 
	situacao = '".$_POST['situacao_equip']."',
	estado = '".$_POST['estado_equip']."',
	filial = '".$_POST['empresa_equip']."',
	imei_chip = '".$_POST['imei_chip']."',	
	status ='".$_POST['status_equip']."',
	data_nota = '".$data_nota."',
	valor = '".$_POST['valor_cel']."'
	WHERE id_equipamento ='".$_POST['id_equipamento']."'";
	$resultado = $conn->query($update);
	
	/*----------------------SALVANDO ACESSÓRIOS DO TABLET---------------------- */

	foreach($_POST['acessorio_celular'] as $tipo_acessario) {//inventario.equip.php

		//VERIFICANDO SE JÁ ESTÁ CADASTRADO AO EQUIPAMENTO
		$verificar_acessorio = "SELECT id_equipamento, tipo_acessorio FROM manager_inventario_acessorios 
		WHERE  id_equipamento = ".$_POST['id_equipamento']." AND tipo_acessorio = ".$tipo_acessario."";
		$result_verificar = $conn->query($verificar_acessorio);
		$row_verificar = mysqli_fetch_assoc($result_verificar);

		if(empty($row_verificar['id_equipamento'])){//insert

			$insert_acessorios = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES (".$_POST['id_equipamento'].", ".$tipo_acessario.")";
			$result_insertA = $conn->query($insert_acessorios);
			
		}//end IF insert

	}//end FOREACH

	/*----------------------DELETANDO ACESSÓRIOS DO TABLET---------------------- */

	$deletar_acessorios = "DELETE FROM manager_inventario_acessorios WHERE id_equipamento = ".$_POST['id_equipamento']."  AND tipo_acessorio NOT IN (";

	foreach ($_POST['acessorio_celular'] as $tipo_acessario) {
		$deletar_acessorios .= $tipo_acessario.",";
	}
	$deletar_acessorios .= "'')";
	$result_deletarA = $conn->query($deletar_acessorios );

	/*----------------------OBSERVAÇÃO DO TABLET---------------------- */

	if($_POST['page'] == 2){
		//montando o log de alteração		
		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_equipamento']."',
						'".$date."',
						'".$_SESSION["id"]."',
						'0')";
		$result_log = $conn->query($log_query);

	}else{
		//inserindo a observação do equipamento
		$insert = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, data_criacao, usuario)
		VALUES ('".$_POST['id_equipamento']."', '".$_POST['status_equip']."', '".$_POST['obs_cel']."', '".$date."', '".$_SESSION['id']."')";
		$resultado_insert = $conn->query($insert);
	}		

	/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

	//data de hoje
	$dataLog = date('d/m/Y G:i:s');

	//query para salvar log

	$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
					VALUES ('".$_POST['id_equipamento']."',
							'".$dataLog."',
							'".$_SESSION["id"]."',
							'0')";
	$result_log = $conn->query($log_query);

	/*_________________________________ FECHANDO O BANCO ______________________________________*/

}//end IF TABLET

/*----------------------CHIP OPERADORA---------------------- */
if($_POST['tipo_equipamento'] == 3){

	//alterando o status do equipamento no banco
	$update = "UPDATE manager_inventario_equipamento SET

	operadora = '".$_POST['operadora']."', 
	planos_voz = '".$_POST['voz']."',
	planos_dados = '".$_POST['dados']."',
	numero = '".$_POST['numero_chip']."',
	imei_chip = '".$_POST['imei_chip']."',	
	status ='".$_POST['status_chip']."',
	filial = '".$_POST['empresa_chip']."'
	WHERE id_equipamento ='".$_POST['id_equipamento']."'";
	$resultado = $conn->query($update);

	/*----------------------OBSERVAÇÃO DO CHIP---------------------- */
	
	if($_POST['page'] == 2){
		//montando o log de alteração		
		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_equipamento']."',
						'".$date."',
						'".$_SESSION["id"]."',
						'0')";
		$result_log = $conn->query($log_query);

	}else{
		//inserindo a observação do equipamento
		$insert = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, data_criacao, usuario)
		VALUES ('".$_POST['id_equipamento']."', '".$_POST['status_chip']."', '".$_POST['obs_chip']."', '".$date."', '".$_SESSION['id']."')";

		$result_insert = $conn->query($insert);
	}		

	/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

	//data de hoje
	$dataLog = date('d/m/Y G:i:s');

	//query para salvar log

	$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
					VALUES ('".$_POST['id_equipamento']."',
							'".$dataLog."',
							'".$_SESSION["id"]."',
							'0')";
	$result_log = $conn->query($log_query);

	/*_________________________________ FECHANDO O BANCO ______________________________________*/
}//end IF CHIP

//voltando para a tela do funcionario
if($_POST['page'] == 1){
	header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&msn=1');
}
if($_POST['page'] == 2){
	header('location: inventario_equip_edit.php?id_equip='.$_POST['id_equipamento'].'&tipo='.$_POST['tipo_equipamento'].'&msn=1');
}else{
	header('location: inventario_equip.php?msn=1');
}

//fechando o banco de dados
$conn->close();
?>