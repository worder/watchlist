create table accounts (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT, 
	`email` varchar(128) UNIQUE, 
	`username` varchar(128),
	`added` datetime
);

create table credentials (
	`accountId` int(11) NOT NULL,
	`type` int(8) NOT NULL,
	`value` varchar(256) UNIQUE NOT NULL,
	`expire` datetime,
	PRIMARY KEY(`accountId`, `type`)
);

create table lists (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`title` text,
	`description` text,
	`added` datetime,
	`updated` datetime
);

create table list_subscriptions (
	`listId` int(11) NOT NULL,
	`userId` int(11) NOT NULL,
	`added` datetime NOT NULL,
	`permissions` text,
	PRIMARY KEY (`listId`, `userId`)
);

create table media (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`apiMediaId` varchar(64) NOT NULL,
	`api` varchar(64) NOT NULL,
	`type` varchar(64) NOT NULL,
	`added` datetime NOT NULL,
	`updated` datetime NOT NULL,
);

create table media_locale (
	`mediaId` int(11) NOT NULL,
	`locale` varchar(10) NOT NULL,
	`data` MEDIUMTEXT NOT NULL,
	`added` datetime NOT NULL,
	`updated` datetime NOT NULL,
	PRIMARY KEY(`mediaId`, `locale`)
);



/* draft, TODO


create table wl_items (
	`id`,
	`watchlistId`,
	`mediaId`,
	`userId`,
	`added`,
);

create table wl_item_status (
	`id`,
	`itemId`,
	`userId`,
	`status`,
	`date`,
)

create table wl_item_progress (
	`id`,
	`itemId`,
	`userId`,
	`progress`,
	`date`,
)

create table wl_item_features (
	`id`,
	`itemId`,
	`type`,
	`value`,
	`date`
)

*/