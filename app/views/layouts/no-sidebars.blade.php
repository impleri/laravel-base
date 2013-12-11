<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            @section('html_title')
                {{$site_title}}
            @show
        </title>

        @include('partials.meta')
    </head>

    <body class="one-sidebar">
        @include('partials.header')

        <section>
            @include('partials.content')
        </section>

        @include('partials.footer')
    </body>
</html>
