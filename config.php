<?php # MDI Demoif(!defined('PAGE_TITLE'))	define("PAGE_TITLE", "ASHVILLE");
$servername	= 'localhost';	// MySql Server Name or IP address
$dbusername	= 'root';		// Login user id
$dbpassword	= '!MMDS2014!';	// Login password
$dbname		= 'ooe';	// database name
function connecttodb($servername,$dbname,$dbuser,$dbpassword)
{
	global $link;
	$link = mysql_connect("$servername","$dbuser","$dbpassword");
	if( !$link ) die ("Could not connect to MySQL");
	mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}
connecttodb($servername,$dbname,$dbusername,$dbpassword);
//row perpage of site
define('FRONT_END_ROW_PER_PAGE', 50);
//number of link display in page
define('WEBSITE_DEFAULT_NUMBER_LINK', 20);
define('OVER_DST' , false);//NEED THIS FUNCTIONfunction getCurrentDate($role, $userState){	return date('Y-m-d H:i:s');		//if(OVER_DST == false) return date('Y-m-d H:i:s');	//if($role == 'admin') $userState = 'AZ';	//if($userState == 'AZ') return date('Y-m-d H:i:s');	//CO	//return date('Y-m-d H:i:s', strtotime('+1 hour'));}
