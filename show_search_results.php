<?PHP

require_once("config.php");

$kwarray;
$khistwarray;
$kwnotseen;

# ID of URL we are looking now
$url = $_REQUEST['url'];

# Load actual URL we are looking now
$sql = 'SELECT url FROM '.DOMAIN_TABLE." WHERE id='$url';";
list($url) = mysql_fetch_row(db_query( $sql ));

# Get position & Count this url for each keword 
# $diff - No of days back to current date

function getPosition($diff){

    global $khistwarray;
    global $url;

# Get the date $diff days in past
    $sql = "SELECT DATE(DATE_SUB(MAX(time_searched),INTERVAL $diff DAY)) AS searchdate FROM ".SEARCH_TABLE." WHERE url LIKE '%$url/%'";
    list($currentdate) = mysql_fetch_array(db_query( $sql ));

# Get keywords, count and the best ranking this URL had
    $sql        = 'SELECT keyword_id,COUNT(keyword_id) AS kwid,MIN(position) as searchpos  FROM '.SEARCH_TABLE." WHERE url LIKE'%$url/%' AND url NOT LIKE'%/%$url/%' AND time_searched like '$currentdate%' GROUP BY keyword_id";
    $result     = db_query( $sql );
    $kwcount    = mysql_num_rows($result);
    while ( $row = mysql_fetch_assoc($result)){
        $khistwarray[$row['keyword_id']][$diff]['position']= $row['searchpos'];
        $khistwarray[$row['keyword_id']][$diff]['count'] = $row['kwid'];
   }

}

# Calculate cgange in count and position for 30/60/120/240/360 days
function findChange(){
    global $khistwarray;
    foreach (array_keys($khistwarray) as $kwid){
        list ($khistwarray[$kwid][30]['count_change'],$khistwarray[$kwid][30]['position_change']) = calculateChange(array($khistwarray[$kwid][0]['count'],$khistwarray[$kwid][0]['position']),array($khistwarray[$kwid][30]['count'],$khistwarray[$kwid][30]['position']));
        list ($khistwarray[$kwid][60]['count_change'],$khistwarray[$kwid][60]['position_change']) = calculateChange(array($khistwarray[$kwid][0]['count'],$khistwarray[$kwid][0]['position']),array($khistwarray[$kwid][60]['count'],$khistwarray[$kwid][60]['position']));
        list ($khistwarray[$kwid][120]['count_change'],$khistwarray[$kwid][120]['position_change']) = calculateChange(array($khistwarray[$kwid][0]['count'],$khistwarray[$kwid][0]['position']),array($khistwarray[$kwid][120]['count'],$khistwarray[$kwid][120]['position']));
        list ($khistwarray[$kwid][240]['count_change'],$khistwarray[$kwid][240]['position_change']) = calculateChange(array($khistwarray[$kwid][0]['count'],$khistwarray[$kwid][0]['position']),array($khistwarray[$kwid][240]['count'],$khistwarray[$kwid][240]['position']));
        list ($khistwarray[$kwid][360]['count_change'],$khistwarray[$kwid][360]['position_change']) = calculateChange(array($khistwarray[$kwid][0]['count'],$khistwarray[$kwid][0]['position']),array($khistwarray[$kwid][360]['count'],$khistwarray[$kwid][360]['position']));
    }

}

# Get list of active keywords.
$sql = 'SELECT id, keyword FROM '.KEYWORD_TABLE." WHERE active='Y';";
$result = db_query( $sql );
while($row = mysql_fetch_assoc($result)){
    $kwarray[$row['id']] = $row['keyword'];
}

# Save Keyword list to generate list of those doest seen at all
$kwnotseen = $kwarray;

# Get latest (current) Date at with this URL was seen in the search.
$sql = "SELECT DATE(MAX(time_searched)) AS searchdate FROM ".SEARCH_TABLE." WHERE url LIKE '%$url/%'";
list($currentdate) = mysql_fetch_array(db_query( $sql ));

