CREATE DATABASE partitura;
CREATE USER 'partitura_user' IDENTIFIED BY 'partitura_password';
GRANT ALL ON partitura.* TO 'partitura_user'@localhost IDENTIFIED BY 'partitura_password';
GRANT ALL ON partitura.* TO 'partitura_user'@172.17.0.1 IDENTIFIED BY 'partitura_password';
