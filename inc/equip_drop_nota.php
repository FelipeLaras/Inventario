<?php
//chamando banco de dados
require_once('../conexao/conexao.php');

/*----------------------------------------------------------------------------------*/

//1º nota windows
if($_POST['programa'] == 1){
    //deletar
    $drop_anexo = "UPDATE manager_sistema_operacional SET deletar = '1' WHERE id_equipamento = ".$_POST['id_equip']."";
    $result_drop = $conn -> query($drop_anexo);
}

//2º nota office
if($_POST['programa'] == 2){
    //deletar
    $drop_anexo = "UPDATE manager_office SET deletar = '1' WHERE id_equipamento = ".$_POST['id_equip']."";
    $result_drop = $conn -> query($drop_anexo);
}

//3º termo 
if($_POST['programa'] == 3){
    //deletar
    $drop_anexo = "UPDATE manager_inventario_anexo SET deletar = '1' WHERE id_anexo = ".$_POST['id_win']."";
    $result_drop = $conn -> query($drop_anexo);

    //altera o estatus do equipamento termo
    $alter_equip = "UPDATE manager_inventario_equipamento SET termo = '1' WHERE id_equipamento = ".$_POST['id_equip']."";
    $resultado_equip = $conn -> query($alter_equip);

    //altera o estatus do equipamento termo
    $alter_funcio = "UPDATE manager_inventario_funcionario SET status = '3' WHERE id_funcionario = ".$_POST['id_fun']."";
    $resultado_funcio = $conn -> query($alter_funcio);
}
/*----------------------------------------------------------------------------------*/
//voltando para a tela

header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&tipo='.$_POST['tipo'].'&msn=1');
/*----------------------------------------------------------------------------------*/

//fechando conexão com o banco de dados
$conn -> close();
?>