function valEmpty (el,msg) {
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
          $('.text-danger').remove();
          $('.login-input').each(function(index, el) {
                  if ($(el).val() == "") {
                          valEmpty($(el,'El campo es obligatorio'));
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
                                  
                          },
                          success:function (response) {
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
                                          $('.responseAjax').html('<p class="bg-danger">'+response.msg+'</p>').show('fast');
                                          setTimeout(function() {
                                                  $('.responseAjax').hide('fast').children('.bg-danger').remove();
                                          },5000)
                                  }
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
    if ($('.password').val() != $('password2').val() && $('.password').val() != "" && $('.password2').val()!= "") {
      valEmpty($('.password2'),'Las contraseñas no concuerdan')
        proceed = 0;

    };
    //Utilizamos una expresion regular
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
 
    //Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('.email').val().trim()))
    {
      valEmpty($('.email'),'Formato de email invalido');       
      proceed = 0;
    }
    if (proceed == 1) {
      $('.form-register').submit();

    }
  });
});
