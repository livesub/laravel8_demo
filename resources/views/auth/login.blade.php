@extends('layouts.head')

@section('content')


  <form action='{{ route('login.store') }}' method='POST' role='form' class='form__auth'>
    {!! csrf_field() !!}

    <div class='page-header'>
      <h4>
        {{ $title_login }}
      </h4>
    </div>


    <div class='form-group'>
      <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}' autofocus>
    </div>
    @error('user_id')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
    </div>
    @error('user_pw')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      <div class='checkbox'>
        <label>
          <input type='checkbox' name='remember' value='{{ old('remember', 1) }}' checked>
          {{ $remember }}
          <span class='text-danger'>
            {{ $remember_help }}
          </span>
        </label>
      </div>
    </div>

    <div class='form-group'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $submit_login }}
      </button>
    </div>

    <div>
      <p class='text-center'>
        {!! trans($ask_registration, ['url' => route('join.create')]) !!}
      </p>

      <p class='text-center'>
        {!! trans($ask_forgot, ['url' => route('pwchange.index')]) !!}
      </p>

    </div>
  </form>

    <div>
      <p class='text-center'>
        <button type="button" onclick="location.href='{{ route('google.login') }}'">구글 로그인</button>
      </p>


    </div>

@endsection