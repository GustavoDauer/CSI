CREATE USER 'secinfo'@'localhost' IDENTIFIED BY 'secinfo';
GRANT ALL PRIVILEGES ON secinfo . * TO 'secinfo'@'localhost';
FLUSH PRIVILEGES;
