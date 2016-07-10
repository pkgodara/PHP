<?php
$servername = "localhost";
$username = "root";
$password = "pk80944";

//create connection
$conn = new mysqli($servername,$username,$password);

//check connection
if ( $conn->connect_error )
{
die("Connection failed : ".$conn->connect_error);
}
echo "Connected Successfully\n";

//create database
$db = "myDB";
$sql = "CREATE DATABASE IF NOT EXISTS ".$db ;

//check if created or not
if( $conn->query($sql) === true )
{
echo "Database \"".$db."\" created\n";
}
else
{
echo "Error creating database: ".$conn->error."\n" ;
}

//connect to database
$conn = new mysqli($servername,$username,$password,$db);
//$conn = mysqli_connect($servername,$username,$password,$db);

$table = "data";

//create table
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
date TIMESTAMP )" ;

//check table
if( $conn->query($sql) === true ) //mysql_query($conn,$sql) )
{
echo "Table \"".$table."\" Created.\n\n";
}
else
{
echo "Error creating table: ".$conn->error."\n";
}


//delete all data from table
$sql = "DELETE FROM ".$table;

if( $conn->query($sql) === TRUE )
{
echo "Table \"".$table."\" Emptied.\n";
}
else
{
echo "Error Deleting Table ".$table." Contents.\n";
}


//insert data
$sql = "INSERT INTO ".$table." (firstName,lastName,email)
 VALUES ('John','Doe','johnDoe@gmail.com')";

if( $conn->query($sql) === true )
{
echo "New Record created.\n";
}
else
{
echo "Error creating record: ".$conn->error."\n";
}

//prepare and bind
$stmt = $conn->prepare("INSERT INTO ".$table." (firstName,lastName,email) VALUES (?,?,?)");
//bind to stmt
$stmt->bind_param("sss",$firstname,$lastname,$email) ;

//set parameters and execute
$firstname = "pradeep";
$lastname = "kumar";
$email = "neveraskpass@gmail.com";
$stmt->execute() ;

$firstname = "Marry";
$lastname = "Gold";
$email = "maryGold@gmail.com";
$stmt->execute() ;

$stmt->close();

echo "\nDatabase Content : \n";

//get data from database
$sql = "SELECT id,firstName,lastName,email,date from ".$table;

$result = $conn->query($sql);

if( $result->num_rows > 0 )
{
//show output of each row
while( $row = $result->fetch_assoc() )
{
echo "Id: ".$row["id"]." ; Name : ".$row["firstName"]." ".$row["lastName"]." ; Email : ".$row["email"]." ; Registered : ".$row["date"]."\n";
}

}
else
{
echo "0 results found\n";
}

$conn->close() ;

echo "\nConnection Closed\n";

?>
