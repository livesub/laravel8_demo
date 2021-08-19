<!DOCTYPE html>
<html>

<body>
    <h1>{{ $subject }}</h1>
    <p>{!! $body !!}</p>

<div style="display:none;">
	<img src="{{ route('email.sendconfirm.index', $receive_token) }}" border="0" width="0" height="0" loading="lazy">
</div>

</body>
</html>