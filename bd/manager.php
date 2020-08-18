<?php 
//chamando a conexão com o banco
require ('../conexao.php');

/*FELIPE APARTI DAQUI*/
//Tabela dos usuários
$query_profile = 'CREATE TABLE manager_profile(
			  id_profile INT NOT NULL AUTO_INCREMENT,
			  profile_name VARCHAR(45) NOT NULL,
			  profile_mail VARCHAR(50) NOT NULL,
			  profile_password VARCHAR(45) NOT NULL,
			  profile_type INT NULL,
			  profile_deleted INT NULL DEFAULT 0,
			  PRIMARY KEY (id_profile))';
$result_profile = mysqli_query($conn, $query_profile) or die (mysqli_error($conn));

//Criando usuários padrões
//Usuário Administrador
$query_add_admin = 'INSERT INTO manager_profile(profile_name, profile_mail, profile_password, profile_type) VALUES("Administrador", "administrador", "d3a9a6115e4332e9e8b0fc45754ccb50",0)';
$result_add_adm = mysqli_query($conn, $query_add_admin) or die (mysqli_error($conn));
//Usuário padrão TESTE
$query_add_user = 'INSERT INTO manager_profile(profile_name, profile_mail, profile_password, profile_type) VALUES("Padrão", "usuario", "d3a9a6115e4332e9e8b0fc45754ccb50",1)';
$result_add_user = mysqli_query($conn, $query_add_user) or die (mysqli_error($conn));
//Usuário tecnico TESTE
$query_add_tec = 'INSERT INTO manager_profile(profile_name, profile_mail, profile_password, profile_type) VALUES("Tecnico", "tecnico", "d3a9a6115e4332e9e8b0fc45754ccb50",2)';
$result_add_tec = mysqli_query($conn, $query_add_tec) or die (mysqli_error($conn));

//Tabela dos perfis
$query_type_profile = 'CREATE TABLE manager_profile_type(
						  id_type INT NOT NULL AUTO_INCREMENT,
						  type_profile INT NOT NULL,
						  type_name VARCHAR(45) NOT NULL,
						  PRIMARY KEY (id_type))';

$result_type_profile = mysqli_query($conn, $query_type_profile) or die (mysqli_error($conn));

//criando o perfil administrador
$query_add_type_adm ='INSERT INTO manager_profile_type (type_profile, type_name) VALUES (0, "Administrador")';
$result_add_type_adm = mysqli_query($conn, $query_add_type_adm) or die (mysqli_error($conn));
//criando o perfil Usuário
$query_add_type_use ='INSERT INTO manager_profile_type (type_profile, type_name) VALUES (1, "Usuário")';
$result_add_type_use = mysqli_query($conn, $query_add_type_use) or die (mysqli_error($conn));
//criando o perfil Tecnico
$query_add_type_tec ='INSERT INTO manager_profile_type (type_profile, type_name) VALUES (2, "Técnico")';
$result_add_type_tec = mysqli_query($conn, $query_add_type_tec) or die (mysqli_error($conn));
//Contratos
$query_contracts = "CREATE TABLE `manager`.`manager_contracts` (
					  `id` INT NOT NULL,
					  `cnpj` BIGINT(20) NOT NULL,
					  `name` VARCHAR(50) NOT NULL,
					  `number` BIGINT(20) NOT NULL,
					  `type` VARCHAR(45) NOT NULL,
					  `type_collection` VARCHAR(45) NOT NULL,
					  `cnpj_branch` VARCHAR(45) NOT NULL,
					  `department` VARCHAR(45) NOT NULL,
					  `date_start` DATE NOT NULL,
					  `contracts_responsible` VARCHAR(45) NOT NULL,
					  `mail_responsible` VARCHAR(45) NOT NULL,
					  `description` VARCHAR(100) NULL,
					  `contracts_file` VARCHAR(45) NULL,
					  `contracts_son` INT(10) NULL,
					  `deleted` INT(10) NOT NULL DEFAULT 0,
					  PRIMARY KEY (`id`))";
$result_contracts = mysqli_query($conn, $query_contracts) or die (mysqli_error($conn));
//Contratos Filhos
$query_contracts_son = "CREATE TABLE `manager`.`manager_contracts_son` (
					  `id` INT NOT NULL AUTO_INCREMENT,
					  `cnpj` BIGINT NULL,
					  `value` INT(10) NULL,
					  `data_due` DATE NOT NULL,
					  `temp_lack` INT(10) NOT NULL,
					  `son_file` VARCHAR(45) NULL,
					  `contracts_father` INT(10) NOT NULL,
					  `deleted` INT(10) NOT NULL DEFAULT 0,
					  PRIMARY KEY (`id`))";
$result_contracts_son = mysqli_query($conn, $query_contracts_son) or die (mysqli_error($conn));
//Arquivos
$query_contracts_file = "CREATE TABLE `manager`.`manager_contracts_file` (
						  `id` INT NOT NULL AUTO_INCREMENT,
						  `name` VARCHAR(45) NOT NULL,
						  `contracts_father` INT(10) NOT NULL,
						  `contracts_son` INT(10) NOT NULL,
						  `type` VARCHAR(45) NOT NULL,
						  `file_way` VARCHAR(45) NOT NULL,
						  `deleted` INT(10) NOT NULL DEFAULT 0,
						  PRIMARY KEY (`id`))";
$result_contracts_file = mysqli_query($conn, $query_contracts_file) or die (mysqli_error($conn));

//Tipo de arquivos validos
$query_file_valid = "CREATE TABLE `manager`.`manager_file_type` (
					  `id_file` INT NOT NULL AUTO_INCREMENT,
					  `type` VARCHAR(100) NOT NULL,
					  `nome` VARCHAR(10) NOT NULL,
					  PRIMARY KEY (`id_file`));";
$result_file_valid = mysqli_query($conn, $query_file_valid) or die (mysqli_error($conn));
//Arquivos WORD
$query_files_word = "INSERT INTO `manager`.`manager_file_type` (`type`, `nome`) VALUES ('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'WORD')";
$result_files_word = mysqli_query($conn, $query_files_word) or die (mysqli_error($conn));
//Arquivos PDF
$query_files_pdf = "INSERT INTO `manager`.`manager_file_type` (`type`, `nome`) VALUES ('application/pdf', 'PDF')";
$result_files_pdf = mysqli_query($conn, $query_files_pdf) or die (mysqli_error($conn));


/*FELIPE FOI ATÉ AQUI*/
/*BRUNO APARTIR DAQUI :-)*/
//fechando a conexão
mysqli_close($conn);
?>