<!-- //babbage.cs.missouri.edu/~mcpv49/cs3380/lab6/lab6.php -->
<html>
	<head>
		<title>Lab 6</title>
	</head>
	<body>
		<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
			<select name="query">
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
			</select>
			<input type="submit" name="submit" value="Execute">
		</form>
		<br>
		<br>
<?php
		if(empty($_POST)){ 
?>
		<em>Select a query.</em>
		<hr>		
<?php
}
?>	

<?php
//Establishing database connection			
if((isset($_POST["submit"]))){
    include("../secure/database.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
    if($conn) {
    echo '<br>';
    } else {
    echo "<p>Failed to connect to DB</p>";
    }
}  
//Checking for the empty case
			 if(!empty($_POST)){
				 $num = $_POST['query']; 
//Using a switch statement to determine what query to execute.
//If elseIf would also work. 
				switch($num){
					case 1:
						$query = "SELECT MIN(surface_area),MAX(surface_area),AVG(surface_area) FROM lab6.country";
						break;
					case 2:
						$query ="SELECT region, SUM(population) AS total_population, SUM(surface_area) AS total_surface_area, SUM(gnp) AS total_gnp FROM lab6.country GROUP BY region ORDER BY total_gnp DESC";
						break;
					case 3:
						$query ='SELECT government_form, COUNT(government_form), MAX(indep_year) AS most_recent_indep_year FROM lab6.country WHERE indep_year != 0 GROUP BY government_form ORDER BY COUNT DESC, most_recent_indep_year DESC';
						break;
					case 4:
						$query ='SELECT country.name, COUNT(*) FROM lab6.city AS city INNER JOIN lab6.country AS country ON city.country_code = country.country_code GROUP BY country.name HAVING COUNT(*) > 100 ORDER BY COUNT ASC';
						break;
					case 5:
						$query ='SELECT country.name, country.population, SUM(city.population) AS urban_population, (SUM(city.population)::numeric/country.population::numeric)*100 AS urban_pct FROM lab6.city AS city  INNER JOIN lab6.country AS country ON city.country_code = country.country_code  GROUP BY country.country_code ORDER BY urban_pct ASC';
						break;
					case 6:
						$query ='SELECT cp.country_name, lab6.city.name, cp.max_population FROM (SELECT lab6.country.country_code AS country_code, lab6.country.name AS country_name, max(lab6.city.population) As max_population FROM lab6.country, lab6.city WHERE lab6.country.country_code = lab6.city.country_code GROUP BY lab6.country.country_code, lab6.country.name) As cp JOIN lab6.city ON cp.country_code = lab6.city.country_code WHERE lab6.city.population = cp.max_population ORDER BY max_population DESC';
						break;
					case 7:
						$query ='SELECT country.name, COUNT(*) FROM lab6.city AS city INNER JOIN lab6.country AS country ON city.country_code = country.country_code GROUP BY country.name ORDER BY COUNT DESC';
						break;
					case 8:
						$query ='SELECT country.name, capitals.name AS capital, count(language) AS lang_count FROM lab6.country AS country INNER JOIN (SELECT city.name AS name,city.country_code AS country_code FROM lab6.city AS city, lab6.country AS country WHERE city.id = country.capital)   AS capitals ON (capitals.country_code = country.country_code) INNER JOIN lab6.country_language AS cl ON (country.country_code = cl.country_code) GROUP BY country.name, capitals.name HAVING count(language) > 7 AND count(language) < 13 ORDER BY lang_count DESC';
						break;
					case 9:
						$query ='SELECT country.name, tmp.city, tmp.population, tmp.running_total FROM (SELECT city.name as city, city.country_code, city.population,SUM(population) OVER (PARTITION BY city.country_code ORDER BY city.population DESC) AS running_total FROM lab6.city) AS tmp JOIN lab6.country USING (country_code) ORDER BY country.name, tmp.running_total';
						break;
					case 10:
						$query ='SELECT country.name, tmp.language, tmp.rank_in_region FROM (SELECT country_code, language, rank() OVER (PARTITION BY country_code ORDER BY percentage DESC) AS rank_in_region FROM lab6.country_language) AS tmp JOIN lab6.country USING (country_code) ORDER BY country.name, tmp.rank_in_region'; 
						break;	
				}
//Query results or it prints fail message
				$result = pg_query($query) or die('Query failed: Internal Error. ' . pg_last_error());
//Displaying the amount of rows returned
				echo "There were " . pg_num_rows($result) . " rows returned<br><br>\n";
				echo "<table border='1'>\n";				
				echo "<tr>";
//Getting the numfields for the header and then filling the header with the correct infor
				$numFields = pg_num_fields($result);
				for($i = 0;$i < $numFields; $i++){
				  $fieldName = pg_field_name($result, $i);
				  echo "\t\t<th>" . $fieldName . "</th>\n";
				}
				echo "</tr>";
//Populating HTML table with the results
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				 echo "\t<tr>\n";
				 foreach ($line as $col_value) {
				 echo "\t\t<td>$col_value</td>\n";
				 }
				 echo "\t</tr>\n";
				}
				echo "</table>\n";
//Frees the result
				pg_free_result($result);
//Closes the database connection
				pg_close($conn);
			}
?>
	</body>
</html>
