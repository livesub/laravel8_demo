<b><h4>1. 버전 정보</h4></b>
Ubuntu : 20.04.2 LTS
php : 7.4.21
Mysql : Ver 8.0.26
Composer : 1.10.1
Laravel : 8

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

<b><h4>3. 설명</h4></b>