# Get current count & position of current URL for all keywords.
$sql        = 'SELECT keyword_id,COUNT(keyword_id) AS kwid,MIN(position) as searchpos  FROM '.SEARCH_TABLE." WHERE url LIKE'%$url/%' AND url NOT LIKE'%/%$url/%' AND time_searched like '$currentdate%' GROUP BY keyword_id";
$result     = db_query( $sql );
$kwcount    = mysql_num_rows($result);
$rowclr     = 'rowone';
while ( $row = mysql_fetch_assoc($result)){

    $khistwarray[$row['keyword_id']][0]['keyword'] = $kwarray[$row['keyword_id']];
    $khistwarray[$row['keyword_id']][0]['count'] = $row['kwid'];
    $khistwarray[$row['keyword_id']][0]['position'] = $row['searchpos'];

}

# Get position of URL 30/60/120/240/360 days in past
getPosition(30);
getPosition(60);
getPosition(120);
getPosition(240);
getPosition(360);

# Calculate change in position & count of current URL
findChange();

# Text to dispaly :)
$alert      = "<br><table cellspacing='0' cellpadding='0' style='border:1px solid black;'><tr><td colspan='14' style='padding:5px;font-size:1.5em;font-weight:bold;border:1px solid black;'>$url</td></tr>";
$alert     .= "<tr><th colspan='2'>&nbsp;</th><th  colspan='2'>Current</th><th  colspan='2'>30 Days</th><th colspan='2'>60 Days</th><th  colspan='2'>120 Days</th><th  colspan='2'>240 Days</th><th  colspan='2'>360 Days</th></tr>";
$alert     .= "<tr><th>No.</th><th>Keyword</th><th>URL Count</th><th>Position</th><th>URL Count</th><th>Position</th><th>URL Count</th><th>Position</th><th>URL Count</th><th>Position</th><th>URL Count</th><th>Position</th><th>URL Count</th><th>Position</th></tr>";
$i          = 1;

# Format output
foreach (array_keys($khistwarray) as $kwid){
    
    $alert .= "<tr class='$rowclr'><td>$i</td><td><a href='show_search_graph.php?keyword=$kwid&url=$url'>".$khistwarray[$kwid][0]['keyword']."</a></td><td>".$khistwarray[$kwid][0]['count']."</td><td>".$khistwarray[$kwid][0]['position']."</td><td>".$khistwarray[$kwid][30]['count_change']."</td><td>".$khistwarray[$kwid][30]['position_change']."</td><td>".$khistwarray[$kwid][60]['count_change']."</td><td>".$khistwarray[$kwid][60]['position_change']."</td><td>".$khistwarray[$kwid][120]['count_change']."</td><td>".$khistwarray[$kwid][120]['position_change']."</td><td>".$khistwarray[$kwid][240]['count_change']."</td><td>".$khistwarray[$kwid][240]['position_change']."</td><td>".$khistwarray[$kwid][360]['count_change']."</td><td>".$khistwarray[$kwid][360]['position_change']."</td></tr>";
    unset($kwnotseen[$kwid]);
    $i++;
    $rowclr = ($rowclr == 'rowone'?'rowtwo':'rowone');
}

# Print those keywords for which this URL was not found
foreach ($kwnotseen as $kws){
    $alert .= "<tr class='$rowclr'><td>$i</td><td>$kws</td><td>0</td><td> >100</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
    $i++;
    $rowclr = ($rowclr == 'rowone'?'rowtwo':'rowone');

}

$alert .= "</table>";


# HTML goes below :)
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;">
    <meta http-equiv="Content-Language" content="">
    <title>Search Results for URL</title>
    <style type='text/css'>
        th {border:1px solid black;}
        .rowone td{background-color:#FFFFFF;height:120%;white-space:nowrap;border-left:1px solid black;border-right:1px solid black;padding:5px;}
        .rowtwo td{background-color:#E9E9E9;height:120%;white-space:nowrap;border-left:1px solid black;border-right:1px solid black;padding:5px;}
    </style>
</head>
<body>
<?php require_once("menus.php");?>
<div align='center'>
<!-- display the Search Results... -->
<table border='0' width='90%' style='border-collapse: collapse; border:1px SOLID #000000;'><?=$alert?></table></div>
</body>
</html>
