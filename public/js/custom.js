function valEmpty (el,msg) {
  $('.text-danger').remove();
  el.parent().addClass('has-error');
  el.after('<p class="text-danger">'+msg+'</p>');
}
function getRootUrl () {
  return window.location.origin?window.location.origin+'/':window.location.protocol+'/'+window.location.host+'/';
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
                                              $('.responseAjax').hide('fast').children('.bg-danger').remove();
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
});
