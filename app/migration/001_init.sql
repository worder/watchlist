create table accounts (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT, 
	`email` varchar(128) UNIQUE, 
	`username` varchar(128),
	`added` datetime
);

create table credentials (
	`accountId` int(11) NOT NULL,
	`type` int(11) NOT NULL,
	`value` varchar(256) UNIQUE NOT NULL,
	`expire` datetime,
	PRIMARY KEY(`accountId`, `type`)
);

create table lists (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`ownerId` int(11) NOT NULL,
	`title` text NOT NULL,
	`description` text,
	`added` datetime NOT NULL,
	`updated` datetime NOT NULL
);

create table list_subscriptions (
	`listId` int(11) NOT NULL,
	`userId` int(11) NOT NULL,
	`added` datetime NOT NULL,
	`permissions` text,
	PRIMARY KEY (`listId`, `userId`)
);

-- -- --
create table media_cache (
	`api` varchar(32) NOT NULL,
	`mediaId` int(11) NOT NULL,
	`locale` varchar(10) NOT NULL,
	`data` MEDIUMTEXT NOT NULL,
	`title` varchar(256),
	`added` datetime NOT NULL,
	`updated` datetime NOT NULL,
	PRIMARY KEY(`api`, `mediaId`, `locale`)
);

create table list_items (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`listId` int(11) NOT NULL,
	`api` varchar(32) NOT NULL,
	`mediaId` int(11) NOT NULL,
	`added` datetime NOT NULL
);

/* type: completed, in progress, planned etc; value can hold current episode or whatever */
create table list_item_statuses (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`itemId` int(11) NOT NULL,
	`date` datetime NOT NULL,
	`added` datetime NOT NULL,
	`type` int(11) NOT NULL,
	`value` text,
	`userId` int(11) NOT NULL
);

/* for comments, ratings etc */
create table list_item_features (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`itemId` int(11) NOT NULL,
	`userId` int(11) NOT NULL,
	`added` datetime NOT NULL,
	`type` varchar(16),
	`value` text
);