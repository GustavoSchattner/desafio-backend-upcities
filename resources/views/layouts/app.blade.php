<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gerenciamento">
    <title>@yield('title', 'Sistema Prefeitura')</title>

    <script src="https://kit.fontawesome.com/6cf20ba8ee.js" crossorigin="anonymous"></script>

    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">

<body>
    <nav class="navbar">
        <a href="/">
            <img class="navbar-image" src="{{ asset('images/logo.png') }}" alt="Logo da empresa UpCities, no seu tom original de verde, localizada no canto superior esquerdo da página.">
        </a>
        <div class="nav-buttons-container">
            <a href="{{ route('people.index') }}">Pessoas</a>
            <button type="button" onclick="window.location.href='{{ route('people.create') }}'">
                Cadastrar pessoa
            </button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
    
    <footer class="footer">
        <img class="footer-image" src="{{ asset('images/logo.png') }}" alt="Logo da empresa UpCities, no seu tom original de verde, localizada no canto inferior esquerdo da página.">
        <a href="https://wa.me/+5533999446412" class="whatsapp-contact-container" target="_blank">
            <i class="fa-brands fa-whatsapp"></i>
            <div class="whatsapp-contact-text">
                <p>Dúvidas?</p>
                <p>Estamos no Whatsapp</p>
            </div>
        </a>

    </footer>
</body>
</html>