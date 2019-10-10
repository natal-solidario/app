var base_url = $('#base_url').val();
$(function() {
    
    $("#select-instituicao").select2({
        language: "pt-BR"
    });

    $("#add-instituicao").click(function() {
        var valor = $("#select-instituicao").val().split("-");
        var campanha = valor[0];
        var instituicao = valor[1];

        if (campanha > 0 && instituicao > 0) {
            console.log("Clicou pra add a instituição de id " + instituicao + " na campanha " + campanha);

            window.location.href = base_url + "campanha/add_instituicao/" + campanha + "/" + instituicao;

            console.log(window.location);
            /*$.ajax({
                method: "GET",
                url: "/campanha/add_instituicao/" + campanha + "/" + instituicao
            })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(jqXHR, textStatus) {
                console.log("FAIL", jqXHR, textStatus);
            });*/
        }
    });

});
