var base_url = $('#base_url').val();
var responsavel_id;
$(function() {
    $('#documento_numero').mask('000.000.000-00', {reverse: true});
    $('#cep').mask('00000-000');
    $('#data_nascimento').mask('00/00/0000');
    $('#data_nascimento_beneficiado').mask('00/00/0000');
    if ($("#nome").val() == "") {
        $(".demais-campos").prop("disabled", true);
        $(".segunda-validacao").prop("disabled", true);
    }

    $('#documento_numero').keyup(function(e) {
        var valor = $(this).val();
        console.log($(this), valor, valor.length);
        if (valor.length < 14) { resetarForm(); $("#enter-cpf").show(); }
        if (e.which == 13 && valor.length == 14) {
            resetarForm();
            console.log("Terminou de digitar");
            
            $.ajax({
                method: "POST",
                url: base_url + "responsavel/get_responsavel",
                data: {
                    etapa: 1,
                    cpf: valor,
                }
            })
            .done(function(data) {
                $("#enter-cpf").hide();
                data = JSON.parse(data);
                console.log("DONE", data);
                if (data == null)
                {
                    Swal.fire({
                        title: 'CPF não encontrado na base de dados, por favor preencha o nome e a data de nascimento.',
                        text: '',
                        type: 'info',
                        onAfterClose: () => {
                            $("#nome").focus();
                            $("#enter-data").show();
                        }
                    });
                    $(".segunda-validacao").prop("disabled", false);
                }
                else {
                    $("#metodo_busca").val("1");
                    responsavel_id = data.id;
                    // alert("CPF encontrado na base de dados, por favor confirme os dados e atualize, caso necessário.");
                    var niver = data.data_nascimento.split("-");
                    $("#nome").val(data.nome);
                    $("#data_nascimento").val(niver[2] + "/" + niver[1] + "/" + niver[0]);
                    $("#cep").val(data.cep > 0 ? data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3) : "");
                    $("#endereco").val(data.endereco);
                    $("#numero").val(data.numero);
                    $("#complemento").val(data.complemento);
                    $("#cidade").val(data.cidade);
                    $("#bairro").val(data.bairro);
                    $("#uf").val(data.uf);
                    $("#responsavel_id").val(responsavel_id);

                    $(".demais-campos").prop("disabled", false);
                    $(".segunda-validacao").prop("disabled", false);

                    getBeneficiados(responsavel_id);
                }
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });
        }
    });

    $('#data_nascimento').keyup(function(e) {
        var data = $(this).val();
        var nome = $("#nome").val();

        if (e.which == 13 && nome.trim().length > 0 && data.length == 10) {
            console.log("Terminou de digitar");
            
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
                $("#enter-data").hide();
                data = JSON.parse(data);
                console.log("DONE", data);
                if (data == null)
                {
                    Swal.fire({
                        title: 'Responsável não consta em nossa base de dados, por favor prossiga com o preenchimento dos demais campos.',
                        text: '',
                        type: 'info',
                        onAfterClose: () => {
                            $("#cep").focus();
                        }
                    });
                    $(".demais-campos").prop("disabled", false);
                    $("#form-add-beneficiado").show();
                    $("#select-beneficiado").hide();
                    $("#metodo_busca").val("0");
                }
                else {
                    $("#metodo_busca").val("2");
                    responsavel_id = data.id;
                    var niver = data.data_nascimento.split("-");
                    $("#nome").val(data.nome);
                    $("#data_nascimento").val(niver[2] + "/" + niver[1] + "/" + niver[0]);
                    $("#cep").val(data.cep > 0 ? data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3) : "");
                    $("#endereco").val(data.endereco);
                    $("#numero").val(data.numero);
                    $("#complemento").val(data.complemento);
                    $("#cidade").val(data.cidade);
                    $("#bairro").val(data.bairro);
                    $("#uf").val(data.uf);
                    $("#responsavel_id").val(responsavel_id);

                    $(".demais-campos").prop("disabled", false);
                    $(".segunda-validacao").prop("disabled", false);

                    getBeneficiados(responsavel_id);
                }
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });
        }
    });

    $("#select_beneficiado").change(function() {
        var valor = $(this).val();
        if (valor == "outro")
        {
            $("#form-add-beneficiado").show();
            $("#nome_beneficiado").val("");
            $("#data_nascimento_beneficiado").val("");
            $("#sexo_beneficiado").val("");
        }
        else if (valor != "")
        {
            var dArr = $("#select_beneficiado option:selected").data("nascimento").split("-");
            $("#form-add-beneficiado").show();
            $("#nome_beneficiado").val($("#select_beneficiado option:selected").text());
            $("#data_nascimento_beneficiado").val(dArr[2] + "/" + dArr[1] + "/" + dArr[0]);
            $("#sexo_beneficiado").val($("#select_beneficiado option:selected").data("sexo"));
        }
        else
        {
            $("#form-add-beneficiado").hide();
            $("#nome_beneficiado").val("");
            $("#data_nascimento_beneficiado").val("");
            $("#sexo_beneficiado").val("");
        }
    });

    $("#salvar-carta").click(function() {
        $("#form-carta").submit();
    });
});

var getBeneficiados = function($id) {
    $.ajax({
        method: "POST",
        url: base_url + "beneficiado/get_beneficiados/",
        data: {
            responsavel: responsavel_id,
        }
    })
    .done(function(data) {
        data = JSON.parse(data);
        console.log("DONE", data);
        if (data.length > 0) {
            $("#select_beneficiado").html("");
            $("#select_beneficiado").append("<option value=\"\">Selecione</option>");
            $.each(data, function(idx, obj) {
                $("#select_beneficiado").append("<option value=\"" + obj.id + "\" data-nascimento=\"" + obj.data_nascimento + "\" data-sexo=\"" + (obj.sexo != null ? obj.sexo.substr(0,1) : "") + "\">" + obj.nome + "</option>");
            });
            $("#select_beneficiado").append("<option value=\"outro\">Outro Beneficiado</option>");
        }
        else {
            $("#select-beneficiado").hide();
            $("#select_beneficiado").val('outro');
            $("#form-add-beneficiado").show();
        }
    })
    .fail(function(jqXHR, textStatus) {
        console.log("FAIL", jqXHR, textStatus);
    });
}


var resetarForm = function() {
    $("#select_beneficiado").val("");
    $("#select-beneficiado").show();
    $("#form-add-beneficiado").hide();
    $("#nome_beneficiado").val("");
    $("#data_nascimento_beneficiado").val("");
    $("#sexo_beneficiado").val("");
    $("#nome").val("");
    $("#data_nascimento").val("");
    $("#cep").val("");
    $("#endereco").val("");
    $("#numero").val("");
    $("#complemento").val("");
    $("#cidade").val("");
    $("#bairro").val("");
    $("#uf").val("");
    $("#responsavel_id").val("");
    $("#metodo_busca").val("");
    $(".demais-campos").prop("disabled", true);
    $(".segunda-validacao").prop("disabled", true);
    $("#enter-cpf").show();
    $("#enter-data").hide();
}