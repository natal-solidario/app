var base_url = $('#base_url').val();
var finalizado = false;
$(function() {
    $('#documento_numero').mask('000.000.000-00', {reverse: true});
    $('#cep').mask('00000-000');
    $('#data_nascimento').mask('00/00/0000');
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
                }
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });
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