<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-lg-12">
            <div class="centering text-center">
                <div class="text-center">
                    <h2 class="without-margin">Don't worry. It's <span class="text-danger"><big>500</big></span> error only.</h2>
                    <h4 class="text-danger">Something is broken, but we will fix it soon</h4>
                </div>
                <div class="text-center">
                    <h3><small>Choose an option below</small></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>
