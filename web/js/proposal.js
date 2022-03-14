$(function () {
  $('.list-shipping').on('click', function () {
      var id = $(this).data('seller');
      $('#'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Carregando...');
      $.ajax({
          url: "/order/shipping?seller=" + id,
          dataType: "json"
      }).done(function (data) {
        var optionsValues = '<h5>Opções de Fretes:</h5>';
        if (data.JadLog != 'undefined') {          
          $.each(data.JadLog, function () {
            optionsValues += '<div class="form-check"><label class="form-check-label">'
            optionsValues += '<input id="' + this.label + '" class="shipping-select form-check-input" type="radio" name="shipping_'+id+'" value="' + this.label + '" data-name="' + this.label + '" data-price="' + this.vltotal + '"  data-deadline="' + this.prazo + '" data-seller="' + id + '">';
            optionsValues += '<span class="ml-2" for="'+ this.label +'">' + this.label + '</span>';
            optionsValues += ' | ' + this.preco;
            optionsValues += ' | PRAZO: ' + this.prazo + ' dias</div></div>';
          });
        }

        if (data.Correios != 'undefined') {
          $.each(data.Correios, function () {
            optionsValues += '<div class="form-check"><label class="form-check-label">'
            optionsValues += '<input id="' + this.label + '" class="shipping-select form-check-input" type="radio" name="shipping_'+id+'" value="' + this.label + '" data-name="Correios - ' + this.label + '" data-price="' + this.vltotal + '"  data-deadline="' + this.prazo + '" data-seller="' + id + '">';
            optionsValues += '<span class="ml-2" for="'+ this.label +'"> Correios - ' + this.label + '</span>';
            optionsValues += ' | ' + this.preco;
            optionsValues += ' | PRAZO: ' + this.prazo + ' dias</div></div>';
          });          
        }

        if (data.Balcao != 'undefined') {
          $.each(data.Balcao, function () {
            optionsValues += '<div class="form-check"><label class="form-check-label">'
            optionsValues += '<input id="' + this.label + '" class="shipping-select form-check-input" type="radio" name="shipping_'+id+'" value="' + this.label + '" data-name="Correios - ' + this.label + '" data-price="' + this.vltotal + '"  data-deadline="' + this.prazo + '" data-seller="' + id + '">';
            optionsValues += '<span class="ml-2" for="'+ this.label +'"> ' + this.label + '</span>';
            optionsValues += ' | ' + this.preco;
            optionsValues += ' | PRAZO: ' + this.prazo + '</div></div>';
          });          
        }

        var select = $('#'+id);
        select.empty().append(optionsValues);
        return true;
      });
  });

  $(document).on('change', '.shipping-select', function (){
    var shipping = parseFloat($(this).data('price'));
    var id = $(this).data('seller');
    var price = parseFloat($('#price_'+id).val());
    var total = price + shipping;
    var html = '';

    totalStr = total.toLocaleString('pt-BR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });

    html += '<div class="col-lg-12 text-center"><strong>TOTAL COM FRETE: R$ ' + totalStr +'</strong></div>';
    html += '<div class="col-lg-12"><button type="submit" class="btn btn-primary mt-4 col-lg-12 rounded">COMPRAR</button>';
    $('#buy-'+$(this).parents('td').attr('id')).empty().append(html);
  });
});
