
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- appointment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `appointment`;

CREATE TABLE `appointment`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `patient_id` INTEGER NOT NULL,
    `timeslot_id` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `room` INTEGER NOT NULL,
    `cost` INTEGER NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `patient_id` (`patient_id`),
    INDEX `employee_id` (`employee_id`),
    INDEX `timeslot_id` (`timeslot_id`),
    CONSTRAINT `appointment_ibfk_1`
        FOREIGN KEY (`patient_id`)
        REFERENCES `patient` (`ID`),
    CONSTRAINT `appointment_ibfk_2`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`ID`),
    CONSTRAINT `appointment_ibfk_3`
        FOREIGN KEY (`timeslot_id`)
        REFERENCES `timeslot` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bill
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `patient_id` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `due_date` VARCHAR(255) NOT NULL,
    `transaction_id` INTEGER NOT NULL,
    `cost` INTEGER NOT NULL,
    `bill_payed` bit(1) NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `patient_id` (`patient_id`),
    INDEX `employee_id` (`employee_id`),
    CONSTRAINT `bill_ibfk_1`
        FOREIGN KEY (`patient_id`)
        REFERENCES `patient` (`ID`),
    CONSTRAINT `bill_ibfk_2`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- department
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `department_name` VARCHAR(255) NOT NULL,
    `section` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- employee
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `salary` INTEGER NOT NULL,
    `department_id` INTEGER NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `date_of_birth` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `department_id` (`department_id`),
    CONSTRAINT `employee_ibfk_1`
        FOREIGN KEY (`department_id`)
        REFERENCES `department` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- employeephone
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `employeephone`;

CREATE TABLE `employeephone`
(
    `phone_number` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    PRIMARY KEY (`phone_number`),
    INDEX `employee_id` (`employee_id`),
    CONSTRAINT `employeephone_ibfk_1`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- healthhistory
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `healthhistory`;

CREATE TABLE `healthhistory`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `patient_id` INTEGER NOT NULL,
    `disease_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `patient_id` (`patient_id`),
    CONSTRAINT `healthhistory_ibfk_1`
        FOREIGN KEY (`patient_id`)
        REFERENCES `patient` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- medicine
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `medicine`;

CREATE TABLE `medicine`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `medicine_name` VARCHAR(255) NOT NULL,
    `prescription_id` INTEGER,
    PRIMARY KEY (`ID`),
    INDEX `prescription_id` (`prescription_id`),
    CONSTRAINT `medicine_ibfk_1`
        FOREIGN KEY (`prescription_id`)
        REFERENCES `prescription` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- patient
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `patient`;

CREATE TABLE `patient`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `date_of_birth` VARCHAR(255) NOT NULL,
    `insurance` VARCHAR(255),
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- patientphone
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `patientphone`;

CREATE TABLE `patientphone`
(
    `phone_number` INTEGER NOT NULL,
    `patient_id` INTEGER NOT NULL,
    PRIMARY KEY (`phone_number`),
    INDEX `patient_id` (`patient_id`),
    CONSTRAINT `patientphone_ibfk_1`
        FOREIGN KEY (`patient_id`)
        REFERENCES `patient` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- payment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `bill_id` INTEGER NOT NULL,
    `amount` INTEGER NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `bill_id` (`bill_id`),
    CONSTRAINT `payment_ibfk_1`
        FOREIGN KEY (`bill_id`)
        REFERENCES `bill` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- prescription
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `prescription`;

CREATE TABLE `prescription`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `patient_id` INTEGER NOT NULL,
    `prescription_date` VARCHAR(255) NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `cost` INTEGER NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `patient_id` (`patient_id`),
    INDEX `employee_id` (`employee_id`),
    CONSTRAINT `prescription_ibfk_1`
        FOREIGN KEY (`patient_id`)
        REFERENCES `patient` (`ID`),
    CONSTRAINT `prescription_ibfk_2`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- timeslot
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `timeslot`;

CREATE TABLE `timeslot`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `start_time` INTEGER NOT NULL,
    `end_time` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `availability` bit(1) NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `employee_id` (`employee_id`),
    CONSTRAINT `timeslot_ibfk_1`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`ID`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
