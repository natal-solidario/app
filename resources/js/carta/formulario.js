$(function() {

    $('#responsavel1NumeroDocumento').mask('000.000.000-00', {reverse: true});
    $('#responsavel2NumeroDocumento').mask('000.000.000-00', {reverse: true});
    
    $('#responsavel1Cep').mask('00000-000');
    $('#responsavel2Cep').mask('00000-000');
    
    $('#dataNascimento').mask('00/00/0000');
    $('#responsavel1DataNascimento').mask('00/00/0000');
    $('#responsavel2DataNascimento').mask('00/00/0000');

    $("#mesmoEndereco").click(function() {
        $("#responsavel2Endereco").val($("#responsavel1Endereco").val());
        $("#responsavel2Complemento").val($("#responsavel1Complemento").val());
        $("#responsavel2Bairro").val($("#responsavel1Bairro").val());
        $("#responsavel2Cidade").val($("#responsavel1Cidade").val());
        $("#responsavel2UF").val($("#responsavel1UF").val());
        $("#responsavel2Cep").val($("#responsavel1Cep").val());
    });

});