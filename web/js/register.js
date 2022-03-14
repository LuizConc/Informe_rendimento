jQuery(document).ready(function () {

    /*
     * Busca o CEP
     */
    var cep = $('#cepInput');
    var cepInput = $('#cepInput');
    var cepError = $('.field-cepInput .text-danger');
    $('#cepInput').on('change', function () {
        $('#registerform-cep, #addressform-cep').val($(this).val());
    });
    $('#cepBuscar').on('click', function () {
        $.ajax({
            url: "/admin/default/cep?n=" + cep.val(),
            dataType: "json"
        }).done(function (data) {
        	console.log(data);
            if (data.erro) {
                cepError.show();
                cepError.text('CEP inválido.');
            } else {
                cepError.hide();
                cepInput.val(data.cep);
                setAddressInput('cep', data.cep);
                setAddressInput('street', data.logradouro);
                setAddressInput('district', data.bairro);
                //setAddressInput('city', data.localidade);
                setAddressInput('state', data.uf);
                setAddressInput('ibge', data.ibge);
                getCities(data.uf, data.ibge);
            }
        });
    });

    /*
     * Atualiza a lista de cidades
     */
    $('#userprofile-state').on('change', function () {
        var uf = $(this).val();
        getCities(uf);
    });
});
/*
 * Retorna a lista de cidades
 */
window.getCities = function(uf, city) {
    $.ajax({
        url: "/admin/default/cidades?uf=" + uf,
        dataType: "json"
    }).done(function (data) {
        if (data.length > 0) {
            var optionsValues = '';
            $.each(data, function () {
                if (city && city == this.id) {
                    optionsValues += '<option value="' + this.id + '" selected>' + this.name + '</option>';
                } else {
                    optionsValues += '<option value="' + this.id + '">' + this.name + '</option>';
                }
            });
            var select = $('#userprofile-city');
            select.empty().append(optionsValues);
            select.prop('disabled', false);
            return true;
        }
    });
    return false;
}

/*
 * define os campos que receberao valores
 */
function setAddressInput(name, value, pessoa) {
    $('#userprofile-' + name ).val(value);
}
