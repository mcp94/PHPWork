<!-- //babbage.cs.missouri.edu/~mcpv49/cs3380/lab3/lab3.php -->
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
    <option value="10">Query 10</option>
    <option value="11">Query 11</option>
    <option value="12">Query 12</option>
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
    echo "There were 3 rows returned";
	echo '<br>';
	$query = "SELECT district,population FROM lab3.city WHERE name = 'Springfield' ORDER BY GREATEST(population)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Population</th>';
	echo '<th> District</th>';
	echo '</tr>';
//Filling table with the correct data	
	while($rows = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td>'.$rows[0].'</td>';
		echo '<td>'.$rows[1]. '</td>';	
		echo '</tr>';	
	}
   }
//Checking if the execute button is pressed and the query is 2
   elseif(isset($_POST) && $_POST["query"] == "2"){
    echo "There were 250 rows returned";
	echo '<br>';
	$query = "SELECT name,district,population FROM lab3.city WHERE country_code = 'BRA' ORDER BY GREATEST(name)ASC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th> District</th>';
	echo '<th>Population</th>';
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
    echo "There were 250 rows returned";
	echo '<br>';
	$query = "SELECT name,continent,surface_area FROM lab3.country ORDER BY LEAST(surface_area)ASC LIMIT 20 ";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th> Continent</th>';
	echo '<th>Surface Area</th>';
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
//Checking if the execute button is pressed and the query is 4	
   elseif(isset($_POST) && $_POST["query"] == "4"){
    echo "There were 23 rows returned";
	echo '<br>';
	$query = "SELECT name,continent,government_form,gnp FROM lab3.country WHERE (gnp>=200000) ORDER BY LEAST(name)ASC ";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th> Continent</th>';
	echo '<th>Government_Form</th>';
	echo '<th>GNP</th>';
	echo '</tr>';
//Filling table with the correct data	
	while($rows = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td>'.$rows[0].'</td>';
		echo '<td>'.$rows[1]. '</td>';	
		echo '<td>'.$rows[2]. '</td>';
		echo '<td>'.$rows[3]. '</td>';		
		echo '</tr>';	
	}
  }
//Checking if the execute button is pressed and the query is 5	
   elseif(isset($_POST) && $_POST["query"] == "5"){
    echo "There were 10 rows returned";
	echo '<br>';
	$query = "SELECT name,life_expectancy FROM lab3.country ORDER BY GREATEST(life_expectancy)DESC OFFSET(27) LIMIT 10;";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th> Life Expectancy</th>';
	echo '</tr>';
//Filling table with the correct data	
	while($rows = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td>'.$rows[0].'</td>';
		echo '<td>'.$rows[1]. '</td>';	

		echo '</tr>';	
	}
  }
//Checking if the execute button is pressed and the query is 6	
   elseif(isset($_POST) && $_POST["query"] == "6"){
    echo "There were 12 rows returned";
	echo '<br>';
	$query = "SELECT name,population FROM lab3.city  WHERE name ~ '(^(?=^B)(?=.*s$))' ORDER BY GREATEST(population)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
 echo '<th>Population</th>';
	echo '</tr>';
//Filling table with the correct data	
	while($rows = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td>'.$rows[0].'</td>';
    echo '<td>'.$rows[1].'</td>';
		echo '</tr>';	
	}
  }
//Checking if the execute button is pressed and the query is 7	
   elseif(isset($_POST) && $_POST["query"] == "7"){
    echo "There were 20 rows returned";
	echo '<br>';
	$query = "SELECT lab3.city.name, lab3.country.name, lab3.city.population FROM lab3.country INNER JOIN lab3.city ON lab3.country.country_code = lab3.city.country_code WHERE lab3.city.population > 6000000 GROUP BY lab3.country.name, lab3.city.name, lab3.city.population ORDER BY( lab3.city.population)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Country Name</th>';
	echo '<th>City Population</th>';
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
  //Checking if the execute button is pressed and the query is 8	
   elseif(isset($_POST) && $_POST["query"] == "8"){
    echo "There were 165 rows returned";
	echo '<br>';
	$query = "SELECT lab3.country.name, lab3.country_language.language, lab3.country_language.percentage FROM lab3.country INNER JOIN lab3.country_language ON lab3.country.country_code = lab3.country_language.country_code WHERE lab3.country.population>50000000 AND lab3.country_language.is_official = FALSE GROUP BY lab3.country.name, lab3.country_language.language,lab3.country_language.percentage,lab3.country_language.is_official ORDER BY(lab3.country_language.percentage)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Language</th>';
	echo '<th>Percentage</th>';
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
   //Checking if the execute button is pressed and the query is 9	
   elseif(isset($_POST) && $_POST["query"] == "9"){
    echo "There were 44 rows returned";
	echo '<br>';
	$query = "SELECT lab3.country.name, lab3.country.indep_year,lab3.country.region FROM lab3.country INNER JOIN lab3.country_language ON lab3.country.country_code = lab3.country_language.country_code WHERE lab3.country_language.language ='English' AND lab3.country_language.is_official = TRUE GROUP BY lab3.country.name, lab3.country.indep_year, lab3.country.region,lab3.country_language.is_official ORDER BY(lab3.country.region)ASC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Indep_Year</th>';
	echo '<th>Region</th>';
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
   //Checking if the execute button is pressed and the query is 10	
   elseif(isset($_POST) && $_POST["query"] == "10"){
    echo "There were 232 rows returned";
	echo '<br>';
	$query = "SELECT lab3.city.name, lab3.country.name,cast(lab3.city.population AS FLOAT)/(cast(lab3.country.population AS FLOAT))*100 AS urban_pct FROM lab3.city INNER JOIN lab3.country ON lab3.city.id = lab3.country.capital GROUP BY lab3.city.name, lab3.country.name,urban_pct ORDER BY(urban_pct)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Capital Name</th>';
	echo '<th>Country Name</th>';
	echo '<th>Urban_Pct</th>';
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
   //Checking if the execute button is pressed and the query is 11	
   elseif(isset($_POST) && $_POST["query"] == "11"){
    echo "There were 238 rows returned";
	echo '<br>';
	$query = "SELECT lab3.country.name, lab3.country_language.language,(lab3.country_language.percentage * lab3.country.population)/100 AS speakers FROM lab3.country INNER JOIN lab3.country_language ON lab3.country.country_code = lab3.country_language.country_code WHERE lab3.country_language.is_official = 'TRUE' GROUP BY lab3.country.name, lab3.country_language.language,speakers ORDER BY(speakers)DESC";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Language</th>';
	echo '<th>Speakers</th>';
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
   //Checking if the execute button is pressed and the query is 12	
   elseif(isset($_POST) && $_POST["query"] == "12"){
    echo "There were 178 rows returned";
	echo '<br>';
	$query = "SELECT lab3.country.name, lab3.country.region,lab3.country.gnp,lab3.country.gnp_old,(lab3.country.gnp - lab3.country.gnp_old)/lab3.country.gnp_old AS wealth FROM lab3.country WHERE gnp IS NOT NULL and gnp_old IS NOT NULL ORDER BY(wealth)DESC ";
	$result = pg_query($conn,$query);
//Error checking and handling	
	if(!result){
		echo "Problem.".$query."</br>";
		echo pg_last_error();
		exit();
	}
//Table creation	
	echo '<table border 1px solid black>';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Region</th>';
	echo '<th>GNP</th>';
	echo '<th>GNP Old</th>';
	echo '<th>Real Change</th>';
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

// Closing connection
pg_close($conn);   
}
?>
</body>
</html>
























































































