<?php 
//chamando o banco de dados
require_once('../conexao/conexao.php');
//DATA DE HOJE APRA COLOCAR NO CAMPO DATA_CADASTRO
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s');

//alterando o status do equipamento no banco
$update = "UPDATE manager_inventario_equipamento SET status='".$_POST['status_equip']."' WHERE id_equipamento='".$_POST['id_equipamento']."'";
$resultado = $conn->query($update);

//inserindo a observação do equipamento
$insert = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, data_criacao)
			VALUES ('".$_POST['id_equipamento']."', '".$_POST['status_equip']."', '".$_POST['obs']."', '".$date."')";
$resultado_insert = $conn->query($insert);

//voltando para a tela do funcionario
header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'');
?>