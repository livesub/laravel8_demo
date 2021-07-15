@extends('layouts.head')

@section('content')
  <form action='{{ route('reset.store') }}' method='POST' role='form' class='form__auth'>
    {!! csrf_field() !!}

    <input type='hidden' name='pw_token' value='{{ $token }}'>

    <div class='page-header'>
      <h4>{{ $title_reset }}</h4>
      <p class='text-muted'>
        {{ $desc_reset }}
      </p>
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
      <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='{{ $user_pw_confirmation }}'>
    </div>
    @error('user_pw_confirmation')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <button class='btn btn-primary btn-lg btn-block' type='submit'>
      {{ $title_reset }}
    </button>
  </form>
@endsection