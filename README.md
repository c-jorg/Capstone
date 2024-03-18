# Capstone
capstone project

getting info from database in php example
make sure apache and mysql is running in xampp control panel
$sqli = new mysqli('localhost:3306','root','','Research');
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "2022-04-01" AND "2023-03-31"';

$result = mysqli_query($sqli,$fundingYear);

if($result){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo "\n".stripslashes($row['entity_id'])." ".stripslashes($row['project_code'])." ".stripslashes($row['funding_amt'])." ".stripslashes($row['date_given'])." ".stripslashes($row['frequency'])." \n";
        }
    }
}


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
