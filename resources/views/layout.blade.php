<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DancingMap</title>
</head>
<body>
    <header>
        {{-- ログインしてなければ表示される --}}
        @guest
            <a href="{{ route ('login') }}">ログイン</a>
            <a href="{{ route ('register') }}">会員登録</a>
        @endguest

        @auth
            名前 {{ Auth::user()->name }}

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit"> ログアウト </button>
            </form>

            <a href="{{ route('places.index') }}">場所一覧</a>
            名前: {{ Auth::user()->name }}
        @endauth
    </header>

    @yield('contents')

    <footer></footer>
</body>
</html>
