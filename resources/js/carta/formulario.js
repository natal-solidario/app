var responsavel2_id;
$(function() {
    $(".obrigatorio-resp2").hide();
    if ($("#responsavel2_id").val() != "") {
        $(".obrigatorio-resp2").show();
    }
    $('#responsavel1NumeroDocumento').mask('000.000.000-00', {reverse: true});
    $('#responsavel2NumeroDocumento').mask('000.000.000-00', {reverse: true});
    
    $('#responsavel1Cep').mask('00000-000');
    $('#responsavel2Cep').mask('00000-000');
    
    $('#dataNascimento').mask('00/00/0000');
    $('#responsavel1DataNascimento').mask('00/00/0000');
    $('#responsavel2DataNascimento').mask('00/00/0000');

    // $('input[name ="preferencial"]').change(function() { console.log($(this).val()) });

    $("#mesmoEndereco").click(function() {
        if($(this).prop("checked")) {
            $("#responsavel2Endereco").val($("#responsavel1Endereco").val());
            $("#responsavel2Numero").val($("#responsavel1Numero").val());
            $("#responsavel2Complemento").val($("#responsavel1Complemento").val());
            $("#responsavel2Bairro").val($("#responsavel1Bairro").val());
            $("#responsavel2Cidade").val($("#responsavel1Cidade").val());
            $("#responsavel2UF").val($("#responsavel1UF").val());
            $("#responsavel2Cep").val($("#responsavel1Cep").val());
        }
        else {
            $("#responsavel2Endereco").val("");
            $("#responsavel2Numero").val("");
            $("#responsavel2Complemento").val("");
            $("#responsavel2Bairro").val("");
            $("#responsavel2Cidade").val("");
            $("#responsavel2UF").val("");
            $("#responsavel2Cep").val("");
        }
    });

    $('#responsavel2NumeroDocumento').blur(function(e) {
        var valor = $(this).val();
        if (valor.length > 0) {
            $(".obrigatorio-resp2").show();
        }
        else {
            if ($('#responsavel2NumeroDocumento').val() == "" && $('#responsavel2Nome').val() == "" && $('#responsavel2DataNascimento').val() == "")
            $(".obrigatorio-resp2").hide();
        }
        if (valor.length == 14) {
            if ($("#responsavel2_id").val() == "") {
                getDadosByCPF(valor);
            }
        }
    });

    $('#responsavel2Nome').blur(function(e) {
        var valor = $(this).val();
        if (valor.length > 0) {
            $(".obrigatorio-resp2").show();
        }
        else {
            if ($('#responsavel2NumeroDocumento').val() == "" && $('#responsavel2Nome').val() == "" && $('#responsavel2DataNascimento').val() == "")
            $(".obrigatorio-resp2").hide();
        }
    });
    
    $('#responsavel2DataNascimento').blur(function(e) {
        var data = $('#responsavel2DataNascimento').val();
        var nome = $("#responsavel2Nome").val();

        console.log(data.length, $("#responsavel2_id").val());
        
        if (data.length > 0 || nome.length > 0) {
            $(".obrigatorio-resp2").show();
        }
        else {
            if ($('#responsavel2NumeroDocumento').val() == "" && $('#responsavel2Nome').val() == "" && $('#responsavel2DataNascimento').val() == "")
            $(".obrigatorio-resp2").hide();
        }
        if (data.length == 10 && $("#responsavel2_id").val() == "") {
            if (nome.trim().length == 0) {
                Swal.fire({
                    title: 'Favor preencher o nome do responsável 2.',
                    text: '',
                    type: 'info',
                    onAfterClose: () => {
                        $("#responsavel2Nome").focus();
                    }
                });
                return;
            }
            else {
                $.ajax({
                    method: "POST",
                    url: base_url + "responsavel/get_responsavel/",
                    data: {
                        nome: nome,
                        data_nascimento: data,
                        etapa: 2
                    }
                })
                .done(function(data) {
                    data = JSON.parse(data);
                    console.log("DONE", data);
                    responsavel2_id = data.id;
                    $("#responsavel2_id").val(responsavel2_id);
                    $("#responsavel2Cep").val(data.cep > 0 ? data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3) : "");
                    $("#responsavel2Endereco").val(data.endereco);
                    $("#responsavel2Numero").val(data.numero);
                    $("#responsavel2Complemento").val(data.complemento);
                    $("#responsavel2Cidade").val(data.cidade);
                    $("#responsavel2Bairro").val(data.bairro);
                    $("#responsavel2UF").val(data.uf);
                    $("#responsavel2Email").val(data.email);
                    $("#responsavel2Telefone").val(data.telefone);
                    $("#responsavel2TelefoneOperadora").val(data.telefone_operadora);
                    $('input:radio[name="responsavel2TelefoneWhatsapp"]').filter('[value="'+data.telefone_whatsapp+'"]').attr('checked', true);
                    $("#responsavel2NumeroDocumento").val(data.documento_numero);
                    $("#responsavel2Ocupacao").val(data.ocupacao);
                    $("#responsavel2Escolaridade").val(data.escolaridade);
                })
                .fail(function(jqXHR, textStatus) {
                    console.log("FAIL", jqXHR, textStatus);
                });
            }   
        }
    });

    $("#salvar-formulario").click(function() {
        $("#form-formulario").submit();
    });
});

var getDadosByCPF = function(valor) {
    $.ajax({
        method: "POST",
        url: base_url + "responsavel/get_responsavel",
        data: {
            etapa: 1,
            cpf: valor,
        }
    })
    .done(function(data) {
        data = JSON.parse(data);
        console.log("DONE", data);
        responsavel2_id = data.id;
        var niver = data.data_nascimento.split("-");
        $("#responsavel2_id").val(responsavel2_id);
        $("#responsavel2Cep").val(data.cep > 0 ? data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3) : "");
        $("#responsavel2Nome").val(data.nome.trim());
        $("#responsavel2DataNascimento").val(niver[2] + "/" + niver[1] + "/" + niver[0]);
        $("#responsavel2Endereco").val(data.endereco);
        $("#responsavel2Numero").val(data.numero);
        $("#responsavel2Complemento").val(data.complemento);
        $("#responsavel2Cidade").val(data.cidade);
        $("#responsavel2Bairro").val(data.bairro);
        $("#responsavel2Email").val(data.email);
        $("#responsavel2Telefone").val(data.telefone);
        $("#responsavel2TelefoneOperadora").val(data.telefone_operadora);
        $('input:radio[name="responsavel2TelefoneWhatsapp"]').filter('[value="'+data.telefone_whatsapp+'"]').attr('checked', true);
        $("#responsavel2UF").val(data.uf);
        $("#responsavel2NumeroDocumento").val(data.documento_numero);
        $("#responsavel2Ocupacao").val(data.ocupacao);
        $("#responsavel2Escolaridade").val(data.escolaridade);
    })
    .fail(function(jqXHR, textStatus) {
        console.log("FAIL", jqXHR, textStatus);
    });
}


var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

$('.telefone').mask(SPMaskBehavior, spOptions);