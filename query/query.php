<?php
require_once('../conexao/conexao.php');

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
                    MIE.tipo_equipamento IN (9 , 5, 8, 10) AND (MIE.status = 11 OR MIE.deletar = 1)";

$resultado_equip = $conn->query($equipamentos);


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

$resultadoEquipDisponivel = $conn->query($equipamentosDisponiveis);

$queryOffiDisponivel = "SELECT 
                            OFFI.id,
                            MDL.nome AS locacao,
                            MDE.nome AS empresa,
                            MDOF.nome AS versao,
                            OFFI.serial,
                            OFFI.fornecedor,
                            OFFI.numero_nota,
                            OFFI.file_nota,
                            OFFI.file_nota_nome AS nomeNota,
                            OFFI.data_nota
                        FROM
                            manager_office OFFI
                        LEFT JOIN
                            manager_droplocacao MDL ON (OFFI.locacao = MDL.id_empresa)
                        LEFT JOIN
                            manager_dropempresa MDE ON (OFFI.empresa = MDE.id_empresa)
                        LEFT JOIN
                            manager_dropoffice MDOF ON (OFFI.versao = MDOF.id)
                        WHERE
                            OFFI.id_equipamento = 0 AND OFFI.deletar = 0";

$resultOfficeDispo = $conn->query($queryOffiDisponivel);


//status funcionario
$status = "SELECT 
                id_funcionario, 
                nome 
            FROM manager_inventario_funcionario 
            WHERE 
                deletar = 0 ORDER BY nome ASC";
$result_status = $conn->query($status);

//recebendo a informação e distribuindo nos campos do formulario
$query_funcionario = "SELECT 
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
                        S.nome AS status,
                        MIOBS.obs
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
                    LEFT JOIN
                        manager_inventario_obs MIOBS ON F.id_funcionario = MIOBS.id_funcionario                        
                    WHERE ";

//Equipamento

$query_equipamento = "SELECT 
                        MIE.numero,
                        MIE.tipo_equipamento AS id_tipoEquipamento,
                        MDTE.nome AS tipo_equipamento,
                        MIE.patrimonio,
                        MIE.filial AS id_empresa,
                        MDE.nome AS empresa,
                        MIE.locacao AS id_locacao,
                        MDL.nome AS locacao,
                        MIE.departamento AS id_departamento,
                        MDD.nome AS departamento,
                        MIE.imei_chip,
                        MIE.hostname,
                        MIE.ip,
                        MIE.valor,
                        MIE.modelo,
                        MIE.planos_dados,
                        MIE.processador,
                        MIE.hd,
                        MIE.memoria,
                        MIE.situacao AS id_situacao,
                        MDS.nome AS situacao,
                        MIE.serialnumber,
                        MIF.nome AS nome_funcionario,
                        MDET.nome as estado,
                        MIE.estado AS id_estado
                    FROM
                        manager_inventario_equipamento MIE
                    LEFT JOIN
                        manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                    LEFT JOIN
                        manager_dropempresa MDTE ON MIE.filial = MDTE.id_empresa
                    LEFT JOIN
                        manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
                    LEFT JOIN
                        manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                    LEFT JOIN
                        manager_dropsituacao MDS ON MIE.situacao = MDS.id_situacao
                    LEFT JOIN
                        manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                    LEFT JOIN
                        manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
                    LEFT JOIN
	                    manager_dropestado MDET ON MIE.estado = MDET.id
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
                        MSO.numero_nota,
                        MSO.data_nota AS data_nota_so,
                        MDE.nome AS empresa,
                        MDL.nome AS locacao
                    FROM
                        manager_sistema_operacional MSO
                    LEFT JOIN
                        manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
                    LEFT JOIN
                        manager_dropempresa MDE ON MSO.empresa = MDE.id_empresa
                    LEFT JOIN
                        manager_droplocacao MDL ON MSO.locacao = MDL.id_empresa
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
                    MOF.file_nota AS caminho_of,
                    MOF.file_nota_nome AS nome_nota_of,
                    MDOF.nome AS versao_of,
                    MOF.data_nota AS data_nota_of,
                    MOF.numero_nota
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
            MIE.tipo_equipamento = 10 AND (MIE.deletar = 0 AND MIE.status != 11)";
$resultado_scanner = $conn->query($query_scanner);
$row_scanner = mysqli_fetch_assoc($resultado_scanner);

