<?php
//chamando o banco de dados
include 'conexao.php';

/*---------------------------------------------------------*/
//data de hoje

$data_hoje = date('Y-m-d');
/*---------------------------------------------------------*/


//1º removendo usuário e alterando o status para disponivel = 6

if($_GET['alter'] == 1){
    //removendo o usuário e alterando o status
    $usuario = "UPDATE manager_inventario_equipamento  SET data_vigencia = '".$data_hoje."', id_funcionario = '0', status = '6' WHERE id_equipamento = ".$_GET['id_equip']."";

    $remover = mysqli_query($conn, $usuario) or die(mysqli_error($conn));
    //voltando para a tela com a mensagem da data vigencia aplicado com sucesso!
    header('location: scan_disponivel.php?msn=1');
}

//2º condenando equipamento e alterando status para condenado = 11

if($_GET['del'] == 1){
    $usuario = "UPDATE manager_inventario_equipamento  SET status = 11 WHERE id_equipamento = ".$_GET['id_equip']."";
    $remover = mysqli_query($conn, $usuario) or die(mysqli_error($conn));

    //voltando para a tela informando que foi condenado com sucesso!
    header('location: scan_disponivel.php?msn=2');
}

/*---------------------------------------------------------*/
//4º Iremos vincular agora um equipamento ao novo funcionário

if($_POST['use'] == 1){
    $usuario = "UPDATE manager_inventario_equipamento  SET 
        id_funcionario = '".$_POST['id_fun']."',
        status = '1'
        WHERE id_equipamento = ".$_POST['id_equip']."";
    $remover = mysqli_query($conn, $usuario) or die(mysqli_error($conn));

    //voltando para a tela informando que foi condenado com sucesso!
    header('location: scan_disponivel.php?msn=3');
}

/*---------------------------------------------------------*/
//5º agora iremos fechar a coneção com o banco de dados
mysqli_close($conn);
?>