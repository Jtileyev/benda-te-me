<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Benda Te Me') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">
</head>
<body class="landing-page">
@if(session('success'))
    <div class="container pt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
@endif
@if($errors->any())
    <div class="container pt-3"><div class="alert alert-danger mb-0">{{ $errors->first() }}</div></div>
@endif
@yield('content')

<script>
document.addEventListener('click',function(e){document.querySelectorAll('.hero-lang-dropdown.open').forEach(function(d){if(!d.contains(e.target))d.classList.remove('open')})});
document.querySelectorAll('.count-up').forEach(function(el){
    var target=parseInt(el.dataset.target,10),duration=2000,start=0,startTime=null;
    function fmt(n){return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g,',')}
    function step(ts){
        if(!startTime)startTime=ts;
        var p=Math.min((ts-startTime)/duration,1);
        var ease=1-Math.pow(1-p,3);
        el.textContent=fmt(Math.floor(ease*target));
        if(p<1)requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
});
</script>
<footer class="landing-footer">
    <span>&copy; {{ date('Y') }} {{ __('site.brand') }}</span>
    &middot;
    <a href="{{ route('about') }}">{{ __('site.about') }}</a>
    &middot;
    <a href="{{ route('login') }}">{{ __('site.authorization') }}</a>
</footer>
</body>
</html>
