<?php
session_start(); 
//CONEXÂO BANCO DE DADOS
require_once('../conexao/conexao.php');

/*VALIDANDO USUARIO CADASTRADO E SE JÁ EXISTER IRÁ PREENCHER AUTOMATICAMENTE OS CAMPOS DO FORMULARIO*/
	if ($_POST['nome_funcionario'] == NULL) {
		/*VERIFICANDO SE O USUÁRIO JA EXISTE NO BD*/
		$query_funcionario = "SELECT id_funcionario, deletar, cpf from manager_inventario_funcionario where cpf = '".$_POST['gols1']."'";//fazendo a query para buscar o funcionario

		$resultado_funcionario = $conn->query($query_funcionario);//aplicando a query no bd
		
		if ($row_funcionario = mysqli_fetch_assoc($resultado_funcionario)) {

			$_SESSION['id_funcionario'] = $row_funcionario['id_funcionario'];//salvando o nome do funcionario em uma sessão para ser usado no formulario

			if ($row_funcionario['deletar'] == 1) {// se o funcionario estiver desativado no sistema
				header('location: msn_inativo.php?id='.$row_funcionario['id_funcionario'].'');//voltando para o formulario com as sessões já preenchidas
			}elseif ($_POST['id_equip'] != NULL) {//verificando se ele quer levar um equipamento junto
				header('location: new_equipamento.php?id_func='.$row_funcionario['id_funcionario'].'&id_equip='.$_POST['id_equip'].'');
			}else{
			header('location: inventario_edit.php?id='.$row_funcionario['id_funcionario'].'');//voltando para o formulario com as sessões já preenchidas
			}			
			$conn->close();//fechando a conexão com o bd
			exit;

		}else {
			$_SESSION['cpf_vazia'] = $_POST['gols1'];//pegando a informação que o usuario colocou e salvando em uma sessão

			if ($_POST['id_equip'] != NULL) {//verificando se ele quer levar um equipamento junto
				header('location: inventario_add.php?id_equip='.$_POST['id_equip'].'');
			}else{
			header('location: inventario_add.php');//voltando para o formulario com as sessões já preenchidas
			}
			exit;
		}	
	}
/*FIM DA VALIDAÇÃO DO USUARIO*/


/*VALIDAÇÃO EQUIPAMENTO*/

	if ($_POST['modelo_celular0'] != NULL) {

	} elseif ($_POST['modelo_tablet0']) {
		

	}elseif($_POST['numero_chip0']){
		

	}elseif($_POST['modelo_modem']){
			
	}else{//esqueceu de selecionar um item!
		header('location: inventario_add.php?error=1');
		exit;
	}

	date_default_timezone_set('America/Sao_Paulo');
	$date_hoje = date('d/m/Y');

	//SALVANDO O USUARIO NO BANDO DE DADOS
	$insert_funcionario = "INSERT INTO manager_inventario_funcionario 
								(cpf, 
								nome, 
								funcao, 
								departamento, 
								empresa, 
								data_cadastro,
								usuario, 
								status) 
							VALUES 
								('".$_POST['gols1']."', 
								'".$_POST['nome_funcionario']."', 
								'".$_POST['funcao_funcionario']."', 
								'".$_POST['depart_funcionario']."', 
								'".$_POST['empresa_funcionario']."', 
								'".$date_hoje."', 
								'".$_SESSION['id']."',
								'".$_POST['status_funcionario']."')";

	$resultado_insert_funcionario = $conn->query($insert_funcionario);
	/*FIM DA INSERÇÃO DO NOVO USUARIO*/

	/*---------------------SALVANDO OBSERVAÇÃO---------------------*/

	if($_POST['obs_termo'] != NULL){
		$obs_insert = "INSERT INTO manager_inventario_obs 
							(id_funcionario, 
							usuario, 
							obs) 
						VALUES 
							((SELECT max(id_funcionario) FROM manager_inventario_funcionario),
							'".$_SESSION['id']."', 
							'".$_POST['obs_termo']."')";
		$result_obs = $conn->query($obs_insert);
	}

	/*---------------------FIM SALVANDO OBSERVAÇÃO---------------------*/

	/*INSERINDO EQUIPAMENTO*/
	$cont_equip = 0;
	/*SALVANDO CELULAR*/

