<?php



//incluindo o banco
require_once('../conexao/conexao.php');

//software
$query = "SELECT * FROM ocs_software";
$resultado = $conn->query($query);

while($row = mysqli_fetch_assoc($resultado)){

    $insert = "INSERT INTO manager_software (patrimonio, software_atual ,software_anterior , data_instalacao, data_last_agente, usuario, usuario_data) VALUE 
            ('".$row['patrimonio']."', '".$row['software']."', '".$row['software']."', '".$row['data_instalacao']."', '".$row['data_last_agente']."', '1', '2019-07-12')";
  
    $resultado_insert = $conn->query($insert);

}

//equipamento


$query_equip = "SELECT * FROM manager_ocs_equip";
$resultado_equip = $conn->query($query_equip);

while($row_equip = mysqli_fetch_assoc($resultado_equip)){

    $insert_equip = "INSERT INTO manager_equipamento (patrimonio, memoria, hard_disk, processador, ip, usuario, usuario_data) VALUE 
            ('".$row_equip['patrimonio']."', '".$row_equip['memoria']."', '".$row_equip['hd']."', '".$row_equip['processador']."', '".$row_equip['ip']."', '1', '2019-07-11')";
    $resultado_insert_equip = $conn->query($insert_equip);

}

echo "Executado com Sucesso!";

//fechando o banco
$conn->close();
?>