<?php
//aplicando para usar variavel em outro arquivo
session_start();
//chamando conexão com o banco
require 'pesquisa_condb.php';
//data de hoje
$date = date('d/m/Y');

if ($_GET['cod'] != NULL) { //excluindo uma informação
	$upt = "UPDATE google SET deleted = 1 WHERE cod_tabela = ".$_GET['cod']."";

	$result = mysqli_query($conn_db, $upt) or die(mysqli_error($conn_db));
	header('location:msn_gdel.php');	

}else{//Inclui o arquivo que faz a conexão ao MySQL		
	
	//SALVANDO PDF
	if(($_FILES['file']['type']) != null){//caso tenha um arquivo
		
		//salvando documento
		$tipo_file = $_FILES['file']['type'];//Pegando qual é a extensão do arquivo
		$nome_db = $_FILES['file']['name'];
		$caminho = "/var/www/html/ti/documentos/google/" . $_FILES['file']['name'];//caminho onde será salvo o FILE
		$caminho_db = "documentos/google/".$_FILES['file']['name'];//pasta onde está o FILE para salvar no Bando de dados

		/*VALIDAÇÃO DO FILE*/
		$sql_file = "SELECT tipo_arquivo FROM google_validacao_arquivo WHERE tipo_arquivo LIKE '".$tipo_file."'";//query de validação 

		$result =  mysqli_query($conn_db, $sql_file);//aplicando a query
		$row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

		/*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
		if ($row['tipo_arquivo'] != NULL) {//se é arquivo valido       
			if (move_uploaded_file($_FILES['file']['tmp_name'], $caminho )){//aplicando o salvamento
				echo "arquivo Enviado!";
			}else{
				echo "Arquivo não foi enviado! ".$caminho." não localizado";//se caso não salvar vai mostrar o erro!
				exit;
			}
		}else{   
			echo "Arquivo Invalido! - Liberado apenas os arquivos com extensão: PDF";// se o arquivo não é valido vai levar para tela de erro 
			exit;
		}

		/*SALVANDO AGORA NO BANCO DE DADOS O DOCUMENTO*/
		$upt = "UPDATE google SET body = '".$_POST['txtArtigo']."', titulo = '".$_POST['titulo']."', caminho_arquivo = '".$caminho_db."'  WHERE cod_tabela = ".$_POST['cod_tabela']."" ;

		($result = mysqli_query($conn_db, $upt)) ?	header('location:msn_google.php') : $error = mysqli_error($conn_db);

	}else{
		$upt = "UPDATE google SET body = '".$_POST['txtArtigo']."', titulo = '".$_POST['titulo']."' WHERE cod_tabela = ".$_POST['cod_tabela']."" ;

		($result = mysqli_query($conn_db, $upt)) ? header('location:msn_google.php') : $error = mysqli_error($conn_db);

	}
}