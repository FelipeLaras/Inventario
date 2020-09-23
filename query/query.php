<?php

//chamando conexão com o banco
require_once('conexao.php');

//Equipamentos
    $query = "SELECT 
        MIE.id_funcionario,
        MIE.id_equipamento,
        MDE.nome AS tipo_equipamento,
        MIE.modelo,
        MIE.patrimonio,
        MIE.imei_chip,
        MIE.numero,
        MIE.planos_voz,
        MIE.planos_dados,
        MDO.nome AS operadora,
        MDSE.nome AS status,
        MIE.termo,
        MDSE.id_status,
        MIE.filial,
        MDES.nome AS filial,
        MIE.tipo_equipamento AS id_tipo,
        MIE.data_nota,
        MIE.valor,
        MIF.nome AS funcionario,
        MDS.nome AS situacao,
        MDET.nome AS estado
    FROM
        manager_inventario_equipamento MIE
    LEFT JOIN
        manager_dropempresa MDES ON MIE.filial = MDES.id_empresa
    LEFT JOIN
        manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
    LEFT JOIN
        manager_dropoperadora MDO ON MDO.id_operadora = MIE.operadora
    LEFT JOIN
        manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
    LEFT JOIN
        manager_inventario_funcionario MIF ON MIF.id_funcionario = MIE.id_funcionario
    LEFT JOIN
        manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
    LEFT JOIN
        manager_dropestado MDET ON MIE.estado = MDET.id
    WHERE
        MIE.deletar = 0 AND
        MIE.tipo_equipamento in (1, 3, 2, 4) ORDER BY MIE.id_equipamento ASC";

$resultado = $conn->query($query);


?>