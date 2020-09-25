<?php
require_once('conexao.php');




//tipo de equipamento
$query_equip = "SELECT * FROM manager_dropequipamentos WHERE deletar = 0 ORDER BY nome ASC";
$resultado_equip = $conn -> query($query_equip);

//funcao
$query_funcao = "SELECT * FROM manager_dropfuncao WHERE deletar = 0 ORDER BY nome ASC";
$resultado_funcao = $conn -> query($query_funcao);

//departamento
$query_depart = "SELECT * FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";
$resultado_depart = $conn -> query($query_depart);

//empresa ou locacao
$query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
$resultado_empresa = $conn -> query($query_empresa);

//status
$query_statusFun = "SELECT * FROM manager_dropstatus WHERE deletar = 0 ORDER BY nome ASC";
$resultado_statusFun = $conn -> query($query_statusFun);

//localização
$query_locacao = "SELECT * FROM manager_droplocacao WHERE deletar = 0 ORDER BY nome ASC";
$resultado_locacao = $conn -> query($query_locacao);

//situação "Alugado ou comprado"
$query_situacao = "SELECT * FROM manager_dropsituacao WHERE deletar = 0 ORDER BY nome ASC";
$resultado_situacao = $conn -> query($query_situacao);

//office
$query_office = "SELECT * FROM manager_dropoffice WHERE deletar = 0 ORDER BY nome ASC";
$resultado_office = $conn -> query($query_office );

//sistma operacional
$query_so = "SELECT * FROM manager_dropsistemaoperacional WHERE deletar = 0 ORDER BY nome ASC";
$resultado_so = $conn -> query($query_so);

//estado "Novo ou Usado"
$query_status = "SELECT * FROM manager_dropestado WHERE deletar = 0 ORDER BY nome ASC";
$resultado_status = $conn->query($query_status);

//acessorios
$query_acessorio = "SELECT * FROM manager_dropacessorios WHERE deletar = 0 ORDER BY nome ASC";
$resultado_acessorio = $conn->query($query_acessorio);

//operadora
$query_operadora = "SELECT * FROM manager_dropoperadora WHERE deletar = 0 ORDER BY nome ASC";
$resultado_operadora = $conn->query($query_operadora);

//status equipamento
$query_status_equip= "SELECT * FROM manager_dropstatusequipamento WHERE deletar = 0 ORDER BY nome ASC";
$resultado_status_equip = $conn->query($query_status_equip);

//perfil usuário
$query_perfil = "SELECT * FROM manager_profile_type ORDER BY type_name ASC";
$resultado_perfil = $conn->query($query_perfil);
?>