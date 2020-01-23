CREATE TABLE `images` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `date` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `plant_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL
);

CREATE TABLE `measurements` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `date` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `plant_id` int(11) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `unit` ENUM ('celsius', 'fahrenheit', 'percent') DEFAULT NULL,
  `type` ENUM ('temperature', 'humidity_soil', 'humidity_air') DEFAULT NULL
);

CREATE TABLE `plants` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date_added` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `owner_id` int(11) DEFAULT NULL,
  `status` ENUM ('green', 'yellow', 'red') DEFAULT NULL,
  `temperature_treshold` float DEFAULT NULL,
  `humidity_treshold` float DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `profile_image_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
);

CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
);

ALTER TABLE `images` ADD FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`);

ALTER TABLE `measurements` ADD FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`);

ALTER TABLE `plants` ADD FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

ALTER TABLE `plants` ADD FOREIGN KEY (`profile_image_id`) REFERENCES `images` (`id`);
