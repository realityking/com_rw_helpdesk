CREATE TABLE IF NOT EXISTS  `#__helpdesk` (
          `id` int(10) NOT NULL auto_increment,
          `hip` varchar(15) NOT NULL default '',
          `hname` varchar(40) NOT NULL default '',
          `hfname` varchar(40) NOT NULL default '',
          `hmail` varchar(60) default NULL,
          `htext` text NOT NULL,
          `hdate` datetime default NULL,
          `hcomment` text,
          `published` tinyint(1) NOT NULL default '0',
          `decline` tinyint(1) NOT NULL default '0',
          `hfac` varchar(50) default NULL,
          `hmajor` varchar(20) default NULL,
          `hfile` text NOT NULL,
          `htype` text NOT NULL,
          `hsize` int(11) NOT NULL,
          `hstatus` tinyint(3) NOT NULL default '0',
          PRIMARY KEY  (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

