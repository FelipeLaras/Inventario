<?php

//chamando conexão com o banco
require_once('conexao.php');

//Equipamentos versão 1
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

//equipamentos Versão 2

$equipamentos = "SELECT 
                    MIF.id_funcionario,
                    MIE.id_equipamento,
                    MDEQ.nome AS tipo_equipamento,
                    MIE.tipo_equipamento AS id_tipo_equipamento,
                    MIE.numero AS ramal,
                    MIE.patrimonio,
                    MIE.ip,
                    MIF.nome AS responsavel,
                    MIF.cpf,
                    MDD.nome AS departamento,
                    MDLB.nome AS locacao,
                    MDE.nome AS empresa,
                    MSO.id AS id_so,
                    MDSO.nome AS versao_so,
                    MSO.serial AS serial_so,
                    MDE.nome AS empresa_so,
                    MDL.nome AS locacao_so,
                    MSO.data_nota AS data_nota_so,
                    MSO.file_nota AS file_nota_so,
                    MSO.file_nota_nome AS file_nome_so,
                    MO.id AS id_office,
                    MDO.nome AS versao_office,
                    MO.serial AS serial_office,
                    MDE.nome AS empresa_office,
                    MDLA.nome AS locacao_office,
                    MO.data_nota AS data_nota_office,
                    MO.file_nota AS file_nota_office,
                    MO.file_nota_nome AS file_nome_office
                FROM
                    manager_inventario_equipamento MIE
                LEFT JOIN
                    manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                LEFT JOIN
                    manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                LEFT JOIN
                    manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                LEFT JOIN
                    manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                LEFT JOIN
                    manager_office MO ON MIE.id_equipamento = MO.id_equipamento
                LEFT JOIN
                    manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
                LEFT JOIN
                    manager_dropoffice MDO ON MO.versao = MDO.id
                LEFT JOIN
                    manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                LEFT JOIN
                    manager_droplocacao MDL ON MSO.locacao = MDL.id_empresa
                LEFT JOIN
                    manager_droplocacao MDLA ON MO.locacao = MDLA.id_empresa
                LEFT JOIN
                    manager_droplocacao MDLB ON MIE.locacao = MDLB.id_empresa
                WHERE
                    MIE.deletar = 1 AND MIE.tipo_equipamento IN (9 , 5, 8)";

$resultado_equip = $conn -> query($equipamentos);


//equipamentos disponiveis

$equipamentosDisponiveis = "SELECT 
                                MIE.id_equipamento,
                                MIE.status AS id_status,
                                MDST.nome AS status,
                                MDEQ.nome AS tipo_equipamento,
                                MIE.tipo_equipamento AS id_tipo_equipamento,
                                MIE.numero AS ramal,
                                MIE.patrimonio,
                                MIE.ip,
                                MDD.nome AS departamento,
                                MDLB.nome AS locacao,
                                MDE.nome AS empresa,
                                MSO.id AS id_so,
                                MDSO.nome AS versao_so,
                                MSO.serial AS serial_so,
                                MDE.nome AS empresa_so,
                                MDL.nome AS locacao_so,
                                MSO.data_nota AS data_nota_so,
                                MSO.file_nota AS file_nota_so,
                                MSO.file_nota_nome AS file_nome_so,
                                MO.id AS id_office,
                                MDO.nome AS versao_office,
                                MO.serial AS serial_office,
                                MDE.nome AS empresa_office,
                                MDLA.nome AS locacao_office,
                                MO.data_nota AS data_nota_office,
                                MO.file_nota AS file_nota_office,
                                MO.file_nota_nome AS file_nome_office
                            FROM
                                manager_inventario_equipamento MIE
                            LEFT JOIN
                                manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                            LEFT JOIN
                                manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                            LEFT JOIN
                                manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                            LEFT JOIN
                                manager_office MO ON MIE.id_equipamento = MO.id_equipamento
                            LEFT JOIN
                                manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
                            LEFT JOIN
                                manager_dropoffice MDO ON MO.versao = MDO.id
                            LEFT JOIN
                                manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                            LEFT JOIN
                                manager_droplocacao MDL ON MSO.locacao = MDL.id_empresa
                            LEFT JOIN
                                manager_droplocacao MDLA ON MO.locacao = MDLA.id_empresa
                            LEFT JOIN
                                manager_droplocacao MDLB ON MIE.locacao = MDLB.id_empresa
                            LEFT JOIN
                                manager_dropstatusequipamento MDST ON MIE.status = MDST.id_status
                            WHERE
                                MIE.deletar = 0 AND 
                                MIE.tipo_equipamento IN (9, 5, 8) AND
                                MIE.status IN (6, 10)";

$resultadoEquipDisponivel = $conn -> query($equipamentosDisponiveis);

