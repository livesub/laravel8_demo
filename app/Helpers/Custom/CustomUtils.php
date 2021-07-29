<?php
#############################################################################
#
#		파일이름		:		CustomUtils.php
#		파일설명		:		사용자 제작 함수
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Validator;  //체크
use Illuminate\Support\Facades\Mail;    //메일 class
use App\Helpers\Custom\Messages_kr;    //한글 error 메세지 모음
use App\Helpers\Custom\Messages_en;    //영어 error 메세지 모음
use Illuminate\Support\Facades\DB;

class CustomUtils extends Controller
{
/*    안씀!!!
    //$request => 입력값, $name => 입력 필드 이름, $chk => 체크 형태 )
    public static function validator_chk($request, $name, $chk)
    {
        $validator = Validator::make($request, $chk);

return $validator;

//        if ($validator->fails()) return false;
//        else return true;
    }
*/
    //이메일 보내기 함수
    public static function email_send($email_blade, $user_name, $user_id, $subject, $data)
    {
        Mail::send(
            $email_blade,
            $data,
            //function($message) use ($to_name, $to_email) {
            function($message) use ($user_name, $user_id, $subject) {
                $message->to($user_id, $user_name)->subject($subject);
                $message->from("yskim@yongsanzip.com","김영여영11111");
            }
        );

        if(count(Mail::failures()) > 0){
            return false;
        }else{
            return true;
        }
    }

    //파일 경로를 반환 하는 함수
    public static function attachments_path($path = '')
    {
        //return public_path($path.($path ? DIRECTORY_SEPARATOR.$path : $path));
        return public_path($path);
    }

    public static function attachment_save($file,$path)
    {
        //$file_name = time().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);     //파일 이름 변환
        //이슈!! 한글 파일명일때 변환을 해 주지 않아 같은 시간대로 파일 덮어 버림
        $file_name = uniqid().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);     //파일 이름 변환
        $file_ori_name = $file->getClientOriginalName();    //원본 파일 이름

