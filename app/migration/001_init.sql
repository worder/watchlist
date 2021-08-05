create table accounts (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT, 
	`email` varchar(128) UNIQUE, 
	`username` varchar(128),
	`added` datetime,
);

create table credentials (
	`accountId` int(11) NOT NULL,
	`type` int(8) NOT NULL,
	`value` varchar(256) UNIQUE NOT NULL,
	PRIMARY KEY(`accountId`, `type`),
);