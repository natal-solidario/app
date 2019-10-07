$(function(){
    $('#NU_CEP').mask('00000-000');
    $('#NU_CNPJ').mask('00.000.000/0000-00', {reverse: true});
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
    $('#DE_TELEFONE').mask(SPMaskBehavior, spOptions);
    console.log("TESTE");
});