//status funcionario
$status = "SELECT 
                id_funcionario, 
                nome 
            FROM manager_inventario_funcionario 
            WHERE 
                deletar = 0 ORDER BY nome ASC";
$result_status = $conn -> query($status);

//recebendo a informação e distribuindo nos campos do formulario
$query_Funcionario = "SELECT 
                        F.id_funcionario,
                        F.nome,
                        F.cpf,
                        Fu.nome AS funcao,
                        Fu.id_funcao,
                        D.nome AS departamento,
                        D.id_depart,
                        E.nome AS empresa,
                        F.empresa AS id_empresa,
                        MIE.patrimonio,
                        MIE.tipo_equipamento,
                        MDS.nome AS situacao,
                        MIE.situacao AS id_situacao,
                        EQ.nome AS filial,
                        MIE.filial AS id_filial,
                        MIE.locacao AS id_locacao,
                        L.nome AS locacao,
                        DD.nome AS departamento_equip,
                        MIE.departamento AS id_departamentoE,
                        MIE.hostname,
                        MIE.ip,
                        MIE.modelo,
                        MIE.processador,
                        MIE.hd,
                        MIE.memoria,
                        MIE.serialnumber,
                        DSO.nome AS so,
                        SO.versao AS id_so,
                        SO.serial AS serial_so,
                        SO.file_nota_nome,
                        SO.data_nota,
                        SO.fornecedor AS forn_so,
                        OF.versao AS id_office,
                        DOF.nome AS office,
                        OF.serial AS serial_office,
                        OF.fornecedor AS forn_office,
                        OF.empresa AS id_empresaOffice,
                        MDEF.nome AS empresaOffice,
                        OF.locacao AS id_locacaoOffice,
                        MDLF.nome AS locacaoOffice,
                        MIE.numero,
                        MIE.ipdi,
                        S.nome AS status
                    FROM
                        manager_inventario_funcionario F
                    LEFT JOIN
                        manager_dropfuncao Fu ON F.funcao = Fu.id_funcao
                    LEFT JOIN
                        manager_dropdepartamento D ON F.departamento = D.id_depart
                    LEFT JOIN
                        manager_dropempresa E ON F.empresa = E.id_empresa
                    LEFT JOIN
                        manager_dropstatus S ON F.status = S.id_status
                    LEFT JOIN
                        manager_inventario_equipamento MIE ON F.id_funcionario = MIE.id_funcionario
                    LEFT JOIN
                        manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
                    LEFT JOIN
                        manager_dropempresa EQ ON MIE.filial = EQ.id_empresa
                    LEFT JOIN
                        manager_droplocacao L ON MIE.locacao = L.id_empresa
                    LEFT JOIN
                        manager_dropdepartamento DD ON MIE.departamento = DD.id_depart
                    LEFT JOIN
                        manager_sistema_operacional SO ON MIE.id_equipamento = SO.id_equipamento
                    LEFT JOIN
                        manager_dropsistemaoperacional DSO ON SO.versao = DSO.id
                    LEFT JOIN
                        manager_office OF ON MIE.id_equipamento = OF.id_equipamento
                    LEFT JOIN
                        manager_dropoffice DOF ON DOF.id = OF.versao
                    LEFT JOIN
                        manager_dropempresa MDEF ON OF.empresa = MDEF.id_empresa
                     LEFT JOIN
                        manager_droplocacao MDLF ON OF.locacao = MDLF.id_empresa
                    WHERE ";

//Equipamento

$query_equipamento = "SELECT 
                        MIE.numero,
                        MIE.tipo_equipamento,
                        MIE.patrimonio,
                        MIE.filial AS id_empresa,
                        MDE.nome AS empresa,
                        MIE.locacao AS id_locacao,
                        MDL.nome AS locacao,
                        MIE.departamento AS id_departamento,
                        MDD.nome AS departamento,
                        MIE.hostname,
                        MIE.ip,
                        MIE.modelo,
                        MIE.processador,
                        MIE.hd,
                        MIE.memoria,
                        MIE.situacao AS id_situacao,
                        MDS.nome AS situacao,
                        MIE.serialnumber
                    FROM
                        manager_inventario_equipamento MIE
                    LEFT JOIN
                        manager_dropempresa MDE ON MIE.filial = MDE.id_empresa
                    LEFT JOIN
                        manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
                    LEFT JOIN
                        manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                    LEFT JOIN
                        manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
                    WHERE ";
//windows                    
$query_windows = "SELECT 
                        MSO.id,
                        MSO.versao AS id_versao,
                        MDSO.nome AS versao,
                        MSO.serial,
                        MSO.fornecedor,
                        MSO.file_nota AS caminho_so,
                        MSO.file_nota_nome AS nome_nota_so,
                        MSO.data_nota AS data_nota_so 
                    FROM
                        manager_sistema_operacional MSO
                    LEFT JOIN
                        manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                    WHERE ";

