<html>
	<head>
		<meta charset="UTF-8">
		<title>Lab 5</title>
	</head>
	<body>
<?php 
//babbage.cs.missouri.edu/~mcpv49/lab5/index.php
?>
		<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
		    Search for a :
		    <input type="radio" name="search_by" checked="true" value="country">Country 
		    <input type="radio" name="search_by" value="city">City
		    <input type="radio" name="search_by" value="language">Language <br>
		    <div class="row left">
			    <div>
			    	<label for="left-label" class="left inline">That begins with:</label>
			    </div>
			    <div class="large-4 columns">
			    	<input type="text" name="query_string" value="">
			    </div>
			</div>
			<div class="row left">
		    	<div class="large-2"><input type="submit" class="left" name="submit" value="Submit"></div>
		    </div>
		</form>
		Or insert a new entry by clicking this <a href="index.php" data-reveal-id="insert-modal">link</a>
<?php		
//Start of php to include the phplogic.php segment of code	
			include("phpView.php");

?>
		<div id="insert-modal" class="reveal-modal" data-reveal>
<?php //echo file_get_contents("views/insert.php")
				displayinsert($conn);
?>
		</div>
	</body>
</html>
