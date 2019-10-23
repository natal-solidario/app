$(function() {
    $("#salvar-upload").click(function() {
        if ($("#imagens").val() != "") {
            $("#form-upload").submit();
        }
    });
});
