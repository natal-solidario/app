var habilitar_acoes = false;
$(function() {
    $(".selecionar-todas").click(function() {
        if ($(this).is(":checked")) {
            $(".selecao").each(function(idx, obj) {
                if (!$(obj).is(":disabled")) {
                    $(obj).prop('checked', true);
                    habilitar_acoes = true;
                }
            });
        }
        else {
            $(".selecao").each(function(idx, obj) {
                $(obj).prop('checked', false);
            });
            habilitar_acoes = false;
        }

        habilitarAcoes(habilitar_acoes);
    });

    $(".selecao").click(function() {
        if ($(this).is(":checked")) {
            $(this).prop('checked', true);
            habilitar_acoes = true;
        }
        else {
            $(this).prop('checked', false);
            habilitar_acoes = false;
            $(".selecao").each(function(idx, obj) {
                if ($(obj).is(":checked")) {
                    habilitar_acoes = true;
                }
            });
        }

        habilitarAcoes(habilitar_acoes);
    });

    $("#aplicar-acao").click(function() {
        if ($("#carteiro").val() == "" && $("#mobilizador").val() == "") {
            Swal.fire({
                title: 'Favor selecionar um Carteiro e/ou Mobilizador nos campos ao lado para atribuir à(s) carta(s) selecionada(s).',
                text: '',
                type: 'info',
                onAfterClose: () => {
                    $("#carteiro").click();
                }
            });
            return;
        }
        else {
            var data = [];
            $(".selecao").each(function(idx, obj) {
                if ($(obj).is(":checked")) {
                    data.push({
                        carta: $(obj).data("carta"),
                        carteiro: $("#carteiro").val(),
                        mobilizador: $("#mobilizador").val()
                    });
                }
            });

            $.ajax({
                method: "POST",
                url: base_url + "carta/atribuir_carteiro_mobilizador/",
                data: { cartas: data }
            })
            .done(function(data) {
                // data = JSON.parse(data);
                console.log("DONE", data);
                location.reload();
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });
        }
    });

    $(".ordenar").click(function() {
        console.log($(this).data());

        $("#ordem").val($(this).data("coluna"));
        $("#direcao").val($(this).data("direcao"));

        if ($(this).data("direcao") == "asc")
            $(this).data("direcao", "desc");
        else if ($(this).data("direcao") == "desc")
            $(this).data("direcao", "asc");

        $("#myform").submit();
    });
});

var habilitarAcoes = function(habilitar_acoes) {
    console.log("habilitarAcoes", habilitar_acoes);

    if (habilitar_acoes) {
        $(".acoes").prop("disabled", false);
    }
    else {
        $(".acoes").prop("disabled", true);
    }
}


var sendMyForm = function() {
    $(".skin-blue").loading({
        stoppable: false,
        message: 'Por favor aguarde...',
        theme: 'dark',
        zIndex: 9999
    });
    $("#myform").submit();
}


