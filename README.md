<b><h5>초보 라라벨 사용자 데모용 개발 입니다. 막코딩!!!</h5></b>

<b><h4>1. 버전 정보</h4></b>
VMWARE : 15

OS : Ubuntu 20.04.2 LTS

php : 7.4.21

Mysql : Ver 8.0.26

Composer : 1.10.1

Laravel : 8

네이버 스마트에디터 : smarteditor2-2.8.2.3
<br>
<br>
<b><h4>2. 설치 정보</h4></b>
1. composer create-project laravel/laravel dev_board

2. ----- DB 설정
mysql -uroot -p	//비번 1
create user kim identified by '1';	//있으면 패스

CREATE DATABASE dev_board default CHARACTER SET UTF8;
GRANT ALL privileges ON dev_board.* TO 'kim'@'%';
flush privileges;

3. .env 편집 -- DB 편집

4. php artisan migrate
<br>
<br>
<b><h4>3. 설명</h4></b>

1. 쎄팅 이후 메인페이지 로딩시 관리자 1명 자동 생성

2. 회원 로그인, 정보 수정, 이미지 첨부, 비밀번호 변경

/adm 관리자 이동
3. 회원 관리 등록, 수정

4. 게시판 관리
    - 게시판 추가(첨부 디렉토리 생성)
    - 게시판 설정
       - 첨부 파일 사용 갯수
       - 게시판 종류(일반 게시판, 갤러리 게시판)
       - 이미지 리사이징 갯수
       - 게시판 접근 권한(목록,쓰기,보기,수정,삭제,답글)
       - 게시판 카테고리 생성
       - 댓글 사용 유무
       - 비밀글 사용 유무
    - 게시판 삭제
        - 삭제시 첨부 파일 디랙토리 같이 삭제

5. 각 생성된 게시판
    - 리스트(관리자 선택 삭제)
    - 글쓰기(스마트 에디터 이용)
        - 비밀글 처리
        - 에디터 이미지 첨부시 크기 조절 기능
    - 글보기
        - 댓글 쓰기(댓글의 답글, 수정, 삭제)
    - 수정 : 수정시 스머트 에디터 이미지 첨부물 처리... 고민중
    - 삭제
        - 삭제시 본문 내용에 포함된 스마트에디터 이미지도 같이 삭제
        
