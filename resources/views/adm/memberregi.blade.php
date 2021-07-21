@extends('layouts.admhead')

@section('content')


  <form action='{{ route('adm.member.regi.store') }}' method='POST' enctype='multipart/form-data' role='form' class='form__auth'>
    {!! csrf_field() !!}
    <input type="hidden" name="mode" id="mode" value="{{ $mode }}">
    <input type="hidden" name="num" id="num" value="{{ $num }}">
    <div class='page-header'>
      <h4>
      회원 {{ $title_ment }}
      </h4>
    </div>


    <div class='form-group'>
      아이디 :

        @if ($mode == 'regi')
            <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
        @else
            {{ $user_id }}
        @endif


    @error('user_id')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>



    <div class='form-group'>
      이름 :
      @if ($mode == 'regi')
        <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ old('user_name') }}' placeholder='{{ $user_name }}'>
      @else
        <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ $user_name }}' placeholder='{{ $user_name }}'>
      @endif
    @error('user_name')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>



    <div class='form-group'>
      비밀번호 : <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
    @error('user_pw')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>


    <div class='form-group'>
      비밀번호 확인 : <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='{{ $user_pw_confirmation }}'>
    @error('user_pw_confirmation')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    @if ($mode == 'modi')
      <input type='button' value='{{ $pw_change }}' onclick='pw_change();'>
    @endif

    </div>



    <div class='form-group'>
      전화번호 :

      @if ($mode == 'regi')
        <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}' placeholder='{{ $user_phone }}'>
      @else
        <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ $user_phone }}' placeholder='{{ $user_phone }}'>
      @endif
    @error('user_phone')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>

    <div class='form-group'>
      레벨 : {!! $select_disp !!}
    </div>

    @if ($mode == 'modi')
    <div class='form-group'>
      가입일 : {{ $created_at }}
    </div>
    <div class='form-group'>
      회원 상태 : {{ $user_status }}
    </div>
    @endif

    <div class='form-group'>
      이미지 : <input name='user_imagepath[]' id='user_imagepath' type='file' class='form-control'>
        @error('user_imagepath.0')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    @if ($user_imagepath != '')
        <img src='{{ asset('/data/member/'.$user_imagepath) }}' style='border-radius: 50%;'>
        <a href="{{ url('filedown', $type) }}">{{ $user_ori_imagepath }}</a>
        <input type='button' value='이미지 삭제' onclick='img_del();'>
    @endif




    <div class='form-group' style='margin-top: 2em;'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $title_ment }}
      </button>


    @if ($mode != 'regi')
      <button style="margin-top:20px;" type="button" onclick="mem_out();">회원 탈퇴/가입 처리</button>
    @endif

    </div>


  </form>


<form action="{{ route('adm.member.out') }}" name="mem_out_form" id="mem_out_form" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="chk_id[]" id="chk_id" value="{{ $num }}">
</form>

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
//alert($('input[name=_token]').val());
    $.ajax({
          headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
          type: 'post',
          url: '{{ route('adm.member.pw_change') }}',
          dataType: 'json',
          data: {
            'user_pw' : $('#user_pw').val(),
            'user_pw_confirmation' : $('#user_pw_confirmation').val(),
            'num' : $('#num').val()
          },
          success: function(data) {
            console.log(data);
            if(data.status == 'false'){
              alert(data.status_ment);
            }else{
              alert(data.status_ment);
              location.href = '/adm';
            }
          },
          error: function(data) {
            console.log("error==> " + data);
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

<script>
  function img_del(){
    if (confirm("회원 이미지를 삭제하시겠습니까??") == true){    //확인
      $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type: 'post',
            url: '{{ route('adm.member.imgdel') }}',
            dataType: 'json',
            data: {
              'num' : $('#num').val()
            },
            success: function(data) {
              console.log(data);
              if(data.status == 'false'){
                alert(data.status_ment);
              }else{
                alert(data.status_ment);
                location.href = '/adm';
              }
            },
            error: function(data) {
              console.log("error==> " + data);
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
    }else{   //취소
        return;
    }
  }
</script>

<script>
    function mem_out(){
        if (confirm("탈퇴 회원은 가입 처리 되며, 가입자는 탈퇴 처리 됩니다.\n회원 정보는 삭제 되지 않습니다.\n선택 하신 회원을 탈퇴/가입 하시겠습니까?") == true){    //확인
          document.mem_out_form.submit();
        }else{
            return;
        }
    }
</script>


@endsection