/*---------------------------------OFFICE--------------------------------------------*/

$query_office = "SELECT 
                    COUNT(OFF.id) AS office
                FROM
                    manager_office OFF
                WHERE
                    OFF.id_equipamento = 0 AND OFF.deletar = 0";

$resultado_office = $conn->query($query_office);

$row_office = $resultado_office->fetch_assoc();

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
            MIE.tipo_equipamento IN (8 , 9, 10) AND (MIE.deletar = 1 OR status = 11)";
$resultado_condenados = $conn->query($query_condenados);
$row_condenados = $resultado_condenados->fetch_assoc();


//RELATORIOS
if ($_GET['relatorios'] == 1) {

    //montando a pesquisa para o relatório
    $query_rel_equipamentos = "SELECT 
                                MIE.id_equipamento,
                                MDE.nome AS tipo_equipamento,
                                MIE.modelo,
                                MIE.patrimonio,
                                MDD.nome AS departamento,
                                MDEM.nome AS filial,
                                MDL.nome AS locacao,
                                MDS.nome AS status,
                                MIE.id_funcionario,
                                MIF.nome,
                                MIE.dominio,
                                MIE.numero
                            FROM
                                manager_inventario_equipamento MIE
                            LEFT JOIN
                                manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
                            LEFT JOIN
                                manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                            LEFT JOIN
                                manager_dropempresa MDEM ON MIE.filial = MDEM.id_empresa
                            LEFT JOIN
                                manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
                            LEFT JOIN
                                manager_dropstatusequipamento MDS ON MIE.status = MDS.id_status
                            LEFT JOIN
                                manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                            WHERE ";

    if (!empty($_GET['eq'])) {
        $query_rel_equipamentos .= "MIE.tipo_equipamento = '" . $_GET['eq'] . "'";

        if (!empty($_GET['se'])) {
            $query_rel_equipamentos .= " AND MIE.status = '" . $_GET['se'] . "'";

            if(!empty($_GET['fi'])){
                $query_rel_equipamentos .= " AND MIE.filial = '" . $_GET['fi'] . "'";
            }
        }else{
            if(!empty($_GET['fi'])){
                $query_rel_equipamentos .= " AND MIE.filial = '" . $_GET['fi'] . "'";
            }
        }
    } else {
        if (!empty($_GET['se'])) {
            $query_rel_equipamentos .= "MIE.status = '" . $_GET['se'] . "'";

            if(!empty($_GET['fi'])){
                $query_rel_equipamentos .= " AND MIE.filial = '" . $_GET['fi'] . "'";
            }
        } else {
            if(!empty($_GET['fi'])){
                $query_rel_equipamentos .= "MIE.filial = '" . $_GET['fi'] . "'";
            }else{
                header('location: ../inc/relatorio_tecnicos.php?msn=2');
            }
        }
    }
    $resultado_rel_equipamentos = $conn->query($query_rel_equipamentos);
}