//Office
$query_office = "SELECT 
                    MOF.id,
                    MOF.versao AS id_versao,
                    MDOF.nome AS versao,
                    MOF.serial,
                    MOF.fornecedor,
                    MOF.empresa AS id_empresa,
                    MDE.nome AS empresa,
                    MOF.locacao AS id_locacao,
                    MDL.nome AS locacao,                       
                    MO.file_nota AS caminho_of,
                    MO.file_nota_nome AS nome_nota_of,
                    MDO.nome AS versao_of,
                    MO.data_nota AS data_nota_of
                 FROM
                    manager_office MOF
                 LEFT JOIN
                    manager_dropoffice MDOF ON MOF.versao = MDOF.id
                 LEFT JOIN
                    manager_dropempresa MDE ON MOF.empresa = MDE.id_empresa
                 LEFT JOIN
                    manager_droplocacao MDL ON MOF.locacao = MDL.id_empresa
                 WHERE ";

//Termo
$query_doc_termo = "SELECT 
                        MIA.id_anexo,
                        MIA.caminho,
                        MIA.nome,
                        MIA.data_criacao,
                        MIA.tipo
                    FROM
                        manager_inventario_anexo MIA
                    WHERE ";

//contagem de status
//query para a contagem dos itens ativos, faltaTermo e demitido.

/*------------------------------------FALTA TERMO-----------------------------------------*/
$query_f = "SELECT 
         COUNT(MIF.status) AS faltaTermo
         FROM
         manager_inventario_funcionario MIF
         LEFT JOIN
         manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
         WHERE
         MIF.status = 3 AND 
         MIE.tipo_equipamento in (9 , 5) AND
         MIF.deletar = 0";
$resultado_f = $conn->query($query_f);
$row_f = $resultado_f->fetch_assoc();

/*------------------------------------ATIVOS-----------------------------------------*/

$query_a = "SELECT
         COUNT(MIF.status) AS ativo
         FROM
         manager_inventario_funcionario MIF
         LEFT JOIN
         manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
         WHERE
         MIF.status = 4 AND
         MIE.tipo_equipamento in (9 , 5, 8) AND
         MIF.deletar = 0";
$resultado_a = $conn->query($query_a);
$row_a = $resultado_a->fetch_assoc();

/*---------------------------------DEMITIDOS--------------------------------------------*/

$query_d = "SELECT 
         COUNT(MIF.status) AS demitido
         FROM
         manager_inventario_funcionario MIF
         LEFT JOIN
         manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
         WHERE
         MIF.status = 8 AND
         MIE.tipo_equipamento in (9 , 5, 8) AND
         MIF.deletar = 0";
$resultado_d = $conn->query($query_d);
$row_d = mysqli_fetch_assoc($resultado_d);

/*---------------------------------SEM EQUIPAMENTOS--------------------------------------------*/

$query_Squip = "SELECT 
         COUNT(MIF.status) AS sem_equip
         FROM
         manager_inventario_funcionario MIF
         LEFT JOIN
         manager_inventario_equipamento MIE ON MIE.id_funcionario = MIF.id_funcionario
         WHERE
         MIF.status = 9 AND
         MIE.tipo_equipamento in (9 , 5, 8) AND
         MIF.deletar = 0";
$resultado_Squip = $conn->query($query_Squip);
$row_Squip = mysqli_fetch_assoc($resultado_Squip);

/*---------------------------------SCANNER--------------------------------------------*/

$query_scanner = "SELECT 
         COUNT(MIE.id_equipamento) AS scanner
         FROM
         manager_inventario_equipamento MIE
         WHERE
            MIE.deletar = 0 AND 
            MIE.tipo_equipamento = 10 ";
$resultado_scanner = $conn->query($query_scanner);
$row_scanner = mysqli_fetch_assoc($resultado_scanner);

/*---------------------------------DISPONIVEIS--------------------------------------------*/

$query_disponivel = "SELECT 
         COUNT(MIE.id_equipamento) AS disponivel
         FROM
         manager_inventario_equipamento MIE
         WHERE
            MIE.deletar = 0 AND 
            MIE.status IN (6, 10) AND
            MIE.tipo_equipamento IN (8,9)";
$resultado_disponivel = $conn->query($query_disponivel);
$row_disponivel = mysqli_fetch_assoc($resultado_disponivel);

/*---------------------------------CONDENADOS--------------------------------------------*/

$query_condenados = "SELECT 
         COUNT(MIE.id_equipamento) AS condenados
         FROM
         manager_inventario_equipamento MIE
         WHERE
            MIE.deletar = 1 AND
            MIE.tipo_equipamento IN (8 , 9)";
$resultado_condenados = $conn->query($query_condenados);
$row_condenados = mysqli_fetch_assoc($resultado_condenados);



?>