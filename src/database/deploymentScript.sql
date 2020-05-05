-- MySQL Script generated by MySQL Workbench
-- Thu Apr 30 17:32:30 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema capstone
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `capstone` DEFAULT CHARACTER SET latin1 ;
USE `capstone` ;

-- -----------------------------------------------------
-- Table `capstone`.`choices`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`choices` ;

CREATE TABLE IF NOT EXISTS `capstone`.`choices` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `QuestionID` INT(11) NOT NULL,
  `ChoiceText` VARCHAR(255) NOT NULL,
  `ChoiceOrder` INT(11) NOT NULL,
  `correct` TINYINT(1) NOT NULL,
  `DateModified` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 92
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`instructors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`instructors` ;

CREATE TABLE IF NOT EXISTS `capstone`.`instructors` (
  `ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`packages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`packages` ;

CREATE TABLE IF NOT EXISTS `capstone`.`packages` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(255) NULL DEFAULT NULL,
  `InstructorID` INT(11) NULL DEFAULT NULL,
  `VideoID` INT(11) NULL DEFAULT NULL,
  `DateModified` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`questions` ;

CREATE TABLE IF NOT EXISTS `capstone`.`questions` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `QuestionText` VARCHAR(3500) NOT NULL,
  `InstructorID` INT(11) NULL DEFAULT NULL,
  `Category` VARCHAR(255) NULL DEFAULT NULL,
  `DateModified` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`studentanswers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`studentanswers` ;

CREATE TABLE IF NOT EXISTS `capstone`.`studentanswers` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `StudentID` INT(11) NOT NULL,
  `PackageID` INT(11) NOT NULL,
  `QuestionID` INT(11) NOT NULL,
  `ChoiceID` INT(11) NOT NULL,
  `AnswerDate` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 158
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`students`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`students` ;

CREATE TABLE IF NOT EXISTS `capstone`.`students` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`video_questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`video_questions` ;

CREATE TABLE IF NOT EXISTS `capstone`.`video_questions` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `PackageID` INT(11) NULL DEFAULT NULL,
  `InstructorID` INT(11) NULL DEFAULT NULL,
  `VideoID` INT(11) NULL DEFAULT NULL,
  `QuestionID` INT(11) NULL DEFAULT NULL,
  `QuestionTimeStamp` DECIMAL(10,1) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `NONClLUSTERED` (`PackageID` ASC, `QuestionID` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `capstone`.`videos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `capstone`.`videos` ;

CREATE TABLE IF NOT EXISTS `capstone`.`videos` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(255) NULL DEFAULT NULL,
  `InstructorID` INT(11) NOT NULL,
  `FilePath` VARCHAR(3500) NOT NULL,
  `IsYouTube` INT(11) NOT NULL,
  `DateModified` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 70
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;