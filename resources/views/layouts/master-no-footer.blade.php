<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{trans('end-user/home.OSH')}} - @yield('title')</title>





    @include('end-user.layouts.head')
</head>

<body>

<div class="body">

@include('end-user.layouts.main-header')


<!--=================================
 Main content -->
    <!-- main-content -->


@yield('content')

<!--=================================
 wrapper 1111 -->

    <!--=================================
footer -->



</div>


<!--=================================
footer -->

@include('end-user.layouts.footer-scripts')



</body>

</html>
