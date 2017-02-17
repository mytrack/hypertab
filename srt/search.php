<?php     
mysql_connect("localhost", "root", "") or die("Error connecting to database: ".mysql_error());

#mysql_connect("localhost", "root", "root") or die("Error connecting to database: ".mysql_error());
/*
    localhost - it's location of the mysql server, usually localhost
    root - your username
    third is your password
     
    if connection fails it will stop loading the page and display an error
*/
 
mysql_select_db("test") or die(mysql_error());
/* tutorial_search is the name of database we've created */
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.easing.min.js"></script>
<script type="text/javascript" src="jquery/scroll.js"></script>  
</head>


<body>
    <form action="search.php" method="GET">
        <input type="text" name="query" />
        <input type="submit" value="Search" />
    </form>

    <div class="scrollbar">
        <div class="bar"></div>
    </div>
</body>







<?php

//$con=mysqli_connect("localhost","root","zxcvbnmk","srt");
//echo mysqli_character_set_name($con);
//mysqli_set_charset($con, 'utf8');

    
    $query = $_GET['query']; 
    // gets value sent over search form
    

    $min_length = 3;
    // you can set minimum length of the query if you want
     
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
         
        $query = htmlspecialchars($query); 
        // changes characters used in html to their equivalents, for example: < to &gt;
         
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection

        #$query = urlencode(iconv('euc_kr','utf-8',$query)); 

        // tetrasys
        //echo $query; $query=urlencode($query);
        $dbc=mysql_connect("localhost", "root", "zxcvbnmk");
        mysql_query("SET NAMES UTF8", $dbc); //very important!


        $raw_results = mysql_query("SELECT * FROM srt_eng WHERE (`rec_text` LIKE '%".$query."%')") or die(mysql_error());

        // $raw_results = mysql_query("SELECT * FROM srt_eng 
        //   WHERE (`rec_text` LIKE '%".$query."%') OR (`rec_text` LIKE '%".$query."%')") or die(mysql_error());
              
        // * means that it selects all fields, you can also write: `id`, `title`, `text`
        // articles is the name of our table
         
        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
         
        if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following

            while($results = mysql_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop

                $total_record_id = $results['id'];
                $record_index = $results['rec_index'];
                $total_recordindex = $total_record_id - $record_index;

                $raw_toc_results = mysql_query("SELECT * FROM toc WHERE (`totalrecord_index` = '".$total_recordindex."')") or die(mysql_error());
                if(mysql_num_rows($raw_toc_results) > 0) { 
                    while($toc_results = mysql_fetch_array($raw_toc_results)) {
                        $content_recordsize = $toc_results['content_recordsize'];
                        $title = $toc_results['title'];
                    }
                }


                printf ("<br>%'.06d ... %'.04d| %s\n",$results['id'], $results['rec_index'], $results['rec_text']);
                printf ("<br>%'.2d %'_20d       %s\n",$record_index, $content_recordsize, $title);
                //echo "<p><h3>".$results['s_start']."</h3>".$results['s_text']."</p>";
                // posts results gotten from database(title and text) you can also show id ($results['id'])
            }
             
        }
        else{ // if there is no matching rows do following
            echo "No results";
        }
         
    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }
?>

</body>
</html>