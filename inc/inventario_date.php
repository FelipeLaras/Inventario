<?php 
//iniciando a sessão
session_start();
//Banco de Dados
require_once('../conexao/conexao.php');

//limitador de caracteres
$limit_caracter = 24;

//Verificando a quantidade de caracreres tem o nome do arquivo

if(!empty($_FILES['checklist']['name'])){
	$total_sting = strlen($_FILES['checklist']['name']);
}

if($limit_caracter < $total_sting){
	header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&msn=5');				
	exit;	
}//if verificação caracteres

/*--------------------EXCLUIR ANEXO DE UM EQUIPAMENTO--------------------*/

if(($_POST['drop'] == 1) || ($_POST['drop'] == 2)){

	//deletar
	$drop_anexo = "UPDATE manager_inventario_anexo SET deletar = '1' WHERE id_anexo = ".$_POST['id_anexo']."";
	$result_drop = $conn->query($drop_anexo );

	//altera o estatus do equipamento termo
	$alter_equip = "UPDATE manager_inventario_equipamento SET termo = '1' WHERE id_funcionario = ".$_POST['id_funcionario']."";
	$resultado_equip = $conn->query($alter_equip );
	
	//altera o estatus do equipamento termo
	$alter_funcio = "UPDATE manager_inventario_funcionario SET status = '3' WHERE id_funcionario = ".$_POST['id_funcionario']."";
	$resultado_funcio = $conn->query($alter_funcio );


	/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

	//data de hoje
	$dataLog = date('d/m/Y G:i:s');

	//query para salvar log

	$log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
					VALUES ('".$_POST['id_funcionario']."',
							'".$dataLog."',
							'".$_SESSION["id"]."',
							'7')";
	$result_log = $conn->query($log_query);

/*_________________________________ FECHANDO O BANCO ______________________________________*/

}else{
	
	/*------------------------------------------------------------------------------------------------------------------------------------------*/
	//date de hoje
	$data_hoje = date('d/m/Y H:i:s');
	/*------------------------------------------------------------------------------------------------------------------------------------------*/
	//alterando o equipamento


	if($_POST['list_equip'] != NULL){//possui mais de um equipamento

		foreach ($_POST['list_equip'] as $list_equip ) {

			if($_POST['list_fun'] != NULL){//possui funcionario

				//editando o equipamento
				$update_vigencia ="UPDATE  manager_inventario_equipamento 
						SET filial='".$_POST['filial_equip']."', 
							status='".$_POST['status_equip']."',
							id_funcionario ='".$_POST['list_fun']."',
							termo = '1',
							liberado_rh = '0'
						WHERE id_equipamento = ".$list_equip."";
				$resultado_update = $conn->query($update_vigencia);

				//alterando estatus do funcionario
				$update_status ="UPDATE  manager_inventario_funcionario 
						SET status = '4'
						WHERE id_funcionario = ".$_POST['id_funcionario']."";
				$resultado_status = $conn->query($update_status);

				//Salvando a observação
				$insert_obs = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, usuario, data_criacao) 
				VALUES ('".$list_equip."', '".$_POST['status_equip']."', '".$_POST['obs']."','".$_SESSION['id']."', '".$data_hoje."')";
				$resultado_insert = $conn->query($insert_obs);

				//salvando o histórico em manager_data_vigência
				$historico_vigencia = "INSERT INTO manager_data_vigencia (id_equipamento, id_funcionario, id_usuario, data_vigencia)
				VALUES ('".$list_equip."', '".$_POST['id_funcionario']."', '".$_SESSION['id']."','".$data_hoje."')";
				$result_historico = $conn->query($historico_vigencia);


			}else{

				$update_vigencia ="UPDATE  manager_inventario_equipamento 
						SET filial='".$_POST['filial_equip']."', 
							status='".$_POST['status_equip']."',
							id_funcionario ='0',
							termo = '1',
							liberado_rh = '0'
						WHERE id_equipamento = ".$list_equip."";
				$resultado_update = $conn->query($update_vigencia);

				//Salvando a observação
				$insert_obs = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, usuario, data_criacao) 
				VALUES ('".$list_equip."', '".$_POST['status_equip']."', '".$_POST['obs']."','".$_SESSION['id']."', '".$data_hoje."')";
				$resultado_insert = $conn->query($insert_obs);

				//salvando o histórico em manager_data_vigência
				$historico_vigencia = "INSERT INTO manager_data_vigencia (id_equipamento, id_funcionario, id_usuario, data_vigencia)
				VALUES ('".$list_equip."', '".$_POST['id_funcionario']."', '".$_SESSION['id']."','".$data_hoje."')";
				$result_historico = $conn->query($historico_vigencia);

			}//Fim  IF validando se tem usuário


			/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje
			$dataLog = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
							VALUES ('".$_POST['id_funcionario']."',
									'".$list_equip."',
									'".$dataLog."',
									'".$_SESSION["id"]."',
									'4')";
			$result_log = $conn->query($log_query);

		/*_________________________________ FECHANDO O BANCO ______________________________________*/

		 }//fim FOREACH listando equipamentos  
	}else{

		if($_POST['list_fun'] != NULL){//possui funcionario

			//alterando o equipamento
			$update_vigencia ="UPDATE  manager_inventario_equipamento 
						SET filial='".$_POST['filial_equip']."', 
							status='".$_POST['status_equip']."',
							id_funcionario ='".$_POST['list_fun']."',
							termo = '1',
							liberado_rh = '0'
						WHERE id_equipamento = ".$_POST['id_equipamento']."";
			$resultado_update = $conn->query($update_vigencia);

			//alterando funcionário
			$update_funcionario = "UPDATE manager_inventario_funcionario
										SET status = 3
									WHERE
										id_funcionario = ".$_POST['list_fun']."";
			$result_funcionario = $conn->query($update_funcionario);


			//Salvando a observação
			$insert_obs = "INSERT INTO manager_inventario_obs 
								(id_equipamento, 
								usuario, 
								id_status, 
								obs, 
								data_criacao) 
							VALUES 
								('".$_POST['id_equipamento']."',
								'".$_SESSION['id']."',
								'".$_POST['status_equip']."', 
								'".$_POST['obs']."',
								'".$data_hoje."')";
			$resultado_insert = $conn->query($insert_obs);

			//salvando o histórico em manager_data_vigência
			$historico_vigencia = "INSERT INTO manager_data_vigencia (id_equipamento, id_funcionario, id_usuario, data_vigencia)
			VALUES ('".$_POST['id_equipamento']."', '".$_POST['id_funcionario']."', '".$_SESSION['id']."','".$data_hoje."')";
			$result_historico = $conn->query($historico_vigencia);

			/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

			//data de hoje
			$dataLog = date('d/m/Y G:i:s');

			//query para salvar log

			$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
							VALUES ('".$_POST['id_funcionario']."',
									'".$_POST['id_equipamento']."',
									'".$dataLog."',
									'".$_SESSION["id"]."',
									'5')";
			$result_log = $conn->query($log_query);

			/*_________________________________ FECHANDO O BANCO ______________________________________*/



		}else{

			$update_vigencia ="UPDATE  manager_inventario_equipamento 
						SET filial='".$_POST['filial_equip']."', 
							status='".$_POST['status_equip']."', 
							id_funcionario ='0',
							termo = '1',
							liberado_rh = '0'
						WHERE id_equipamento = ".$_POST['id_equipamento']."";
			$resultado_update = $conn->query($update_vigencia);

			//Salvando a observação
			$insert_obs = "INSERT INTO manager_inventario_obs (id_equipamento, usuario, id_status, obs, data_criacao) 
			VALUES ('".$_POST['id_equipamento']."', '".$_SESSION['id']."', '".$_POST['status_equip']."', '".$_POST['obs']."','".$data_hoje."')";
			$resultado_insert = $conn->query($insert_obs);

			//salvando o histórico em manager_data_vigência
			$historico_vigencia = "INSERT INTO manager_data_vigencia (id_equipamento, id_funcionario, id_usuario, data_vigencia)
			VALUES ('".$_POST['id_equipamento']."', '".$_POST['id_funcionario']."', '".$_SESSION['id']."','".$data_hoje."')";
			$result_historico = $conn->query($historico_vigencia);
		}//FIm IF validando usuário		

		/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

		//data de hoje
		$dataLog = date('d/m/Y G:i:s');

		//query para salvar log

		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
						VALUES ('".$_POST['id_equipamento']."',
								'".$dataLog."',
								'".$_SESSION["id"]."',
								'4')";
		$result_log = $conn->query($log_query);

		/*_________________________________ FECHANDO O BANCO ______________________________________*/
		
	}//fim IF verificando se tem mais de 1 equipamento

	/*------------------------------------------------------------------------------------------------------------------------------------------*/
	
	/*SALVANDO O checklist*/
		
	if(!empty($_FILES['checklist']['type'])){
		/*coletando informações do FILE*/ 
		$tipo_file = $_FILES['checklist']['type'];//Pegando qual é a extensão do arquivo
		$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['checklist']['name'];//caminho onde será salvo o FILE
		$caminho_db = "documentos/inventario/".$_FILES['checklist']['name'];//pasta onde está o FILE para salvar no Bando de dados

		/*VALIDAÇÃO DO FILE*/
		$sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

		$result =  $conn->query($sql_file);//aplicando a query
		$row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

		/*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
		if ($row['type'] != NULL) {//se é arquivo valido 

			if (move_uploaded_file($_FILES['checklist']['tmp_name'], $caminho )){//aplicando o salvamento
				echo "Arquivo enviado para = ".$_FILES['checklist']['tmp_name'].$uploadfile;
			}else{
			header("Location: error.php");
				echo "<br>não deu";

			}//se caso não salvar vai mostrar o erro!
		}else{// se o arquivo não é valido vai levar para tela de erro    
			header("Location: error.php");
			exit;
		}

		$insert_bd_file = "INSERT INTO manager_inventario_anexo (id_equipamento, id_funcionario, usuario,  tipo_anexo, nome, caminho, tipo, data_criacao) 
		VALUES ('".$_POST['id_equipamento']."', '".$_POST['id_funcionario']."', '".$_SESSION['id']."', '".$tipo_file."','".$_FILES['checklist']['name']."' ,'".$caminho_db."', '5', '".$dataLog."')";

		
		echo $insert_bd_file;

		//aplicando a query
		$resultado_insert_file = $conn->query($insert_bd_file);
	}//end IF salvando cheklist

}//end IF


//enviando para termo caso tenha funcionário
if($_POST['list_fun'] != NULL){
	header('location: pdf_termo.php?id_funcionario='.$_POST['list_fun'].'');
	exit;
}

/*------------------------------------------------------------------------------------------------------------------------------------------*/

$conn->close();


switch ($_POST['drop']) {
	case 1:
		header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&msn=3');
		break;
	case 2:
		header('location: inventario_equip_edit.php?id_equip='.$_POST['id_equipamento'].'&tipo='.$_POST['tipo_equip'].'&msn=2');
		break;

	default:
		header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&msn=4');
		break;
}

?>