@extends('layouts.app')

@section('content')

<div class="w-full max-w-sm flex m-auto items-center">
    <form method="POST" class="w-full bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('login') }}">
        @csrf
        <div class="text-xl mb-4">{{ __('Login') }}</div>

        <div class="mb-4">
            <label for="email" class="block text-grey-darker text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
            <input
                    id="email" type="email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight
                    focus:outline-none focus:shadow-outline {{ $errors->has('email') ? ' border-red' : '' }}"
                    name="email"
                    value="{{ old('email') }}"
                    required autofocus
            >
            @if ($errors->has('email'))
                <span class="text-red text-xs italic mt-2" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
        </div>

        <div class="mb-5">
            <label for="password" class="block text-grey-darker text-sm font-bold mb-2">{{ __('Password') }}</label>
            <input
                    id="password"
                    type="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3
                    leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('password') ? ' border-red' : '' }}"
                    name="password"
                    required
            >

            @if ($errors->has('password'))
                <span class="text-red text-xs italic mt-2" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="mb-3">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="text-grey-darker text-sm font-bold mb-2" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="button">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a class="inline-block align-baseline font-bold text-sm text-blue no-underline hover:text-blue-dark" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
