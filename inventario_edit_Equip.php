<?php 
//chamando o banco de dados
include 'conexao.php';

//DATA DE HOJE APRA COLOCAR NO CAMPO DATA_CADASTRO
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s');

//alterando o status do equipamento no banco
$update = "UPDATE manager_inventario_equipamento SET status='".$_POST['status_equip']."' WHERE id_equipamento='".$_POST['id_equipamento']."'";
$resultado = mysqli_query($conn, $update) or die(mysqli_error($conn));

//inserindo a observação do equipamento
$insert = "INSERT INTO manager_inventario_obs (id_equipamento, id_status, obs, data_criacao)
			VALUES ('".$_POST['id_equipamento']."', '".$_POST['status_equip']."', '".$_POST['obs']."', '".$date."')";
$resultado_insert = mysqli_query($conn, $insert) or die(mysqli_error($conn));

//voltando para a tela do funcionario
header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'');
?>