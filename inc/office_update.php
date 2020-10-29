<?php

require_once('../conexao/conexao.php');

//coletando informações sobre o equipamento

$queryEquipamento = "SELECT id_funcionario, tipo_equipamento FROM manager_inventario_equipamento where id_equipamento = '".$_POST['id_equipamento']."'";
$resultEquipamento = $conn -> query($queryEquipamento);

if($equipamento = $resultEquipamento->fetch_assoc()){
    //vinculando o office ao equipamento
    $updateOffice = "UPDATE manager_office SET id_equipamento = '".$_POST['id_equipamento']."', status = '1' WHERE (id = '".$_POST['id_office']."')";

    if(!$conn->query($updateOffice)){
        echo "não foi possivel vincular o office ao equipamento. Fale com o administrador<br />";
        printf("Mensagem do erro: %s\n", $conn->error);

        exit;
    }

    header('location: equip_edit.php?id_equip='.$_POST['id_equipamento'].'&id_fun='.$equipamento['id_funcionario'].'&tipo='.$equipamento['tipo_equipamento'].'&msn=2');

}else{
    echo "não foi possivel vincular o office ao equipamento. Fale com o administrador<br />";
    printf("Mensagem do erro: %s\n", $conn->error);

    exit;
}

$conn->close();

?>