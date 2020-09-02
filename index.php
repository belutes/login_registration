<?php include("includes/header.php"); 
include("includes/nav.php");
?>


	<div class="jumbotron">
		<h1 class="text-center">Home Page</h1>
  </div>
  <?php
  $sql = "SELECT * FROM users";
  $result = query($sql);
  confirm($result);
  $row = fetch_array($result);
  echo $row['username'] . "<br/>" . $row['first_name'] . "<br/>" . $row['last_name'];
  ?>


<?php include("includes/footer.php") ?>
	
