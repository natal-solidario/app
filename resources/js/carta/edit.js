$(function() {
    $('#documento_numero').mask('000.000.000-00', {reverse: true});
    $('#cep').mask('00000-000');
    $('#data_nascimento').mask('00/00/0000');
    $('#data_nascimento_beneficiado').mask('00/00/0000');
    
    $("#salvar-carta").click(function() {
        $("#form-carta").submit();
    });
});