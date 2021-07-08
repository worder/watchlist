create table users (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT, 
	`email` varchar(128) UNIQUE, 
	`password` varchar(100), 
	`nick` varchar(128),
	`userType` int(11),
	`authToken` varchar(100) UNIQUE
);

create table localSearchTitles (
	`sourceId` SMALLINT,
	`mediaId` int(11),
	`title` varchar(512),
	`lang` varchar(16),
)


/*create table movies (
	`id` int(11) PRIMARY KEY,
	`added` datetime,
	`title` text,
	`originalTitle` text,
	`releaseDate` varchar(32),
	`poster` text
);

create table lists (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`name` varchar(128),
	`ownerId` int(11),
	`writeByOthers` int(1) DEFAULT 0,
	`added` datetime
);

create table listItems(
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`movieId` int(11),
	`listId` int(11),
	`userId` int(11),
	`status` int(11),
	`date` datetime,
	`added` datetime
);

create table subscriptions (
	`userId` int(11),
	`listId` int(11),
	`date` datetime,
	PRIMARY KEY(`userId`, `listId`)
);
*/