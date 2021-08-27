<?php

namespace App\Http\Controllers\adm\admstatistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\UserAgent; //통계 관련 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\visits;    //통계 모델 정의

class StatisticsContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function statistics()
    {
        $customutils = new CustomUtils();
        $Messages = $customutils->language_pack(session()->get('multi_lang'));

        if ($customutils->get_cookie('ck_visit_ip') != $_SERVER['REMOTE_ADDR'])
        {
            $details = $customutils->ip_details($_SERVER['REMOTE_ADDR']);

            //접속 브라우져 등 정보
            $ua = new UserAgent();
            $agent_info = $ua->detect($_SERVER['HTTP_USER_AGENT']);
        	//print_r($ua->detect($_SERVER['HTTP_USER_AGENT']));
            $customutils->set_cookie('ck_visit_ip', $_SERVER['REMOTE_ADDR'], 86400); // 하루동안 저장

            $vi_id = visits::max('vi_id') + 1;

            // $_SERVER 배열변수 값의 변조를 이용한 SQL Injection 공격을 막는 코드입니다. 110810
            $remote_addr = $_SERVER['REMOTE_ADDR'];

            $referer = "";
            if (isset($_SERVER['HTTP_REFERER']))
                $referer = strip_tags($_SERVER['HTTP_REFERER']);
            $user_agent  = strip_tags($_SERVER['HTTP_USER_AGENT']);

            $vi_browser = $agent_info['browser']['name'];
            $vi_os = $agent_info['platform']['name'];
            $vi_device = $agent_info['system']['name'];


            //DB 저장 배열 만들기
            $data = array(
                'vi_id'         => $vi_id,
                'vi_ip'         => $remote_addr,
                'vi_referer'    => $referer,
                'vi_agent'      => $user_agent,
                'vi_browser'    => $vi_browser,
                'vi_os'         => $vi_os,
                'vi_device'     => $vi_device,
                'vi_city'       => $details['city'],
                'vi_country'    => $details['country'],
            );

            //저장 처리
            $create_result = visits::create($data);
            $create_result->save();










/*
            //추가 디테일 하게 꾸밀시 사용 (라라벨로 변환)
            if($in_result){

                $in_sum_sql = " insert into ncp_visit_sum set vs_count = 1, vs_date = '{$now_ymd}' ";
                $in_sum_ment = "<br>쿼리내용 - 방문 합계 입력쿼리<br>쿼리 - ".$in_sum_sql;
                $in_sum_result = mysql_query($in_sum_sql) or die(mysql_errno()." : ".mysql_error().$in_sum_ment);

                // DUPLICATE 오류가 발생한다면 이미 날짜별 행이 생성되었으므로 UPDATE 실행
                if (!$in_sum_result) {
                    $up_sum_sql = " update ncp_visit_sum set vs_count = vs_count + 1 where vs_date = '{$now_ymd}' ";
                    $up_sum_ment = "<br>쿼리내용 - 방문 합계 업뎃 쿼리<br>쿼리 - ".$up_sum_sql;
                    $up_sum_result = mysql_query($up_sum_sql) or die(mysql_errno()." : ".mysql_error().$up_sum_ment);
                }


        /* 접속자수 보이게 할때
                // 오늘
                $today_sql = " select vs_count as cnt from ncp_visit_sum where vs_date = '{$now_ymd}' ";
                $today_ment = "쿼리내용 - 오늘 정보 추출 쿼리<br>쿼리 - ".$today_sql;
                $today_result = mysql_query($today_sql) or die($today_ment);
                $today_row = mysql_fetch_array($today_result);

                $vi_today = isset($today_row['cnt']) ? $today_row['cnt'] : 0;


                // 어제
                $yesterday_sql = " select vs_count as cnt from ncp_visit_sum where vs_date = DATE_SUB('{$now_ymd}', INTERVAL 1 DAY) ";
                $yesterday_ment = "쿼리내용 - 어제 정보 추출 쿼리<br>쿼리 - ".$yesterday_sql;
                $yesterday_result = mysql_query($yesterday_sql) or die($yesterday_ment);
                $yesterday_row = mysql_fetch_array($yesterday_result);
                $vi_yesterday = isset($yesterday_row['cnt']) ? $yesterday_row['cnt'] : 0;


                // 최대
                $max_sql = " select max(vs_count) as cnt from ncp_visit_sum ";
                $max_ment = "쿼리내용 - 최대 정보 추출 쿼리<br>쿼리 - ".$max_sql;
                $max_result = mysql_query($max_sql) or die($max_ment);
                $max_row = mysql_fetch_array($max_result);
                $vi_max = isset($max_row['cnt']) ? $max_row['cnt'] : 0;


                // 전체
                $sum_sql = " select sum(vs_count) as total from ncp_visit_sum ";
                $sum_ment = "쿼리내용 - 최대 정보 추출 쿼리<br>쿼리 - ".$sum_sql;
                $sum_result = mysql_query($sum_sql) or die($sum_ment);
                $sum_row = mysql_fetch_array($sum_result);
                $vi_sum = isset($sum_row['total']) ? $sum_row['total'] : 0;


                $visit = '오늘:'.$vi_today.',어제:'.$vi_yesterday.',최대:'.$vi_max.',전체:'.$vi_sum;

                //sql_query(" update {$g5['config_table']} set cf_visit = '{$visit}' ");

            }
*/

        }
    }
}
