@extends('layouts.head')

@section('content')

<script>
  function pw_change()
  {
    if($('#user_pw').val() == '')
    {
      alert('{{ $alert_pw }}');
      $('#user_pw').focus();
      return false;
    }

    if($('#user_pw_confirmation').val() == '')
    {
      alert('{{ $alert_pw_confirmation }}');
      $('#user_pw_confirmation').focus();
      return false;
    }

    if($('#user_pw').val().length < 6 || $('#user_pw').val().length > 16)
    {
      alert('비밀번호는 6자 이상 16이하로 입력 하세요.');
      $('#user_pw').focus();
      return false;
    }

    if($('#user_pw_confirmation').val().length < 6 || $('#user_pw_confirmation').val().length > 16)
    {
      alert('비밀번호는 6자 이상 16이하로 입력 하세요.');
      $('#user_pw_confirmation').focus();
      return false;
    }

    if($('#user_pw').val() != $('#user_pw_confirmation').val())
    {
      alert('{{ $user_pw_same }}');
      $('#user_pw_confirmation').focus();
      return false;
    }

    $.ajax({
          headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
          type: 'post',
          url: '{{ route('mypage.pw_change') }}',
          dataType: 'json',
          data: {
            'user_pw' : $('#user_pw').val(),
            'user_pw_confirmation' : $('#user_pw_confirmation').val()
          },
          success: function(data) {
            console.log(data);

            if(data.status == 'false'){
              alert(data.status_ment);
            }else{
              alert(data.status_ment);
              location.href = '';
            }
          },
          error: function(data) {

            console.log(data);
            //초기화
            $(document).find('[name=user_pw]').val('');
            $(document).find('[name=user_pw_confirmation]').val('');
            $('#reset_user_pw').remove();
            $('#reset_user_pw_confirmation').remove();

            $.each(data.responseJSON.errors,function(field_name,error){
              $(document).find("[name='+field_name+']").after("<span class='text-strong textdanger' id='reset_'+field_name>' +error+ '</span>");
            })
          }
    });
  }
</script>

    <div class='page-header'>
      <h4>
      {{ $title_mypage }}
      </h4>
    </div>

  <form action='{{ route('mypage.infosave') }}' id='mypage_form' method='post' enctype='multipart/form-data'>
  {!! csrf_field() !!}

    <div class='form-group'>
     {{ $title_id }} : <b>{{ $user_id }}</b>
    </div>


    <div class='form-group'>
      {{ $title_name }} : <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ $user_name }}' placeholder='{{ $user_name }}'>
    </div>
    @error('user_name')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      {{ $title_pw }} : <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
    </div>
    @error('user_pw')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>


    <div class='form-group'>
      {{ $title_pw_confirmation }} : <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='{{ $user_pw_confirmation }}'>
      <input type='button' value='{{ $pw_change }}' onclick='pw_change();'>
    </div>
    @error('user_pw_confirmation')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      {{ $title_phone }} : <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ $user_phone }}' placeholder='{{ $user_phone }}'>
    </div>
    @error('user_phone')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class='form-group'>
      {{ $title_image }} : <input name='user_imagepath[]' id='user_imagepath' type='file' class='form-control'>
    </div>

    @error('user_imagepath.0')
    <div class='form-group'>
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    </div>
    @enderror

    @if ($user_imagepath != '')
        <img src='{{ asset('/data/member/'.$user_thumb_name) }}' style='border-radius: 50%;'>
        <a href="{{ url('filedown', $type) }}">{{ $user_ori_imagepath }}</a>
    @endif


    <div class='form-group'>
      {{ $join_date }} : {{ $created_at }}
    </div>


    <div class='form-group' style='margin-top: 2em;'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $submit_join }}
      </button>
      <button type="button" onclick="withdraw();">탈퇴 하기</button>
    </div>


  </form>

<script>
  function withdraw(){
    if (confirm("정말 탈퇴 하시겠습니까?") == true){    //확인
        location.href='{{ route('mypage.withdraw') }}';
    }else{   //취소
        return false;
    }
  }
</script>


{{--
@if ($errors->any())
    <div class='alert alert-danger'>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
--}}






@endsection
