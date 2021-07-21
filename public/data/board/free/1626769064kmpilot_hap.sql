

DROP TABLE IF EXISTS `CMS_SMS_DATA`;
CREATE TABLE IF NOT EXISTS `CMS_SMS_DATA` (
  `IDX` int NOT NULL AUTO_INCREMENT,
  `SEND_TYPE` enum('P','C','K') NOT NULL COMMENT 'P: 포털, C: 관리자, K:카톡친구톡',
  `SMS_TYPE` enum('M','S','K') DEFAULT 'S',
  `SPHONE1` varchar(5) NOT NULL,
  `SPHONE2` varchar(5) NOT NULL,
  `SPHONE3` varchar(5) NOT NULL,
  `SMS_MSG` mediumtext NOT NULL,
  `S_COUNT` smallint NOT NULL DEFAULT '0',
  `REG_DATE` int NOT NULL,
  `IS_DEL` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDX`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `CMS_SMS_RESULT`
--

DROP TABLE IF EXISTS `CMS_SMS_RESULT`;
CREATE TABLE IF NOT EXISTS `CMS_SMS_RESULT` (
  `IDX` int NOT NULL AUTO_INCREMENT,
  `PARENTIDX` int UNSIGNED NOT NULL,
  `USER_ID` varchar(50) DEFAULT NULL,
  `RPHONE1` varchar(5) NOT NULL,
  `RPHONE2` varchar(5) NOT NULL,
  `RPHONE3` varchar(5) NOT NULL,
  `RECV_NAME` varchar(50) NOT NULL,
  `R_MSG` mediumtext NOT NULL,
  `LINK_FILE` varchar(255) DEFAULT NULL,
  `REG_DATE` int NOT NULL,
  `RECEIVE` enum('0','1') NOT NULL DEFAULT '1',
  `RESULT` tinyint NOT NULL,
  `ERRCODE` varchar(50) DEFAULT NULL,
  `SEND_RESULT` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1' COMMENT '0:실패, 1: 성공',
  `IS_DEL` enum('0','1') DEFAULT '0' COMMENT '삭제 플래그 테이블(0 : 미삭제 1;삭제)',
  PRIMARY KEY (`IDX`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `CMS_SMS_SETUP`
--

DROP TABLE IF EXISTS `CMS_SMS_SETUP`;
CREATE TABLE IF NOT EXISTS `CMS_SMS_SETUP` (
  `IDX` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `SMS_STATE` enum('0','1') NOT NULL DEFAULT '0',
  `SMS_TYPE` enum('S','M') NOT NULL,
  `SMS_NAME` varchar(100) NOT NULL,
  `SMS_CONT` mediumtext NOT NULL,
  `SMS_CONT_LEN` smallint NOT NULL DEFAULT '0',
  `REG_DATE` int NOT NULL,
  `REG_IP` varchar(15) NOT NULL,
  `MODIFY_DATE` int DEFAULT NULL,
  `MODIFY_IP` varchar(15) DEFAULT NULL,
  KEY `IDX` (`IDX`),
  KEY `SMS_STATE` (`SMS_STATE`),
  KEY `SMS_TYPE` (`SMS_TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `CMS_SMS_SETUP`
--

INSERT INTO `CMS_SMS_SETUP` (`IDX`, `SMS_STATE`, `SMS_TYPE`, `SMS_NAME`, `SMS_CONT`, `SMS_CONT_LEN`, `REG_DATE`, `REG_IP`, `MODIFY_DATE`, `MODIFY_IP`) VALUES
(1, '1', 'S', '인사말1', '{NAME}회원님 안녕하십니까 한국도선사협회 김명석차장입니다.1', 59, 1437768104, '121.126.219.76', 1437772828, '121.126.219.76');

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_auth`
--

DROP TABLE IF EXISTS `kmp_auth`;
CREATE TABLE IF NOT EXISTS `kmp_auth` (
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `au_menu` varchar(20) NOT NULL DEFAULT '',
  `au_auth` set('r','w','d') NOT NULL DEFAULT '',
  PRIMARY KEY (`mb_id`,`au_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `kmp_auth`
--



-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_autosave`
--

DROP TABLE IF EXISTS `kmp_autosave`;
CREATE TABLE IF NOT EXISTS `kmp_autosave` (
  `as_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint UNSIGNED NOT NULL,
  `as_subject` varchar(255) NOT NULL,
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `kmp_autosave`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_board`
--
-- 
DROP TABLE IF EXISTS `kmp_board`;
CREATE TABLE IF NOT EXISTS `kmp_board` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `bo_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `bo_admin` varchar(255) NOT NULL DEFAULT '',
  `bo_list_level` tinyint NOT NULL DEFAULT '0',
  `bo_read_level` tinyint NOT NULL DEFAULT '0',
  `bo_write_level` tinyint NOT NULL DEFAULT '0',
  `bo_reply_level` tinyint NOT NULL DEFAULT '0',
  `bo_comment_level` tinyint NOT NULL DEFAULT '0',
  `bo_upload_level` tinyint NOT NULL DEFAULT '0',
  `bo_download_level` tinyint NOT NULL DEFAULT '0',
  `bo_html_level` tinyint NOT NULL DEFAULT '0',
  `bo_link_level` tinyint NOT NULL DEFAULT '0',
  `bo_count_delete` tinyint NOT NULL DEFAULT '0',
  `bo_count_modify` tinyint NOT NULL DEFAULT '0',
  `bo_read_point` int NOT NULL DEFAULT '0',
  `bo_write_point` int NOT NULL DEFAULT '0',
  `bo_comment_point` int NOT NULL DEFAULT '0',
  `bo_download_point` int NOT NULL DEFAULT '0',
  `bo_use_category` tinyint NOT NULL DEFAULT '0',
  `bo_category_list` text NOT NULL,
  `bo_use_sideview` tinyint NOT NULL DEFAULT '0',
  `bo_use_file_content` tinyint NOT NULL DEFAULT '0',
  `bo_use_secret` tinyint NOT NULL DEFAULT '0',
  `bo_use_dhtml_editor` tinyint NOT NULL DEFAULT '0',
  `bo_select_editor` varchar(50) NOT NULL DEFAULT '',
  `bo_use_rss_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_good` tinyint NOT NULL DEFAULT '0',
  `bo_use_nogood` tinyint NOT NULL DEFAULT '0',
  `bo_use_name` tinyint NOT NULL DEFAULT '0',
  `bo_use_signature` tinyint NOT NULL DEFAULT '0',
  `bo_use_ip_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_file` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_content` tinyint NOT NULL DEFAULT '0',
  `bo_table_width` int NOT NULL DEFAULT '0',
  `bo_subject_len` int NOT NULL DEFAULT '0',
  `bo_mobile_subject_len` int NOT NULL DEFAULT '0',
  `bo_page_rows` int NOT NULL DEFAULT '0',
  `bo_mobile_page_rows` int NOT NULL DEFAULT '0',
  `bo_new` int NOT NULL DEFAULT '0',
  `bo_hot` int NOT NULL DEFAULT '0',
  `bo_image_width` int NOT NULL DEFAULT '0',
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_include_head` varchar(255) NOT NULL DEFAULT '',
  `bo_include_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_content_head` text NOT NULL,
  `bo_mobile_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int NOT NULL DEFAULT '0',
  `bo_gallery_width` int NOT NULL DEFAULT '0',
  `bo_gallery_height` int NOT NULL DEFAULT '0',
  `bo_mobile_gallery_width` int NOT NULL DEFAULT '0',
  `bo_mobile_gallery_height` int NOT NULL DEFAULT '0',
  `bo_upload_size` int NOT NULL DEFAULT '0',
  `bo_reply_order` tinyint NOT NULL DEFAULT '0',
  `bo_use_search` tinyint NOT NULL DEFAULT '0',
  `bo_order` int NOT NULL DEFAULT '0',
  `bo_count_write` int NOT NULL DEFAULT '0',
  `bo_count_comment` int NOT NULL DEFAULT '0',
  `bo_write_min` int NOT NULL DEFAULT '0',
  `bo_write_max` int NOT NULL DEFAULT '0',
  `bo_comment_min` int NOT NULL DEFAULT '0',
  `bo_comment_max` int NOT NULL DEFAULT '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint NOT NULL DEFAULT '0',
  `bo_use_email` tinyint NOT NULL DEFAULT '0',
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '',
  `bo_use_sns` tinyint NOT NULL DEFAULT '0',
  `bo_use_captcha` tinyint NOT NULL DEFAULT '0',
  `bo_sort_field` varchar(255) NOT NULL DEFAULT '',
  `bo_1_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_2_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_3_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_4_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_5_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_6_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_7_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_8_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_9_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_10_subj` varchar(255) NOT NULL DEFAULT '' COMMENT '댓글사용여부 컬럼',
  `bo_1` varchar(255) NOT NULL DEFAULT '',
  `bo_2` varchar(255) NOT NULL DEFAULT '',
  `bo_3` varchar(255) NOT NULL DEFAULT '',
  `bo_4` varchar(255) NOT NULL DEFAULT '',
  `bo_5` varchar(255) NOT NULL DEFAULT '',
  `bo_6` varchar(255) NOT NULL DEFAULT '',
  `bo_7` varchar(255) NOT NULL DEFAULT '',
  `bo_8` varchar(255) NOT NULL DEFAULT '',
  `bo_9` varchar(255) NOT NULL DEFAULT '',
  `bo_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bo_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `kmp_board` (`bo_table`, `gr_id`, `bo_subject`, `bo_mobile_subject`, `bo_device`, `bo_admin`, `bo_list_level`, `bo_read_level`, `bo_write_level`, `bo_reply_level`, `bo_comment_level`, `bo_upload_level`, `bo_download_level`, `bo_html_level`, `bo_link_level`, `bo_count_delete`, `bo_count_modify`, `bo_read_point`, `bo_write_point`, `bo_comment_point`, `bo_download_point`, `bo_use_category`, `bo_category_list`, `bo_use_sideview`, `bo_use_file_content`, `bo_use_secret`, `bo_use_dhtml_editor`, `bo_select_editor`, `bo_use_rss_view`, `bo_use_good`, `bo_use_nogood`, `bo_use_name`, `bo_use_signature`, `bo_use_ip_view`, `bo_use_list_view`, `bo_use_list_file`, `bo_use_list_content`, `bo_table_width`, `bo_subject_len`, `bo_mobile_subject_len`, `bo_page_rows`, `bo_mobile_page_rows`, `bo_new`, `bo_hot`, `bo_image_width`, `bo_skin`, `bo_mobile_skin`, `bo_include_head`, `bo_include_tail`, `bo_content_head`, `bo_mobile_content_head`, `bo_content_tail`, `bo_mobile_content_tail`, `bo_insert_content`, `bo_gallery_cols`, `bo_gallery_width`, `bo_gallery_height`, `bo_mobile_gallery_width`, `bo_mobile_gallery_height`, `bo_upload_size`, `bo_reply_order`, `bo_use_search`, `bo_order`, `bo_count_write`, `bo_count_comment`, `bo_write_min`, `bo_write_max`, `bo_comment_min`, `bo_comment_max`, `bo_notice`, `bo_upload_count`, `bo_use_email`, `bo_use_cert`, `bo_use_sns`, `bo_use_captcha`, `bo_sort_field`, `bo_1_subj`, `bo_2_subj`, `bo_3_subj`, `bo_4_subj`, `bo_5_subj`, `bo_6_subj`, `bo_7_subj`, `bo_8_subj`, `bo_9_subj`, `bo_10_subj`, `bo_1`, `bo_2`, `bo_3`, `bo_4`, `bo_5`, `bo_6`, `bo_7`, `bo_8`, `bo_9`, `bo_10`) VALUES
('edu_notice_kr', 'community', '공지사항', '', '', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 5, 5, 24, 100, 600, 'edu_basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('events_newsletter', 'community', '경조사 · 뉴스레터', '', '', '', 2, 2, 9, 9, 9, 9, 2, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 900, 'newsletter_basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('free', 'community', '자유게시판', '', '', '', 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 2, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', ''),
('hongbo', 'community', '홍보영상', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 54, 26, 6, 5, 24, 100, 900, 'hongbo', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 3, 300, 200, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('information', 'community', '정보게시판', '', '', '', 2, 2, 9, 9, 9, 9, 2, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('meeting_official', 'community', '회의 · 공문서', '', '', '', 2, 2, 9, 9, 9, 9, 2, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 900, 'pdf_basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('news_en', 'community', 'News', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('notice_en', 'community', 'Notice', '', '', '', 1, 1, 9, 9, 9, 1, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 1, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('notice_kr', 'community', '공지사항', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 400, 'basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 10, 0, 0, 0, 0, '5', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', ''),
('passage_plan', 'community', 'Passage Plan', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 1, '부산항 | 여수항 | 인천항 | 울산항 | 평택항 | 마산항 | 대산항 | 포항항 | 군산항 | 목포항 | 동해항 | 제주항', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'passage_plan_basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('pds', 'community', '자료실', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 10, 5, 24, 100, 600, 'pds', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('photo_news', 'community', '포토뉴스', '', '', '', 1, 1, 9, 9, 9, 9, 1, 9, 9, 1, 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 1, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 54, 30, 6, 5, 24, 100, 900, 'photo_news', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 3, 300, 200, 125, 100, 73400320, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_board_file`
--

DROP TABLE IF EXISTS `kmp_board_file`;
CREATE TABLE IF NOT EXISTS `kmp_board_file` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `bf_no` int NOT NULL DEFAULT '0',
  `bf_source` varchar(255) NOT NULL DEFAULT '',
  `bf_file` varchar(255) NOT NULL DEFAULT '',
  `bf_download` int NOT NULL,
  `bf_content` text NOT NULL,
  `bf_fileurl` varchar(255) NOT NULL DEFAULT '',
  `bf_thumburl` varchar(255) NOT NULL DEFAULT '',
  `bf_storage` varchar(50) NOT NULL DEFAULT '',
  `bf_filesize` int NOT NULL DEFAULT '0',
  `bf_width` int NOT NULL DEFAULT '0',
  `bf_height` smallint NOT NULL DEFAULT '0',
  `bf_type` tinyint NOT NULL DEFAULT '0',
  `bf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_board_good`
--

DROP TABLE IF EXISTS `kmp_board_good`;
CREATE TABLE IF NOT EXISTS `kmp_board_good` (
  `bg_id` int NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bg_flag` varchar(255) NOT NULL DEFAULT '',
  `bg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_board_new`
--

DROP TABLE IF EXISTS `kmp_board_new`;
CREATE TABLE IF NOT EXISTS `kmp_board_new` (
  `bn_id` int NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `wr_parent` int NOT NULL DEFAULT '0',
  `bn_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_cert_history`
--

DROP TABLE IF EXISTS `kmp_cert_history`;
CREATE TABLE IF NOT EXISTS `kmp_cert_history` (
  `cr_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `cr_company` varchar(255) NOT NULL DEFAULT '',
  `cr_method` varchar(255) NOT NULL DEFAULT '',
  `cr_ip` varchar(255) NOT NULL DEFAULT '',
  `cr_date` date NOT NULL DEFAULT '0000-00-00',
  `cr_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_config`
--

DROP TABLE IF EXISTS `kmp_config`;
CREATE TABLE IF NOT EXISTS `kmp_config` (
  `cf_title` varchar(255) NOT NULL DEFAULT '',
  `cf_theme` varchar(100) NOT NULL DEFAULT '',
  `cf_admin` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email_name` varchar(100) NOT NULL DEFAULT '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint NOT NULL DEFAULT '0',
  `cf_point_term` int NOT NULL DEFAULT '0',
  `cf_use_copy_log` tinyint NOT NULL DEFAULT '0',
  `cf_use_email_certify` tinyint NOT NULL DEFAULT '0',
  `cf_login_point` int NOT NULL DEFAULT '0',
  `cf_cut_name` tinyint NOT NULL DEFAULT '0',
  `cf_nick_modify` int NOT NULL DEFAULT '0',
  `cf_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_new_rows` int NOT NULL DEFAULT '0',
  `cf_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_read_point` int NOT NULL DEFAULT '0',
  `cf_write_point` int NOT NULL DEFAULT '0',
  `cf_comment_point` int NOT NULL DEFAULT '0',
  `cf_download_point` int NOT NULL DEFAULT '0',
  `cf_write_pages` int NOT NULL DEFAULT '0',
  `cf_mobile_pages` int NOT NULL DEFAULT '0',
  `cf_link_target` varchar(50) NOT NULL DEFAULT '',
  `cf_bbs_rewrite` tinyint NOT NULL DEFAULT '0',
  `cf_delay_sec` int NOT NULL DEFAULT '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_syndi_token` varchar(255) NOT NULL,
  `cf_syndi_except` text NOT NULL,
  `cf_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_use_homepage` tinyint NOT NULL DEFAULT '0',
  `cf_req_homepage` tinyint NOT NULL DEFAULT '0',
  `cf_use_tel` tinyint NOT NULL DEFAULT '0',
  `cf_req_tel` tinyint NOT NULL DEFAULT '0',
  `cf_use_hp` tinyint NOT NULL DEFAULT '0',
  `cf_req_hp` tinyint NOT NULL DEFAULT '0',
  `cf_use_addr` tinyint NOT NULL DEFAULT '0',
  `cf_req_addr` tinyint NOT NULL DEFAULT '0',
  `cf_use_signature` tinyint NOT NULL DEFAULT '0',
  `cf_req_signature` tinyint NOT NULL DEFAULT '0',
  `cf_use_profile` tinyint NOT NULL DEFAULT '0',
  `cf_req_profile` tinyint NOT NULL DEFAULT '0',
  `cf_register_level` tinyint NOT NULL DEFAULT '0',
  `cf_register_point` int NOT NULL DEFAULT '0',
  `cf_icon_level` tinyint NOT NULL DEFAULT '0',
  `cf_use_recommend` tinyint NOT NULL DEFAULT '0',
  `cf_recommend_point` int NOT NULL DEFAULT '0',
  `cf_leave_day` int NOT NULL DEFAULT '0',
  `cf_search_part` int NOT NULL DEFAULT '0',
  `cf_email_use` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_group_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_board_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_write` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_comment_all` tinyint NOT NULL DEFAULT '0',
  `cf_email_mb_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_mb_member` tinyint NOT NULL DEFAULT '0',
  `cf_email_po_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int NOT NULL DEFAULT '0',
  `cf_memo_del` int NOT NULL DEFAULT '0',
  `cf_visit_del` int NOT NULL DEFAULT '0',
  `cf_popular_del` int NOT NULL DEFAULT '0',
  `cf_optimize_date` date NOT NULL DEFAULT '0000-00-00',
  `cf_use_member_icon` tinyint NOT NULL DEFAULT '0',
  `cf_member_icon_size` int NOT NULL DEFAULT '0',
  `cf_member_icon_width` int NOT NULL DEFAULT '0',
  `cf_member_icon_height` int NOT NULL DEFAULT '0',
  `cf_member_img_size` int NOT NULL DEFAULT '0',
  `cf_member_img_width` int NOT NULL DEFAULT '0',
  `cf_member_img_height` int NOT NULL DEFAULT '0',
  `cf_login_minutes` int NOT NULL DEFAULT '0',
  `cf_image_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_flash_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_movie_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_formmail_is_member` tinyint NOT NULL DEFAULT '0',
  `cf_page_rows` int NOT NULL DEFAULT '0',
  `cf_mobile_page_rows` int NOT NULL DEFAULT '0',
  `cf_visit` varchar(255) NOT NULL DEFAULT '',
  `cf_max_po_id` int NOT NULL DEFAULT '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_open_modify` int NOT NULL DEFAULT '0',
  `cf_memo_send_point` int NOT NULL DEFAULT '0',
  `cf_mobile_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_captcha_mp3` varchar(255) NOT NULL DEFAULT '',
  `cf_editor` varchar(50) NOT NULL DEFAULT '',
  `cf_cert_use` tinyint NOT NULL DEFAULT '0',
  `cf_cert_ipin` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_hp` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcb_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_lg_mid` varchar(100) NOT NULL DEFAULT '',
  `cf_lg_mert_key` varchar(100) NOT NULL DEFAULT '',
  `cf_cert_limit` int NOT NULL DEFAULT '0',
  `cf_cert_req` tinyint NOT NULL DEFAULT '0',
  `cf_sms_use` varchar(255) NOT NULL DEFAULT '',
  `cf_sms_type` varchar(10) NOT NULL DEFAULT '',
  `cf_icode_id` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_pw` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_ip` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_server_port` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_token_key` varchar(100) NOT NULL DEFAULT '',
  `cf_googl_shorturl_apikey` varchar(50) NOT NULL DEFAULT '',
  `cf_social_login_use` tinyint NOT NULL DEFAULT '0',
  `cf_social_servicelist` varchar(255) NOT NULL DEFAULT '',
  `cf_payco_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_payco_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_facebook_appid` varchar(100) NOT NULL,
  `cf_facebook_secret` varchar(100) NOT NULL,
  `cf_twitter_key` varchar(100) NOT NULL,
  `cf_twitter_secret` varchar(100) NOT NULL,
  `cf_google_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_google_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_rest_key` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_client_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_js_apikey` varchar(100) NOT NULL,
  `cf_captcha` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_site_key` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_1_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_2_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_3_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_4_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_5_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_6_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_7_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_8_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_9_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_10_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_1` varchar(255) NOT NULL DEFAULT '',
  `cf_2` varchar(255) NOT NULL DEFAULT '',
  `cf_3` varchar(255) NOT NULL DEFAULT '',
  `cf_4` varchar(255) NOT NULL DEFAULT '',
  `cf_5` varchar(255) NOT NULL DEFAULT '',
  `cf_6` varchar(255) NOT NULL DEFAULT '',
  `cf_7` varchar(255) NOT NULL DEFAULT '',
  `cf_8` varchar(255) NOT NULL DEFAULT '',
  `cf_9` varchar(255) NOT NULL DEFAULT '',
  `cf_10` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `kmp_config`
--

INSERT INTO `kmp_config` VALUES ('한국도선사협회','','root','kkte02@naver.com','한국도선사협회','',0,0,1,0,0,15,60,'basic',3,'basic','basic','basic',0,0,0,0,10,5,'_blank',0,30,'18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ','','','','','','','basic',0,0,1,0,1,1,1,1,1,0,1,0,1,1000,1,0,0,0,10000,1,0,0,0,0,0,0,0,0,'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객','',30,180,180,180,'2021-02-18',0,50000,60,60,50000,100,120,10,'gif|jpg|jpeg|png','swf','asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',1,5,15,'오늘:1,어제:1,최대:1,전체:26',0,'해당 홈페이지에 맞는 회원가입약관을 입력합니다.','해당 홈페이지에 맞는 개인정보처리방침을 입력합니다.',0,0,'basic','basic','basic','basic','basic','basic','smarteditor2',0,'','','','','','',2,0,'icode','','yongsanzip','1q2w3e4r','211.172.232.124','7295','','',0,'','','','','','','','','','','','','','','kcaptcha','','','','','','','','','','','','','','','','','','','','','','');

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_content`
--

DROP TABLE IF EXISTS `kmp_content`;
CREATE TABLE IF NOT EXISTS `kmp_content` (
  `co_id` varchar(20) NOT NULL DEFAULT '',
  `co_html` tinyint NOT NULL DEFAULT '0',
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` longtext NOT NULL,
  `co_seo_title` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `co_tag_filter_use` tinyint NOT NULL DEFAULT '0',
  `co_hit` int NOT NULL DEFAULT '0',
  `co_include_head` varchar(255) NOT NULL,
  `co_include_tail` varchar(255) NOT NULL,
  PRIMARY KEY (`co_id`),
  KEY `co_seo_title` (`co_seo_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `kmp_content`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_edu_new_win`
--

DROP TABLE IF EXISTS `kmp_edu_new_win`;
CREATE TABLE IF NOT EXISTS `kmp_edu_new_win` (
  `nw_id` int NOT NULL AUTO_INCREMENT,
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int NOT NULL DEFAULT '0',
  `nw_left` int NOT NULL DEFAULT '0',
  `nw_top` int NOT NULL DEFAULT '0',
  `nw_height` int NOT NULL DEFAULT '0',
  `nw_width` int NOT NULL DEFAULT '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `en_nw_subject` text NOT NULL,
  `en_nw_content` text NOT NULL,
  `nw_content_html` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`nw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_faq`
--

DROP TABLE IF EXISTS `kmp_faq`;
CREATE TABLE IF NOT EXISTS `kmp_faq` (
  `fa_id` int NOT NULL AUTO_INCREMENT,
  `fm_id` int NOT NULL DEFAULT '0',
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_faq_master`
--

DROP TABLE IF EXISTS `kmp_faq_master`;
CREATE TABLE IF NOT EXISTS `kmp_faq_master` (
  `fm_id` int NOT NULL AUTO_INCREMENT,
  `fm_subject` varchar(255) NOT NULL DEFAULT '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`fm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `kmp_faq_master`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `kmp_group`
--

DROP TABLE IF EXISTS `kmp_group`;
CREATE TABLE IF NOT EXISTS `kmp_group` (
  `gr_id` varchar(10) NOT NULL DEFAULT '',
  `gr_subject` varchar(255) NOT NULL DEFAULT '',
  `gr_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `gr_admin` varchar(255) NOT NULL DEFAULT '',
  `gr_use_access` tinyint NOT NULL DEFAULT '0',
  `gr_order` int NOT NULL DEFAULT '0',
  `gr_1_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_2_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_3_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_4_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_5_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_6_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_7_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_8_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_9_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_10_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_1` varchar(255) NOT NULL DEFAULT '',
  `gr_2` varchar(255) NOT NULL DEFAULT '',
  `gr_3` varchar(255) NOT NULL DEFAULT '',
  `gr_4` varchar(255) NOT NULL DEFAULT '',
  `gr_5` varchar(255) NOT NULL DEFAULT '',
  `gr_6` varchar(255) NOT NULL DEFAULT '',
  `gr_7` varchar(255) NOT NULL DEFAULT '',
  `gr_8` varchar(255) NOT NULL DEFAULT '',
  `gr_9` varchar(255) NOT NULL DEFAULT '',
  `gr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `kmp_group` (`gr_id`, `gr_subject`, `gr_device`, `gr_admin`, `gr_use_access`, `gr_order`, `gr_1_subj`, `gr_2_subj`, `gr_3_subj`, `gr_4_subj`, `gr_5_subj`, `gr_6_subj`, `gr_7_subj`, `gr_8_subj`, `gr_9_subj`, `gr_10_subj`, `gr_1`, `gr_2`, `gr_3`, `gr_4`, `gr_5`, `gr_6`, `gr_7`, `gr_8`, `gr_9`, `gr_10`) VALUES
('1', '지방도선사회', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('2', '도선사협회', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('3', '사무장', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('4', '도선사회 회원', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('5', '일반회원', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('6', '도선사회 회장', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('7', '퇴직 도선사', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('8', '도선수습생', 'both', '', 1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('community', '커뮤니티', 'both', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');



DROP TABLE IF EXISTS `kmp_group_member`;
CREATE TABLE IF NOT EXISTS `kmp_group_member` (
  `gm_id` int NOT NULL AUTO_INCREMENT,
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `gm_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_group_member_check`;
CREATE TABLE IF NOT EXISTS `kmp_group_member_check` (
  `gmc_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '' COMMENT '회원 아이디',
  `bo_table` varchar(20) NOT NULL DEFAULT '' COMMENT '테이블 명',
  `wr_id` int NOT NULL COMMENT '테이블 순서',
  `gr_id` varchar(20) NOT NULL DEFAULT '' COMMENT '그룹 아이디',
  `gmc_date` datetime NOT NULL COMMENT '들어온 시간',
  `mb_name` varchar(20) NOT NULL DEFAULT '' COMMENT '회원 이름',
  `mb_doseongu` varchar(45) NOT NULL DEFAULT '' COMMENT '회원 도선구',
  PRIMARY KEY (`gmc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='특정 그룹이 들어왔는지 확인하는 테이블';



DROP TABLE IF EXISTS `kmp_login`;
CREATE TABLE IF NOT EXISTS `kmp_login` (
  `lo_ip` varchar(100) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `lo_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY (`lo_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_mail`;
CREATE TABLE IF NOT EXISTS `kmp_mail` (
  `ma_id` int NOT NULL AUTO_INCREMENT,
  `ma_subject` varchar(255) NOT NULL DEFAULT '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL DEFAULT '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_main_image`;
CREATE TABLE IF NOT EXISTS `kmp_main_image` (
  `idx` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '기본키',
  `subject` varchar(255) NOT NULL COMMENT '제목',
  `image_name` varchar(255) NOT NULL COMMENT '이미지 이름',
  `image_ment1` varchar(255) NOT NULL COMMENT '이미지 배경에 노출 ment1',
  `image_ment2` varchar(255) NOT NULL COMMENT '이미지 배경에 노출 ment2',
  `image_ment3` varchar(255) NOT NULL COMMENT '이미지 배경에 노출 ment3',
  `turn` int UNSIGNED NOT NULL COMMENT '출력순서',
  `type` enum('A','E') NOT NULL DEFAULT 'A' COMMENT '협회/교육통합 선택',
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='메인이미지(협회/교육통합)';



DROP TABLE IF EXISTS `kmp_member`;
CREATE TABLE IF NOT EXISTS `kmp_member` (
  `mb_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_password` varchar(255) NOT NULL DEFAULT '',
  `mb_name` varchar(255) NOT NULL DEFAULT '',
  `mb_nick` varchar(255) NOT NULL DEFAULT '',
  `mb_nick_date` varchar(30) NOT NULL DEFAULT '',
  `mb_email` varchar(255) NOT NULL DEFAULT '',
  `mb_homepage` varchar(255) NOT NULL DEFAULT '',
  `mb_level` tinyint NOT NULL DEFAULT '0',
  `mb_sex` char(3) NOT NULL DEFAULT '',
  `mb_birth` varchar(20) DEFAULT 'null',
  `mb_tel` varchar(255) NOT NULL DEFAULT '',
  `mb_hp` varchar(255) NOT NULL DEFAULT '',
  `mb_certify` varchar(20) NOT NULL DEFAULT '',
  `mb_adult` tinyint NOT NULL DEFAULT '0',
  `mb_dupinfo` varchar(255) NOT NULL DEFAULT '',
  `mb_zip1` char(3) NOT NULL DEFAULT '',
  `mb_zip2` char(3) NOT NULL DEFAULT '',
  `mb_addr1` varchar(255) NOT NULL DEFAULT '',
  `mb_addr2` varchar(255) NOT NULL DEFAULT '',
  `mb_addr3` varchar(255) NOT NULL DEFAULT '',
  `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL DEFAULT '',
  `mb_point` int NOT NULL DEFAULT '0',
  `mb_today_login` varchar(30) NOT NULL DEFAULT '',
  `mb_login_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_datetime` varchar(30) NOT NULL DEFAULT '',
  `mb_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_leave_date` varchar(8) NOT NULL DEFAULT '',
  `mb_intercept_date` varchar(8) NOT NULL DEFAULT '',
  `mb_email_certify` varchar(30) NOT NULL DEFAULT '',
  `mb_email_certify2` varchar(255) NOT NULL DEFAULT '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint NOT NULL DEFAULT '0',
  `mb_sms` tinyint NOT NULL DEFAULT '0',
  `mb_open` tinyint NOT NULL DEFAULT '0',
  `mb_open_date` varchar(30) NOT NULL DEFAULT '',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL DEFAULT '',
  `mb_memo_cnt` int NOT NULL DEFAULT '0',
  `mb_scrap_cnt` int NOT NULL DEFAULT '0',
  `mb_doseongu` varchar(50) NOT NULL DEFAULT '' COMMENT '도선구',
  `mb_lead_code` varchar(255) NOT NULL DEFAULT '' COMMENT '도선약호',
  `mb_license_mean` varchar(255) NOT NULL DEFAULT '' COMMENT '면허 종류',
  `mb_first_license_day` varchar(30) NOT NULL DEFAULT '' COMMENT '최초 면허 발급일',
  `mb_license_renewal_day` varchar(30) NOT NULL DEFAULT '' COMMENT '면허 갱신일',
  `mb_validity_day_from` varchar(30) NOT NULL DEFAULT '' COMMENT '면허 유효기간 부터',
  `mb_validity_day_to` varchar(30) NOT NULL DEFAULT '' COMMENT '면허 유효기간 까지',
  `mb_license_ext_day_from` varchar(30) NOT NULL DEFAULT '' COMMENT '정년 연장 기간 부터',
  `mb_license_ext_day_to` varchar(30) NOT NULL DEFAULT '' COMMENT '정년 연장 기간 까지',
  `required_pilot_status_from` varchar(30) NOT NULL DEFAULT '' COMMENT '국가 필수 도선사 부터',
  `required_pilot_status_to` varchar(30) NOT NULL DEFAULT '' COMMENT '국가 필수 도선사 까지',
  `mb_retire_date` VARCHAR(4) NOT NULL DEFAULT '' COMMENT '퇴직연도',
  PRIMARY KEY (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회원정보 테이블';



INSERT INTO `kmp_member` (`mb_no`, `mb_id`, `mb_password`, `mb_name`, `mb_nick`, `mb_nick_date`, `mb_email`, `mb_homepage`, `mb_level`, `mb_sex`, `mb_birth`, `mb_tel`, `mb_hp`, `mb_certify`, `mb_adult`, `mb_dupinfo`, `mb_zip1`, `mb_zip2`, `mb_addr1`, `mb_addr2`, `mb_addr3`, `mb_addr_jibeon`, `mb_signature`, `mb_recommend`, `mb_point`, `mb_today_login`, `mb_login_ip`, `mb_datetime`, `mb_ip`, `mb_leave_date`, `mb_intercept_date`, `mb_email_certify`, `mb_email_certify2`, `mb_memo`, `mb_lost_certify`, `mb_mailling`, `mb_sms`, `mb_open`, `mb_open_date`, `mb_profile`, `mb_memo_call`, `mb_memo_cnt`, `mb_scrap_cnt`, `mb_doseongu`, `mb_lead_code`, `mb_license_mean`, `mb_first_license_day`, `mb_license_renewal_day`, `mb_validity_day_from`, `mb_validity_day_to`, `mb_license_ext_day_from`, `mb_license_ext_day_to`, `required_pilot_status_from`, `required_pilot_status_to`,`mb_retire_date`) VALUES
(1, 'root', '3c6e99c3c38b0b3eb97a9e42eed0e8c8', '최고관리자', '최고관리자', '', 'kkte02@naver.com', '', 9, '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', 265, '2021-01-18 09:07:53', '::1', '2021-01-08 10:06:22', '::1', '', '', '2021-01-08 10:06:22', '', '', '', 1, 0, 1, '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '');

INSERT INTO `kmp_member` (`mb_no`, `mb_id`, `mb_password`, `mb_name`, `mb_nick`, `mb_nick_date`, `mb_email`, `mb_homepage`, `mb_level`, `mb_sex`, `mb_birth`, `mb_tel`, `mb_hp`, `mb_certify`, `mb_adult`, `mb_dupinfo`, `mb_zip1`, `mb_zip2`, `mb_addr1`, `mb_addr2`, `mb_addr3`, `mb_addr_jibeon`, `mb_signature`, `mb_recommend`, `mb_point`, `mb_today_login`, `mb_login_ip`, `mb_datetime`, `mb_ip`, `mb_leave_date`, `mb_intercept_date`, `mb_email_certify`, `mb_email_certify2`, `mb_memo`, `mb_lost_certify`, `mb_mailling`, `mb_sms`, `mb_open`, `mb_open_date`, `mb_profile`, `mb_memo_call`, `mb_memo_cnt`, `mb_scrap_cnt`, `mb_doseongu`, `mb_lead_code`, `mb_license_mean`, `mb_first_license_day`, `mb_license_renewal_day`, `mb_validity_day_from`, `mb_validity_day_to`, `mb_license_ext_day_from`, `mb_license_ext_day_to`, `required_pilot_status_from`, `required_pilot_status_to`,`mb_retire_date`) VALUES
(2, 'yongsanzip', 'a2dbd25b4228d5cc7e084863c9dea279', '용산집', '용산집', '', 'yskim@yongsanzip.com', '', 10, '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', 265, '2021-01-18 09:07:53', '::1', '2021-01-08 10:06:22', '::1', '', '', '2021-01-08 10:06:22', '', '', '', 1, 0, 1, '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '');



DROP TABLE IF EXISTS `kmp_member_academic_back`;
CREATE TABLE IF NOT EXISTS `kmp_member_academic_back` (
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `high_name` varchar(30) NOT NULL DEFAULT '' COMMENT '고등학교 명',
  `high_major` varchar(30) NOT NULL DEFAULT '' COMMENT '고등학교 전공',
  `high_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '고등학교 졸업여부',
  `university_name` varchar(30) NOT NULL DEFAULT '' COMMENT '대학교 명',
  `university_major` varchar(30) NOT NULL DEFAULT '' COMMENT '대학교 전공',
  `university_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '대학교 졸업여부',
  PRIMARY KEY (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회원 학력사항 테이블';



DROP TABLE IF EXISTS `kmp_member_punishment`;
CREATE TABLE IF NOT EXISTS `kmp_member_punishment` (
  `mbp_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '' COMMENT '회원 아이디',
  `mb_punishment_memo` varchar(50) NOT NULL DEFAULT '' COMMENT '징계에 대한 메모',  
  `mb_punishment` varchar(50) NOT NULL DEFAULT '' COMMENT '징계',
  `mb_punishment_date` date NOT NULL COMMENT '징계일자',
  PRIMARY KEY (`mbp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='징계사항 테이블';



DROP TABLE IF EXISTS `kmp_member_social_profiles`;
CREATE TABLE IF NOT EXISTS `kmp_member_social_profiles` (
  `mp_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `provider` varchar(50) NOT NULL DEFAULT '',
  `object_sha` varchar(45) NOT NULL DEFAULT '',
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `profileurl` varchar(255) NOT NULL DEFAULT '',
  `photourl` varchar(255) NOT NULL DEFAULT '',
  `displayname` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `mp_register_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mp_latest_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `mp_no` (`mp_no`),
  KEY `mb_id` (`mb_id`),
  KEY `provider` (`provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_memo`;
CREATE TABLE IF NOT EXISTS `kmp_memo` (
  `me_id` int NOT NULL AUTO_INCREMENT,
  `me_recv_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  `me_send_id` int NOT NULL DEFAULT '0',
  `me_type` enum('send','recv') NOT NULL DEFAULT 'recv',
  `me_send_ip` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_menu`;
CREATE TABLE IF NOT EXISTS `kmp_menu` (
  `me_id` int NOT NULL AUTO_INCREMENT,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `me_link` varchar(255) NOT NULL DEFAULT '',
  `me_target` varchar(255) NOT NULL DEFAULT '',
  `me_order` int NOT NULL DEFAULT '0',
  `me_use` tinyint NOT NULL DEFAULT '0',
  `me_mobile_use` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`me_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_new_win`;
CREATE TABLE IF NOT EXISTS `kmp_new_win` (
  `nw_id` int NOT NULL AUTO_INCREMENT,
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int NOT NULL DEFAULT '0',
  `nw_left` int NOT NULL DEFAULT '0',
  `nw_top` int NOT NULL DEFAULT '0',
  `nw_height` int NOT NULL DEFAULT '0',
  `nw_width` int NOT NULL DEFAULT '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `en_nw_subject` text NOT NULL,
  `en_nw_content` text NOT NULL,  
  `nw_content_html` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`nw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





DROP TABLE IF EXISTS `kmp_pilot_edu_apply`;
CREATE TABLE IF NOT EXISTS `kmp_pilot_edu_apply` (
  `apply_idx` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '기본키',
  `edu_idx` int UNSIGNED NOT NULL COMMENT '각 교육 edu_idx',
  `edu_type` char(3) NOT NULL DEFAULT 'CR' COMMENT '교육종류 => 면허갱신: CR, 보수:CE, 필수도선사:CC 특별교육:(CN-온,CF-오프)',
  `mb_id` varchar(255) NOT NULL COMMENT '신청자 아이디',
  `mb_name` varchar(255) NOT NULL COMMENT '신청자 이름',
  `apply_cancel` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '교육 신청 취소시 Y:취소, N:취소아님',
  `apply_cancel_date` varchar(50) NOT NULL COMMENT '교육 취소일',
  `apply_date` varchar(50) NOT NULL COMMENT '신청일',
  `lecture_completion_date` varchar(50) NOT NULL COMMENT '수강 수료일(전체 동영상 다 봤을 경우)',
  `lecture_completion_status` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '수강을 완료 했는지 여부(전체 동영상 다 봤을 경우) Y:다봤음, N:아직',
  `certificate_num` int UNSIGNED NOT NULL COMMENT '수료증 순번',
  PRIMARY KEY (`apply_idx`),
  KEY `edu_idx` (`edu_idx`,`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='교육신청및 수강완료여부,수강 취소여부';



DROP TABLE IF EXISTS `kmp_pilot_edu_list`;
CREATE TABLE IF NOT EXISTS `kmp_pilot_edu_list` (
  `edu_idx` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '순번',
  `edu_onoff_type` enum('on','off') NOT NULL DEFAULT 'on' COMMENT '온/오프라인 구분',
  `edu_type` char(3) NOT NULL DEFAULT 'CR' COMMENT '교육종류 => 면허갱신: CR, 보수:CE, 필수도선사:CC 특별교육:(CN-온,CF-오프)',
  `edu_type_name` varchar(255) NOT NULL COMMENT '교육종류명',
  `edu_name_kr` varchar(255) NOT NULL COMMENT '교육명(한글)',
  `edu_name_en` varchar(255) NOT NULL COMMENT '교육명(영문)',
  `edu_way` char(3) NOT NULL DEFAULT 'off' COMMENT '교육방법 오프라인:off, 온라인:on',
  `edu_place` varchar(255) NOT NULL COMMENT '교육장소',
  `edu_time` varchar(50) NOT NULL COMMENT '교육시간',
  `edu_cal_start` varchar(12) NOT NULL COMMENT '교육기간 시작',
  `edu_cal_end` varchar(12) NOT NULL COMMENT '교육기간 끝',
  `edu_cal_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '교육기간 => 0: 종료일 미정, 1 : 종료일 확정=> 날짜 미정으로 변경미정, 1 : 종료일 확정',
  `edu_receipt_start` varchar(12) NOT NULL COMMENT '접수기간 시작',
  `edu_receipt_end` varchar(12) NOT NULL COMMENT '접수기간 끝',
  `edu_receipt_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '접수기간 => 0: 종료일 미정, 1 : 종료일 확정=> 날짜 미정으로 변경미정, 1 : 종료일 확정',
  `edu_receipt_status` enum('I','C','P') NOT NULL DEFAULT 'I' COMMENT '접수현황 => I:접수중, C:접수마감, P:준비중',
  `edu_person` int NOT NULL COMMENT '교육인원',
  `edu_del_type` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제 여부 => Y:삭제, N:미삭제',
  `edu_regi` varchar(50) NOT NULL COMMENT '등록일',
  UNIQUE KEY `edu_idx` (`edu_idx`),
  KEY `edu_type` (`edu_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='교육 리스트';



DROP TABLE IF EXISTS `kmp_pilot_lecture_complet`;
CREATE TABLE IF NOT EXISTS `kmp_pilot_lecture_complet` (
  `complet_idx` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '기본키',
  `lecture_idx` int UNSIGNED NOT NULL COMMENT '각 강의 idx',
  `edu_idx` int UNSIGNED NOT NULL COMMENT '각 교육 edu_idx',
  `apply_idx` int UNSIGNED NOT NULL COMMENT '각 신청 apply_idx',
  `mb_id` varchar(255) NOT NULL COMMENT '신청자 아이디',
  `mb_name` varchar(255) NOT NULL COMMENT '신청자 이름',
  `complet_date` varchar(50) NOT NULL COMMENT '시청완료일',
  PRIMARY KEY (`complet_idx`),
  KEY `lecture_idx` (`lecture_idx`,`edu_idx`,`apply_idx`,`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='시청 완료';



DROP TABLE IF EXISTS `kmp_pilot_lecture_list`;
CREATE TABLE IF NOT EXISTS `kmp_pilot_lecture_list` (
  `lecture_idx` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '강의순번',
  `edu_idx` int UNSIGNED NOT NULL COMMENT '교육순번',
  `edu_onoff_type` enum('on','off') NOT NULL DEFAULT 'on' COMMENT '교육 온/오프라인 구분',
  `edu_type` char(3) NOT NULL DEFAULT 'CR' COMMENT '교육종류 => 면허갱신: CR, 보수:CE, 필수도선사:CC 특별교육:(CN-온,CF-오프)',
  `lecture_subject` varchar(255) NOT NULL COMMENT '강의제목',
  `lecture_name` varchar(50) NOT NULL COMMENT '강사명',
  `lecture_time` int(3) NOT NULL COMMENT '강의시간',
  `lecture_youtube` varchar(255) NOT NULL COMMENT '유튜브 주소',
  `lecture_del_type` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제 여부 => Y:삭제, N:미삭제',
  `lecture_regi` varchar(50) NOT NULL COMMENT '등록일',
  UNIQUE KEY `lecture_idx` (`lecture_idx`),
  KEY `edu_idx` (`edu_idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='강의 리스트';



DROP TABLE IF EXISTS `kmp_point`;
CREATE TABLE IF NOT EXISTS `kmp_point` (
  `po_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `po_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL DEFAULT '',
  `po_point` int NOT NULL DEFAULT '0',
  `po_use_point` int NOT NULL DEFAULT '0',
  `po_expired` tinyint NOT NULL DEFAULT '0',
  `po_expire_date` date NOT NULL DEFAULT '0000-00-00',
  `po_mb_point` int NOT NULL DEFAULT '0',
  `po_rel_table` varchar(20) NOT NULL DEFAULT '',
  `po_rel_id` varchar(20) NOT NULL DEFAULT '',
  `po_rel_action` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_poll`;
CREATE TABLE IF NOT EXISTS `kmp_poll` (
  `po_id` int NOT NULL AUTO_INCREMENT,
  `po_subject` varchar(255) NOT NULL DEFAULT '',
  `po_poll1` varchar(255) NOT NULL DEFAULT '',
  `po_poll2` varchar(255) NOT NULL DEFAULT '',
  `po_poll3` varchar(255) NOT NULL DEFAULT '',
  `po_poll4` varchar(255) NOT NULL DEFAULT '',
  `po_poll5` varchar(255) NOT NULL DEFAULT '',
  `po_poll6` varchar(255) NOT NULL DEFAULT '',
  `po_poll7` varchar(255) NOT NULL DEFAULT '',
  `po_poll8` varchar(255) NOT NULL DEFAULT '',
  `po_poll9` varchar(255) NOT NULL DEFAULT '',
  `po_cnt1` int NOT NULL DEFAULT '0',
  `po_cnt2` int NOT NULL DEFAULT '0',
  `po_cnt3` int NOT NULL DEFAULT '0',
  `po_cnt4` int NOT NULL DEFAULT '0',
  `po_cnt5` int NOT NULL DEFAULT '0',
  `po_cnt6` int NOT NULL DEFAULT '0',
  `po_cnt7` int NOT NULL DEFAULT '0',
  `po_cnt8` int NOT NULL DEFAULT '0',
  `po_cnt9` int NOT NULL DEFAULT '0',
  `po_etc` varchar(255) NOT NULL DEFAULT '',
  `po_level` tinyint NOT NULL DEFAULT '0',
  `po_point` int NOT NULL DEFAULT '0',
  `po_date` date NOT NULL DEFAULT '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_poll_etc`;
CREATE TABLE IF NOT EXISTS `kmp_poll_etc` (
  `pc_id` int NOT NULL DEFAULT '0',
  `po_id` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `pc_name` varchar(255) NOT NULL DEFAULT '',
  `pc_idea` varchar(255) NOT NULL DEFAULT '',
  `pc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_popular`;
CREATE TABLE IF NOT EXISTS `kmp_popular` (
  `pp_id` int NOT NULL AUTO_INCREMENT,
  `pp_word` varchar(50) NOT NULL DEFAULT '',
  `pp_date` date NOT NULL DEFAULT '0000-00-00',
  `pp_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





DROP TABLE IF EXISTS `kmp_qa_config`;
CREATE TABLE IF NOT EXISTS `kmp_qa_config` (
  `qa_title` varchar(255) NOT NULL DEFAULT '',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_use_email` tinyint NOT NULL DEFAULT '0',
  `qa_req_email` tinyint NOT NULL DEFAULT '0',
  `qa_use_hp` tinyint NOT NULL DEFAULT '0',
  `qa_req_hp` tinyint NOT NULL DEFAULT '0',
  `qa_use_sms` tinyint NOT NULL DEFAULT '0',
  `qa_send_number` varchar(255) NOT NULL DEFAULT '0',
  `qa_admin_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_admin_email` varchar(255) NOT NULL DEFAULT '',
  `qa_use_editor` tinyint NOT NULL DEFAULT '0',
  `qa_subject_len` int NOT NULL DEFAULT '0',
  `qa_mobile_subject_len` int NOT NULL DEFAULT '0',
  `qa_page_rows` int NOT NULL DEFAULT '0',
  `qa_mobile_page_rows` int NOT NULL DEFAULT '0',
  `qa_image_width` int NOT NULL DEFAULT '0',
  `qa_upload_size` int NOT NULL DEFAULT '0',
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL DEFAULT '',
  `qa_include_tail` varchar(255) NOT NULL DEFAULT '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_2_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_3_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_4_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_5_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_qa_content`;
CREATE TABLE IF NOT EXISTS `kmp_qa_content` (
  `qa_id` int NOT NULL AUTO_INCREMENT,
  `qa_num` int NOT NULL DEFAULT '0',
  `qa_parent` int NOT NULL DEFAULT '0',
  `qa_related` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `qa_name` varchar(255) NOT NULL DEFAULT '',
  `qa_email` varchar(255) NOT NULL DEFAULT '',
  `qa_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_type` tinyint NOT NULL DEFAULT '0',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_email_recv` tinyint NOT NULL DEFAULT '0',
  `qa_sms_recv` tinyint NOT NULL DEFAULT '0',
  `qa_html` tinyint NOT NULL DEFAULT '0',
  `qa_subject` varchar(255) NOT NULL DEFAULT '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint NOT NULL DEFAULT '0',
  `qa_file1` varchar(255) NOT NULL DEFAULT '',
  `qa_source1` varchar(255) NOT NULL DEFAULT '',
  `qa_file2` varchar(255) NOT NULL DEFAULT '',
  `qa_source2` varchar(255) NOT NULL DEFAULT '',
  `qa_ip` varchar(255) NOT NULL DEFAULT '',
  `qa_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_scrap`;
CREATE TABLE IF NOT EXISTS `kmp_scrap` (
  `ms_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` varchar(15) NOT NULL DEFAULT '',
  `ms_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_uniqid`;
CREATE TABLE IF NOT EXISTS `kmp_uniqid` (
  `uq_id` bigint UNSIGNED NOT NULL,
  `uq_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`uq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_visit`;
CREATE TABLE IF NOT EXISTS `kmp_visit` (
  `vi_id` int NOT NULL DEFAULT '0',
  `vi_ip` varchar(100) NOT NULL DEFAULT '',
  `vi_date` date NOT NULL DEFAULT '0000-00-00',
  `vi_time` time NOT NULL DEFAULT '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(200) NOT NULL DEFAULT '',
  `vi_browser` varchar(255) NOT NULL DEFAULT '',
  `vi_os` varchar(255) NOT NULL DEFAULT '',
  `vi_device` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_visit_sum`;
CREATE TABLE IF NOT EXISTS `kmp_visit_sum` (
  `vs_date` date NOT NULL DEFAULT '0000-00-00',
  `vs_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







-- 게시판 자동 생성 체이블
DROP TABLE IF EXISTS `kmp_write_edu_notice_kr`;
CREATE TABLE IF NOT EXISTS `kmp_write_edu_notice_kr` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_events_newsletter`;
CREATE TABLE IF NOT EXISTS `kmp_write_events_newsletter` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_write_free`;
CREATE TABLE IF NOT EXISTS `kmp_write_free` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `kmp_write_hongbo`;
CREATE TABLE IF NOT EXISTS `kmp_write_hongbo` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_write_information`;
CREATE TABLE IF NOT EXISTS `kmp_write_information` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `kmp_write_meeting_official`;
CREATE TABLE IF NOT EXISTS `kmp_write_meeting_official` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_news_en`;
CREATE TABLE IF NOT EXISTS `kmp_write_news_en` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_notice_en`;
CREATE TABLE IF NOT EXISTS `kmp_write_notice_en` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_notice_kr`;
CREATE TABLE IF NOT EXISTS `kmp_write_notice_kr` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_pds`;
CREATE TABLE IF NOT EXISTS `kmp_write_pds` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `kmp_write_photo_news`;
CREATE TABLE IF NOT EXISTS `kmp_write_photo_news` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 게시판 끝



DROP TABLE IF EXISTS `SMS_CONFIG`;
CREATE TABLE IF NOT EXISTS `SMS_CONFIG` (
  `IDX` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `MKEY` varchar(30) NOT NULL,
  `SKEY` varchar(30) NOT NULL,
  `VALUE` longtext NOT NULL,
  `HELP` varchar(300) DEFAULT NULL,
  UNIQUE KEY `SKEY` (`SKEY`),
  KEY `IDX` (`IDX`),
  KEY `MKEY` (`MKEY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `SMS_CONFIG`
--

INSERT INTO `SMS_CONFIG` (`IDX`, `MKEY`, `SKEY`, `VALUE`, `HELP`) VALUES
(4, 'CFG', 'cms_DomainURL', 'http://kmpilot.or.kr', '전체 CMS 도메인'),
(1, 'CFG', 'cms_mng', '한국도선사협회', NULL),
(2, 'CFG', 'cms_sms_number', '02-784-6022', NULL),
(3, 'CFG', 'cms_sms_title', '한국도선사협회', NULL);
COMMIT;




drop table if exists `CMS_MAGAZINE_NEW`;
CREATE TABLE `CMS_MAGAZINE_NEW` (
  `IDX` int NOT NULL AUTO_INCREMENT,
  `PARENTIDX` int unsigned NOT NULL,
  `SITE_CODE` varchar(50) NOT NULL,
  `S_YEAR` varchar(4) NOT NULL,
  `S_MONTH` varchar(2) NOT NULL,
  `S_DAY` varchar(2) DEFAULT NULL,
  `SECTION` varchar(10) NOT NULL,
  `M_AUTHOR` varchar(50) NOT NULL,
  `CGCODE` varchar(30) NOT NULL,
  `SCGCODE` varchar(50) DEFAULT NULL,
  `GUBUN` enum('1','2') NOT NULL,
  `DEPTH` smallint NOT NULL,
  `M_TITLE` varchar(150) NOT NULL,
  `M_CONT` mediumtext ,
  `M_IMG` varchar(100) NOT NULL,
  `M_SORT` smallint unsigned NOT NULL DEFAULT '1',
  `C_TITLE` varchar(250) DEFAULT NULL,
  `C_PAGE` varchar(3) DEFAULT NULL,
  `FILENAME_ORG` varchar(255) DEFAULT NULL,
  `FILENAME` varchar(255) DEFAULT NULL,
  `FILETYPE` varchar(30) DEFAULT NULL,
  `C_SORT` smallint unsigned NOT NULL DEFAULT '1',
  `REGI_DATE` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`IDX`),
  KEY `IDX` (`IDX`),
  KEY `PARENTIDX` (`PARENTIDX`),
  KEY `DEPTH` (`DEPTH`),
  KEY `CGCODE` (`CGCODE`),
  KEY `M_SORT` (`M_SORT`),
  KEY `C_SORT` (`C_SORT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




INSERT INTO `CMS_MAGAZINE_NEW` VALUES (1,0,'portal','1988','10','20','창간호','한국도선사협회','D01','','1',1,'1988년 창간호 도선지(통권1호)','','magzine_tit_1233.gif',69,'','','','','',1,''),(2,1,'portal','','','','','','','협회동정','1',2,'','','',69,'화보로 보는 협회 동정 - 편집실','03','001_03.pdf','cad1c14985b7a6ca9a5631ef773434fb.pdf','application/pdf',1,''),(3,1,'portal','','','','','','','권두언','1',2,'','','',69,'「도선」지 창간에 즈음하여 / 김정철','10','001_10.pdf','6cb006ac1dac7be8a65d04510146d6ab.pdf','application/pdf',2,''),(4,1,'portal','','','','','','','창간사','1',2,'','','',69,'「도선」지 창간을 축하드리며 / 진 념','12','001_12.pdf','a0cfae0c0a326489407604be48fdfcbe.pdf','application/pdf',3,''),(5,1,'portal','','','','','','','창간사','1',2,'','','',69,'「도선」지의 역할을 기대하며 / 이명기','13','001_13.pdf','fc414f4df550d7b991a6b66462b0ed87.pdf','application/pdf',4,''),(6,1,'portal','','','','','','','창간사','1',2,'','','',69,'「도선」지의 무궁한 발전을 기원하며 / 박현규','14','001_14.pdf','79bc1584c1d61e1360629db53c871b57.pdf','application/pdf',5,''),(7,1,'portal','','','','','','','특집','1',2,'','','',69,'도선과 도선사 / 편집부','16','001_16.pdf','eefeacb5e10cda3ec6760db71c9f1691.pdf','application/pdf',6,''),(8,1,'portal','','','','','','','도선논단','1',2,'','','',69,'인천항 갑문입거조선 / 김길성','23','001_23.pdf','45e59a0d4bd0026751f2abbce466daa4.pdf','application/pdf',7,''),(9,1,'portal','','','','','','','특별기획','1',2,'','','',69,'도선현장을 가다 - ①인천항 / 유미혜','37','001_37.pdf','78b9414a60343ce4727fb479337da59f.pdf','application/pdf',8,''),(10,1,'portal','','','','','','','고서','1',2,'','','',69,'도선사 연수교육을 마치고','46','001_46.pdf','4b5687b6c6530c2632fc835bfdd59e15.pdf','application/pdf',9,''),(11,1,'portal','','','','','','','에세이','1',2,'','','',69,'생활에세이 | 역전의 묘미','48','001_48.pdf','9ee98c8d116e3ac1da40b59f45eb3672.pdf','application/pdf',10,''),(12,1,'portal','','','','','','','기타','1',2,'','','',69,'근황 | 전덕준 명예도선사','50','001_50.pdf','7777235e3b4d5a6942e0b725e16799eb.pdf','application/pdf',11,''),(13,1,'portal','','','','','','','기타','1',2,'','','',69,'소개 | 수습도선사의 면모','51','001_51.pdf','1b92c839a375663bce684517354c6b06.pdf','application/pdf',12,''),(14,1,'portal','','','','','','','기타','1',2,'','','',69,'고사성어','52','001_52.pdf','14eafbdc6ef47fc3f5ba27458f33192c.pdf','application/pdf',13,''),(15,1,'portal','','','','','','','도선논단','1',2,'','','',69,'소련 도선업무의 구성 / LㆍLㆍKhlebnikov','53','001_53.pdf','4532af75996bb58da29f41ceb52395e0.pdf','application/pdf',14,''),(16,1,'portal','','','','','','','법령코너','1',2,'','','',69,'도선법령의 주요개정내용 / 사무국','68','001_68.pdf','7d0b1e50df251da0c1c993cb843f0d6c.pdf','application/pdf',15,''),(17,1,'portal','','','','','','','자료','1',2,'','','',69,'역대 임원명단','71','001_71.pdf','e2e053f7afb21995e000680294e8b019.pdf','application/pdf',16,''),(18,1,'portal','','','','','','','동정','1',2,'','','',69,'협회 및 회원 소식','76','001_76.pdf','40359e9e23dedcad479ed1e891edd99d.pdf','application/pdf',17,''),(19,1,'portal','','','','','','','도선문예','1',2,'','','',69,'「삶의 현장」/ 이창훈','78','001_78.pdf','8f4e7bb65b056d62bdb0cba4e0b53637.pdf','application/pdf',18,''),(20,1,'portal','','','','','','','교양특집','1',2,'','','',69,'권두시','02','001_02.pdf','4cb9c07ca5f468d58cb23227debabaa5.pdf','application/pdf',19,''),(21,1,'portal','','','','','','','교양특집','1',2,'','','',69,'생활의 지혜 / 64, 취미백과 / 65, 건강교실 / 66, 스포츠교실 / 67','64','001_64.pdf','a7c1cba4e393967fd2f2fe6091c20425.pdf','application/pdf',20,''),(22,1,'portal','','','','','','','교양특집','1',2,'','','',69,'도선게시판','79','001_79.pdf','c675ae207bef000fd7fb74d560250f55.pdf','application/pdf',21,''),(23,1,'portal','','','','','','','교양특집','1',2,'','','',69,'편집후기','80','001_80.pdf','99afa6e389612acc82dda34df624730f.pdf','application/pdf',22,''),(24,1,'portal','','','','','','','교양특집','1',2,'','','',69,'각지회 주소','81','001_81.pdf','a15d9988ec47a09697f8e1c68a145792.pdf','application/pdf',23,''),(25,0,'portal','1989','03','31','봄호','한국도선사협회','D01','','1',1,'1989년 봄호 도선지(통권2호)','','magzine_tit_1211.gif',68,'','','','','',1,''),(26,25,'portal','','','','','','','협회동정','1',2,'','','',68,'화보로 보는 협회 동정 - 편집실','03','','','',1,''),(27,25,'portal','','','','','','','신년사','1',2,'','','',68,'자율과 개방, 경쟁의 바탕위에서 발전지향적 대책을 / 진 념','10','002_10.pdf','ef2b122e8134b8149f11d5b21a593e97.pdf','application/pdf',2,''),(28,25,'portal','','','','','','','권두언','1',2,'','','',68,'해운원로의 사명 / 양시권','12','002_12.pdf','0d49d3643eb60a5b24692eb215a96e80.pdf','application/pdf',3,''),(29,25,'portal','','','','','','','도선논단','1',2,'','','',68,'도선업무에 대한 소고 / 정연직','14','002_14.pdf','318affa3fc29509997fe89af295612e0.pdf','application/pdf',4,''),(30,25,'portal','','','','','','','도선논단','1',2,'','','',68,'안전도선과 예선의 운용 / 윤점동','20','002_20.pdf','d8e107494079e3a4647cf5adae1800e9.pdf','application/pdf',5,''),(31,25,'portal','','','','','','','도선현장을 가다','1',2,'','','',68,'② 마산항 부산스케치/도선사들의 숨결이 살아있는 곳/부산이라는 이름의 유래/ 편집실','27','002_27.pdf','b944c1d1d0f9178fe3c7cbfb89cc8178.pdf','application/pdf',6,''),(32,25,'portal','','','','','','','특별기고','1',2,'','','',68,'도선사와 건강 / 최학영','37','002_37.pdf','4d7db3fdbc076f58040fdac88619a6b6.pdf','application/pdf',7,''),(33,25,'portal','','','','','','','참가보고','1',2,'','','',68,'제6회 간친회의에 참가하고서 / 조진형','44','002_44.pdf','931b9a0e7bd53b38649795f5f056bc1c.pdf','application/pdf',8,''),(34,25,'portal','','','','','','','참가보고','1',2,'','','',68,'IMO 제35차 항해안전소위원회보고서','49','002_49.pdf','69b396923322d041842f5271c6ad24a5.pdf','application/pdf',9,''),(35,25,'portal','','','','','','','동정','1',2,'','','',68,'협회 및 회원소식','54','002_54.pdf','d9aafe46251125aad9efb0cf033d4d26.pdf','application/pdf',10,''),(36,25,'portal','','','','','','','동정','1',2,'','','',68,'89 협회 사업실적 및 계획','59','002_59.pdf','2ddc72457374e89221128f879983d522.pdf','application/pdf',11,''),(37,25,'portal','','','','','','','추모사','1',2,'','','',68,'김창영 선배의 서거를 애도함 / 송정석','61','002_61.pdf','182916d698806963888102bf68cf00e1.pdf','application/pdf',12,''),(38,25,'portal','','','','','','','추모사','1',2,'','','',68,'해운의 큰별이 떨어지다 / 이성재','62','002_62.pdf','1803242f80f234a8d94e3f8db70b0e0b.pdf','application/pdf',13,''),(39,25,'portal','','','','','','','탐방','1',2,'','','',68,'시몬의 집-따스한 사랑이 흐르는 곳','64','002_64.pdf','766a745bfc98245ece1bd883be5f7115.pdf','application/pdf',14,''),(40,25,'portal','','','','','','','교양특집','1',2,'','','',68,'권두시','02','002_02.pdf','8463d284078f36e1bdd70a71196e94a1.pdf','application/pdf',15,''),(41,25,'portal','','','','','','','교양특집','1',2,'','','',68,'교양특집','66','002_66.pdf','f99e23f0a87c2b6a6ddd9b20d1d09771.pdf','application/pdf',16,''),(42,25,'portal','','','','','','','교양특집','1',2,'','','',68,'해사정보','78','002_78.pdf','de72f4bdf5c9cc15de066c309143d465.pdf','application/pdf',17,''),(43,25,'portal','','','','','','','교양특집','1',2,'','','',68,'자료','70','002_70.pdf','bd5977a9eceb2c6518aad5129700f363.pdf','application/pdf',18,''),(44,25,'portal','','','','','','','교양특집','1',2,'','','',68,'토막상식','53','002_53.pdf','5109b78e5449538aeb475e61cda51327.pdf','application/pdf',19,''),(45,25,'portal','','','','','','','교양특집','1',2,'','','',68,'알려드립니다','76','002_76.pdf','27fa5739db8f32ea9cc813da4502a024.pdf','application/pdf',20,''),(46,25,'portal','','','','','','','교양특집','1',2,'','','',68,'각지회주소','80','002_80.pdf','fba7af66ea6db5b2985ac915af941d2e.pdf','application/pdf',21,''),(47,0,'portal','1989','09','03','여름호','한국도선사협회','D01','','1',1,'1989년 여름호 도선지(통권3호)','','magzine_tit_1188.gif',67,'','','','','',1,''),(48,47,'portal','','','','','','','협회동정','1',2,'','','',67,'화보로 보는 협회 동정 - 편집실','03','003_03.pdf','8488abd805d93674789656c28a17b1c7.pdf','application/pdf',1,''),(49,47,'portal','','','','','','','취임사','1',2,'','','',67,'회장 취임인사 / 이용우','10','003_10.pdf','8e14356326f272d77a7776cae6befab2.pdf','application/pdf',2,''),(50,47,'portal','','','','','','','권두언','1',2,'','','',67,'한국 해운의 발전과 도선사의 역할 / 송희수','12','003_12.pdf','82199b422a232fa0c36744da560902ab.pdf','application/pdf',3,''),(51,47,'portal','','','','','','','도선논단','1',2,'','','',67,'한ㆍ일 도선료 체계의 비교 검토 / 김길성','14','003_14.pdf','912aef8d66f9bd7cff189a856c0781c8.pdf','application/pdf',4,''),(52,47,'portal','','','','','','','도선논단','1',2,'','','',67,'한국의 도선사제도에 대한 고찰 / 조진형','23','003_23.pdf','e205a1570d701786973fc61239745ba6.pdf','application/pdf',5,''),(53,47,'portal','','','','','','','도선논단','1',2,'','','',67,'거대형선 조선시 Tug boat의 기본운용법 / 윤점동','31','003_31.pdf','985e66095e100eb733c2979e438723f8.pdf','application/pdf',6,''),(54,47,'portal','','','','','','','도선현장을 가다','1',2,'','','',67,'뜨겁고 힘차게 시작되는 아침,포항항/편집실','41','003_41.pdf','75d1f79001206607179bd57e40824624.pdf','application/pdf',7,''),(55,47,'portal','','','','','','','도선인터뷰','1',2,'','','',67,'영원한 로타리안 - 전 로타리총재 윤영원 도선사 - / 편집실','53','003_53.pdf','45a358183d68152c623f6f4711fa8187.pdf','application/pdf',8,''),(56,47,'portal','','','','','','','특별기고','1',2,'','','',67,'\"원불교와 나\" - 종교와 도선사 - / 선승원','56','003_56.pdf','3784da248e86082e3081cb2a2f335aab.pdf','application/pdf',9,''),(57,47,'portal','','','','','','','참가보고','1',2,'','','',67,'제2회 도선가족 친선체육대회','60','003_60.pdf','56c197155a5e97e93e812dc5e98d0f25.pdf','application/pdf',10,''),(58,47,'portal','','','','','','','탐방','1',2,'','','',67,'바다에서 미래의 꿈을 심는 한국해양소년단 / 김동원','62','003_62.pdf','3d3da8bd29a8dfeb5c9c649e123345fd.pdf','application/pdf',11,''),(59,47,'portal','','','','','','','해외정보 소식','1',2,'','','',67,'IMPA, IMO 및 기타소식','65','003_65.pdf','4bf892db44e851ae81d03a1e99e8356c.pdf','application/pdf',12,''),(60,47,'portal','','','','','','','동정','1',2,'','','',67,'협회 및 회원, 각 지회소식','67','89_여름_동정.pdf','9eb9b2ca8a6a21b9c7d59afb7beeba0c.pdf','application/pdf',13,''),(61,47,'portal','','','','','','','법령코너','1',2,'','','',67,'도선법의 개정방향에 대하여','73','003_73.pdf','afde24df6292f991d99f0ce461013562.pdf','application/pdf',14,''),(62,47,'portal','','','','','','','자료','1',2,'','','',67,'한국도선사 \"도선면장\" 발급연번 현황','75','003_75.pdf','337c7d145a626ef2f20cbb156d5f9b74.pdf','application/pdf',15,''),(63,47,'portal','','','','','','','도선문예','1',2,'','','',67,'30년만에 찾아온목포항 / 이성재','79','003_79.pdf','7c6989dde476ae499e885747ea0e863c.pdf','application/pdf',16,''),(64,47,'portal','','','','','','','교양특집','1',2,'','','',67,'권두시','02','003_02.pdf','9a37fb7fd001f1e9dcc4660d2b19871e.pdf','application/pdf',17,''),(65,47,'portal','','','','','','','교양특집','1',2,'','','',67,'알려드립니다','81','003_81.pdf','2cb2dbe4a8f229f47118cf377d46006e.pdf','application/pdf',18,''),(66,47,'portal','','','','','','','교양특집','1',2,'','','',67,'교양특집','85','003_85.pdf','dfdbeeb2e5f48efcc16b55f33016529b.pdf','application/pdf',19,''),(67,47,'portal','','','','','','','교양특집','1',2,'','','',67,'고사성어','86','003_86.pdf','8d3232557c844a2ec8de6f55a372194b.pdf','application/pdf',20,''),(68,47,'portal','','','','','','','교양특집','1',2,'','','',67,'편집후기','87','','','',21,''),(69,47,'portal','','','','','','','교양특집','1',2,'','','',67,'각지회주소','88','','','',22,''),(70,0,'portal','1989','11','15','가을·겨울호','한국도선사협회','D01','','1',1,'1989년 가을호 도선지(통권4호)','','magzine_tit_1163.gif',66,'','','','','',1,''),(71,70,'portal','','','','','','','협회동정','1',2,'','','',66,'화보로 보는 협회 동정 - 편집실','03','004_03.pdf','aab6db1e3c622f7edd60de713ca55657.pdf','application/pdf',1,''),(72,70,'portal','','','','','','','권두언','1',2,'','','',66,'우리의 안전도선으로 밝고 활기찬 새해를 / 이용우','10','004_10.pdf','be501f32c23b53c76f414d7859f07515.pdf','application/pdf',2,''),(73,70,'portal','','','','','','','도선논단','1',2,'','','',66,'거대형선의 진행타력 및 이와관련된 해난의 실예 / 윤점동','12','004_12.pdf','b79e633e75895949977d73b15d9d346e.pdf','application/pdf',3,''),(74,70,'portal','','','','','','','도선논단','1',2,'','','',66,'한국의 도선사 제도에 대한 고찰ㆍ2 / 조진형','22','004_22.pdf','ff1868e321e6df7d00de6337832e593e.pdf','application/pdf',4,''),(75,70,'portal','','','','','','','특별기획','1',2,'','','',66,'도선현장을 가다④ 21세기 항만신화를 창조하는 여수항 / 백남진','35','004_35.pdf','2d65246e2f3335725ecb046600e149b5.pdf','application/pdf',5,''),(76,70,'portal','','','','','','','도선인터뷰','1',2,'','','',66,'도선 27년의 베테랑, 최용도 도선사 / 편집실','47','004_47.pdf','0265541818d55b812d013123c8a587f3.pdf','application/pdf',6,''),(77,70,'portal','','','','','','','특별기고','1',2,'','','',66,'초대형 해상구조물을 도선하고서 / 이강호','51','004_51.pdf','4f6437fa9c8b4ab621987e899b7cf277.pdf','application/pdf',7,''),(78,70,'portal','','','','','','','특별기고','1',2,'','','',66,'\"예배하는 마음\" -종교와 도선사- / 김진곤','55','004_55.pdf','5ba2d2b119684d2265b706f7769cd4fe.pdf','application/pdf',8,''),(79,70,'portal','','','','','','','칼럼','1',2,'','','',66,'도선업무의 개척자 - 방상표 명예회원님을 모시고 - / 편집실','58','004_58.pdf','bf08ee173d3e6347f8f48aef48e8a5df.pdf','application/pdf',9,''),(80,70,'portal','','','','','','','기획','1',2,'','','',66,'테마기획 | 수습도선사의 변 / 노병호','61','004_61.pdf','1809f5f20c0d3052c2169613d6121421.pdf','application/pdf',10,''),(81,70,'portal','','','','','','','기획','1',2,'','','',66,'테마기획 | 도선사 시험에 합격하고서 / 조수린','63','004_63.pdf','2db796a4669d74b7e294af25c407678b.pdf','application/pdf',11,''),(82,70,'portal','','','','','','','행사보고','1',2,'','','',66,'원로 도선사 초청 위로연 개최 / 편집실','66','004_66.pdf','7b347359951733a7c2c045cdf7903c82.pdf','application/pdf',12,''),(83,70,'portal','','','','','','','행사보고','1',2,'','','',66,'가을비속에서의 도선가족 만남의 장 / 편집실','69','004_69.pdf','6432c433a0323807c0c9b653a33c3b3d.pdf','application/pdf',13,''),(84,70,'portal','','','','','','','도선문예','1',2,'','','',66,'\'술의 독백\' / 이성재','70','004_70.pdf','8d417ce7aeac7c3ee7dcbc35a2fe8bc8.pdf','application/pdf',14,''),(85,70,'portal','','','','','','','동정','1',2,'','','',66,'협회 및 지회소식 / 사무국','72','004_72.pdf','daa65138b886c0d1fb0b13be46dccb11.pdf','application/pdf',15,''),(86,70,'portal','','','','','','','해외정보 소식','1',2,'','','',66,'IMPA, IMO 및 기타소식 / 사무국','77','004_77.pdf','689ceb16fbcb20efa1e4e55ee124ace9.pdf','application/pdf',16,''),(87,70,'portal','','','','','','','법령코너','1',2,'','','',66,'도선법의 연구 / 사무국','81','004_81.pdf','f6faa050fb3fb01eae59a3111d0ff62b.pdf','application/pdf',17,''),(88,70,'portal','','','','','','','자료','1',2,'','','',66,'연도별 도선실적 분석 / 사무국','88','004_88.pdf','7a19b4c50e10ba15e689de5f893154c8.pdf','application/pdf',18,''),(89,70,'portal','','','','','','','교양특집','1',2,'','','',66,'권두시','02','004_02.pdf','e86502a04350c42aeb9cfff2dcca17f9.pdf','application/pdf',19,''),(90,70,'portal','','','','','','','교양특집','1',2,'','','',66,'알려드립니다','95','004_95.pdf','b5475848054dafe091de0df5480a3294.pdf','application/pdf',20,''),(91,70,'portal','','','','','','','교양특집','1',2,'','','',66,'교양특집','97','004_97.pdf','1482f69115dbb744704530407274ae99.pdf','application/pdf',21,''),(92,70,'portal','','','','','','','교양특집','1',2,'','','',66,'고사성어','65','004_65.pdf','33b87b54a4c22127cfa135e88b64c2e6.pdf','application/pdf',22,''),(93,70,'portal','','','','','','','교양특집','1',2,'','','',66,'편집후기','98','004_98.pdf','6b8f6f39918eeda6c1430684ac19136d.pdf','application/pdf',23,''),(94,70,'portal','','','','','','','교양특집','1',2,'','','',66,'각지회주소','99','004_99.pdf','e52210a0e86db3ba13b1a42ecd4eed6d.pdf','application/pdf',24,''),(95,0,'portal','1990','03','28','봄호','한국도선사협회','D01','','1',1,'1990년 봄호 도선지(통권5호)','','magzine_tit_1137.gif',65,'','','','','',1,''),(96,95,'portal','','','','','','','협회동정','1',2,'','','',65,'화보로 보는 협회 동정 - 편집실','03','005_03.pdf','98c26b50ec7dc04b6df98026d6353cda.pdf','application/pdf',1,''),(97,95,'portal','','','','','','','권두언','1',2,'','','',65,'우리의 안전도선으로 밝고 활기찬 새해를 / 이용우','10','005_10.pdf','b38331a5e95cd5f18dfc03aa35204f72.pdf','application/pdf',2,''),(98,95,'portal','','','','','','','취임사','1',2,'','','',65,'해운항만의 좋은 결실을 맺도록 다짐하며 / 안공혁','12','005_12.pdf','4a6fca38ed8110eb420c06194fc89d6a.pdf','application/pdf',3,''),(99,95,'portal','','','','','','','도선칼럼','1',2,'','','',65,'도선제도에 관한 제언 / 김상진','14','005_14.pdf','6e6b449093f474a091ee2ef10eec1bf7.pdf','application/pdf',4,''),(100,95,'portal','','','','','','','도선논단','1',2,'','','',65,'항내조선과 선체조종운동의 기본이론 / 윤점동','18','005_18.pdf','118cdc1683b62d98b53ddc6b7f997a1e.pdf','application/pdf',5,''),(101,95,'portal','','','','','','','도선논단','1',2,'','','',65,'인천항 갑문안전통항 규칙의 소개 / 김길성','27','005_27.pdf','ba74d3eb4af586504e26a8795956bfef.pdf','application/pdf',6,''),(102,95,'portal','','','','','','','도선논단','1',2,'','','',65,'한국의 도선사제도에 대한 고찰ㆍ3 / 조진형','36','005_36.pdf','9ad07e68d41a002d913eb6de9a69b9b4.pdf','application/pdf',7,''),(103,95,'portal','','','','','','','특별기획','1',2,'','','',65,'공업한국의 영예를 새롭게 모색하는 항도, 울산 / 편집실','45','005_45.pdf','ecb14146cf086d1872095259ce2efa33.pdf','application/pdf',8,''),(104,95,'portal','','','','','','','도선인터뷰','1',2,'','','',65,'항상 새로움을 꿈꾸는 로맨티스트 정오언 도선사 / 편집실','55','005_55.pdf','f8fc15201beb1bb173c01a4fcae9aa40.pdf','application/pdf',9,''),(105,95,'portal','','','','','','','특별기고','1',2,'','','',65,'신조 도선선 \"승봉호\"를 건조, 취항함에 있어 / 인천지회','60','005_60.pdf','7bd1f34136f6adc0e152080b459a3630.pdf','application/pdf',10,''),(106,95,'portal','','','','','','','특별기고','1',2,'','','',65,'조선조 마지막 황태자 영친왕 내외를 알현하고 / 윤영원','63','005_63.pdf','83b6a156290839a3e7be877db322569b.pdf','application/pdf',11,''),(107,95,'portal','','','','','','','특별기고','1',2,'','','',65,'초대와 응답 / 주영필','66','005_66.pdf','19b1e0b9663b6feeebff5182c9fca44c.pdf','application/pdf',12,''),(108,95,'portal','','','','','','','기획','1',2,'','','',65,'테마기획 | 도선사가 되기까지, 그 기나긴 여정 / 강완수','72','005_72.pdf','15c4a235729fb93222cb488bf12413c2.pdf','application/pdf',13,''),(109,95,'portal','','','','','','','기획','1',2,'','','',65,'테마기획 | 도선수습을 마치면서 / 김동원','74','005_74.pdf','837a266414dc676507a1d9f734b564be.pdf','application/pdf',14,''),(110,95,'portal','','','','','','','동정','1',2,'','','',65,'협회 및 지회, 회원소식','76','005_76.pdf','a3d824f74e66fb742bd5ca82e37c0734.pdf','application/pdf',15,''),(111,95,'portal','','','','','','','해외정보 소식','1',2,'','','',65,'IMPA, IMO 및 기타소식','81','005_81.pdf','84bc4c180d4472593a59487c85159f3e.pdf','application/pdf',16,''),(112,95,'portal','','','','','','','법령코너','1',2,'','','',65,'도선법 연구ㆍ2','84','005_84.pdf','1416925decdc8f8d31fe3cacec2fe874.pdf','application/pdf',17,''),(113,95,'portal','','','','','','','자료','1',2,'','','',65,'도선료 미수금 현황','92','005_92.pdf','ba6f9a62b0e2bfd40d45d45e4e8e8eb0.pdf','application/pdf',18,''),(114,95,'portal','','','','','','','자료','1',2,'','','',65,'항별 도선사 근무인원수 및 도선실적표','93','005_93.pdf','9a752aabc7b57cb843f8aac788008c0a.pdf','application/pdf',19,''),(115,95,'portal','','','','','','','교양특집','1',2,'','','',65,'권두시','02','005_02.pdf','7f0099c0bfaa54ee0f060dd5b1788d8f.pdf','application/pdf',20,''),(116,95,'portal','','','','','','','교양특집','1',2,'','','',65,'알려드립니다','71','005_71.pdf','18b797f126a64a9ed8e414b2b5ce277f.pdf','application/pdf',21,''),(117,95,'portal','','','','','','','교양특집','1',2,'','','',65,'토막상식','91','005_91.pdf','5316043c73067c04ff393b694f172da8.pdf','application/pdf',22,''),(118,95,'portal','','','','','','','교양특집','1',2,'','','',65,'고사성어','80','005_80.pdf','9473589dd1d1bc4bdccab2579187a6a2.pdf','application/pdf',23,''),(119,95,'portal','','','','','','','교양특집','1',2,'','','',65,'편집후기','94','005_94.pdf','d937ea3ff5c4b3a2ac0b4f2d0709d565.pdf','application/pdf',24,''),(120,95,'portal','','','','','','','교양특집','1',2,'','','',65,'각 지회 주소','95','005_95.pdf','f0805b811bf5a67be5cfb40434edb4f8.pdf','application/pdf',25,''),(121,0,'portal','1990','08','25','여름호','한국도선사협회','D01','','1',1,'1990년 여름호 도선지(통권6호)','','magzine_tit_1108.gif',64,'','','','','',1,''),(122,121,'portal','','','','','','','협회동정','1',2,'','','',64,'화보로 보는 협회 동정','03','006_03.pdf','0a575f3442d85ef5e2d9dd7116feef6c.pdf','application/pdf',1,''),(123,121,'portal','','','','','','','권두언','1',2,'','','',64,'도선법 개정에 임하여 / 이용우','10','006_10.pdf','cab3c804b11c2d8efa7b8a87a2470104.pdf','application/pdf',2,''),(124,121,'portal','','','','','','','도선논단','1',2,'','','',64,'항내조선과 선체조종운동의 기본이론ㆍ2 / 윤점동','12','006_12.pdf','aadd286b72073cdfbd083fc6bfdfb4b5.pdf','application/pdf',3,''),(125,121,'portal','','','','','','','도선논단','1',2,'','','',64,'우리나라 도선료 체계를 위한 소고 / 김길성','22','006_22.pdf','98cd2a1ef1b2f734b5200925cc2a3efc.pdf','application/pdf',4,''),(126,121,'portal','','','','','','','도선논단','1',2,'','','',64,'범세계적 해상조난 및 안전제도의 도입실시와 통신자의 직무 / 변진명','30','006_30.pdf','1c989002c8c1999fa9637adfcb8ddf41.pdf','application/pdf',5,''),(127,121,'portal','','','','','','','특별기획','1',2,'','','',64,'파란 물과 뜨거운 가슴으로 오래도록 기억될, 마산 / 편집실','35','006_35.pdf','80739cb0f05c60892506b14a54959971.pdf','application/pdf',6,''),(128,121,'portal','','','','','','','도선인터뷰','1',2,'','','',64,'열정으로 살아온 한평생, 영원한 바다의 청년 박성극 도선사 / 편집실','47','006_47.pdf','63372373458b1e99ad2153d0d66ea129.pdf','application/pdf',7,''),(129,121,'portal','','','','','','','특별기고','1',2,'','','',64,'나를 이끌어 준 한마디 / 송영록','50','006_50.pdf','7098e278334b65a4f0777722e806c715.pdf','application/pdf',8,''),(130,121,'portal','','','','','','','특별기고','1',2,'','','',64,'쾌속 도선선 \'포항 파일럿\' / 송정석','54','006_54.pdf','94d8db9af05155b2391ab9b2024d773e.pdf','application/pdf',9,''),(131,121,'portal','','','','','','','특별기고','1',2,'','','',64,'마젤란 해협과 마젤란의 일대기 / 김재곤','56','006_56.pdf','4df3b945587ebb7c9b73ccab96f05ea3.pdf','application/pdf',10,''),(132,121,'portal','','','','','','','특별기고','1',2,'','','',64,'후배가 본 선배도선사의 모습 / 옥태영','62','006_62.pdf','8fc18d56fb8bfb9403ad188dbe729374.pdf','application/pdf',11,''),(133,121,'portal','','','','','','','특별기고','1',2,'','','',64,'근황 | 한시를 통해 새로운 삶을… 김병주 명예도선사 / 편집부','64','006_64.pdf','2a22948e0832f0f7190f2d3e70548a61.pdf','application/pdf',12,''),(134,121,'portal','','','','','','','행사보고','1',2,'','','',64,'명승사찰 순례와 더불어 펼쳐진 도선가족 만남의 제전 / 편집부','66','006_66.pdf','0491d48b73a6703577e60e5c084d0dbd.pdf','application/pdf',13,''),(135,121,'portal','','','','','','','행사보고','1',2,'','','',64,'제10차 IMPA 총회 참가기 / 황호재','69','006_69.pdf','4d7f0f61c37a8f4f7969e00c71577602.pdf','application/pdf',14,''),(136,121,'portal','','','','','','','행사보고','1',2,'','','',64,'초여름, 자연의 정취를 맛보며 가졌던 원로도선사 초청 위로연','74','006_74.pdf','449ca107e36d0cc946199bf6e2cee729.pdf','application/pdf',15,''),(137,121,'portal','','','','','','','행사보고','1',2,'','','',64,'90 도선사 연수교육의 이모저모 / 이성재','76','006_76.pdf','752e5f142c85cf6f44da22de777f5e44.pdf','application/pdf',16,''),(138,121,'portal','','','','','','','특집','1',2,'','','',64,'종교와 도선사 | 불교의 특성과 선불교 / 황정원','78','006_78.pdf','7c7f4e035d095785ec94b8444d233fb5.pdf','application/pdf',17,''),(139,121,'portal','','','','','','','동정','1',2,'','','',64,'협회 및 지회, 회원소식','82','90_여름_동정.pdf','6c373dc9a5b86bc7aeabaae380dfa0ed.pdf','application/pdf',18,''),(140,121,'portal','','','','','','','법령코너','1',2,'','','',64,'도선법 연구ㆍ3 ','88','006_88.pdf','7ae60c188a400b371b901b88ef5c2a51.pdf','application/pdf',19,''),(141,121,'portal','','','','','','','해외정보 소식','1',2,'','','',64,'해외정보 IMPA 및 IMO 소식','93','006_93.pdf','97c9b6599d340374c1dd094cb3f4ffd6.pdf','application/pdf',20,''),(142,121,'portal','','','','','','','자료','1',2,'','','',64,'도선구별(항별) 도선사 취업현황','96','006_96.pdf','7dfe84969ef6975adb227d9baede72b9.pdf','application/pdf',21,''),(143,121,'portal','','','','','','','교양특집','1',2,'','','',64,'권두시','02','006_02.pdf','f1093675fabeef514cf4ee7edc6a28bb.pdf','application/pdf',22,''),(144,121,'portal','','','','','','','교양특집','1',2,'','','',64,'고사성어','55','006_55.pdf','d54b9e78f48ce042a6ef3244eb7da399.pdf','application/pdf',23,''),(145,121,'portal','','','','','','','교양특집','1',2,'','','',64,'토막상식','73','006_73.pdf','a7d8250cf93e7c885f2127c5f715c5a8.pdf','application/pdf',24,''),(146,121,'portal','','','','','','','교양특집','1',2,'','','',64,'알려드립니다','94','006_94.pdf','827477da46db52376116ec57df695d66.pdf','application/pdf',25,''),(147,121,'portal','','','','','','','교양특집','1',2,'','','',64,'편집후기','100','006_100.pdf','10604727f1271f09f99130e549a5bb88.pdf','application/pdf',26,''),(148,121,'portal','','','','','','','교양특집','1',2,'','','',64,'각 지회 주소','101','006_101.pdf','eb435cbc2b09d9fb250527036109eb6f.pdf','application/pdf',27,''),(149,0,'portal','1990','11','30','가을·겨울호','한국도선사협회','D01','','1',1,'1990년 가을호 도선지(통권7호)','','magzine_tit_1085.gif',63,'','','','','',1,''),(150,149,'portal','','','','','','','협회동정','1',2,'','','',63,'화보로 보는 협회 동정 - 편집실','03','007_03.pdf','6995c213a1d45bc8c4e6a5f680a3c380.pdf','application/pdf',1,''),(151,149,'portal','','','','','','','권두언','1',2,'','','',63,'항만운영과 도선사의 역할 / 정희영','10','007_10.pdf','64af989b64759725d19411857b2a6d5a.pdf','application/pdf',2,''),(152,149,'portal','','','','','','','도선논단','1',2,'','','',63,'항내조선과 선체조종운동의 기본이론ㆍ3 / 윤점동','12','007_12.pdf','d160b6dd0d852407610ea8d273e63424.pdf','application/pdf',3,''),(153,149,'portal','','','','','','','특집','1',2,'','','',63,'제7차 한ㆍ일 도선사 간친회 의제발표 논문 수록 미군함 조선의 특이점 / 김원중','24','007_24.pdf','d2b5546afcf5b98647daf8ce3f207cce.pdf','application/pdf',4,''),(154,149,'portal','','','','','','','특집','1',2,'','','',63,'제7차 한ㆍ일 도선사 간친회 의제발표 논문 수록 조종성기 기준에 관한 연구 / 송본신인','28','007_28.pdf','1c79a8c8ed39b2e211d5a0f44178cae6.pdf','application/pdf',5,''),(155,149,'portal','','','','','','','특별기획','1',2,'','','',63,'국제적 항만으로 급상승하고 있는 군산항 / 편집실','39','007_39.pdf','4f8e770c14fa613c33cd5165518d3a4a.pdf','application/pdf',6,''),(156,149,'portal','','','','','','','도선인터뷰','1',2,'','','',63,'25시간을 사는 도선인, 인천항 김수금 도선사 / 편집실','51','007_51.pdf','64ad315ea1447f2e2ed3ff6454153939.pdf','application/pdf',7,''),(157,149,'portal','','','','','','','특별기고','1',2,'','','',63,'마젤란 해협과 마젤란의 일대기(하) / 김재곤','54','007_54.pdf','35f9772e9c61f13ebff128e57c791682.pdf','application/pdf',8,''),(158,149,'portal','','','','','','','특별기고','1',2,'','','',63,'도선하는 마음자세 / 김승언','59','007_59.pdf','24f427b48dd99506131bca287c2efe88.pdf','application/pdf',9,''),(159,149,'portal','','','','','','','행사보고','1',2,'','','',63,'90 한ㆍ일 도선사 간친회 개최 / 사무국','61','007_61.pdf','ee87e9147a5826cdb4131d87f09e518f.pdf','application/pdf',10,''),(160,149,'portal','','','','','','','행사보고','1',2,'','','',63,'풍요로운 우정을 거두는 결실의 장 / 편집실','68','007_68.pdf','f4f68d5f611358eb6b14ffa5d0b1cc47.pdf','application/pdf',11,''),(161,149,'portal','','','','','','','기획','1',2,'','','',63,'테마기획 수습도선사의 변 | 지각생 / 송용무','70','007_70.pdf','025679fcb9145866067dee88176cf430.pdf','application/pdf',12,''),(162,149,'portal','','','','','','','기획','1',2,'','','',63,'테마기획 수습도선사의 변 | 노력과 끈기 / 부성치','72','007_72.pdf','4863d1aaf98727f3bc23fd7c58b71f4c.pdf','application/pdf',13,''),(163,149,'portal','','','','','','','동정','1',2,'','','',63,'협회 및 지회, 회원소식','74','90_가을_동정.pdf','8e52891960b0b5fdb2118486fdc4a1cf.pdf','application/pdf',14,''),(164,149,'portal','','','','','','','자료','1',2,'','','',63,'국제회의참가 및 개최현황','90','007_90.pdf','235bd240be6d75abbb6fff982a98510c.pdf','application/pdf',15,''),(165,149,'portal','','','','','','','기타','1',2,'','','',63,'고 송경환 형을 애도하면서 | 노병호','95','007_95.pdf','958ff6c00dc445a5948b1d9d11adcfaf.pdf','application/pdf',16,''),(166,149,'portal','','','','','','','교양특집','1',2,'','','',63,'권두시','02','007_02.pdf','8eaba5d8fdd99cb30feb99d6638c3f7d.pdf','application/pdf',17,''),(167,149,'portal','','','','','','','교양특집','1',2,'','','',63,'고사성어','50','007_50.pdf','144274f4cdedfffe32e82a6819e2762e.pdf','application/pdf',18,''),(168,149,'portal','','','','','','','교양특집','1',2,'','','',63,'토막상식','93','007_93.pdf','b5ca83f27adaafe4da7e1da2ca9f7fa4.pdf','application/pdf',19,''),(169,149,'portal','','','','','','','교양특집','1',2,'','','',63,'알려드립니다','94','007_94.pdf','1563fbe18e41aea76b2ff1279d8dad40.pdf','application/pdf',20,''),(170,149,'portal','','','','','','','교양특집','1',2,'','','',63,'편집후기','96','007_96.pdf','4067a0001b11e15ec247952709222106.pdf','application/pdf',21,''),(171,149,'portal','','','','','','','교양특집','1',2,'','','',63,'각 지회 주소','97','007_97.pdf','6d02c912c7eddace35232d008a708ce9.pdf','application/pdf',22,''),(172,0,'portal','1991','03','27','봄호','한국도선사협회','D01','','1',1,'1991년 봄호 도선지(통권8호)','','magzine_tit_1063.gif',62,'','','','','',1,''),(173,172,'portal','','','','','','','협회동정','1',2,'','','',62,'화보로 보는 협회 동정 - 편집실','03','008_03.pdf','8de14a94ae4b1b6ceaab163d97ef6894.pdf','application/pdf',1,''),(174,172,'portal','','','','','','','신년사','1',2,'','','',62,'굳건한 사명감으로 도약의 한해를 / 이용우','10','008_10.pdf','9446d3359b1370d5ce0cc66b893ea903.pdf','application/pdf',2,''),(175,172,'portal','','','','','','','신년사','1',2,'','','',62,'해운항만에 새로운 이정표를 세울 뜻깊은 한해 / 안상영','12','008_12.pdf','e4032702d6accec93f159934221839cf.pdf','application/pdf',3,''),(176,172,'portal','','','','','','','특집','1',2,'','','',62,'도선계약의 연구 / 조진형','16','008_16.pdf','d946bc41767076d024a1879412c2dde4.pdf','application/pdf',4,''),(177,172,'portal','','','','','','','특집','1',2,'','','',62,'도선계약의 영역문 / 사무국','24','008_24.pdf','69fc8ab64fff4aa571bb1fbb7da09598.pdf','application/pdf',5,''),(178,172,'portal','','','','','','','특별기획','1',2,'','','',62,'미래로 솟아오르는 태양의 도시, 동해 / 전희주','33','008_33.pdf','d14f74da3cf47d6faeb7f627b6c4d87f.pdf','application/pdf',6,''),(179,172,'portal','','','','','','','도선문예','1',2,'','','',62,'Baikal호를 생각한다 / 민병언','45','','','',7,''),(180,172,'portal','','','','','','','자료','1',2,'','','',62,'도선선 현황 / 편집부','49','008_49.pdf','f07dbbb6087a405b368b33ee26a7a95d.pdf','application/pdf',8,''),(181,172,'portal','','','','','','','기획','1',2,'','','',62,'테마기획 | 신입도선사에게 드리는 글 / 주영필','50','008_50.pdf','11e23d96e209067cc8431d7ad6f27978.pdf','application/pdf',9,''),(182,172,'portal','','','','','','','기획','1',2,'','','',62,'테마기획 | 수급도선을 마친 후배에게 드리는 글 / 김길성','52','008_52.pdf','e2a27591fca0b9421324f17a9636ce66.pdf','application/pdf',10,''),(183,172,'portal','','','','','','','보고','1',2,'','','',62,'도선법 시행규칙 일부 개정 / 사무국','58','008_58.pdf','191ef6856348948be6447779739c9d2f.pdf','application/pdf',11,''),(184,172,'portal','','','','','','','동정','1',2,'','','',62,'협회 및 지회, 회원소식 / 편집부','72','91_봄_동정.pdf','1fe2236644fa38e6f890cc35fbd43c68.pdf','application/pdf',12,''),(185,172,'portal','','','','','','','법령코너','1',2,'','','',62,'도선법 연구ㆍ5 / 이성재','78','008_78.pdf','672f46b0578269b7bcdb5cd6dc6a7a5d.pdf','application/pdf',13,''),(186,172,'portal','','','','','','','해외정보 소식','1',2,'','','',62,'IMPA 및 IMO 소식 / 편집부','87','008_87.pdf','3fd6898398ec80e3f15276cc27c0c9e1.pdf','application/pdf',14,''),(187,172,'portal','','','','','','','기타','1',2,'','','',62,'용퇴소식','89','008_89.pdf','c58e6043d88abc631842adc960227c13.pdf','application/pdf',15,''),(188,172,'portal','','','','','','','교양특집','1',2,'','','',62,'권두시','02','008_02.pdf','2cb7063378e2a3625db05c977d058d6c.pdf','application/pdf',16,''),(189,172,'portal','','','','','','','교양특집','1',2,'','','',62,'고사성어','32','008_32.pdf','ffc277f0a839ef5259d91d2fe8dcdb0a.pdf','application/pdf',17,''),(190,172,'portal','','','','','','','교양특집','1',2,'','','',62,'건강','57','008_57.pdf','1ace2f07d9c9b40d6c07d9ac0230395d.pdf','application/pdf',18,''),(191,172,'portal','','','','','','','교양특집','1',2,'','','',62,'토막상식','86','008_86.pdf','a9ce56eb6a05595307c23805e1503b4a.pdf','application/pdf',19,''),(192,172,'portal','','','','','','','교양특집','1',2,'','','',62,'편집후기','90','008_90.pdf','5f6ee05e716678336060a3ee9bb4a1cb.pdf','application/pdf',20,''),(193,172,'portal','','','','','','','교양특집','1',2,'','','',62,'각 지회 주소','91','008_91.pdf','1b667ecc1a3968f8a4ccad9dbe483ff9.pdf','application/pdf',21,''),(194,0,'portal','1991','07','29','여름호','한국도선사협회','D01','','1',1,'1991년 여름호 도선지(통권9호)','','magzine_tit_1040.gif',61,'','','','','',1,''),(195,194,'portal','','','','','','','협회동정','1',2,'','','',61,'화보로 보는 협회 동정 - 편집실','03','009_03.pdf','6485e195187d2f59bbc3da45c9bb1e24.pdf','application/pdf',1,''),(196,194,'portal','','','','','','','권두언','1',2,'','','',61,'세계적 수준의 서비스로 선진해운 이끌어야 / 차수웅','10','009_10.pdf','e58ecad37748133db73285431f111e55.pdf','application/pdf',2,''),(197,194,'portal','','','','','','','도선논단','1',2,'','','',61,'박용기관의 특성이 조선에 미치는 영향 / 전효중','12','009_12.pdf','ed2fd9e33f27e040ee2a43541f4c734c.pdf','application/pdf',3,''),(198,194,'portal','','','','','','','도선논단','1',2,'','','',61,'부산항 개발에 따른 파랑분석과 항만부진동에 관한 연구 / 이중우','21','009_21.pdf','da0af88b963436235faffcf204d2b636.pdf','application/pdf',4,''),(199,194,'portal','','','','','','','도선논단','1',2,'','','',61,'항만개발이 도선상의 안전에 미치는 영향 / 김환수','32','009_32.pdf','9351c4b0419ab1f0de5387889e71b957.pdf','application/pdf',5,''),(200,194,'portal','','','','','','','도선논단','1',2,'','','',61,'도선에 있어서 선저 여유수심 / 조수린','39','009_39.pdf','bfff85c9ece644b10570d09ea291fb35.pdf','application/pdf',6,''),(201,194,'portal','','','','','','','특별기획','1',2,'','','',61,'풍요와 번영을 일구는 예술의 도시, 목포항 / 전희주','47','009_47.pdf','66214e6c6006a3d2dca5525984b56e7c.pdf','application/pdf',7,''),(202,194,'portal','','','','','','','방문기','1',2,'','','',61,'울릉도 태하국민학교를 가다 / 조진형','59','009_59.pdf','643e6274f517e60d32e421e745797b01.pdf','application/pdf',8,''),(203,194,'portal','','','','','','','특별기고','1',2,'','','',61,'우리나라 도선 개화기에 대한 소고 / 김상','63','009_63.pdf','4608f6cd1a8f345e4c6508380d6bc602.pdf','application/pdf',9,''),(204,194,'portal','','','','','','','행사보고','1',2,'','','',61,'세월속에 다져지는 훈훈한 정 / 편집부','66','009_66.pdf','4d96c9ee733b42caf41a06b22b345df1.pdf','application/pdf',10,''),(205,194,'portal','','','','','','','행사보고','1',2,'','','',61,'땀방울로 맺어지는 우정의 마당 / 편집부','68','009_68.pdf','c2bfa0992646a023483b5e9bae6f67db.pdf','application/pdf',11,''),(206,194,'portal','','','','','','','보고','1',2,'','','',61,'도선선용 안전사다리 / 이강호','70','009_70.pdf','5fd5af39be3b85576f5d5325970ca4c3.pdf','application/pdf',12,''),(207,194,'portal','','','','','','','동정','1',2,'','','',61,'편집부','72','91_여름_동정.pdf','03e3969a492707b06131df2280ee7320.pdf','application/pdf',13,''),(208,194,'portal','','','','','','','법령코너','1',2,'','','',61,'도선법 연구ㆍ6 / 이성재','76','009_76.pdf','cb43de19d83f48c3d6cf7c8c2740dd7c.pdf','application/pdf',14,''),(209,194,'portal','','','','','','','기타','1',2,'','','',61,'자료 / 편집부','83','009_83.pdf','b96e7b294565f1f2d1ddb37b6855ea1c.pdf','application/pdf',15,''),(210,194,'portal','','','','','','','기타','1',2,'','','',61,'알려드립니다 / 편집부','84','009_84.pdf','0bc7ce6022def60c4337bf8eb4047e12.pdf','application/pdf',16,''),(211,194,'portal','','','','','','','기타','1',2,'','','',61,'용퇴소식','87','009_87.pdf','f7585c5decb20300da5225d180b03674.pdf','application/pdf',17,''),(212,194,'portal','','','','','','','교양특집','1',2,'','','',61,'권두시','02','009_02.pdf','de9cae5f3b833ed5a50f3e8d09c8b3f3.pdf','application/pdf',18,''),(213,194,'portal','','','','','','','교양특집','1',2,'','','',61,'고사성어','45','009_45.pdf','f583d427207b2e57486e3fdab6872149.pdf','application/pdf',19,''),(214,194,'portal','','','','','','','교양특집','1',2,'','','',61,'건강','46','009_46.pdf','c06f48ec701f0d2ed3b21bcb99670e44.pdf','application/pdf',20,''),(215,194,'portal','','','','','','','교양특집','1',2,'','','',61,'편집후기','88','009_88.pdf','d50269721dac04f21b37152ce7c558b3.pdf','application/pdf',21,''),(216,194,'portal','','','','','','','교양특집','1',2,'','','',61,'각 지회 주소','89','009_89.pdf','0cb59aa752bb8d981d62a01d1b4db4bf.pdf','application/pdf',22,''),(217,0,'portal','1991','12','03','가을·겨울호','한국도선사협회','D01','','1',1,'1991년 가을호 도선지(통권10호) ','','magzine_tit_1020.gif',60,'','','','','',1,''),(218,217,'portal','','','','','','','협회동정','1',2,'','','',60,'화보로 보는 협회 동정 - 편집실','03','010_03.pdf','46035a44b3732d569fc773db81d00c3f.pdf','application/pdf',1,''),(219,217,'portal','','','','','','','권두언','1',2,'','','',60,'항내항행안전을 위해 통항관리제도가 시급히 도입되어야 / 배병태','10','010_10.pdf','751ff176f982b0b20ace3cc9d1dcd3dd.pdf','application/pdf',2,''),(220,217,'portal','','','','','','','도선논단','1',2,'','','',60,'「한국도선료 체계의 개선에 관한 연구」의 발췌 및 요약문/윤점동-12','12','010_12.pdf','933b36a44292aaf2a543e1ecd66df942.pdf','application/pdf',3,''),(221,217,'portal','','','','','','','도선논단','1',2,'','','',60,'도선면제된 유조선 해난사례(상) / 박경현','35','010_35.pdf','883edf0bb17df9813f1a8e410ba46be9.pdf','application/pdf',4,''),(222,217,'portal','','','','','','','특별기획','1',2,'','','',60,'왕성한 의욕으로 활기찬 인천항 / 전희주','39','010_39.pdf','b578e404d1c72e32872ba1479836eef4.pdf','application/pdf',5,''),(223,217,'portal','','','','','','','도선인터뷰','1',2,'','','',60,'살아있는 도선신화 배순태 도선사 / 편집실','49','010_49.pdf','edf5b23f3186b6c33c42bbd3ea79e5f8.pdf','application/pdf',6,''),(224,217,'portal','','','','','','','특집','1',2,'','','',60,'제8회 한일도선사 간친회 보고 / 사무국','53','010_53.pdf','e3b2ed388a5cb16235c2ef5fa229d99b.pdf','application/pdf',7,''),(225,217,'portal','','','','','','','특집','1',2,'','','',60,'발표의제 논문 / 문경헌','60','010_60.pdf','74c2dbfcbe5b83c026bc3a0446cb7b1a.pdf','application/pdf',8,''),(226,217,'portal','','','','','','','기획','1',2,'','','',60,'테마기획 | 지나간 이야기들 / 유래혁','72','010_72.pdf','788ea11d63103e6ce1df713bd0d7af89.pdf','application/pdf',9,''),(227,217,'portal','','','','','','','기획','1',2,'','','',60,'테마기획 | 수습도선사 시험합격 소감 / 박현화','76','010_76.pdf','9f9e1c4addf196d095762087f265d314.pdf','application/pdf',10,''),(228,217,'portal','','','','','','','기타','1',2,'','','',60,'여행기 | 중국 여행기 / 윤영원','79','010_79.pdf','762ae0d4f5bee20b35cbfcdc49c8431c.pdf','application/pdf',11,''),(229,217,'portal','','','','','','','동정','1',2,'','','',60,'편집실','85','91_가을_동정.pdf','927533964488b0e8b56bd1101d432c8f.pdf','application/pdf',12,''),(230,217,'portal','','','','','','','법령코너','1',2,'','','',60,'도선법 연구ㆍ7 / 이성재','88','010_88.pdf','6ddf02d2c67f61c04d49236fa0ff04c4.pdf','application/pdf',13,''),(231,217,'portal','','','','','','','알림','1',2,'','','',60,'알려드립니다 / 편집실','96','010_96.pdf','2a649529194c6955d25791add4c3eac4.pdf','application/pdf',14,''),(232,217,'portal','','','','','','','교양특집','1',2,'','','',60,'권두시','02','010_02.pdf','09023c5d75d79f6c63230512b1217376.pdf','application/pdf',15,''),(233,217,'portal','','','','','','','교양특집','1',2,'','','',60,'고사성어','38','010_38.pdf','b6929525b1912cf815feee804934c144.pdf','application/pdf',16,''),(234,217,'portal','','','','','','','교양특집','1',2,'','','',60,'건강','78','010_78.pdf','5a03624353d349ee33d1486882b2d6dc.pdf','application/pdf',17,''),(235,217,'portal','','','','','','','교양특집','1',2,'','','',60,'편집후기','98','010_98.pdf','81118a926682112374c690722c626006.pdf','application/pdf',18,''),(236,217,'portal','','','','','','','교양특집','1',2,'','','',60,'각 지회 주소','99','010_99.pdf','4e9dff5b64078ea36c5921a581183927.pdf','application/pdf',19,''),(237,0,'portal','1992','04','04','봄호','한국도선사협회','D01','','1',1,'1992년 봄호 도선지(통권11호)','','magzine_tit_998.gif',59,'','','','','',1,''),(238,237,'portal','','','','','','','협회동정','1',2,'','','',59,'화보로 보는 협회 동정 - 편집실','03','011_03.pdf','70d55a1097efdb067c114f2ae73a6543.pdf','application/pdf',1,''),(239,237,'portal','','','','','','','취임사','1',2,'','','',59,'도선사상의 혁신으로 밝아오는 새시대를 맞이합시다 / 황호채','10','011_10.pdf','b590bbbba0c776c4c2b0188c271af0f3.pdf','application/pdf',2,''),(240,237,'portal','','','','','','','신년사','1',2,'','','',59,'국민편의 위주의 해운항만행정 쇄신 / 안상영','12','011_12.pdf','fe12153dfafb1babdd741d35eb73ee96.pdf','application/pdf',3,''),(241,237,'portal','','','','','','','도선논단','1',2,'','','',59,'항만의 최적 입출항항로 시스템에 관한 연구 / 우병구','16','011_16.pdf','1c6b3fac9d2f783bab9aaf3fcb9f3e3f.pdf','application/pdf',4,''),(242,237,'portal','','','','','','','도선논단','1',2,'','','',59,'도선면제된 유조선 해난사례(하) / 박경현','35','011_35.pdf','03fc57ed5f5c7bf168cb4fa2950a8f41.pdf','application/pdf',5,''),(243,237,'portal','','','','','','','기획','1',2,'','','',59,'테마기획- 도선업무 30년 / 윤영원','56','011_56.pdf','b431ac5545dbd229c82dacc82e67d9f7.pdf','application/pdf',6,''),(244,237,'portal','','','','','','','기획','1',2,'','','',59,'테마기획- 수습기간의 에피소드 및 각오 / 박현화','62','011_62.pdf','0f940b3ba4d97a28b7c435052531b9da.pdf','application/pdf',7,''),(245,237,'portal','','','','','','','기획','1',2,'','','',59,'테마기획- 도선연습을 마치면서 / 박기석','65','011_65.pdf','1e2bfcb86b3b762e7917dec439608e96.pdf','application/pdf',8,''),(246,237,'portal','','','','','','','특별기고','1',2,'','','',59,'우리선박의 종류와 크기 / 조진형','68','011_68.pdf','ea734674ab8fde7eed90dd4aef6a591e.pdf','application/pdf',9,''),(247,237,'portal','','','','','','','법령코너','1',2,'','','',59,'도선법 연구ㆍ8 / 이성재','72','011_72.pdf','da3ea9efe90831b0047fe9c448231db1.pdf','application/pdf',10,''),(248,237,'portal','','','','','','','동정','1',2,'','','',59,'편집부','79','92_봄_동정.pdf','231efdca053805d8ae8613ca84045434.pdf','application/pdf',11,''),(249,237,'portal','','','','','','','알림','1',2,'','','',59,'알려드립니다 / 편집부','82','011_82.pdf','9779ce8fde05ec60e9681bf4a69177b0.pdf','application/pdf',12,''),(250,237,'portal','','','','','','','해외정보 소식','1',2,'','','',59,'편집부','84','011_84.pdf','de2c51d44561a0bb4f65f6f8136e781e.pdf','application/pdf',13,''),(251,237,'portal','','','','','','','기타','1',2,'','','',59,'자료 | 도선자료 변천표 / 편집부','86','011_86.pdf','f86b02b61b1163c0cfc246415a8bfd1f.pdf','application/pdf',14,''),(252,237,'portal','','','','','','','기타','1',2,'','','',59,'용퇴소식 / 구완섭','90','011_90.pdf','9de7328053427f98741ba6f5de5a74ee.pdf','application/pdf',15,''),(253,237,'portal','','','','','','','교양특집','1',2,'','','',59,'권두시','02','011_02.pdf','ce8b6919d8a0d2287b8034a6d11bff95.pdf','application/pdf',16,''),(254,237,'portal','','','','','','','교양특집','1',2,'','','',59,'고사성어','34','011_34.pdf','9b89c5bf6b6949bc464f84841dfab5b0.pdf','application/pdf',17,''),(255,237,'portal','','','','','','','교양특집','1',2,'','','',59,'건강','55','011_55.pdf','fbcbeda1f4d7376f893d162f60afa03a.pdf','application/pdf',18,''),(256,237,'portal','','','','','','','교양특집','1',2,'','','',59,'토막상식','83','011_83.pdf','1595403cc9fa794d996664372c9996a7.pdf','application/pdf',19,''),(257,237,'portal','','','','','','','교양특집','1',2,'','','',59,'편집후기','91','011_91.pdf','3e5490b713180e2cb78cf49a47fdb9b9.pdf','application/pdf',20,''),(258,237,'portal','','','','','','','교양특집','1',2,'','','',59,'각 지회 주소','92','011_92.pdf','555047e68ff974d39d05988d8d7bf5a7.pdf','application/pdf',21,''),(259,0,'portal','1992','10','10','가을·겨울호','한국도선사협회','D01','','1',1,'1992년 가을호 도선지(통권12호)','','magzine_tit_976.gif',58,'','','','','',1,''),(260,259,'portal','','','','','','','협회동정','1',2,'','','',58,'화보로 보는 협회 동정 - 편집실','03','012_03.pdf','3dba3655aad0080eb392a8e17952faf8.pdf','application/pdf',1,''),(261,259,'portal','','','','','','','권두언','1',2,'','','',58,'도선사의 위상 / 전효중','10','012_10.pdf','6679c9af1b93a2eb4a06a8fa4def70ee.pdf','application/pdf',2,''),(262,259,'portal','','','','','','','도선논단','1',2,'','','',58,'해운산업발전을 위한 도선사의 역할 / 황호재','12','012_12.pdf','01aa8b70a5fcc12df134fe9e8ed6a5d1.pdf','application/pdf',3,''),(263,259,'portal','','','','','','','도선논단','1',2,'','','',58,'항내조선보조예선의 작업용어 소고 / 송정석','15','012_15.pdf','479fc1701befe6ad383fbf6a55593b33.pdf','application/pdf',4,''),(264,259,'portal','','','','','','','도선논단','1',2,'','','',58,'개정상법의 개요 / 황석갑','20','012_20.pdf','d48323ec52985319a6914485e54eae15.pdf','application/pdf',5,''),(265,259,'portal','','','','','','','특별기획','1',2,'','','',58,'아름다운 항만도시, 여수항을 찾아서 / 이도영','35','012_35.pdf','cf7316130e1e2dc1937051ff58465664.pdf','application/pdf',6,''),(266,259,'portal','','','','','','','기획','1',2,'','','',58,'테마기획 | 94년도 도선수습생 전형시험을 치르고 나서 / 홍동의','48','012_48.pdf','b5fde0069d754c4f140a89760f436f02.pdf','application/pdf',7,''),(267,259,'portal','','','','','','','기획','1',2,'','','',58,'테마기획 | 도선수습생시험 합격소감 / 박춘길','51','012_51.pdf','bcf79d061790566a84ec1f20568ea83c.pdf','application/pdf',8,''),(268,259,'portal','','','','','','','행사보고','1',2,'','','',58,'제8회 도선가족친선체육대회 / 편집부','53','012_53.pdf','955ad900babee4e914a612c0cb9fe620.pdf','application/pdf',9,''),(269,259,'portal','','','','','','','행사보고','1',2,'','','',58,'92 도선사 연수교육 / 편집부','55','012_55.pdf','90a261055ff04927c05f6744fc974f37.pdf','application/pdf',10,''),(270,259,'portal','','','','','','','동정','1',2,'','','',58,'편집부','57','92_가을겨울_동정.pdf','6458a518738774d92e1721db60fc91cd.pdf','application/pdf',11,''),(271,259,'portal','','','','','','','알림','1',2,'','','',58,'알려드립니다 / 편집부','61','012_61.pdf','d79762b3d3e2691ceb164c29289806a6.pdf','application/pdf',12,''),(272,259,'portal','','','','','','','법령코너','1',2,'','','',58,'도선법 연구ㆍ9 / 이성재','64','012_64.pdf','d428a0f04ff04762ad7c8beb5c3a2ecd.pdf','application/pdf',13,''),(273,259,'portal','','','','','','','해외정보 소식','1',2,'','','',58,'제11차 IMPA총회 / 편집부','72','012_72.pdf','d387fb64bcdbaee84f4f8422ab7486d9.pdf','application/pdf',14,''),(274,259,'portal','','','','','','','기타','1',2,'','','',58,'용퇴소식 / 편집부 - 74ㆍ75','74','012_74.pdf','43a1049961e3f003d2622495ab64a8eb.pdf','application/pdf',15,''),(275,259,'portal','','','','','','','교양특집','1',2,'','','',58,'권두시','02','012_02.pdf','667717d467cca5b327af68065c417b81.pdf','application/pdf',16,''),(276,259,'portal','','','','','','','교양특집','1',2,'','','',58,'고사성어','19','012_19.pdf','1755282e66d2b81ed87df9adf0bb1edf.pdf','application/pdf',17,''),(277,259,'portal','','','','','','','교양특집','1',2,'','','',58,'토막상식','52','012_52.pdf','445436b411fea17f1ea23e9e62275f05.pdf','application/pdf',18,''),(278,259,'portal','','','','','','','교양특집','1',2,'','','',58,'건강','56','012_56.pdf','58ee20fff86b2d499785c11c5c0028a7.pdf','application/pdf',19,''),(279,259,'portal','','','','','','','교양특집','1',2,'','','',58,'편집후기','76','012_76.pdf','98ea8161384cc7e52fb3ea43e022033e.pdf','application/pdf',20,''),(280,259,'portal','','','','','','','교양특집','1',2,'','','',58,'각 지회 주소','77','012_77.pdf','3c5225e6a2db8e5dfdf90c112b77ad3b.pdf','application/pdf',21,''),(281,0,'portal','1993','04','20','봄호','한국도선사협회','D01','','1',1,'1993년 봄호 도선지(통권13호)','','magzine_tit_955.gif',57,'','','','','',1,''),(282,281,'portal','','','','','','','협회동정','1',2,'','','',57,'화보로 보는 협회 동정 - 편집실','03','013_03.pdf','b55057f18845098562765e58ad9f4dab.pdf','application/pdf',1,''),(283,281,'portal','','','','','','','취임사','1',2,'','','',57,'21세기 태평양시대를 앞둔 우리해운의성장기반을 마련할터/염태섭','10','013_10.pdf','dfb6634273c1fbf59d26e461f4846580.pdf','application/pdf',2,''),(284,281,'portal','','','','','','','도선논단','1',2,'','','',57,'인천항 항계내 해난(충돌)사고 예방대책 / 김길성','12','013_12.pdf','731f5d08d4604d92a1f8a4dfc339d823.pdf','application/pdf',3,''),(285,281,'portal','','','','','','','특별기획','1',2,'','','',57,'조선공업의 메카, 울산항을 찾아서 / 편집부','22','013_22.pdf','885262e001ef819cd030c1bbc982cc26.pdf','application/pdf',4,''),(286,281,'portal','','','','','','','도선인터뷰','1',2,'','','',57,'울산항의 산증인 김정철 도선사 / 편집부','33','013_33.pdf','565f322fb646ba3c51bb7b5de19d5ee4.pdf','application/pdf',5,''),(287,281,'portal','','','','','','','행사보고','1',2,'','','',57,'제4회 원로 도선사 초청위로연 / 편집부','40','013_40.pdf','e097e6384ff4f4544ffbb24a1debbd0a.pdf','application/pdf',6,''),(288,281,'portal','','','','','','','칼럼','1',2,'','','',57,'명사칼럼 | 강동석','43','013_43.pdf','008544a129e59edd1c82a835eef078b8.pdf','application/pdf',7,''),(289,281,'portal','','','','','','','보고','1',2,'','','',57,'도선법 시행규칙중 개정령 / 편집부','44','013_44.pdf','ae38e079a254a07091c252aff536ff4d.pdf','application/pdf',8,''),(290,281,'portal','','','','','','','동정','1',2,'','','',57,'편집부','54','93_봄_동정.pdf','e7d5a74e4f22a48639497cb6719de2ca.pdf','application/pdf',9,''),(291,281,'portal','','','','','','','법령코너','1',2,'','','',57,'도선법 연구ㆍ10 | 이성재','64','013_64.pdf','eb664639387a39a11529de8fe250495e.pdf','application/pdf',10,''),(292,281,'portal','','','','','','','기타','1',2,'','','',57,'알려드립니다 | 편집부','60','013_60.pdf','3c779c484e4c2326ba9eedd25e8fa50e.pdf','application/pdf',11,''),(293,281,'portal','','','','','','','해외정보 소식','1',2,'','','',57,'해외정보 | 1993년 IMO회의 개최예정표 / 편집부','72','013_72.pdf','f1ac6988a18b0fe3075ba4f2811016d5.pdf','application/pdf',12,''),(294,281,'portal','','','','','','','기타','1',2,'','','',57,'자료 | 연도별 도선사 연수교육 참가자 현황 / 편집부','74','013_74.pdf','295d1891aa4cc75ea39dfb469c5b9bb1.pdf','application/pdf',13,''),(295,281,'portal','','','','','','','기타','1',2,'','','',57,'용퇴소식 | 편집부','76','013_76.pdf','bff3466cc7aa3402c3193c60f5dfa97e.pdf','application/pdf',14,''),(296,281,'portal','','','','','','','교양특집','1',2,'','','',57,'권두시','02','013_02.pdf','837238043661f59d780366079a6b43bc.pdf','application/pdf',15,''),(297,281,'portal','','','','','','','교양특집','1',2,'','','',57,'고사성어','21','013_21.pdf','79214ea48ad92fd21d8ae55f4cc7ea02.pdf','application/pdf',16,''),(298,281,'portal','','','','','','','교양특집','1',2,'','','',57,'건강','38','013_38.pdf','88818810a1f4d05e5492e015c96d6bf8.pdf','application/pdf',17,''),(299,281,'portal','','','','','','','교양특집','1',2,'','','',57,'역사의 인물','71','013_71.pdf','42e2de37718feda0a7d44ef9a2527386.pdf','application/pdf',18,''),(300,281,'portal','','','','','','','교양특집','1',2,'','','',57,'편집후기','80','013_80.pdf','7e679f2e9fec8d7aba688fad3b6e04ec.pdf','application/pdf',19,''),(301,281,'portal','','','','','','','교양특집','1',2,'','','',57,'각 지회 주소','81','013_81.pdf','3c51b5941ad79adab25989a7071a726a.pdf','application/pdf',20,''),(302,0,'portal','1993','08','31','여름호','한국도선사협회','D01','','1',1,'1993년 여름호 도선지(통권14호)','','magzine_tit_926.gif',56,'','','','','',1,''),(303,302,'portal','','','','','','','협회동정','1',2,'','','',56,'화보로 보는 협회 동정 - 편집실','03','014_03.pdf','e0e78887c1d6dee1cf2b6cbd59d581af.pdf','application/pdf',1,''),(304,302,'portal','','','','','','','취임사','1',2,'','','',56,'취임사 / 최학영','10','014_10.pdf','666d66f38dc34990d5471a6bb8f34962.pdf','application/pdf',2,''),(305,302,'portal','','','','','','','이임사','1',2,'','','',56,'황호채','11','014_11.pdf','9fcab9f998fe8ebdc4c193a1f2acd041.pdf','application/pdf',3,''),(306,302,'portal','','','','','','','권두언','1',2,'','','',56,'우리나라 행운을 홍보하는 민간 외교관으로서의 역할을 지녀야 / 차수웅','12','014_12.pdf','096e628b366797b21d05d10e2f99ed5a.pdf','application/pdf',4,''),(307,302,'portal','','','','','','','도선논단','1',2,'','','',56,'신경제정책과 해운항만산업 / 배병태','16','014_16.pdf','79f9b5bdedbfbf0f36cd02ae743ccd1b.pdf','application/pdf',5,''),(308,302,'portal','','','','','','','도선논단','1',2,'','','',56,'도선사 운영제도 개선방안에 대한 소고 / 협회사무국','24','014_24.pdf','9a746def353408ae4a6a1de2cc04f1ff.pdf','application/pdf',6,''),(309,302,'portal','','','','','','','도선논단','1',2,'','','',56,'광양항 도선상의 문제점 / 여수지회','28','014_28.pdf','3442cd1af93d5a3cef886a085c17ace5.pdf','application/pdf',7,''),(310,302,'portal','','','','','','','도선칼럼','1',2,'','','',56,'도서유감 / 주영필','30','014_30.pdf','f0f13a32782b7aa78d435a88c82a6739.pdf','application/pdf',8,''),(311,302,'portal','','','','','','','특별기획','1',2,'','','',56,'「가고파」의 시향, 마산항을 찾아서 / 편집부 - 35','35','014_35.pdf','6194945696c856d56dc95316cc7ed5a4.pdf','application/pdf',9,''),(312,302,'portal','','','','','','','도선인터뷰','1',2,'','','',56,'마산항의 대부, 정병태 도선사 / 편집부','46','014_46.pdf','ce1963edd06badec8eb6c8748018ac58.pdf','application/pdf',10,''),(313,302,'portal','','','','','','','기고','1',2,'','','',56,'바다와 더불어 살아온 이모저모 / 윤영원','51','014_51.pdf','b5e50063212d0aadf04bd84db0c213d3.pdf','application/pdf',11,''),(314,302,'portal','','','','','','','특별기고','1',2,'','','',56,'삶의 고뇌와 내조자의 각오 / 이선희','53','014_53.pdf','14066f44bf180deb41d07ffa62907d12.pdf','application/pdf',12,''),(315,302,'portal','','','','','','','행사보고','1',2,'','','',56,'원로 도선사 초청 위로행사를 마치고 / 편집부 - 58','58','014_58.pdf','34e36e4e3ad14fe0b0f85f9d3d4db829.pdf','application/pdf',13,''),(316,302,'portal','','','','','','','동정','1',2,'','','',56,'편집부','61','93_여름_동정.pdf','33ba7ad33b3d5df3d0f801bdb0f66d2f.pdf','application/pdf',14,''),(317,302,'portal','','','','','','','법령코너','1',2,'','','',56,'도선법 연구ㆍ11 / 이성재','66','014_66.pdf','8acb53d6563f5ad79441851db7fac0ec.pdf','application/pdf',15,''),(318,302,'portal','','','','','','','기타','1',2,'','','',56,'알립니다 / 편집부','74','014_74.pdf','ac033c2364023d6dae1ad0f1fbcdafda.pdf','application/pdf',16,''),(319,302,'portal','','','','','','','기타','1',2,'','','',56,'자료 | IMPA총회 참가현황 / 편집부','76','014_76.pdf','cffd0f1c289d025a674deb82c513b87e.pdf','application/pdf',17,''),(320,302,'portal','','','','','','','기타','1',2,'','','',56,'용퇴소식 / 편집부','78','014_78.pdf','6d5d971dcdfee133d5493e7227d64bb3.pdf','application/pdf',18,''),(321,302,'portal','','','','','','','기타','1',2,'','','',56,'추모사 | 이긍섭 선배의 서거를 추모하며 / 이성재','79','014_79.pdf','c13703daf88a386cbe4300ba97c9d530.pdf','application/pdf',19,''),(322,302,'portal','','','','','','','교양특집','1',2,'','','',56,'권두시','02','014_02.pdf','b89a30c8d82166a3b75d42632fe63bc9.pdf','application/pdf',20,''),(323,302,'portal','','','','','','','교양특집','1',2,'','','',56,'고사성어','34','014_34.pdf','3dd3b2b1cef5e165dc978d4742e626fb.pdf','application/pdf',21,''),(324,302,'portal','','','','','','','교양특집','1',2,'','','',56,'건강','50','014_50.pdf','452ac9567b62d5fc608ac78e38cfe3b0.pdf','application/pdf',22,''),(325,302,'portal','','','','','','','교양특집','1',2,'','','',56,'선박용어','57','014_57.pdf','c0721aba657f571740ab5c906ce8ac84.pdf','application/pdf',23,''),(326,302,'portal','','','','','','','교양특집','1',2,'','','',56,'토막상식','73','','','',24,''),(327,302,'portal','','','','','','','교양특집','1',2,'','','',56,'편집후기','80','014_80.pdf','5b927448302d14d4ae40e2fba1ab5077.pdf','application/pdf',25,''),(328,302,'portal','','','','','','','교양특집','1',2,'','','',56,'각 지회 주소','81','014_81.pdf','ecec47f74f6446d0094986170ed5e2ac.pdf','application/pdf',26,''),(329,0,'portal','1993','11','27','가을·겨울호','한국도선사협회','D01','','1',1,'1993년 가을호 도선지(통권15호)','','magzine_tit_903.gif',55,'','','','','',1,''),(330,329,'portal','','','','','','','협회동정','1',2,'','','',55,'화보로 보는 협회 동정 - 편집실','03','015_03.pdf','b316d1d63d94f4f64555020c465a9ad6.pdf','application/pdf',1,''),(331,329,'portal','','','','','','','취임사','1',2,'','','',55,'김철용','10','015_10.pdf','6df08b91feaa8564694f4dee7335aa70.pdf','application/pdf',2,''),(332,329,'portal','','','','','','','도선논단','1',2,'','','',55,'예선조선에 있어서 고려할 사항 / 김길성','12','015_12.pdf','c1f5e3f5cb5d11d95f5d5d59fec553d7.pdf','application/pdf',3,''),(333,329,'portal','','','','','','','도선논단','1',2,'','','',55,'도선 업무중 해난사고 방지대책 / 조월회관','23','015_23.pdf','c10852933b2fed5d29e17dc488fee8d8.pdf','application/pdf',4,''),(334,329,'portal','','','','','','','도선논단','1',2,'','','',55,'실지 조선의 비결 / 수내 임(편집실, 편역)','28','015_28.pdf','81725f83dc6ac2f8954433349a65cb0a.pdf','application/pdf',5,''),(335,329,'portal','','','','','','','특별기획','1',2,'','','',55,'21세기를 향해 떠오르는 태양의 도시, 동해항을 찾아서 / 김병희','43','015_43.pdf','7c1c93eb91360c651ba6740324abe3d4.pdf','application/pdf',6,''),(336,329,'portal','','','','','','','도선인터뷰','1',2,'','','',55,'동해항의 신사, 황강운 도선사 / 김병희','57','015_57.pdf','d829c1655f299b17dd35486c8b428a1d.pdf','application/pdf',7,''),(337,329,'portal','','','','','','','특별기고','1',2,'','','',55,'도선사 레이다 관측 기능 / 심근형','66','015_66.pdf','a296b6f245f4a34372e5bdb018a2fca1.pdf','application/pdf',8,''),(338,329,'portal','','','','','','','행사보고','1',2,'','','',55,'제9차 한일 간친회 / 편집실','74','015_74.pdf','0b74d05e48650b5952b380647534a2d1.pdf','application/pdf',9,''),(339,329,'portal','','','','','','','동정','1',2,'','','',55,'편집실','81','93_가을_동정.pdf','c99b99ce65a4c63f9c5003664127d84e.pdf','application/pdf',10,''),(340,329,'portal','','','','','','','법령코너','1',2,'','','',55,'도선법 연구ㆍ12 / 이성재','84','015_84.pdf','ac635d71a226a3442bbc7713d799e14a.pdf','application/pdf',11,''),(341,329,'portal','','','','','','','기타','1',2,'','','',55,'알립니다 / 편집실','91','015_91.pdf','f41a3241ca285fddb67e6f316d9097ef.pdf','application/pdf',12,''),(342,329,'portal','','','','','','','기타','1',2,'','','',55,'용퇴소식 / 편집실','94','015_94.pdf','376f0b9560194499fc2590089c42d917.pdf','application/pdf',13,''),(343,329,'portal','','','','','','','기타','1',2,'','','',55,'자료 | 한일 간친회 참가 현황 / 편집실','96','015_96.pdf','8b33c895b6312076f617f29015322347.pdf','application/pdf',14,''),(344,329,'portal','','','','','','','교양특집','1',2,'','','',55,'권두시','02','015_02.pdf','309be65d113baee04b6a146fe07c1d7f.pdf','application/pdf',15,''),(345,329,'portal','','','','','','','교양특집','1',2,'','','',55,'고사성어','62','015_62.pdf','1d15f0a34d7c518ba8087525cbc4b233.pdf','application/pdf',16,''),(346,329,'portal','','','','','','','교양특집','1',2,'','','',55,'건강','63','015_63.pdf','a6f909b380b71e1816c3f16047100193.pdf','application/pdf',17,''),(347,329,'portal','','','','','','','교양특집','1',2,'','','',55,'어떻게 생각하십니까?','80','015_80.pdf','2377abfc84c522d3825529bb3b8b2ad3.pdf','application/pdf',18,''),(348,329,'portal','','','','','','','교양특집','1',2,'','','',55,'우리말 바른말','83','015_83.pdf','bbaa3689cd410a0649825c73f110dd9a.pdf','application/pdf',19,''),(349,329,'portal','','','','','','','교양특집','1',2,'','','',55,'생활의 지혜','93','015_93.pdf','b491cf0e3dad4ac1997349f823e200cc.pdf','application/pdf',20,''),(350,329,'portal','','','','','','','교양특집','1',2,'','','',55,'편집후기','99','015_99.pdf','8530fc9fd8211f4c18830e6ad87b89d1.pdf','application/pdf',21,''),(351,329,'portal','','','','','','','교양특집','1',2,'','','',55,'각 지회 주소','101','015_101.pdf','1dcdcaf0cc16dcd262adbb5c65988449.pdf','application/pdf',22,''),(352,0,'portal','1994','05','04','봄호','한국도선사협회','D01','','1',1,'1994년 봄호 도선지(통권16호)','','magzine_tit_880.gif',54,'','','','','',1,''),(353,352,'portal','','','','','','','협회동정','1',2,'','','',54,'화보로 보는 협회 동정 - 편집실','03','016_03.pdf','6e4390f2408740f6966053b6e6b16bad.pdf','application/pdf',1,''),(354,352,'portal','','','','','','','권두언','1',2,'','','',54,'김정민','10','016_10.pdf','13a3b669178344c1010de33c42ba6298.pdf','application/pdf',2,''),(355,352,'portal','','','','','','','특집','1',2,'','','',54,'건강한 사회, 깨끗한 정부 / 김철용','12','016_12.pdf','5cd3f3f4eba17753bdf39883f4578008.pdf','application/pdf',3,''),(356,352,'portal','','','','','','','취임사','1',2,'','','',54,'도남섭','14','016_14.pdf','36616b4571ea3e3c3ecf8c6088ce5de2.pdf','application/pdf',4,''),(357,352,'portal','','','','','','','도선논단','1',2,'','','',54,'군산항내 조선 보조 예선의 적정 소요 척수에 관한 고찰 /박현화','16','016_16.pdf','bc5e8dcad7e0db03685227d17922c132.pdf','application/pdf',5,''),(358,352,'portal','','','','','','','도선논단','1',2,'','','',54,'도선업무의 특성과 도선 제도 / 김길성','33','016_33.pdf','da95b93d1fb7cb07085a5aa2a887eb92.pdf','application/pdf',6,''),(359,352,'portal','','','','','','','특별기획','1',2,'','','',54,'역사적 풍상을 딛고 국제적 항만으로 급부상하고 있는 군산항을 찾아서 / 김병희','43','016_43.pdf','8d40b7d19cca9f7653e7f14dbcfad25f.pdf','application/pdf',7,''),(360,352,'portal','','','','','','','도선인터뷰','1',2,'','','',54,'군산항 개혁의 바람, 박현화 도선사 / 김병희','59','016_59.pdf','975b43f1a7dc4f997ecdce01e518e342.pdf','application/pdf',8,''),(361,352,'portal','','','','','','','특별기고','1',2,'','','',54,'옥계항 50,000DWT 급 선박 접안 시 문제점 / 권강수','67','016_67.pdf','440b1729c87c55b2d0f53e9d9992e002.pdf','application/pdf',9,''),(362,352,'portal','','','','','','','동정','1',2,'','','',54,'편집실','73','94_봄_동정.pdf','e11a0c1ff04125d118def7ac310708c3.pdf','application/pdf',10,''),(363,352,'portal','','','','','','','법령코너','1',2,'','','',54,'도선법 연구ㆍ13 / 이성재','80','016_80.pdf','18ec788a2170b5782cb0cb8a08a374f1.pdf','application/pdf',11,''),(364,352,'portal','','','','','','','기타','1',2,'','','',54,'알립니다 / 편집실','94','016_94.pdf','63bbc77236b4ba9bde9c468171a7f11d.pdf','application/pdf',12,''),(365,352,'portal','','','','','','','기타','1',2,'','','',54,'용퇴소식 / 편집실','98','016_98.pdf','aaaba0f269ccc3d0aa8fb55898762dfc.pdf','application/pdf',13,''),(366,352,'portal','','','','','','','해외정보 소식','1',2,'','','',54,'94년도 IMO 회의 개최 예정표 / 편집실','102','016_102.pdf','397e0d7aa23c121cc0003b7560352e83.pdf','application/pdf',14,''),(367,352,'portal','','','','','','','교양특집','1',2,'','','',54,'권두시','02','016_02.pdf','6ae80a358b585fa4baa12ce0adc31360.pdf','application/pdf',15,''),(368,352,'portal','','','','','','','교양특집','1',2,'','','',54,'고사성어','58','016_58.pdf','b5e0d6718eadd3909ece4542e365676d.pdf','application/pdf',16,''),(369,352,'portal','','','','','','','교양특집','1',2,'','','',54,'건강','70','016_70.pdf','47df29198ee0a958388fe98174ad6f4d.pdf','application/pdf',17,''),(370,352,'portal','','','','','','','교양특집','1',2,'','','',54,'어떻게 생각하십니까?','72','016_72.pdf','4171f8001d3c019e8b5ab4730ea7b114.pdf','application/pdf',18,''),(371,352,'portal','','','','','','','교양특집','1',2,'','','',54,'생활의 지혜','79','016_79.pdf','d39d907b0803de000e94c6a0a44feeb3.pdf','application/pdf',19,''),(372,352,'portal','','','','','','','교양특집','1',2,'','','',54,'승자와 패자','92','016_92.pdf','12fdee98613d06d48d7d5c141fc1ccf4.pdf','application/pdf',20,''),(373,352,'portal','','','','','','','교양특집','1',2,'','','',54,'편집후기','104','016_104.pdf','ac2bb5e14f7f5d8e368e0ee5e0b82435.pdf','application/pdf',21,''),(374,352,'portal','','','','','','','교양특집','1',2,'','','',54,'각 지회 주소','105','016_105.pdf','55661f785cb648392c3d3e15505f5a1e.pdf','application/pdf',22,''),(375,0,'portal','1994','09','16','여름호','한국도선사협회','D01','','1',1,'1994년 여름호 도선지(통권17호)','','magzine_tit_855.gif',53,'','','','','',1,''),(376,375,'portal','','','','','','','협회동정','1',2,'','','',53,'화보로 보는 협회 동정 / 편집실','03','017_03.pdf','31acf3b8eca3d83ba426354ba084f537.pdf','application/pdf',1,''),(377,375,'portal','','','','','','','권두언','1',2,'','','',53,'박현규','10','017_10.pdf','2282255593cf708bdb4c975110f5d225.pdf','application/pdf',2,''),(378,375,'portal','','','','','','','도선논단','1',2,'','','',53,'한국 도선의 문제점과 발전방향 / 윤점동','13','017_13.pdf','bd6c71982c10a08b18297b0c57c28901.pdf','application/pdf',3,''),(379,375,'portal','','','','','','','도선논단','1',2,'','','',53,'강풍과 항내조선의 한게에 관한 소고 / 조수린','22','017_22.pdf','75b9fe46a1589d4288f6af1191f0a645.pdf','application/pdf',4,''),(380,375,'portal','','','','','','','도선논단','1',2,'','','',53,'안전도선 확보를 위한 최적항로의 설계에 관하여 / 김환수','32','017_32.pdf','40e0d470fb1fce98853202d6c4a73fcf.pdf','application/pdf',5,''),(381,375,'portal','','','','','','','특별기획','1',2,'','','',53,'세계를 향한 웅비의 포항, 포항항 / 김병희','52','017_52.pdf','8bedecc20e5cd1604be82b10ad9eedaf.pdf','application/pdf',6,''),(382,375,'portal','','','','','','','도선인터뷰','1',2,'','','',53,'포항항의 개척자, 김규용 도선사 / 김병희','67','017_67.pdf','211cd136c75fc624dbe43e9a5a6852f9.pdf','application/pdf',7,''),(383,375,'portal','','','','','','','행사보고','1',2,'','','',53,'제10회 도선가족 친선체육대회 / 편집실','76','017_76.pdf','093e62caaaf8a80c270578c728074bb8.pdf','application/pdf',8,''),(384,375,'portal','','','','','','','행사보고','1',2,'','','',53,'원로도선사 위로 행사 / 편집실','78','017_78.pdf','babc288fded4b8fcd6a5e079310b2e32.pdf','application/pdf',9,''),(385,375,'portal','','','','','','','특별기고','1',2,'','','',53,'한국도선사협회 정관의 변천사 / 이성재','80','017_80.pdf','708c34e30feedfe840765f989abcd0af.pdf','application/pdf',10,''),(386,375,'portal','','','','','','','동정','1',2,'','','',53,'편집실','86','94_여름_동정.pdf','025dde22c282387347fa2290bfa0b232.pdf','application/pdf',11,''),(387,375,'portal','','','','','','','법령코너','1',2,'','','',53,'도선법 연구ㆍ14 / 이성재','94','017_94.pdf','4bea2b695df07efbe33c59ad2e757fe6.pdf','application/pdf',12,''),(388,375,'portal','','','','','','','기타','1',2,'','','',53,'추모사 | (故) 호칠용 도선사 영전에 / 김인규','102','','','',13,''),(389,375,'portal','','','','','','','기타','1',2,'','','',53,'알립니다 / 편집실','104','017_104.pdf','3d88eedfe99f17293128de5d9e0e68c2.pdf','application/pdf',14,''),(390,375,'portal','','','','','','','기타','1',2,'','','',53,'용퇴소식 / 편집실','109','017_109.pdf','cbef9dd1f7131231ce3bfa6d1e205bf4.pdf','application/pdf',15,''),(391,375,'portal','','','','','','','해외정보 소식','1',2,'','','',53,'제12차 IMPA 총회 의사일정 / 편집실','107','017_107.pdf','6815100296668fb74b4e38d4f15941a1.pdf','application/pdf',16,''),(392,375,'portal','','','','','','','기타','1',2,'','','',53,'자료 | 한국도선사 및 전국 도선구의 도선선 현황 / 편집실','110','017_110.pdf','a6119cc610a68e98e84a0919fc18e28c.pdf','application/pdf',17,''),(393,375,'portal','','','','','','','교양특집','1',2,'','','',53,'권두시','02','017_02.pdf','37e3306c731a6e0be63e4171eb43ed94.pdf','application/pdf',18,''),(394,375,'portal','','','','','','','교양특집','1',2,'','','',53,'고사성어','51','017_51.pdf','fea04be726c3ab7649d6d8f0e3f82833.pdf','application/pdf',19,''),(395,375,'portal','','','','','','','교양특집','1',2,'','','',53,'건강','74','017_74.pdf','a502553086bc94d9b3928e23cdcaac27.pdf','application/pdf',20,''),(396,375,'portal','','','','','','','교양특집','1',2,'','','',53,'어떻게 생각하십니까?','85','017_85.pdf','02b9e1d8e0ae4dfee8262c246113c61a.pdf','application/pdf',21,''),(397,375,'portal','','','','','','','교양특집','1',2,'','','',53,'생활의 지혜','92','017_92.pdf','572b07521f3a4a3fd36ddfdb2f80f1ac.pdf','application/pdf',22,''),(398,375,'portal','','','','','','','교양특집','1',2,'','','',53,'편집후기','116','017_116.pdf','7727252e9c2a4663974ac5810261f624.pdf','application/pdf',23,''),(399,375,'portal','','','','','','','교양특집','1',2,'','','',53,'각 지회 주소','117','017_117.pdf','0dc4826494bdf0caca17918e285e8726.pdf','application/pdf',24,''),(400,0,'portal','1994','12','31','가을·겨울호','한국도선사협회','D01','','1',1,'1994년 겨울호 도선지(통권18호)','','magzine_tit_827.gif',52,'','','','','',1,''),(401,400,'portal','','','','','','','협회동정','1',2,'','','',52,'화보로 보는 협회 동정 / 편집실','03','018_03.pdf','9967c6ad6edbbffcc92cd1b9a99a5a69.pdf','application/pdf',1,''),(402,400,'portal','','','','','','','권두언','1',2,'','','',52,'이진풍','10','018_10.pdf','50d183fcff2e8a1d5932794e7239b84d.pdf','application/pdf',2,''),(403,400,'portal','','','','','','','도선칼럼','1',2,'','','',52,'김상진','16','018_16.pdf','acc543ee964253c459ef0c8e621938f6.pdf','application/pdf',3,''),(404,400,'portal','','','','','','','도선논단','1',2,'','','',52,'도선업의 배경과 전망(1) / 이원철','18','018_18.pdf','f1df0116563fd3b9e3caed609b5171b1.pdf','application/pdf',4,''),(405,400,'portal','','','','','','','특별기획','1',2,'','','',52,'21세기 국제교역도시로 떠오르고 있는 항구도시 목포 / 김병희','31','018_31.pdf','a9892a93e37988ad9876776153447259.pdf','application/pdf',5,''),(406,400,'portal','','','','','','','도선인터뷰','1',2,'','','',52,'정열의 바다 사나이 목포항 김국상 도선사 / 김병희','48','018_48.pdf','2d5cb9e2cc352c9eee9f83d679ae8099.pdf','application/pdf',6,''),(407,400,'portal','','','','','','','행사보고','1',2,'','','',52,'제11회 도선가족 친선체육대회 / 편집실','56','018_56.pdf','18d2e1b606ab3babf947ea5728f2b46a.pdf','application/pdf',7,''),(408,400,'portal','','','','','','','특별기고','1',2,'','','',52,'도선 수습의 길에서 / 김필상','59','018_59.pdf','35e83fa1ace3280adfc01b0be269ac2e.pdf','application/pdf',8,''),(409,400,'portal','','','','','','','특별기고','1',2,'','','',52,'울산항에 닻을 내리며 / 전기철','61','018_61.pdf','7f2572bb89f5af526f913ee4b34faede.pdf','application/pdf',9,''),(410,400,'portal','','','','','','','도선문예','1',2,'','','',52,'IMPA 총회 참석 기행 / 김소자','64','018_64.pdf','9ecdd2855a099b3f41ba2efeac2a807f.pdf','application/pdf',10,''),(411,400,'portal','','','','','','','도선문예','1',2,'','','',52,'거미줄같은 내인생/심중근','72','018_72.pdf','d9f9530e901777467b0ca438b41073ca.pdf','application/pdf',11,''),(412,400,'portal','','','','','','','도선문예','1',2,'','','',52,'갑술년 한해를 뒤돌아 보며 / 김인규','80','018_80.pdf','b52985613df1a9d320423c56043e31e1.pdf','application/pdf',12,''),(413,400,'portal','','','','','','','도선문예','1',2,'','','',52,'나의 입사 초년시절을 생각하며 / 박민숙','82','018_82.pdf','f53b11302a4b2fce0900adc02e748b43.pdf','application/pdf',13,''),(414,400,'portal','','','','','','','동정','1',2,'','','',52,'편집실','85','94_겨울_동정.pdf','c2469c9364b5cd70182fcc7f13c30d69.pdf','application/pdf',14,''),(415,400,'portal','','','','','','','법령코너','1',2,'','','',52,'도선법 연구ㆍ15 / 이성재','90','018_90.pdf','b36cdeefac9f47ce9dff22c60ee53de6.pdf','application/pdf',15,''),(416,400,'portal','','','','','','','기타','1',2,'','','',52,'추모사 | (故) 경연홍 선배의 서거를 추모하며 / 정연직','99','018_99.pdf','625bcffa338e1d6ddc85083842ffd00f.pdf','application/pdf',16,''),(417,400,'portal','','','','','','','기타','1',2,'','','',52,'알립니다 / 편집실','101','018_101.pdf','4ddff401583b19ff5ebbb4f591d6d1d1.pdf','application/pdf',17,''),(418,400,'portal','','','','','','','기타','1',2,'','','',52,'용퇴소식 / 편집실','105','018_105.pdf','fad607906752cc6869cf08d0141b8f1f.pdf','application/pdf',18,''),(419,400,'portal','','','','','','','교양특집','1',2,'','','',52,'권두시','02','018_02.pdf','c92ba6812bac962b839827753523994a.pdf','application/pdf',19,''),(420,400,'portal','','','','','','','교양특집','1',2,'','','',52,'고사성어','30','018_30.pdf','4a4f6175e2fad6867e138092e1865a6d.pdf','application/pdf',20,''),(421,400,'portal','','','','','','','교양특집','1',2,'','','',52,'3분 명상','47','018_47.pdf','967cf57e8e429a69a8da363276e71b30.pdf','application/pdf',21,''),(422,400,'portal','','','','','','','교양특집','1',2,'','','',52,'어떻게생각하십니까?','55','018_55.pdf','4201c3c51adcb2617decccba497b31d6.pdf','application/pdf',22,''),(423,400,'portal','','','','','','','교양특집','1',2,'','','',52,'건강','58','018_58.pdf','68c34fc806cb1886e079bfe9dba7ad55.pdf','application/pdf',23,''),(424,400,'portal','','','','','','','교양특집','1',2,'','','',52,'생활의 지혜','89','018_89.pdf','f377434f4ede5a70004edc92bddf54b5.pdf','application/pdf',24,''),(425,400,'portal','','','','','','','교양특집','1',2,'','','',52,'토막상식','106','018_106.pdf','8aa855e2bf1a3cfd3b3978102e1e73d7.pdf','application/pdf',25,''),(426,400,'portal','','','','','','','교양특집','1',2,'','','',52,'편집후기','108','018_108.pdf','b2ad8f59999a1f31c7bbf18365503993.pdf','application/pdf',26,''),(427,400,'portal','','','','','','','교양특집','1',2,'','','',52,'각 지회 주소','109','018_109.pdf','62e93c5b9aa43cac1a6dcbbeb4f1f1df.pdf','application/pdf',27,''),(428,0,'portal','1994','08','12','여름호','한국도선사협회','D01','','1',1,'1995년 여름호 도선지(통권19호)','','magzine_tit_801.gif',51,'','','','','',1,''),(429,428,'portal','','','','','','','협회동정','1',2,'','','',51,'편집실','03','019_03.pdf','0449cf892f80d537159851e4f2caacef.pdf','application/pdf',1,''),(430,428,'portal','','','','','','','권두언','1',2,'','','',51,'우리나라 도선사 정원과 도선료에 대한 소고 / 전효중','10','019_10.pdf','1d7cdf8ccfa02ad4efa4aa06e687e522.pdf','application/pdf',2,''),(431,428,'portal','','','','','','','도선논단','1',2,'','','',51,'선박의 안전을 위한 최적항로 배치 및 항로폭 결정에 관한 연구 / 김환수','12','019_12.pdf','ac8d02cace3b3f1f9e2a9e14ea70a70a.pdf','application/pdf',3,''),(432,428,'portal','','','','','','','도선논단','1',2,'','','',51,'도선업의 배경과 전망(2) / 이원철','34','019_34.pdf','256371abb310d3a58ccdce997323842b.pdf','application/pdf',4,''),(433,428,'portal','','','','','','','특별기획','1',2,'','','',51,'21세기 동북아 중심항으로 발돋움 하는 한국의 관문 인천항 /김병희','51','019_51.pdf','7134bc5eda3460fcc34fd4507eb3dd92.pdf','application/pdf',5,''),(434,428,'portal','','','','','','','도선인터뷰','1',2,'','','',51,'온유함을 가진 크리스찬 인천항 이행근 도선사 / 김병희','68','019_68.pdf','f1d74ae22e47b3ffc2d2c75163d18d09.pdf','application/pdf',6,''),(435,428,'portal','','','','','','','행사보고','1',2,'','','',51,'제12회 도선가족친선체육대회 / 편집실','76','019_76.pdf','843b2bdd58781147e1c9ed1dd663f0e3.pdf','application/pdf',7,''),(436,428,'portal','','','','','','','행사보고','1',2,'','','',51,'원로도선사(명예회원) 위로연 / 편집실','78','019_78.pdf','e37ea78e9ad22bb21d93cf6a1f3988d7.pdf','application/pdf',8,''),(437,428,'portal','','','','','','','기고','1',2,'','','',51,'세계화와 우리의 대응 / 김광득','80','019_80.pdf','da8f542effe3a82a7fa9232a33f153b0.pdf','application/pdf',9,''),(438,428,'portal','','','','','','','도선문예','1',2,'','','',51,'수필감상 \"봄\" / 피천득','90','019_90.pdf','652b0ca7378f5b5bdcb9e2b2b1989ef7.pdf','application/pdf',10,''),(439,428,'portal','','','','','','','도선문예','1',2,'','','',51,'영화감상 \"브레이브 하트\" / 편집실','93','019_93.pdf','62bc67df5a6f5451c9ea0dcef8f6aadd.pdf','application/pdf',11,''),(440,428,'portal','','','','','','','동정','1',2,'','','',51,'편집실','100','95_여름_동정.pdf','06199627dc5812b62e8e86f04319975a.pdf','application/pdf',12,''),(441,428,'portal','','','','','','','법령코너','1',2,'','','',51,'도선법 연구ㆍ16 / 이성재','104','019_104.pdf','eb0fe00f01a8e0a97d1222223c2e999a.pdf','application/pdf',13,''),(442,428,'portal','','','','','','','알림','1',2,'','','',51,'편집실','110','019_110.pdf','88bd2f5516b8037b0f8a7377d06a28c6.pdf','application/pdf',14,''),(443,428,'portal','','','','','','','해외정보 소식','1',2,'','','',51,'편집실','115','019_115.pdf','647b5fb81c33a268943726eab52569a5.pdf','application/pdf',15,''),(444,428,'portal','','','','','','','기타','1',2,'','','',51,'용퇴소식 / 편집실','117','019_117.pdf','9670789b5d61686c332065afee33420c.pdf','application/pdf',16,''),(445,428,'portal','','','','','','','교양특집','1',2,'','','',51,'권두시','02','019_02.pdf','af1968c6b892b66322b4c7d8db92622a.pdf','application/pdf',17,''),(446,428,'portal','','','','','','','교양특집','1',2,'','','',51,'고사성어','50','019_50.pdf','f8c4dc29285e352bb7057ef697d7f302.pdf','application/pdf',18,''),(447,428,'portal','','','','','','','교양특집','1',2,'','','',51,'건강상식','66','019_66.pdf','95bd27305f948c23a4e1a9f3e9d8106d.pdf','application/pdf',19,''),(448,428,'portal','','','','','','','교양특집','1',2,'','','',51,'시사상식','75','019_75.pdf','e95441243714a2a9ccd3a6cc8ee6c375.pdf','application/pdf',20,''),(449,428,'portal','','','','','','','교양특집','1',2,'','','',51,'생활의 지혜','90','019_90.pdf','d4e8455de846cda1c1a5245ee80e47e7.pdf','application/pdf',21,''),(450,428,'portal','','','','','','','교양특집','1',2,'','','',51,'스트레스 해소방법','95','019_95.pdf','9f7ead269168589317530651e0df8354.pdf','application/pdf',22,''),(451,428,'portal','','','','','','','교양특집','1',2,'','','',51,'생활의 지혜','98','019_98.pdf','70664aae6ff561380a86b6866ac42cce.pdf','application/pdf',23,''),(452,428,'portal','','','','','','','교양특집','1',2,'','','',51,'편집후기','120','019_120.pdf','a60928ddc313f71b70c97d768bcf5ebd.pdf','application/pdf',24,''),(453,428,'portal','','','','','','','교양특집','1',2,'','','',51,'각 지회 주소','121','019_121.pdf','43e71233beaf8c46b0a95c0ecf073cc1.pdf','application/pdf',25,''),(454,0,'portal','1995','12','30','가을·겨울호','한국도선사협회','D01','','1',1,'1995년 겨울호 도선지(통권20호)','','magazine_tit_769.gif',50,'','','','','',1,''),(455,454,'portal','','','','','','','협회동정','1',2,'','','',50,'편집실','03','020_03.pdf','0b935ad9be4e0721db2e2a38c383fa5b.pdf','application/pdf',1,''),(456,454,'portal','','','','','','','권두언','1',2,'','','',50,'우리나라 도선업의 발전방향에 관하여 / 이주완','10','020_10.pdf','b45b8f4678c17a69eb7665fc4e2d54ea.pdf','application/pdf',2,''),(457,454,'portal','','','','','','','취임사','1',2,'','','',50,'21세기 대비, 발전하는 해운항만 정책 펼칠 터 / 이부식 ','12','020_12.pdf','829e8874231ca0b69f521774ff79f6fd.pdf','application/pdf',3,''),(458,454,'portal','','','','','','','도선논단','1',2,'','','',50,'바람과 조류가 조선에 미치는 영향 및 계산사례 / 윤점동','15','020_15.pdf','e60f91c21827da5c5bca838252682977.pdf','application/pdf',4,''),(459,454,'portal','','','','','','','도선논단','1',2,'','','',50,'해양유류 오염방지 및 방제자재에 관한 연구 / 정영모','27','020_27.pdf','c5ea0d69af1096d2434f9f2fc8576372.pdf','application/pdf',5,''),(460,454,'portal','','','','','','','도선현장을 가다','1',2,'','','',50,'세계로 뻗어가는 한국 제일의 항만 경제성장과 국제무역의 현주소, 부산항 /김병희','44','020_44.pdf','f6369a8d563c70ae69c7cad30a4c39c9.pdf','application/pdf',6,''),(461,454,'portal','','','','','','','도선인터뷰','1',2,'','','',50,'도선경력 29년의 바다인생 부산항 이용규 도선사 / 김병희','58','020_58.pdf','8ea8fa4dda9c21f8dd93ba1be9a87857.pdf','application/pdf',7,''),(462,454,'portal','','','','','','','행사보고','1',2,'','','',50,'제10차 한ㆍ일 도선사 간친회 보고 / 편집실','67','020_67.pdf','717c27aeb445a88d311041be606e34b5.pdf','application/pdf',8,''),(463,454,'portal','','','','','','','행사보고','1',2,'','','',50,'제13회 도선가족 친선 추계체육대회 개최 / 편집실','70','020_70.pdf','281a7093cb279ed69c110c2aea0932de.pdf','application/pdf',9,''),(464,454,'portal','','','','','','','건강','1',2,'','','',50,'우리 몸의 화학공장, 간을 건강하게 / 김기현','73','020_73.pdf','d09cc6455ba2de524e5abe6e6ae407ee.pdf','application/pdf',10,''),(465,454,'portal','','','','','','','특별기고','1',2,'','','',50,'나의 인생항로 / 이태호','78','020_78.pdf','1d304a1f9d993a4035cf50d4d7d3a8ef.pdf','application/pdf',11,''),(466,454,'portal','','','','','','','특별기고','1',2,'','','',50,'나의 길(My Way) / 이명식','82','020_82.pdf','b882dfe3eec94e918f7ddc1204115fb6.pdf','application/pdf',12,''),(467,454,'portal','','','','','','','특별기고','1',2,'','','',50,'J선장, O선장, L선장 및 Y선장님! / 황의창','84','020_84.pdf','77f922a0f554ac68a33a8cadcc446861.pdf','application/pdf',13,''),(468,454,'portal','','','','','','','특별기고','1',2,'','','',50,'아쉬운 우리의 해양유적/박인석','86','020_86.pdf','7156ea8753b8a6f4968f4fb873354ddc.pdf','application/pdf',14,''),(469,454,'portal','','','','','','','도선문예','1',2,'','','',50,'시감상 \" 시인이 보내 온 사랑의 편지\" / 이생진','92','020_92.pdf','0bdaa6109905441a5ea4505ea2d3e6e8.pdf','application/pdf',15,''),(470,454,'portal','','','','','','','도선문예','1',2,'','','',50,'시 \"큰 바다\" / 최영호','93','020_93.pdf','f014070df7df012623498918b76272e1.pdf','application/pdf',16,''),(471,454,'portal','','','','','','','도선문예','1',2,'','','',50,'자비심이 곧 여래다 / 옥태영','94','020_94.pdf','cf1a5c8396b8558647da99950d7059ff.pdf','application/pdf',17,''),(472,454,'portal','','','','','','','도선문예','1',2,'','','',50,'홍세화의 \"나는 파리의 택시운전사\"를 읽고 / 김정례','96','020_96.pdf','f87d9aee867d06a71186cab5ec71fcdd.pdf','application/pdf',18,''),(473,454,'portal','','','','','','','도선문예','1',2,'','','',50,'화제의 책 \"한 자연주의자의 죽음\" / 편집실','98','020_86.pdf','06e76a4df1cd1d1bab08513afdcb83af.pdf','application/pdf',19,''),(474,454,'portal','','','','','','','동정','1',2,'','','',50,'편집실','100','95_겨울_동정.pdf','59023594ac83eda29ad04d1920e558bd.pdf','application/pdf',20,''),(475,454,'portal','','','','','','','News','1',2,'','','',50,'편집실','104','020_104.pdf','a666cc699eb2c897220f79d19f1d766d.pdf','application/pdf',21,''),(476,454,'portal','','','','','','','해외정보 소식','1',2,'','','',50,'편집실','109','020_109.pdf','b83529e9b6b44639084a9bae8b4d4201.pdf','application/pdf',22,''),(477,454,'portal','','','','','','','교양특집','1',2,'','','',50,'권두시','02','020_02.pdf','ecf87fa5b5613e00a8eef665b5720b0d.pdf','application/pdf',23,''),(478,454,'portal','','','','','','','교양특집','1',2,'','','',50,'취미와 레저','65','020_65.pdf','ed1b54b54f9db9030b786c1ead2f1998.pdf','application/pdf',24,''),(479,454,'portal','','','','','','','교양특집','1',2,'','','',50,'시사상식','72','020_72.pdf','61cf6955167c248696e981694c35690e.pdf','application/pdf',25,''),(480,454,'portal','','','','','','','교양특집','1',2,'','','',50,'칠금법','72','020_72.pdf','f4458e8503e313de8cc8dded2b887bb3.pdf','application/pdf',26,''),(481,454,'portal','','','','','','','교양특집','1',2,'','','',50,'생활의 지혜','90','020_90.pdf','98dfb21242000ad6b4748014ed0ae424.pdf','application/pdf',27,''),(482,454,'portal','','','','','','','교양특집','1',2,'','','',50,'웃으며 삽시다','108','020_108.pdf','ddbdf2d33f345793766f2bedb3eea7f7.pdf','application/pdf',28,''),(483,454,'portal','','','','','','','교양특집','1',2,'','','',50,'편집후기','110','020_110.pdf','6f0997faf31c8239fafffc3702e3a537.pdf','application/pdf',29,''),(484,454,'portal','','','','','','','교양특집','1',2,'','','',50,'각 지회 주소','111','020_111.pdf','ff180761b9355b483c826484d383c779.pdf','application/pdf',30,''),(485,0,'portal','1996','08','21','여름호','한국도선사협회','D01','','1',1,'1996년 여름호 도선지(통권21호)','','magzine_tit_739.gif',49,'','','','','',1,''),(486,485,'portal','','','','','','','협회동정','1',2,'','','',49,'편집실','03','021_03.pdf','e47139f837ee7905a9cd133f013340b2.pdf','application/pdf',1,''),(487,485,'portal','','','','','','','권두언','1',2,'','','',49,'안전도선에 관하여 / 이차환','10','021_10.pdf','b3221e06fe9c9b2e7b79a9de09d82e62.pdf','application/pdf',2,''),(488,485,'portal','','','','','','','취임사','1',2,'','','',49,'해양수산부 초대 장관 취임사 / 신상우','12','021_12.pdf','95f8ab5d4acf5bd1b02fc1805a55c42d.pdf','application/pdf',3,''),(489,485,'portal','','','','','','','도선논단','1',2,'','','',49,'인천항 출입항로 개선 방안에 관한 시뮬레이션 연구/ 김환수, 정세모, 허일, 이덕수','14','021_14.pdf','f43ae351846f99b5abc1f29c8d6b2945.pdf','application/pdf',4,''),(490,485,'portal','','','','','','','도선현장을 가다','1',2,'','','',49,'2000년대 환태평양 시대의 거점 항만 도시, 울산항 /김병희','42','021_42.pdf','0f3ff22c3ac396f387460128f834574e.pdf','application/pdf',5,''),(491,485,'portal','','','','','','','도선인터뷰','1',2,'','','',49,'과묵하고 강직한 바다 사나이 울산항 이강호 도선사 / 김병희','61','021_61.pdf','aa4a3f0d0e105d57515dfb48e93fde60.pdf','application/pdf',6,''),(492,485,'portal','','','','','','','행사보고','1',2,'','','',49,'제13차 IMPA(국제도선사협회) 총회 참석 보고서 / 김길성','67','021_67.pdf','4dadb68d35eb90f4a14ca3e1b8c3644f.pdf','application/pdf',7,''),(493,485,'portal','','','','','','','특별기고','1',2,'','','',49,'항만안전, 도선사의 기량에만 의존하는가? / 이상집','80','021_80.pdf','aac9c326c57e74556f12bea2ffc5623c.pdf','application/pdf',8,''),(494,485,'portal','','','','','','','기타','1',2,'','','',49,'취미와 레저 | 래프팅-급류와 싸우는 쾌감 / 편집실','82','021_82.pdf','58d570b645b1436f1f9a4927427bdf97.pdf','application/pdf',9,''),(495,485,'portal','','','','','','','기타','1',2,'','','',49,'취미와 레저 | 골프-턱밑에서 퍼팅샷 / 편집실','83','021_83.pdf','d46cba0e4a869cca4e65e4fbdfeab8b9.pdf','application/pdf',10,''),(496,485,'portal','','','','','','','도선기고','1',2,'','','',49,'정열가 김수금 도선사의 \"25시 바다 인생\" / 김병희','84','021_84.pdf','9f16dd4f39352683eba9800f329dcd21.pdf','application/pdf',11,''),(497,485,'portal','','','','','','','기타','1',2,'','','',49,'시사상식 | 디지털과 아날로그 / 편집실','89','021_89.pdf','483cd0c073c43368a114653c6c376fad.pdf','application/pdf',12,''),(498,485,'portal','','','','','','','건강','1',2,'','','',49,'현대인의 스트레스 탈출법 / 편집실','91','021_91.pdf','90df62d9be9bdc1373f7e3f9a006a073.pdf','application/pdf',13,''),(499,485,'portal','','','','','','','특별기획','1',2,'','','',49,'명예회원님을 모시고 호반의 도시, 춘천을 가다 / 김범재','94','021_94.pdf','fd5ee63a4a96325fdddfa59b6e2f9424.pdf','application/pdf',14,''),(500,485,'portal','','','','','','','문화마당','1',2,'','','',49,'문학 | 시선집<내 마음의 바다> / 편집실','102','021_102.pdf','82b7558ce49e688b0b9c6125912de4f5.pdf','application/pdf',15,''),(501,485,'portal','','','','','','','문화마당','1',2,'','','',49,'영화|미션 임파서블 / 편집실','103','021_103.pdf','2cc31bd6a8350fea69fd56b1b9411830.pdf','application/pdf',16,''),(502,485,'portal','','','','','','','문화마당','1',2,'','','',49,'서평 | 103인의현대사상 /편집실','105','021_105.pdf','7870e4fe1381bb85f1964c2aaeb42b23.pdf','application/pdf',17,''),(503,485,'portal','','','','','','','문화마당','1',2,'','','',49,'추천서적 / 편집실','106','021_106.pdf','2e463fede7e03d2030f4398a71b351a6.pdf','application/pdf',18,''),(504,485,'portal','','','','','','','문화마당','1',2,'','','',49,'여름여행 | 그곳에 가고 싶다 / 편집실','','','','',19,''),(505,485,'portal','','','','','','','동정','1',2,'','','',49,'협회 및 지회 소식 / 편집실','109','96_여름_동정.pdf','8f14d0c7c51f484ea2405b43703c1506.pdf','application/pdf',20,''),(506,485,'portal','','','','','','','News','1',2,'','','',49,'편집실','116','021_116.pdf','5ca76c0ac9a55d9293389189c2ae59e4.pdf','application/pdf',21,''),(507,485,'portal','','','','','','','해외정보 소식','1',2,'','','',49,'제13차 IMPA 총회 결의사항 / 편집실','121','021_121.pdf','88c76e7e82240a843788bd9eac1753e2.pdf','application/pdf',22,''),(508,485,'portal','','','','','','','교양특집','1',2,'','','',49,'권두시','02','021_02.pdf','11e5206bf68c14cdcceab3be223abcf4.pdf','application/pdf',23,''),(509,485,'portal','','','','','','','교양특집','1',2,'','','',49,'고사성어 | 人之將死言也善','60','021_60.pdf','4510c28e913128e7d619f88b2da467f7.pdf','application/pdf',24,''),(510,485,'portal','','','','','','','교양특집','1',2,'','','',49,'세계 화폐 단위의 어원들','79','021_79.pdf','418b26054f4e8b02d91fbed304868218.pdf','application/pdf',25,''),(511,485,'portal','','','','','','','교양특집','1',2,'','','',49,'생활의 지혜 | 내일로 보는 날씨 정보','92','021_92.pdf','f647203a16f182c2dea0856515ef231d.pdf','application/pdf',26,''),(512,485,'portal','','','','','','','교양특집','1',2,'','','',49,'사색의 창 | 즐거운 마음이 행복을 불러온다','115','021_115.pdf','77f1eb6834cebaf903f9b767cfadc319.pdf','application/pdf',27,''),(513,485,'portal','','','','','','','교양특집','1',2,'','','',49,'편집후기','125','021_125.pdf','25ee14157f1d7846391674f828794ff7.pdf','application/pdf',28,''),(514,485,'portal','','','','','','','교양특집','1',2,'','','',49,'각 지회 주소','127','021_127.pdf','837eb6bac708b13a43ffc98fe9fd94b5.pdf','application/pdf',29,''),(515,0,'portal','1997','03','17','봄호','한국도선사협회','D01','','1',1,'1997년 봄호 도선지(통권22호)','','magzine_tit_710.gif',48,'','','','','',1,''),(516,515,'portal','','','','','','','협회동정','1',2,'','','',48,'편집실','03','022_03.pdf','539a3cbbe4168abf5924c771891bd72a.pdf','application/pdf',1,''),(517,515,'portal','','','','','','','권두언','1',2,'','','',48,'도선사와 해상안전 / 이항규','10','022_10.pdf','67d48f1345bb6c2cc84deeadef34bcca.pdf','application/pdf',2,''),(518,515,'portal','','','','','','','신년사','1',2,'','','',48,'일류 해양국가 건설을 위한 우리 역량 다지는 한 해 되길 / 신상우','12','022_12.pdf','60dfc9ed29a0ad1e4b0a356631606c82.pdf','application/pdf',3,''),(519,515,'portal','','','','','','','도선논단','1',2,'','','',48,'IMO 조종성 표준 해설 / 윤점동','15','022_15.pdf','cc5e2451f31eaacd4d45f5717918bf19.pdf','application/pdf',4,''),(520,515,'portal','','','','','','','도선현장을 가다','1',2,'','','',48,'남해안의 비경(秘境)인 한려수도(閑麗水道)의 중심도시, 한국의 나폴리 여수(麗水)ㆍ광양항(光陽港)을 찾아서 / 김병희','45','022_45.pdf','e11e82100c01623fad782e9fc26531a5.pdf','application/pdf',5,''),(521,515,'portal','','','','','','','도선인터뷰','1',2,'','','',48,'안전도선 22년의 다정다감한 여수항 이해성 도선사(Pilot)클래식을 좋아하고 젊은 감각을 지닌 베테랑 파일럿 / 김병희','65','022_65.pdf','2013f981d601baf8c1a66b7003a0c01d.pdf','application/pdf',6,''),(522,515,'portal','','','','','','','기타','1',2,'','','',48,'취미와 레저 | 스키(Ski) 설원이 부른다 / 편집실','75','022_75.pdf','fe210372f02f74c9c17c37188d294464.pdf','application/pdf',7,''),(523,515,'portal','','','','','','','기타','1',2,'','','',48,'취미와 레저 | 골프(Golf) 골프의 세가지 금연 / 편집실','79','022_79.pdf','2d3a3a42419beb7ef9929820860ba282.pdf','application/pdf',8,''),(524,515,'portal','','','','','','','기고','1',2,'','','',48,'테마기획 | 경쟁력이란? / 김필상','80','022_80.pdf','2fc02c58428c44822b597008b4f81ea3.pdf','application/pdf',9,''),(525,515,'portal','','','','','','','기고','1',2,'','','',48,'테마기획 | 오랜 꿈을 이룬 수습도선사의 기쁨 / 윤병원','84','022_84.pdf','565333034f0e00ed89ac7d4192efd6a4.pdf','application/pdf',10,''),(526,515,'portal','','','','','','','건강','1',2,'','','',48,'四象체질에 맞춰 건강 설계 / 편집실','87','022_87.pdf','5f0f45266d182d96d3678456fa11d864.pdf','application/pdf',11,''),(527,515,'portal','','','','','','','건강','1',2,'','','',48,'라이프 스타일 | 귀댁의 \'삶의 질\'과 \'행복도\'는 몇점? / 편집실','90','022_90.pdf','9cc8ff286b2601c75f8b7e82bf738cbb.pdf','application/pdf',12,''),(528,515,'portal','','','','','','','문화마당','1',2,'','','',48,'한편의 시 | 「외눈박이 물고기의 사랑」/ 류시화','96','022_96.pdf','b3b6dc8a9e45101d3f62bae6b11f6e01.pdf','application/pdf',13,''),(529,515,'portal','','','','','','','문화마당','1',2,'','','',48,'기행 | 유럽여행 / 박인석','97','022_97.pdf','2bb858bd2b0690a313c3f9db5d02f43e.pdf','application/pdf',14,''),(530,515,'portal','','','','','','','문화마당','1',2,'','','',48,'시네마천국 |「센스 앤 센서빌리티」와「데드 맨 워킹」영화속의 \"선과 악\"/편집실','106','022_106.pdf','2bad05ff4be13e90ad366f60ec3e3807.pdf','application/pdf',15,''),(531,515,'portal','','','','','','','문화마당','1',2,'','','',48,'서평 | 아이언 모리슨의 「제2의 커브(The Second Curve)」/ 편집실','108','022_108.pdf','09809da95d9de842605edce793a51eae.pdf','application/pdf',16,''),(532,515,'portal','','','','','','','문화마당','1',2,'','','',48,'추천서적 / 편집실','109','022_109.pdf','51030d27047c55550815943c8437dedc.pdf','application/pdf',17,''),(533,515,'portal','','','','','','','동정','1',2,'','','',48,'협회 및 지회 소식 / 편집실','112','97_봄_동정.pdf','4843b53e034cab8ddd5e16435ddc3d60.pdf','application/pdf',18,''),(534,515,'portal','','','','','','','최신도선정보','1',2,'','','',48,'한국 도선사 현황 / 편집실','127','022_127.pdf','7be74c47179977b9c15beecf75249a64.pdf','application/pdf',19,''),(535,515,'portal','','','','','','','교양특집','1',2,'','','',48,'권두시','02','022_02.pdf','38a64681c08daf5145cf644a289e168e.pdf','application/pdf',20,''),(536,515,'portal','','','','','','','교양특집','1',2,'','','',48,'마음의 여유 | 행복한 가정을 만드는 공식','64','022_64.pdf','dc8e7fb4cccd3cf839fded401fa08437.pdf','application/pdf',21,''),(537,515,'portal','','','','','','','교양특집','1',2,'','','',48,'바른말 우리말','74','022_74.pdf','5b17f93a87bc3c47f5bebaadef2f2500.pdf','application/pdf',22,''),(538,515,'portal','','','','','','','교양특집','1',2,'','','',48,'시사에센스','74','022_74.pdf','4dd91f7ca90df87ee4a8316bfbd31657.pdf','application/pdf',23,''),(539,515,'portal','','','','','','','교양특집','1',2,'','','',48,'사색의 창|애악잠','73','022_73.pdf','874d5abf43e1c3be6b53189f7d260d8b.pdf','application/pdf',24,''),(540,515,'portal','','','','','','','교양특집','1',2,'','','',48,'건강십계','89','022_89.pdf','c3a74121f147af07054f605e8d2d5067.pdf','application/pdf',25,''),(541,515,'portal','','','','','','','교양특집','1',2,'','','',48,'원고모집','94','022_94.pdf','8f29c7dd7a1f6c1afbcfeeb6ad243ded.pdf','application/pdf',26,''),(542,515,'portal','','','','','','','교양특집','1',2,'','','',48,'편집후기','132','022_132.pdf','ee55dcd1411351653373e521f1902862.pdf','application/pdf',27,''),(543,515,'portal','','','','','','','교양특집','1',2,'','','',48,'각 지회 주소','133','022_133.pdf','6a0fd7be07bd3603db3d94c79f9b2ca5.pdf','application/pdf',28,''),(544,0,'portal','1997','09','11','가을·겨울호','한국도선사협회','D01','','1',1,'1997년 가을호 도선지(통권23호)','','magzine_tit_682.gif',47,'','','','','',1,''),(545,544,'portal','','','','','','','협회동정','1',2,'','','',47,'편집실','03','023_03.pdf','5e4767cf4bed5081dbd023cf8253fc4c.pdf','application/pdf',1,''),(546,544,'portal','','','','','','','권두언','1',2,'','','',47,'해양전문가로서의 도선사의 역할 / 조경식','10','023_10.pdf','2895350f5ac0fad7732c976363c22e79.pdf','application/pdf',2,''),(547,544,'portal','','','','','','','축사','1',2,'','','',47,'창립 20주년 | 안전도선으로 국가경쟁력 향상에 이바지하고… / 신석흔','12','023_12.pdf','9da2be70c9f0e525c8ac0621357f4759.pdf','application/pdf',3,''),(548,544,'portal','','','','','','','도선논단','1',2,'','','',47,'OCIMF의 풍조압력 계산법에 의한 조타 및 통항속력 결정 / 이태호','14','023_14.pdf','b17fa9b5293ae7fb1d12e96cfc012a88.pdf','application/pdf',4,''),(549,544,'portal','','','','','','','도선논단','1',2,'','','',47,'한국 해상에서의 해난의 발생현황과 대응 방안 / 김길수','31','023_31.pdf','789641937bd1bf5bb3bce11b858f6538.pdf','application/pdf',5,''),(550,544,'portal','','','','','','','도선현장을 가다','1',2,'','','',47,'21세기 환태평양과 동남아시아권의 중심 국제교역항으로 발돋움하려는 천혜의 양항, 마산항 / 김병희','51','023_51.pdf','8b16dc734752c6f4c388e45873ce0b47.pdf','application/pdf',6,''),(551,544,'portal','','','','','','','도선인터뷰','1',2,'','','',47,'외강내유의 바다 사나이 마산항 이보언 도선사 / 김병희','73','023_73.pdf','30d515565447e58d293e5569afc36e39.pdf','application/pdf',7,''),(552,544,'portal','','','','','','','특집','1',2,'','','',47,'바다의 날 기념 | 안전도선을 최우선 목표로 / 신석흔','80','023_80.pdf','e783857238f1ee7fb5353e3e5151d58e.pdf','application/pdf',8,''),(553,544,'portal','','','','','','','행사보고','1',2,'','','',47,'원로도선사 위로연 수행기 / 최영환','84','023_84.pdf','2bfd7f5a8e623a0dd699c0d9918899fa.pdf','application/pdf',9,''),(554,544,'portal','','','','','','','특별기고','1',2,'','','',47,'소록도에 다녀와서 / 윤영원','88','023_88.pdf','d9d5fc6e73089cd2c67fa4187ead2c2d.pdf','application/pdf',10,''),(555,544,'portal','','','','','','','특별기고','1',2,'','','',47,'안전불감증이 사고를 부른다 / 김인규','92','023_92.pdf','451fc1fcbf3826a09bdb8d91e6f5b945.pdf','application/pdf',11,''),(556,544,'portal','','','','','','','건강','1',2,'','','',47,'스트레스 탈출 7단계 / 편집실','94','023_94.pdf','30c6d6edc28fe3fff5ebeb8331bf975d.pdf','application/pdf',12,''),(557,544,'portal','','','','','','','문화마당','1',2,'','','',47,'시 | 우리 만난 이 세상에 / 용혜원','97','023_97.pdf','7f033190960776ed6cc3ba3eb14ac775.pdf','application/pdf',13,''),(558,544,'portal','','','','','','','문화마당','1',2,'','','',47,'서평 | 조경란의 「식빵굽는 시간」/ 편집실','98','023_98.pdf','6d85db338319c7db83655c542a39ec4a.pdf','application/pdf',14,''),(559,544,'portal','','','','','','','문화마당','1',2,'','','',47,'추천서적 / 편집실','101','023_101.pdf','f618e986e3005b608ed2bd642041f383.pdf','application/pdf',15,''),(560,544,'portal','','','','','','','동정','1',2,'','','',47,'협회 및 지회 회원 소식 / 편집실','103','97_가을_동정.pdf','9326061c5c91bc5b37072ed4c9c9e2ac.pdf','application/pdf',16,''),(561,544,'portal','','','','','','','News','1',2,'','','',47,'편집실','110','023_110.pdf','2bb57a600d5dd351bc4daaafff2e1e80.pdf','application/pdf',17,''),(562,544,'portal','','','','','','','해외정보 소식','1',2,'','','',47,'제11차 한ㆍ일 도선사 간친회(KMPA-JPA Meting)일정 / 편집실','114','023_114.pdf','12c4b878962bbb00c5a2e2e62653cf7b.pdf','application/pdf',18,''),(563,544,'portal','','','','','','','교양특집','1',2,'','','',47,'photo gallery','02','023_02.pdf','4147a7e20dfb331929e8c4accbbfadf1.pdf','application/pdf',19,''),(564,544,'portal','','','','','','','교양특집','1',2,'','','',47,'사색의 창 | 행복한 가정을 위한 10가지 비결','50','023_50.pdf','524aae2c32ab4dbf212c90be65f34af0.pdf','application/pdf',20,''),(565,544,'portal','','','','','','','교양특집','1',2,'','','',47,'명심보감 | 분노의 감정은 빨리 삭일수록 좋다','72','023_72.pdf','af2ddb9cbf724840c4b52bfdef7707d9.pdf','application/pdf',21,''),(566,544,'portal','','','','','','','교양특집','1',2,'','','',47,'삼분명상 | 크게 생각하기 위해…','91','023_91.pdf','5bb408b8982fde8b2bd54e98d81065f2.pdf','application/pdf',22,''),(567,544,'portal','','','','','','','교양특집','1',2,'','','',47,'폭소 유머 | 술 두잔','95','023_95.pdf','c5901ea7263e39ff38ec10aa9ff41d78.pdf','application/pdf',23,''),(568,544,'portal','','','','','','','교양특집','1',2,'','','',47,'퍼즐','95','023_95.pdf','fbabbb424488b7e84d4cb1f6ee04cedd.pdf','application/pdf',24,''),(569,544,'portal','','','','','','','교양특집','1',2,'','','',47,'영어 한마디 | 바캉스','115','023_115.pdf','c0305833da2b02bb3c743900dd0e666b.pdf','application/pdf',25,''),(570,544,'portal','','','','','','','교양특집','1',2,'','','',47,'편집후기','116','023_116.pdf','459a028a8b1253a1711bd250f981196b.pdf','application/pdf',26,''),(571,544,'portal','','','','','','','교양특집','1',2,'','','',47,'각 지회 주소','117','023_117.pdf','ea63b4c08289997ebdec06ec78faf0b3.pdf','application/pdf',27,''),(572,0,'portal','1998','01','20','신년호','한국도선사협회','D01','','1',1,'1998년 신년호 도선지(통권24호)','','magzine_tit_655.gif',46,'','','','','',1,''),(573,572,'portal','','','','','','','협회동정','1',2,'','','',46,'편집실','03','024_03.pdf','a81e44f04062228e770ece0ad0b9e355.pdf','application/pdf',1,''),(574,572,'portal','','','','','','','권두언','1',2,'','','',46,'21세기 세계 해운국가 건설을 위한 전략 / 조수호','10','024_10.pdf','f5079182244dd5ecc10b2d836965b62f.pdf','application/pdf',2,''),(575,572,'portal','','','','','','','신년사','1',2,'','','',46,'굳건한 사명감으로 활기찬 새해를 열어 나갑시다 / 신석흔','12','024_12.pdf','98cb04de957cec5121a0594202f31a3e.pdf','application/pdf',3,''),(576,572,'portal','','','','','','','신년사','1',2,'','','',46,'국민에게 해양에 대한 비전 제시로 일류 해양국가로 웅비 / 조정제','14','024_14.pdf','cfb2ecda7e8f1fdc1d328dccd3f344b5.pdf','application/pdf',4,''),(577,572,'portal','','','','','','','도선논단','1',2,'','','',46,'선박의 안전운항과 해상교통관리제도(VTS) / 박진수','17','024_17.pdf','3f1974c8e21b63834aaa1ff69681b632.pdf','application/pdf',5,''),(578,572,'portal','','','','','','','도선현장을 가다','1',2,'','','',46,'개항 100주년을 맞아 \"21세기 동북아 거점항\" 으로 힘찬 날개짓을 하고 있는 목포항을 찾아서 / 김병희','41','024_41.pdf','fd02fc85f6ff8baf84af41797396527f.pdf','application/pdf',6,''),(579,572,'portal','','','','','','','도선인터뷰','1',2,'','','',46,'검소함과 순수함을 간직한 인정 많은 목포항 임방남 도선사 신앙인으로서 하나님을 공경하는 장로님 / 김병희','53','024_53.pdf','f8e48c668e752e29b7726da24b9aaa13.pdf','application/pdf',7,''),(580,572,'portal','','','','','','','특별기고','1',2,'','','',46,'한국정신과학 학회 학술대화 발표 논문 | 프랙탈(Fractal) 우주론 / 정윤표','57','024_57.pdf','a676867166ab3aa4d1014101b028e0a0.pdf','application/pdf',8,''),(581,572,'portal','','','','','','','기고','1',2,'','','',46,'이 바다에서 또 하나의 출발 / 김영대','62','024_62.pdf','36faa42104b5c17e428c1d0e3763c39c.pdf','application/pdf',9,''),(582,572,'portal','','','','','','','건강','1',2,'','','',46,'건강/잇몸 관리 이렇게 하라 | 식사 마지막에 채소를… / 편집실','64','024_64.pdf','29bd5ca4305163dd80bd912b49448664.pdf','application/pdf',10,''),(583,572,'portal','','','','','','','행사보고','1',2,'','','',46,'제11차 한ㆍ일 도선사 간친회 개최 / 협회사무국','66','024_66.pdf','b3da2bbfedefd58923d4255350fae5db.pdf','application/pdf',11,''),(584,572,'portal','','','','','','','행사보고','1',2,'','','',46,'한국측 주제발표 | 한국도선법에서 규정한 도선운영협의회에 관한 연구 / 송용무','70','024_70.pdf','b9cd1061c2e7f9bf6d1e06fa706b41ce.pdf','application/pdf',12,''),(585,572,'portal','','','','','','','행사보고','1',2,'','','',46,'일본측 주제발표 | YOKOHAMA 항내에서의 안전항해 / 송창 광길','73','024_73.pdf','cbb1e888a5ea3d678b0dd52a58ed932b.pdf','application/pdf',13,''),(586,572,'portal','','','','','','','문화마당','1',2,'','','',46,'한편의 시 | 끝끝내 / 정호승 - 78 - 한편의 에세이 | 어머니 / 리사 보이드','79','024_79.pdf','644953890b58538e8d52336b9e5f2f4c.pdf','application/pdf',14,''),(587,572,'portal','','','','','','','문화마당','1',2,'','','',46,'독자투고 | 등잔불 이야기 / 김동정','81','024_81.pdf','18012de5ac1c4be167504e5c12a9fb14.pdf','application/pdf',15,''),(588,572,'portal','','','','','','','문화마당','1',2,'','','',46,'시네마 천국 | 영화「아편전쟁」과 「차이니스 박스」/ 편집실','83','024_83.pdf','958b762ad857faa75edd1fcd94a67ee0.pdf','application/pdf',16,''),(589,572,'portal','','','','','','','문화마당','1',2,'','','',46,'서평 | 역사와 문학이 떠나는 기행 / 편집실','85','024_85.pdf','ef4245b695a150e3364ff0e872af802c.pdf','application/pdf',17,''),(590,572,'portal','','','','','','','동정','1',2,'','','',46,'협회 및 지회 소식 / 편집실','86','98_신년_동정.pdf','a23633ea4a4a03cfdd7ee2939764448a.pdf','application/pdf',18,''),(591,572,'portal','','','','','','','News','1',2,'','','',46,'편집실','92','024_92.pdf','d5631859332aaf84104d82f4235c3362.pdf','application/pdf',19,''),(592,572,'portal','','','','','','','법령코너','1',2,'','','',46,'도선법시행규칙 개정 공포 / 협회사무국','95','024_95.pdf','fd6d34f5e53283037b3de241e29c80b5.pdf','application/pdf',20,''),(593,572,'portal','','','','','','','교양특집','1',2,'','','',46,'권두글 | 신발 한짝','02','024_02.pdf','c9cbe66b5d9c484b9624cdb68a1d6b97.pdf','application/pdf',21,''),(594,572,'portal','','','','','','','교양특집','1',2,'','','',46,'삼분명상 | 자신의 의지대로 살아간다','40','024_40.pdf','03d2ef438f8a7bc0fb2568c5c5545cdb.pdf','application/pdf',22,''),(595,572,'portal','','','','','','','교양특집','1',2,'','','',46,'생활의 지혜 | 경혈자극','61','024_61.pdf','2d8503e2830dfa5abea60294a14faa35.pdf','application/pdf',23,''),(596,572,'portal','','','','','','','교양특집','1',2,'','','',46,'원고모집','76','024_76.pdf','e0e317310be353fde77ec3b0cdd7ae40.pdf','application/pdf',24,''),(597,572,'portal','','','','','','','교양특집','1',2,'','','',46,'편집후기','102','024_102.pdf','17d10cae56fb18df0b3c0acf64d9773e.pdf','application/pdf',25,''),(598,572,'portal','','','','','','','교양특집','1',2,'','','',46,'각 지회 주소','103','024_103.pdf','f2584131cecfe59028c156978854f062.pdf','application/pdf',26,''),(599,0,'portal','1998','07','27','여름호','한국도선사협회','D01','','1',1,'1998년 여름호 도선지(통권25호)','','magzine_tit_626.gif',45,'','','','','',1,''),(600,599,'portal','','','','','','','협회동정','1',2,'','','',45,'편집실','03','025_03.pdf','62cc80512e02347d0eb12fea2af8b863.pdf','application/pdf',1,''),(601,599,'portal','','','','','','','권두언','1',2,'','','',45,'새로운 해양환경과 도선사의 역할 / 이병건','10','025_10.pdf','f36d806df3889119cf4940c017c54edb.pdf','application/pdf',2,''),(602,599,'portal','','','','','','','도선논단','1',2,'','','',45,'도선운영제도의 발전 방향 / 김길성','12','025_12.pdf','db1ae2ea1800a9e7a60b2bb89a364a2f.pdf','application/pdf',3,''),(603,599,'portal','','','','','','','도선논단','1',2,'','','',45,'LPGㆍLNG 탱커 및 항만의 안전성의 고찰 / 박현화','20','025_20.pdf','9434b7b085ccec656d2e8fe66654ea25.pdf','application/pdf',4,''),(604,599,'portal','','','','','','','도선현장을 가다','1',2,'','','',45,'서해안 시대, 새롭게 급부상하고 있는 대산항을 찾아서 / 김병희','27','025_27.pdf','df28cb732f00901ba881d2e731e90898.pdf','application/pdf',5,''),(605,599,'portal','','','','','','','도선인터뷰','1',2,'','','',45,'바다를 향한 집념의 바다사나이, 대산항 육일웅 도선사 /김병희','40','025_40.pdf','27c9fea91a56bbac2c0baf53e36e2d07.pdf','application/pdf',6,''),(606,599,'portal','','','','','','','특별기고','1',2,'','','',45,'한국정신과학학회학술대화발표논문|프랙탈(Fractal)우주론ㆍ2 /우병구','45','025_45.pdf','c44b0678504c424699eedb9a7633a8dc.pdf','application/pdf',7,''),(607,599,'portal','','','','','','','도선칼럼','1',2,'','','',45,'꿈으로 간직한 도선사가 되어 / 문학봉','56','025_56.pdf','8b16a8304e595633301a82fe6481291c.pdf','application/pdf',8,''),(608,599,'portal','','','','','','','도선칼럼','1',2,'','','',45,'항만의 경쟁력제고 방안에 대한 도선분야 개혁과제 내용을 읽고서 / 김인규 ','59','025_59.pdf','662b790f24ca5506e45182f5196b0e29.pdf','application/pdf',9,''),(609,599,'portal','','','','','','','건강','1',2,'','','',45,'최면요법 | 최면요법으로 마음의 평정을 / 편집실','64','025_64.pdf','ff7f415f9aab92c09fd6b18c34845ef1.pdf','application/pdf',10,''),(610,599,'portal','','','','','','','행사보고','1',2,'','','',45,'제18회 도선가족 친선 춘계 체육대회 개최 / 편집실','66','025_66.pdf','5d3159f3de89c9e63ea589f9b14c1859.pdf','application/pdf',11,''),(611,599,'portal','','','','','','','이슈(ISSUE)','1',2,'','','',45,'도선선료 현실화작업 / 협회사무국','68','025_68.pdf','321ee0f367e4da4cf2ea41efedcef353.pdf','application/pdf',12,''),(612,599,'portal','','','','','','','기고','1',2,'','','',45,'전등사ㆍ제부도로 떠나는 여름여행 / 편집실','70','025_70.pdf','8afca487c642e349707766e8c5944cd3.pdf','application/pdf',13,''),(613,599,'portal','','','','','','','문화마당','1',2,'','','',45,'시 | 슬픈바다 / 박인석','75','025_75.pdf','5fd2d8ebc2286d9fb388ed900fd7e159.pdf','application/pdf',14,''),(614,599,'portal','','','','','','','문화마당','1',2,'','','',45,'영화평 | 영화「타이타닉」조난 장면의 검증 / 長 誠治','76','025_76.pdf','9c82e12f72e919ff7b7c4957cdaf969b.pdf','application/pdf',15,''),(615,599,'portal','','','','','','','문화마당','1',2,'','','',45,'서평 | 산에는 꽃이 피네 / 편집실','80','025_80.pdf','aac7432341bc930ec744620bd0c2ad22.pdf','application/pdf',16,''),(616,599,'portal','','','','','','','문화마당','1',2,'','','',45,'추천서적 안내 / 편집실','82','025_82.pdf','af705a877b43c0f799983acb60f63643.pdf','application/pdf',17,''),(617,599,'portal','','','','','','','동정','1',2,'','','',45,'협회 및 지회 소식 / 편집실','83','98_여름_동정.pdf','3c2e61f117d72f593e1d1951232bd12f.pdf','application/pdf',18,''),(618,599,'portal','','','','','','','해외정보 소식','1',2,'','','',45,'제14차 IMPA 총회 / 편집실','92','025_92.pdf','568491fdf890d99415d797e04396ebff.pdf','application/pdf',19,''),(619,599,'portal','','','','','','','기타','1',2,'','','',45,'전국 도선구별 도선선 현황 / 편집실','93','025_93.pdf','11a74941835752424728c4be544bc0a7.pdf','application/pdf',20,''),(620,599,'portal','','','','','','','교양특집','1',2,'','','',45,'권두글 | 나의 아버지는 내게…','02','025_02.pdf','4b4702b3e6888c25c431739e3e6db761.pdf','application/pdf',21,''),(621,599,'portal','','','','','','','교양특집','1',2,'','','',45,'한자로읽는 세상|구화지문(口禍之門)','26','025_26.pdf','1424eef3b3d94a630599bc72c9dcaa68.pdf','application/pdf',22,''),(622,599,'portal','','','','','','','교양특집','1',2,'','','',45,'맵시내기|입는 양말, 숨쉬는 구두','63','025_63.pdf','86c457e5c7617bfdbb95de35f1ac4d45.pdf','application/pdf',23,''),(623,599,'portal','','','','','','','교양특집','1',2,'','','',45,'생활의 지혜 | 알뜰살림','69','025_69.pdf','682c298bfe8dcd7a88fae6206c7bd4aa.pdf','application/pdf',24,''),(624,599,'portal','','','','','','','교양특집','1',2,'','','',45,'영어한마디','69','025_69.pdf','0d4ab5bebe65fe572a8442261922a594.pdf','application/pdf',25,''),(625,599,'portal','','','','','','','교양특집','1',2,'','','',45,'원고모집','86','025_86.pdf','027c4ca38f1644618bb7412ab8b21ed1.pdf','application/pdf',26,''),(626,599,'portal','','','','','','','교양특집','1',2,'','','',45,'편집후기','94','025_94.pdf','d6bface7667c450efd63b5e8feaa2ceb.pdf','application/pdf',27,''),(627,599,'portal','','','','','','','교양특집','1',2,'','','',45,'각 지회 주소','95','025_95.pdf','236aea074e1eaf6716456ad7c025c3d0.pdf','application/pdf',28,''),(628,0,'portal','1999','01','21','신년호','한국도선사협회','D01','','1',1,'1999년 신년호 도선지(통권26호)','','magzine_tit_597.gif',44,'','','','','',1,''),(629,628,'portal','','','','','','','협회동정','1',2,'','','',44,'편집실','03','026_03.pdf','5064a9fa574e9e60dd6416477f8f449d.pdf','application/pdf',1,''),(630,628,'portal','','','','','','','권두언','1',2,'','','',44,'세계 정기선 해운업계의 전망과 우리의 대응 / 이윤수','10','026_10.pdf','0e70a63f2ca509c3c57ec50a0b0a81cd.pdf','application/pdf',2,''),(631,628,'portal','','','','','','','신년사','1',2,'','','',44,'존경하는 해양수산 가족 여러분 / 김선길','13','026_13.pdf','470642c7dc6a89ff2c200782c479d0b1.pdf','application/pdf',3,''),(632,628,'portal','','','','','','','신년사','1',2,'','','',44,'己卯年 새해, 해운항만역군으로서 최선을… / 신석흔','16','026_16.pdf','4b57681bc209c822a98f399e968d5016.pdf','application/pdf',4,''),(633,628,'portal','','','','','','','도선논단','1',2,'','','',44,'항만내에서의 조선과 해난사고 / 윤점동','18','026_18.pdf','9ee99cc7a6282caf7e0a495e591cc501.pdf','application/pdf',5,''),(634,628,'portal','','','','','','','도선논단','1',2,'','','',44,'도선수습생 전형시험에 실기시험 도입을 위한 고찰 / 구자윤','31','026_31.pdf','b90ec5800e8df6e1d76a71c9886791d9.pdf','application/pdf',6,''),(635,628,'portal','','','','','','','도선현장을 가다','1',2,'','','',44,'21세기 세계의 관문을 꿈꾸는 인천항과떠오르는 평택항을 찾아서 / 김병희','45','026_45.pdf','6c439fcc4c0ae0604b0b38aaf2fba614.pdf','application/pdf',7,''),(636,628,'portal','','','','','','','도선인터뷰','1',2,'','','',44,'인천항을 지키는 수문장, 인천항 남일현 도선사 / 김병희','61','026_61.pdf','22f2fa811447cbc3877346dd5f4fb2a0.pdf','application/pdf',8,''),(637,628,'portal','','','','','','','행사보고','1',2,'','','',44,'제14차 IMPA 총회 참가 보고서 / 신석흔','66','026_66.pdf','bbf9c95d00445a55769e43a6c1afcccf.pdf','application/pdf',9,''),(638,628,'portal','','','','','','','특별기고','1',2,'','','',44,'선교 절차 지침서(Bridge Procedures Guide)와 도선사(Pilots) / 우병구','78','026_78.pdf','1a99cf4382a902bb608219115402947e.pdf','application/pdf',10,''),(639,628,'portal','','','','','','','건강','1',2,'','','',44,'울적한 마음에 웃음이 보약 / 김종우','88','026_88.pdf','bac59910ddf48fce80c8480da6e5e422.pdf','application/pdf',11,''),(640,628,'portal','','','','','','','특별기고','1',2,'','','',44,'하늘과 바다가 하나가 되는 아름다운 섬 / 편집실','90','026_90.pdf','caf09f5d6a917147dff0791eb4a7c211.pdf','application/pdf',12,''),(641,628,'portal','','','','','','','문화마당','1',2,'','','',44,'한편의 시 | 그리워(Reverie) / R.H.휴손','93','026_93.pdf','21337ef4aa42da2bbd938994070c3425.pdf','application/pdf',13,''),(642,628,'portal','','','','','','','문화마당','1',2,'','','',44,'에세이 | 己卯年 토끼 이야기 / 김동정','94','026_94.pdf','a0f08240769fae901a5f773f4051c1ef.pdf','application/pdf',14,''),(643,628,'portal','','','','','','','문화마당','1',2,'','','',44,'추천서적 / 편집실','97','026_97.pdf','7c4fa843bba57fa7bad2aa65fb191dc3.pdf','application/pdf',15,''),(644,628,'portal','','','','','','','문화마당','1',2,'','','',44,'영화평 | <카케무사> 봉건을 뒤엎은 진짜 영웅 / 편집실','98','026_98.pdf','cf5c6e1cbf9b10744bccc560c17c3e0b.pdf','application/pdf',16,''),(645,628,'portal','','','','','','','동정','1',2,'','','',44,'협회 및 지회 소식 / 편집실','100','99_신년_동정.pdf','5901159bdc50f9f67fc8dcaee30b0f49.pdf','application/pdf',17,''),(646,628,'portal','','','','','','','News','1',2,'','','',44,'편집실','111','026_111.pdf','ffc70dd0904a78d557776cbc92849222.pdf','application/pdf',18,''),(647,628,'portal','','','','','','','해외정보 소식','1',2,'','','',44,'제14차 IMPA 총회 결의문(원문) / 편집실','116','026_116.pdf','1186b44e9243e7b4246bd5046b01e6b0.pdf','application/pdf',19,''),(648,628,'portal','','','','','','','교양특집','1',2,'','','',44,'권두글','02','026_02.pdf','1a90ed9735af45d7ce4af6d92b344165.pdf','application/pdf',20,''),(649,628,'portal','','','','','','','교양특집','1',2,'','','',44,'한자로 읽는 세상 | 柔能制剛 ','44','026_44.pdf','c99c35641d6822e4ab4bf220e1e6b4ee.pdf','application/pdf',22,''),(650,628,'portal','','','','','','','교양특집','1',2,'','','',44,'생활의 지혜 | 건강음주법','60','026_60.pdf','bce7954d928736d877561c26d00d0747.pdf','application/pdf',23,''),(651,628,'portal','','','','','','','교양특집','1',2,'','','',44,'영어한마디 | 잘못 알고 있는 영어','77','026_77.pdf','711ae8da91390fd8c3bc53a04757d225.pdf','application/pdf',24,''),(652,628,'portal','','','','','','','교양특집','1',2,'','','',44,'원고모집','87','026_87.pdf','3bdaeea5ace71469f15c42dba8c75585.pdf','application/pdf',25,''),(653,628,'portal','','','','','','','교양특집','1',2,'','','',44,'시사상식 | 세상을 재는 단위','109','026_109.pdf','df5dc115e8e52509db50229d39a6ea3c.pdf','application/pdf',26,''),(654,628,'portal','','','','','','','교양특집','1',2,'','','',44,'편집후기','118','026_118.pdf','c1fab2d1a9af076eccdc57b800e08b71.pdf','application/pdf',27,''),(655,628,'portal','','','','','','','교양특집','1',2,'','','',44,'각 지회 주소','119','026_119.pdf','18b67a3af6d6f59255e9b0dcb6cfb2b1.pdf','application/pdf',28,''),(656,0,'portal','1999','07','16','여름호','한국도선사협회','D01','','1',1,'1999년 여름호 도선지(통권27호)','','magzine_tit_572.gif',43,'','','','','',1,''),(657,656,'portal','','','','','','','협회동정','1',2,'','','',43,'편집실','02','027_02.pdf','0c68e36d1f7615db06c98bc4e0d9e27d.pdf','application/pdf',1,''),(658,656,'portal','','','','','','','권두언','1',2,'','','',43,'지식혁명과 21세기 해양강국 건설 / 김광수','10','027_10.pdf','4fc114aec36c3c8d3190fd829392ddd1.pdf','application/pdf',2,''),(659,656,'portal','','','','','','','도선논단','1',2,'','','',43,'도선중 해난사고에 관한 조치사항과 그 교훈 / 황병호','13','027_13.pdf','acbc25102614cd60e250444f33f4b38c.pdf','application/pdf',3,''),(660,656,'portal','','','','','','','도선논단','1',2,'','','',43,'운항과실의 중복처벌 이대로 좋은가 / 최정섭','26','027_26.pdf','893d4a16d1df84e3213a641290c6dee9.pdf','application/pdf',4,''),(661,656,'portal','','','','','','','도선현장을 가다','1',2,'','','',43,'1세기 세계적인 항만으로 성장하려는 우리나라 제일의 항구 부산항을 찾아서 / 김병희','39','027_39.pdf','f3f9ca8225b96d1d6c820a4d0c59d90f.pdf','application/pdf',5,''),(662,656,'portal','','','','','','','도선인터뷰','1',2,'','','',43,'안전도선 20년의 부산항최고의 베테랑, 이군보 도선사 /김병희','51','027_51.pdf','a4789947ee23dc1650c55eb3d96b9a4e.pdf','application/pdf',6,''),(663,656,'portal','','','','','','','행사보고','1',2,'','','',43,'제20회 도선가족 친선 춘계 체육대회 개최 / 편집실','56','027_56.pdf','aa0ebcc85f56791776aedf3848ed218c.pdf','application/pdf',7,''),(664,656,'portal','','','','','','','도선기고','1',2,'','','',43,'도선사 훈련(Pilot Training) /Capt. Hans Hederstrom','58','027_58.pdf','4c3f980628e014c082160eb00eb1c9a4.pdf','application/pdf',8,''),(665,656,'portal','','','','','','','특별기고','1',2,'','','',43,'GPS의 이용과 그 개발 전망 / 정태권','66','027_66.pdf','94c307a0df30e4b4958c63b027946bff.pdf','application/pdf',9,''),(666,656,'portal','','','','','','','문화마당','1',2,'','','',43,'한편의 시 [대양의 노래(Ocean)] / 바이런(Byron)','75','027_75.pdf','78b5a99266e943606d13b7875e46fc7e.pdf','application/pdf',10,''),(667,656,'portal','','','','','','','문화마당','1',2,'','','',43,'에세이 [착시현상] / 민병언','76','027_76.pdf','c9ff9e7ab5950c2d61696f66b5d09625.pdf','application/pdf',11,''),(668,656,'portal','','','','','','','문화마당','1',2,'','','',43,'테마여름 [선인들의 여름나기] / 김맑음','78','027_78.pdf','4580ba399e59c992a0d7a9afe32d8e53.pdf','application/pdf',12,''),(669,656,'portal','','','','','','','문화마당','1',2,'','','',43,'추천서적 / 편집실','80','027_80.pdf','e62a5f9cd0f1267b3d4ca16655754457.pdf','application/pdf',13,''),(670,656,'portal','','','','','','','동정','1',2,'','','',43,'협회 및 지회 소식 / 편집실','82','027_82.pdf','3ee951727492fb953a7ca674e2160e16.pdf','application/pdf',14,''),(671,656,'portal','','','','','','','법령코너','1',2,'','','',43,'도선관계 법령 개정ㆍ공포 / 협회 사무국','88','027_88.pdf','81ffda666cfa1c7a6aa586cab353508d.pdf','application/pdf',15,''),(672,656,'portal','','','','','','','News','1',2,'','','',43,'편집실','90','027_90.pdf','c6a22b3811d6f91e9a32dea2074cef48.pdf','application/pdf',16,''),(673,656,'portal','','','','','','','교양특집','1',2,'','','',43,'photo gallery','02','027_02.pdf','d46584980a9fc3614a9f16fa8723a191.pdf','application/pdf',17,''),(674,656,'portal','','','','','','','교양특집','1',2,'','','',43,'마음의창 | 자녀 망가뜨리기 10계명','55','027_55.pdf','162fd9bf1e9cf0bdbfbea4ff0530d7e1.pdf','application/pdf',18,''),(675,656,'portal','','','','','','','교양특집','1',2,'','','',43,'웃으며 삽시다 | 극장편','81','027_81.pdf','83fcb00c023b6cf9c80de31e79ef23c8.pdf','application/pdf',19,''),(676,656,'portal','','','','','','','교양특집','1',2,'','','',43,'바른말 우리말 | 잘못쓰고 있는 한자말','73','027_73.pdf','695da219a9fb044a21337ef47c13ee92.pdf','application/pdf',20,''),(677,656,'portal','','','','','','','교양특집','1',2,'','','',43,'원고모집','87','027_87.pdf','43d3ab6ae0891d0bc40857cc2bc5695c.pdf','application/pdf',21,''),(678,656,'portal','','','','','','','교양특집','1',2,'','','',43,'함께풀어봅시다 | 퍼즐','81','027_81.pdf','98b518c6c99afa96e0499e5b533161e7.pdf','application/pdf',22,''),(679,656,'portal','','','','','','','교양특집','1',2,'','','',43,'편집후기','96','027_96.pdf','c27f8c919c9f294f24461727fa5050db.pdf','application/pdf',23,''),(680,656,'portal','','','','','','','교양특집','1',2,'','','',43,'각 지회 주소','97','027_97.pdf','1c6d09b70598745744f2f3a7685c5e5e.pdf','application/pdf',24,''),(681,0,'portal','2000','01','19','신년호','한국도선사협회','D01','','1',1,'2000년 신년호 도선지(통권28호)','','magzine_tit_545.gif',42,'','','','','',1,''),(682,681,'portal','','','','','','','협회동정','1',2,'','','',42,'편집실','04','028_04.pdf','58f6a3cf31d2c991b8feb3021f347bae.pdf','application/pdf',1,''),(683,681,'portal','','','','','','','권두언','1',2,'','','',42,'21세기의 도선사 / 이정욱','10','028_10.pdf','8c909ac7c5d4db8f84d1f60ea3aea3e2.pdf','application/pdf',2,''),(684,681,'portal','','','','','','','신년사','1',2,'','','',42,'희망과 도전의 새 천년 / 신석흔','12','028_12.pdf','e32a0bd396b79024bcebbbdb7e776d2b.pdf','application/pdf',3,''),(685,681,'portal','','','','','','','취임사','1',2,'','','',42,'해양부국의 실현 / 이항규','14','028_14.pdf','5b118e37940a673c91b5a4561359f4ac.pdf','application/pdf',4,''),(686,681,'portal','','','','','','','도선논단','1',2,'','','',42,'BRM적 사고와 안전도선 / 박진수','18','028_18.pdf','a4508e8055bc99533e2a9bfab9d0a00d.pdf','application/pdf',5,''),(687,681,'portal','','','','','','','도선논단','1',2,'','','',42,'도선사의 징계와 일사부재리의 원칙 / 심근형','28','028_28.pdf','00940bcb190fe1b06662170b6f4ab0bc.pdf','application/pdf',6,''),(688,681,'portal','','','','','','','도선현장을 가다','1',2,'','','',42,'새천년을 맞아 아시아 환태평양의 물류중심항으로 발전하려는 울산항을 찾아서 / 김병희','37','028_37.pdf','fce6c379456c64cef0cea2265bc13b49.pdf','application/pdf',7,''),(689,681,'portal','','','','','','','도선인터뷰','1',2,'','','',42,'바다를 고마워할줄아는 해양인 울산항 김종삼 도선사 / 김병희','51','028_51.pdf','a0774e5b19642d5377e691b58d4a352a.pdf','application/pdf',8,''),(690,681,'portal','','','','','','','회의참가보고','1',2,'','','',42,'제12차 한ㆍ일 도선사 간친회를 다녀와서 / 김진곤','56','028_56.pdf','4110d547ee4af045fd888dce3d2972ca.pdf','application/pdf',9,''),(691,681,'portal','','','','','','','회의참가보고','1',2,'','','',42,'한국측 주제발표문 |한국 도선제도의 변화와 인천항 도선운영제도 / 김길성','61','028_61.pdf','665a3a51d5be8058b6e38bbac7e6d131.pdf','application/pdf',10,''),(692,681,'portal','','','','','','','기획','1',2,'','','',42,'뉴밀레니엄기획 | 해양 전문인력의 양성 / 신한원','68','028_68.pdf','99b9075b748b90ad210c56a1aca3f03e.pdf','application/pdf',11,''),(693,681,'portal','','','','','','','건강','1',2,'','','',42,'나의 건강 극복기 / 이강호 - 75','75','028_75.pdf','c29f566536798625cd07db90e48498bd.pdf','application/pdf',12,''),(694,681,'portal','','','','','','','특별기고','1',2,'','','',42,'산행을 하면서... / 장석훈','80','028_80.pdf','577b0b7d04e785e762c8d60ed70e19d9.pdf','application/pdf',13,''),(695,681,'portal','','','','','','','문화마당','1',2,'','','',42,'<바다의 도시이야기>를 읽고서 / 이현식','84','028_84.pdf','bb32db0d9dda8df54d6316e5906c1176.pdf','application/pdf',14,''),(696,681,'portal','','','','','','','동정','1',2,'','','',42,'협회 및 지회 소식 / 편집실','90','2000_신년_동정.pdf','0ef000c7cc2b140c1eeec9a1109935a7.pdf','application/pdf',15,''),(697,681,'portal','','','','','','','News','1',2,'','','',42,'편집실','107','028_107.pdf','ee69dc89321083fcb66bad1b5f460b17.pdf','application/pdf',16,''),(698,681,'portal','','','','','','','특별기고','1',2,'','','',42,'임의각의 3등분법 / 이봉희','96','028_96.pdf','1b3920f1ebdb68ee1c384dad5bb58cc1.pdf','application/pdf',17,''),(699,681,'portal','','','','','','','해외정보 소식','1',2,'','','',42,'제15차 IMPA 총회 개최 안내 / 편집실','101','028_101.pdf','bc28b9d3ff5181482ae9026207420bbb.pdf','application/pdf',18,''),(700,681,'portal','','','','','','','News','1',2,'','','',42,'편집실','102','028_102.pdf','9cbf088133b6d102c76a0748260f245e.pdf','application/pdf',19,''),(701,681,'portal','','','','','','','교양특집','1',2,'','','',42,'photo gallery | 사람과 사람 사이, 난 부탁했다','02','','','',20,''),(702,681,'portal','','','','','','','교양특집','1',2,'','','',42,'마음의창 | 포용력을 높이기 위한 제언','50','028_50.pdf','6eb39f3bb7aa215f834274337fb20e2b.pdf','application/pdf',21,''),(703,681,'portal','','','','','','','교양특집','1',2,'','','',42,'가슴에 남는 일화 하나 | 늘 최선을 다하는 마음으로','67','028_67.pdf','43d1470d5cf4a9eebde86f68656b7b17.pdf','application/pdf',22,''),(704,681,'portal','','','','','','','교양특집','1',2,'','','',42,'원고모집','95','028_95.pdf','c0f9249ef861b737e3245d1af1e63a4c.pdf','application/pdf',23,''),(705,681,'portal','','','','','','','교양특집','1',2,'','','',42,'호기심천국 | 아들ㆍ딸 지능은 누굴 닮나?','100','028_100.pdf','a1d0630e7e629f8335a10d5467692f32.pdf','application/pdf',24,''),(706,681,'portal','','','','','','','교양특집','1',2,'','','',42,'편집후기','106','028_106.pdf','ff21683dc711d8625ba2e4eae96c7211.pdf','application/pdf',25,''),(707,681,'portal','','','','','','','교양특집','1',2,'','','',42,'각 지회 주소','107','028_107.pdf','4b2352923c240d8e27f835811448657b.pdf','application/pdf',26,''),(708,0,'portal','2000','07','13','여름호','한국도선사협회','D01','','1',1,'2000년 여름호 도선지(통권29호)','','magzine_tit_524.gif',41,'','','','','',1,''),(709,708,'portal','','','','','','','협회동정','1',2,'','','',41,'편집실','04','029_04.pdf','7884a3216c0a1d8025d8faea7066777b.pdf','application/pdf',1,''),(710,708,'portal','','','','','','','권두언','1',2,'','','',41,'해기전승의 위기와 도선사의 역할 / 박용섭','10','029_10.pdf','3184f2d326b5a2e46661cac66e04fd89.pdf','application/pdf',2,''),(711,708,'portal','','','','','','','도선논단','1',2,'','','',41,'G/T 50,000톤(4000TEU)급 컨테이너선의 부산 김천항 입출항 안전성에 관한 연구 / 허용범','12','029_12.pdf','ba3cc6a18d1c45394c620f1fc0046260.pdf','application/pdf',3,''),(712,708,'portal','','','','','','','도선논단','1',2,'','','',41,'LNG선의 계류 안전성 평가 / 김세원','29','029_29.pdf','87f30042067e49bd74f0b9dcdcdd7c20.pdf','application/pdf',4,''),(713,708,'portal','','','','','','','도선현장을 가다','1',2,'','','',41,'황해권 중추항으로 발전하려는 서해안의 중심 항구,군산항을 찾아서 / 김병희','39','029_39.pdf','a826436bda4d1fa9b7ae80be12712225.pdf','application/pdf',5,''),(714,708,'portal','','','','','','','도선인터뷰','1',2,'','','',41,'군산항의 작은거인, 홍명희 도선사 / 김병희','51','029_51.pdf','bf9d3e8e3c546cc7a75582a82c1347ab.pdf','application/pdf',6,''),(715,708,'portal','','','','','','','회의참가보고','1',2,'','','',41,'제15차 국제도선사협회(IMPA) 총회 참가 보고서 / 이보언','55','029_55.pdf','83cf73df49ec8cf9f9c0aa75c3d4fcf3.pdf','application/pdf',7,''),(716,708,'portal','','','','','','','연구논문','1',2,'','','',41,'우리 나라 주요 항만 진입항만 혼잡도 평가와 인천항팔미도 주변의 출항항로 신설에 관하여 / 구자윤','62','029_62.pdf','8f5cee29afed34bae7a40e4a2af5019b.pdf','application/pdf',8,''),(717,708,'portal','','','','','','','도선칼럼','1',2,'','','',41,'윤교수가 권하는 도선 자세 / 윤순동','74','029_74.pdf','76aa664cb62da899c7775d07f272f068.pdf','application/pdf',9,''),(718,708,'portal','','','','','','','문화마당','1',2,'','','',41,'제15차 IMPA총회 참가 기행/하와이를 다녀와서 / 홍영자','78','029_78.pdf','49d392bb96843c05b2ccca02ea7c2191.pdf','application/pdf',10,''),(719,708,'portal','','','','','','','문화마당','1',2,'','','',41,'서신/감사하는 마음으로 장학금을 받으며... / 신경희 ','81','029_81.pdf','0f0cfd6e9a375efdb8d14e67b45dd8c0.pdf','application/pdf',11,''),(720,708,'portal','','','','','','','기고','1',2,'','','',41,'해도에 따른 도선과 신뢰의 원칙 / 김태규','83','029_83.pdf','52ca3bfba738d8159e4196b05169f57b.pdf','application/pdf',12,''),(721,708,'portal','','','','','','','기고','1',2,'','','',41,'파랑중 선박의 동력학 해석 / 이희상','85','029_85.pdf','d5adae000bba7c9678993cf014299a4c.pdf','application/pdf',13,''),(722,708,'portal','','','','','','','해외정보 소식','1',2,'','','',41,'제15차 IMPA총회 결의서 / 해무실','98','029_98.pdf','71e7bdcd21eb279812ac86e8cd09c090.pdf','application/pdf',14,''),(723,708,'portal','','','','','','','동정','1',2,'','','',41,'협회 및 지회 소식 / 편집실','102','029_102.pdf','c4ed2304ea57af627a22b3496be6c565.pdf','application/pdf',15,''),(724,708,'portal','','','','','','','News','1',2,'','','',41,'해운항만 관련 소식 / 편집실','107','029_107.pdf','40fd238e2bd6dbb7543eb144fed9ddb2.pdf','application/pdf',16,''),(725,708,'portal','','','','','','','교양특집','1',2,'','','',41,'photo gallery','02','029_02.pdf','a4262bc47684e3e8448d7fae11799145.pdf','application/pdf',17,''),(726,708,'portal','','','','','','','교양특집','1',2,'','','',41,'원고모집','106','029_106.pdf','da0cdb6a2ec8ee3dfa4e97a94c743fbb.pdf','application/pdf',18,''),(727,708,'portal','','','','','','','교양특집','1',2,'','','',41,'편집후기','110','029_110.pdf','0e929df101bacd61616fc97b7118ff41.pdf','application/pdf',19,''),(728,708,'portal','','','','','','','교양특집','1',2,'','','',41,'각 지회 주소','111','029_111.pdf','d070f7802213684a25fe30d2b467d68f.pdf','application/pdf',20,''),(729,0,'portal','2001','01','19','신년호','한국도선사협회','D01','','1',1,'2001년 신년호 도선지(통권30호) ','','magzine_tit_497.gif',40,'','','','','',1,''),(730,729,'portal','','','','','','','협회동정','1',2,'','','',40,'편집실','','','','',1,''),(731,729,'portal','','','','','','','권두언','1',2,'','','',40,'해기사에 있어 미래의 희망이자 표상인 도선사 / 정명선','10','030_10.pdf','070151416a572dfd7e87cb22c9237a9f.pdf','application/pdf',2,''),(732,729,'portal','','','','','','','신년사','1',2,'','','',40,'변혁과 개혁의 시대 / 신석흔','12','030_12.pdf','e80140626c0ab05e30780da50728ddb3.pdf','application/pdf',3,''),(733,729,'portal','','','','','','','신년사','1',2,'','','',40,'21세기는 해양의 시대 / 노무현','14','030_14.pdf','0a2bd742c94570ce701285057b8b04c9.pdf','application/pdf',4,''),(734,729,'portal','','','','','','','도선논단','1',2,'','','',40,'도선 및 선박조종 기술 해설(On Pilotage and Shiphandling Glossary) / 우병구','18','030_18.pdf','623414c92add246a1bde6d2e718d4180.pdf','application/pdf',5,''),(735,729,'portal','','','','','','','도선현장을 가다','1',2,'','','',40,'21세기 환동해권의 중심항구, 금강산을 향한 동해항을 찾아서 / 김병희','37','030_37.pdf','9cb2cc9bd718038daaf54e0ef1d9f28e.pdf','application/pdf',6,''),(736,729,'portal','','','','','','','도선인터뷰','1',2,'','','',40,'투철한 프로정신을 가지고 도선에 임하는 동해항 권강수 도선사 (pilot) / 김병희','49','030_49.pdf','9477d38716892f2962bccdd60b36ae30.pdf','application/pdf',7,''),(737,729,'portal','','','','','','','행사보고','1',2,'','','',40,'제23회 도선가족 친선 추계 체육대회 / 편집실','54','030_54.pdf','20218404b358bd1c5b78a1a704a8e4f1.pdf','application/pdf',8,''),(738,729,'portal','','','','','','','건강','1',2,'','','',40,'비타민 C, E 혈압강하에 효과 / 편집실','56','030_56.pdf','474634fd38bcdeb02c9bef22de9d8550.pdf','application/pdf',9,''),(739,729,'portal','','','','','','','도산사연수 교육','1',2,'','','',40,'2002년도 도선사 연수교육 워크샵 주제 발표문 / 해무실','57','030_57.pdf','f8fc67effb1c772e589466f6643e569f.pdf','application/pdf',10,''),(740,729,'portal','','','','','','','도산사연수 교육','1',2,'','','',40,'항내도선을 할 때에 간과하기 쉬운 몇 가지 주의사항 / 윤병원','58','030_58.pdf','dd85f7e1986ea7f8740c896a5b7a6eff.pdf','application/pdf',11,''),(741,729,'portal','','','','','','','도산사연수 교육','1',2,'','','',40,'4,300TEU급 대형 컨테이너선의 감천항 입항시의 조선 및 향후대책 / 김영주 ','63','030_63.pdf','61657e7ddc740beaf327b9bf39df2447.pdf','application/pdf',12,''),(742,729,'portal','','','','','','','도산사연수 교육','1',2,'','','',40,'대형선 접안시 기관사용 불능으로 인한 비상투묘 및 예선 사용에 관한 검토 / 박진수','67','030_67.pdf','4956b83e7dbd2917a0d57506e1371e9c.pdf','application/pdf',13,''),(743,729,'portal','','','','','','','도산사연수 교육','1',2,'','','',40,'포항항 원료부두 야간도선에 관한 것 / 박용배','72','030_72.pdf','f98888b6a09bd13a61d01de197475175.pdf','application/pdf',14,''),(744,729,'portal','','','','','','','기고','1',2,'','','',40,'다시 되새기는 자린고비의 정신 / 김동정','77','030_77.pdf','5ddbbe578c75e9eaab5078004518b3a5.pdf','application/pdf',15,''),(745,729,'portal','','','','','','','동정','1',2,'','','',40,'협회 및 지회 소식 / 편집실','80','2001_신년_동정.pdf','eed5d0dcde1e4bb1bc0c376bb0b67c02.pdf','application/pdf',16,''),(746,729,'portal','','','','','','','최신도선정보','1',2,'','','',40,'피로와 도선사 / 해무실','88','030_88.pdf','b4df2afa997b841fd001aa18a19cf219.pdf','application/pdf',17,''),(747,729,'portal','','','','','','','해외정보 소식','1',2,'','','',40,'2001년도 IMO 회의 일정 안내 / 편집실','92','030_92.pdf','5736cbbf473c8de31fade20d0b8a4b2f.pdf','application/pdf',18,''),(748,729,'portal','','','','','','','News','1',2,'','','',40,'편집실','93','030_93.pdf','5e7416a99080ca267dd0adc7185a0951.pdf','application/pdf',19,''),(749,729,'portal','','','','','','','교양특집','1',2,'','','',40,'photo gallery | 길...인간은... ','02','030_02.pdf','19f44bfee41836769b2010b95f2204ff.pdf','application/pdf',20,''),(750,729,'portal','','','','','','','교양특집','1',2,'','','',40,'배이야기 | 세계에서 가장 큰 배는?','76','030_76.pdf','90b7b8a91e4427197fc9d5ae8891223f.pdf','application/pdf',21,''),(751,729,'portal','','','','','','','교양특집','1',2,'','','',40,'원고모집','86','030_86.pdf','72f1b819a698c4f07c2c784d24c1ac0a.pdf','application/pdf',22,''),(752,729,'portal','','','','','','','교양특집','1',2,'','','',40,'의학상식 | 약을 차와함께 마시면...','87','030_87.pdf','ec364fe5fdb6f23c4aeecc7cf3407a81.pdf','application/pdf',23,''),(753,729,'portal','','','','','','','교양특집','1',2,'','','',40,'마음의 창 | 인생은...','87','030_87.pdf','32dd2b6262ddd56f8b6eba8dc22b29a3.pdf','application/pdf',24,''),(754,729,'portal','','','','','','','교양특집','1',2,'','','',40,'편집후기','100','030_100.pdf','353d7415caceddc3b1c5f19ce257e180.pdf','application/pdf',25,''),(755,729,'portal','','','','','','','교양특집','1',2,'','','',40,'각 지회 주소','101','030_101.pdf','590052091f7845fa0724ac3795fe5f9b.pdf','application/pdf',26,''),(756,0,'portal','2001','07','23','여름호','한국도선사협회','D01','','1',1,'2001년 여름호 도선지(통권31호) ','','magzine_tit_476.gif',39,'','','','','',1,''),(757,756,'portal','','','','','','','협회동정','1',2,'','','',39,'편집실','04','310400.pdf','5d33ad6302bd4e934bb8f9c897bd51ea.pdf','application/pdf',1,''),(758,756,'portal','','','','','','','권두언','1',2,'','','',39,'해양안전을 인도하는 도선사의 영원한 발전을 기원하며/ 전승규|한급선급회장','10','311000.pdf','699eab968698d703b585c63e3b851d9b.pdf','application/pdf',2,''),(759,756,'portal','','','','','','','취임사','1',2,'','','',39,'제7대 해양수산부장관 취임사 / 정우택|해양수산부장관','12','311500.pdf','827064d9a8233e96fe0c545737c8d4ff.pdf','application/pdf',3,''),(760,756,'portal','','','','','','','도선논단','1',2,'','','',39,'한국 도선사, 학습하는 엘리트여야 한다. / 김길수|한국해양대학교 교수','16','312001.pdf','0562512a8326d0bb99b1a4ecd203a06f.pdf','application/pdf',4,''),(761,756,'portal','','','','','','','도선논단','1',2,'','','',39,'항만의 위험관리 방법론에 관한 고찰 / 황병호|한국해양수산연수원 교수','21','312002.pdf','391b30fe7a38a8341ad8a2e3d0f90927.pdf','application/pdf',5,''),(762,756,'portal','','','','','','','해외정보 소식','1',2,'','','',39,'IMO 항행계획 지침 / 해무실','31','312500.pdf','b96d7f50838aafabe84d4dde37b9d22a.pdf','application/pdf',6,''),(763,756,'portal','','','','','','','도선현장을 가다','1',2,'','','',39,'고요한아침의 나라 대한민국, 그 아침을 깨우는 포항, 더 큰 희망을 향해 나아가는 포항항을 찾아서 / 김명석','39','313000.pdf','ee8ffcacbba6069f10ca681c5d0bff07.pdf','application/pdf',7,''),(764,756,'portal','','','','','','','도선인터뷰','1',2,'','','',39,'잔잔한 미소와 겸손한 마음을 소유한 도선 프로페셔널 포항항 부성치 도선사(Pilot) / 김명석','51','313500.pdf','59fc7ad075a070bbab090cc2bfd575ac.pdf','application/pdf',8,''),(765,756,'portal','','','','','','','건강','1',2,'','','',39,'좋은 수면을 위한 제안 / 편집실','55','314000.pdf','3561b483be8bb423d1560f2f4149ab79.pdf','application/pdf',9,''),(766,756,'portal','','','','','','','행사보고','1',2,'','','',39,'제24회 춘계 도선가족 친선 체육대회 / 편집실','56','314500.pdf','7901d213dae0796a2170f5a240058dde.pdf','application/pdf',10,''),(767,756,'portal','','','','','','','도선칼럼','1',2,'','','',39,'도선사의 활동과 안전 / 김상진|협회 前 고문','58','315000.pdf','75b8df9b3f3b05baccee5a4c216c5f7e.pdf','application/pdf',11,''),(768,756,'portal','','','','','','','문화마당','1',2,'','','',39,'\"멋을 아는 사람 여기 모이세요\" / 편집실','62','315500.pdf','91dff308e871af3821311a91a079e368.pdf','application/pdf',12,''),(769,756,'portal','','','','','','','동정','1',2,'','','',39,'협회 및 지회 소식 / 편집실','64','2001_여름_동정.pdf','8aa8a42c6b872eb44204c42e37a71011.pdf','application/pdf',13,''),(770,756,'portal','','','','','','','기고','1',2,'','','',39,'삼복(三伏)과 백중놀이 / 강오식|자유기고가','71','316500.pdf','b0642e68b72263a66dbd70cd7252a27f.pdf','application/pdf',14,''),(771,756,'portal','','','','','','','연재기획','1',2,'','','',39,'대만 인수법 및 인수인관리규정 / 해무실|각국의 도선제도 소개','75','','','',15,''),(772,756,'portal','','','','','','','News','1',2,'','','',39,'편집실','87','317500.pdf','d5c81fde4945b7eeaa694c5daa68fa3f.pdf','application/pdf',16,''),(773,756,'portal','','','','','','','교양특집','1',2,'','','',39,'Photo gallery','0','310200.pdf','70ba39f4f25765607bac5194fdea5cd6.pdf','application/pdf',17,''),(774,756,'portal','','','','','','','교양특집','1',2,'','','',39,'Cover Story','0','310100.pdf','320be3df381a4bc0398b85cb11c0ba35.pdf','application/pdf',18,''),(775,756,'portal','','','','','','','교양특집','1',2,'','','',39,'편집후기','0','319500.pdf','d3a26eb2f054e889f8ef412f406d635a.pdf','application/pdf',19,''),(776,756,'portal','','','','','','','교양특집','1',2,'','','',39,'협회 홈페이지 개설','0','310000.pdf','1d3ff77333f3f1329edf5fb90c2a4f79.pdf','application/pdf',20,''),(777,0,'portal','2002','01','18','신년호','한국도선사협회','D01','','1',1,'2002년 신년호 도선지(통권32호)','','magzine_tit_453.gif',38,'','','','','',1,''),(778,777,'portal','','','','','','','협회동정','1',2,'','','',38,'편집실','04','320400.pdf','e702fc04f9018e3e387d1666a91ebcc8.pdf','application/pdf',1,''),(779,777,'portal','','','','','','','권두언','1',2,'','','',38,'21세기, 도선사협회의 새로운 역할을 기대하며... / 이갑숙|중앙해양안전심판원장','10','321000.pdf','f5cef18afdc4c0b7384c33521eceff76.pdf','application/pdf',2,''),(780,777,'portal','','','','','','','신년사','1',2,'','','',38,'선진 해운ㆍ항만 문화의 창달 / 신석흔|한국도선사협회 회장','12','321501.pdf','e2cd576c231ee779b879eae1f4418e26.pdf','application/pdf',3,''),(781,777,'portal','','','','','','','신년사','1',2,'','','',38,'\"바다경영의 새틀을 짜야 한다\" / 유삼남|해양수산부 장관','14','321502.pdf','95a327e65ad4caaa509d3118d53eee35.pdf','application/pdf',4,''),(782,777,'portal','','','','','','','도선논단','1',2,'','','',38,'목포구 부근의 신항로 개설 및 항로표지 재배치에 관한 연구 / 김세원|한국해양대학교 교수','18','322001.pdf','62fd35b012cbc23271e801d472472fd7.pdf','application/pdf',5,''),(783,777,'portal','','','','','','','도선논단','1',2,'','','',38,'기상 정보관리 / 이동섭|한국해양수산연수원 교수','29','322002.pdf','d0a83f697221c8eab76d4754a12e3d31.pdf','application/pdf',6,''),(784,777,'portal','','','','','','','도선현장을 가다','1',2,'','','',38,'2010년 세계박람회 개최 후보지 여수, 천혜의 아름다움을 간직한 여수항을 찾아서 / 김명석','50','322500.pdf','23ea9a562a0c57865f8404c51b18b1e6.pdf','application/pdf',7,''),(785,777,'portal','','','','','','','도선인터뷰','1',2,'','','',38,'안전도선을 지휘하는 김동원 도선사(PILOT)와 함께 / 김명석','59','323000.pdf','47679074d2297be3daf9f57a05c4800e.pdf','application/pdf',8,''),(786,777,'portal','','','','','','','건강','1',2,'','','',38,'2002 상반기 건강캘린더 / 편집실','63','324000.pdf','cd297c461d465b37c9f06dc84eb183d8.pdf','application/pdf',9,''),(787,777,'portal','','','','','','','행사보고','1',2,'','','',38,'제25회 추계 도선가족 친선 체육대회 / 편집실','64','324500.pdf','a6894bc455808fb56eb34afe17f07cc7.pdf','application/pdf',10,''),(788,777,'portal','','','','','','','문화마당','1',2,'','','',38,'\"우리문화 BEST10\" / 편집실','66','325500.pdf','2ba8a226ed970ef8231cb29d658fb85a.pdf','application/pdf',11,''),(789,777,'portal','','','','','','','해외정보 소식','1',2,'','','',38,'2002년도 IMO회의 일정 안내 / 편집실','70','325000.pdf','64a8fa78eafe1595b2c1f80acbba94e5.pdf','application/pdf',12,''),(790,777,'portal','','','','','','','특별기고','1',2,'','','',38,'친절한 대화와 안전도선 / 김홍수|여수항 도선사','71','326501.pdf','ecb53d9797d4046505d905ededfbf628.pdf','application/pdf',13,''),(791,777,'portal','','','','','','','특별기고','1',2,'','','',38,'求得不苦 / 이승기|마산항 도선수습생','73','326502.pdf','74e21a043802389fe562767c5a67e1af.pdf','application/pdf',14,''),(792,777,'portal','','','','','','','특별기고','1',2,'','','',38,'가족-그 지난 이야기 / 조태호|인천항 도선수습생','76','326503.pdf','ff62f3a2cfd63142a9a6f8c5ceabcff0.pdf','application/pdf',15,''),(793,777,'portal','','','','','','','특별기고','1',2,'','','',38,'금 110만원의 보람 / 윤영원|명예 도선사','80','326504.pdf','da53522637dacdd8003a77aa7f9ff01d.pdf','application/pdf',16,''),(794,777,'portal','','','','','','','특별기고','1',2,'','','',38,'협회 및 지회 소식 / 편집실','83','326504.pdf','ed097a6d22de62d4e79fc7820526ad14.pdf','application/pdf',17,''),(795,777,'portal','','','','','','','News','1',2,'','','',38,'편집실','87','327500.pdf','e3f6d3503f3882f2b03d11e6f0e6394f.pdf','application/pdf',18,''),(796,777,'portal','','','','','','','교양특집','1',2,'','','',38,'Photo gallery','','320200.pdf','b744ec25b2fcd8e62992e8433f978e07.pdf','application/pdf',19,''),(797,777,'portal','','','','','','','교양특집','1',2,'','','',38,'Cover Story','','329000.pdf','ab1a365141455831c1cd4113f4cf41e4.pdf','application/pdf',20,''),(798,777,'portal','','','','','','','교양특집','1',2,'','','',38,'편집후기','','329500.pdf','408cf45150814b88297326e0f2df98d8.pdf','application/pdf',21,''),(799,777,'portal','','','','','','','교양특집','1',2,'','','',38,'협회 홈페이지 안내','','320000.pdf','4c48e825c34dcb813826d7d1dededa65.pdf','application/pdf',22,''),(800,0,'portal','2002','07','24','여름호','한국도선사협회','D01','','1',1,'2002년 여름호 도선지(통권33호) ','','magzine_tit_435.gif',37,'','','','','',1,''),(801,800,'portal','','','','','','','협회동정','1',2,'','','',37,'편집실','04','330400.pdf','a3431297cdd51a2e3599aab8860e63ca.pdf','application/pdf',1,''),(802,800,'portal','','','','','','','권두언','1',2,'','','',37,'우리나라 해운산업 발전과 해기전승의 당위성 / 현영원| 한국선주협회 회장','10','331000.pdf','3dec9d4390c424d8a96f4d46b08376e4.pdf','application/pdf',2,''),(803,800,'portal','','','','','','','취임사','1',2,'','','',37,'제9대 해양수산부장관 취임사 / 김호식|해양수산부 장관','12','331500.pdf','454dda08cd12ebfb9e26a8d0b18a20b7.pdf','application/pdf',3,''),(804,800,'portal','','','','','','','도선논단','1',2,'','','',37,'도선사의 법적책임과 보호 / 김인형|목포해양대학교교수','16','332001.pdf','3b8b728a1b1aac1a6e15a889ce8dc9a1.pdf','application/pdf',4,''),(805,800,'portal','','','','','','','도선논단','1',2,'','','',37,'도선 및 조정 관련 영어의 미국식 발음법에 관하여 / 우병국|한국해양수산연구원 교수','34','332002.pdf','8fdf07af8154202587e520704bc639e0.pdf','application/pdf',5,''),(806,800,'portal','','','','','','','도선현장을 가다','1',2,'','','',37,'가보고 싶은 천혜의 항구도시 마산, 천21세기 환태평양시대의 주역 마산항을 찾아서 / 김명석','47','332500.pdf','59b72d986c9e4ccb9c431ebf716295c6.pdf','application/pdf',6,''),(807,800,'portal','','','','','','','도선인터뷰','1',2,'','','',37,'아름다운 마산항에서 안전도선을 일구는 박춘길 도선사(PILOT)와 함께 / 김명석','57','333000.pdf','a599ea4e696e19684de381e8a0a99248.pdf','application/pdf',7,''),(808,800,'portal','','','','','','','주제발표문','1',2,'','','',37,'제13차 한일 간친회 한국측 주제발표문 / 편집실 - 61','61','333500.pdf','d1eddb0998bf561aa30d80598bab30e6.pdf','application/pdf',8,''),(809,800,'portal','','','','','','','문화마당','1',2,'','','',37,'한국의 세계유산을 찾아서... / 편집실','68','334000.pdf','a3f34a3bb5253f613ded993ea30652e1.pdf','application/pdf',9,''),(810,800,'portal','','','','','','','판례소개','1',2,'','','',37,'펜실베니아호 사건 / 박영선|중앙해양안전심판원 조사관','70','334500.pdf','ca1ef7563ff4ae1aab65dcf9553e399c.pdf','application/pdf',10,''),(811,800,'portal','','','','','','','국내정보','1',2,'','','',37,'한국의 해도측지계 변경추진 / 해무실','78','335000.pdf','9f984274248c69022f0411352f576af6.pdf','application/pdf',11,''),(812,800,'portal','','','','','','','국외정보','1',2,'','','',37,'도선의 경쟁에 대한 IMPA의 입장 / 해무실','82','335500.pdf','a444c4607c62ed612b644aa15c42993d.pdf','application/pdf',12,''),(813,800,'portal','','','','','','','특별기고','1',2,'','','',37,'줄잡이 업무제도의 개선이 시급하다 / 김인규|부산지회 상무','84','336000.pdf','343604093458f6068ddacb5a1286caaf.pdf','application/pdf',13,''),(814,800,'portal','','','','','','','Pilot Now','1',2,'','','',37,'협회 및 지회, 회원소식 / 편집실','89','2002_여름_나우.pdf','8228a52483e0d44831753fa365508e2b.pdf','application/pdf',14,''),(815,800,'portal','','','','','','','News','1',2,'','','',37,'편집실','96','337500.pdf','53437512cd6d3494227bde677aad0a4d.pdf','application/pdf',15,''),(816,800,'portal','','','','','','','교양특집','1',2,'','','',37,'Photo gallery','','330200.pdf','1bdd95e5159a7a4e917cca11a9bac44b.pdf','application/pdf',16,''),(817,800,'portal','','','','','','','교양특집','1',2,'','','',37,'편집후기','','330100.pdf','f391a425e66468050e89841ac65a5b06.pdf','application/pdf',17,''),(818,0,'portal','2003','01','20','신년호','한국도선사협회','D01','','1',1,'2003년 신년호 도선지(통권34호)','','magzine_tit_413.gif',36,'','','','','',1,''),(819,818,'portal','','','','','','','협회동정','1',2,'','','',36,'편집실','04','340400.pdf','9b60aa97710ef335d09909335b1fa69e.pdf','application/pdf',1,''),(820,818,'portal','','','','','','','권두언','1',2,'','','',36,'후배 도선사의 푸념 / 유명윤|한국해양수산연구원 원장','10','341000.pdf','1c779fcbf5d9b92064236ed2f81ea515.pdf','application/pdf',2,''),(821,818,'portal','','','','','','','신년사','1',2,'','','',36,'전환기적 시기와 우리의 선택 / 신석흔|한국도선사협회 회장','12','341500.pdf','538f335dc699b4a472bd4522c06e13aa.pdf','application/pdf',3,''),(822,818,'portal','','','','','','','신년사','1',2,'','','',36,'신년사 / 김호식|해양수산부 장관','14','341600.pdf','904b367da94a99a6a1e00f59bac2c46f.pdf','application/pdf',4,''),(823,818,'portal','','','','','','','발표자료','1',2,'','','',36,'이안작업중 돌핀접촉 및 화물유출 사고 / 임연희|대산항 도선사','18','342000.pdf','295f7fefdc05154c75c6c4e8fea63126.pdf','application/pdf',5,''),(824,818,'portal','','','','','','','발표자료','1',2,'','','',36,'항내 또는 복잡수로에서의 무중 Radar 항법 / 박재석|부산항 도선사','23','342100.pdf','6da421c1e1517766f59913b41ec996e7.pdf','application/pdf',6,''),(825,818,'portal','','','','','','','도선현장을 가다','1',2,'','','',36,'새 하늘! 새 땅! 새 바다! 인천 21세기 동북아 물류의 중심, 인천항을 찾아서 / 김명석','33','342500.pdf','cdb636448de460664d706dc9d40b0c51.pdf','application/pdf',7,''),(826,818,'portal','','','','','','','도선인터뷰','1',2,'','','',36,'동북아시아의 새로운 물류흐름을 창조해 가는 인천항에서 김길성 도선사와 함께 / 김명석','41','343000.pdf','020b52b84cfb6925b4b27b26a9f4653b.pdf','application/pdf',8,''),(827,818,'portal','','','','','','','참가보고','1',2,'','','',36,'제16차 IMPA총회 참가보고서 / 옥태영','46','343500.pdf','0996edfb3a0fb3d71bb54704a7ba84ae.pdf','application/pdf',9,''),(828,818,'portal','','','','','','','특별기고','1',2,'','','',36,'도선사의 자질 / 최학영 명예 도선사','56','344000.pdf','93106efe744a36893b5d8a979b6375c7.pdf','application/pdf',10,''),(829,818,'portal','','','','','','','특별기고','1',2,'','','',36,'은퇴의 미학 / 송용무 명예 도선사','65','344100.pdf','16aa9992088d5461a6e78f00c0f582e1.pdf','application/pdf',11,''),(830,818,'portal','','','','','','','특별기고','1',2,'','','',36,'외래어 찾아보기 / 이강호 울산항 도선사','68','344200.pdf','b53ca446a5b5bd3b8990e72d77c55e85.pdf','application/pdf',12,''),(831,818,'portal','','','','','','','특별기고','1',2,'','','',36,'도선사의 지위와 자세 / 김준웅 인천항 도선사','70','344300.pdf','03f0ce8e895f3b38b6aa295de4a37efe.pdf','application/pdf',13,''),(832,818,'portal','','','','','','','특별기고','1',2,'','','',36,'Farewell my Charlie! / 김수룡 부산항 도선수습생','72','344400.pdf','c5625b4bb76952c491aafa6a7ef929d9.pdf','application/pdf',14,''),(833,818,'portal','','','','','','','문화마당','1',2,'','','',36,'암 조기발견 과신 말라! / 편집실','76','','','',15,''),(834,818,'portal','','','','','','','해외정보 소식','1',2,'','','',36,'제16차 IMPA총회 결의서 / 해무실','78','346000.pdf','5cc32d695fb6b9fdff33bea64964799b.pdf','application/pdf',16,''),(835,818,'portal','','','','','','','해외정보 소식','1',2,'','','',36,'제2003년도 IMO회의 일정 / 해무실','82','346100.pdf','dd250694092ca9c65e3b9618f1269af3.pdf','application/pdf',17,''),(836,818,'portal','','','','','','','Pilot Now','1',2,'','','',36,'협회 및 지회, 회원 소식 / 편집실','83','2003_신년_나우.pdf','befbf16856d579c8d119c3ee1b0022d0.pdf','application/pdf',18,''),(837,818,'portal','','','','','','','News','1',2,'','','',36,'편집실','90','347500.pdf','623675786c2a10656947f59b76ddefbc.pdf','application/pdf',19,''),(838,818,'portal','','','','','','','교양특집','1',2,'','','',36,'Photo gallery','','340200.pdf','429200b469386e1381efba0b7f5336f7.pdf','application/pdf',20,''),(839,818,'portal','','','','','','','교양특집','1',2,'','','',36,'편집후기','','340100.pdf','85846d27d551473abc126845e3235d85.pdf','application/pdf',21,''),(840,0,'portal','2003','07','22','여름호','한국도선사협회','D01','','1',1,'2003년 여름호 도선지(통권35호)','','magzine_tit_393.gif',35,'','','','','',1,''),(841,840,'portal','','','','','','','협회동정','1',2,'','','',35,'편집실','04','350500.pdf','bca1addfdc68e6240956b6e8de6c6d48.pdf','application/pdf',1,''),(842,840,'portal','','','','','','','권두언','1',2,'','','',35,'해기사회의 지도자적 위치에서 역할을! / 박찬조|한국해기사협회 회장','10','351000.pdf','57722fa0b23f0461c2cf9064a8dd280f.pdf','application/pdf',2,''),(843,840,'portal','','','','','','','도선논단','1',2,'','','',35,'외력에 의한 선박의 압류량에 대한 연구 / 윤종회|한국해양대학교 교수','12','352001.pdf','a137d471db0647bd027a876cdf6982a9.pdf','application/pdf',3,''),(844,840,'portal','','','','','','','도선논단','1',2,'','','',35,'TSS항로에서의 니어미스 및 신침로거리 변침조선법 / 우병구|한국해양수산연수원 교수 ','22','352002.pdf','4f6c6acaf80cf470b745c83e3c23f7fa.pdf','application/pdf',4,''),(845,840,'portal','','','','','','','도선현장을 가다','1',2,'','','',35,'동북아 경제중심국가 건설을 선도하는 부산항을 찾아서 / 김명석','37','352500.pdf','00ce8767201a890323eb79e6a8c3e21e.pdf','application/pdf',5,''),(846,840,'portal','','','','','','','도선인터뷰','1',2,'','','',35,'정직과 성실한 삶, 환한미소의 부산항 문경헌 도선사와 함께 / 김명석','45','353000.pdf','0568f4487888aee91ab80edef40698b3.pdf','application/pdf',6,''),(847,840,'portal','','','','','','','특별기고','1',2,'','','',35,'해협 위의 하늘 / 류종열|인천항 도선사','49','353501.pdf','ed18cb436aa38b6fa57d52916043ae46.pdf','application/pdf',7,''),(848,840,'portal','','','','','','','특별기고','1',2,'','','',35,'나무를 알면 삶이 즐겁다 / 김동정|동화작가','52','353502.pdf','58b0836dc80347d0201a898c8f5b7813.pdf','application/pdf',8,''),(849,840,'portal','','','','','','','판례소개','1',2,'','','',35,'항법판례 이야기 / 허용범|중앙해양안전심판원 심판관','55','354001.pdf','9bf17232056547bacd8d831d5e3b2b93.pdf','application/pdf',9,''),(850,840,'portal','','','','','','','판례소개','1',2,'','','',35,'오리건호 사건 / 박영선|중앙해양안전심판원 조사관','62','354002.pdf','0b0543f051a02d6ceed7804f9dfe1b8b.pdf','application/pdf',10,''),(851,840,'portal','','','','','','','건강','1',2,'','','',35,'걷기가 몸에 좋은 이유 / 편집실','74','354500.pdf','96f430062c3cfd37818557b8b77e4866.pdf','application/pdf',11,''),(852,840,'portal','','','','','','','해외정보 소개','1',2,'','','',35,'도선사의 훈련, 자격 및 운영절차에 관한 권고(안) / 해무실','76','355000.pdf','98a67d2cae5b9db7e4e8152ad8fc7f9e.pdf','application/pdf',12,''),(853,840,'portal','','','','','','','의학상식','1',2,'','','',35,'제2003년도 IMO회의 일정 / 해무실','86','355500.pdf','6fbcdf748af61d0bc6d286bd85fd48a7.pdf','application/pdf',13,''),(854,840,'portal','','','','','','','Pilot Now','1',2,'','','',35,'협회 및 지회, 회원 소식 / 편집실','88','2003_여름_나우.pdf','3f422e6802033e25c281a6e1cc3c9017.pdf','application/pdf',14,''),(855,840,'portal','','','','','','','News','1',2,'','','',35,'편집실','94','356500.pdf','a701f6c76ae54a03c70016781b0a57a2.pdf','application/pdf',15,''),(856,840,'portal','','','','','','','교양특집','1',2,'','','',35,'Passage Plan','','350000.pdf','1e5868a98c374b87a3860dff8dcede51.pdf','application/pdf',16,''),(857,840,'portal','','','','','','','교양특집','1',2,'','','',35,'편집후기','','357000.pdf','87bbe5a836b2d29cb7fcb0293cf2acda.pdf','application/pdf',17,''),(858,840,'portal','','','','','','','교양특집','1',2,'','','',35,'각 지회 주소','','357500.pdf','d5247c00763bffa1f23681024af93a83.pdf','application/pdf',18,''),(859,0,'portal','2004','01','30','신년호','한국도선사협회','D01','','1',1,'2004년 신년호 도선지(통권36호)','','magzine_tit_372.gif',34,'','','','','',1,''),(860,859,'portal','','','','','','','협회동정','1',2,'','','',34,'편집실','04','360500.pdf','d56f99397940f58d182384ac7c796308.pdf','application/pdf',1,''),(861,859,'portal','','','','','','','권두언','1',2,'','','',34,'홍용찬|한국국제해운대리점협회 회장','10','361000.pdf','d63277131e8becabfbe7e2841fe058c0.pdf','application/pdf',2,''),(862,859,'portal','','','','','','','신년사','1',2,'','','',34,'이경화|한국도선사협회 회장','12','361501.pdf','528792c349c8d1713fff1707f03a44f1.pdf','application/pdf',3,''),(863,859,'portal','','','','','','','신년사','1',2,'','','',34,'장승우|해양수산부 장관','14','361502.pdf','25583d425244307b5b48d1bbca612828.pdf','application/pdf',4,''),(864,859,'portal','','','','','','','도선논단','1',2,'','','',34,'항로표지의 설치 타당성 검도 / 윤병원|평택항 도선사','18','362001.pdf','81fd36f3a86c7221f475ddc055d5ce21.pdf','application/pdf',5,''),(865,859,'portal','','','','','','','도선논단','1',2,'','','',34,'울산항 인터넷 도선관리 System / 나태채|울산항 도선사','23','362002.pdf','1d6c8fc48b4202958d75a165b1563630.pdf','application/pdf',6,''),(866,859,'portal','','','','','','','도선현장을 가다','1',2,'','','',34,'동북아 종합물류중심항만으로 성장하는 중화학공업의 최대 메카,울산항을 찾아서 / 김명석','31','362500.pdf','8d9a6c127c96f80ca91394a8e2572469.pdf','application/pdf',7,''),(867,859,'portal','','','','','','','도선인터뷰','1',2,'','','',34,'우리나라 최대의 공업항! 울산항에서 손영록 도선사(pilot)와 함께','39','363000.pdf','a77263a599e2655bca759a6e21cf2d8a.pdf','application/pdf',8,''),(868,859,'portal','','','','','','','해외정보 소식','1',2,'','','',34,'2004년도 IMO회의 일정 안내 / 해무실','43','363500.pdf','709d2c422f9017370c5ae1ff9d18c4eb.pdf','application/pdf',9,''),(869,859,'portal','','','','','','','건강','1',2,'','','',34,'스트레스의 노화 / 김영옥|자생생명공학연구소 실장','44','364000.pdf','34672641b68e8c220c99250f7a13bc93.pdf','application/pdf',10,''),(870,859,'portal','','','','','','','참가보고','1',2,'','','',34,'제14차 한일 도선사 간친회 참가보고서 / 박성기|부산항 도선사 ','46','364500.pdf','caca683627bf6a94213979e01bfb7adf.pdf','application/pdf',11,''),(871,859,'portal','','','','','','','발표자료','1',2,'','','',34,'한국 도선사 선발제도의 현황 및 문제점 / 조수린|인천항 도선사','52','365001.pdf','a3c9e124fdf74ba02dff3c59c130e7bc.pdf','application/pdf',12,''),(872,859,'portal','','','','','','','발표자료','1',2,'','','',34,'도선업무에 있어서 해난방지대책에 대하여 / 우치다 나오유키|일본 이세만 도선사회 회장','58','365002.pdf','8720417e1cd40c0e29c52c2cdfd3ab9b.pdf','application/pdf',13,''),(873,859,'portal','','','','','','','연수교육','1',2,'','','',34,'법률강좌-해양사고에 대한 도선사의 책임과 대응방안  / 김현|법무법인 세창 변호사','67','365501.pdf','422c247ef2670a96dd331d7aef1488bc.pdf','application/pdf',14,''),(874,859,'portal','','','','','','','연수교육','1',2,'','','',34,'주제발표-당진항로 광폭선의 안전통항 검토 / 박현화|대산항 도선사','81','365502.pdf','aef5610c277114306ada69d1b4160825.pdf','application/pdf',15,''),(875,859,'portal','','','','','','','Pilot Now','1',2,'','','',34,'협회 및 지회, 회원 소식 / 편집실','81','2004_신년_나우.pdf','b66ee242d52158291b1fc7234739eecf.pdf','application/pdf',16,''),(876,859,'portal','','','','','','','News','1',2,'','','',34,'편집실','97','366500.pdf','2fad85de97d05894bfed2c65a4d78841.pdf','application/pdf',17,''),(877,859,'portal','','','','','','','교양특집','1',2,'','','',34,'Photo Gallery','','360001.pdf','74db5893305096ced56313233cd3772b.pdf','application/pdf',18,''),(878,859,'portal','','','','','','','교양특집','1',2,'','','',34,'편집후기','','367000.pdf','c6fb68d40c5a4ad36b6aa9a138616ace.pdf','application/pdf',19,''),(879,859,'portal','','','','','','','교양특집','1',2,'','','',34,'각 지회 주소','','367500.pdf','1379c01249197d98e9d2377ce93a2a6b.pdf','application/pdf',20,''),(880,0,'portal','2004','07','24','여름호','한국도선사협회','D01','','1',1,'2004년 여름호 도선지(통권37호)','','magzine_tit_355.gif',33,'','','','','',1,''),(881,880,'portal','','','','','','','협회동정','1',2,'','','',33,'편집실','04','370500.pdf','279789aaadc37fdcd97440612fbd34c6.pdf','application/pdf',1,''),(882,880,'portal','','','','','','','권두언','1',2,'','','',33,'해상안전과 항만서비스 혁신의 선도적 역할을 기대하며 /정이기 이사장','10','370100.pdf','744f5e3ef95b44f21895858399a7cefa.pdf','application/pdf',2,''),(883,880,'portal','','','','','','','도선논단','1',2,'','','',33,'선박교통의 관제실태와 VTS운영 개선방안 / 윤 병 원 도선사','12','372001.pdf','c8de8a3f35dd7211747e6a3b08cb291c.pdf','application/pdf',3,''),(884,880,'portal','','','','','','','도선논단','1',2,'','','',33,'우리나라 해양오염방제시스템에 대한 고찰 / 윤 종 휘 교수','46','372002.pdf','709799d0d8bb538293f68bb623d91510.pdf','application/pdf',4,''),(885,880,'portal','','','','','','','도선현장을 가다','1',2,'','','',33,'서해안시대의 물류중심도시로 거듭나고 있는 대산항을 찾아서 /김명석','57','372500.pdf','162b4af020c57e3f645b4bfaf55a8ea5.pdf','application/pdf',5,''),(886,880,'portal','','','','','','','도선인터뷰','1',2,'','','',33,'서해안시대를 맞이하여 대산항에서 장현훈 도선사와 함께 /김명석','65','373000.pdf','5072a0be7c7be61029009a9cabd78cea.pdf','application/pdf',6,''),(887,880,'portal','','','','','','','건강','1',2,'','','',33,'퇴행성관절염; 노화와 관절 / 김 영 옥 실장','70','374500.pdf','da15d50136353bb4b184a4e9843ee3b4.pdf','application/pdf',7,''),(888,880,'portal','','','','','','','특별기고','1',2,'','','',33,'석양을 맞이하여 / 남 기 섭 도선사','72','373501.pdf','f467ca5e2ab4a8ab50b392d0057bb0ae.pdf','application/pdf',8,''),(889,880,'portal','','','','','','','특별기고','1',2,'','','',33,'부산항 항만관제 업그레이드를 위한 방안 / 강 을 규 도선사','79','373502.pdf','e238eb1dbed6c161a288f315edeb91cb.pdf','application/pdf',9,''),(890,880,'portal','','','','','','','특별기고','1',2,'','','',33,'여자는 배, 남자는... / 윤 명 오 교수','83','373503.pdf','f25118bc11d35bdd7eae1c4309f442ba.pdf','application/pdf',10,''),(891,880,'portal','','','','','','','Pilot Now','1',2,'','','',33,'협회 및 지회, 회원 소식 / 편집실','86','','','',11,''),(892,880,'portal','','','','','','','News','1',2,'','','',33,'편집실','96','376500.pdf','1900922e27653ebb129bf17afc0f9cb4.pdf','application/pdf',12,''),(893,880,'portal','','','','','','','교양특집','1',2,'','','',33,'도선지 검색 시스템','','370100.pdf','9b53753ce828777803d789bf3307b95d.pdf','application/pdf',13,''),(894,880,'portal','','','','','','','교양특집','1',2,'','','',33,'원고모집','69','370200.pdf','00ef6b746c5ac17e5f331c9feb4d4382.pdf','application/pdf',14,''),(895,880,'portal','','','','','','','교양특집','1',2,'','','',33,'편집후기','100','370300.pdf','d02416e5033083e7e13be7f82a2859e4.pdf','application/pdf',15,''),(896,880,'portal','','','','','','','교양특집','1',2,'','','',33,'뒤표지','','370400.pdf','d00d9c5ae6bd719b16775b5b0896d0a3.pdf','application/pdf',16,''),(897,0,'portal','2005','01','24','신년호','한국도선사협회','D01','','1',1,'2005년 신년호 도선지(통권38호)','','magzine_tit_336.gif',32,'','','','','',1,''),(898,897,'portal','','','','','','','권두언','1',2,'','','',32,'선진 항만서비스 제공을 위한 도선사의 역할 증대를 기대하며/ 김순갑','04','038_04.pdf','ef972e7997666b430ecc3e5d15a7b777.pdf','application/pdf',1,''),(899,897,'portal','','','','','','','신년사','1',2,'','','',32,'협회장 신년사 / 이경화','06','038_06.pdf','2a497bb212610a2bac3ad8970beff7a9.pdf','application/pdf',2,''),(900,897,'portal','','','','','','','취임사','1',2,'','','',32,'해양수산부장관 취임사 /오거돈','08','038_08.pdf','fabf6f9eda2a1465e368f257617b524f.pdf','application/pdf',3,''),(901,897,'portal','','','','','','','Photo Gallery','1',2,'','','',32,'사진으로 보는 협회 동정 /편집실','10','038_10.pdf','4363163e3d82542a5c908362084dc752.pdf','application/pdf',4,''),(902,897,'portal','','','','','','','도선논단','1',2,'','','',32,'사법부 판례로 본 해양안전심판원 / 허용범 ','14','038_14.pdf','bf79bcfa9b63256f1851d2cb40de5217.pdf','application/pdf',5,''),(903,897,'portal','','','','','','','특집,참가보고서','1',2,'','','',32,'제17차 IMPA총회 참가보고서 / 황성현','27','038_27.pdf','43d96ee209a49b90c8b5f39519a13aa6.pdf','application/pdf',6,''),(904,897,'portal','','','','','','','해외정보 소개','1',2,'','','',32,'영국 도선제도의 고찰 / 김수룡','45','038_45.pdf','37e476ac2a2916d97a539e1a903caf6d.pdf','application/pdf',7,''),(905,897,'portal','','','','','','','IMO 회의일정','1',2,'','','',32,'2005년도 IMO 회의일정 / 해무실','60','038_60.pdf','d3b265fd63d105ab763ff4ab9bba8e74.pdf','application/pdf',8,''),(906,897,'portal','','','','','','','도선현장을 가다','1',2,'','','',32,'평택항을 찾아서 / 편집실','61','038_61.pdf','42ca232b77407f3fd3eff53952f4ce9f.pdf','application/pdf',9,''),(907,897,'portal','','','','','','','도선인터뷰','1',2,'','','',32,'평택항 김철균 도선사 / 임재근','68','038_68.pdf','853dc3045c04ee111945c5cef01ece9e.pdf','application/pdf',10,''),(908,897,'portal','','','','','','','건강','1',2,'','','',32,'식품과 건강 / 김영옥','75','038_75.pdf','597279067c52a4a37bb40b66e51a49a8.pdf','application/pdf',11,''),(909,897,'portal','','','','','','','도선기고','1',2,'','','',32,'대도예찬 / 임방섭','79','038_79.pdf','be77be588d46b153eff323b5334207cd.pdf','application/pdf',12,''),(910,897,'portal','','','','','','','도선기고','1',2,'','','',32,'부산항에서의 강제도선 면제제도에 대한 소고 / 양희준','81','038_81.pdf','d02eff658949c8b2e1516239e32c1477.pdf','application/pdf',13,''),(911,897,'portal','','','','','','','도선기고','1',2,'','','',32,'SBM에서 정년을 맞이한 후에 / 이문홍','84','038_84.pdf','5b82a5c05c09bfb17ff45587abfba91b.pdf','application/pdf',14,''),(912,897,'portal','','','','','','','Culture','1',2,'','','',32,'도선가족과 함께 보는 해양영화 7선 / 가순찬','86','038_86.pdf','b32d8a6aba9fd1802f903b6fd55f6bea.pdf','application/pdf',15,''),(913,897,'portal','','','','','','','Pilot Now','1',2,'','','',32,'협회 및 지회소식, 회원소식 / 편집실','88','038_88.pdf','b9596efc2a0b07f7adef35795cf8f949.pdf','application/pdf',16,''),(914,897,'portal','','','','','','','News','1',2,'','','',32,'알림 / 편집실','94','038_94.pdf','b38bb94e02d7dd9c74a6d2820ccf25d3.pdf','application/pdf',17,''),(915,897,'portal','','','','','','','편집후기','1',2,'','','',32,'임재근','98','038_98.pdf','5e3030418c2eafa7645240ed4f84ae78.pdf','application/pdf',18,''),(916,0,'portal','2005','07','25','여름호','한국도선사협회','D01','','1',1,'2005년 여름호 도선지(통권39호)','','magzine_tit_319.gif',31,'','','','','',1,''),(917,916,'portal','','','','','','','권두언','1',2,'','','',31,'도선사와 해기교육 / 신철호','04','039_4.pdf','6f44ba058421a2989967512939a4675f.pdf','application/pdf',1,''),(918,916,'portal','','','','','','','Photo Gallery','1',2,'','','',31,'사진으로 보는 협회 동정 / 편집실','06','039_6.pdf','68e2022557925cf39bd080fe47af944c.pdf','application/pdf',2,''),(919,916,'portal','','','','','','','도선논단','1',2,'','','',31,'해상교통에 있어서 신뢰의 원칙에 대한 고려/ 진노석','11','039_11.pdf','b50facd1db4302961cc9c503f8639295.pdf','application/pdf',3,''),(920,916,'portal','','','','','','','도선논단','1',2,'','','',31,'최적의 회항조선법 Inverse Williamson Turn에 관한 연구 / 우병구','27','039_27.pdf','213d9a2e91755e4795eb0a0ac14f632c.pdf','application/pdf',4,''),(921,916,'portal','','','','','','','해외정보 소개','1',2,'','','',31,'NAV 51 회의를 다녀와서 / 김수룡 ','43','039_43.pdf','b45b64aec3c769f4bbd197c51587461f.pdf','application/pdf',5,''),(922,916,'portal','','','','','','','도선현장을 가다','1',2,'','','',31,'목포항을 찾아서 / 편집실','52','039_52.pdf','0313733251ef8b3789877e5686789f11.pdf','application/pdf',6,''),(923,916,'portal','','','','','','','도선인터뷰','1',2,'','','',31,'목포항 이명식 도선사 / 임재근','60','039_60.pdf','20764a59ba462a5d1355bee11bf79cb5.pdf','application/pdf',7,''),(924,916,'portal','','','','','','','건강','1',2,'','','',31,'식품과 건강 / 김영옥','67','039_67.pdf','05ef3d8e5302416aa165e55f32b39e46.pdf','application/pdf',8,''),(925,916,'portal','','','','','','','도선기고','1',2,'','','',31,'Peter를 생각하며(만남1)/ 김수룡','71','039_71.pdf','a170a3931e66a8a97de9df22ce98caca.pdf','application/pdf',9,''),(926,916,'portal','','','','','','','도선기고','1',2,'','','',31,'친절도선/ 임방섭','76','039_76.pdf','94d8afb1b1b02762d4a6fd02fa48f13a.pdf','application/pdf',10,''),(927,916,'portal','','','','','','','도선기고','1',2,'','','',31,'수로안내인의 승선/ 심호섭','78','039_78.pdf','1ffd74360f2ef6110099ecbee6f0e3e5.pdf','application/pdf',11,''),(928,916,'portal','','','','','','','도선기고','1',2,'','','',31,'열린 자연을 찾아서/ 김동정','80','039_80.pdf','5c3e0b9b89935cf190154ae80081fcd5.pdf','application/pdf',12,''),(929,916,'portal','','','','','','','도선기고','1',2,'','','',31,'종합소득세 절세전략/ 김해동','83','039_83.pdf','f2e0fbf5e1bcb8bead0f2755e8295fdf.pdf','application/pdf',13,''),(930,916,'portal','','','','','','','Pilot Now','1',2,'','','',31,'협회 및 지회소식, 회원 소식/ 편집실','88','','','',14,''),(931,916,'portal','','','','','','','News','1',2,'','','',31,'알림 / 편집실','98','039_98.pdf','0b900d44e9677e2784a075c499ea70db.pdf','application/pdf',15,''),(932,916,'portal','','','','','','','편집후기','1',2,'','','',31,'임재근','102','039_102.pdf','1d20268ee6d160489de0da0b09b62c6f.pdf','application/pdf',16,''),(933,0,'portal','2006','01','23','신년호','한국도선사협회','D01','','1',1,'2006년 신년호 도선지(통권40호)','','magzine_tit_264.gif',30,'','','','','',1,''),(934,933,'portal','','','','','','','권두언','1',2,'','','',30,'인천항을 환항해권 중심항만으로 이끌 도선을 기대하며... /서정호','04','040_04.pdf','8df85e46f208e3cdb1ac4d6d0b3e2170.pdf','application/pdf',1,''),(935,933,'portal','','','','','','','신년사','1',2,'','','',30,'협회장 신년사 / 이경화','06','040_06.pdf','93b04511693990458fe22e5ed92bed4e.pdf','application/pdf',2,''),(936,933,'portal','','','','','','','신년사','1',2,'','','',30,'해양수산부장관 / 오거돈','08','','','',3,''),(937,933,'portal','','','','','','','Photo News','1',2,'','','',30,'사진으로 보는 협회 동정','12','040_12.pdf','9514441525ed00d4aadf29758c98189d.pdf','application/pdf',4,''),(938,933,'portal','','','','','','','도선논단','1',2,'','','',30,'에스코트 예선 운용 / 황성현','15','040_15.pdf','49c618e7955c1ff3093cc0ddcdb1eb38.pdf','application/pdf',5,''),(939,933,'portal','','','','','','','도선논단','1',2,'','','',30,'도선사와 VTS센터 관제 참여 / 정태권','40','040_40.pdf','786992dfae30a1a33a58a6b3c58889a8.pdf','application/pdf',6,''),(940,933,'portal','','','','','','','해외정보 소개','1',2,'','','',30,'Asia Navigation Conference 2005에 다녀와서 / 나태채','47','040_47.pdf','b091006cb9e85880a3bdfaf2ccd7ca52.pdf','application/pdf',7,''),(941,933,'portal','','','','','','','도선현장을 가다','1',2,'','','',30,'이순신 장군의 혼이 담겨있는 여수·광양항을 찾아서 /임재근','52','040_52.pdf','9729d638bdcc17249276b27086dc0fa3.pdf','application/pdf',8,''),(942,933,'portal','','','','','','','도선인터뷰','1',2,'','','',30,'여수항 주영필 도선사 / 임재근','62','040_62.pdf','f0f9b4a911349445277daadc03232e46.pdf','application/pdf',9,''),(943,933,'portal','','','','','','','도선인터뷰','1',2,'','','',30,'여수항 주영필 도선사 퇴임사 / 주영필','68','040_68.pdf','13addb5407e6cfa329a5bc689218a05c.pdf','application/pdf',10,''),(944,933,'portal','','','','','','','특별기고','1',2,'','','',30,'도선료의 선진국 수준화 / 최학영','71','040_71.pdf','7b8bb6a732b8a334f1db18704d35248e.pdf','application/pdf',11,''),(945,933,'portal','','','','','','','도선기고','1',2,'','','',30,'갈림길에 서서 / 주영필','73','040_73.pdf','6a1a82d3c72f90a165e2bb01c5db116f.pdf','application/pdf',12,''),(946,933,'portal','','','','','','','도선기고','1',2,'','','',30,'Sam과 Clay(만남2) / 김수룡','77','040_77.pdf','375e35dab6abc6fa88857e05d5275540.pdf','application/pdf',13,''),(947,933,'portal','','','','','','','도선기고','1',2,'','','',30,'해미에 얽힌 이야기 / 정관영','82','040_82.pdf','0ddfaa07591cd254292e1bc9419c6e78.pdf','application/pdf',14,''),(948,933,'portal','','','','','','','도선기고','1',2,'','','',30,'도선사의 사회활동 확대에 대한 의견 / 김인현','86','040_86.pdf','d24a3dde960ea8df97d6fabf1baf2b9b.pdf','application/pdf',15,''),(949,933,'portal','','','','','','','도선기고','1',2,'','','',30,'감사하는 마음 / 조은숙','89','040_89.pdf','1e7cf492de0dac18af7709bbdcd5e4f7.pdf','application/pdf',16,''),(950,933,'portal','','','','','','','도선기고','1',2,'','','',30,'다시 웅비하는 2006년 개띠해에 얽힌 이야기 / 김동정','91','040_91.pdf','e9b66d7cfd5d08359030aca5bed55029.pdf','application/pdf',17,''),(951,933,'portal','','','','','','','Pilot Now','1',2,'','','',30,'협회 및 지회 소식 / 편집실','94','040_94.pdf','9d427ef2880c96764a8a700b5e209051.pdf','application/pdf',18,''),(952,933,'portal','','','','','','','News','1',2,'','','',30,'알림 / 편집실','103','040_103.pdf','3280f60ec1a674c570bbde66d9a1e3fd.pdf','application/pdf',19,''),(953,933,'portal','','','','','','','편집후기','1',2,'','','',30,'편집실','106','040_106.pdf','d37965d60c230616732df913dbed1875.pdf','application/pdf',20,''),(954,0,'portal','2006','07','28','여름호','한국도선사협회','D01','','1',1,'2006년 여름호 도선지(통권41호)','','magazine_tit_248.gif',29,'','','','','',1,''),(955,954,'portal','','','','','','','권두언','1',2,'','','',29,'부산항을 동북아 중심항으로 이끌 도선을 기대하며... / 추준석','04','041_4.pdf','3b2ba9c56d1ca675034c926511ccbe5f.pdf','application/pdf',1,''),(956,954,'portal','','','','','','','Photo News','1',2,'','','',29,'사진으로 보는 협회 동정 / 편집실','06','041_6.pdf','c5c20d55345f0b9d5b9bf61d99f6770b.pdf','application/pdf',2,''),(957,954,'portal','','','','','','','도선논단','1',2,'','','',29,'변침조타법 오버슈트-스티어링 및 이지-스티어링의 정침조타에 관한 연구 / 우병구','11','041_11.pdf','7669ee28ef3d6dbef52e509a6c7d6ddb.pdf','application/pdf',3,''),(958,954,'portal','','','','','','','도선논단','1',2,'','','',29,'컨버전스 시대의 선박 관제 시스템 / 이희용','22','041_22.pdf','566e068c1c6fdbe00ceae60eb11181df.pdf','application/pdf',4,''),(959,954,'portal','','','','','','','해외정보 소개','1',2,'','','',29,'일본 수선법 개정안과 우리나라 도선법의 비교 / 황의창','32','041_32.pdf','7647e1a35b2041efc26dbe302ee40656.pdf','application/pdf',5,''),(960,954,'portal','','','','','','','해외정보 소개','1',2,'','','',29,'Asia-Pacific Pilotage Conference 2006? / 김수룡','40','041_40.pdf','8f793d5c44c48e5af79c6da4abc4bbdf.pdf','application/pdf',6,''),(961,954,'portal','','','','','','','도선현장을 가다','1',2,'','','',29,'동해안의 관문인 포항항을 찾아서... / 임재근','75','041_75.pdf','cd23360a0e10f7842e053994f4863650.pdf','application/pdf',7,''),(962,954,'portal','','','','','','','도선인터뷰','1',2,'','','',29,'포항항 김성호 도선사 / 임재근','85','041_85.pdf','3c6017780bf8cee9762efef223e16e05.pdf','application/pdf',8,''),(963,954,'portal','','','','','','','건강','1',2,'','','',29,'사계절의 음식섭생 / 김영옥','90','041_90.pdf','1a780e16d140f000b3d58e7fa64169b2.pdf','application/pdf',9,''),(964,954,'portal','','','','','','','도선기고','1',2,'','','',29,'잊혀지지 않는 파일럿 한 분 / 박성일','93','041_93.pdf','287fd75d4b80342a70e089e82b637c2a.pdf','application/pdf',10,''),(965,954,'portal','','','','','','','도선기고','1',2,'','','',29,'독일인 Boto (만남3) / 김수룡','95','041_95.pdf','d63a1197f38175571c8a09ecb43bfd2b.pdf','application/pdf',11,''),(966,954,'portal','','','','','','','도선기고','1',2,'','','',29,'중국 양산항, 상해, 항주, 계림 기행 / 이종열','99','041_99.pdf','4ea96713573c8d950706f1a374d8d644.pdf','application/pdf',12,''),(967,954,'portal','','','','','','','Pilot Now','1',2,'','','',29,'협회 및 지회소식·회원소식 / 편집실','104','041_104.pdf','51c04b7440e75726deb6c90fc1fd5250.pdf','application/pdf',13,''),(968,954,'portal','','','','','','','News','1',2,'','','',29,'편집실','115','041_115.pdf','4950ab2efbf5665c7a8be1b2b92a2f72.pdf','application/pdf',14,''),(969,954,'portal','','','','','','','편집후기','1',2,'','','',29,'편집실','118','041_118.pdf','e7a9a8ea755711c9a386dd768bfacbad.pdf','application/pdf',15,''),(970,0,'portal','2007','01','23','신년호','한국도선사협회','D01','','1',1,'2007년 신년호 도선지(통권42호)','','magzine_tit_227.gif',28,'','','','','',1,''),(971,970,'portal','','','','','','','권두언','1',2,'','','',28,'물류의 원활화 및 안전을 최우선하는 도선을 기대하며... /이정환','04','042_4.pdf','2d1ac41eb3d00560d55308b4e1df3cc9.pdf','application/pdf',1,''),(972,970,'portal','','','','','','','신년사','1',2,'','','',28,'협회장 신년사 / 이귀복','06','042_6.pdf','3707bc6d9f06b608debf0eada9559415.pdf','application/pdf',2,''),(973,970,'portal','','','','','','','신년사','1',2,'','','',28,'해양수산부장관 신년사 / 김성진','08','042_8.pdf','4d5ed7beb59d74ca9a5332cdc34ed627.pdf','application/pdf',3,''),(974,970,'portal','','','','','','','Photo News','1',2,'','','',28,'사진으로 보는 협회 동정','12','042_12.pdf','1b6d3c68ad9706d934132b9d2737019d.pdf','application/pdf',4,''),(975,970,'portal','','','','','','','도선논단','1',2,'','','',28,'해운기업의 안전관리체제 운영평가지표 개발에 대한 연구 / 송정규','16','042_16.pdf','d7b669e8838c5eaed5b4a1a6ab94804e.pdf','application/pdf',5,''),(976,970,'portal','','','','','','','도선논단','1',2,'','','',28,'대한해협에서 우발적인 해양사고 예방책으로서의 도선제도 / 정기남','34','042_34.pdf','b62c063cd2334d8198d5da234ab6a085.pdf','application/pdf',6,''),(977,970,'portal','','','','','','','해외정보 소개','1',2,'','','',28,'제52차 항해안전전문위원회 참석보고 / 황성현','61','042_61.pdf','a26362e7ecabfba06d647f02a509efff.pdf','application/pdf',7,''),(978,970,'portal','','','','','','','해외정보 소개','1',2,'','','',28,'우리협회와 호주도선사협회간의 양해각서 체결에 관해/ 김수룡','68','042_68.pdf','7b78c876f8f6faa2f1c672c5159d4950.pdf','application/pdf',8,''),(979,970,'portal','','','','','','','해외정보 소개','1',2,'','','',28,'호주의 BRM 교육에 관하여 / 김수룡','77','042_77.pdf','bb0f991dfdd21c59b4bbaa91758f5aa8.pdf','application/pdf',9,''),(980,970,'portal','','','','','','','해외정보 소개','1',2,'','','',28,'제18차 IMPA 총회 참가보고 및 소감 / 서영한','83','042_83.pdf','680b253960e9deb3dcc5c2d5f4f7b894.pdf','application/pdf',10,''),(981,970,'portal','','','','','','','도선현장을 가다','1',2,'','','',28,'의로운 고장 마산항을 찾아서 /임재근','88','042_88.pdf','1ec015e3ffb7a5e71fb4ab4acae4c056.pdf','application/pdf',11,''),(982,970,'portal','','','','','','','도선인터뷰','1',2,'','','',28,'마산항 박정혁 도선사 / 임재근','98','042_98.pdf','55b98019699f654dda445c717ee451cb.pdf','application/pdf',12,''),(983,970,'portal','','','','','','','도선기고','1',2,'','','',28,'삼성조선소 탐방기 / 윤영원','108','042_108.pdf','68de403e497f873f154991730fccd0d5.pdf','application/pdf',13,''),(984,970,'portal','','','','','','','도선기고','1',2,'','','',28,'Life Jacket과 맺은 별난 인연 / 정태환','110','042_110.pdf','c3f1072c25d70ba6b8bdb92437f21853.pdf','application/pdf',14,''),(985,970,'portal','','','','','','','도선기고','1',2,'','','',28,'차오프라야강을 찾아서 / 양재원','114','042_114.pdf','7ffa21cd98609a18baa65be0aca7d2e6.pdf','application/pdf',15,''),(986,970,'portal','','','','','','','도선기고','1',2,'','','',28,'찬란한 일출을 바라보면서 / 김세원','116','042_116.pdf','c2f547f31c3889a0869a8f4f361c4be1.pdf','application/pdf',16,''),(987,970,'portal','','','','','','','도선기고','1',2,'','','',28,'세계 무역을 이끄는 도선사(Pilot) / 최방우','118','042_118.pdf','50dbc3b45205db94b1aaf373a110ef8d.pdf','application/pdf',17,''),(988,970,'portal','','','','','','','Pilot Now','1',2,'','','',28,'협회 및 지회 소식 / 편집실','120','042_120.pdf','0faca0e4d52adf560ee4b565fae2d526.pdf','application/pdf',18,''),(989,970,'portal','','','','','','','News','1',2,'','','',28,'알림 / 편집실','134','042_134.pdf','d0876bf30d0742dc646965be32a17836.pdf','application/pdf',19,''),(990,970,'portal','','','','','','','편집후기','1',2,'','','',28,'편집실','138','042_138.pdf','53a1f86fb1bc6d13fab236b47f2824a0.pdf','application/pdf',20,''),(991,0,'portal','2007','07','26','여름호','한국도선사협회','D01','','1',1,'2007년 여름호 도선지(통권43호)','','magzine_tit_211.gif',27,'','','','','',1,''),(992,991,'portal','','','','','','','권두언','1',2,'','','',27,'세계 5대 해운강국 진입을 위한 도선사의 역할 /이진방','04','043_4.pdf','98c88520970953ade0631f088c6ffae1.pdf','application/pdf',1,''),(993,991,'portal','','','','','','','Photo News','1',2,'','','',27,'사진으로 보는 협회 동정','06','043_6.pdf','a542ade1a60a8e33c7d254a514bc059a.pdf','application/pdf',2,''),(994,991,'portal','','','','','','','도선논단','1',2,'','','',27,'해운기업의 안전관리체제 운영평가지표 개발에 대한 연구(2) / 송정규','10','043_10.pdf','aea50c1bedfca07b49f5ac6f2d6f62fe.pdf','application/pdf',3,''),(995,991,'portal','','','','','','','도선논단','1',2,'','','',27,'IMO 선박조종성 시험 기준 및 조선법에 관한 고찰 / 우병구','36','043_36.pdf','eb8f382f031e4699f1cf9fe91246a1a0.pdf','application/pdf',4,''),(996,991,'portal','','','','','','','해외정보 소개','1',2,'','','',27,'2007년 호주도선사협회(AMPA) 총회 / 김수룡','48','043_48.pdf','7661fefbcd47ea9f4973ee33646752f6.pdf','application/pdf',5,''),(997,991,'portal','','','','','','','도선현장을 가다','1',2,'','','',27,'환태평양시대의 중심항만 부산항을 찾아서/임재근','58','043_58.pdf','b6fe6b40859fca5f6fe4fc07bb3e0887.pdf','application/pdf',6,''),(998,991,'portal','','','','','','','도선인터뷰','1',2,'','','',27,'부산항 박영철 도선사 / 임재근','68','043_68.pdf','4f7d6d572356101df54966bb5cf953b2.pdf','application/pdf',7,''),(999,991,'portal','','','','','','','도선기고','1',2,'','','',27,'도선수습생 시험 도전기 / 이우환','78','043_78.pdf','c55af8f96742b58e49edff732835e5ad.pdf','application/pdf',8,''),(1000,991,'portal','','','','','','','도선기고','1',2,'','','',27,'변혁을 겪은 선원교육 / 이재우','85','043_85.pdf','a4b026151ff50c34328f8ff79c39a979.pdf','application/pdf',9,''),(1001,991,'portal','','','','','','','도선기고','1',2,'','','',27,'등대와 야화 / 박성일','94','043_94.pdf','2c8f88fcdda68a30f63121031b9fc2eb.pdf','application/pdf',10,''),(1002,991,'portal','','','','','','','도선기고','1',2,'','','',27,'착지 / 정성화','96','043_96.pdf','306a314ba8d4cd93b96a10c40427705d.pdf','application/pdf',11,''),(1003,991,'portal','','','','','','','도선기고','1',2,'','','',27,'고독한 천재 빈세트 반 고흐 / 박희숙','99','043_99.pdf','a75ff65b5e5c1a2e29f6f31aca984f84.pdf','application/pdf',12,''),(1004,991,'portal','','','','','','','Pilot Now','1',2,'','','',27,'협회 및 지회 소식 / 편집실 - 102','102','043_102.pdf','926755aea6f88a91e8739170d84a35d6.pdf','application/pdf',13,''),(1005,991,'portal','','','','','','','News','1',2,'','','',27,'알림 / 편집실','116','043_116.pdf','96679a64a5532c05281aeb9b1c4e57ae.pdf','application/pdf',14,''),(1006,991,'portal','','','','','','','편집후기','1',2,'','','',27,'편집실','120','043_120.pdf','192d45fe40a0ede26320f9f04fbbe1ab.pdf','application/pdf',15,''),(1007,0,'portal','2008','01','25','신년호','한국도선사협회','D01','','1',1,'2008년 신년호 도선지(통권44호)','','magzine_tit_192.gif',26,'','','','','',1,''),(1008,1007,'portal','','','','','','','권두언','1',2,'','','',26,'고객만족과 서비스 제고를 위해... /이인수','04','044_4.pdf','b74c8b16b2048a1eb96ac3d2b6199569.pdf','application/pdf',1,''),(1009,1007,'portal','','','','','','','신년사','1',2,'','','',26,'협회장 신년사 / 이귀복','06','044_6.pdf','3f843569a81cacdf09195040418585b0.pdf','application/pdf',2,''),(1010,1007,'portal','','','','','','','신년사','1',2,'','','',26,'해양수산부장관 신년사 / 강무현','08','044_8.pdf','468cfeef8997ab6678bd0d7123ec780d.pdf','application/pdf',3,''),(1011,1007,'portal','','','','','','','Photo News','1',2,'','','',26,'사진으로 보는 협회 동정','12','044_12.pdf','f43424d7d233da955573f15596ac80b6.pdf','application/pdf',4,''),(1012,1007,'portal','','','','','','','도선논단','1',2,'','','',26,'항만예선(Harbor Tug)의 추진시스템, 조종성능 및 사용법 / 우병구','16','044_16.pdf','db67eaf72bfdb8efa2cc9b3338a058f3.pdf','application/pdf',5,''),(1013,1007,'portal','','','','','','','도선논단','1',2,'','','',26,'우리나라 항만의 경쟁력 제고방안과 도선사의 역할 / 김길수','24','044_24.pdf','cca5961a4f97963f8966713bd160ad4f.pdf','application/pdf',6,''),(1014,1007,'portal','','','','','','','특집','1',2,'','','',26,'제1회 한·호도선사 간친회 참가 보고서 / 김수룡','36','044_36.pdf','ff09d9b1eb3cf9ef218805094a83e4ee.pdf','application/pdf',7,''),(1015,1007,'portal','','','','','','','특집','1',2,'','','',26,'브리즈번도선사회, 최고의 국제적 명성을 구축하다/Pelecanos','51','044_51.pdf','3c2ad3182343982c5310c5ce7a3eb4b3.pdf','application/pdf',8,''),(1016,1007,'portal','','','','','','','특집','1',2,'','','',26,'도선서비스의 현대화/ Rory Main','57','044_57.pdf','1ceb47aa06a178934e78e15be8c5cc7f.pdf','application/pdf',9,''),(1017,1007,'portal','','','','','','','특집','1',2,'','','',26,'도선안전관리시스템 / Chris Kline','61','044_61.pdf','c8e799955a76de645dd06ab23407a2af.pdf','application/pdf',10,''),(1018,1007,'portal','','','','','','','해외정보 소개','1',2,'','','',26,'IMO 제53차 항해안전전문위원회 참가보고 / 최영식','65','044_65.pdf','7db25cd15b07ce0de0eb3cdd92d9e1d7.pdf','application/pdf',11,''),(1019,1007,'portal','','','','','','','도선현장을 가다','1',2,'','','',26,'고래의 본 고장 울산항을 찾아서 /임재근','72','044_72.pdf','185e1a2bb8e2f4f6c449772a2b5db1d2.pdf','application/pdf',12,''),(1020,1007,'portal','','','','','','','도선인터뷰','1',2,'','','',26,'울산항 전기철 도선사 / 임재근','82','044_82.pdf','08ff0e7e8529d47de7e9c4683d1ec306.pdf','application/pdf',13,''),(1021,1007,'portal','','','','','','','도선기고','1',2,'','','',26,'인천은 아직도 항만이다 / 최영식','92','044_92.pdf','3799287e7ee0fe8128d1b8e90a875e0b.pdf','application/pdf',14,''),(1022,1007,'portal','','','','','','','도선기고','1',2,'','','',26,'다방면에 천재였던 레오나르도 다빈치 / 박희숙','94','044_94.pdf','54d27d165c4355a3c45d39b1e874d52a.pdf','application/pdf',15,''),(1023,1007,'portal','','','','','','','Pilot Now','1',2,'','','',26,'협회 및 지회 소식 / 편집실','98','044_98.pdf','e522224db28e12f2853ce847bfecf2be.pdf','application/pdf',16,''),(1024,1007,'portal','','','','','','','News','1',2,'','','',26,'알림 / 편집실','110','044_110.pdf','38761b3459d56c26c4fa3ae7e03049fb.pdf','application/pdf',17,''),(1025,1007,'portal','','','','','','','편집후기','1',2,'','','',26,'편집실','113','044_114.pdf','00ad60e09aaf779cd73417bfc108c16c.pdf','application/pdf',18,''),(1026,0,'portal','2008','07','25','여름호','한국도선사협회','D01','','1',1,'2008년 여름호 도선지(통권45호)','','magzine_tit_175.gif',25,'','','','','',1,''),(1027,1026,'portal','','','','','','','권두언','1',2,'','','',25,'우리에게 바다는 땅입니다 /오거돈','04','045_4.pdf','dec2cd1e7e9c6b4187ede9e25b62bea9.pdf','application/pdf',1,''),(1028,1026,'portal','','','','','','','Photo News','1',2,'','','',25,'사진으로 보는 협회 동정','06','045_6.pdf','09a55d4253ada3052885f0847277b75a.pdf','application/pdf',2,''),(1029,1026,'portal','','','','','','','도선논단','1',2,'','','',25,'안전항해를 위한 항행환경의 연구(평택,당진항을 중심으로) / 윤병원','10','045_10.pdf','c2deb18333ba1540e839fd207dc59ee1.pdf','application/pdf',3,''),(1030,1026,'portal','','','','','','','도선논단','1',2,'','','',25,'IMO 표준조타명령 MEET HER와 계류삭 취급명령... / 우병구','22','045_22.pdf','6de79e3f5e521e9348dd92cb8f8ff28e.pdf','application/pdf',4,''),(1031,1026,'portal','','','','','','','도선논단','1',2,'','','',25,'해양사고발생 주요 원인, 인적과실과 이의 BRM적 해결 / 허용범','28','045_28.pdf','4e3629a9e3b18de2ebc77f2afdd811b8.pdf','application/pdf',5,''),(1032,1026,'portal','','','','','','','해외정보 소개','1',2,'','','',25,'일본의 대형 탱커선 및 일반 거대선에... / 옥덕용','36','045_36.pdf','c8184785c761e2eeda9a649a1a1b8e37.pdf','application/pdf',6,''),(1033,1026,'portal','','','','','','','해외정보 소개','1',2,'','','',25,'제2차 캐나다도선사협회 총회 참석 보고서 / 서영한','40','045_40.pdf','32024fbaf36d12964fb3762c3990a95c.pdf','application/pdf',7,''),(1034,1026,'portal','','','','','','','해외정보 소개','1',2,'','','',25,'호주도선사협회 총회 참석 보고서/ 김수룡','46','045_46.pdf','3e178d76cb1fdc79424a7b4f67e057c6.pdf','application/pdf',8,''),(1035,1026,'portal','','','','','','','도선현장을 가다','1',2,'','','',25,'충남의 유일의 무역항 대산항을 찾아서/임재근','52','045_52.pdf','cb9f439aac2c189b68182da8a7320c24.pdf','application/pdf',9,''),(1036,1026,'portal','','','','','','','도선인터뷰','1',2,'','','',25,'대산항 유순기 도선사 / 임재근','60','045_60.pdf','ad3481348dce9d717d6e77bcbc78969a.pdf','application/pdf',10,''),(1037,1026,'portal','','','','','','','도선기고','1',2,'','','',25,'충돌 방지 조치로서의 VHF 사용과 문제점/ 이창희','68','045_68.pdf','678c3ab83da7cbb40da149b9df5bbda1.pdf','application/pdf',11,''),(1038,1026,'portal','','','','','','','도선기고','1',2,'','','',25,'국궁소개 / 정형택','74','045_74.pdf','64b70eb71eef4c3776a4e5c43f90611d.pdf','application/pdf',12,''),(1039,1026,'portal','','','','','','','도선기고','1',2,'','','',25,'행복을 표현한 화가 르누아르 / 박희숙','78','045_78.pdf','972ee6d0b0bb125c57d85917a9e0400c.pdf','application/pdf',13,''),(1040,1026,'portal','','','','','','','Pilot Now','1',2,'','','',25,'협회 및 지회 소식 / 편집실','82','045_82.pdf','85017bd28df90f6ed019ed541e74f5f0.pdf','application/pdf',14,''),(1041,1026,'portal','','','','','','','News','1',2,'','','',25,'알림 / 편집실','94','045_96.pdf','436314de0f74a13be10028665fb6e02d.pdf','application/pdf',15,''),(1042,1026,'portal','','','','','','','편집후기','1',2,'','','',25,'편집실','98','045_98.pdf','518a213aa7cce0e51bc4612f04abdce6.pdf','application/pdf',16,''),(1043,0,'portal','2009','01','23','신년호','한국도선사협회','D01','','1',1,'2009년 신년호 도선지(통권46호)','','magzine_tit_154.gif',24,'','','','','',1,''),(1044,1043,'portal','','','','','','','권두언','1',2,'','','',24,'최고의 인천항을 이끌 도선울 꿈꾸며... /김종태','04','046_4.pdf','daed1fdb768b76791ed2308133f20255.pdf','application/pdf',1,''),(1045,1043,'portal','','','','','','','신년사','1',2,'','','',24,'협회장 신년사 / 이귀복','06','046_6.pdf','37761aa517426a8a107ef359bdcd09dd.pdf','application/pdf',2,''),(1046,1043,'portal','','','','','','','Photo News','1',2,'','','',24,'사진으로 보는 협회 동정','08','046_8.pdf','d34bf5164da157ef4b3e94ea847c93f2.pdf','application/pdf',3,''),(1047,1043,'portal','','','','','','','도선논단','1',2,'','','',24,'도선선의 연구 / 윤병원','12','046_12.pdf','aaf17aa37235f08ef4e07a793bf8939c.pdf','application/pdf',4,''),(1048,1043,'portal','','','','','','','도선논단','1',2,'','','',24,'컨테이너 전용선의 10,000TEU급 이상 초대형화 / 우병구','64','046_64.pdf','837b2f29035b6eda21a0fed3c96b96af.pdf','application/pdf',5,''),(1049,1043,'portal','','','','','','','특집','1',2,'','','',24,'도선사 연수 새로운 패러다임 도전 / 이은방','72','046_72.pdf','eb5056bbc711f9bbe8a551f45c2593a8.pdf','application/pdf',6,''),(1050,1043,'portal','','','','','','','해외정보 소개','1',2,'','','',24,'제19차 IMPA 총회 참석보고 / 최영식','82','046_82.pdf','a9bec6365086fd80e584fdd6abe2e718.pdf','application/pdf',7,''),(1051,1043,'portal','','','','','','','해외정보 소개','1',2,'','','',24,'IMO 제54차 항해안전 전문위원회 참가 보고/ 최영식','93','046_93.pdf','dfafdc2ed1aa18dd87b6c1e684360e57.pdf','application/pdf',8,''),(1052,1043,'portal','','','','','','','도선현장을 가다','1',2,'','','',24,'동북아 중심국가 실현을 선도하는 인천항.. /임재근','106','046_106.pdf','06bf6f7f0a697a557aa5bbc3ce26bc09.pdf','application/pdf',9,''),(1053,1043,'portal','','','','','','','도선인터뷰','1',2,'','','',24,'인천항 이왕효 도선사 / 임재근','118','046_118.pdf','d0955dc26e20aad79e0d3a9a368be053.pdf','application/pdf',10,''),(1054,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'수습도선일기 / 박장희','126','046_126.pdf','e53dbe4e208ebb6021b4e097b32d641f.pdf','application/pdf',11,''),(1055,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'나의 포부와 자세 / 조영세','130','046_130.pdf','0ed14c3efa148b8eb333a5db47785e8a.pdf','application/pdf',12,''),(1056,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'K 선장 수습기 / 최성국','132','046_132.pdf','5989850379db483eae537159d9615e39.pdf','application/pdf',13,''),(1057,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'도선사의 사회적 책임과 명예 / 배병덕','134','046_134.pdf','af15c4ab47fea11f415b7aebddd9a327.pdf','application/pdf',14,''),(1058,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'21세기 신해양시대와 신해양력 / 이재우','139','046_139.pdf','f9cbd5d90cf6cdf8b2dcea773e30e8a5.pdf','application/pdf',15,''),(1059,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'각 도 / 정성화','147','046_147.pdf','27b3be6acd6929a65ca9c1702dd063db.pdf','application/pdf',16,''),(1060,1043,'portal','','','','','','','도선기고','1',2,'','','',24,'빛의 화가 렘브란트 / 박희숙','150','046_150.pdf','5933cd5cc78869f0d6d629136610f0c9.pdf','application/pdf',17,''),(1061,1043,'portal','','','','','','','Pilot Now','1',2,'','','',24,'협회 및 지회 소식 / 편집실','156','046_156.pdf','28d843cdc3f761796df8f751f13dbaaf.pdf','application/pdf',18,''),(1062,1043,'portal','','','','','','','News','1',2,'','','',24,'알림 / 편집실','164','046_164.pdf','a69f76783366202099d2612c7748e221.pdf','application/pdf',19,''),(1063,1043,'portal','','','','','','','편집후기','1',2,'','','',24,'편집실','168','046_168.pdf','008c4ca843e90c4c8fb1cfaa54e54d03.pdf','application/pdf',20,''),(1064,0,'portal','2009','07','28','여름호','한국도선사협회','D01','','1',1,'2009년 여름호 도선지(통권47호)','','magzine_tit_138.gif',23,'','','','','',1,''),(1065,1064,'portal','','','','','','','권두언','1',2,'','','',23,'초일류 도선을 향하여... /노기태','04','047_4.pdf','c25cf438549ce19d578d806177cf880d.pdf','application/pdf',1,''),(1066,1064,'portal','','','','','','','Photo News','1',2,'','','',23,'사진으로 보는 협회 동정','06','047_6.pdf','11347390190e018f96e041a29eaba3e4.pdf','application/pdf',2,''),(1067,1064,'portal','','','','','','','도선논단','1',2,'','','',23,'도선학술연구회 활동과 앞으로의 나갈길 / 이동섭','10','047_10.pdf','44d2b8db8ca82d7ecfabc562bee97dc8.pdf','application/pdf',3,''),(1068,1064,'portal','','','','','','','도선논단','1',2,'','','',23,'함정상부구조물과 조종설비 / 우병구','18','047_18.pdf','1f6c4e3d7c4c8b1b910bc51c47032422.pdf','application/pdf',4,''),(1069,1064,'portal','','','','','','','해외정보 소개','1',2,'','','',23,'ISPO회의 참가보고서 / 강을규','30','047_30.pdf','a3f9eb2b6c5f2e0a83e7f2a2cf188886.pdf','application/pdf',5,''),(1070,1064,'portal','','','','','','','도선현장을 가다','1',2,'','','',23,'동북아 물류중심 평택당진항을 찾아서.. /천성민','40','047_40.pdf','1adfb530c2832c2a13b67919ba23e15b.pdf','application/pdf',6,''),(1071,1064,'portal','','','','','','','도선현장취재','1',2,'','','',23,'평택당진항 도선현장을 가다 / 천성민','44','047_44.pdf','9017e037d644133c663b5f6596d9bd02.pdf','application/pdf',7,''),(1072,1064,'portal','','','','','','','도선기고','1',2,'','','',23,'월드투게더 / 조태호','58','047_58.pdf','bb26cd514abe641dd671152eb8d5952b.pdf','application/pdf',8,''),(1073,1064,'portal','','','','','','','도선기고','1',2,'','','',23,'英語遺憾 / 최성국','64','047_64.pdf','85cc3d173cc702f365116882d42f3654.pdf','application/pdf',9,''),(1074,1064,'portal','','','','','','','도선기고','1',2,'','','',23,'만남 / 조영세','67','047_67.pdf','5e2a606e6d65c80e77d73c874a763811.pdf','application/pdf',10,''),(1075,1064,'portal','','','','','','','도선기고','1',2,'','','',23,'여성의 아름다움을 예술로 승화시킨 화가 클림트 / 박희숙','69','047_69.pdf','f810996763807920bbdfa5e215d829d1.pdf','application/pdf',11,''),(1076,1064,'portal','','','','','','','도선기고','1',2,'','','',23,'내가 산을 찾는 이유 / 김동정','72','047_72.pdf','a8ddc0fbf78174b209fe4fca49336ccf.pdf','application/pdf',12,''),(1077,1064,'portal','','','','','','','Pilot Now','1',2,'','','',23,'협회 및 지회 소식 / 편집실','76','047_76.pdf','00c212602cf98f88f8fcf48aaaf580e6.pdf','application/pdf',13,''),(1078,1064,'portal','','','','','','','News','1',2,'','','',23,'알림 / 편집실','88','047_88.pdf','8d0ae195fe7411114dc49e8f7801d07a.pdf','application/pdf',14,''),(1079,1064,'portal','','','','','','','편집후기','1',2,'','','',23,'편집실','92','047_92.pdf','fa0ca618ad1dbcbf8cf06f7fbc0467af.pdf','application/pdf',15,''),(1080,0,'portal','2010','01','25','신년호','한국도선사협회','D01','','1',1,'2010년 신년호 도선지(통권48호)','','magzine_tit_120.gif',22,'','','','','',1,''),(1081,1080,'portal','','','','','','','권두언','1',2,'','','',22,'庚寅年 새해! 세계 최고의 해운시대를 함께 열어갑시다! /서병수','04','048_4.pdf','56dfad084999d65926ed15995a410486.pdf','application/pdf',1,''),(1082,1080,'portal','','','','','','','신년사','1',2,'','','',22,'협회장 신년사','06','048_6.pdf','4908abe86fd1e5f97fe11fe0c87445de.pdf','application/pdf',2,''),(1083,1080,'portal','','','','','','','신년사','1',2,'','','',22,'국토해양부장관 신년사','10','048_10.pdf','2db25b201706380f545c1ad1462fe68f.pdf','application/pdf',3,''),(1084,1080,'portal','','','','','','','Photo News','1',2,'','','',22,'사진으로 보는 협회 동정','14','2010_신년_포토.pdf','67a88a3c7661d04901f80d89ff156526.pdf','application/pdf',4,''),(1085,1080,'portal','','','','','','','도선논단','1',2,'','','',22,'전자해도시스템의 개요 / 배병덕','18','048_18.pdf','37da8d0f0977f1bebd20b0a13c216a7c.pdf','application/pdf',5,''),(1086,1080,'portal','','','','','','','도선논단','1',2,'','','',22,'녹색사회에서의 Pilotship 탐색 / 이은방','31','048_31.pdf','7be6976a660efe46f44ef30681ece452.pdf','application/pdf',6,''),(1087,1080,'portal','','','','','','','특집','1',2,'','','',22,'심장병어린이와 나눔의 기쁨을 함께하다 / 편집실','40','2010_신년_특집.pdf','32e2b6ad7579d1944e4b835b24a105c6.pdf','application/pdf',7,''),(1088,1080,'portal','','','','','','','해외정보 소식','1',2,'','','',22,'IMO 제55차 NAV회의 참석 보고서 / 최영식','44','048_44.pdf','73a3bb7996ef08d8ac3005a6fa485bed.pdf','application/pdf',8,''),(1089,1080,'portal','','','','','','','특별기획','1',2,'','','',22,'여수광양항을 찾아서.. /천성민','56','048_56.pdf','45e8bb094399a18058d5824402b90458.pdf','application/pdf',9,''),(1090,1080,'portal','','','','','','','특별기획','1',2,'','','',22,'여수광양항 도선현장취재 /천성민','60','048_60.pdf','394dbbb48bd02dd22de113e2978733a4.pdf','application/pdf',10,''),(1091,1080,'portal','','','','','','','특별기획','1',2,'','','',22,'여수광양항 해상교통관제센터 방문기 /천성민','70','048_70.pdf','cce8ef354681f723b70ef6d414db9ef1.pdf','application/pdf',11,''),(1092,1080,'portal','','','','','','','도선기고','1',2,'','','',22,'도선수습체험기 / 김수진','74','048_74.pdf','5fa4eb0c3eab5cba8e713dcbad8b9d69.pdf','application/pdf',12,''),(1093,1080,'portal','','','','','','','도선기고','1',2,'','','',22,'르네상스의 거장-미켈란젤로 / 박희숙','78','048_78.pdf','aa28f8f9aabb5018de3f19626c11e69a.pdf','application/pdf',13,''),(1094,1080,'portal','','','','','','','도선기고','1',2,'','','',22,'서커스에 대한 추억 / 정성화','81','048_81.pdf','1b8c0ce8db2c83bc0f20158e88c89dc2.pdf','application/pdf',14,''),(1095,1080,'portal','','','','','','','Pilot Now','1',2,'','','',22,'협회 및 지회 소식 / 편집실','84','048_84.pdf','1ba6a7104c623bbac47ffc6cddce9142.pdf','application/pdf',15,''),(1096,1080,'portal','','','','','','','News','1',2,'','','',22,'알림 / 편집실','94','048_94.pdf','6f77c523ac614270361a57fa5e294c96.pdf','application/pdf',16,''),(1097,1080,'portal','','','','','','','편집후기','1',2,'','','',22,'편집실','98','048_98.pdf','8ab9505569e282e6cf682bf47bcde7d2.pdf','application/pdf',17,''),(1098,0,'portal','2010','07','26','여름호','한국도선사협회','D01','','1',1,'2010년 여름호 도선지(통권49호)','','magzine_tit_104.gif',21,'','','','','',1,''),(1099,1098,'portal','','','','','','','권두언','1',2,'','','',21,'해양산업에 대한 대국민 인식제고 시급 / 이진방','04','049_4.pdf','56b53c5baf01a70d9a4ca86787faf91c.pdf','application/pdf',1,''),(1100,1098,'portal','','','','','','','Photo News','1',2,'','','',21,'사진으로 보는 협회 동정','06','049_6.pdf','149be79951d8c241db7f9d876029f24c.pdf','application/pdf',2,''),(1101,1098,'portal','','','','','','','도선논단','1',2,'','','',21,'무선센서통신망과 전력선 통신망 선내 실험 결과 비교 / 배병덕','10','049_10.pdf','63da8173b9a8f855f2ff6a39826f6bc7.pdf','application/pdf',3,''),(1102,1098,'portal','','','','','','','도선논단','1',2,'','','',21,'2010년 해상부표연구 / 우병구','19','049_19.pdf','8f2b8acfe226ed5f58fb07ddc7401bfa.pdf','application/pdf',4,''),(1103,1098,'portal','','','','','','','특집','1',2,'','','',21,'심장병어린이 소식 / 편집실','28','2010_여름_특집.pdf','858aa14580f8973c64bd92fb5731db16.pdf','application/pdf',5,''),(1104,1098,'portal','','','','','','','특별기획','1',2,'','','',21,'도선현장을 가다(마산항을 찾아서).. /천성민','32','049_32.pdf','28c60d425dfd1ae790e1d89181b8b29a.pdf','application/pdf',6,''),(1105,1098,'portal','','','','','','','특별기획','1',2,'','','',21,'도선 인터뷰(마산항 도선현장취재)   /천성민','46','049_46.pdf','1a2096ec53651d33cc6375dfb8b6aaa5.pdf','application/pdf',7,''),(1106,1098,'portal','','','','','','','도선기고','1',2,'','','',21,'도선사, 그 후 3년 / 양재원','52','049_52.pdf','38ce7d7d53a95b8ac266e8b8c6b256d3.pdf','application/pdf',8,''),(1107,1098,'portal','','','','','','','도선기고','1',2,'','','',21,'업이란 / 조영세','56','049_56.pdf','63b8749c1c418c5db449e24c819bf540.pdf','application/pdf',9,''),(1108,1098,'portal','','','','','','','도선기고','1',2,'','','',21,'잠과의 전쟁 / 서윤성','58','049_58.pdf','068baf5ac54a12c0ae6065591a53d42f.pdf','application/pdf',10,''),(1109,1098,'portal','','','','','','','도선기고','1',2,'','','',21,'해양사고 조사, 심판제도의 개선 / 지희진','64','049_64.pdf','7e8e18a53eb614e153959bd2a10d4565.pdf','application/pdf',11,''),(1110,1098,'portal','','','','','','','도선기고','1',2,'','','',21,'새로운 시대를 열었던 천재 피카소 / 박희숙','68','049_68.pdf','c6b4e6b14415b0b310c28a1e23d0e23b.pdf','application/pdf',12,''),(1111,1098,'portal','','','','','','','Pilot Now','1',2,'','','',21,'협회 및 지회 소식 / 편집실','72','049_72.pdf','46108206475d6707c929b1d5eaafc034.pdf','application/pdf',13,''),(1112,1098,'portal','','','','','','','News','1',2,'','','',21,'알림 / 편집실','86','049_86.pdf','a138d0caf6949155ef0f5ce244810be0.pdf','application/pdf',14,''),(1113,1098,'portal','','','','','','','편집후기','1',2,'','','',21,'편집실','90','049_90.pdf','f8e885306073adf8d5869b6e6a6bc39b.pdf','application/pdf',15,''),(1114,0,'portal','2011','01','20','신년호','한국도선사협회','D01','','1',1,'2011년 신년호 도선지(통권50호)','','magzine_tit_84.gif',20,'','','','','',1,''),(1115,1114,'portal','','','','','','','권두언','1',2,'','','',20,'해운강국의 선봉장으로서 새롭고 활기찬 신묘년을 기대하며 /박희태','04','050_4.pdf','c5a8750fe5e6cfc08b34ddf08bc5fb12.pdf','application/pdf',1,''),(1116,1114,'portal','','','','','','','권두언','1',2,'','','',20,'Pilots working together / Michael Watson','06','050_6.pdf','2f241daeba7c92616a85d8a7a4bb8de6.pdf','application/pdf',2,''),(1117,1114,'portal','','','','','','','신년사','1',2,'','','',20,'협회장 신년사','08','050_8.pdf','1b760c15e840abd12291e15f80deb04d.pdf','application/pdf',3,''),(1118,1114,'portal','','','','','','','신년사','1',2,'','','',20,'국토해양부장관 신년사','12','050_12.pdf','302eee5e13128180d65a87076f71f983.pdf','application/pdf',4,''),(1119,1114,'portal','','','','','','','Photo News','1',2,'','','',20,'사진으로 보는 협회 동정','14','050_14.pdf','584b6501b7da5d1b5bc9fd43dffc6911.pdf','application/pdf',5,''),(1120,1114,'portal','','','','','','','도선논단','1',2,'','','',20,'IAMSAR / 우병구','18','050_18.pdf','7cae342ed8ecac9eb225c3815257143b.pdf','application/pdf',6,''),(1121,1114,'portal','','','','','','','도선논단','1',2,'','','',20,'등화 및 형상물의 게양의무와 법적책임 / 박성일','26','050_26.pdf','b177e2010c9e16a8433678a3c94003c3.pdf','application/pdf',7,''),(1122,1114,'portal','','','','','','','특집','1',2,'','','',20,'글로벌 해운 전문인력 장학생 소식 / 편집실','36','','','',8,''),(1123,1114,'portal','','','','','','','해외정보 소식','1',2,'','','',20,'IMO 제56차 NAV회의 참석 보고서 / 강철민','38','050_38.pdf','75b5f723b69d3381839c53ab29d625ca.pdf','application/pdf',9,''),(1124,1114,'portal','','','','','','','특별기획','1',2,'','','',20,'도선현장을 가다(목포항을 찾아서) /천성민','54','050_54.pdf','de0fa8b10b3f972e9c6046f377f2289a.pdf','application/pdf',10,''),(1125,1114,'portal','','','','','','','특별기획','1',2,'','','',20,'도선인터뷰(목포항 송인기 도선사) / 천성민','62','050_62.pdf','aed28deb3f165121d3ae04005d3ed05a.pdf','application/pdf',11,''),(1126,1114,'portal','','','','','','','도선기고','1',2,'','','',20,'도선사를 위한 선박조종 시뮬레이터 / 허용범','66','050_66.pdf','b63231a9009860e99d056ba62b217adb.pdf','application/pdf',12,''),(1127,1114,'portal','','','','','','','도선기고','1',2,'','','',20,'대구야 내다 / 정성화','74','050_74.pdf','eabe0f8582bc19924b75de83b44d167e.pdf','application/pdf',13,''),(1128,1114,'portal','','','','','','','도선기고','1',2,'','','',20,'천국여권 / 신현배','78','050_78.pdf','e2f31b8837b10a7d14a981c2b0b46ee0.pdf','application/pdf',14,''),(1129,1114,'portal','','','','','','','도선기고','1',2,'','','',20,'대중적 이미지를 예술로 승화시킨 앤디워홀 / 박희숙','85','050_82.pdf','4023efef0f37a9a6ce495fc0b6ceff24.pdf','application/pdf',15,''),(1130,1114,'portal','','','','','','','도선기고','1',2,'','','',20,'2011년에 부르는 희망의 찬가 / 김동정','86','050_86.pdf','c7bde9da0bf6747c6cd49148d11f380b.pdf','application/pdf',16,''),(1131,1114,'portal','','','','','','','Pilot Now','1',2,'','','',20,'협회 및 지회 소식 / 편집실','88','','','',17,''),(1132,1114,'portal','','','','','','','News','1',2,'','','',20,'관련단체소식 / 편집실','100','050_100.pdf','1d665682f5bbe4c9340cc42c7d5be22d.pdf','application/pdf',18,''),(1133,1114,'portal','','','','','','','편집후기','1',2,'','','',20,'편집실','104','050_104.pdf','9596d4173bef996e5ae1c97f9d127caf.pdf','application/pdf',19,''),(1134,0,'portal','2011','07','27','여름호','한국도선사협회','D01','','1',1,'2011 여름호 도선지(통권51호)','','magzine_tit_68.jpg',19,'','','','','',1,''),(1135,1134,'portal','','','','','','','권두언','1',2,'','','',19,'신현윤','04','051_04.pdf','557166770c9920866c8105f23f2c780f.pdf','application/pdf',1,''),(1136,1134,'portal','','','','','','','Photo News','1',2,'','','',19,'사진으로 보는 협회 동정','06','051_06.pdf','5041d2276c5a88c6e16fa15a7379d015.pdf','application/pdf',2,''),(1137,1134,'portal','','','','','','','특별기고','1',2,'','','',19,'해운항만산업과 도선사 / 임기택','10','051_10.pdf','ece10100a860450fe8c7f2eac7a88994.pdf','application/pdf',3,''),(1138,1134,'portal','','','','','','','도선논단','1',2,'','','',19,'선박개념의 확대 경향과 안전도선 / 박성일','14','051_14.pdf','efa1eeb3238b96c6be082dcc2f106a31.pdf','application/pdf',4,''),(1139,1134,'portal','','','','','','','해외정보 소식','1',2,'','','',19,'IMO 제57차 NAV회의 참석 보고서 / 최영식','30','051_30.pdf','f5a69a79748d8152cd70a965623eba0e.pdf','application/pdf',5,''),(1140,1134,'portal','','','','','','','특별기획','1',2,'','','',19,'도선현장을 가다(부산항을 찾아서) /천성민','40','051_40.pdf','b58285505d4c42adc68361f6720dfbe5.pdf','application/pdf',6,''),(1141,1134,'portal','','','','','','','특별기획','1',2,'','','',19,'부산항 항만물류과장 인터뷰 / 천성민','47','051_47.pdf','bf1ce791db1616ab4497199edeb9a09e.pdf','application/pdf',7,''),(1142,1134,'portal','','','','','','','특별기획','1',2,'','','',19,'도선인터뷰(부산항 손영재 도선사) / 천성민','48','051_48.pdf','ca353d7a0ee175ec513baa01e6aca3cf.pdf','application/pdf',8,''),(1143,1134,'portal','','','','','','','도선기고','1',2,'','','',19,'노래연습장 / 최성국','52','051_52.pdf','c94242589cc56c39f96d2ad6215521dc.pdf','application/pdf',9,''),(1144,1134,'portal','','','','','','','도선기고','1',2,'','','',19,'선원과 편의치적 제도 / 장경우','56','051_56.pdf','19a219e97141ba2a8987b36b9184a78c.pdf','application/pdf',10,''),(1145,1134,'portal','','','','','','','도선기고','1',2,'','','',19,'나폴레옹의 화가 다비드 / 박희숙','60','051_60.pdf','93618f4c97db95a2f4fd180b769a124d.pdf','application/pdf',11,''),(1146,1134,'portal','','','','','','','도선기고','1',2,'','','',19,'징크스 / 신현배','64','051_64.pdf','014b2c16c5f627b45800b08378fbb118.pdf','application/pdf',12,''),(1147,1134,'portal','','','','','','','Pilot Now','1',2,'','','',19,'협회 및 지회 소식 / 편집실','68','2011_여름_나우.pdf','2b8d00d2e53745d413d941b675d2c283.pdf','application/pdf',13,''),(1148,1134,'portal','','','','','','','News','1',2,'','','',19,'관련단체소식 / 편집실','82','051_82.pdf','7b4053a0958988c184f6d6fa4818c258.pdf','application/pdf',14,''),(1149,1134,'portal','','','','','','','편집후기','1',2,'','','',19,'편집실','86','051_86.pdf','58ca161b78e159faa40da4b494941ef8.pdf','application/pdf',15,''),(1150,0,'portal','2012','01','19','신년호','한국도선사협회','D01','','1',1,'2012년 신년호 도선지(통권52호)','','magzine_tit_45.jpg',18,'','','','','',1,''),(1151,1150,'portal','','','','','','','권두언','1',2,'','','',18,'장광근','04','052_04.pdf','560feb56a541091dd94df43614c91181.pdf','application/pdf',1,''),(1152,1150,'portal','','','','','','','신년사','1',2,'','','',18,'송정규','06','052_06.pdf','7a5fb289c254508d489ff06e50ab46cf.pdf','application/pdf',2,''),(1153,1150,'portal','','','','','','','신년사','1',2,'','','',18,'국토해양부장관','10','052_10.pdf','77e072ea01ba1cded601ab1d9f457c3f.pdf','application/pdf',3,''),(1154,1150,'portal','','','','','','','Photo News','1',2,'','','',18,'사진으로 보는 협회 동정','14','052_14.pdf','ab8be890866f0b792f898dea13ae1822.pdf','application/pdf',4,''),(1155,1150,'portal','','','','','','','특집','1',2,'','','',18,'글로벌 리더, 첫 걸음을 내딛다 / 김겸원','18','052_18.pdf','b7c0f78c74e4281141f144f3f6af2517.pdf','application/pdf',5,''),(1156,1150,'portal','','','','','','','특집','1',2,'','','',18,'호주해양대학 교환학생 후기 / 이말그내','22','052_22.pdf','0e00c101398ac665c6d482687926d6a0.pdf','application/pdf',6,''),(1157,1150,'portal','','','','','','','특집','1',2,'','','',18,'타즈매니아에서의 새로운 도전 / 권한솔','28','052_28.pdf','d77f83ee9feb2a8170e27d83349f3c85.pdf','application/pdf',7,''),(1158,1150,'portal','','','','','','','특집','1',2,'','','',18,'Kingspoint 유학생 새해인사 / 장유락','31','052_31.pdf','a0cf48efede78ab9200d5be63de7fb66.pdf','application/pdf',8,''),(1159,1150,'portal','','','','','','','도선논단','1',2,'','','',18,'도선사-선장간의 도선 정보교환 및 코스카드활용에 관하여 / 우병구','32','052_32.pdf','55e37f9ff058bf3c0e7d515d93c9dd6c.pdf','application/pdf',9,''),(1160,1150,'portal','','','','','','','도선논단','1',2,'','','',18,'해양안전심판에 있어서의 이해관계인 비교 / 이철환','42','052_42.pdf','1dad619086e1b0725b182fe74e685e52.pdf','application/pdf',10,''),(1161,1150,'portal','','','','','','','특별기획','1',2,'','','',18,'도선현장을 가다(울산항을 찾아서) / 천성민','60','052_60.pdf','c34dcf671659fb1fed8f454c0dc70358.pdf','application/pdf',11,''),(1162,1150,'portal','','','','','','','특별기획','1',2,'','','',18,'도선인터뷰(울산항 나태채 도선사) / 천성민','69','052_69.pdf','b6654e7a0e923bc475b7c95722f3a21b.pdf','application/pdf',12,''),(1163,1150,'portal','','','','','','','특별기획','1',2,'','','',18,'울산항 항만물류과장 인터뷰 / 천성민','73','052_73.pdf','924fdeac2b64a704eb10fadb0c8cc5df.pdf','application/pdf',13,''),(1164,1150,'portal','','','','','','','도선기고','1',2,'','','',18,'도선사의 해기전승 / 조영균','76','052_76.pdf','868fbf459f5c53cc50350928e2186f7b.pdf','application/pdf',14,''),(1165,1150,'portal','','','','','','','도선기고','1',2,'','','',18,'도선수습생의 각오 / 최상문','78','052_78.pdf','39f7d7904a3a6c3b4f6333adb543daff.pdf','application/pdf',15,''),(1166,1150,'portal','','','','','','','도선기고','1',2,'','','',18,'나는 도선사다 / 이은방','84','052_84.pdf','5f76a46124647e216e1abb27eede4717.pdf','application/pdf',16,''),(1167,1150,'portal','','','','','','','도선기고','1',2,'','','',18,'오십대를 저글링 하다 / 정성화','91','052_91.pdf','af1e56aa0fb719c4d762362396148eae.pdf','application/pdf',17,''),(1168,1150,'portal','','','','','','','도선기고','1',2,'','','',18,'노동의 신성함을 일깨워 주는 화가 밀레 / 박희숙','94','052_94.pdf','27b4e0128cf29c3993827f4e8b1ca128.pdf','application/pdf',18,''),(1169,1150,'portal','','','','','','','Pilot Now','1',2,'','','',18,'협회 및 지회 소식 / 편집실','102','052_102.pdf','c768ffec53890c995abc37d23ee14195.pdf','application/pdf',20,''),(1170,1150,'portal','','','','','','','News','1',2,'','','',18,'관련단체소식 / 편집실','114','052_114.pdf','7303c58c96e6ad5b0f70800588fbd0fe.pdf','application/pdf',21,''),(1171,1150,'portal','','','','','','','편집후기','1',2,'','','',18,'편집실','118','052_118.pdf','964ac8561d92196a611fc91c75744ec5.pdf','application/pdf',22,''),(1172,1150,'portal','','','','','','','권두언','1',2,'','','',17,'박한일','04','053_04.pdf','a5f7b60eb89129417bf9b4bf6dcf5af7.pdf','application/pdf',1,''),(1173,1150,'portal','','','','','','','Photo News','1',2,'','','',17,'사진으로 보는 협회 동정','06','053_06.pdf','e17e32e04e5a6b0756332b1ba947972c.pdf','application/pdf',2,''),(1174,1150,'portal','','','','','','','도선논단','1',2,'','','',17,'정류선의 항법상 지위에 관한 연구 / 이철환','10','053_10.pdf','09fa3bd398e97b4f7d3035714ca6c4ee.pdf','application/pdf',3,''),(1175,1150,'portal','','','','','','','도선논단','1',2,'','','',17,'선박입출항법 제정안과 도선제도에 관한 소고 / 이창희','20','53ȣ 도선사 내지20-26.pdf','aa9249f179c5fb1f46063bc2fe2781b3.pdf','application/pdf',4,''),(1176,1150,'portal','','','','','','','도선논단','1',2,'','','',17,'예인선 침몰사고로 본 해양안전의 책임한계 / 박성일','26','053_26.pdf','a31906a6173c57fe0c37689b636d07c8.pdf','application/pdf',5,''),(1177,1150,'portal','','','','','','','특별기획','1',2,'','','',17,'도선현장을 가다(대산항을 찾아서) / 천성민','36','053_36.pdf','d1f128e7f45d6ebe2b74dec5debd9ad4.pdf','application/pdf',6,''),(1178,1150,'portal','','','','','','','특별기획','1',2,'','','',17,'도선인터뷰(대산항 최석호 도선사) / 천성민','43','053_43.pdf','1e1838314f436de092efba6ce32a3517.pdf','application/pdf',7,''),(1179,1150,'portal','','','','','','','도선기고','1',2,'','','',17,'도선선과 도선선 장비의 개선 / 강을규','50','053_50.pdf','a81475f5277eab2596af3204fc6bfae2.pdf','application/pdf',8,''),(1180,1150,'portal','','','','','','','도선기고','1',2,'','','',17,'도선사고 사례(안전도선을 기원하며) / 윤일수','54','053_54.pdf','0086f15b64fa1f8ce8de28932842ef17.pdf','application/pdf',9,''),(1181,1150,'portal','','','','','','','도선기고','1',2,'','','',17,'아버지를 찾아서 / 신현배','78','053_78.pdf','a04a524da9104476db08c0669b73377e.pdf','application/pdf',10,''),(1182,1150,'portal','','','','','','','Pilot Now','1',2,'','','',17,'협회 및 지회 소식 / 편집실','82','053_82.pdf','01315ea329edcd4e5a045eb7f5ea7798.pdf','application/pdf',11,''),(1183,1150,'portal','','','','','','','News','1',2,'','','',17,'관련단체소식 / 편집실','94','053_94.pdf','80d2b60b7ce51c38032e0fd492f34336.pdf','application/pdf',12,''),(1184,1150,'portal','','','','','','','편집후기','1',2,'','','',17,'편집실','98','053_98.pdf','6e19902295d17ba4ae81373b6c64f5c1.pdf','application/pdf',13,''),(1185,0,'portal','2012','07','25','여름호','한국도선사협회','D01','','1',1,'2012년 여름호 도선지(통권53호)','','magzine_tit_19.jpg',17,'','','','','',1,''),(1186,0,'portal','2013','01','25','신년호','한국도선사협회','D01','','1',1,'2013 신년호 도선지(통권54호)','','magazine_tit_1.jpg',16,'','','','','',1,''),(1187,1186,'portal','','','','','','','신년사','1',2,'','','',16,'권도엽 국토해양부장관','04','54_04.pdf','ee82f1eecc04f380a57d74bbe76109f2.pdf','application/pdf',1,''),(1188,1186,'portal','','','','','','','권두언','1',2,'','','',16,'주승용 국회 국토해양위원장','10','54_10.pdf','a793124b117c7b8ae758a2c1779b7a3c.pdf','application/pdf',2,''),(1189,1186,'portal','','','','','','','신년사','1',2,'','','',16,'나종팔 한국도선사협회장','12','54_12.pdf','9dc41187e3f22d8ae77f0d344c487a71.pdf','application/pdf',3,''),(1190,1186,'portal','','','','','','','Photo News','1',2,'','','',16,'사진으로 보는 협회 동정','14','54_14.pdf','126ebe5ee34f3f2e544574c0826362a1.pdf','application/pdf',4,''),(1191,1186,'portal','','','','','','','해외정보 소식','1',2,'','','',16,'NAV 58 참가보고서 / 변영욱','18','54_18.pdf','150c674967d565f882208db7ffe7dab7.pdf','application/pdf',5,''),(1192,1186,'portal','','','','','','','해외정보 소식','1',2,'','','',16,'IMPA 총회 참가 보고서 / 최영식','26','54_26.pdf','07d1b54515813301b41f2e42154107ff.pdf','application/pdf',6,''),(1193,1186,'portal','','','','','','','특집','1',2,'','','',16,'월드투게더 캄보디아 심장병 어린이 돕기 / 주문희','34','54_34.pdf','2d366346d08e793d2102895323074e87.pdf','application/pdf',7,''),(1194,1186,'portal','','','','','','','도선논단','1',2,'','','',16,'선박충돌사고에서 항법규정의 적용에 관한 고찰 / 박성일','40','54_40.pdf','8219bb51cc312854f60de93b20b4ef0c.pdf','application/pdf',8,''),(1195,1186,'portal','','','','','','','도선논단','1',2,'','','',16,'항법적용 시점에 관한 소고 / 이창희','56','54_56.pdf','1bac263a43f170b23d11b05714a5a426.pdf','application/pdf',9,''),(1196,1186,'portal','','','','','','','도선논단','1',2,'','','',16,'2012년 INTERCO-COLREG Whistle / 우병구','62','54_62.pdf','8ab55b0a2e53d6af4f3bc315e9bdd89e.pdf','application/pdf',10,''),(1197,1186,'portal','','','','','','','특별기획','1',2,'','','',16,'도선현장을 가다 (인천항을 찾아서) / 최재원','70','54_70.pdf','fe06354f909524c7d0354cd061a6f104.pdf','application/pdf',11,''),(1198,1186,'portal','','','','','','','특별기획','1',2,'','','',16,'도선 인터뷰 (인천항 진노석 도선사) / 최재원','78','54_78.pdf','0707e8d3da31c0857a885dc54476f3d2.pdf','application/pdf',12,''),(1199,1186,'portal','','','','','','','특별기획','1',2,'','','',16,'인천지방항만청 허삼영 항만물류과장 인터뷰 / 최재원','83','54_83.pdf','d8b4275ee10f9d6febbca870a4b3272b.pdf','application/pdf',13,''),(1200,1186,'portal','','','','','','','특별기획','1',2,'','','',16,'인천항 해상교통관제센터 방문기 / 최재원','84','54_84.pdf','d833953af279b98ca1dace5710ab2f5c.pdf','application/pdf',14,''),(1201,1186,'portal','','','','','','','도선기고','1',2,'','','',16,'나의 커다란 Innisfree / 김상래','86','54_86.pdf','6242924e90b41cb28c3c072d08d25969.pdf','application/pdf',15,''),(1202,1186,'portal','','','','','','','도선기고','1',2,'','','',16,'도선수습생 도전기 / 강대하','88','54_88.pdf','8617bc25689999b3fb402f2bf7549b30.pdf','application/pdf',16,''),(1203,1186,'portal','','','','','','','도선기고','1',2,'','','',16,'갑과 乙 / 정성화 ','94','54_94.pdf','6a3c01aa88438297ae4a9d5e78f70e5f.pdf','application/pdf',17,''),(1204,1186,'portal','','','','','','','도선기고','1',2,'','','',16,'런던, 내셔널 갤러리 / 박희숙','96','54_96.pdf','c9b585c3d47e78b433b6814e694f3fb6.pdf','application/pdf',18,''),(1205,1186,'portal','','','','','','','Pilot Now','1',2,'','','',16,'협회 및 지회 소식','104','54_104.pdf','76bf70e4e490fef1725c6b04c0dfe30c.pdf','application/pdf',20,''),(1206,1186,'portal','','','','','','','관련단체 소식','1',2,'','','',16,'알림 (News)','114','54_114.pdf','88b421ca2ad5a2433283e4c7f6c3c885.pdf','application/pdf',21,''),(1207,1186,'portal','','','','','','','편집후기','1',2,'','','',16,'편집후기','118','54_118.pdf','eeb2c037d276288d18488dbb87c749ac.pdf','application/pdf',22,''),(1208,0,'portal','2013','07','25','여름호','한국도선사협회','D01','','1',1,'2013 여름호 도선지(통권55호)','','magzine_tit_1263.jpg',15,'','','','','',1,''),(1209,1208,'portal','','','','','','','권두언','1',2,'','','',15,'최규성 (국회 농림축산식품해양수산위원장)','4','P4.pdf','7b26f00d1e16ebe6133761504483609b.pdf','application/pdf',1,''),(1210,1208,'portal','','','','','','','권두언','1',2,'','','',15,'이윤재 (한국선주협회 회장)','6','P6.pdf','846ee6f1be2fd1c086be5380703a63d5.pdf','application/pdf',2,''),(1211,1208,'portal','','','','','','','Photo News','1',2,'','','',15,'사진으로 보는 협회동정','10','P10.pdf','3f1e8e5de7373452f501276c78b5f55d.pdf','application/pdf',3,''),(1212,1208,'portal','','','','','','','특집','1',2,'','','',15,'한국심장재단 심장병 어린이 돕기 - 편집실','14','P14.pdf','8802fce6b444c9b09ba89d2e35d45450.pdf','application/pdf',4,''),(1213,1208,'portal','','','','','','','특집','1',2,'','','',15,'Healthy 레져(마라톤) - 편집실','20','P20.pdf','14a6a430fbb87febeea25313665ad57f.pdf','application/pdf',5,''),(1214,1208,'portal','','','','','','','특집','1',2,'','','',15,'Ocean Histoty - 문성혁(세계해사대학교 교수)','24','P24.pdf','5bee66bab38b0afb4dda5e3d31aa1e46.pdf','application/pdf',6,''),(1215,1208,'portal','','','','','','','도선논단','1',2,'','','',15,'수정 Zig-zag 조타법에 관한 연구 - 우병구(한국해양수산연수원 교수)','26','P26.pdf','2784b10a0d4b3dc37fa9a2cbaf1aacf8.pdf','application/pdf',7,''),(1216,1208,'portal','','','','','','','도선논단','1',2,'','','',15,'예인선열의 조종능력제한여부 판단 기준 - 이창희(목포해양대학교 교수)','38','P38.pdf','cbe5cbf91721275110484bb67f48666a.pdf','application/pdf',8,''),(1217,1208,'portal','','','','','','','도선논단','1',2,'','','',15,'안전한 선박조선을 위한 요소 - 김상래(동해항 도선사)','46','P46.pdf','137ab340917ad59427ff3056ba66bfa0.pdf','application/pdf',9,''),(1218,1208,'portal','','','','','','','특별기획','1',2,'','','',15,'도선현장을 가다 - 최재원','56','P56.pdf','d7a0b0e20510e8bf0f9e18f99e34d2cf.pdf','application/pdf',10,''),(1219,1208,'portal','','','','','','','특별기획','1',2,'','','',15,'도선 인터뷰 - 평택항 양재갑 도선사','64','P64.pdf','36203d208e7f36ba6a350580ede19392.pdf','application/pdf',11,''),(1220,1208,'portal','','','','','','','특별기획','1',2,'','','',15,'평택지방해양항만청 김광용 청장 인터뷰 - 최재원','68','P68.pdf','505cdeadeeb9d8009a303dd38611f5c5.pdf','application/pdf',12,''),(1221,1208,'portal','','','','','','','도선기고','1',2,'','','',15,'계사년의 그녀 - 박성일(목포해양대학교 교수)','72','P72.pdf','ccdd713f6d7ba139d860ab6bc19d73a4.pdf','application/pdf',13,''),(1222,1208,'portal','','','','','','','도선기고','1',2,'','','',15,'철새기행 - 김동정(여행작가)','74','P74.pdf','a46d8f99c20e4f3366383101e4f5c1f6.pdf','application/pdf',14,''),(1223,1208,'portal','','','','','','','도선기고','1',2,'','','',15,'뉴욕 메트로폴리탄 미술관 - 박희숙(서양미술작가)','78','P78.pdf','30b8ff4829f48abf159559c0b7c776d9.pdf','application/pdf',15,''),(1224,1208,'portal','','','','','','','Pilot Now','1',2,'','','',15,'협회 및 지회·회원 소식','82','P82.pdf','a2a6ac99cb1d8e09830128a041c900f0.pdf','application/pdf',16,''),(1225,1208,'portal','','','','','','','News','1',2,'','','',15,'관련단체 소식','96','P96.pdf','ccdbb538ed18566a53c52d783719c333.pdf','application/pdf',17,''),(1226,1208,'portal','','','','','','','편집후기','1',2,'','','',15,'편집후기','100','P100.pdf','995500b0a127be4c65278f3c662d21c4.pdf','application/pdf',18,''),(1227,0,'portal','2014','01','17','신년호','한국도선사협회','D01','','1',1,'2014 신년호 도선지(통권56호)','','magzine_tit_1282.jpg',14,'','','','','',1,''),(1228,1227,'portal','','','','','','','신년사','1',2,'','','',14,'나종팔 (한국도선사협회장)','4','4p.pdf','278dd984813f3ade794efd785cc81e79.pdf','application/pdf',1,''),(1229,1227,'portal','','','','','','','신년사','1',2,'','','',14,'윤진숙 (해양수산부장관)','8','8p.pdf','17c2bd13dd8e5ac3a251bb7704b9cc8e.pdf','application/pdf',2,''),(1230,1227,'portal','','','','','','','권두언','1',2,'','','',14,'윤학배 (중앙해양안전심판원장)','12','12p.pdf','030c7ed2f96008bf06e586591e100f39.pdf','application/pdf',3,''),(1231,1227,'portal','','','','','','','Photo News','1',2,'','','',14,'사진으로 보는 협회동정 - 편집실','18','18p.pdf','9640379d47f7f3f72fafbae198057843.pdf','application/pdf',4,''),(1232,1227,'portal','','','','','','','특집','1',2,'','','',14,'한국도선사협회 사회나눔 활동 - 편집실','22','2014_신년_특집.pdf','7bef36ec6c19160510950e7ae05b919b.pdf','application/pdf',5,''),(1233,1227,'portal','','','','','','','특집','1',2,'','','',14,'Healthy Leisure (자전거 Riding) - 편집실','28','28p.pdf','6b98b3fecea154057471142466bfa8c1.pdf','application/pdf',6,''),(1234,1227,'portal','','','','','','','특집','1',2,'','','',14,'Ocean History - 문성혁 (세계해사대학교 교수)','34','34p.pdf','b1291d8bda881e8364364c4b1dfe762e.pdf','application/pdf',7,''),(1235,1227,'portal','','','','','','','특별기획','1',2,'','','',14,'도선현장을 가다 - 여수·광양항 김정태 도선사','36','36p.pdf','8aa95b210f7422b11bfd61bdb585f6c7.pdf','application/pdf',8,''),(1236,1227,'portal','','','','','','','특별기획','1',2,'','','',14,'여수지방해양항만청 김부기 항만물류과장 인터뷰','46','46p.pdf','528c729b009744ad42b155c710f84992.pdf','application/pdf',9,''),(1237,1227,'portal','','','','','','','도선논단','1',2,'','','',14,'Report on Safe Tug Procedures - 최영식 (인천항 도선사)','50','50p.pdf','ecf67c6ae611d7d8ddc1959572d67f69.pdf','application/pdf',10,''),(1238,1227,'portal','','','','','','','도선논단','1',2,'','','',14,'IMO 정보시스템에 대한 고찰 - 장운재 (목포해양대학교 교수)','58','58p.pdf','9ab4115defa8c7e1d87255c90cbb20da.pdf','application/pdf',11,''),(1239,1227,'portal','','','','','','','도선기고','1',2,'','','',14,'사랑의 도시락 - 정병일 (울산항 도선수습생)','70','70p.pdf','9824925729870462541cd1a1624c9c99.pdf','application/pdf',12,''),(1240,1227,'portal','','','','','','','도선기고','1',2,'','','',14,'먹는 즐거움 - 박희숙 (서양미술작가)','76','76p.pdf','380a3ddaba2c057c05132f4d616d8c0f.pdf','application/pdf',13,''),(1241,1227,'portal','','','','','','','도선기고','1',2,'','','',14,'가을 그리고 바이올린 - 채희숙 (부산항 김수룡 도선사 아내)','80','80p.pdf','ee7e2b9825b1cbae5f8106e070b26e6a.pdf','application/pdf',14,''),(1242,1227,'portal','','','','','','','Pilot Now','1',2,'','','',14,'협회 및 지회·회원 소식','84','2014_신년_나우.pdf','f5e44265c93be03a351bb30e2117265d.pdf','application/pdf',15,''),(1243,1227,'portal','','','','','','','관련단체 소식','1',2,'','','',14,'관련단체 소식','98','98p.pdf','5b67b8497d7b37c903522ba961c5204a.pdf','application/pdf',16,''),(1244,1227,'portal','','','','','','','편집후기','1',2,'','','',14,'편집후기','104','104p.pdf','5ab902941113651372409ab84a357bdd.pdf','application/pdf',17,''),(1245,0,'portal','2014','07','18','여름호','한국도선사협회','D01','','1',1,'2014 여름호 도선지(통권57호)','','magzine_tit_1300.jpg',13,'','','','','',1,''),(1246,1245,'portal','','','','','','','권두언','1',2,'','','',13,'임재택 / 한국해기사협회 회장','4','도선지57호_권두언.pdf','a4485b5a42e81c7ae28131a2193ce266.pdf','application/pdf',1,''),(1247,1245,'portal','','','','','','','Photo News','1',2,'','','',13,'사진으로 보는 협회동정 / 편집실','6','도선지57호_포토뉴스.pdf','b19d8b0160ed0fce10fecf443113c780.pdf','application/pdf',2,''),(1248,1245,'portal','','','','','','','특집','1',2,'','','',13,'Ocean History / 문성혁 세계해사대학 교수','10','도선지57호_특집-Ocean history.pdf','83ea364d95ef9cc65838f2b94f325a51.pdf','application/pdf',3,''),(1249,1245,'portal','','','','','','','특집','1',2,'','','',13,'장학생 해외유학 수기 1,2 / 편집실','12','도선지57호_특집-장학생 해외유학수기.pdf','3df3bd1388fff46eb10558455eb1abdb.pdf','application/pdf',4,''),(1250,1245,'portal','','','','','','','특집','1',2,'','','',13,'해양대학생이 묻습니다 / 편집실','18','도선지57호_특집-해양대학생이묻습니다.pdf','dbe8e1ba000f8915a60ef669ad9fb9eb.pdf','application/pdf',5,''),(1251,1245,'portal','','','','','','','해외정보 소식','1',2,'','','',13,'2015년 IMO 회의 일정 / 편집실','27','도선지57호_2015년IMO회의일정.pdf','7a1a5df732da35e9a6f7c33735216ba5.pdf','application/pdf',6,''),(1252,1245,'portal','','','','','','','해외정보 소식','1',2,'','','',13,'제22차 IMPA 총회 참가 보고서 / 곽상민 도선사','28','도선지57호_해외정보-제22차IMP총회참가보고서.pdf','74b1e3cc8a5d69a39e1d55d73d599cf3.pdf','application/pdf',7,''),(1253,1245,'portal','','','','','','','특별기획','1',2,'','','',13,'도선현장을 가다 / 편집실','42','도선지57호_특별기획-도선현장을가다.pdf','924ab5c36c5431dff2cd5c5c3507273f.pdf','application/pdf',8,''),(1254,1245,'portal','','','','','','','특별기획','1',2,'','','',13,'도선 인터뷰 (포항항 석정태 도선사) / 편집실','47','도선지57호_특별기획-도선인터뷰.pdf','7739709ae0560cbcf4590bcd1464ffe6.pdf','application/pdf',9,''),(1255,1245,'portal','','','','','','','특별기획','1',2,'','','',13,'포항항 해상교통관제센터(VTS) 방문기 / 편집실','52','도선지57호_특별기획-포항항VTS방문기.pdf','8fb3d06cf0db74a2e32ec198d93c7092.pdf','application/pdf',10,''),(1256,1245,'portal','','','','','','','특별기획','1',2,'','','',13,'포항항을 찾아서 / 편집실','56','도선지57호_특별기획-포항항을 찾아서.pdf','4678946f6f787c309936ff5c3edb3765.pdf','application/pdf',11,''),(1257,1245,'portal','','','','','','','특별기획','1',2,'','','',13,'포항여행 / 편집실','59','도선지57호_특별기획-포항여행.pdf','8271aeaba9c8d7d1076a3c080663bddf.pdf','application/pdf',12,''),(1258,1245,'portal','','','','','','','도선논단','1',2,'','','',13,'선박소유권 및 선박소유자에 관한 준거법 / 박장희 도선사','62','도선지57호_도선논단-선박소유권및선박소유자에관한준거법.pdf','c2fb9d3c278b71d180355f20c860d4e5.pdf','application/pdf',13,''),(1259,1245,'portal','','','','','','','도선기고','1',2,'','','',13,'유능한 도선사 확보 방안 마련해야 / 지상원 한국해양대학 교수','84','도선지57호_도선기고-유능한도선사확보 방안마련해야.pdf','baf5831970f54ec01c7e54e11ad2ca60.pdf','application/pdf',14,''),(1260,1245,'portal','','','','','','','도선기고','1',2,'','','',13,'특별한 하루, 감사합니다 / 조윤경 관제사','86','도선지57호_도선기고-특별한하루감사합니다.pdf','320faa86250576cc3102f7e484b373f6.pdf','application/pdf',15,''),(1261,1245,'portal','','','','','','','도선기고','1',2,'','','',13,'의사 / 박희숙 서양미술작가','88','도선지57호_도선기고-의사.pdf','0850f0a13f1a4ea3383df54ad3a948fc.pdf','application/pdf',16,''),(1262,1245,'portal','','','','','','','Pilot Now','1',2,'','','',13,'협회·지회·회원 소식 / 편집실','92','도선지57호_Pilot Now.pdf','0b3a03470ed03bcc61ba1a8f8cb40fce.pdf','application/pdf',17,''),(1263,1245,'portal','','','','','','','관련단체 소식','1',2,'','','',13,'알림(News) / 편집실','102','도선지57호_Pilot News.pdf','58ba431e9a8c13028bde82ac40ab8cfa.pdf','application/pdf',18,''),(1264,1245,'portal','','','','','','','편집후기','1',2,'','','',13,'편집후기 / 편집실','106','도선지57호_편집후기.pdf','a4aafebacae74098a2be313bfd056e12.pdf','application/pdf',19,''),(1265,0,'portal','2015','01','26','신년호','한국도선사협회','D01','','1',1,'2015년 신년호(통권58호)','','magzine_tit_1320.jpg',12,'','','','','',1,''),(1266,1265,'portal','','','','','','','신년사','1',2,'','','',12,'한국도선사협회 회장 신년사 / 나종팔','4','1.한국도선사협회 회장 신년사.pdf','625bf6bae4d33390298565213a48f887.pdf','application/pdf',1,''),(1267,1265,'portal','','','','','','','신년사','1',2,'','','',12,'해양수산부 차관 신년사 / 김영석','8','2_해양수산부 차관 신년사.pdf','99246254f6b7a67901fb35b013fc6cd2.pdf','application/pdf',2,''),(1268,1265,'portal','','','','','','','권두언','1',2,'','','',12,'국회 농림축산식품해양수산위원장 권두언 / 김우남','12','3_농림축산식품해양수산위원장권두언.pdf','5b48da3d0f024ff1afddd34a50e64ade.pdf','application/pdf',3,''),(1269,1265,'portal','','','','','','','Photo News','1',2,'','','',12,'사진으로 보는 협회동정 / 편집실','14','4_Photo news.pdf','c141eee4ac0e0ac346ff82914ae80285.pdf','application/pdf',4,''),(1270,1265,'portal','','','','','','','해외정보 소개','1',2,'','','',12,'제94차 MSC 회의 및 제72차 IMPA 집행위원회 참가 보고서 / 편집실','20','5_해외정보.pdf','0e3eb6b74555d60ef488fa395061bc3e.pdf','application/pdf',5,''),(1271,1265,'portal','','','','','','','IMO 회의일정','1',2,'','','',12,'2015년 IMO 회의일정 / 편집실','27','6_IMO회의일정.pdf','7ce9028752d1f15f578a4718f351e85a.pdf','application/pdf',6,''),(1272,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'군산항을 찾아서 / 편집실','28','7_군산항을 찾아서(1).PDF','90fe3aa0ed0fb7e8b50f8a8f9b4ca399.pdf','application/pdf',7,''),(1273,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'도선현장을 가다 / 편집실','31','7_도선현장을 가다.PDF','95bac5b3427c2b60e8d3155954804758.pdf','application/pdf',8,''),(1274,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'도선 인터뷰(군산항 정수해 도선사) / 편집실','36','8_도선인터뷰.pdf','2478f1a7b4a66988347235430d2f680e.pdf','application/pdf',9,''),(1275,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'군산지방해양수산청 홍성준 항만물류과장 인터뷰 / 편집실','40','9_군산지방해양수산청 홍성준인터뷰.pdf','05dc06b0be406100516e234ed0c64231.pdf','application/pdf',10,''),(1276,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'군산항 해상교통관제센터(VTS) 방문기 / 편집실','44','10_VTS방문기.pdf','ed66ea6295ac05d5be23a75517184cc2.pdf','application/pdf',11,''),(1277,1265,'portal','','','','','','','특별기획','1',2,'','','',12,'군산여행 / 편집실','47','11_군산여행.pdf','cde9e67421826be38825356a4b06d417.pdf','application/pdf',13,''),(1278,1265,'portal','','','','','','','도선기고','1',2,'','','',12,'光風霽月(광풍제월) / 박재화(목포항 도선사)','52','12_기고-박재화.pdf','e045f07830658bff22300b2f3e1a107c.pdf','application/pdf',14,''),(1279,1265,'portal','','','','','','','도선기고','1',2,'','','',12,'미안하다 그 한마디 / 정성화(수필가)','56','13_기고-정성화.pdf','ef19f65b12b5653fd6f5bacff4651959.pdf','application/pdf',15,''),(1280,1265,'portal','','','','','','','도선기고','1',2,'','','',12,'가족의 의미 / 박희숙(서양미술작가)','58','14_기고-박희숙.pdf','81f44d637d9c170c4b7ffa2af3557111.pdf','application/pdf',16,''),(1281,1265,'portal','','','','','','','도선논단','1',2,'','','',12,'도선환경 변화에 따른 도선사 수급전망 및 제도개선 방안 / 박용안 外','62','15_도선논단.pdf','e0ccf5f427525f496860a1ed7f55634b.pdf','application/pdf',17,''),(1282,1265,'portal','','','','','','','Pilot Now','1',2,'','','',12,'협회 및 지회,회원 소식 / 편집실','74','16_Pilot now.pdf','a1fc5399607c980436c9edb9c2926701.pdf','application/pdf',18,''),(1283,1265,'portal','','','','','','','관련단체 소식','1',2,'','','',12,'알림(News) / 편집실','84','17_Pilot news.pdf','8fff923ece6b4cb4985118b278ad5aac.pdf','application/pdf',19,''),(1284,1265,'portal','','','','','','','편집후기','1',2,'','','',12,'편집후기 / 편집실','90','18_편집후기.pdf','9881e45442846c983bb200603d74544e.pdf','application/pdf',20,''),(1285,0,'portal','2015','07','24','여름호','한국도선사협회 ','D01','','1',1,'2015년 여름호(통권59호)','','magzine_tit_1342.jpg',11,'','','','','',1,''),(1286,1285,'portal','','','','','','','권두언','1',2,'','','',11,'\'해양안전\'이라는 대전제 / 박범식','4','1-권두언.pdf','81097836022ed377ed4f0a07b0810c2c.pdf','application/pdf',3,''),(1287,1285,'portal','','','','','','','Photo News','1',2,'','','',11,'사진으로 보는 협회동정 / 편집실','6','2-사진으로 보는 협회동정.pdf','a255868e6819cf8304a960fed6717700.pdf','application/pdf',4,''),(1288,1285,'portal','','','','','','','특집','1',2,'','','',11,'Ocean History : 1해리(Nautical Mile)와 1노트(Knot) / 문성혁','16','3-특집-ocean history.pdf','a216b858bbc497626e234f23c51f5296.pdf','application/pdf',5,''),(1289,1285,'portal','','','','','','','특집','1',2,'','','',11,'사회나눔활동 : 법학전문대학원 장학생 서신 / 편집실','18','2015_여름_특집.pdf','e2cf3ba51d7bab70e889336e5ae030e2.pdf','application/pdf',6,''),(1290,1285,'portal','','','','','','','도선논단','1',2,'','','',11,'도선 중인 선박의 해양사고 방지 방안에 관한 소고 / 이창희','26','6-논단-이창희.pdf','acb51180d704741af470725cbe4a232c.pdf','application/pdf',7,''),(1291,1285,'portal','','','','','','','도선논단','1',2,'','','',11,'도선사 관련 해양사고 분석을 통한 안전 도선 환경 마련에 대한 제언 / 박영수','40','7-논단-박영수.pdf','68e0489203503615c4f1650812c8060c.pdf','application/pdf',8,''),(1292,1285,'portal','','','','','','','특별기획','1',2,'','','',11,'도선현장을 가다(마산항을 찾아서) / 편집실','52','8-특별기획-마산항을찾아서(통합본).PDF','fd0aa7ebda0a6dd286dbc013e650daec.pdf','application/pdf',9,''),(1293,1285,'portal','','','','','','','특별기획','1',2,'','','',11,'도선인터뷰(마산항 이승기 도선사) / 편집실','61','10-특별기획-마산항이승기도선사.pdf','555aa81cac0fc060b7821db430770f7a.pdf','application/pdf',10,''),(1294,1285,'portal','','','','','','','특별기획','1',2,'','','',11,'마산지방해양수산청 항만물류과장 인터뷰 / 편집실','67','11-특별기획-마산지방해양수산청항만물류과장인터뷰.pdf','478a97230c913ded6cc7a9931f7ce6a8.pdf','application/pdf',11,''),(1295,1285,'portal','','','','','','','특별기획','1',2,'','','',11,'마산항 해상교통관제센터(VTS) 방문기 / 편집실','70','12-특별기획-마산항VTS방문기.pdf','d1463df7389e8998d2ae95ec3baac4c9.pdf','application/pdf',12,''),(1296,1285,'portal','','','','','','','특별기획','1',2,'','','',11,'마산여행 / 편집실','73','13-특별기획-마산여행.pdf','cfd1968ea0ebb519c51c91fb73048f86.pdf','application/pdf',13,''),(1297,1285,'portal','','','','','','','도선기고','1',2,'','','',11,'원격 무료 강좌 서비스 소개 및 고찰 / 장운재','76','14-기고-장운재.pdf','552e9fce9e7131751449f84673f41e24.pdf','application/pdf',14,''),(1298,1285,'portal','','','','','','','도선기고','1',2,'','','',11,'그림을 재미있게 보는 방법에 대해 / 박희숙','82','15-기고-박희숙.pdf','21f9842e64a392e9d63fc26077479bd9.pdf','application/pdf',15,''),(1299,1285,'portal','','','','','','','Pilot Now','1',2,'','','',11,'협회 및 지회*회원 소식 / 편집실','86','16-협회지회소식.pdf','fa73385eb06df3c64223c2cb976a97a3.pdf','application/pdf',16,''),(1300,1285,'portal','','','','','','','관련단체 소식','1',2,'','','',11,'알림(News) / 편집실','94','17-알림News.pdf','4293ae9ec7cd62b8896ec48ac4dc58e5.pdf','application/pdf',17,''),(1301,1285,'portal','','','','','','','편집후기','1',2,'','','',11,'편집후기 / 편집실','102','18-편집후기.pdf','2e5d09f9f8e862abe7789862791120f9.pdf','application/pdf',18,''),(1302,0,'portal','2016','01','25','신년호','한국도선사협회','D01','','1',1,'2016년 신년호(통권60호)','','magzine_tit_1362.jpg',10,'','','','','',1,''),(1303,1302,'portal','','','','','','','신년사','1',2,'','','',10,'한국도선사협회 회장 신년사 / 나종팔','4','1-신년사-나종팔.pdf','58ce6b0c930ba2127abd4fb6c6d33a30.pdf','application/pdf',1,''),(1304,1302,'portal','','','','','','','신년사','1',2,'','','',10,'해양수산부 장관 신년사 / 김영석','8','2-신년사-김영석.pdf','056089c941c1231ae8fdf8d6ef31367c.pdf','application/pdf',2,''),(1305,1302,'portal','','','','','','','권두언','1',2,'','','',10,'부산항만공사 사장 권두언 / 우예종','12','3-권두언-우예종.pdf','ba3f675857ef59e4782d5d4457c910f0.pdf','application/pdf',3,''),(1306,1302,'portal','','','','','','','Photo News','1',2,'','','',10,'사진으로 보는 협회동정 / 편집실','14','4-Photo News.pdf','69ffda1dc452b9fd8bc9bdeddacf0b0b.pdf','application/pdf',4,''),(1307,1302,'portal','','','','','','','IMO 회의일정','1',2,'','','',10,'2016년 IMO 회의 일정 / 편집실','20','5-2016 IMO회의일정.pdf','3c1f8376c2187b8dd54e9049338b18df.pdf','application/pdf',5,''),(1308,1302,'portal','','','','','','','해외정보 소개','1',2,'','','',10,'IMO 사무총장 임명 축하 메시지 / 편집실','21','6-임기택 축하메시지.pdf','6e61f11f1d3809de2a5e2cefcea21b19.pdf','application/pdf',6,''),(1309,1302,'portal','','','','','','','특집','1',2,'','','',10,'IMPA 2016, 서울 총회 소개 / 편집실','22','7-IMPA 서울총회소개(수정본).pdf','bf1f5aa3a00d4645f58f1c23b10b5794.pdf','application/pdf',7,''),(1310,1302,'portal','','','','','','','특집','1',2,'','','',10,'사회나눔활동 : 캄보디아 후원아동 방문(월드투게더) / 편집실','28','2016_신년_특집1.pdf','fee6c3bb9584ebca2435df8e9bc35e18.pdf','application/pdf',8,''),(1311,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'동해항을 찾아서 / 편집실','34','9-특별기획-동해항을 찾아서.pdf','ae11e6c546aeb489547c295bd70a1f8a.pdf','application/pdf',9,''),(1312,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'도선현장을 가다 / 편집실','37','10-특별기획-도선현장을가다.pdf','b04cfe51c5aa44ce1bc61e3f85c373b7.pdf','application/pdf',10,''),(1313,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'도선인터뷰(동해항 고민보 도선사) / 편집실','43','11-특별기획-도선인터뷰.pdf','4b658a42bf60d3ddfe7f7fc3e57b20b1.pdf','application/pdf',11,''),(1314,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'동해지방해양수산청 항만물류과장 인터뷰 / 편집실','50','12-특별기획-동해지방해양수산청 항만물류과장 인터뷰.pdf','874b6c32d6ecf45a6b090328a377a803.pdf','application/pdf',12,''),(1315,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'동해항 해상교통관제센터(VTS) 방문기 / 편집실','53','13-특별기획-VTS방문기.pdf','1ae893d21319893f3b0b4b1578b698a7.pdf','application/pdf',13,''),(1316,1302,'portal','','','','','','','특별기획','1',2,'','','',10,'동해여행 / 편집실','56','14-특별기획-동해여행.pdf','64d9ece6901287a9ac69a991214ff2bc.pdf','application/pdf',14,''),(1317,1302,'portal','','','','','','','도선기고','1',2,'','','',10,'명예도선사의 건강 백수 / 윤일수 ','60','15-기고-명예도선사의 건강백수.pdf','be006b25e2edf8e3cd6ace3bcd8ae31b.pdf','application/pdf',15,''),(1318,1302,'portal','','','','','','','도선논단','1',2,'','','',10,'선박조종시뮬레이터의 기본적 이해와 활용 / 허용범','66','16-도선논단-허용범.pdf','d9c333a5b4534e5b3988398cdfa0ac3a.pdf','application/pdf',16,''),(1319,1302,'portal','','','','','','','Pilot Now','1',2,'','','',10,'협회 및 지회, 회원 소식 / 편집실','78','17-Pilot Now.pdf','e89ac029eaa984b58d9910933cbba6f9.pdf','application/pdf',17,''),(1320,1302,'portal','','','','','','','관련단체 소식','1',2,'','','',10,'알림(News) / 편집실','86','18-Pilot News.pdf','76a095ca3fbbaa94348a9cea8e118b0f.pdf','application/pdf',18,''),(1321,1302,'portal','','','','','','','편집후기','1',2,'','','',10,'편집후기 / 편집실','92','19-편집후기.pdf','d7a7940271a7ea34e49108eb203a3c1d.pdf','application/pdf',19,''),(1322,0,'portal','2016','07','20','여름호','한국도선사협회','D01','','1',1,'2016년 여름호(통권61호)','','magzine_tit_1382.jpg',9,'','','','','',1,''),(1323,1322,'portal','','','','','','','권두언','1',2,'','','',9,'국제도선사협회 회장 권두언 / Capt. Simon Pelletier','4','1-권두언.pdf','0f72f6ccb1e3a62c78966b67ff4c20d5.pdf','application/pdf',1,''),(1324,1322,'portal','','','','','','','Photo News','1',2,'','','',9,'협회,지회 및 회원 소식 / 편집실','6','2-협회지회소식.pdf','a5b67e898d36e777f3a0b03dcbc9007e.pdf','application/pdf',2,''),(1325,1322,'portal','','','','','','','특집','1',2,'','','',9,'Ocean history : 톤의 기원과 재화중량톤(DWT) / 문성혁','12','3-특집-ocean history(REV).pdf','caa8f063dfca9ccd767e60ffe1184506.pdf','application/pdf',3,''),(1326,1322,'portal','','','','','','','IMO 회의일정','1',2,'','','',9,'2016년 IMO 회의 일정 / 편집실','15','4-IMO회의일정.pdf','03918a05283d57a7d10889045c6a2ceb.pdf','application/pdf',4,''),(1327,1322,'portal','','','','','','','해외정보 소개','1',2,'','','',9,'크루즈 선박 추진기(ACD\'s)에 대한 이해 / 최영식','16','5-해외정보-크루즈선박추진기에대한이해.pdf','3c28f09db08f96f88390c3f5b5a4f8d3.pdf','application/pdf',5,''),(1328,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'목포항을 찾아서 / 편집실','28','7-특별기획-목포항을찾아서.pdf','ea36435c4717c648149e2c78bf2ce85e.pdf','application/pdf',6,''),(1329,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'도선현장을 가다 / 편집실','30','8-특별기획-도선현장을가다.pdf','28f8ec6c34ae89fd11c40d3e5806c416.pdf','application/pdf',7,''),(1330,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'도선인터뷰(목포항 박재화 도선사) / 편집실','36','9-특별기획-목포항박재화도선사.pdf','dc87c2746dd43af68ade2403d4797128.pdf','application/pdf',8,''),(1331,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'목포지방해양수산청장 인터뷰 / 편집실','42','10-특별기획-목포지방해양수산청장인터뷰.pdf','362b857c93149493fa53d7d18724bda7.pdf','application/pdf',9,''),(1332,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'목포항 해상교통관제센터(VTS) 방문기 / 편집실','46','11-특별기획-목포항VTS방문기.pdf','e93b770a358a81c7d8ec8e075af38541.pdf','application/pdf',10,''),(1333,1322,'portal','','','','','','','특별기획','1',2,'','','',9,'목포여행 / 편집실','50','12-특별기획-목포여행.pdf','0880e4926dc04851956eb6335409c323.pdf','application/pdf',11,''),(1334,1322,'portal','','','','','','','도선기고','1',2,'','','',9,'인천항 도선사를 떠나면서 / 안창수','54','13-기고-안창수.pdf','161d431c24da410efe524be48813f799.pdf','application/pdf',12,''),(1335,1322,'portal','','','','','','','도선기고','1',2,'','','',9,'바깥이 되어준다는 것 / 정성화','56','14-기고-정성화.pdf','09ee21da11ed543c9e7ca2c042e44834.pdf','application/pdf',13,''),(1336,1322,'portal','','','','','','','도선논단','1',2,'','','',9,'해양사고 시 도선사의 법률적 보호방안 / 박영선','58','15-논단-박영선.pdf','66debd309dfe256b74041ef45b5b6338.pdf','application/pdf',14,''),(1337,1322,'portal','','','','','','','관련단체 소식','1',2,'','','',9,'알림(Marine News) / 편집실','68','17-마린뉴스.pdf','d38c6d19f1ab9013ef901882e9a04654.pdf','application/pdf',15,''),(1338,1322,'portal','','','','','','','편집후기','1',2,'','','',9,'편집후기 / 편집실','72','18-편집후기.pdf','0b8874906b4a70a34fc8c62b545d62bc.pdf','application/pdf',16,''),(1339,0,'portal','2017','01','23','신년호','한국도선사협회','D01','','1',1,'2017년 신년호(통권62호)','','magazine_tit_1399.jpg',8,'','','','','',1,''),(1340,1339,'portal','','','','','','','신년사','1',2,'','','',8,'해양수산부장관 신년사 / 김영석 장관 ','4','1-신년사-해양수산부장관.pdf','c4d4087de0037d612138c955ba832acd.pdf','application/pdf',1,''),(1341,1339,'portal','','','','','','','신년사','1',2,'','','',8,'한국도선사협회장 신년사 / 나종팔 회장','8','2-신년사-한국도선사협회회장.pdf','d1c8ae64c3bb45d68331c2febf744859.pdf','application/pdf',2,''),(1342,1339,'portal','','','','','','','권두언','1',2,'','','',8,'한국예선업협동조합 이사장 / 김일동 이사장','14','3-권두언.pdf','3805640555399335afdb40e8da8caecc.pdf','application/pdf',3,''),(1343,1339,'portal','','','','','','','Photo News','1',2,'','','',8,'협회,지회 및 회원 소식 / 편집실','16','4-KMPA NEWS.pdf','8818e72021297f5b4cc46f61ae52a57a.pdf','application/pdf',4,''),(1344,1339,'portal','','','','','','','특별기획','1',2,'','','',8,'부산항을 찾아서 / 편집실','22','5-특별기획-부산항을 찾아서.pdf','3129d7f624eb9e5fe36d22986e7cb8a9.pdf','application/pdf',5,''),(1345,1339,'portal','','','','','','','도선현장을 가다','1',2,'','','',8,'도선현장을 가다 / 편집실','24','6-특별기획-도선현장을 가다.pdf','7729b76a5be381cb628d683959b50ff4.pdf','application/pdf',6,''),(1346,1339,'portal','','','','','','','도선인터뷰','1',2,'','','',8,'도선인터뷰(부산항 양희준 도선사) / 편집실','31','7-특별기획-도선인터뷰.pdf','8ac30b7749ee4581d5bc87932db2dc08.pdf','application/pdf',7,''),(1347,1339,'portal','','','','','','','특별기획','1',2,'','','',8,'부산지방해양수산청 항만물류과장 인터뷰 / 편집실','38','8-특별기획-부산지방해양수산청 항만물류과장 인터뷰.pdf','e1e154834228313d9fa097caa95c310e.pdf','application/pdf',8,''),(1348,1339,'portal','','','','','','','특별기획','1',2,'','','',8,'부산신항 해상교통관제센터장(부산신항VTS) 인터뷰 / 편집실','42','9-특별기획-부산신항 해상교통관제센터장(부산신항VTS) 인터뷰.pdf','049c33fbd01f033a267473e27ccd30fc.pdf','application/pdf',9,''),(1349,1339,'portal','','','','','','','특별기획','1',2,'','','',8,'부산여행 / 편집실','46','10-특별기획-부산여행.pdf','8552a562fb6790c33f758a6d67d03cb1.pdf','application/pdf',10,''),(1350,1339,'portal','','','','','','','특집','1',2,'','','',8,'사회나눔활동 - 인천항 후원활동 / 편집실','52','11-특집-사회나눔활동-인천항 후원활동.pdf','1cb5021aef8d8dfba10d6f8d5ff775aa.pdf','application/pdf',11,''),(1351,1339,'portal','','','','','','','특집','1',2,'','','',8,'사회나눔활동 - 법학전문대학원 장학생 서신 / 편집실','53','12-특집-사회나눔활동-법학전문대학원 장학생 서신.pdf','ec662b950d1b7a9aab9b9aba2f9f6406.pdf','application/pdf',12,''),(1352,1339,'portal','','','','','','','특집','1',2,'','','',8,'사회나눔활동 - 법학전문대학원 장학생 해외유학 수기 / 편집실','54','13-특집-사회나눔활동-법학전문대학원 장학생 해외유학 수기.pdf','9e3844688c161292360e94ca2706f580.pdf','application/pdf',13,''),(1353,1339,'portal','','','','','','','특집','1',2,'','','',8,'사회나눔활동 - 심장병어린이수술지원 활동 / 편집실','57','2017_신년_특집1.pdf','f755f568fcf75a8284ef23aef1566488.pdf','application/pdf',14,''),(1354,1339,'portal','','','','','','','특집','1',2,'','','',8,'제23차 IMPA 서울 총회 보고 / 편집실','60','15-특집-제23차 IMPA 서울 총회 보고.pdf','14f0231f547074c31eaa17789e1cceaf.pdf','application/pdf',15,''),(1355,1339,'portal','','','','','','','특집','1',2,'','','',8,'제23차 IMPA 서울 총회 참가 보고서 / 편집실','76','16-특집-제23차 IMPA 서울 총회 참가 보고서.pdf','98e1401c74c85574305265be50d495a0.pdf','application/pdf',16,''),(1356,1339,'portal','','','','','','','해외정보 소개','1',2,'','','',8,'2017년 IMO 회의 일정 / 편집실','93','17-2017년 IMO 회의 일정.pdf','3df4a25267d1e326242d6d8eeb3f6c2e.pdf','application/pdf',17,''),(1357,1339,'portal','','','','','','','도선기고','1',2,'','','',8,'아량과 측은지심 / 부산항 조영세 도선사','94','18-도선기고.pdf','0ecb384681936a7920657efa90a74a2f.pdf','application/pdf',18,''),(1358,1339,'portal','','','','','','','도선논단','1',2,'','','',8,'도선안전과 부산항의 경쟁력 / 부산항 양희준 도선사','98','19-도선논단.pdf','bc8db52672fb06a6099c8deffbb589f0.pdf','application/pdf',19,''),(1359,1339,'portal','','','','','','','관련단체 소식','1',2,'','','',8,'알림(Marine News) / 편집실','102','21-마린뉴스.pdf','ebb6b7e2ca3ba845b96a66efe20afd11.pdf','application/pdf',20,''),(1360,0,'portal','2017','07','18','여름호','한국도선사협회','D01','','1',1,'2017년 여름호(통권63호)','','magzine_tit_1420.jpg',7,'','','','','',1,''),(1361,1360,'portal','','','','','','','권두언','1',2,'','','',7,'국립해양조사원장 / 이동재 원장 ','4','1-권두언.pdf','221f41adf4917afa6e31a0f081a2f009.pdf','application/pdf',1,''),(1362,1360,'portal','','','','','','','Photo News','1',2,'','','',7,'협회,지회 및 회원 소식 / 편집실','6','2-KMPA NEWS.pdf','0e3d6ee4f96fe8ceed16ce08b84d41f5.pdf','application/pdf',3,''),(1363,1360,'portal','','','','','','','특집','1',2,'','','',7,'사회나눔활동 : 협회 글로벌장학생 인터뷰 / 편집실	','14','3-특집-사회나눔활동-협회 글로벌장학생 인터뷰.pdf','1c87dc2be6a92bfa2e40cfc98b3e2ac1.pdf','application/pdf',4,''),(1364,1360,'portal','','','','','','','특집','1',2,'','','',7,'사회나눔활동 : 지회별 후원활동 / 편집실	','17','4-특집-사회나눔활동-지회별 후원활동.pdf','a24c85fda1e85042311d47260938161b.pdf','application/pdf',5,''),(1365,1360,'portal','','','','','','','특집','1',2,'','','',7,'새롭게 개정되는 도선법 소개 / 편집실','18','5-특집-새롭게 개정되는 도선법 소개.pdf','f8ad48bf48f2bb1c167708a548be040b.pdf','application/pdf',6,''),(1366,1360,'portal','','','','','','','해외정보 소식','1',2,'','','',7,'2017년 IMO 회의 일정 / 편집실','24','6-2017년 IMO 회의 일정.pdf','297888597446c03a578e62c3dfbd2886.pdf','application/pdf',7,''),(1367,1360,'portal','','','','','','','해외정보 소식','1',2,'','','',7,'IMPA 캠페인 / 편집실','25','7-IMPA 캠페인.pdf','428a92f6851683b853ad14d8bab52725.pdf','application/pdf',8,''),(1368,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'울산항을 찾아서 / 편집실','26','8-특별기획-울산항을 찾아서.pdf','e037fcfa3ff94084173bcc969a5962ee.pdf','application/pdf',9,''),(1369,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'도선현장을 가다 / 편집실','28','9-특별기획-도선현장을 가다.pdf','3eed80450bf80954db212cb3670718e6.pdf','application/pdf',10,''),(1370,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'도선인터뷰(울산항 이병옥 도선사) / 편집실','33','10-특별기획-도선인터뷰.pdf','0afb18eb357ec572c19e2198a121de43.pdf','application/pdf',11,''),(1371,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'울산지방해양수산청 항만물류과장 인터뷰 / 편집실','40','11-특별기획-울산지방해양수산청 항만물류과장 인터뷰.pdf','b218cf38cae91aff62e8885b72f1cb19.pdf','application/pdf',12,''),(1372,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'울산항 해상교통관제센터장(VTS) 인터뷰 / 편집실','45','12-특별기획-울산항 해상교통관제센터장(VTS) 인터뷰.pdf','d1c54548c12cec9c1c9b4414760b2edf.pdf','application/pdf',13,''),(1373,1360,'portal','','','','','','','특별기획','1',2,'','','',7,'울산여행 /편집실','49','13-특별기획-울산여행.pdf','f9eff9e8df6aee305cbf390b38528154.pdf','application/pdf',14,''),(1374,1360,'portal','','','','','','','도선기고','1',2,'','','',7,'도선사 예찬 / 이재우 명예교수','54','','','',15,''),(1375,1360,'portal','','','','','','','도선논단','1',2,'','','',7,'도선사의 역할과 해상안전 / 박성일 교수','64','16-도선논단-도선사의 역할과 해상안전.pdf','2f267c3afa3ae2684b6892dba8719f7c.pdf','application/pdf',16,''),(1376,1360,'portal','','','','','','','도선논단','1',2,'','','',7,'선박통항과 접안 안정성에 관한 실증적 연구 / 윤병원 도선사','69','17-도선논단-선박통항과 접안 안정성에 관한 실증적 연구.pdf','6b5e0fb742d0a1cca547c301e96c0744.pdf','application/pdf',17,''),(1377,1360,'portal','','','','','','','관련단체 소식','1',2,'','','',7,'알림(Marine News) / 편집실','120','','','',18,''),(1378,1360,'portal','','','','','','','편집후기','1',2,'','','',7,'편집후기 / 편집실','124','19-편집후기.pdf','9e78ee2fc913c54d11f14f6ada5d6b14.pdf','application/pdf',19,''),(1379,1360,'portal','','','','','','','기타','1',2,'','','',7,'원고모집안내 / 편집실','63','15-원고모집.pdf','75ec3a701c7adf3116d858fbdaa33df9.pdf','application/pdf',20,''),(1380,0,'portal','2018','01','15','신년호','한국도선사협회','D01','','1',1,'2018년 신년호(통권64호)','','magzine_tit_1441.jpg',6,'','','','','',1,''),(1381,1380,'portal','','','','','','','신년사','1',2,'','','',6,'한국도선사협회장 신년사 / 나종팔 회장','4','신년사_ 한국도선사협회 회장.pdf','d1998291899f60b9ccc90e91ef9c9c8e.pdf','application/pdf',1,''),(1382,1380,'portal','','','','','','','신년사','1',2,'','','',6,' 해양수산부 장관 신년사 / 김영춘 장관','8','신년사_해양수산부 장관.pdf','6bf5122744df5a2257390aefd34d1a9a.pdf','application/pdf',2,''),(1383,1380,'portal','','','','','','','권두언','1',2,'','','',6,'해양경찰청장 권두언 / 박경민 청장','12','권두언_해양경찰청장.pdf','ae9f403c9fb7a3a7c541dbb63b4339c7.pdf','application/pdf',3,''),(1384,1380,'portal','','','','','','','Photo News','1',2,'','','',6,'협회,지회 및 회원 소식 / 편집실','14','KMPA NEWS_협회-지회-회원소식.pdf','74b88de6fa223ba55c8d1eec10a91316.pdf','application/pdf',4,''),(1385,1380,'portal','','','','','','','특집','1',2,'','','',6,'사회나눔활동 : 법학전문대학원 지원소개 / 편집실','28','','','',5,''),(1386,1380,'portal','','','','','','','해외정보 소식','1',2,'','','',6,'제1차 아시아도선사포럼 참가 보고 / 박행진 도선사','30','해외정보_제1차 아시아도선사포럼 참가 보고.pdf','945de2cf52f09b1ade423f7c7f7c5b81.pdf','application/pdf',6,''),(1387,1380,'portal','','','','','','','해외정보 소식','1',2,'','','',6,'2018년 IMO 회의 일정 / 편집실','36','해외정보_IMO회의일정.pdf','ba9c88283f935587bf084a24fd4e4820.pdf','application/pdf',7,''),(1388,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'대산항을 찾아서 / 편집실','38','특별기획_대산항을 찾아서.pdf','cb9ba2264b298c250c925d9794283546.pdf','application/pdf',8,''),(1389,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'도선현장을 가다 / 편집실','40','특별기획_도선현장을 가다.pdf','f78ce34690e1405411adf6e1ea22d1b5.pdf','application/pdf',9,''),(1390,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'도선인터뷰(대산항 임연희 도선사) / 편집실','46','특별기획_도선 인터뷰(대산항 임연희도선사).pdf','f6bd2190fd5d0246b3114e24d7020f60.pdf','application/pdf',10,''),(1391,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'대산지방해양수산청 항만물류과장 인터뷰 / 편집실','52','특별기획_대산지방해양수산청 항만물류과장 인터뷰.pdf','57b0eaa1e5f95e843cdd4eb6080c9b93.pdf','application/pdf',11,''),(1392,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'대산항 해상교통관제센터장(VTS) 인터뷰 / 편집실','57','특별기획_대산항 해상교통관제센터장(대산항VTS) 인터뷰.pdf','6db0b949287781f9e47e2e8282160eaf.pdf','application/pdf',12,''),(1393,1380,'portal','','','','','','','특별기획','1',2,'','','',6,'대산여행 /편집실','60','특별기획_대산여행.pdf','ca24187a15107df2577cf5dfbf0e2f48.pdf','application/pdf',13,''),(1394,1380,'portal','','','','','','','도선기고','1',2,'','','',6,'나의 아프락삭스 / 강원호 도선사','65','도선기고_나의 아프락삭스.pdf','e8707e6dcd30284a6694f511e2234067.pdf','application/pdf',14,''),(1395,1380,'portal','','','','','','','도선기고','1',2,'','','',6,'말은 입체다 / 정성화 작가','72','도선기고_말은 입체다.pdf','d762d40f2d6fd88985b607607a373b18.pdf','application/pdf',15,''),(1396,1380,'portal','','','','','','','도선논단','1',2,'','','',6,'우리 도선구의 예선마력 사용기준은 적정한가? / 최영식 도선사','74','도선논단_우리 도선구의 예선마력 사용기준은 적정한가.pdf','0cba50b4ec59027929345ffb3f2dc2c5.pdf','application/pdf',16,''),(1397,1380,'portal','','','','','','','관련단체 소식','1',2,'','','',6,'알림(Marine News) / 편집실','78','Marine NEWS_관련단체 소식.pdf','ffe47c1bfd37cb4188b7d4a26b479736.pdf','application/pdf',17,''),(1398,1380,'portal','','','','','','','편집후기','1',2,'','','',6,'편집후기 / 편집실','82','편집후기.pdf','3dd1bd544dfd5ec7c168a65d1984d67b.pdf','application/pdf',18,''),(1399,1380,'portal','','','','','','','기타','1',2,'','','',6,'원고모집안내 / 편집실','00','원고모집_도선지 원고모집.pdf','0930f28b577bcd6c99f32030188cfb11.pdf','application/pdf',19,''),(1400,0,'portal','2018','07','18','여름호','한국도선사협회','D01','','1',1,'2018년 여름호(통권65호)','','magzine_tit_1461.png',5,'','','','','',1,''),(1401,1400,'portal','','','','','','','권두언','1',2,'','','',5,'한국해사문제연구소 이사장 권두언 / 박현규 이사장','4','권두언-한국해사문제연구소 이사장.pdf','6c564bc484cd2347a30bbc7efab76e36.pdf','application/pdf',1,''),(1402,1400,'portal','','','','','','','권두언','1',2,'','','',5,'IMPA 사무총장 인사말 / Mr.Nick Cutmore','8','IMPA Message - IMPA사무총장 인사말.pdf','1eaa8ccf3f4e11cc78c56b8cb3314128.pdf','application/pdf',2,''),(1403,1400,'portal','','','','','','','Photo News','1',2,'','','',5,'협회,지회 및 회원 소식 / 편집실','10','KMPA NEWS - 협회 지회 회원소식.pdf','a7cb5c40f1221dbecbd54aba341046fb.pdf','application/pdf',3,''),(1404,1400,'portal','','','','','','','특집','1',2,'','','',5,'사회나눔활동 : 장학생 해외 유학 수기1,2,3','18','특집 - 사회나눔활동_장학생 해외 유학수기 123.pdf','dcdccd6ea5afda372c0499c5993c9024.pdf','application/pdf',4,''),(1405,1400,'portal','','','','','','','해외정보 소식','1',2,'','','',5,'제24차 IMPA 총회 참가 보고서 / 곽상민 도선사','28','해외정보 - 제24차 IMPA총회 참가 보고서.pdf','bd3ac165c684b9db1e1b5aba17f4f1f3.pdf','application/pdf',5,''),(1406,1400,'portal','','','','','','','해외정보 소식','1',2,'','','',5,'2018년 하반기 IMO & IMPA 회의 일정 / 편집실','41','해외정보 - IMO & IMPA 회의 일정.pdf','c4e7bdc0b8d5ae3d12092ca2fa2186e6.pdf','application/pdf',6,''),(1407,1400,'portal','','','','','','','해외정보 소식','1',2,'','','',5,'제19차 IALA 컨퍼런스 참가 보고서 / 강을규, 최영식 도선사','42','해외정보 - 제19차 IALA 컨퍼런스 참가 보고서.pdf','f65ead8271247336f25e3a2d4c66edff.pdf','application/pdf',7,''),(1408,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'인천항을 찾아서 / 편집실','52','특별기획 - 인천항을 찾아서.pdf','6abbc64bd13e33d2bd1592e3cdbffad7.pdf','application/pdf',8,''),(1409,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'도선현장을 가다 / 편집실','56','특별기획 - 도선현장을 가다.pdf','2dc39dbb254ec157d4fbf2cd5fb5d4e8.pdf','application/pdf',9,''),(1410,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'도선인터뷰 (인천항 옥덕용 도선사) / 편집실','63','특별기획 - 도선인터뷰(인천항 옥덕용 도선사).pdf','f3b1b32d530eea16181ed3ecf16adfd8.pdf','application/pdf',10,''),(1411,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'인천지방해양수산청항만물류과장 인터뷰 / 편집실','70','특별기획 - 인천지방해양수산청 항만물류과장.pdf','c71a687d7a35ed74bd41930aa70fb4b0.pdf','application/pdf',11,''),(1412,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'인천항 해상교통관제센터장 인터뷰 / 편집실 ','73','특별기획 - 인천항 해상교통관제센터장(인천항VTS).pdf','8645d5a7535b614ef9c5fb7e6b3333f2.pdf','application/pdf',12,''),(1413,1400,'portal','','','','','','','특별기획','1',2,'','','',5,'인천여행 / 편집실','76','특별기획 - 인천여행.pdf','c2ea5a94e98476c5e637ac298e156776.pdf','application/pdf',13,''),(1414,1400,'portal','','','','','','','도선기고','1',2,'','','',5,'시간 / 조영세 도선사','82','도선기고 - 시간.pdf','a58f3b95de79b50ca6e1fb4235788797.pdf','application/pdf',14,''),(1415,1400,'portal','','','','','','','도선기고','1',2,'','','',5,'별 볼 일 없는 밤 / 여수항 선박팀 김재창 ','86','도선기고 - 별 볼 일 없는 밤.pdf','dcf8327a0f1fedbeadc5059c7526c949.pdf','application/pdf',15,''),(1416,1400,'portal','','','','','','','도선논단','1',2,'','','',5,'위험한 도선사 사다리에 대한 딜레마 / 최영식 도선사','90','도선논단 - 위험한 도선사 사다리에 대한 딜레마.pdf','ec94581382dd8a85ff3288e49d753a70.pdf','application/pdf',16,''),(1417,1400,'portal','','','','','','','관련단체 소식','1',2,'','','',5,'관련단체소식(Marine News) / v편집실','94','Marine NEWS - 관련단체 소식.pdf','d01abf72a2c58bd410261fae91ee7df9.pdf','application/pdf',17,''),(1418,1400,'portal','','','','','','','편집후기','1',2,'','','',5,'편집후기 / 편집실','98','편집후기.pdf','8d5a9a4e09df18cc3a6ba2676c6f82dd.pdf','application/pdf',18,''),(1419,0,'portal','2019','01','15','신년호','한국도선사협회','D01','','1',1,'2019년 신년호(통권66호)','','magzine_tit_1482.jpg',4,'','','','','',1,''),(1420,1419,'portal','','','','','','','신년사','1',2,'','','',4,'한국도선사협회장 신년사 / 임상현 회장','4','도선사_신년사_임상현회장.pdf','f3ae3f5b0d1a80c725c2efcd888abe48.pdf','application/pdf',1,''),(1421,1419,'portal','','','','','','','신년사','1',2,'','','',4,'해양수산부장관 신년사 / 김영춘 장관','8','도선사_신년사_김영춘장관.pdf','19cbebc5c48d2eb8e140c9525b56126a.pdf','application/pdf',2,''),(1422,1419,'portal','','','','','','','권두언','1',2,'','','',4,'한국해기사협회장 권두언 / 이권희 회장','12','도선사_권두언.pdf','5bed63e4c3b5cfc49c3c44bf8338a05b.pdf','application/pdf',3,''),(1423,1419,'portal','','','','','','','Photo News','1',2,'','','',4,'협회,지회 및 회원 소식 / 편집실','14','도선사_KMPA뉴스.pdf','7211fa524a1ee6c523db7cdc5bbaf2de.pdf','application/pdf',4,''),(1424,1419,'portal','','','','','','','법령코너','1',2,'','','',4,'새롭게 개정되는 도선법 소개 / 편집실','20','도선사_법률정보.pdf','30f34a4dd166061ec4742df1b8c09699.pdf','application/pdf',5,''),(1425,1419,'portal','','','','','','','특집','1',2,'','','',4,'제1회 도선사진 콘테스트 / 편집실','28','도선사_특집_도선사진.pdf','bdc0bc30771a65230a88a99fcb33b853.pdf','application/pdf',6,''),(1426,1419,'portal','','','','','','','특집','1',2,'','','',4,'은퇴후의 삶 : 어떤 여행기 / 안창수 명예도선사 ','34','도선사_특집_어떤여행기.pdf','3fad636f5312b1bb2ac60b2d3443d032.pdf','application/pdf',7,''),(1427,1419,'portal','','','','','','','특별기획','1',2,'','','',4,'여수광양항 / 편집실','42','도선사_특별기획_여수광양항을찾아서.pdf','f4d2d33317c84dbcf2412227a696fc80.pdf','application/pdf',8,''),(1428,1419,'portal','','','','','','','특별기획','1',2,'','','',4,'여수지방해양수산청 항만물류과장 인터뷰 / 편집실','44','도선사_특별기획_여수지방해양수산청 인터뷰.pdf','073fa4993790f6e042254b5e9591d716.pdf','application/pdf',9,''),(1429,1419,'portal','','','','','','','특별기획','1',2,'','','',4,'여수항 해상교통관제센터장(VTS) 인터뷰 / 편집실','48','도선사_특별기획_여수항 해상교통관제센터장.pdf','0fc7c76dae3499d05fe065034d59e8aa.pdf','application/pdf',10,''),(1430,1419,'portal','','','','','','','특별기획','1',2,'','','',4,'도선 현장을 가다 / 편집실','54','도선사_특별기획_도선현장을가다(통합).pdf','808924bf2d75d62072ecfd1680192658.pdf','application/pdf',11,''),(1431,1419,'portal','','','','','','','특별기획','1',2,'','','',4,'도선인터뷰 (여수항 김홍수 도선사) / 편집실','64','도선사_특별기획_도선인터뷰 김홍수도선사.pdf','439c6fad876d89858c9126e4108a8abc.pdf','application/pdf',13,''),(1432,1419,'portal','','','','','','','해외정보 소개','1',2,'','','',4,'호주 다윈 워크숍 참가 보고서 / 인천항 최영식 도선사','76','도선사_해외정보_호주도선사 다윈.pdf','8a9d84d57ad9709ed310687d47b22e85.pdf','application/pdf',14,''),(1433,1419,'portal','','','','','','','해외정보 소개','1',2,'','','',4,'2019년 IMP&IMPA 회의 일정 / 편집실','80','도선사_해외정보_주요일정.pdf','5864882f07f0e7676b72ba6f89c01079.pdf','application/pdf',15,''),(1434,1419,'portal','','','','','','','도선기고','1',2,'','','',4,'설리 허드슨강의 기적 / 여수항 이종열 도선사','82','도선사_도선기고_허드슨강.pdf','5ce69c42e3ef12ea057e8bf705fd6f41.pdf','application/pdf',16,''),(1435,1419,'portal','','','','','','','도선기고','1',2,'','','',4,'국민의 안전, 해상에서의 정보 혁명을 위해 / 한국형이네비 사업단장 이한진','85','도선사_도선기고_한국형e-navigation.pdf','fad7aa686d04f1d472fed252231a850e.pdf','application/pdf',17,''),(1436,1419,'portal','','','','','','','관련단체 소식','1',2,'','','',4,'관련단체 소식 / 편집실','88','도선사_마린뉴스.pdf','b739438be4ab577409b3bc979c06ccac.pdf','application/pdf',18,''),(1437,1419,'portal','','','','','','','편집후기','1',2,'','','',4,'편집후기 / 편집실','92','도선사_편집후기.pdf','cda48b36bdee71b49a766f2acedb4e45.pdf','application/pdf',19,''),(1438,0,'portal','2019','07','15','여름호','한국도선사협회','D01','','1',1,'2019년 여름호(통권67호)','','magzine_tit_1502.jpg',3,'','','','','',1,''),(1439,1438,'portal','','','','','','','권두언','1',2,'','','',3,'한국선주상호보험조합 회장 권두언/ 박영안 회장 ','4','도선지67-권두언.pdf','98b9358157e532fc1b73c78991f1d49d.pdf','application/pdf',1,''),(1440,1438,'portal','','','','','','','Photo News','1',2,'','','',3,'협회뉴스 / 편집실','6','도선지67-KMPA뉴스.pdf','dc2e1992076d1764b0ad95d235efe43d.pdf','application/pdf',2,''),(1441,1438,'portal','','','','','','','해외정보 소개','1',2,'','','',3,'제81차 IMPA 집행위원회 참가 보고서 / 인천항 최영식 도선사','14','도선지67-해외정보 제81차 IMPA 집행위원회 참가 보고서.pdf','5dcba810b5bea48a281dce0902ef7f8e.pdf','application/pdf',3,''),(1442,1438,'portal','','','','','','','해외정보 소개','1',2,'','','',3,'2019년 하반기 IMP&IMPA 회의 일정 / 편집실','19','도선지67-해외정보 IMO&IMPA 하반기 회의일정.pdf','1a257fbe51d6f8109d5895df944d14c2.pdf','application/pdf',4,''),(1443,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'포항항을 찾아서 / 편집실','20','도선지67-특별기획0 포항항을 찾아서.pdf','d434729bdef16e122e20d63f21ef229c.pdf','application/pdf',5,''),(1444,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'포항지방해양수산청 항만물류과장 인터뷰 / 편집실','22','도선지67-특별기획1 포항지방해양수산청 항만물류과장 인터뷰.pdf','de6f7ecc6928185daab53faf1360f68b.pdf','application/pdf',6,''),(1445,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'포항항 해상교통관제센터장(VTS) 인터뷰 / 편집실','26','도선지67-특별기획2 포항항해상교통관제센터장 인터뷰.pdf','bea71f291997d9a45622672d12257777.pdf','application/pdf',7,''),(1446,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'도선 현장을 가다(포항항 도선 현장 취재) / 편집실','30','도선지67-특별기획3 도선 현장 취재.pdf','9181f859b332c3ef0dbb052135aaf1f8.pdf','application/pdf',8,''),(1447,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'도선인터뷰 (포항 최만택 도선사) / 편집실','36','도선지67-특별기획4_도선인터뷰.pdf','8e6a5aaf5bf672556ad75125d4e49ff5.pdf','application/pdf',9,''),(1448,1438,'portal','','','','','','','특별기획','1',2,'','','',3,'포항문화 / 편집실','42','도선지67-특별기획5 포항문화.pdf','4cb1d96f6352923bb218e6c8482d5e13.pdf','application/pdf',10,''),(1449,1438,'portal','','','','','','','도선기고','1',2,'','','',3,'서해안 기행기 : 변산반도를 다녀와서 / 부산항 박정태 도선사','48','도선지67-도선기고1 서해안기행 변산반도.pdf','f2d49a95a5a7e679f48446bc3541221f.pdf','application/pdf',11,''),(1450,1438,'portal','','','','','','','도선기고','1',2,'','','',3,'故 해봉 배순태 도선사 추모 대서사시 / 김광자 시인','60','도선지67-도선기고2 해봉 배순태 도선사 추모시.pdf','7b3b4f93956b9962b28b4ac69f18d192.pdf','application/pdf',12,''),(1451,1438,'portal','','','','','','','도선기고','1',2,'','','',3,'일본 / 부산항 조영세 도선사','66','도선지67-도선기고3 일본.pdf','f7ab72fe014bbfa10a9a24c79afd6f53.pdf','application/pdf',13,''),(1452,1438,'portal','','','','','','','관련단체 소식','1',2,'','','',3,'관련단체 소식 / 편집실','75','도선지67-마린뉴스.pdf','f13cd610230a0f559d472c81804327bd.pdf','application/pdf',14,''),(1453,1438,'portal','','','','','','','특집','1',2,'','','',3,'협회 장학활동 보고서 / 편집실','75','도선지67-협회 장학활동 보고서.pdf','ddaccd20a0c1271a569d293bab38e0c1.pdf','application/pdf',15,''),(1454,1438,'portal','','','','','','','편집후기','1',2,'','','',3,'편집후기 / 편집실','92','도선지67-편집후기.pdf','72a111f1720d1fb47bf0eca502ac0506.pdf','application/pdf',16,''),(1455,0,'portal','2020','01','15','신년호','한국도선사협회','D01','','1',1,'2020년 신년호(통권68호)	','','magazine_tit_1526.jpg',2,'','','','','',1,''),(1456,1455,'portal','','','','','','','신년사','1',2,'','','',2,'한국도선사협회장 신년사 / 임상현 회장','4','1-신년사-임상현 회장.pdf','dd6a523696306aee198d644f5164c24b.pdf','application/pdf',1,''),(1457,1455,'portal','','','','','','','신년사','1',2,'','','',2,'해양수산부장관 신년사 / 문성혁 장관','8','2-신년사-문성혁 장관.pdf','34c7cc566123d04c30db361a167b53c3.pdf','application/pdf',2,''),(1458,1455,'portal','','','','','','','권두언','1',2,'','','',2,'한국해양교통안전공단 이사장 권두언 / 이연승 이사장','14','3-권두언-이연승 이사장.pdf','659d50e89e90b05351c621287ba620f9.pdf','application/pdf',3,''),(1459,1455,'portal','','','','','','','Photo News','1',2,'','','',2,'협회,센터, 지회 및 회원 소식 / 편집실','18','4-KMPA News.pdf','333685631d2bf0a77e27abb1885c1845.pdf','application/pdf',4,''),(1460,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'마산항을 찾아서 / 편집실','28','5-마산항을 찾아서(완).pdf','67d337da9a4a205a0dc27e1a5a3161a0.pdf','application/pdf',5,''),(1461,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'도선 현장을 가다 / 편집실','30','6-도선현장을가다(완).pdf','64f592ec6ae311eb73ba938cce15acc6.pdf','application/pdf',6,''),(1462,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'도선인터뷰 (마산항 김충곤 도선사) / 편집실','42','8-도선인터뷰_마산항김충곤도선사.pdf','a75e8e25f55bfc2dc861fd36ca8fdbd4.pdf','application/pdf',7,''),(1463,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'마산지방해양수산청 항만물류과장 인터뷰 / 편집실','50','9-마산청항만물류과장 인터뷰.pdf','ef91b83df868c75aaa1dd9da2028c595.pdf','application/pdf',8,''),(1464,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'마산항 해상교통관제센터장(VTS) 인터뷰 / 편집실','54','10-마산VTS센터장 인터뷰.pdf','15dacbb33dcc15be611d91b2fe97da86.pdf','application/pdf',9,''),(1465,1455,'portal','','','','','','','특별기획','1',2,'','','',2,'통영문화 / 편집실','58','11-통영문화.pdf','8057619fcbc2dafbfc859cbc03a1eb65.pdf','application/pdf',10,''),(1466,1455,'portal','','','','','','','특집','1',2,'','','',2,'제2회 도선사진 콘테스트 / 편집실','64','12-특집 제2회도선사진콘테스트.pdf','8185b8703ba01c52b180431b5ac90dd0.pdf','application/pdf',11,''),(1467,1455,'portal','','','','','','','특집','1',2,'','','',2,'사회나눔활동(월드투게더 후원 소식) / 편집실','72','13-사회나눔활동_ 월드투게더.pdf','06bd8477c0efdfad880dc094c00ee07a.pdf','application/pdf',12,''),(1468,1455,'portal','','','','','','','도선기고','1',2,'','','',2,'재회 / 부산항 김수룡 도선사','76','14-기고-재회.pdf','9b6b2e2f64d6b4e224bd009bde924b97.pdf','application/pdf',13,''),(1469,1455,'portal','','','','','','','해외정보 소개','1',2,'','','',2,'제2차 아시아도선사포럼 참가보고서 / 여수항 이형기 도선사','82','15-해외정보_ 제2차아시아포럼보고서.pdf','cfe3995f4b0fc7547911591f23039ce3.pdf','application/pdf',14,''),(1470,1455,'portal','','','','','','','해외정보 소개','1',2,'','','',2,'2020년 IMP&IMPA 회의 일정 / 편집실','92','16-해외정보 imo impa 일정.pdf','0eb4a664072c5a1f5f4e8e8624fa8419.pdf','application/pdf',15,''),(1471,1455,'portal','','','','','','','관련단체 소식','1',2,'','','',2,'관련단체 소식 / 편집실','94','17-마린뉴스.pdf','4ad6dace658479011fbc620f283336bb.pdf','application/pdf',16,''),(1472,1455,'portal','','','','','','','편집후기','1',2,'','','',2,'편집후기 / 편집실','98','18-편집후기.pdf','fc641ddd4d7711128edf51f01c345f9b.pdf','application/pdf',17,''),(1473,0,'portal','2009','02','','','한국도선사협회','D02','','2',1,'한국도선사협회 30년사','','magzine_tit_285.gif',1,'','','','','',1,''),(1474,1473,'portal','','','','','','','','1',2,'','','',1,'발간사, 목차, 화보 ','1','0편 발간사 등.pdf','17c16625b95ecfdb49f1fa9830059595.pdf','application/pdf',1,''),(1475,1473,'portal','','','','','','','','1',2,'','','',1,'제1편 : 한국도선사협회 전사(前史)','73','제1편.pdf','fe392adb6f8392f64af2f4f0894d1093.pdf','application/pdf',2,''),(1476,1473,'portal','','','','','','','','1',2,'','','',1,'제2편 : 한국도선사협회 설립과 운영(1~3장)','97','제2편 123장.pdf','5dab75b6001eaa9f0e35afb3599ebf8a.pdf','application/pdf',3,''),(1477,1473,'portal','','','','','','','','1',2,'','','',1,'제2편 : 한국도선사협회 설립과 운영(4~7장)','146','제2편 4567장.pdf','8a2f977a5fab007509a9e050a211ed2f.pdf','application/pdf',4,''),(1478,1473,'portal','','','','','','','','1',2,'','','',1,'제3편 : 전국 도선구','215','제3편.pdf','04372d1a8a39bf5476168b12d26aec1d.pdf','application/pdf',5,''),(1479,1473,'portal','','','','','','','','1',2,'','','',1,'제4편 : 한국 도선제도의 발전방향','293','제4편.pdf','81183fa85ef41f25f4439558b09b5848.pdf','application/pdf',6,''),(1480,1473,'portal','','','','','','','','1',2,'','','',1,'제5편 : 자료, 통계','327','제5편.pdf','85a239e6dd9e41e5dfc4e46c65340e71.pdf','application/pdf',7,''),(1481,0,'portal','2020','07','01','여름호','한국도선사협회','D01','','1',1,'2020년 여름호(통권69호)','','magzine_tit_1544.jpg',1,'','','','','',1,''),(1482,1481,'portal','','','','','','','권두언','1',2,'','','',1,'(사)한국국제해운대리점협회 / 이재훈 회장','4','1.권두언_ 도선지69.pdf','7b1cd2081ce55df93d12b0ca85897668.pdf','application/pdf',1,''),(1483,1481,'portal','','','','','','','Photo News','1',2,'','','',1,'협회뉴스 / 편집실','8','2.협회뉴스_ 도선지69.pdf','ed2ed68e34b4ee395b439245333b73cf.pdf','application/pdf',2,''),(1484,1481,'portal','','','','','','','특집','1',2,'','','',1,'코로나19와 도선 / 편집실','16','3.코로나19와 도선_ 도선지69.pdf','c148f1ad8b84fabe8da6adb900780191.pdf','application/pdf',3,''),(1485,1481,'portal','','','','','','','도선기고','1',2,'','','',1,'Mariner Virus / 김수룡 명예도선사','28','4.mariner virus_ 도선지69.pdf','5b5d2d721d0ec78cddb0b5e82d657f76.pdf','application/pdf',4,''),(1486,1481,'portal','','','','','','','특집','1',2,'','','',1,'미니인터뷰 : 2020년도 신규도선사 소개(도선사 선발 안내)','32','5.미니인터뷰2020년도 도선사소개_ 도선지69.pdf','f030c2922f76a24d4cb67c97378db08a.pdf','application/pdf',5,''),(1487,1481,'portal','','','','','','','도선기고','1',2,'','','',1,'도선사시험 준비 / 마산항 박한웅 도선사','41','6.도선사시험준비_ 도선지69.pdf','9975c8dbe3319d10c23207284b9fec65.pdf','application/pdf',6,''),(1488,1481,'portal','','','','','','','특집','1',2,'','','',1,'장학활동 - 글로벌장학생 해외유학 수기 / 한국해양대 이유정 ','46','7.장학활동-글로벌장학생 해외유학수기_ 도선지69.pdf','3ff8698b0139f5b01b8628d367230cce.pdf','application/pdf',7,''),(1489,1481,'portal','','','','','','','특집','1',2,'','','',1,'장학활동 - 해사고장학생 학교생활 수기 / 부산해사고 채 원 ','50','8.장학활동-해사고장학생 학교생활수기_ 도선지69.pdf','55c81c297ec47d68feec6e047e328e74.pdf','application/pdf',8,''),(1490,1481,'portal','','','','','','','도선기고','1',2,'','','',1,'심장과 건강 / 한국심장재단 제공','56','9.심장과 건강_ 도선지69.pdf','dea7b080909eae2f7297b7d3182e19dc.pdf','application/pdf',9,''),(1491,1481,'portal','','','','','','','도선기고','1',2,'','','',1,'꿈 / 부산항 조영세 도선사','60','10.꿈_ 도선지69.pdf','7cf538ffc25b54c38c4adbbde2ca2c2f.pdf','application/pdf',10,''),(1492,1481,'portal','','','','','','','해외정보 소개','1',2,'','','',1,'IMPA SAFETY CAMPAIGN 2020 / 편집실','64','11.IMPA SAFETY CAMPAIGN2020_ 도선지69.pdf','01657c6fe31096aef59bbb4e6f280d57.pdf','application/pdf',11,''),(1493,1481,'portal','','','','','','','해외정보 소개','1',2,'','','',1,'IMO&IMPA 소식(IMPA 집행위 보고서) / 인천항 최영식 도선사','74','12.IMPA&IMO 2020_ 도선지69.pdf','14f7f4d33b6f0880dc9df5077f3b7c81.pdf','application/pdf',12,''),(1494,1481,'portal','','','','','','','법령코너','1',2,'','','',1,'최신관계법령 소개 / 편집실','78','13.최신관계법령 소개_ 도선지69.pdf','55561983fb73c625595f87466312c026.pdf','application/pdf',13,''),(1495,1481,'portal','','','','','','','관련단체 소식','1',2,'','','',1,'관련단체 소식 / 편집실','82','14.관련단체 소식_ 도선지69.pdf','d374d975bbb9a1a57f9975008898b050.pdf','application/pdf',14,''),(1496,1481,'portal','','','','','','','편집후기','1',2,'','','',1,'편집후기 / 편집실','86','15.편집후기_ 도선지69.pdf','d83bf06a92c64abd450e618e7e3a2aaa.pdf','application/pdf',15,'');






















drop table if exists `kmp_MEMBER_HONOR`;
CREATE TABLE `kmp_MEMBER_HONOR` (
  `IDX` int unsigned NOT NULL AUTO_INCREMENT COMMENT '기본키',
  `H_USER_GROUP_KEY` varchar(50) NOT NULL COMMENT '소속도선사회(부산항,여수항 등의 키값)',
  `H_USER_ID` varchar(50) NOT NULL COMMENT '아이디',
  `H_USER_NAME` varchar(50) NOT NULL COMMENT '이름',
  `H_USER_PHOTO` varchar(50) NOT NULL COMMENT '사진',
  `H_POSITION` varchar(10) NOT NULL COMMENT '명예도선사 직책',
  `H_USER_BIRTH` varchar(4) NOT NULL COMMENT '생년',
  `H_RETIRE_DATE` varchar(4) NOT NULL COMMENT '퇴직년',
  `REG_DATE` varchar(50) NOT NULL COMMENT '등록일',
  `REG_IP` varchar(30) NOT NULL COMMENT '등록자 아이피',
  PRIMARY KEY (`IDX`),
  KEY `H_USER_GROUP_KEY` (`H_USER_GROUP_KEY`,`H_USER_ID`,`H_USER_NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='명예도선사';