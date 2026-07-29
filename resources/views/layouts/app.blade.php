<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'NextStep AI')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('NextStepAi-front/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('NextStepAi-front/css/footer.css') }}" rel="stylesheet">
@yield('css')
</head>
<body>

@include('partials.navbar')

@yield('content')

@include('partials.footer')

@yield('scripts')
</body>
</html>
