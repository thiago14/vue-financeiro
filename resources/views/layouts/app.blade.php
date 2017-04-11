<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
             'csrfToken' => csrf_token(),
        ]);?>
    </script>
</head>
<body>
    <div id="app">
        <header>
            @if (Auth::check())
                <?php
                    $menuConfig = [
                        'name' => Auth::user()->name,
                        'menus' => [
                            [ 'id' => 0, 'name' => 'Dashboard', 'url' => '/' ],
                            [
                                'id' => 1, 'name' => 'Contas a pagar', 'url' => '/bill/pay', 'subMenuId' => 'bill_pay',
                                'subMenus' => [
                                    [ 'id' => 0, 'name' => 'Lista de contas', 'url' => '/bill/pay' ],
                                    [ 'id' => 1, 'name' => 'Criar conta', 'url' => '/bill/pay/create' ]
                                ]
                            ],
                            [
                                'id' => 2, 'name' => 'Conta a receber', 'url' => '/bill/receive', 'subMenuId' => 'bill_receive',
                                'subMenus' => [
                                    [ 'id' => 0, 'name' => 'Lista de contas', 'url' => '/bill/receive' ],
                                    [ 'id' => 1, 'name' => 'Criar conta', 'url' => '/bill/receive/create' ]
                                ]
                            ]
                        ],
                        'urlLogout' => env('URL_ADMIN_LOGOUT'),
                        'csrfToken' => csrf_token()
                    ];
                ?>
                <admin-menu :config="{{ json_encode($menuConfig) }}"></admin-menu>
            @endif
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="page-footer">
            <div class="footer-copyright">
                <div class="container">
                    &copy; {{ date('Y') }} <a href="https://github.com/thiago14/" class="grey-text text-lighten-4"></a>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('build/admin.bundles.js') }}"></script>
</body>
</html>
