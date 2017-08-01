<!DOCTYPE html>
<!--
    @ Chrome    43+
    @ Firefox   40+
    @ Opera     31+
    @ Android   44+
    @ Chrome for Android    44+
-->
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- External CSS -->
    <link type="text/css" rel="stylesheet" href="http://mui.xuehtml.com/src/css/miniui.min.css">
    <link type="text/css" rel="stylesheet" href="http://mui.xuehtml.com/src/css/simple-line-icons.css">
    <link type="text/css" rel="stylesheet" href="http://project.xuehtml.com/react-redux/src/css/style.css">

    <title>画方科技</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        console.log('arr:',[1,2].push(3));
    </script>

</head>
<body>
    <div id="webApplication"></div>

    <!-- JavaScript -->
    <script type="text/javascript" src="/public/js/init.js"></script>
    <script type="text/javascript" src="/public/js/bundle.js"></script>
</body>
</html>
