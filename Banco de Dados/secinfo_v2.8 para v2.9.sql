ALTER TABLE `secinfo`.`Equipamento` 
CHANGE COLUMN `responsavel` `responsavel` VARCHAR(250) NULL DEFAULT NULL ,
CHANGE COLUMN `problema` `problema` VARCHAR(5200) NULL DEFAULT NULL ,
CHANGE COLUMN `solucao` `solucao` VARCHAR(5200) NULL DEFAULT NULL ,
CHANGE COLUMN `observacao` `observacao` VARCHAR(2500) NULL DEFAULT NULL ;

CREATE TABLE IF NOT EXISTS `secinfo`.`Internet` (
  `login` VARCHAR(250) NULL,
  `consumo` INT NULL,
  `ip` VARCHAR(17) NULL);
