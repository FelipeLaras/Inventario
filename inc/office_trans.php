<?php
require_once('../conexao/conexao.php');

$updateRemoveOffice = "UPDATE manager_office SET id_equipamento = 0, status = 6 WHERE id = ".$_POST['id_office']."";

echo $updateRemoveOffice;

if(!$conn->query($updateRemoveOffice)){
    printf("Houve um erro na remoção do office, peço que printe essa tela e envie para administrador do sistema: %s\n", $conn->error);
}

header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&tipo='.$_POST['tipo'].'&msn=3');

$conn->close();
?>