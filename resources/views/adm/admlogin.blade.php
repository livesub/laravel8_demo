<table border=1>
<form action='{{ route('adm.login.store') }}' method='POST' role='form' class='form__auth'>
{!! csrf_field() !!}
    <tr>
        <td>
            <h4>
                {{ $title_login }}
            </h4>
        </td>
    </tr>
    <tr>
        <td>
            <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}' autofocus>
            @error('user_id')
                <span class='invalid-feedback' role='alert'>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </td>
    </tr>
    <tr>
        <td>
            <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
            @error('user_pw')
                <span class='invalid-feedback' role='alert'>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </td>
    </tr>
    <tr>
        <td>
            <button class='btn btn-primary btn-lg btn-block' type='submit'>
                {{ $submit_login }}
            </button>
        </td>
    </tr>
</form>
</table>


    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif