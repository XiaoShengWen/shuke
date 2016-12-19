-- 暂未使用
CREATE TABLE `control_flag` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `type` int(10) NOT NULL DEFAULT '0',
    `flag` smallint(5) NOT NULL DEFAULT '0',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 

-- 爬虫的session记录
CREATE TABLE `login_session` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `session` varchar(64) NOT NULL DEFAULT '',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 通用配置
