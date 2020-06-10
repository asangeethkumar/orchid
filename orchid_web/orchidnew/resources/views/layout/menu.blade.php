<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body id="fontclass">
        @if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
            <header id="main" class="row header_bgnd">
                @include('includes.header')
            </header>
        @endif
            <div id="main" class="row">
                <!-- main content -->
                <div id="content" class="col-lg-12 col-xl-12">
                    @yield('content')
                </div>
            </div>
        
        @if ( (($agent->isDesktop()) || ($agent->isiPad()) || $agent->match('Nexus 10')) == false)
            <footer id="main" class="row footer">
                @include('includes.footer')
            </footer>
        @endif

    </body>
</html>