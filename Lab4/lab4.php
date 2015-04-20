<!-- //babbage.cs.missouri.edu/~mcpv49/cs3380/lab4/lab4.php -->
<!--table creation-->
<html>
<head/>
<body>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
  <table border="1">
     <tr><td></td><td><select name="query">
    <option value="1">Query 1</option>
    <option value="2">Query 2</option>
    <option value="3">Query 3</option>
    <option value="4">Query 4</option>
    <option value="5">Query 5</option>
    <option value="6">Query 6</option>
    <option value="7">Query 7</option>
    <option value="8">Query 8</option>
    <option value="9">Query 9</option>
  </select>
  </td></tr>
  </tr><td colspan="2" align="center"><input type="submit" name="submit" value="Execute" /></td></tr>

</table>
</form>
<!-- Start of php script-->
<?php

echo "Select a Query from the above list";

//Testing database connection
if((isset($_POST["submit"]))){
    include("../secure/database.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
    if($conn) {
    echo '<br>';
    } else {
    echo "<p>Failed to connect to DB</p>";
    }
   //Checking if the execute button is pressed and the query is 1 
   if(isset($_POST) && $_POST["query"] == "1"){
  echo '<br>';
  $query = "SELECT * FROM lab4.weight";
  $result = pg_query($conn,$query);
  $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>pid</th>';
  echo '<th> fname</th>';
  echo '<th>lname </th>';
  echo '</tr>';
//Filling table with the correct data 

  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';
    echo '<td>'.$rows[2]. '</td>';    
    echo '</tr>'; 
  }
 }
//Checking if the execute button is pressed and the query is 2
   elseif(isset($_POST) && $_POST["query"] == "2"){
  echo '<br>';
  $query = "SELECT * FROM lab4.bmi";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>fname</th>';
  echo '<th> lname</th>';
  echo '<th>round</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';  
    echo '<td>'.$rows[2]. '</td>';
    echo '</tr>'; 
  }
 }
  //Checking if the execute button is pressed and the query is 3
   elseif(isset($_POST) && $_POST["query"] == "3"){
  echo '<br>';
  $query = "SELECT u.university_name, u.city FROM lab4.university AS u WHERE NOT EXISTS(SELECT 1 FROM lab4.person as p WHERE u.uid = p.uid)";
  $result = pg_query($conn,$query);
  $rowCount = pg_num_rows($result);
 echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>university_name</th>';
  echo '<th> city</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';  
    echo '</tr>'; 
  }
  }
//Checking if the execute button is pressed and the query is 4  
   elseif(isset($_POST) && $_POST["query"] == "4"){
  echo '<br>';
  $query = "SELECT u.university_name,u.city FROM lab4.university AS u WHERE NOT EXISTS ( SELECT 1 FROM lab4.person AS p WHERE u.uid = p.uid)";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>fname</th>';
  echo '<th> lname</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';    
    echo '</tr>'; 
  }
  }
//Checking if the execute button is pressed and the query is 5  
   elseif(isset($_POST) && $_POST["query"] == "5"){
  echo '<br>';
  $query = "SELECT activity_name FROM lab4.activity WHERE activity_name NOT IN (SELECT activity_name FROM lab4.participated_in)";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>activity_name</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '</tr>'; 
  }
 }
//Checking if the execute button is pressed and the query is 6  
   elseif(isset($_POST) && $_POST["query"] == "6"){
  echo '<br>';
  $query = "SELECT pid FROM lab4.participated_in WHERE activity_name = 'running' UNION SELECT pid FROM lab4.participated_in WHERE activity_name = 'racquetball'";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>pid</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '</tr>'; 
  }
  }
//Checking if the execute button is pressed and the query is 7  
   elseif(isset($_POST) && $_POST["query"] == "7"){
  echo '<br>';
  $query = "SELECT i.fname,i.lname FROM lab4.person AS i INNER JOIN lab4.body_composition AS bc ON i.pid = bc.pid AND bc.age > 30 INTERSECT SELECT i.fname,i.lname FROM lab4.person AS i INNER JOIN lab4.body_composition AS bc ON i.pid = bc.pid AND bc.height > 65 ";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>fName</th>';
  echo '<th>lname</th>';

  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';  
    echo '</tr>'; 
  }
  }
  //Checking if the execute button is pressed and the query is 8  
   elseif(isset($_POST) && $_POST["query"] == "8"){
  echo '<br>';
  $query = "SELECT fname,lname,weight,height,age FROM lab4.person INNER JOIN lab4.body_composition ON lab4.person.pid = lab4.body_composition.pid ORDER BY (height)DESC,(weight)ASC,(lname)ASC";
  $result = pg_query($conn,$query);
    $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>fname</th>';
  echo '<th>lname</th>';
  echo '<th>weight</th>';
  echo '<th>height</th>';
  echo '<th>age</th>';  
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';  
    echo '<td>'.$rows[2]. '</td>';  
	echo '<td>'.$rows[3]. '</td>';  
	echo '<td>'.$rows[4]. '</td>';  
    echo '</tr>'; 
  }
  }
   //Checking if the execute button is pressed and the query is 9 
   elseif(isset($_POST) && $_POST["query"] == "9"){
  echo '<br>';
 $query = "WITH CTE AS (SELECT fname,lname,pid FROM lab4.person AS p INNER JOIN lab4.university AS u ON (p.uid = u.uid) WHERE u.university_name = 'University of Missouri Columbia' ) SELECT * FROM lab4.body_composition   AS b INNER JOIN CTE  ON (CTE.pid = b.pid) "; 
 $result = pg_query($conn,$query);
  $rowCount = pg_num_rows($result);
  echo '<td>'.'There were '.$rowCount.' returned'.'</td>';
//Error checking and handling 
  if(!result){
    echo "Problem.".$query."</br>";
    echo pg_last_error();
    exit();
  }
//Table creation  
  echo '<table border 1px solid black>';
  echo '<tr>';
  echo '<th>pid</th>';
  echo '<th>height</th>';
  echo '<th>weight</th>';
  echo '<th>age</th>';
  echo '<th>fname</th>';
  echo '<th>lname</th>';
  echo '</tr>';
//Filling table with the correct data 
  while($rows = pg_fetch_row($result)){
    echo '<tr>';
    echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1]. '</td>';  
    echo '<td>'.$rows[2]. '</td>'; 
    echo '<td>'.$rows[3]. '</td>';  
    echo '<td>'.$rows[4]. '</td>';  
    echo '<td>'.$rows[5]. '</td>';   	
    echo '</tr>'; 
  }
 }
 // Closing connection
pg_close($conn);   
}
?>
</body>
</html> 
