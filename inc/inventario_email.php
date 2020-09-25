<?php
//iniciando uma sessão
session_start();

//chamando o banco de dados
require_once('../conexao/conexao.php');
/*-----------------------------------------------------------------------------*/

//Variaveis com as tratativas das datas
$data_hoje = date('Y-m-d');
$data_5 = date('Y-m-d', strtotime("-5 days", strtotime($data_hoje)));//data de hoje somando 5 dias
$data_10 = date('Y-m-d', strtotime("-10 days", strtotime($data_hoje)));//data de hoje somando 10 dias
$data_15 = date('Y-m-d', strtotime("-15 days", strtotime($data_hoje)));//data de hoje somando 15 dias

/*-----------------------------------------------------------------------------*/
//tratando os equipamentos com exatamente 5 dias de pendência
$query_data_5 = "SELECT 
MIE.id_equipamento,
MIE.id_funcionario,
MIE.data_criacao,
MIE.modelo,
MIF.nome,
MIE.tipo_equipamento,
MDE.nome AS filial,
MDD.nome AS departamento,
MIE.imei_chip,
MIE.numero
FROM
manager_inventario_funcionario MIF
    LEFT JOIN
manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
    LEFT JOIN
manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
    LEFT JOIN
manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
WHERE
MIF.deletar = 0 AND 
MIE.termo = 1 AND 
MIE.tipo_equipamento IN (1, 3, 4, 2) AND /*1 = Celular; 3 = CHIP; 4 = MODEM; 2 = TABLET*/
MIE.data_criacao = '".$data_5."'";
$resultado_data_5 = $conn->query($query_data_5);

$cont = 0;
while ($row_data_5 = mysqli_fetch_assoc($resultado_data_5)) {

    $_SESSION['destinatario_5'] = 'larissa.santos@servopa.com.br';
    $_SESSION['nome_5'] = 'Larissa Santos';
    $_SESSION['modelo_5'.$cont.''] = $row_data_5['modelo'];
    $_SESSION['tipo_5'.$cont.''] = $row_data_5['tipo_equipamento'];
    $_SESSION['funcionario_5'.$cont.''] = $row_data_5['nome'];
    $_SESSION['filial_5'.$cont.''] = $row_data_5['filial'];
    $_SESSION['departamento_5'.$cont.''] = $row_data_5['departamento'];
    $_SESSION['imei_chip_5'.$cont.''] = $row_data_5['imei_chip'];
    $_SESSION['numero_5'.$cont.''] = $row_data_5['numero'];
    $_SESSION['id_equipamento_5'.$cont.''] = $row_data_5['id_equipamento'];
    $_SESSION['dias_5'] = 5;  
    $cont++;//somando mais um para montar a tabela na hora de enviar o e-mail
}

/*-----------------------------------------------------------------------------*/
//tratando os equipamentos com exatamente 10 dias de pendência
$query_data_10 = "SELECT 
MIE.id_equipamento,
MIE.id_funcionario,
MIE.data_criacao,
MIE.modelo,
MIF.nome,
MIE.tipo_equipamento,
MDE.nome AS filial,
MDD.nome AS departamento,
MIE.imei_chip,
MIE.numero
FROM
manager_inventario_funcionario MIF
    LEFT JOIN
manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
    LEFT JOIN
manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
    LEFT JOIN
manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
WHERE
MIF.deletar = 0 AND 
MIE.termo = 1 AND 
MIE.tipo_equipamento IN (1, 3, 4, 2) AND /*1 = Celular; 3 = CHIP; 4 = MODEM; 2 = TABLET*/
MIE.data_criacao = '".$data_10."'";
$resultado_data_10 = $conn->query($query_data_10);


$cont = 0;
while ($row_data_10 = $resultado_data_10->fetch_assoc()) {

    $_SESSION['destinatario_10'] = 'lucimara.segalla@servopa.com.br';
    $_SESSION['nome_10'] = 'Larissa Santos';
    $_SESSION['modelo_10'.$cont.''] = $row_data_10['modelo'];
    $_SESSION['tipo_10'.$cont.''] = $row_data_10['tipo_equipamento'];
    $_SESSION['funcionario_10'.$cont.''] = $row_data_10['nome'];
    $_SESSION['filial_10'.$cont.''] = $row_data_10['filial'];
    $_SESSION['departamento_10'.$cont.''] = $row_data_10['departamento'];
    $_SESSION['imei_chip_10'.$cont.''] = $row_data_10['imei_chip'];
    $_SESSION['numero_10'.$cont.''] = $row_data_10['numero'];
    $_SESSION['id_equipamento_10'.$cont.''] = $row_data_10['id_equipamento'];
    $_SESSION['dias_10'] = 10;  
    $cont++;//somando mais um para montar a tabela na hora de enviar o e-mail
}

/*-----------------------------------------------------------------------------*/
//tratando os equipamentos com exatamente 15 dias de pendência
$query_data_15 = "SELECT 
MIE.id_equipamento,
MIE.id_funcionario,
MIE.data_criacao,
MIE.modelo,
MIF.nome,
MIE.tipo_equipamento,
MDE.nome AS filial,
MDD.nome AS departamento,
MIE.imei_chip,
MIE.numero
FROM
manager_inventario_funcionario MIF
    LEFT JOIN
manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
    LEFT JOIN
manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
    LEFT JOIN
manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
WHERE
MIF.deletar = 0 AND 
MIE.termo = 1 AND 
MIE.tipo_equipamento IN (1, 3, 4, 2) AND /*1 = Celular; 3 = CHIP; 4 = MODEM; 2 = TABLET*/
MIE.data_criacao =  '".$data_15."'";
$resultado_data_15 = $conn->query($query_data_15);

$cont = 0;
while ($row_data_15 = mysqli_fetch_assoc($resultado_data_15)) {

    $_SESSION['destinatario_15'] = 'celina@servopa.com.br';
    $_SESSION['nome_15'] = 'Larissa Santos';
    $_SESSION['modelo_15'.$cont.''] = $row_data_15['modelo'];
    $_SESSION['tipo_15'.$cont.''] = $row_data_15['tipo_equipamento'];
    $_SESSION['funcionario_15'.$cont.''] = $row_data_15['nome'];
    $_SESSION['filial_15'.$cont.''] = $row_data_15['filial'];
    $_SESSION['departamento_15'.$cont.''] = $row_data_15['departamento'];
    $_SESSION['imei_chip_15'.$cont.''] = $row_data_15['imei_chip'];
    $_SESSION['numero_15'.$cont.''] = $row_data_15['numero'];
    $_SESSION['id_equipamento_15'.$cont.''] = $row_data_15['id_equipamento'];
    $_SESSION['dias_15'] = 15;  
    $cont++;//somando mais um para montar a tabela na hora de enviar o e-mail
}

header('location: inventario_envioEmail.php');
$conn->close();
?>