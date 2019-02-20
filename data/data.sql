CREATE DATABASE IF NOT EXISTS `radio_db`;
USE `radio_db`;
CREATE TABLE `radio_db`.`radios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` VARCHAR(45) NULL,
  `allowed_locations` VARCHAR(255) NULL,
  `location` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;