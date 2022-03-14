jQuery(document).ready(function () {

    /*
     * Busca a lista de fretes
     */
    $('#getShipping').on('click', function () {
        var id = $(this).val();
        getShipping(id);
    });

    $(document).on('click', '.shipping-select', function() {
        $('#statusseller-deadline').val($(this).data('deadline'))
    })
});
/*
 * Retorna a lista de marcas
 */
window.getShipping = function(id) {

    var height = $('#statusseller-height').val(),
        width = $('#statusseller-width').val(),
        lenght = $('#statusseller-lenght').val(),
        weight = $('#statusseller-weight').val();    

    $.ajax({
        url: "/admin/order/shipping",
        data: {id: id, height: height, width: width, lenght: lenght, weight: weight},
        dataType: "json"
    }).done(function (data) {

        console.log(data);
        if (data.JadLog != 'undefined') {
            var optionsValues = '<h5>Lista de Fretes</h5><div class="row">';
            $.each(data.JadLog, function () {
                optionsValues += '<div class="col-md-4 col-sx-1 mb-3"><input id="' + this.label + '" class="shipping-select" type="radio" name="StatusSeller[shipping]" value="' + this.label + '" data-name="' + this.label + '" data-price="' + this.vltotal + '"  data-deadline="' + this.prazo + '">';
                optionsValues += '<span class="ml-2" for="'+ this.label +'">' + this.label + '</span>';
                optionsValues += '<div class="ml-4">' + this.preco + '</div>';
                optionsValues += '<div class="ml-4">Prazo ' + this.prazo + ' dias</div></div>';
            });

            $.each(data.Correios, function () {
                optionsValues += '<div class="col-md-4 col-sx-1"><input id="' + this.label + '" class="shipping-select" type="radio" name="StatusSeller[shipping]" value="' + this.label + '" data-name="Correios - ' + this.label + '" data-price="' + this.vltotal + '"  data-deadline="' + this.prazo + '">';
                optionsValues += '<span class="ml-2" for="'+ this.label +'"> Correios - ' + this.label + '</span>';
                optionsValues += '<div class="ml-4">' + this.preco + '</div>';
                optionsValues += '<div class="ml-4">Prazo ' + this.prazo + ' dias</div></div>';
            });
            optionsValues += '</div>';
            var select = $('#list-shipping');
            select.empty().append(optionsValues);
            return true;
        }
    });
    return false;
}

