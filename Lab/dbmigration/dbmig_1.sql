ALTER TABLE `dentalimplantsmi_dental`.`case_tbl` 
ADD COLUMN `case_status_cd` CHAR(1) NULL AFTER `associate_deduction_upd_dt`,
ADD COLUMN `last_upd_userid` VARCHAR(15) NULL AFTER `case_status_cd`,
ADD COLUMN `last_upd_dt` DATETIME NULL AFTER `last_upd_userid`;

DELIMITER $$
CREATE TRIGGER CASE_PROCEDURE_TXN_AFINSERT
AFTER INSERT
ON case_procedure_txn_tbl FOR EACH ROW
BEGIN
    IF NEW.procedure_start_dt <> '0000-00-00' THEN
        UPDATE case_tbl SET case_status_cd = 'T'
        WHERE case_number_id = NEW.case_number_id;
	END IF;
    IF NEW.procedure_out_to_lab_dt <> '0000-00-00' THEN
        UPDATE case_tbl SET case_status_cd = 'L'
        WHERE case_number_id = NEW.case_number_id;
	END IF;
    IF NEW.procedure_back_from_lab_dt <> '0000-00-00' THEN
        UPDATE case_tbl SET case_status_cd = 'B'
        WHERE case_number_id = NEW.case_number_id;
	END IF;
END$$