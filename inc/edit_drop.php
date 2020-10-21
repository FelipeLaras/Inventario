<?php
//aplicando para usar varialve em outro arquivo
session_start();

//Aplicando a regra de login
if ($_SESSION["perfil"] == NULL) {
    header('location: ../front/index.html');
} elseif ($_SESSION["perfil"] == 2) {
    header('location: ../front/error.php');
}

require_once('../conexao/conexao.php');

/*EDITANDO OS MENUS*/

//Função
if (!empty($_POST['id_funcao'])) {
    $updateFun = "UPDATE manager_dropfuncao SET nome = '" . $_POST['name_funcao'] . "' WHERE (id_funcao = '" . $_POST['id_funcao'] . "')";

    echo $updateFun;

    $resultFun = $conn->query($updateFun);
    $_SESSION['activeFun'] = 1;
}

//departamento
if (!empty($_POST['id_depart'])) {
    $updateDep = "UPDATE manager_dropdepartamento SET nome = '" . $_POST['name_departamento'] . "' WHERE (id_depart = '" . $_POST['id_depart'] . "')";
    $resultDep = $conn->query($updateDep);    
    $_SESSION['activeDep'] = 1;
}

//Empresa
if (!empty($_POST['id_empresa'])) {
    $updateEmp = "UPDATE manager_dropempresa SET nome = '" . $_POST['name_empresa'] . "' WHERE (id_empresa = '" . $_POST['id_empresa'] . "')";
    $resultEmp = $conn->query($updateEmp);    
    $_SESSION['activeEmp'] = 1;
}

//Locação
if (!empty($_POST['id_locacao'])) {
    $updateLoc = "UPDATE manager_droplocacao SET nome = '" . $_POST['name_locacao'] . "' WHERE (id_empresa = '" . $_POST['id_locacao'] . "')";
    $resultLoc = $conn->query($updateLoc);
    $_SESSION['activeLoc'] = 1;
}

//Status Colaborador
if (!empty($_POST['id_statusFun'])) {
    $updateSt = "UPDATE manager_dropstatus SET nome = '" . $_POST['name_status_colaborador'] . "' WHERE (id_status = '" . $_POST['id_statusFun'] . "')";
    $resultSt = $conn->query($updateSt);
    $_SESSION['activeSt'] = 1;
}

//Equipamentos
if (!empty($_POST['id_equip'])) {
    $updateEquip = "UPDATE manager_dropequipamentos SET nome = '" . $_POST['name_equipamentos'] . "' WHERE (id_equip = '".$_POST['id_equip']."')";
    $resultEquip = $conn->query($updateEquip);
    $_SESSION['activeEquip'] = 1;
}

//Situação
if (!empty($_POST['id_situacao'])) {
    $updateSit = "UPDATE manager_dropsituacao SET nome = '" . $_POST['name_situacao'] . "' WHERE (id_situacao = '".$_POST['id_situacao']."')";
    $resultSit = $conn->query($updateSit);
    $_SESSION['activeSit'] = 1;
}

//Estado
if (!empty($_POST['id_estado'])) {
    $updateEst = "UPDATE manager_dropestado SET nome = '" . $_POST['name_estado'] . "' WHERE (id = '".$_POST['id_estado']."')";
    $resultEst = $conn->query($updateEst);
    $_SESSION['activeEst'] = 1;
}

//Acessórios
if (!empty($_POST['id_acessorio'])) {
    $updateAce = "UPDATE manager_dropacessorios SET nome = '" . $_POST['name_acessorios'] . "' WHERE (id_acessorio = '".$_POST['id_acessorio']."')";
    $resultAce = $conn->query($updateAce);
    $_SESSION['activeAce'] = 1;
}

//Operadora
if (!empty($_POST['id_operadora'])) {
    $updateOp = "UPDATE manager_dropoperadora SET nome = '" . $_POST['name_operadora'] . "' WHERE (id_operadora = '".$_POST['id_operadora']."')";
    $resultOp = $conn->query($updateOp);
    $_SESSION['activeOp'] = 1;
}

//Status Equipamento
if (!empty($_POST['id_status'])) {
    $updateStEquip = "UPDATE manager_dropstatusequipamento SET nome = '" . $_POST['name_status_equipamento'] . "' WHERE (id_status = '".$_POST['id_status']."')";
    $resultStEquip = $conn->query($updateStEquip);
    $_SESSION['activeStEquip'] = 1;
}

//Office
if (!empty($_POST['id_office'])) {
    $updateOf = "UPDATE manager_dropoffice SET nome = '" . $_POST['name_office'] . "' WHERE (id = '".$_POST['id_office']."')";
    $resultOf = $conn->query($updateOf);
    $_SESSION['activeOf'] = 1;
}

//Sistema Operacional
if (!empty($_POST['id_windows'])) {
    $updateOs = "UPDATE manager_dropsistemaoperacional SET nome = '" . $_POST['name_windows'] . "' WHERE (id = '".$_POST['id_windows']."')";
    $resultOs = $conn->query($updateOs);
    $_SESSION['activeOs'] = 1;
}

header('location: manager_drop_inventario.php?editado=1');

$conn->close();

?>