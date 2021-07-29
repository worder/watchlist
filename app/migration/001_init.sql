create table account (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT, 
	`email` varchar(128) UNIQUE, 
	`nick` varchar(128),
);

create table authToken (
	`accountId` int(11) NOT NULL,
	`type` int(8) NOT NULL,
	`value` varchar(256) UNIQUE NOT NULL,
	PRIMARY KEY(`accountId`, `type`),
);