function valEmpty (el,msg) {
  $('.text-danger').remove();
  el.parent().addClass('has-error');
  el.after('<p class="text-danger">'+msg+'</p>');
}
function getRootUrl () {
  return window.location.origin?window.location.origin+'/':window.location.protocol+'/'+window.location.host+'/';
}
function doAddToCart(dataPost) {
  var base = getRootUrl();
  $.ajax({
    url: base+'carphone/public/telefono/agregar-al-carrito',
    type: 'get',
    dataType: 'json',
    data: dataPost,
    beforeSend:function() {
         $('.cd-cart-total').addClass('hidden')
         $('.checkout-btn').addClass('disabled')
         $('.vaciar').addClass('hidden')
    },
    success:function(response)
    {
       $('.cd-cart-total').removeClass('hidden')
       $('.checkout-btn').removeClass('disabled')
       $('.vaciar').removeClass('hidden')
      if (response.type == 'success') {
        toastr.success(response.msg);
      }
      if (response.type == 'warning') {
        toastr.warning(response.msg);
        var row = $('#item_'+dataPost.id+dataPost.color);
        row.children('.cd-qty').html(response.maximo);
        row.children('.cd-price').html(parseInt(dataPost.price)*parseInt(response.maximo));
        calcTotal();
      };
    }
  })
  
}
function calcTotal() {
      var total = 0;
      $('.cartItem').each(function(index, el) {
        if (!isNaN(parseInt($(el).children('.cd-price').html()))) {
          total += parseInt($(el).children('.cd-price').html());
        };
      });
      $('.cd-cart-total').children('p').children('span').html(total)
}
function calcTotalCart() {
  var total = 0;
      $('.cartItem').each(function(index, el) {
        if (typeof $(el).children('.cart_total').children('.cart_total_price').html() != 'undefined') {
          total += parseInt($(el).children('.cart_total').children('.cart_total_price').html().substr(1));
        };
      });
      $('.totalCart').html('$'+total)
}
function updateQty(data) {
  var base = getRootUrl();
    if(typeof xhr != "undefined" && xhr.readyState != 4){
      xhr.abort();
    }
    xhr = $.ajax({
    url: base+'carphone/public/telefono/modificar-cantidad',
    type: 'GET',
    dataType: 'json',
    data: data,
    beforeSend:function() {
      $('.comprarBtn').addClass('disabled');
    },
    success:function(response) {
      $('.comprarBtn').removeClass('disabled');
      if(response.type == "success")
      {
        toastr.success(response.msg);
      }
      if(response.type == 'warning')
      {
        var inp = $('#item_'+data.id+data.color).children('.cart_quantity').children('.cart_quantity_button').children('.cart_quantity_input')
        inp.val(response.maximo);
        toastr.warning(response.msg);
      }
    },
    error:function(xhr, text_status, error_thrown)
    {
      if (text_status != "abort") {
        alert('Lo Sentimos, ha ocurrido un error. por favor ponerse en contacto con el administrador del sitio.');
      };
    }
  })
    return xhr;
}
jQuery(document).ready(function($) {
  var base = getRootUrl();
  $('.login-input').on('focus', function(event) {
          $(this).next('.text-danger').remove();
          $(this).parent().removeClass('has-error');
  });
  $('.login').on('click', function(event) {
          var proceed = 1;
          
          $('.login-input').each(function(index, el) {
              if ($(el).val() == "") {
                valEmpty($(el),'El campo es obligatorio');
                proceed = 0;
              }
          });
          if (proceed == 1) {
              if ($('.checkbox-login:checked').length > 0) {
                      var itsCheck = 1;
              }else
              {
                      var itsCheck = 0;
              }
              $.ajax({
                      url: base+'carphone/public/iniciar-sesion/enviar',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                              username: $('.username').val(),
                              password: $('.password').val(),
                              check   : itsCheck
                      },
                      beforeSend:function() {
                        $('.login').addClass('disabled').after('<img src="http://localhost/carphone/public/images/loader.gif" class="miniLoader">')
                      },
                      success:function (response) {
                              if(response.type == 'success')
                              {
                                $('.responseAjax').addClass('alert-success').html('<p>'+response.msg+'</p>').show('fast',function(){
                                  window.location.reload();
                                  
                                });
                              }
                              if (response.type == 'warning') {
                                      if (response.data.username) {
                                              $('.username').after('<p class="text-danger">'+response.data.username+'</p>').parent().addClass('has-error');
                                      }
                                      if(response.data.password)
                                      {
                                              $('.password').after('<p class="text-danger">'+response.data.password+'</p>').parent().addClass('has-error');
                                      }
                              }else if(response.type == 'danger')
                              {
                                      $('.responseAjax').addClass('alert-danger').html('<p>'+response.msg+'</p>').show('fast');
                                      setTimeout(function() {
                                              $('.responseAjax').hide('fast').removeClass('alert-danger');
                                      },5000)
                              }
                              $('.login').removeClass('disabled');
                              $('.miniLoader').remove();
                      }
              })                      
          };
  });
  $('.register').on('click', function(event) {
    var proceed = 1;
    $('.register-input').each(function(index, el) {
      if ($(el).val() == "") {
        valEmpty($(el),'El campo es obligatorio');
        proceed = 0;
      }
    });
    if ($('.password').val() != $('.password2').val()) {
      valEmpty($('.password2'),'Las contraseñas no concuerdan')
        proceed = 0;

    };
    //Utilizamos una expresion regular
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
 
    //Se utiliza la funcion test() nativa de JavaScript
    if (!regex.test($('.email').val().trim()))
    {
      valEmpty($('.email'),'Formato de email invalido');       
      proceed = 0;
    }
    if (proceed == 1) {
      $('.form-register').submit();

    }
  });
  $('.imgMini').on('mouseenter', function(event) {
    var src = $(this).attr('src');
    $('.imgPrinc').fadeOut('fast', function() {
      $(this).attr('src',src).fadeIn('fast');
    })
  });
  $('.addToCart').on('click',function(event) {
    if ($($(this).data('color')).val() != "") {
      var dataPost = {
        'id'        :$(this).data('id'),
        'name'      :$(this).data('name'),
        'price'     :$(this).data('price'),
        'color'     :$($(this).data('color')).val(),
        'img'       :$(this).data('img'),
        'cod'       :$(this).data('cod'),
        'color_desc': $($($(this).data('color')+' option:selected')).html()
      };
      if ($('#item_'+dataPost.id+dataPost.color).length > 0) {
        var row = $('#item_'+dataPost.id+dataPost.color);
        row.children('.cd-qty').html(parseInt(row.children('.cd-qty').html())+1);
        row.children('.cd-price').html(parseInt(dataPost.price)*parseInt(row.children('.cd-qty').html()));
      }else
      {
        $('.cd-cart-total').removeClass('hidden')
        $('.checkout-btn').removeClass('hidden')
        $('.vaciar').removeClass('hidden')

        $('.no-item-td').remove();
        var cont = $('.cartItem.hidden:last');
        var clon   = cont.clone();
        cont.attr('id','item_'+dataPost.id+dataPost.color);
        cont.removeClass('hidden');
        cont.after(clon)
        clon.addClass('hidden');

        var btnElim = cont.children('td').children('.removeItem').val(dataPost.id).attr('data-target','#item_'+dataPost.id+dataPost.color).attr('data-color',dataPost.color);

        cont.children('.cd-qty').html(1);
        cont.children('.cd-name').html(dataPost.name);
        cont.children('.cd-color').html($($($(this).data('color')+' option:selected')).html());
        cont.children('.cd-price').html(dataPost.price);
        $('.borrarColor').bind('click')
      }

      calcTotal();
      doAddToCart(dataPost);
    }else
    {
      toastr.warning('Debe seleccionar un color')
    }
  });
  $('.removeItem').on('click', function(event) {
    event.preventDefault();
    var dataPost = {
      'id'    :$(this).val(),
      'color' :$(this).data('color')
    }
    $($(this).data('target')).remove();
    if($('.cartItem:not(.hidden)').length < 1)
    {
      $('.cd-cart-total').addClass('hidden')
      $('.checkout-btn').addClass('hidden')
      $('.vaciar').addClass('hidden')
    }
    calcTotal()
    var base = getRootUrl();
    $.ajax({
      url: base+'carphone/public/telefono/quitar',
      type: 'GET',
      dataType: 'json',
      data: dataPost,
    })
    
  });
  $('.vaciar').on('click', function(event) {
    event.preventDefault();
    $('.cd-cart-total').addClass('hidden')
    $('.checkout-btn').addClass('hidden')
    $('.vaciar').addClass('hidden')
    $('.cartItem:not(.hidden)').remove();
    $.ajax({
      url: base+'carphone/public/telefono/vaciar',
      type: 'GET',
      dataType: 'json',
      success:function() {
        toastr.success('El carrito se ha vaciado');
      }
    })
  });
  $('.btn-add').on('click', function(event) {
    event.preventDefault();
    var qty = $($(this).data('target'));
    qty.val(parseInt(qty.val())+1);
    dataPost = {
      'id'   : $(this).data('id'),
      'color': $(this).data('color'),
      'qty'  : qty.val()
    };
    var papa = $('#item_'+dataPost.id+dataPost.color);
    var price = parseInt(papa.children('.cart_price').children('p').html().substr(1));
    papa.children('.cart_total').children('.cart_total_price').html('$'+(price*parseInt(qty.val())));    
    calcTotalCart();
    updateQty(dataPost);
  });
  $('.btn-rest').on('click', function(event) {
    event.preventDefault();
    var qty = $($(this).data('target'));
    if (qty.val() ) {};
    qty.val(parseInt(qty.val())-1);
     dataPost = {
      'id'   : $(this).data('id'),
      'color': $(this).data('color'),
      'qty'  : qty.val()
    };
    var papa = $('#item_'+dataPost.id+dataPost.color);
    var price = parseInt(papa.children('.cart_price').children('p').html().substr(1));
    papa.children('.cart_total').children('.cart_total_price').html('$'+(price*parseInt(qty.val())));    
    calcTotalCart();
    updateQty(dataPost);
  });
});
