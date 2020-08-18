<?php
require 'conexao.php';

    foreach ($_POST['equipamento'] as $id_equipamento){
        //atrelando o funcionario no equipamento

        $updateEquipamento = "UPDATE manager_inventario_equipamento SET id_funcionario = ".$_POST['id_funcionario']." WHERE id_equipamento = ".$id_equipamento."";
        $resultEquipamento = mysqli_query($conn, $updateEquipamento) or die(mysqli_error($conn));

        //alterando status do equipamento
        $updateStatusEquipamento = "UPDATE manager_inventario_equipamento SET status = 1 WHERE id_equipamento = ".$id_equipamento."";
        $resultStatusEquipamento = mysqli_query($conn, $updateStatusEquipamento) or die(mysqli_error($conn));

    }

    //alterando o status do funcionário para "faltando termo"
    $updateStatusEquipamento = "UPDATE manager_inventario_funcionario SET status = 3 WHERE id_funcionario = ".$_POST['id_funcionario']."";
    $resultStatusEquipamento = mysqli_query($conn, $updateStatusEquipamento) or die(mysqli_error($conn));

    //enviando para gerar o termo
    header('location: pdf_termo.php?id_funcionario='.$_POST['id_funcionario'].'');

//Finalizando

mysqli_close($conn);
?>