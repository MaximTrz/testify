@extends('layouts.app')

@section('content')
<div class="login">
    <div class="login__card">
        <div class="login__header">Войти</div>

        <div class="login__body">
            <form class="login__form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login__form-group">
                    <label for="email" class="login__label">Email</label>
                    <input id="email" type="email" class="login__input @error('email') login__input--invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="login__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="login__form-group">
                    <label for="password" class="login__label">Пароль</label>
                    <input id="password" type="password" class="login__input @error('password') login__input--invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="login__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="login__form-group login__form-group--checkbox">
                    <div class="login__checkbox-wrapper">
                        <input class="login__checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="login__checkbox-label" for="remember">Запомнить</label>
                    </div>
                </div>

                <div class="login__form-group">
                    <button type="submit" class="login__button">Войти</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
