<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- Adicionando JQuery mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"
            integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>

    @vite(['resources/js/app.js', 'resources/js/form.js'])
    <title>@yield('title')</title>
</head>
<body class="flex flex-col h-screen overflow-visible">
    <div class="loading" style="display: none"></div>
    <section class="mb-4 p-3">
        <div class="container mx-auto">
            <h2 class="font-bold text-center mt-10 text-2xl md:text-3xl">Projeto Desenvolvedor ASC 🚀</h2>
        </div>
    </section>
    @yield('content')
</body>
@stack('scripts')
</html>
