DROP TABLE IF EXISTS nodes;
CREATE TABLE `nodes` (
`id` int(11) unsigned NOT NULL auto_increment,
`label` varchar(25),
`parent_id` int(11) unsigned NULL,
 PRIMARY KEY (`id`)
 )  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

