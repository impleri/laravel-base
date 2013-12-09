<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            @section('html_title')
                {{site_title}}
            @show
        </title>

        @include('partials.meta')
    </head>

    <body class="two-sidebars">
        @include('partials.header')

        <section>
            @include('partials.content')

            @include('partials.sidebar-one')
            @include('partials.sidebar-two')
        </section>

        @include('partials.footer')
    </body>
</html>