if ($_GET['relatorios'] == 2) {
    $query_relatorios = "SELECT 
                            MIF.nome, 
                            MIF.cpf, 
                            MDF.nome AS funcao, 
                            MDD.nome AS departamento, 
                            MDE.nome AS filial, 
                            MDEQ.nome AS tipo_equipamento, 
                            MIE.modelo, 
                            MIE.imei_chip, 
                            MIE.numero, 
                            MIE.valor, 
                            MDSE.nome AS status
                        FROM 
                            manager_inventario_funcionario MIF
                        LEFT JOIN 
                            manager_inventario_equipamento MIE ON MIF.id_funcionario = MIE.id_funcionario
                        LEFT JOIN 
                            manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
                        LEFT JOIN 
                            manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
                        LEFT JOIN 
                            manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
                        LEFT JOIN 
                            manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                        LEFT JOIN 
                            manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
                        WHERE ";

    if (!empty($_GET['nome'])) {
        $query_relatorios .= "MIF.nome like '%" . $_GET['nome'] . "%'";

        if (!empty($_GET['cpf'])) {
            $query_relatorios .= " AND MIF.cpf = '" . $_GET['cpf'] . "'";

            if (!empty($_GET['func'])) {
                $query_relatorios .= " AND MIF.funcao = '" . $_GET['func'] . "'";

                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            } else {
                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            }
        } else {
            if (!empty($_GET['func'])) {
                $query_relatorios .= " AND MIF.funcao = '" . $_GET['func'] . "'";

                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            } else {
                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            }
        }
    } else {
        if (!empty($_GET['cpf'])) {
            $query_relatorios .= "MIF.cpf = '" . $_GET['cpf'] . "'";

            if (!empty($_GET['func'])) {
                $query_relatorios .= " AND MIF.funcao = '" . $_GET['func'] . "'";

                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            } else {
                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            }
        } else {
            if (!empty($_GET['func'])) {
                $query_relatorios .= "MIF.funcao = '" . $_GET['func'] . "'";

                if (!empty($_GET['dep'])) {
                    $query_relatorios .= " AND MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                }
            } else {
                if (!empty($_GET['dep'])) {
                    $query_relatorios .= "MIF.departamento = '" . $_GET['dep'] . "'";

                    if (!empty($_GET['em'])) {
                        $query_relatorios .= " AND MIF.empresa = '" . $_GET['em'] . "'";
                    }
                } else {
                    if (!empty($_GET['em'])) {
                        $query_relatorios .= "MIF.empresa = '" . $_GET['em'] . "'";
                    } else {
                        header('location: ../inc/relatorio_tecnicos.php?msn=2');
                    }
                }
            }
        }
    } //end IF
    $resultado_relatorios = $conn->query($query_relatorios);    
}

if($_GET['relatorios'] == 3){

    $hoje = date('d/m/yy');

    $datainicio = date('d/m/yy', strtotime($_GET['inicio_data']));

    if(empty($_GET['fim_data'])){
        $dataFim = $hoje;
    }else{
        $dataFim = $_GET['fim_data'];
    }

//montando a pesquisa para o relatório
$query_rel_fiscal = "SELECT 
                        MIF.nome,
                        MDD.nome AS DepartamentoFuncionario,
                        MDEM.nome AS EmpresaEquipamento,
                        MDEQ.nome AS tipo_equipamento,
                        MIE.modelo,
                        MIE.imei_chip,
                        MIE.numero_nota,
                        MIE.data_nota,
                        MIE.valor,
                        MDSE.nome AS status,
                        MIA.caminho,
                        MIA.nome AS Nota
                    FROM
                        manager_inventario_equipamento MIE
                    LEFT JOIN
                        manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                    LEFT JOIN
                        manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
                    LEFT JOIN
                        manager_dropempresa MDEM ON MIE.filial = MDEM.id_empresa
                    LEFT JOIN
                        manager_dropequipamentos MDEQ ON MIE.tipo_equipamento = MDEQ.id_equip
                    LEFT JOIN
                        manager_dropstatusequipamento MDSE ON MIE.status = MDSE.id_status
                    LEFT JOIN
                        manager_inventario_anexo MIA ON MIE.id_equipamento = MIA.id_equipamento
                    WHERE ";

                    if(!empty($_GET['numero_nota'])){
                        $query_rel_fiscal .= "MIE.numero_nota = '".$_GET['numero_nota']."'";

                        if(!empty($_GET['filial'])){
                            $query_rel_fiscal .= " AND MIE.filial = '".$_GET['filial']."'";

                            if(!empty($_GET['inicio_data'])){
                                $query_rel_fiscal .= " AND MIE.data_nota BETWEEN '".$datainicio."' AND '".$dataFim."'";
                            }
                        }else{
                            if(!empty($_GET['inicio_data'])){
                                $query_rel_fiscal .= " AND MIE.data_nota BETWEEN '".$datainicio."' AND '".$dataFim."'";
                            }
                        }
                    }else{
                        if(!empty($_GET['filial'])){
                            $query_rel_fiscal .= "MIE.filial = '".$_GET['filial']."'";  

                            if(!empty($_GET['inicio_data'])){
                                $query_rel_fiscal .= " AND MIE.data_nota BETWEEN '".$datainicio."' AND '".$dataFim."'";
                            }
                        }else{
                             if(!empty($_GET['inicio_data'])){
                                $query_rel_fiscal .= "MIE.data_nota BETWEEN '".$datainicio."' AND '".$dataFim."'";
                            }else{
                                header('location: ../inc/relatorio_tecnicos.php?msn=2');
                            }
                        }
                    }
$resultado_rel_fiscal = $conn->query($query_rel_fiscal);
}
