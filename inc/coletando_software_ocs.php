<?php
//chamando a base do OCS
require_once('../conexao/conexao_ocs.php');

//chamando a base do manager
require_once('../conexao/conexao.php');

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
$resultado_ocs = $conn_ocs -> query($query_ocs);

/*----------------------------excluindo os dados da tabela manager_ocs_equip-------------------------------------*/

$drop_table = "DROP TABLE ocs_software";
$resultado_drop = $conn -> query($drop_table);

/*----------------------------criando os dados da tabela manager_ocs_equip----------------------------------------*/

$create_table = "CREATE TABLE `manager`.`ocs_software` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `patrimonio` VARCHAR(255)  NULL,
    `software` VARCHAR(255) NULL,
    `data_instalacao` DATETIME NULL,
    `data_last_agente` DATETIME NULL,
    PRIMARY KEY (`id`));";
$resultado_create = $conn -> query($create_table);

/*----------------------------inserindo os dados na base manager--------------------------------------------------*/

while($row_ocs = $resultado_ocs -> fetch_assoc()){  

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

    $resultado_manager = $conn -> query($update_manager);
}//end WHILE

/*------------------------------------------------FIM----------------------------------------------------------------*/

//FECHANDO AS CONEXÕES
$conn -> close($conn);
$conn_ocs -> close();

echo "Processo executado e finalizado!"
?>