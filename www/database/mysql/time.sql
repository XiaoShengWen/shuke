-- 生活轮回
CREATE TABLE `time_loop` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `type` varchar(128) NOT NULL COMMENT '轮回类别，1工2商3文4体5政6通',
    `loop` int(10) NOT NULL COMMENT '第几次轮回',
    `phase` int(10) NOT NULL COMMENT '轮回阶段',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 计划
CREATE TABLE `time_plan` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`name` varchar(128) NOT NULL,
`type` varchar(128) NOT NULL COMMENT '计划类别，1工作2事业3生活',
`loop_id` int(10) NOT NULL DEFAULT '0',
`begin_date` varchar(128) NOT NULL,
`end_date` varchar(128) NOT NULL,
`create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
`update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 任务
CREATE TABLE `time_task` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `plan_id` int(10) NOT NULL DEFAULT '0',
    `action_num` int(10) NOT NULL DEFAULT '0' COMMENT '行为次数',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8

-- 行动 
CREATE TABLE `time_action` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `task_id` int(10) NOT NULL DEFAULT '0',
    `begin_time` int(10) NOT NULL DEFAULT '0',
    `end_time` int(10) NOT NULL DEFAULT '0',
    `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
