# Capstone
capstone project


copying .sql file into database

xampp control panel start apache then mysql
move Research.sql into xampp folder
open shell from xampp control panel
mysqladmin -u root -p create Research          to create database skip if it already exists
mysql -u root -p Research < Research.sql       copies .sql file into database
finished



dumping database into file 

xampp control panel start apache then mysql
open shell from xampp control panel
mysqldump -u root -p -v database > database.sql
file will be in xampp folder