        if (!$file->move(CustomUtils::attachments_path($path),$file_name)) {
            return ['false', $file_name, $file_ori_name];
        }else{
            return ['true', $file_name, $file_ori_name];
        }
    }

    public static function language_pack($type)
    {
        if($type == 'kr' || $type == '') $Messages = new Messages_kr;
        else $Messages = new Messages_en;

        return $Messages;
    }

    public static function page_function($table_name,$pageNum,$writeList,$pageNumList,$type,$bm_tb_name='',$cate='')
    {
        //$table_name = 테이블 이름
        //$pageNum = get 방식의 호출 페이지 번호
        //$writeList = 한 화면에 보여줄 데이터 갯수
        //$pageNumList = 한 페이지당 표시될 글 갯수
        //$total_cnt = 게시물 총 갯수
        //$type = 게시물 총 갯수(게시판 총 관리 테이블과 회원 관리 테이블 구조가 다름)
        //$bm_tb_name = 게시판 이름

        $page = array();
        if($type != 'board'){
            $total_cnt = DB::table($table_name)->count();
            $cateinfo = '';
        }else{
            if($cate == ""){
                $total_cnt = DB::table($table_name)->where('bm_tb_name',$bm_tb_name)->count();
                $cateinfo = '';
            }else {
                $total_cnt = DB::table($table_name)->where([['bm_tb_name',$bm_tb_name],['bdt_category',$cate]])->count();
                $cateinfo = "&cate=".$cate;
            }
        }

        // view에서 넘어온 현재페이지의 파라미터 값.
        $page['pageNum']     = (isset($pageNum)?$pageNum:1);
        // 페이지 번호가 없으면 1, 있다면 그대로 사용
        $page['startNum']    = ($page['pageNum'] - 1) * $writeList;
        // 한 페이지당 표시될 글 갯수
        $page['pageNumList'] = $pageNumList;
        // 전체 페이지 중 표시될 페이지 갯수
        $page['pageGroup']   = ceil($page['pageNum'] / $page['pageNumList']);
        // 페이지 그룹 번호
        //$page['startPage']   = (($page['pageGroup'] - 1) * $page['pageNumList']) + 1;
        $page['startPage']   = 1;
        // 페이지 그룹 내 첫 페이지 번호
        $page['endPage']     = $page['startPage'] + $page['pageNumList'] - 1;
        // 페이지 그룹 내 마지막 페이지 번호
        $page['totalCount']  = $total_cnt;
        // 전체 게시글 갯수
        $page['totalPage']   = ceil($page['totalCount'] / $writeList); //5
        // 전체 페이지 갯수
        //if($page['endPage'] >= $page['totalPage']) {
            $page['endPage'] = $page['totalPage'];
        //} // 페이지 그룹이 마지막일 때 마지막 페이지 번호

        $page['virtual_num'] = $page['totalCount'] - $page['pageNumList'] * ($page['pageNum'] - 1);

        //페이징 관련
        if($page['endPage'] != 0){
            $page['preFirstPage'] = "<a href = '?pageNum=".$page['startPage'].$cateinfo."'><<&nbsp</a>";
        }else{
            $page['preFirstPage'] = "<<&nbsp";
        }

        if($page['pageNum'] == 1)
        {
            $page['pre1Page'] = "";
        }else{
            $page['pre1Page'] = "<a href = '?page=".($page['pageNum'] - 1).$cateinfo."'>&nbsp<</a>";
        }

        $page_hap = "";
        if($page['endPage'] != 0){
            for($i=$page['startPage']; $i<=$page['endPage']; $i++)
            {
                $page_hap .= "<a href = '?page=".$i.$cateinfo."'>&nbsp".$i."&nbsp</a>";
            }
        }else{
            $page_hap = "&nbsp1&nbsp";
        }

        $page['listPage'] = $page_hap;

        if($page['pageNum'] == $page['totalPage'])
        {
            $page['next1Page'] = "";
        }else{
            if($page['endPage'] != 0){
                $page['next1Page'] = "<a href = '?page=".($page['pageNum'] + 1).$cateinfo."'>&nbsp>&nbsp</a>";
            }else{
                $page['next1Page'] = "";
            }
        }

        if($page['endPage'] != 0){
            $page['nextLastPage'] = "<a href = '?page=".$page['endPage'].$cateinfo."'>&nbsp>></a>";
        }else{
            $page['nextLastPage'] = "&nbsp>>";
        }

        return $page;
    }

    public static function admin_access($user_level,$admin_level)
    {
        if($user_level > $admin_level){
            return false;
        }else{
            return true;
        }
    }

    public static function thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3')
    {
/*
$filename, -> 확장자를 포함한 파일명(ex abc.jpg) - 서버에 올라간 파일명
$source_path, -> 파일의 위치(ex G5_DATA_PATH.'/file/bo_table')
$target_path, -> 썸네일 폴더 생성위치(ex G5_DATA_PATH.'/file/bo_table')
$thumb_width, -> 생성 썸네일의 기준 넓이 또는 제한넓이
$thumb_height,-> 생성 썸네일의 기준 높이 또는 제한높이
$is_create, -> 페이지 새로고침 시 마다 썸네일을 재성성 할지 여부
$is_crop=false, -> 썸네일이 기준보다 클 경우 자를지여부
$crop_mode='center', -> 자를때 기준점
$is_sharpen=false,
$um_value='80/0.5/3'
*/

        if(!$thumb_width && !$thumb_height)
            return;

        $source_file = "$source_path/$filename";

        if(!is_file($source_file)) // 원본 파일이 없다면
            return;

        $size = @getimagesize($source_file);
        if(!isset($size[2]) || $size[2] < 1 || $size[2] > 3) // gif, jpg, png 에 대해서만 적용
            return;

        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        // 디렉토리가 존재하지 않거나 쓰기 권한이 없으면 썸네일 생성하지 않음
        if(!(is_dir($target_path) && is_writable($target_path)))
            return '';

        // Animated GIF는 썸네일 생성하지 않음
        if($size[2] == 1) {
            if(is_animated_gif($source_file))
                return basename($source_file);
        }

        $ext = array(1 => 'gif', 2 => 'jpg', 3 => 'png');

        $thumb_filename = preg_replace("/\.[^\.]+$/i", "", $filename); // 확장자제거
        $thumb_file = "$target_path/thumb-{$thumb_filename}_{$thumb_width}x{$thumb_height}.".$ext[$size[2]];

        $thumb_time = @filemtime($thumb_file);
        $source_time = @filemtime($source_file);

        if (file_exists($thumb_file)) {
            if ($is_create == false && $source_time < $thumb_time) {
                return basename($thumb_file);
            }
        }

        // 원본파일의 GD 이미지 생성
        $src = null;
        $degree = 0;

        if ($size[2] == 1) {
            $src = @imagecreatefromgif($source_file);
            $src_transparency = @imagecolortransparent($src);
        } else if ($size[2] == 2) {
            $src = @imagecreatefromjpeg($source_file);

            if(function_exists('exif_read_data')) {
                // exif 정보를 기준으로 회전각도 구함
                $exif = @exif_read_data($source_file);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 회전각도 있으면 이미지 회전
                    if($degree) {
                        $src = imagerotate($src, $degree, 0);

                        // 세로사진의 경우 가로, 세로 값 바꿈
                        if($degree == 90 || $degree == -90) {
                            $tmp = $size;
                            $size[0] = $tmp[1];
                            $size[1] = $tmp[0];
                        }
                    }
                }
            }
        } else if ($size[2] == 3) {
            $src = @imagecreatefrompng($source_file);
            @imagealphablending($src, true);
        } else {
            return;
        }

        if(!$src)
            return;

        $is_large = true;
        // width, height 설정

        if($thumb_width) {
            if(!$thumb_height) {
                $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            } else {
                if($crop_mode === 'center' && ($size[0] > $thumb_width || $size[1] > $thumb_height)){
                    $is_large = true;
                } else if($size[0] < $thumb_width || $size[1] < $thumb_height) {
                    $is_large = false;
                }
            }
        } else {
            if($thumb_height) {
                $thumb_width = round(($thumb_height * $size[0]) / $size[1]);
            }
        }

        $dst_x = 0;
        $dst_y = 0;
        $src_x = 0;
        $src_y = 0;
        $dst_w = $thumb_width;
        $dst_h = $thumb_height;
        $src_w = $size[0];
        $src_h = $size[1];

        $ratio = $dst_h / $dst_w;

        if($is_large) {
            // 크롭처리
            if($is_crop) {
                switch($crop_mode)
                {
                    case 'center':
                        if($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                            $src_y = round(($size[1] - $src_h) / 2);
                        } else {
                            $src_w = round($size[1] / $ratio);
                            $src_x = round(($size[0] - $src_w) / 2);
                        }
                        break;
                    default:
                        if($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                        } else {
                            $src_w = round($size[1] / $ratio);
                        }
                        break;
                }

                $dst = imagecreatetruecolor($dst_w, $dst_h);

                if($size[2] == 3) {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                } else if($size[2] == 1) {
                    $palletsize = imagecolorstotal($src);
                    if($src_transparency >= 0 && $src_transparency < $palletsize) {
                        $transparent_color   = imagecolorsforindex($src, $src_transparency);
                        $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                        imagefill($dst, 0, 0, $current_transparent);
                        imagecolortransparent($dst, $current_transparent);
                    }
                }
            } else { // 비율에 맞게 생성
                $dst = imagecreatetruecolor($dst_w, $dst_h);
                $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색

                if($size[2] == 3) {
                    $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefill($dst, 0, 0, $bgcolor);
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                } else if($size[2] == 1) {
                    $palletsize = imagecolorstotal($src);
                    if($src_transparency >= 0 && $src_transparency < $palletsize) {
                        $transparent_color   = imagecolorsforindex($src, $src_transparency);
                        $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                        imagefill($dst, 0, 0, $current_transparent);
                        imagecolortransparent($dst, $current_transparent);
                    } else {
                        imagefill($dst, 0, 0, $bgcolor);
                    }
                } else {
                    imagefill($dst, 0, 0, $bgcolor);
                }
            }
        } else {
            $dst = imagecreatetruecolor($dst_w, $dst_h);
            $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색

            //이미지 썸네일을 비율 유지하며 썸네일 생성합니다.
            if($src_w < $dst_w) {
                if($src_h >= $dst_h) {
                    if( $src_h > $src_w ){
                        $tmp_w = round(($dst_h * $src_w) / $src_h);
                        $dst_x = round(($dst_w - $tmp_w) / 2);
                        $dst_w = $tmp_w;
                    } else {
                        $dst_x = round(($dst_w - $src_w) / 2);
                        $src_h = $dst_h;
                        if( $dst_w > $src_w ){
                            $dst_w = $src_w;
                        }
                    }
                } else {
                    $dst_x = round(($dst_w - $src_w) / 2);
                    $dst_y = round(($dst_h - $src_h) / 2);
                    $dst_w = $src_w;
                    $dst_h = $src_h;
                }
            } else {
                if($src_h < $dst_h) {
                    if( $src_w > $dst_w ){
                        $tmp_h = round(($dst_w * $src_h) / $src_w);
                        $dst_y = round(($dst_h - $tmp_h) / 2);
                        $dst_h = $tmp_h;
                    } else {
                        $dst_y = round(($dst_h - $src_h) / 2);
                        $dst_h = $src_h;
                        $src_w = $dst_w;
                    }
                }
            }


            if($size[2] == 3) {
                $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                imagefill($dst, 0, 0, $bgcolor);
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            } else if($size[2] == 1) {
                $palletsize = imagecolorstotal($src);
                if($src_transparency >= 0 && $src_transparency < $palletsize) {
                    $transparent_color   = imagecolorsforindex($src, $src_transparency);
                    $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                    imagefill($dst, 0, 0, $current_transparent);
                    imagecolortransparent($dst, $current_transparent);
                } else {
                    imagefill($dst, 0, 0, $bgcolor);
                }
            } else {
                imagefill($dst, 0, 0, $bgcolor);
            }
        }

        imagecopyresampled($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

        // sharpen 적용
        if($is_sharpen && $is_large) {
            $val = explode('/', $um_value);
            UnsharpMask($dst, $val[0], $val[1], $val[2]);
        }

        if($size[2] == 1) {
            imagegif($dst, $thumb_file);
        } else if($size[2] == 3) {
            $png_compress = 5;
            imagepng($dst, $thumb_file, $png_compress);
        } else {
            $jpg_quality = 90;

            imagejpeg($dst, $thumb_file, $jpg_quality);
        }

        chmod($thumb_file, 0644); // 추후 삭제를 위하여 파일모드 변경

        imagedestroy($src);
        imagedestroy($dst);

        return basename($thumb_file);
    }

    //셀렉트 박스 만들기
    public static function select_box($select_name, $value, $key, $selected_val='',$route_link='')
    {
        $value_cut = explode("@@",$value);
        $key_cut = explode("@@",$key);

        $select_disp = "<select name='{$select_name}' id='{$select_name}' {$route_link}>";
        if($route_link != ""){
            $select_disp .= "
                <option value='' >전체</option>
            ";
        }
        for($i = 0; $i < count($value_cut); $i++){
            $selected = "";
            if($key_cut[$i] == $selected_val) $selected = "selected";
            $select_disp .= "
                <option value='$key_cut[$i]' $selected>$value_cut[$i]</option>
            ";
        }

        $select_disp .= "</select>";

        return $select_disp;
    }

    //게시물 삭제시 스마트 에디터 첨부 파일 까지 삭제 하기
    public static function editor_img_del($content, $editor_path)
    {
        //$content = 본문 내용
        //$editor_path = 저장된 스마트 에디터 첨부 경록
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);
        for($y = 0; $y < count($matches[1]); $y++){
            $tmp_cut = explode("/",$matches[1][$y]);
            $last_file_name = end($tmp_cut);
            $editor_img_del = $editor_path."/".$last_file_name;

            if (file_exists($editor_img_del)) {
                @unlink($editor_img_del); //이미지 삭제
            }
        }
        return true;
    }

    //디렉토리에 있는 하위 디렉토리 까지 전부 삭제
    function rmdir_ok($dir) {
        $dirs = dir($dir);
        while(false !== ($entry = $dirs->read())) {
            if(($entry != '.') && ($entry != '..')) {
                if(is_dir($dir.'/'.$entry)) {
                      $this->rmdir_ok($dir.'/'.$entry);
                } else {
                      @unlink($dir.'/'.$entry);
                }
            }
        }
        $dirs->close();
        @rmdir($dir);
    }

}
