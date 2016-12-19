-- 小说作品信息跟踪
CREATE TABLE `novel_info` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `collect` int(10) NOT NULL DEFAULT '0',
    `click` int(10) NOT NULL DEFAULT '0',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `recommend` int(10) NOT NULL DEFAULT '0',
    `comment` int(8) NOT NULL DEFAULT '0',
    `book_id` int(12) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 小说章节成绩记录 
CREATE TABLE `novels` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(64) NOT NULL,
    `desc` varchar(64) DEFAULT '',
    `volume` smallint(5) DEFAULT '0',
    `chapter` int(10) NOT NULL DEFAULT '0',
    `collect` int(10) NOT NULL DEFAULT '0',
    `comment` int(10) DEFAULT '0',
    `reward` int(10) DEFAULT '0',
    `recommend` int(10) DEFAULT '0',
    `publish_time` varchar(64) NOT NULL DEFAULT '',
    `produce_time_num` smallint(5) NOT NULL DEFAULT '2',
    `count` int(10) NOT NULL DEFAULT '0',
    `subscribe` int(10) DEFAULT '0',
    `month_ticket` int(10) DEFAULT '0',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `end_time` varchar(64) DEFAULT '',
    `collect_show` int(10) DEFAULT '0',
    `click` int(10) DEFAULT '0',
    `auto_flag` smallint(5) DEFAULT '0',
    `book_id` int(12) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 书客PC网站显示记录
CREATE TABLE `web_info` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `start_time` varchar(64) NOT NULL,
    `end_time` varchar(64) NOT NULL,
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `second_time` varchar(64) NOT NULL,
    `time_diff` int(10) NOT NULL DEFAULT '0',
    `time_diff2` int(10) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 书客PC网站显示时间间隔
CREATE TABLE `web_novel_show_log` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `title` varchar(128) NOT NULL,
    `chapter` varchar(128) NOT NULL,
    `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
    `end_time` varchar(128) NOT NULL DEFAULT '',
    `name` varchar(64) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 书客网站推荐效果记录
CREATE TABLE `web_recommend` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `type` varchar(32) NOT NULL DEFAULT '',
    `title` varchar(64) NOT NULL DEFAULT '' COMMENT '书名',
    `author` varchar(64) NOT NULL DEFAULT '' COMMENT '作者',
    `book_id` int(10) NOT NULL DEFAULT '0' COMMENT '作品id',
    `collect` text COMMENT '收藏变化，json串格式',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `date` varchar(32) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
