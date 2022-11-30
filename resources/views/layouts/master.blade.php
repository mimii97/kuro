<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{$settings->sitename_en}} @yield('title')</title>





    @include('layouts.head')
</head>

<body>

<div class="body">

        @include('layouts.main-header')


        <!--=================================
 Main content -->
        <!-- main-content -->


            @yield('content')

            <!--=================================
 wrapper 1111 -->

            <!--=================================
 footer -->

            @include('layouts.footer')

    </div>


    <!--=================================
 footer -->

    @include('layouts.footer-scripts')



</body>

</html>
