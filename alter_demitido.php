<?php
    //chamando banco de dados
    include 'conexao.php';
    /*-------------------------------------------------*/

    //alterando status do funcionario

    $demitido = "UPDATE manager_inventario_funcionario SET status = 8 WHERE id_funcionario = ".$_GET['id_fun']."";
    $result_demitido = mysqli_query($conn, $demitido) or die(mysqli_error($conn));

    /*-------------------------------------------------*/

    //voltando para a tela e infomando que foi alterado para demitido
    header('location: inventario.php?msn=1');

    //fechando conexão com o bando de dados
    mysqli_close($conn);
?>