
//Buscar CPF no maneger e Patrimonio no Inventario
(function() {

    var $gols1 = document.getElementById('gols1');

    function handleSubmit() {
        if ($gols1.value){
            var $cpf_validacao = document.getElementById('cpf_validacao');
            if ($cpf_validacao.value)
            document.getElementById('form2');
            $cpf_validacao.value = $gols1.value;
            document.getElementById('form2').submit();
        }    
    }
    $gols1.addEventListener('blur', handleSubmit);
})();

//Buscar CPU
(function() {

    var $gols2 = document.getElementById('gols2');

    function handleSubmit() {
        if ($gols2.value){
            var $cpu_validacao = document.getElementById('cpu_validacao');
            if ($cpu_validacao.value)
            document.getElementById('form1');
            $cpu_validacao.value = $gols2.value;
            document.getElementById('form1').submit();
        }    
    }
    $gols2.addEventListener('blur', handleSubmit);
})();

//Buscar NOTEBOOK
(function() {

    var $gols3 = document.getElementById('gols3');

    function handleSubmit() {
        if ($gols3.value){
            var $notebook_validacao = document.getElementById('notebook_validacao');
            if ($notebook_validacao.value)
            document.getElementById('form1');
            $notebook_validacao.value = $gols3.value;
            document.getElementById('form1').submit();
        }    
    }
    $gols3.addEventListener('blur', handleSubmit);
})();