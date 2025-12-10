<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <form action="{{ route('register')}}" method="POST">
        @csrf

        <h2>Register</h2>

        <label for="nama_user">Nama:</label>
        <input type="text" name="nama_user" required value="{{ old('nama_user') }}">

        <label for="no_induk">NIM/NIP:</label>
        <input type="text" name="no_induk" required value="{{ old('no_induk') }}">

        <label for="no_hp">No. HP:</label>
        <input type="text" name="no_hp" required value="{{ old('no_hp') }}">

        <label for="email">Email:</label>
        <input type="email" name="email" required value="{{ old('email') }}">

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit" class="btn mt-4">Daftar</button>

        {{-- validation errors --}}
        @if ($errors->any())
            <ul class="px-4 py-2 bg-red-100">
                @foreach ($errors->all() as $error)
                    <li class="my-2 text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </form>
</body>
</html>
