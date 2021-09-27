<?php
#############################################################################
#
#		파일이름		:		Messages_kr.php
#		파일설명		:		한글 언어팩
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 02일
#		최종수정일		:		2021년 07월 02일
#
###########################################################################-->

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Messages_kr extends Controller
{
    static $fatal_fail_ment = [
        /** 회원가입 관련 */
        'fatal_fail'  => [
            'error' => '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.',
        ]
    ];

    static $blade_ment = [
        /** 회원가입 관련 */
        'join'  => [
            'title_join' => '회원가입',
            'submit_join' => '가입 하기',
            'user_id' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_name' => '이름을 입력 하세요.',
            'user_pw' => '비밀번호를 입력 하세요.',
            'user_pw_confirmation' => '비밀번호를 확인 하세요.',
            'user_phone' => '전화번호를 입력 하세요.',
        ],

        /** 로그인 관련 */
        'login'  => [
            'title_login' => '로그인',
            'submit_login' => '로그인 하기',
            'user_id' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => '비밀번호를 입력 하세요.',
            'remember' => '로그인 기억하기',
            'remember_help' => '(공용 컴퓨터에서는 사용하지 마세요!)',
            'ask_registration' => '회원이 아니라면? <a href=":url"> 가입하세요. </a>',
            'ask_forgot' => '<a href=":url"> 비밀번호를 잊으셨나요? </a>',
        ]
    ];

    static $join_confirm_ment = [
        /** 회원가입 관련 */
        'confirm'  => [
            'join_confirm' => '회원가입을 확인해주세요.',
            'join_success' => '회원가입을 축하 합니다.',
            'adm_join_success' => '저장 되었습니다.',
        ]
    ];

    static $validate = [
        /** 회원가입 관련 */
        'join' => [
            'user_id.unique' => '이미 사용하고 있는 아이디 입니다.',
            'user_id.required' => '아이디를 이메일 형식에 맞춰 입력하세요.',

            'user_id.regex' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => '아이디를 200자 이하를 입력하세요.',


            'user_name.required' => '이름을 입력하세요.',
            'user_name.max' => '이름 60자 이하를 입력하세요.',

            'user_pw.required' => '비밀번호를 입력하세요.',
            'user_pw.min' => '비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => '비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => '비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => '비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => '비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => '비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => '비밀번호를 정확하게 입력하세요',

            //'user_email.regex' => '이메일 형식에 맞춰 입력하세요.',
            //'user_email.max' => '이메일을 200자 이하를 입력하세요.',

            'user_phone.required' => '전화번호를 20자 이하를 입력하세요.',
        ]
    ];

    static $email_certificate = [
        /** 회원가입 관련 */
        'email_certificate' => [
            'name_welcome' => '님, 환영합니다.',
            'join_open' => '가입 확인을 위해 브라우저에서 다음 주소를 열어 주세요:',
            'email_confirm_fail' => 'URL 이 정확 하지 않습니다.',
            'email_confirm_success' => '환영 합니다. 가입 확인 되었습니다. 로그인 하세요.',
        ]
    ];

    static $login_Validator = [
        'login_Validator' => [
            'user_id.required' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => '아이디를 200자 이하를 입력하세요.',

            'user_pw.required' => '비밀번호를 입력하세요.',
            'user_pw.min' => '비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => '비밀번호 16자 이하를 입력하세요.',
        ]
    ];

    static $login_chk = [
        'login_chk' => [
            'login_chk' => '회원이 아니거나 탈퇴 회원 일수 있습니다.\n아이디 또는 비빌번호를 확인 하세요.',
            'email_chk' => '메일 인증이 필요 합니다.',
            'login_ok' => '환영합니다.',
        ]
    ];

    static $logout_chk = [
        'logout' => [
            'logout' => '안녕히 가세요.',
        ]
    ];

    static $pwchange = [
        'pwchange' => [
            'title_change' => '비밀번호 변경',
            'desc_change' => '가입한 이메일로 비밀번호 변경 안내 메일이 발송 됩니다.',
            'user_id' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'send_change' => '비밀번호 메일 발송',

            'user_id.required' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => '아이디를 200자 이하를 입력하세요.',
            'user_id.exists' => '아이디가 존재 하지 않습니다. 다시 입력 하세요.',

            'email_change' => '비밀번호 변경 안내 메일 입니다.',
            'email_body' => '비밀번호를 변경려면 브라우저에서 이 주소를 여세요 : ',
            'email_send' => '가입 하신 이메일로 비밀번호 변경 안내 보내 드립니다.',
        ]
    ];

    static $pwreset = [
        'pwreset' => [
            'title_reset' => '비밀번호 변경',
            'desc_reset' => '회원가입한 이메일을 입력하고 새로운 비밀번호를 입력하세요.',

            'user_id' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => '새로운 비밀번호를 입력 하세요.',
            'user_pw_confirmation' => '새로운 비밀번호를 확인 하세요.',

            'send_reset' => '비밀번호 변경',
            'sent_reminder' => '비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 메일박스를 확인하세요.',
            'error_wrong_url' => 'URL이 정확하지 않습니다.',
            'success_reset' => '비밀번호를 바꾸었습니다. 새로운 비밀번호로 로그인하세요.',
        ],

        'pwreset_Validator' => [
            'user_id.required' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.regex' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_id.max' => '아이디를 200자 이하를 입력하세요.',
            'user_id.exists' => '아이디가 존재 하지 않습니다. 다시 입력 하세요.',

            'user_pw.required' => '새로운 비밀번호를 입력하세요.',
            'user_pw.min' => '새로운 비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => '새로운 비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => '새로운 비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => '새로운 비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => '새로운 비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => '새로운 비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => '새로운 비밀번호를 정확하게 입력하세요',
        ],

        'pwreset_false' => [
            'pwreset_false' => '잘못된 요청입니다. 이메일로 받은 주소를 정확히 입력해 주세요.',
            'pwsame_false' => '기존 비밀번호와 같습니다. 다른 비밀번호를 입력 하세요.',
            'pwreset_ok' => '정상적으로 비밀 번호가 변경 되었습니다. 새로운 비밀번호로 로그인 하세요.',
        ],

        'pwreset_ok' => [
            'pwreset_ok' => '정상적으로 비밀 번호가 변경 되었습니다. 새로운 비밀번호로 로그인 하세요.',
        ]
    ];

    static $main = [
        'main' => [
            'title_main' => '메인 페이지 입니다.',
        ]
    ];

    static $mypage = [
        'mypage' => [
            'title_mypage' => 'MYPAGE 페이지 입니다.',
            'title_id' => '아이디',
            'title_name' => '이름',
            'title_pw' => '비밀번호',
            'title_pw_confirmation' => '비밀번호 확인',
            'title_phone' => '전화번호',
            'title_image' => '이미지',
            'submit_join' => '저장 하기',
            'pw_change' => '비밀번호 변경 하기',
            'join_date' => '회원 가입일',

            'user_name' => '이름을 입력 하세요.',
            'user_pw' => '비밀번호를 입력 하세요.',
            'user_pw_confirmation' => '비밀번호를 확인 하세요.',
            'user_pw_same' => '비밀번호를 정확하게 입력하세요',
            'user_phone' => '전화번호를 입력 하세요.',

            'alert_pw' => '비밀번호를 입력 하세요.',
            'alert_pw_confirmation' => '비밀번호 확인을 입력 하세요.',

            'my_change' => '정상적으로 변경 되었습니다',
            'withdraw_ok' => '정상적으로 탈퇴 되었습니다',
        ],

        'validate' => [
            'user_pw.required' => '비밀번호를 입력하세요.',
            'user_pw.min' => '비밀번호 6자 이상을 입력하세요.',
            'user_pw.max' => '비밀번호 16자 이하를 입력하세요.',
            'user_pw.confirmed' => '비밀번호 확인을 확인 하세요.',

            'user_pw_confirmation.required' => '비밀번호 확인을 입력하세요.',
            'user_pw_confirmation.min' => '비밀번호 확인을 6자 이상을 입력하세요.',
            'user_pw_confirmation.max' => '비밀번호 확인을 16자 이하를 입력하세요.',
            'user_pw_confirmation.same' => '비밀번호를 정확하게 입력하세요',

            'pwsame_false' => '기존 비밀번호와 같습니다. 다른 비밀번호를 입력 하세요.',
            'pwchange_ok' => '비밀번호가 변경 되었습니다. 다시 로그인 하세요.',
            'admpwchange_ok' => '비밀번호가 변경 되었습니다.',
            'img_del_ok' => '이미지가 삭제 되었습니다.',
        ]
    ];

    static $file_chk = [
        'file_chk' => [
            'user_imagepath.*.max' => '10kb를 초과할 수 없습니다',
            'user_imagepath.*.mimes' => 'jpeg,jpg,gif의 파일만 등록됩니다',

            'file_false' => '첨부 파일이 잘못 되었습니다.',
        ]
    ];


/********** 추가 사항 나중에 영문에도 추가 하면 됨 */
//관리자 관련
    static $adm_log_ment = [
        /** 로그인 관련 */
        'admlogin'  => [
            'title_login' => '관리자 로그인',
            'submit_login' => '로그인 하기',
            'user_id' => '아이디를 이메일 형식에 맞춰 입력하세요.',
            'user_pw' => '비밀번호를 입력 하세요.',
        ]
    ];

    static $adm_login_chk = [
        'login_chk' => [
            'login_chk' => '관리자 아이디 또는 비빌번호 확인 하세요.',
            'login_ok' => '관리자 로그인 되었습니다.',
        ]
    ];

    static $adm_mem_chk = [
        'mem_chk' => [
            'out_ok' => '처리 되었습니다.',
        ]
    ];

    static $boardmanage = [
        'bm' => [
            'bmm_title' => '게시판 목록 및 추가',
            'bmm_subtitle' => '설치된 게시판 리스트',
            'bmm_tb_name' => '게시판명',
            'bmm_tb_subject' => '게시판제목',
            'bmm_tb_add_ok' => '게시판이 추가 되었습니다.',
            'bmm_tb_up_ok' => '게시판이 수정 되었습니다.',
        ]
    ];

//게시판 관련
    static $board = [
        'b_ment' => [
            'b_list_chk' => '글목록 권한이 없습니다.',
            'b_list_ment' => '글목록',
            'b_write_chk' => '글쓰기 권한이 없습니다.',
            'b_view_chk' => '글보기 권한이 없습니다.',
            'b_comment_chk' => '댓글 권한이 없습니다.',
            'b_write_ment' => '글쓰기',
            'b_del_chk' => '삭제 권한이 없습니다.',
            'b_del_ment' => '삭제',
            'b_reply_chk' => '답글 권한이 없습니다.',
            'b_reply_ment' => '답글쓰기',
            'b_modi_ment' => '수정',
            'b_choice_del_ment' => '선택삭제',
            'b_save' => '저장 되었습니다.',
            'b_modi' => '수정 되었습니다.',
            'b_del' => '삭제 되었습니다.',
            'b_pwno' => '비밀번호가 맞지 않습니다.',
            'b_set' => '게시판 설정을 확인 하세요.',
            'time_over' => '글쓰기 시간이 초과 되었습니다.',
        ]
    ];

    static $board_file_chk = [
        'board_file_chk' => [
            'bdt_file1.size' => '10kb를 초과할 수 없습니다',
            'file_false' => '첨부 파일이 잘못 되었습니다.',
        ]
    ];

    static $board_manage = [
        'validate' => [
            'bm_tb_name.required' => '게시판명을 입력하세요.',
            'bm_tb_name.unique' => '같은 게시판명이 존재 합니다.',
            'bm_tb_name.max' => '20자 이하로 작성 하세요.',
        ]
    ];

    static $board_editor = [
        'editor' => [
            'del_ok' => '정상적으로 삭제 되었습니다.',
        ]
    ];

    static $category = [
        'insert' => [
            'in_ok' => '카테고리가 추가 되었습니다.',
            'cate_no' => '분류를 더 이상 추가할 수 없습니다.\\n\\n5단계 분류까지만 가능합니다.',
        ],

        'update' => [
            'up_ok' => '카테고리가 수정 되었습니다.',
        ],

        'cate_del' => [
            'cate_del_ok' => '카테고리가 삭제 되었습니다.',
        ],

        'del' => [
            'del_chk' => '하위 카테고리가 있거나 상품이 존재 합니다.',
        ],
    ];

    static $item = [
        'insert' => [
            'in_ok' => '상품이 추가 되었습니다.',
        ],

        'del' => [
            'del_ok' => '상품이 삭제 되었습니다.',
        ],

        'update' => [
            'up_ok' => '상품이 수정 되었습니다.',
        ]
    ];

    static $menu = [
        'insert' => [
            'menu_no' => '분류를 더 이상 추가할 수 없습니다.\\n\\n3단계 분류까지만 가능합니다.',
            'in_ok' => '메뉴가 추가 되었습니다.',
        ],

        'update' => [
            'up_ok' => '메뉴가 수정 되었습니다.',
        ],

        'del' => [
            'del_ok' => '메뉴가 삭제 되었습니다.',
            'del_chk' => '하위 메뉴가 존재 합니다.',
        ],

        'validate' => [
            'mk_menu_id.required' => '분류코드가 생성 되지 않았습니다.',
            'mk_menu_id.unique' => '같은 분류코드가 존재 합니다.',
            'mk_menu_id.max' => '3단계 까지만 생성 됩니다.',

            'menu_name_en.required' => '영문명을 입력 하세요.',
            'menu_name_en.unique' => '같은 영문명이 존재 합니다.',
            'menu_name_en.max' => '20자 이내로 입력 하세요.',

            'menu_name_kr.required' => '한글명을 입력 하세요.',
            'menu_name_kr.max' => '20자 이내로 입력 하세요.',
        ]
    ];

    static $email = [
        'e_ment' => [
            'e_save' => '저장 되었습니다.',
            'e_del' => '삭제 되었습니다.',
            'email_send' => '이메일이 발송 되었습니다.',
            'e_modisave' => '수정 되었습니다.',
        ]
    ];

    //소셜 로그인 관련
    static $social = [
        'join_fail' => '이미 사용하고 있는 아이디 입니다.',
        'join_cencel' => '인증을 취소 하셨습니다.',
        'withdraw_chk' => '탈퇴된 회원입니다.',
    ];

    //팝업 관련
    static $popup = [
        'in_ok' => '저장 되었습니다.',
        'up_ok' => '수정 되었습니다.',
        'del_ok' => '삭제 되었습니다.',
    ];

    //쇼핑몰 관련
    //팝업 관련
    static $shop = [
        'no_data' => '자료가 없습니다.',
        'now_no_item' => '현재 판매가능한 상품이 아닙니다.',
        'in_ok' => '저장 되었습니다.',
        'no_resize' => '상품 등록 전에 환경 설정 > 이미지 리사이징 설정을 입력 저장 하세요.',
        'resize_num' => '이미지 리사이징 3개이상 입력 저장 하세요.',
    ];

}


