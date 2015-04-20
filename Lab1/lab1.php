<html>
<head/>
<body>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
  <table border="1">
     <tr><td>Number of Rows:</td><td><input type="text" name="rows" /></td></tr>
     <tr><td>Number of Columns:</td><td><select name="columns">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="4">4</option>
    <option value="8">8</option>
    <option value="16">16</option>

  </select>
</td></tr>
   <tr><td>Operation:</td><td><input type="radio" name="operation" value="multiplication" checked="yes">Multiplication</input><br/>
  <input type="radio" name="operation" value="addition">Addition</input>
  </td></tr>
  </tr><td colspan="2" align="center"><input type="submit" name="submit" value="Generate" /></td></tr>
</table>
</form>

<?php

if((isset($_POST["submit"]))&& ($_POST["rows"] >0)){

        //Error Checking to see if it is set to row. Also makes sure the input is numeric, and not something like a charater or a lette
  if ( isset($_POST["rows"]) && is_numeric($_POST["rows"])){
            //Error checking to make sure the rows are positive
		//Gets the operation and determines which it is and performs the necessary tasks on it
                    if(isset($_POST) && $_POST["operation"] == "multiplication"){
                            //Displays the title ontop of the table with what type of table it is
			    echo 'This is a '. $_POST["rows"] . ' x ' . $_POST["columns"] .' multiplication table';
                	  //Sets the table border = 1 
		            echo "<table border=1";
                            echo'<tr>';
			//Moves through the columns
                    for($i = 0; $i <= $_POST["columns"];$i++){
                            echo '<th>'.$i.'</th>';}
                            echo '</tr>';
			//Moves through the rows
                    for($j = 1; $j <= $_POST["rows"]; $j++){
                            echo'<tr><th>'.$j.'</th>';
//Moving through the columns and then performs the multiplication
                            for($x = 1; $x <= $_POST["columns"]; $x++){
                                    echo '<td>' .$x*$j. '</td>';
                            }
                                            echo '</tr>';
                                    }
            echo "</table>";
            }
//If not multiplication and the button is set to addition, do the necessary tasks
 else if (isset($_POST) && $_POST["operation"] == "addition")
                    {
			//Displays the title ontop of the table with what type of table it is
			echo 'This is a '. $_POST["rows"] . ' x ' . $_POST["columns"] .' addition table';
			//Moves through the rows + 1
                            for($x=0; $x<$_POST['rows']+1; $x++)
{
//Sets i = 0, then takes i and adds it to x then sets it equal to y
    $i=0;
    $y= $i+$x;
//Creates the table border and its color
    echo '<table border 1px solid black>';
    echo '<tr>';
    echo '<td>'.$y.'</td>';
//Moving through the columns + 1
    for($val = 1 ;$val < $_POST['columns']+1 ;$val++){
    $c=$y+$val;
        echo '<td>'.$c;

    echo '</td>';
    }
    echo '</tr>';
    echo '</table>';
}
echo "</table>";
}
//If these do not work, print the error message and exit
}
}
else {
	echo "incorrect parameters";
	exit();
}
//babbage.cs.missouri.edu/~mcpv49/cs3380/lab1/lab1.php
x
s
s
//babbage.cs.missouri.edu/cs
?>
</body>
<html>
