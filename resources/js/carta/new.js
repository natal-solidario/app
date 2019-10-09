var finalizado = false;
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

    $('#documento_numero').keyup(function() {
        var valor = $(this).val();
        console.log($(this), valor, valor.length);
        if (valor.length == 14 && finalizado == false) {
            console.log("Terminou de digitar");
            
            $.ajax({
                method: "POST",
                url: "/responsavel/get_responsavel",
                data: {
                    etapa: 1,
                    cpf: valor,
                }
            })
            .done(function(data) {
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
                        }
                    });
                    $(".segunda-validacao").prop("disabled", false);
                }
                else {
                    responsavel_id = data.id;
                    // alert("CPF encontrado na base de dados, por favor confirme os dados e atualize, caso necessário.");
                    var niver = data.data_nascimento.split("-");
                    $("#nome").val(data.nome);
                    $("#data_nascimento").val(niver[2] + "/" + niver[1] + "/" + niver[0]);
                    $("#cep").val(data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3));
                    $("#endereco").val(data.endereco);
                    $("#numero").val(data.numero);
                    $("#complemento").val(data.complemento);
                    $("#cidade").val(data.cidade);
                    $("#bairro").val(data.bairro);
                    $("#uf").val(data.uf);

                    $(".demais-campos").prop("disabled", false);
                    $(".segunda-validacao").prop("disabled", false);

                    getBeneficiados(responsavel_id);
                }
                finalizado = true;
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });
        }
    });

    $('#data_nascimento').keyup(function() {
        var data = $(this).val();
        var nome = $("#nome").val();

        if (nome.trim().length > 0 && data.length == 10) {
            console.log("Terminou de digitar");
            
            $.ajax({
                method: "POST",
                url: "/responsavel/get_responsavel/",
                data: {
                    nome: nome,
                    data_nascimento: data,
                    etapa: 2
                }
            })
            .done(function(data) {
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
                }
                else {
                    responsavel_id = data.id;
                    var niver = data.data_nascimento.split("-");
                    $("#nome").val(data.nome);
                    $("#data_nascimento").val(niver[2] + "/" + niver[1] + "/" + niver[0]);
                    $("#cep").val(data.cep.substr(0, 5) + "-" + data.cep.substr(5, 3));
                    $("#endereco").val(data.endereco);
                    $("#numero").val(data.numero);
                    $("#complemento").val(data.complemento);
                    $("#cidade").val(data.cidade);
                    $("#bairro").val(data.bairro);
                    $("#uf").val(data.uf);

                    $(".demais-campos").prop("disabled", false);
                    $(".segunda-validacao").prop("disabled", false);

                    getBeneficiados(responsavel_id);
                }
                finalizado = true;
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
        }
        else if (valor != "")
        {
            var dArr = $("#select_beneficiado option:selected").data("nascimento").split("-");
            $("#form-add-beneficiado").show();
            $("#nome_beneficiado").val($("#select_beneficiado option:selected").text());
            $("#data_nascimento_beneficiado").val(dArr[2] + "/" + dArr[1] + "/" + dArr[0]);
        }
        else
        {
            $("#form-add-beneficiado").hide();
            $("#nome_beneficiado").val("");
            $("#data_nascimento_beneficiado").val("");
        }
    });
});

var getBeneficiados = function($id) {
    $.ajax({
        method: "POST",
        url: "/beneficiado/get_beneficiados/",
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
                $("#select_beneficiado").append("<option value=\"" + obj.id + "\" data-nascimento=\"" + obj.data_nascimento + "\">" + obj.nome + "</option>");
            });
            $("#select_beneficiado").append("<option value=\"outro\">Outro Beneficiado</option>");
        }
        else {
            $("#select-beneficiado").hide();
            $("#form-add-beneficiado").show();
        }
    })
    .fail(function(jqXHR, textStatus) {
        console.log("FAIL", jqXHR, textStatus);
    });
}