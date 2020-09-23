<?php

require_once('../conexao/conexao.php');

foreach ($_POST['equipamento'] as $id_equipamento){
    //atrelando o funcionario no equipamento

    $updateEquipamento = "UPDATE manager_inventario_equipamento SET id_funcionario = ".$_POST['id_funcionario']." WHERE id_equipamento = ".$id_equipamento."";
    $resultEquipamento = $conn -> query($updateEquipamento);

    //alterando status do equipamento
    $updateStatusEquipamento = "UPDATE manager_inventario_equipamento SET status = 1 WHERE id_equipamento = ".$id_equipamento."";
    $resultStatusEquipamento = $conn -> query($updateStatusEquipamento);

}

//alterando o status do funcionário para "faltando termo"
$updateStatusEquipamento = "UPDATE manager_inventario_funcionario SET status = 3 WHERE id_funcionario = ".$_POST['id_funcionario']."";
$resultStatusEquipamento = $conn -> query($updateStatusEquipamento);

//enviando para gerar o termo
header('location: pdf_termo.php?id_funcionario='.$_POST['id_funcionario'].'');

//Finalizando
$conn -> close($conn);

?>