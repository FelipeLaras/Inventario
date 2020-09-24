<?php 
session_start(); 
//incluindo o banco de dados
require_once('../conexao/conexao.php');
/*______________________________________________________________________________________________*/
//VALIDAÇÃO EQUIPAMENTO

if ($_POST['modelo_celular0'] != NULL) {

} elseif ($_POST['modelo_tablet0']) {
	

}elseif($_POST['imei_chip0']){
	

}elseif($_POST['modelo_modem']){
		
}else{//esqueceu de selecionar um item!
	header('location: inventario_equip_add.php?error=1');
	exit;
}
/*______________________________________________________________________________________________*/
//DATA DE HOJE APRA COLOCAR NO CAMPO DATA_CADASTRO
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');
/*______________________________________________________________________________________________*/
//adicionando os equipamentos

//celular
$cont_equip = 0;

if ($_POST['modelo_celular0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS


	while ($_POST['modelo_celular'.$cont_equip.''] != NULL) {

		if($_FILES['file_nota_celular'.$cont_equip.''] != NULL){

			$queryNomeFile = "SELECT nome FROM manager_inventario_anexo WHERE nome = '".$_FILES['file_nota_celular'.$cont_equip.'']['name']."'";
			$resultNomeFile = $conn->query($queryNomeFile);
			
			if($nomeFile = $resultNomeFile->fetch_assoc()){
		
				header('location: inventario_equip_add.php?error=2');
		
				exit;
			}
		}

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$insert_equipamento = "INSERT INTO manager_inventario_equipamento 
									(tipo_equipamento,
									usuario, 
									filial, 
									modelo, 
									operadora, 
									numero, 
									situacao, 
									estado,
									planos_voz, 
									planos_dados, 
									imei_chip, 
									data_criacao, 
									data_nota, 
									valor, 
									status) 
								VALUES 
									('1',
									'".$_SESSION['id']."',
									'".$_POST['filial_celular'.$cont_equip.'']."',
									'".$_POST['modelo_celular'.$cont_equip.'']."', 
									'5',
									'---', 
									'".$_POST['situacao_celular'.$cont_equip.'']."',
									'".$_POST['estado_celular'.$cont_equip.'']."',
									'---', 
									'---', 
									'".$_POST['imei_celular'.$cont_equip.'']."',
									'".$date."', 
									'".$_POST['data_nota_celular'.$cont_equip.'']."',
									'".$_POST['valor'.$cont_equip.'']."', 
									'".$_POST['status_celular'.$cont_equip.'']."')
									";
		
		$resultado_equipamento = $conn->query($insert_equipamento);

		if (isset($_POST['acessorio_celular'.$cont_equip.''])) {

			$idAcessorioCelular = $_POST['acessorio_celular'.$cont_equip.''];

			foreach ($idAcessorioCelular as $IdCelular) {
				//montando a query
				$query_acessorios = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ((select max(id_equipamento) from manager_inventario_equipamento),'".$IdCelular."')";
				$resultado_acessrios = $conn->query($query_acessorios);
			}
		}

		//salvo o minha nota fiscal
		
		// SALVANDO OS FILES DA NOTA CELULAR
		if($_FILES['file_nota_celular'.$cont_equip.''] != NULL){
			//salvando o file da nota
			$tipo_file = $_FILES['file_nota_celular'.$cont_equip.'']['type'];//Pegando qual é a extensão do arquivo
			$nome_db = $_FILES['file_nota_celular'.$cont_equip.'']['name'];
			$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['file_nota_celular'.$cont_equip.'']['name'];//caminho onde será salvo o FILE
			$caminho_db = "documentos/inventario/".$_FILES['file_nota_celular'.$cont_equip.'']['name'];//pasta onde está o FILE para salvar no Bando de dados
	
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

/*______________________________________________________________________________________________*/
//talet
$cont_equip = 0;

if ($_POST['modelo_tablet0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS

	if($_FILES['file_nota_tablet'.$cont_equip.''] != NULL){

		$queryNomeFile = "SELECT nome FROM manager_inventario_anexo WHERE nome = '".$_FILES['file_nota_tablet'.$cont_equip.'']['name']."'";
		$resultNomeFile = $conn->query($queryNomeFile);

		if($nomeFile = $resultNomeFile->fetch_assoc()){	
			header('location: inventario_equip_add.php?error=2');	
			exit;
		}
	}

	while ($_POST['modelo_tablet'.$cont_equip.''] != NULL) {

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$insert_equipamento_tablet = "INSERT INTO 
										manager_inventario_equipamento 
										(tipo_equipamento, 
										usuario,
										filial, 
										modelo,
										patrimonio, 
										operadora, 
										situacao,
										estado, 
										imei_chip,  
										data_criacao, 
										data_nota, 
										valor, 
										status) 
									VALUES 
										('2',
										'".$_SESSION['id']."',										
										'".$_POST['filial_tablet'.$cont_equip.'']."',
										'".$_POST['modelo_tablet'.$cont_equip.'']."', 
										'".$_POST['patrimonio_tablet'.$cont_equip.'']."', 
										'5', 
										'".$_POST['situacao_tablet'.$cont_equip.'']."',
										'".$_POST['estado_tablet'.$cont_equip.'']."',
										'".$_POST['imei_tablet'.$cont_equip.'']."',
										'".$date."', 
										'".$_POST['data_nota_tablet'.$cont_equip.'']."',
										'".$_POST['valor_tablet'.$cont_equip.'']."', 
										'".$_POST['status_tablet'.$cont_equip.'']."'
										)";

		$resultado_equipamento_tablet = $conn->query($insert_equipamento_tablet);

		if (isset($_POST['acessorio_tablet'.$cont_equip.''])) {

			$idAcessorioTablet = $_POST['acessorio_tablet'.$cont_equip.''];

			foreach ($idAcessorioTablet as $IdTablet) {
				//montando a query
				$query_acessorios_tablet = "INSERT INTO manager_inventario_acessorios (id_equipamento, tipo_acessorio) VALUES ((select max(id_equipamento) from manager_inventario_equipamento),'".$IdTablet."')";
				$resultado_acessrios_tablet = $conn->query($query_acessorios_tablet);
			}

		}

		// SALVANDO OS FILES DA NOTA TABLET
		if($_FILES['file_nota_tablet'.$cont_equip.''] != NULL){
			//salvando o file da nota
			$tipo_file = $_FILES['file_nota_tablet'.$cont_equip.'']['type'];//Pegando qual é a extensão do arquivo
			$nome_db = $_FILES['file_nota_tablet'.$cont_equip.'']['name'];
			$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['file_nota_tablet'.$cont_equip.'']['name'];//caminho onde será salvo o FILE
			$caminho_db = "documentos/inventario/".$_FILES['file_nota_tablet'.$cont_equip.'']['name'];//pasta onde está o FILE para salvar no Bando de dados
	
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
/*______________________________________________________________________________________________*/
/*SALVANDO CHIP*/
$cont_equip_chip = 0;

if ($_POST['imei_chip0'] != NULL) {//CASO TENHA UM EQUIPAMENTO SEGUIRA PARA SALVA-LOS
	//data de criação apenas informar quando o chip se tornar diferente de virgem

	if ($_POST['status_chip'.$cont_equip_chip.''] == 4) {
		$date_chip = '9999-12-01';
	}else{
		$date_chip = $date;
	}

	while ($_POST['imei_chip'.$cont_equip_chip.''] != NULL) {
		
		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_equipamento_chip = "INSERT INTO manager_inventario_equipamento
										(tipo_equipamento, 
										usuario,
										filial, 
										modelo, 
										operadora, 
										numero, 
										planos_voz, 
										planos_dados, 
										imei_chip, 
										data_vigencia, 
										data_criacao, 
										valor, 
										status) 
									VALUES ('3',									
									'".$_SESSION['id']."',
									'".$_POST['filial_chip'.$cont_equip_chip.'']."', 
									'---', 
									'".$_POST['operadora_chip'.$cont_equip_chip.'']."',
									'".$_POST['numero_chip'.$cont_equip_chip.'']."', 
									'".$_POST['voz'.$cont_equip_chip.'']."' , 
									'".$_POST['dados'.$cont_equip_chip.'']."', 
									'".$_POST['imei_chip'.$cont_equip_chip.'']."', 
									'9999-12-01', 
									'".$date_chip."', 
									'---', 
									'".$_POST['status_chip'.$cont_equip_chip.'']."')";

		$resultado_equipamento_chip = $conn->query($query_equipamento_chip);
	//SOMANDO MAIS 1 PARA PEGAR OS PROXIMOS APARELHOS
		$cont_equip_chip++;
	}
}
/*______________________________________________________________________________________________*/
/*SALVANDO O MODEM*/
if ($_POST['modelo_modem'] != NULL) {		

		//SALVANDO O EQUIPAMENTO NO BANCO DE DADOS
		$query_modem = "INSERT INTO manager_inventario_equipamento 
							(tipo_equipamento,
							usuario,
							filial, 
							modelo, 
							operadora,  
							imei_chip, 
							data_criacao) 
						VALUES 
							('4',
							'".$_SESSION['id']."',
							'".$_POST['filial_modem']."',
							'".$_POST['modelo_modem']."',
							'5',
							'".$_POST['imei_modem']."', 
							'".$date."')";

		$resultado_modem = $conn->query($query_modem);
	}


$conn->close();
header('location: msn_equipamento.php?msn=3');
?>