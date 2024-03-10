# Capstone
capstone project


copying .sql file into database

1. xampp control panel start apache then mysql
2. move Research.sql into xampp folder
3. open shell from xampp control panel
4. mysqladmin -u root -p create Research          to create database skip if it already exists
5. mysql -u root -p Research < Research.sql       copies .sql file into database
6. finished



dumping database into file 

1. xampp control panel start apache then mysql
2. open shell from xampp control panel
3. mysqldump -u root -p -v database > database.sql
4. file will be in xampp folder
