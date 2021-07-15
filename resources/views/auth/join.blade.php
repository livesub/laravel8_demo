@extends('layouts.head')

@section('content')

  <form action='{{ route('join.store') }}' method='POST' role='form' class='form__auth'>
    {!! csrf_field() !!}

    <div class='page-header'>
      <h4>
      {{ $title_join }}
      </h4>
    </div>


    <div class='form-group'>
      <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
    </div>
    @error('user_id')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ old('user_name') }}' placeholder='{{ $user_name }}'>
    </div>
    @error('user_name')
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


    <div class='form-group'>
      <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}' placeholder='{{ $user_phone }}'>
    </div>
    @error('user_phone')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group' style='margin-top: 2em;'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $submit_join }}
      </button>
    </div>
  </form>


@endsection
