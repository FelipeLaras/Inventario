//CELULAR
$("#tipo_equipamento").change(
    function() {
        $('#celular').hide();
        if (this.value == "1") {
            $('#celular').show();
        }
    }
);
//CHIP
$("#tipo_equipamento").change(
    function() {
        $('#chip').hide();
        if (this.value == "3") {
            $('#chip').show();
        }
    }
);
//CPU
$("#tipo_equipamento").change(
    function() {
        $('#cpu').hide();
        if (this.value == "8") {
            $('#cpu').show();
        }
    }
);
//MODEM
$("#tipo_equipamento").change(
    function() {
        $('#moden').hide();
        if (this.value == "4") {
            $('#moden').show();
        }
    }
);
//NOTEBOOK
$("#tipo_equipamento").change(
    function() {
        $('#notebook').hide();
        if (this.value == "9") {
            $('#notebook').show();
        }
    }
);
//RAMAL IP
$("#tipo_equipamento").change(
    function() {
        $('#ramal').hide();
        if (this.value == "5") {
            $('#ramal').show();
        }
    }
);
//SCANNER
$("#tipo_equipamento").change(
    function() {
        $('#scanner').hide();
        if (this.value == "10") {
            $('#scanner').show();
        }
    }
);
//TABLET
$("#tipo_equipamento").change(
    function() {
        $('#tablet').hide();
        if (this.value == "2") {
            $('#tablet').show();
        }
    }
);