if ($_POST['modelo_celular'.$cont_equip.''] != NULL) { //CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	if ($_POST['id_equip'] != NULL) {

		//altualizando o equipamento
		$update_cel = "UPDATE 
							manager_inventario_equipamento 
						SET
							modelo = '".$_POST['modelo_celular'.$cont_equip.'']."',
							patrimonio = '".$_POST['patrimonio'.$cont_equip.'']."',
							filial = '".$_POST['filial_celular'.$cont_equip.'']."',
							situacao = '".$_POST['situacao_celular'.$cont_equip.'']."',
							estado = '".$_POST['status_celular'.$cont_equip.'']."',
							imei_chip = '".$_POST['imei_celular'.$cont_equip.'']."',
							valor = '".$_POST['valor'.$cont_equip.'']."',
							data_nota = '".$_POST['data_nota_celular'.$cont_equip.'']."',
							id_funcionario = (SELECT max(id_funcionario) FROM manager_inventario_funcionario), 
							data_criacao = '".$date_hoje."',
							status = 1 
						WHERE 
							id_equipamento = ".$_POST['id_equip']."";

		$resultado_update_cel = $conn->query($update_cel);
		$_SESSION['celular_id'.$cont_equip.''] = $_POST['id_equip'];

		//atualizando os acessórios

		if (isset($_POST['acessorio_celular'.$cont_equip.''])) {

			$idAcessorioCelular = $_POST['acessorio_celular0'];

			//deletando os acessórios quando for diferente do que veio

			$del_acessorios = "DELETE FROM manager_inventario_acessorios WHERE tipo_acessorio NOT IN ('";

			foreach ($idAcessorioCelular as $IdCelular) {

				//deletando os acessórios

				$del_acessorios .= $IdCelular."','";

				//Primeiro vemos se ja temos esse acessorio
				$tem_acessorio = "SELECT * FROM manager_inventario_acessorios WHERE tipo_acessorio = ".$IdCelular."";
				$result_tem = $conn->query($tem_acessorio);

				if($row_tem = mysqli_fetch_assoc($result_tem)){//encontrou o item
					//já possui o equipamento selecionado então não faz nada
				}else{
					//não possui o acessorios, então vamos salva-lo
					$inert_ace = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUE ('".$_POST['id_equip']."','".$IdCelular."')";
					$rest_ace = $conn->query($inert_ace);

				}//fim IF salvando acessórios que não possui				
			}//fim FOREACH pegando os acessórios

			$del_acessorios .= "')";

			$result_deleted = $conn->query($del_acessorios);

		}//fim IF salvando acessório
		
	}else{

		while (isset($_POST['modelo_celular'.$cont_equip.''])) {
			
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$insert_equipamento = "INSERT INTO manager_inventario_equipamento 
										(id_funcionario,
										usuario, 
										tipo_equipamento,
										filial,
										modelo,
										patrimonio, 
										operadora,
										situacao,
										estado, 
										imei_chip,
										data_criacao, 
										data_nota, 
										valor) 
									VALUES 
										((SELECT max(id_funcionario) FROM manager_inventario_funcionario),
										'".$_SESSION['id']."', 
										'1',
										'".$_POST['filial_celular'.$cont_equip.'']."', 
										'".$_POST['modelo_celular'.$cont_equip.'']."', 
										'".$_POST['patrimonio'.$cont_equip.'']."',
										'5',
										'".$_POST['situacao_celular'.$cont_equip.'']."',
										'".$_POST['status_celular'.$cont_equip.'']."',
										'".$_POST['imei_celular'.$cont_equip.'']."',
										'".$date_hoje."',
										'".$_POST['data_nota_celular'.$cont_equip.'']."', 
										'R$ ".$_POST['valor'.$cont_equip.'']."')";

			$resultado_equipamento = $conn->query($insert_equipamento);
			
			//salvando os acessórios
			if (isset($_POST['acessorio_celular'.$cont_equip.''])) {

				$idAcessorioCelular = $_POST['acessorio_celular'.$cont_equip.''];

				foreach ($idAcessorioCelular as $IdCelular) {
					//montando a query
					$query_acessorios = "INSERT INTO manager_inventario_acessorios 
											(id_equipamento, 
											tipo_acessorio) 
										VALUES 
											((select max(id_equipamento) FROM manager_inventario_equipamento),
											'".$IdCelular."')";
					$resultado_acessrios = $conn->query($query_acessorios);
				}

			}

			// SALVANDO OS FILES DA NOTA CELULAR
			if($_FILES['file_nota_celular'.$cont_equip.''] != NULL){
				//salvando o file da nota
				$tipo_file = $_FILES['file_nota_celular'.$cont_equip.'']['type'];//Pegando qual é a extensão do arquivo
				$nome_db = $_FILES['file_nota_celular'.$cont_equip.'']['name'];
				$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['file_nota_celular'.$cont_equip.'']['name'];//caminho onde será salvo o FILE
				$caminho_db = "../documentos/inventario/".$_FILES['file_nota_celular'.$cont_equip.'']['name'];//pasta onde está o FILE para salvar no Bando de dados
		
				/*VALIDAÇÃO DO FILE*/
				$sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
		
				$result =  $conn->query($sql_file);//aplicando a query
				$row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
		
				/*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
				if($tipo_file != NULL){
					if ($row['type'] != NULL) {//se é arquivo valido       
						if (move_uploaded_file($_FILES['file_nota_celular'.$cont_equip.'']['tmp_name'], $caminho )){//aplicando o salvamento
							//echo "Arquivo enviado para = ".$_FILES['file_nota_celular'.$cont_equip.'']['tmp_name'].$uploadfile;
						}else{
						echo "Arquivo não foi enviado!";
						}//se caso não salvar vai mostrar o erro!
					}else{// se o arquivo não é valido vai levar para tela de erro    
						echo "Arquivo Invalido!";
						exit;
					}//end IF validação
				}//end IF anexo cheio

				//salvando a nota no banco de dados
				$bd_nota = "INSERT INTO manager_inventario_anexo
								(id_equipamento,
								usuario, 
								tipo_anexo, 
								caminho, 
								nome, 
								tipo, 
								data_criacao)
							VALUES
								((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
								'".$_SESSION['id']."',
								'".$tipo_file."',
								'".$caminho_db."',
								'".$nome_db."',
								'4',
								'".$_POST['data_nota_celular'.$cont_equip.'']."')";
				$resultado_file_nota = $conn->query($bd_nota);
			}//FIM IF salvando file nota

			//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
			$cont_equip++;
		}
	}		
}	


/*INSERINDO EQUIPAMENTO*/
$cont_equip = 0;
/*SALVANDO TABLET*/

if ($_POST['modelo_tablet'.$cont_equip.''] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	if ($_POST['id_equip'] != NULL) {

		$update_tablet = "UPDATE 
							manager_inventario_equipamento 
						  SET 
						  	modelo = '".$_POST['modelo_tablet'.$cont_equip.'']."',
							patrimonio = '".$_POST['patrimonio_tablet'.$cont_equip.'']."',
							filial = '".$_POST['filial_tablet'.$cont_equip.'']."', 
							situacao = '".$_POST['situacao_tablet'.$cont_equip.'']."',
							estado = '".$_POST['status_tablet'.$cont_equip.'']."',
							imei_chip = '".$_POST['imei_tablet'.$cont_equip.'']."',
							valor = '".$_POST['valor_tablet'.$cont_equip.'']."',
							data_nota = '".$_POST['data_nota_tablet'.$cont_equip.'']."',
						  	id_funcionario = '".$_POST['id_equip']."', 
						  	data_criacao = '".$date_hoje."', 
						  	status = 1 
						  WHERE 
						  	id_equipamento = ".$_POST['id_equip']."";

		$resultado_update_tablet = $conn->query($update_tablet);
		$_SESSION['tablet_id'.$cont_equip.''] = $_POST['id_equip'];

		//atualizando os acessórios

		if (isset($_POST['modelo_tablet'.$cont_equip.''])) {

			$idAcessorioCelular = $_POST['modelo_tablet'.$cont_equip.''];

			//deletando os acessórios quando for diferente do que veio

			$del_acessorios = "DELETE FROM manager_inventario_acessorios WHERE tipo_acessorio NOT IN ('";

			foreach ($idAcessorioCelular as $IdCelular) {

				//deletando os acessórios

				$del_acessorios .= $IdCelular."','";

				//Primeiro vemos se ja temos esse acessorio
				$tem_acessorio = "SELECT * FROM manager_inventario_acessorios WHERE tipo_acessorio = ".$IdCelular."";
				$result_tem = $conn->query($tem_acessorio);

				if($row_tem = mysqli_fetch_assoc($result_tem)){//encontrou o item
					//já possui o equipamento selecionado então não faz nada
				}else{
					//não possui o acessorios, então vamos salva-lo
					$inert_ace = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUE ('".$_POST['id_equip']."','".$IdCelular."')";
					$rest_ace = $conn->query($inert_ace);

				}//fim IF salvando acessórios que não possui				
			}//fim FOREACH pegando os acessórios

			$del_acessorios .= "')";

			$result_deleted = $conn->query($del_acessorios);

		}//fim IF salvando acessório

	}else{

		while (isset($_POST['modelo_tablet'.$cont_equip.''])) {
			
			//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
			$insert_equipamento_tablet = "INSERT INTO manager_inventario_equipamento 
											(id_funcionario,
											usuario, 
											tipo_equipamento,
											filial,
											modelo,
											patrimonio, 
											operadora,
											situacao,
											estado,  
											imei_chip, 
											data_criacao, 
											data_nota, 
											valor) 
										VALUES 
										((SELECT max(id_funcionario) FROM manager_inventario_funcionario),
										'".$_SESSION['id']."', 
										'2',
										'".$_POST['filial_tablet'.$cont_equip.'']."', 
										'".$_POST['modelo_tablet'.$cont_equip.'']."',
										'".$_POST['patrimonio_tablet'.$cont_equip.'']."', 
										'5',
										'".$_POST['situacao_tablet'.$cont_equip.'']."',
										'".$_POST['status_tablet'.$cont_equip.'']."',
										'".$_POST['imei_tablet'.$cont_equip.'']."', 
										'".$date_hoje."',
										'".$_POST['data_nota_tablet'.$cont_equip.'']."', 
										'R$ ".$_POST['valor_tablet'.$cont_equip.'']."'
										)";

			$resultado_equipamento_tablet = $conn->query($insert_equipamento_tablet);
			

			if (isset($_POST['acessorio_tablet'.$cont_equip.''])) {

				$idAcessorioTablet = $_POST['acessorio_tablet'.$cont_equip.''];

				foreach ($idAcessorioTablet as $IdTablet) {
					//montando a query
					$query_acessorios_tablet = "INSERT INTO manager_inventario_acessorios 
													(id_equipamento, 
													tipo_acessorio) 
												VALUES 
													((select max(id_equipamento) 
												FROM
													manager_inventario_equipamento),'".$IdTablet."')";
					$resultado_acessrios_tablet = $conn->query($query_acessorios_tablet);
				}

			}

			// SALVANDO OS FILES DA NOTA TABLET
			if($_FILES['file_nota_tablet'.$cont_equip.''] != NULL){
				//salvando o file da nota
				$tipo_file = $_FILES['file_nota_tablet'.$cont_equip.'']['type'];//Pegando qual é a extensão do arquivo
				$nome_db = $_FILES['file_nota_tablet'.$cont_equip.'']['name'];
				$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['file_nota_tablet'.$cont_equip.'']['name'];//caminho onde será salvo o FILE
				$caminho_db = "../documentos/inventario/".$_FILES['file_nota_tablet'.$cont_equip.'']['name'];//pasta onde está o FILE para salvar no Bando de dados
		
				/*VALIDAÇÃO DO FILE*/
				$sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
		
				$result =  $conn->query($sql_file);//aplicando a query
				$row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
		
				/*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
				if($tipo_file != NULL){
					if ($row['type'] != NULL) {//se é arquivo valido       
						if (move_uploaded_file($_FILES['file_nota_tablet'.$cont_equip.'']['tmp_name'], $caminho )){//aplicando o salvamento
							//echo "Arquivo enviado para = ".$_FILES['file_nota_tablet'.$cont_equip.'']['tmp_name'].$uploadfile;
						}else{
						echo "Arquivo não foi enviado!";
						}//se caso não salvar vai mostrar o erro!
					}else{// se o arquivo não é valido vai levar para tela de erro    
						echo "Arquivo Invalido!";
						exit;
					}//end IF validação
				}//end IF anexo cheio

				//salvando a nota no banco de dados
				$bd_nota = "INSERT INTO manager_inventario_anexo
								(id_equipamento,
								usuario, 
								tipo_anexo, 
								caminho, 
								nome, 
								tipo, 
								data_criacao)
							VALUES
								((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
								'".$_SESSION['id']."',
								'".$tipo_file."',
								'".$caminho_db."',
								'".$nome_db."',
								'4',
								'".$_POST['data_nota_tablet'.$cont_equip.'']."')";
				$resultado_file_nota = $conn->query($bd_nota);
			}//FIM IF salvando file nota

			//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
			$cont_equip++;
		}
	}		
}	

/*SALVANDO CHIP*/
$cont_equip_chip=0;

if ($_POST['numero_chip0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

		if ($_POST['id_equip'] != NULL) {

		$update = "UPDATE 
						manager_inventario_equipamento 
					SET 
						id_funcionario = (SELECT max(id_funcionario) FROM manager_inventario_funcionario), 
						data_criacao = '".$date_hoje."', 
						status = 1 
					WHERE 
						id_equipamento = ".$_POST['id_equip']."";

		$resultado_update = $conn->query($update);
		$_SESSION['chip_id'.$cont_equip_chip.''] = $_POST['id_equip'];

	}else{

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_equipamento_chip = "INSERT INTO manager_inventario_equipamento
										(id_funcionario,
										usuario,
										tipo_equipamento, 
										filial,
										operadora, 
										numero, 
										planos_voz,
										planos_dados, 
										imei_chip, 
										data_criacao) 
									VALUES 
										((SELECT max(id_funcionario) FROM manager_inventario_funcionario),
										'".$_SESSION['id']."', 
										'3',
										".$_POST['empresa_funcionario'].",
										'".$_POST['operadora_chip'.$cont_equip_chip.'']."',
										'".$_POST['numero_chip'.$cont_equip_chip.'']."', 
										'".$_POST['voz'.$cont_equip_chip.'']."' , 
										'".$_POST['dados'.$cont_equip_chip.'']."', 
										'".$_POST['imei_chip'.$cont_equip_chip.'']."',
										'".$date_hoje."')";
		$resultado_equipamento_chip = $conn->query($query_equipamento_chip);
		//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
		$cont_equip_chip++;
	}
}

/*SALVANDO O MODEM*/
if ($_POST['modelo_modem'] != NULL) {		
		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_modem = "INSERT INTO manager_inventario_equipamento 
							(id_funcionario,
							usuario, 
							tipo_equipamento,
							filial, 
							modelo, 
							operadora, 
							numero,  
							imei_chip,
							data_criacao) 
						VALUES 
							((SELECT max(id_funcionario) FROM manager_inventario_funcionario),
							'".$_SESSION['id']."', 
							'4',
							'".$_POST['empresa_funcionario']."', 
							'".$_POST['modelo_modem']."', 
							'".$_POST['operadora_modem']."',
							'".$_POST['numero_modem']."',
							'".$_POST['imei_modem']."', 
							 '".$date_hoje."')";

		$resultado_modem = $conn->query($query_modem);
		//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
}
/*ACABOU A PUTARIA UFA!!!*/

/*Pegando a ultima id para enviar via GET*/

$pegando_id = "SELECT max(id_funcionario) AS id_funcionario FROM manager_inventario_funcionario";
$re_id = $conn->query($pegando_id);
$row_id = mysqli_fetch_assoc($re_id);

$conn->close();


if ($_POST['id_equip'] != NULL) {
	if($_POST['id_funcionario'] != NULL){		
		header('location: pdf_new_termo.php?id_fun='.$_POST['id_funcionario'].'');
	}else{
		header('location: pdf_new_termo.php?id_fun='.$row_id['id_funcionario'].'');
	}	
}else{
	header('location: pdf_termo.php?id_funcionario='.$row_id['id_funcionario'].'');
}
?>