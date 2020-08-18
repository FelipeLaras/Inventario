<?php
//chamando a base do OCS
include 'conexao_ocs.php';

//chamando a base do manager
include 'conexao.php';

//dominio servopa
$dominio = 'servopa.local';

//montando a coleta dos dados

$query_ocs = "SELECT
                H.ID AS hardware_id,                
                H.WORKGROUP AS dominio,
                AI.TAG AS patrimonio,
                H.NAME AS hostname,
                H.IPSRC AS ip,
                B.SSN AS serial_number,
                B.SMODEL AS modelo,
                C.TYPE AS processador,
                (select sum(DISKSIZE) from storages S where H.id = S.HARDWARE_ID ) AS hd,
                (select sum(capacity) from memories M where H.id = M.HARDWARE_ID ) AS memoria,
                H.OSNAME AS sistema_operacional,
                H.WINPRODKEY AS chave_windows,
                OF.PRODUCT AS office,
                OF.OFFICEKEY AS chave_office
            FROM 
                hardware H
            LEFT JOIN 
                accountinfo AI ON H.id = AI.HARDWARE_ID
            LEFT JOIN 
                cpus C ON H.ID = C.HARDWARE_ID
            LEFT JOIN 
                bios B ON H.ID = B.HARDWARE_ID
            LEFT JOIN 
                officepack OF ON H.ID = OF.HARDWARE_ID
            LEFT JOIN 
                storages S ON H.ID = S.HARDWARE_ID
                ";
$resultado_ocs = mysqli_query($conn_ocs, $query_ocs);

//funcão de conversão de dados HD
function HD($size){
    $filesizename = array(" Bytes", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
} 
//funcão de converso de dados Memória
function RAM($size){
    $filesizename = array(" Bytes", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

/*----------------------------excluindo os dados da tabela manager_ocs_equip-------------------------------------*/

$drop_table = "DROP TABLE manager_ocs_equip";
$resultado_drop = mysqli_query($conn, $drop_table) or die(mysqli_error($conn));

/*----------------------------criando os dados da tabela manager_ocs_equip----------------------------------------*/

$create_table = "CREATE TABLE `manager`.`manager_ocs_equip` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `hardware_id` INT(10) NULL,
    `dominio` INT(10) NULL COMMENT '0 = possui;\n1 = não possui',
    `patrimonio` VARCHAR(60) NULL,
    `hd` VARCHAR(30) NULL,
    `processador` VARCHAR(50) NULL,
    `memoria` VARCHAR(30) NULL,
    `hostname` VARCHAR(30) NULL,
    `ip` VARCHAR(15) NULL,
    `serial_number` VARCHAR(60) NULL,
    `modelo` VARCHAR(40) NULL,
    `sistema_operacional` VARCHAR(50) NULL,
    `chave_windows` VARCHAR(30) NULL,
    `office` VARCHAR(255) NULL,
    `chave_office` VARCHAR(30) NULL,
    PRIMARY KEY (`id`))";
$resultado_create = mysqli_query($conn, $create_table) or die(mysqli_error($conn));

/*----------------------------inserindo os dados na base manager--------------------------------------------------*/

while($row_ocs = mysqli_fetch_assoc($resultado_ocs)){    
    
    //convertendo antes de salvar
    $valbytes = $row_ocs['hd'];    
    $hd = HD($valbytes);
    //convertendo antes de salvar
    $valbytes = $row_ocs['memoria'];    
    $memoria = RAM($valbytes);

    //tratando as informações do dominio(AD)

    if($row_ocs['dominio'] === $dominio){
        $servopaLocal = 0; //possui dominio
    }else{
        $servopaLocal = 1; //não possui dominio
    }

    //montando o update
    $update_manager = "INSERT INTO manager_ocs_equip
    (hardware_id, dominio, patrimonio,hd, processador, memoria, hostname, ip, serial_number, modelo, sistema_operacional, chave_windows, office, chave_office)
    VALUES 
    ('".$row_ocs['hardware_id']."',
    '".$servopaLocal."',
    '".$row_ocs['patrimonio']."',
    '".$hd."',
    '".$row_ocs['processador']."',
    '".$memoria."',
    '".$row_ocs['hostname']."',
    '".$row_ocs['ip']."',
    '".$row_ocs['serial_number']."',
    '".$row_ocs['modelo']."',
    '".$row_ocs['sistema_operacional']."',
    '".$row_ocs['chave_windows']."',
    '".$row_ocs['office']."',
    '".$row_ocs['chave_office']."')";

    $resultado_manager = mysqli_query($conn, $update_manager);

}//end WHILE

/*------------------------------------------------FIM----------------------------------------------------------------*/

//FECHANDO AS CONEXÕES
mysqli_close($conn);
mysqli_close($conn_ocs);
?>