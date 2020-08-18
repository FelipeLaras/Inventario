<?php
//sessão 
session_start();
//conexão banco de dados
include 'conexao.php';

//data de hoje
$date_hoje = date('Y-m-d');
//buscando a msn / incluindo / excluindo

foreach ($_POST['mensagem'] as $msn) {
    
    /*---------------------BUSCAR A MENSANSAGEM-----------------------------*/

    $query_busca = "SELECT * FROM manager_comparacao_ocs WHERE id = ".$msn."";
    $result_busca = mysqli_query($conn, $query_busca);
    $row_busca = mysqli_fetch_assoc($result_busca);
    
    /*---------------------INCLUIR A MENSANSAGEM-----------------------------*/
    $insert_msn = "INSERT INTO manager_software
                    (patrimonio, 
                    software_atual, 
                    software_anterior, 
                    data_instalacao, 
                    data_last_agente, 
                    alerta_enviado, 
                    usuario, 
                    usuario_data) 
                    VALUES 
                    ('".$row_busca['patrimonio']."', 
                    '".$row_busca['software_atual']."', 
                    '".$row_busca['software_anterior']."', 
                    '".$row_busca['data_instalacao']."', 
                    '".$row_busca['data_last_agente']."', 
                    '".$row_busca['mensagem']."', 
                    '".$_SESSION["id"]."', 
                    '".$date_hoje."');
                    ";
    $result_msn = mysqli_query($conn, $insert_msn) or die(mysqli_error($conn));
    /*---------------------EXCLUIR A MENSANSAGEM-----------------------------*/

    $deletar_busca = "DELETE FROM manager_comparacao_ocs WHERE  id = ".$msn."";
    $result_deletar = mysqli_query($conn, $deletar_busca) or die(mysqli_error($conn));

}
//volto para relatório para avisar que excluimos
header('location: relatorio_tecnicos.php?msn=1');
?>
