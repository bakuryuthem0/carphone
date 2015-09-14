<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $title; }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-theme.min.css') }}
        {{ HTML::style('css/custom-admin.css') }}
        {{ HTML::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') }}
        {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') }}
    </head>
    <body class="admin">
        <header class="admin">
            <nav class="navbar navbar-default" style="position:initial;">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="col-xs-1">
                  <a href="{{ URL::to('administrador/inicio') }}"><img src="{{ asset('images/logo-01.png') }}" class="logo2"></a>
                </div>

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
               
               <div class="collapse navbar-collapse adminlayout" id="bs-example-navbar-collapse-1 col-xs-3">
                @if(!Auth::check())
                <h3 style="text-align:left;vertical-align:middle;">Bienvenido (a)<br>Al Centro De Administración De La tienda </h3>
                @else
                  <ul class="nav navbar-nav">
                    <li class="dropdown myMenu">
                      <a href="#" class="dropdown-toggle textoPromedio" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-user"></i>
                          {{ Auth::user()->username }}
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu multi-level" role="menu">
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Marcas
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('marca/nueva') }}">
                                  <i class="fa fa-plus"></i> Nueva marca
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('marca/ver-marcas') }}">
                                  Modificar marca
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('categoria/nueva-sub-categoria') }}">
                                  Nueva Sub-categoría
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('sub-categoria/ver-sub-categorias') }}">
                                  Modificar Sub-categoría
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Colores
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('color/nuevo') }}">
                                  <i class="fa fa-plus"></i> Nuevo
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('colores/ver-colores') }}">
                                  <i class="fa fa-money"></i>
                                  Modificar
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Tallas
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('talla/nueva') }}">
                                  <i class="fa fa-plus"></i> Nueva
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('talla/ver-tallas') }}">
                                  <i class="fa fa-money"></i>
                                  Modificar
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Articulos
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('administrador/nuevo-articulo') }}">
                                  Nuevo articulo
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('administrador/ver-articulo') }}">
                                  Ver articulos
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Pagos
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('administrador/ver-pagos') }}">
                                  Ver pagos
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('administrador/ver-pagos-aprobados') }}">
                                  Ver pagos aprobados
                                </a>
                              </li>
                              
                            </ul>
                          </li>
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Bancos
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('administrador/agregar-bancos') }}">
                                  Agregar
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('administrador/editar-banco') }}">
                                  Editar
                                </a>
                              </li>
                              
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li class="dropdown myMenu">
                        <a href="#" class="dropdown-toggle textoPromedio" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-user"></i>
                            Usuario
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li><a href="{{ URL::to('administrador/crear-nuevo') }}">Nuevo administrador</a></li>
                            <li><a href="{{ URL::to('administrador/cambiar-contraseña') }}">Cambiar mi contraseña</a></li>
                          </ul>
                      </li>
                      <li class="dropdown myMenu">
                      <a href="#" class="dropdown-toggle textoPromedio" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-user"></i>
                          Pagina
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu multi-level" role="menu">
                          <li class="dropdown-submenu">
                            <a href="#" >
                              Imagenes de fondo
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ URL::to('administrador/nueva-imagen') }}">
                                  Nueva Imagen
                                </a>
                              </li>
                              <li>
                                <a href="{{ URL::to('administrador/editar-slides') }}">
                                  Editar Imagenes
                                </a>
                              </li>
                              
                            </ul>
                          </li>
                        </ul>
                      </li> 
                      <li class="textoPromedio"><a href="{{ URL::to('cerrar-sesion') }}" class="logout">Cerrar sesión</a></li>
                  </ul>
                @endif

                </div>
                
              </div><!-- /.container-fluid -->
            </nav>
        </header>
    @yield('content')
    {{ HTML::script("http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
        {{ HTML::script('js/jquery.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/custom-admin.js') }}
        {{ HTML::script('//code.jquery.com/ui/1.11.2/jquery-ui.js') }}
  
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-57229555-1', 'auto');
          ga('send', 'pageview');

        </script>
       @yield('postscript')
    </body>
</html>