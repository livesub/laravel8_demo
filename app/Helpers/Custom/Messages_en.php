<?php
#############################################################################
#
#		파일이름		:		Messages_en.php
#		파일설명		:		영문 언어팩
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 02일
#		최종수정일		:		2021년 07월 02일
#
###########################################################################-->

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Messages_en extends Controller
{
    static $fatal_fail_ment = [
        /** 회원가입 관련 */
        'fatal_fail'  => [
            'error' => 'eng 잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.',
        ]
    ];

    static $blade_ment = [
        /** 회원가입 관련 */
        'join'  => [
            'title_join' => 'eng 회원가입',
            'submit_join' => 'eng 가입 하기',
            'user_id' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_name' => 'eng 이름을 입력 하세요.',
            'user_pw' => 'eng 비밀번호를 입력 하세요.',
            'user_pw_confirmation' => 'eng 비밀번호를 확인 하세요.',
            'user_phone' => 'eng 전화번호를 입력 하세요.',
        ],

        /** 로그인 관련 */
        'login'  => [
            'title_login' => 'eng 로그인',
            'submit_login' => 'eng 로그인 하기',
            'user_id' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => 'eng 비밀번호를 입력 하세요.',
            'remember' => 'eng 로그인 기억하기',
            'remember_help' => 'eng (공용 컴퓨터에서는 사용하지 마세요!)',
            'ask_registration' => 'eng 회원이 아니라면? <a href=":url"> 가입하세요. </a>',
            'ask_forgot' => '<a href=":url"> eng 비밀번호를 잊으셨나요? </a>',
        ]
    ];

    static $join_confirm_ment = [
        /** 회원가입 관련 */
        'confirm'  => [
            'join_confirm' => 'eng 회원가입을 확인해주세요.',
            'join_success' => 'eng 회원가입을 축하 합니다.',
            'adm_join_success' => 'eng 저장 되었습니다.',
        ]
    ];

    static $validate = [
        /** 회원가입 관련 */
        'join' => [
            'user_id.unique' => 'eng 이미 사용하고 있는 아이디 입니다.',
            'user_id.required' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',

            'user_id.regex' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => 'eng 아이디를 200자 이하를 입력하세요.',


            'user_name.required' => 'eng 이름을 입력하세요.',
            'user_name.max' => 'eng 이름 60자 이하를 입력하세요.',

            'user_pw.required' => 'eng 비밀번호를 입력하세요.',
            'user_pw.min' => 'eng 비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => 'eng 비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => 'eng 비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => 'eng 비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => 'eng 비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => 'eng 비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => 'eng 비밀번호를 정확하게 입력하세요',

            //'user_email.regex' => '이메일 형식에 맞춰 입력하세요.',
            //'user_email.max' => '이메일을 200자 이하를 입력하세요.',

            'user_phone.required' => 'eng 전화번호를 20자 이하를 입력하세요.',
        ]
    ];

    static $email_certificate = [
        /** 회원가입 관련 */
        'email_certificate' => [
            'name_welcome' => '님, 환영합니다.',
            'join_open' => 'eng 가입 확인을 위해 브라우저에서 다음 주소를 열어 주세요:',
            'email_confirm_fail' => 'eng URL 이 정확 하지 않습니다.',
            'email_confirm_success' => 'eng 환영 합니다. 가입 확인 되었습니다. 로그인 하세요.',
        ]
    ];

    static $login_Validator = [
        'login_Validator' => [
            'user_id.required' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => 'eng 아이디를 200자 이하를 입력하세요.',

            'user_pw.required' => 'eng 비밀번호를 입력하세요.',
            'user_pw.min' => 'eng 비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => 'eng 비밀번호 16자 이하를 입력하세요.',
        ]
    ];

    static $login_chk = [
        'login_chk' => [
            'login_chk' => 'eng 회원이 아니거나 탈퇴 회원 일수 있습니다.\n아이디 또는 비빌번호를 확인 하세요.',
            'email_chk' => 'eng 메일 인증이 필요 합니다.',
            'login_ok' => 'eng 환영합니다.',
        ]
    ];

    static $logout_chk = [
        'logout' => [
            'logout' => 'eng 안녕히 가세요.',
        ]
    ];

    static $pwchange = [
        'pwchange' => [
            'title_change' => 'eng 비밀번호 변경',
            'desc_change' => 'eng 가입한 이메일로 비밀번호 변경 안내 메일이 발송 됩니다.',
            'user_id' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'send_change' => 'eng 비밀번호 메일 발송',

            'user_id.required' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => 'eng 아이디를 200자 이하를 입력하세요.',
            'user_id.exists' => 'eng 아이디가 존재 하지 않습니다. 다시 입력 하세요.',

            'email_change' => 'eng 비밀번호 변경 안내 메일 입니다.',
            'email_body' => 'eng 비밀번호를 변경려면 브라우저에서 이 주소를 여세요 : ',
            'email_send' => 'eng 가입 하신 이메일로 비밀번호 변경 안내 보내 드립니다.',
        ]
    ];

    static $pwreset = [
        'pwreset' => [
            'title_reset' => 'eng 비밀번호 변경',
            'desc_reset' => 'eng 회원가입한 이메일을 입력하고 새로운 비밀번호를 입력하세요.',

            'user_id' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => 'eng 새로운 비밀번호를 입력 하세요.',
            'user_pw_confirmation' => 'eng 새로운 비밀번호를 확인 하세요.',

            'send_reset' => 'eng 비밀번호 변경',
            'sent_reminder' => 'eng 비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 메일박스를 확인하세요.',
            'error_wrong_url' => 'eng URL이 정확하지 않습니다.',
            'success_reset' => 'eng 비밀번호를 바꾸었습니다. 새로운 비밀번호로 로그인하세요.',
        ],

        'pwreset_Validator' => [
            'user_id.required' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => 'eng 아이디를 200자 이하를 입력하세요.',
            'user_id.exists' => 'eng 아이디가 존재 하지 않습니다. 다시 입력 하세요.',

            'user_pw.required' => 'eng 새로운 비밀번호를 입력하세요.',
            'user_pw.min' => 'eng 새로운 비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => 'eng 새로운 비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => 'eng 새로운 비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => 'eng 새로운 비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => 'eng 새로운 비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => 'eng 새로운 비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => 'eng 새로운 비밀번호를 정확하게 입력하세요',
        ],

        'pwreset_false' => [
            'pwreset_false' => 'eng 잘못된 요청입니다. 이메일로 받은 주소를 정확히 입력해 주세요.',
            'pwsame_false' => 'eng 기존 비밀번호와 같습니다. 다른 비밀번호를 입력 하세요.',
            'pwreset_ok' => 'eng 정상적으로 비밀 번호가 변경 되었습니다. 새로운 비밀번호로 로그인 하세요.',
        ],

        'pwreset_ok' => [
            'pwreset_ok' => 'eng 정상적으로 비밀 번호가 변경 되었습니다. 새로운 비밀번호로 로그인 하세요.',
        ]
    ];

    static $main = [
        'main' => [
            'title_main' => 'eng 메인 페이지 입니다.',
        ]
    ];

    static $mypage = [
        'mypage' => [
            'title_mypage' => 'eng MYPAGE 페이지 입니다.',
            'title_id' => 'eng 아이디',
            'title_name' => 'eng 이름',
            'title_pw' => 'eng 비밀번호',
            'title_pw_confirmation' => 'eng 비밀번호 확인',
            'title_phone' => 'eng 전화번호',
            'title_image' => 'eng 이미지',
            'submit_join' => 'eng 저장 하기',
            'pw_change' => 'eng 비밀번호 변경 하기',
            'join_date' => 'eng 회원 가입일',

            'user_name' => 'eng 이름을 입력 하세요.',
            'user_pw' => 'eng 비밀번호를 입력 하세요.',
            'user_pw_confirmation' => 'eng 비밀번호를 확인 하세요.',
            'user_pw_same' => 'eng 비밀번호를 정확하게 입력하세요',
            'user_phone' => 'eng 전화번호를 입력 하세요.',

            'alert_pw' => 'eng 비밀번호를 입력 하세요.',
            'alert_pw_confirmation' => 'eng 비밀번호 확인을 입력 하세요.',

            'my_change' => 'eng 정상적으로 변경 되었습니다',
        ],

        'validate' => [
            'user_pw.required' => 'eng 비밀번호를 입력하세요.',
            'user_pw.min' => 'eng 비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => 'eng 비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => 'eng 비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => 'eng 비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => 'eng 비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => 'eng 비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => 'eng 비밀번호를 정확하게 입력하세요',

            'pwsame_false' => 'eng 기존 비밀번호와 같습니다. 다른 비밀번호를 입력 하세요.',
            'pwchange_ok' => 'eng 비밀번호가 변경 되었습니다. 다시 로그인 하세요.',
            'admpwchange_ok' => 'eng 비밀번호가 변경 되었습니다.',
            'img_del_ok' => 'eng 이미지가 삭제 되었습니다.',
        ]
    ];

    static $file_chk = [
        'file_chk' => [
            'user_imagepath.*.max' => 'eng 10kb를 초과할 수 없습니다',
            'user_imagepath.*.mimes' => 'jpeg,jpg,gif의 파일만 등록됩니다',

            'file_false' => 'eng 첨부 파일이 잘못 되었습니다.',
        ]
    ];


/********** 추가 사항 나중에 영문에도 추가 하면 됨 */
//관리자 관련
    static $adm_log_ment = [
        /** 로그인 관련 */
        'admlogin'  => [
            'title_login' => 'eng 관리자 로그인',
            'submit_login' => 'eng 로그인 하기',
            'user_id' => 'eng 아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => 'eng 비밀번호를 입력 하세요.',
        ]
    ];

    static $adm_login_chk = [
        'login_chk' => [
            'login_chk' => 'eng 관리자 아이디 또는 비빌번호 확인 하세요.',
            'login_ok' => 'eng 관리자 로그인 되었습니다.',
        ]
    ];

    static $adm_mem_chk = [
        'mem_chk' => [
            'out_ok' => 'eng 처리 되었습니다.',
        ]
    ];

    static $boardmanage = [
        'bm' => [
            'bmm_title' => 'eng 게시판 목록 및 추가',
            'bmm_subtitle' => 'eng 설치된 게시판 리스트',
            'bmm_tb_name' => 'eng 게시판명',
            'bmm_tb_subject' => 'eng 게시판제목',
            'bmm_tb_add_ok' => 'eng 게시판이 추가 되었습니다.',
            'bmm_tb_up_ok' => 'eng 게시판이 수정 되었습니다.',
        ]
    ];

//게시판 관련
    static $board = [
        'b_ment' => [
            'b_list_chk' => 'eng 글목록 권한이 없습니다.',
            'b_list_ment' => 'eng 글목록',
            'b_write_chk' => 'eng 글쓰기 권한이 없습니다.',
            'b_view_chk' => 'eng 글보기 권한이 없습니다.',
            'b_comment_chk' => 'eng 댓글 권한이 없습니다.',
            'b_write_ment' => 'eng 글쓰기',
            'b_del_chk' => 'eng 삭제 권한이 없습니다.',
            'b_del_ment' => 'eng 삭제',
            'b_reply_chk' => 'eng 답글 권한이 없습니다.',
            'b_reply_ment' => 'eng 답글쓰기',
            'b_modi_ment' => 'eng 수정',
            'b_choice_del_ment' => 'eng 선택삭제',
            'b_save' => 'eng 저장 되었습니다.',
            'b_modi' => 'eng 수정 되었습니다.',
            'b_del' => 'eng 삭제 되었습니다.',
            'b_pwno' => 'eng 비밀번호가 맞지 않습니다.',
            'b_set' => 'eng 게시판 설정을 확인 하세요.',
            'time_over' => 'eng 글쓰기 시간이 초과 되었습니다.',
        ]
    ];

    static $board_file_chk = [
        'board_file_chk' => [
            'bdt_file1.size' => '10kb를 초과할 수 없습니다',
            'file_false' => 'eng 첨부 파일이 잘못 되었습니다.',
        ]
    ];

    static $board_manage = [
        'validate' => [
            'bm_tb_name.required' => 'eng 게시판명을 입력하세요.',
            'bm_tb_name.unique' => 'eng 같은 게시판명이 존재 합니다.',
            'bm_tb_name.max' => '20자 이하로 작성 하세요.',
        ]
    ];

    static $board_editor = [
        'editor' => [
            'del_ok' => 'eng 정상적으로 삭제 되었습니다.',
        ]
    ];

    static $category = [
        'insert' => [
            'in_ok' => 'eng 카테고리가 추가 되었습니다.',
            'cate_no' => 'eng 분류를 더 이상 추가할 수 없습니다.\\n\\n5단계 분류까지만 가능합니다.',
        ],

        'update' => [
            'up_ok' => 'eng 카테고리가 수정 되었습니다.',
        ],

        'cate_del' => [
            'cate_del_ok' => 'eng 카테고리가 삭제 되었습니다.',
        ],

        'del' => [
            'del_chk' => 'eng 하위 카테고리가 있거나 상품이 존재 합니다.',
        ],
    ];

    static $item = [
        'insert' => [
            'in_ok' => 'eng 상품이 추가 되었습니다.',
        ],

        'del' => [
            'del_ok' => 'eng 상품이 삭제 되었습니다.',
        ],

        'update' => [
            'up_ok' => 'eng 상품이 수정 되었습니다.',
        ]
    ];

    static $menu = [
        'insert' => [
            'menu_no' => 'eng 분류를 더 이상 추가할 수 없습니다.\\n\\n3단계 분류까지만 가능합니다.',
            'in_ok' => 'eng 메뉴가 추가 되었습니다.',
        ],

        'update' => [
            'up_ok' => 'eng 메뉴가 수정 되었습니다.',
        ],

        'del' => [
            'del_ok' => 'eng 메뉴가 삭제 되었습니다.',
            'del_chk' => 'eng 하위 메뉴가 존재 합니다.',
        ],

        'validate' => [
            'mk_menu_id.required' => 'eng 분류코드가 생성 되지 않았습니다.',
            'mk_menu_id.unique' => 'eng 같은 분류코드가 존재 합니다.',
            'mk_menu_id.max' => 'eng 3단계 까지만 생성 됩니다.',

            'menu_name_en.required' => 'eng 영문명을 입력 하세요.',
            'menu_name_en.unique' => 'eng 같은 영문명이 존재 합니다.',
            'menu_name_en.max' => 'eng 20자 이내로 입력 하세요.',

            'menu_name_kr.required' => 'eng 한글명을 입력 하세요.',
            'menu_name_kr.max' => 'eng 20자 이내로 입력 하세요.',
        ]
    ];

    static $email = [
        'e_ment' => [
            'e_save' => 'eng 저장 되었습니다.',
            'e_del' => 'eng 삭제 되었습니다.',
            'email_send' => 'eng 이메일이 발송 되었습니다.',
            'e_modisave' => 'eng 수정 되었습니다.',
        ]
    ];

}


