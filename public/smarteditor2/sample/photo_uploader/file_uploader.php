<?php
// default redirection
$url = 'callback.html?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];

	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg","jpeg", "png", "bmp", "gif");

	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		//$uploadDir = '../../../data/smarteditor/';
		$uploadDir = "../../../data/{$_COOKIE['directory']}/";	//다른 곳에 쓰일경우 COOKIE['directory'] 설정 변경
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}

		$newPath = $uploadDir.urlencode($_FILES['Filedata']['name']);

		@move_uploaded_file($tmp_name, $newPath);

		$url .= "&bNewLine=true";
		$url .= "&sFileName=".urlencode(urlencode($name));
		//$url .= "&sFileURL=../../../data/smarteditor/".urlencode(urlencode($name));
		$url .= "&sFileURL={$uploadDir}".urlencode(urlencode($name));
	}
}
// FAILED
else {
	$url .= '&errstr=error';
}

header('Location: '. $url);
?>