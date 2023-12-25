<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        {{-- Style Here --}}
    </style>
</head>
<body>
<div class="content">
    <header>
        <!-- Header Content here -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Footer Content Here -->
    </footer>
</div>
</body>
</html>
