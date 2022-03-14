jQuery(document).ready(function () {

    /*
     * Atualiza a lista de marcas
     */
    $('#orderform-category_id').on('change', function () {
        var id = $(this).val();
        getBrands(id);
    });

    $('.add-item').on('click', function () {
        var html = $('#item');
        var qtd = $('.pecas').length;

        $(html).find("input").each(function(){
            $(this).attr("name", $(this).attr("name").replace(/\d+/, qtd));
        });
        $(html).find("select").each(function(){
            $(this).attr("name", $(this).attr("name").replace(/\d+/, qtd));
        });

        $(html).find("textarea").each(function(){
            $(this).attr("name", $(this).attr("name").replace(/\d+/, qtd));
        });

        $('.list-pecas').append('<div class="bg-light rounded p-4 mb-4"><div id="item-'+ qtd +'" class="row pecas"></div></div>')
        $(html.html()).appendTo('#item-'+qtd);
    });

    $(document).on('click', '.del-item', function () {
        $(this).parent().parent().parent().remove();
    })
});
/*
 * Retorna a lista de marcas
 */
window.getBrands = function(id) {
    $.ajax({
        url: "order/brands?category=" + id,
        dataType: "json"
    }).done(function (data) {
        if (data.length > 0) {
            var optionsValues = '';
            $.each(data, function () {
                optionsValues += '<option value="' + this.id + '">' + this.name + '</option>';
            });
            var select = $('#orderform-brand_id');
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
    $('#profile-' + name ).val(value);
}
