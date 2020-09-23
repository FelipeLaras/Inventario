<?php
    //chamando banco de dados
    require_once('../conexao/conexao.php');
    /*-------------------------------------------------*/

    //alterando status do funcionario

    $demitido = "UPDATE manager_inventario_funcionario SET status = 8 WHERE id_funcionario = ".$_GET['id_fun']."";
    $result_demitido = $conn -> query($demitido);

    /*-------------------------------------------------*/

    //voltando para a tela e infomando que foi alterado para demitido
    header('location: inventario.php?msn=1');

    //fechando conexão com o bando de dados
    $conn -> close();
?>