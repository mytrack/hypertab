<?php 

$con=mysqli_connect("localhost","root","zxcvbnmk","srt");

// tetrasys
//echo mysqli_character_set_name($con);
mysqli_set_charset($con, 'utf8');

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
} 


// Perform queries 
//mysqli_query($con,"SELECT * FROM s_srt");
//mysqli_query($con,"INSERT INTO s_srt (s_index,s_start,s_end,s_text) 
//	VALUES (2,'Glenn','Quagmire','text')");

if ($result = mysqli_query($con,"SELECT * FROM s_srt")) {
    printf("Select returned %d rows.\n", mysqli_num_rows($result));

    /* free result set */
    mysqli_free_result($result);
}

//$sql="SELECT * FROM s_srt ORDER BY id ";
// phpMyAdmin 에서  생성
$sql = "SELECT * FROM `s_srt` WHERE `id` > 40000 ORDER BY `id` DESC ";
#$sql="SELECT * FROM s_srt WHERE s_text LIKE '%I want%' ";

if ($result=mysqli_query($con,$sql))
{
  // Fetch one and one row
  while ($col=mysqli_fetch_row($result))
  {
    printf ("<br>%'.06d ...  %'.04d | %s\n",$col[0],$col[1],$col[4]); 
    //printf ("<br>%'.06d ...  %'.04d-[%s~%s] %s\n",$col[0],$col[1],$col[2],$col[3],$col[4]); 
  }
  // Free result set
  mysqli_free_result($result);
}




mysqli_close($con);


?>


</body>
</html>