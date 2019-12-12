CREATE TABLE IF NOT EXISTS `gallery` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`fileNameExt` varchar(255) NOT NULL,
	`fileName` varchar(255) NOT NULL,
	`fileExt` varchar(255) NOT NULL,
	`imageType` varchar(255) NOT NULL,
	`title` varchar(255) NOT NULL,
	`descr` varchar(255) NOT NULL,
	`width` int(11) NOT NULL,
	`height` int(11) NOT NULL,
	`widthHeight` varchar(255) NOT NULL,
	`imagePath` varchar(255) NOT NULL,
	`thumb150` varchar(255),
	`thumb600` varchar(255),
	`thumb600size` varchar(255),
	PRIMARY KEY (`id`)
);