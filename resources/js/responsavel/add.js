var finalizado = false;
$(function() {
    $('#documento_numero').mask('000.000.000-00', {reverse: true});
    $('#cep').mask('00000-000');
    $('#data_nascimento').mask('00/00/0000');
    if ($("#nome").val() == "") {
        $(".demais-campos").prop("disabled", true);
        $(".segunda-validacao").prop("disabled", true);
    }

    $('#documento_numero').keydown(function(e) {
        var valor = $(this).val();
        if (e.which == 9 && valor.length == 14) {
            getDadosByCPF(valor);
        }
    });

    $('#documento_numero').keyup(function(e) {
        var valor = $(this).val();
        if (valor.length < 14) { resetarForm(); $("#enter-cpf").show(); }
        if (e.which == 13 && valor.length == 14) {
            getDadosByCPF(valor);
        }
    });


    $('#data_nascimento').keydown(function(e) {
        var data = $(this).val();
        var nome = $("#nome").val();

        if ((e.which == 13 || e.which == 9) && data.length == 10) {
            if (nome.trim().length == 0) {
                Swal.fire({
                    title: 'Favor preencher o nome do responsável.',
                    text: '',
                    type: 'info',
                    onAfterClose: () => {
                        $("#nome").focus();
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
                        $("#select_beneficiado").val("outro");
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
        }
    });

    $("#salvar-responsavel").click(function() {
        $("#form-responsavel").submit();
    });

});

var resetarForm = function() {
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

var getDadosByCPF = function(valor) {
    resetarForm();
    
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
            if (data.status == 'error') {
                Swal.fire({
                    title: data.message,
                    text: '',
                    type: 'error',
                    onAfterClose: () => {
                        $("#cpf").focus();
                    }
                });
                return;
            }

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
        }
    })
    .fail(function(jqXHR, textStatus) {
        console.log("FAIL", jqXHR, textStatus);
    });
}