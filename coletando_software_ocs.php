<?php
//chamando a base do OCS
include 'conexao_ocs.php';

//chamando a base do manager
include 'conexao.php';

//variaveis globais

$data_zerada = '0000-00-00 00:00:00';

//montando a coleta dos dados

$query_ocs = "SELECT 
    AI.tag AS patrimonio,
    SO.name AS software,
    SO.INSTALLDATE AS data_instalacao,
    H.lastdate AS data_agente
FROM
    softwares SO
        LEFT JOIN
    accountinfo AI ON SO.HARDWARE_ID = AI.HARDWARE_ID
        LEFT JOIN
    hardware H ON SO.HARDWARE_ID = H.ID";
$resultado_ocs = mysqli_query($conn_ocs, $query_ocs);

/*----------------------------excluindo os dados da tabela manager_ocs_equip-------------------------------------*/

$drop_table = "DROP TABLE ocs_software";
$resultado_drop = mysqli_query($conn, $drop_table) or die(mysqli_error($conn));

/*----------------------------criando os dados da tabela manager_ocs_equip----------------------------------------*/

$create_table = "CREATE TABLE `manager`.`ocs_software` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `patrimonio` VARCHAR(255)  NULL,
    `software` VARCHAR(255) NULL,
    `data_instalacao` DATETIME NULL,
    `data_last_agente` DATETIME NULL,
    PRIMARY KEY (`id`));";
$resultado_create = mysqli_query($conn, $create_table) or die(mysqli_error($conn));

/*----------------------------inserindo os dados na base manager--------------------------------------------------*/

while($row_ocs = mysqli_fetch_assoc($resultado_ocs)){  

    //pegando data de isntalação zerada e trocando para a data do agente
    if($row_ocs['data_instalacao'] == $data_zerada){
        $sem_horario = $row_ocs['data_agente'];
    }else{
        $sem_horario = $row_ocs['data_instalacao'];
    }//end IF alterando zerada
    
    //montando o update
    $update_manager = "INSERT INTO ocs_software
    (patrimonio, software, data_instalacao, data_last_agente)
    VALUES 
    ('".$row_ocs['patrimonio']."','".$row_ocs['software']."','".$sem_horario."','".$row_ocs['data_agente']."');";

    $resultado_manager = mysqli_query($conn, $update_manager);
}//end WHILE

/*------------------------------------------------FIM----------------------------------------------------------------*/

//FECHANDO AS CONEXÕES
mysqli_close($conn);
mysqli_close($conn_ocs);

echo "Processo executado e finalizado!"
?>