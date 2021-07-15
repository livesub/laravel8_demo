@extends('layouts.head')

@section('content')
  <form action='{{ route('pwchange.store') }}' method='POST' role='form' class='form__auth'>
    {!! csrf_field() !!}

    <div class='page-header'>
      <h4>
        {{ $title_change }}
      </h4>
      <p class='text-muted'>
        {{ $desc_change }}
      </p>
    </div>


    <div class='form-group'>
      <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
    </div>
    @error('user_id')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <button class='btn btn-primary btn-lg btn-block' type='submit'>
      {{ $send_change }}
    </button>
  </form>
@endsection