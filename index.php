<?php #MDI Demo
if(!defined("PAGE_TITLE")) define("PAGE_TITLE", "MD Imaging");

$debugflag = isset($_REQUEST['debug'])?$_REQUEST['debug']:'';
$debugflag = false;

//ini_set('display_errors', '1');
if ( $debugflag )
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?=PAGE_TITLE?></title>
		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="map_images/jquery.blockUI.js"></script>
		<script type="text/javascript" src="common.js"></script>
		<link href="menu/menu_style.css" rel="stylesheet" type="text/css"/>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<style>
		body {
			margin: 0px;
		}
		
		#top {
			background: url(top.png);
			display: block;
			width: 100%;
			height: 25px;
		}
		
		#top a.top1 {
			background: url(top.png);
			float: left;
		}
		
		#top span.top2 {
			padding: 5px;
			background: url(top.png);
			float: left;
			color: white;
			text-decoration: none;
			font-size: 10px;
		}
		
		#top span.top2 a {
			color: white;
			text-decoration: none;
		}
		
		#top a.top3 {
			background: url(top.png);
			float: right;
		}
		
		#header {
			background: url(bg.png);
			padding: 5px;
			text-align: left;
		}
		
		#menuad {
			background: url(main.png);
			width: 100%;
			text-align: left;
		}
		
		#content {
			height: auto;
			float: left;
			width: 100%;
		}
		#footer {
		  background: url(top.png);
		}
		HR {
		page-break-after: always;
		}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<div id="top">
				<a href="index.php?pg=20" class="top1"><img src="images/home.png"/></a>
				<?php include 'top_nav.php';?>
				<a href="logout.php" class="top3"><img src="images/logout.png"/></a>
			</div>
			<div id="header">
				<img src="images/logo.png"/>
			</div>
		<?if($_SESSION['role'] === 'admin'):
			include_once 'nav/nav.php';
		else:?>
			<div id="menuad">
				<div class="menu">
					<ul>
						<li>
						<?=($_REQUEST['pg'] === "20" && !isset($_GET['all']))?'<a href="index.php?pg=20&all=all" style="color:#fff;text-decoration:none; padding-left:10px;align: left;" align="left"> Show All</a>':''?>
						<?=( $_REQUEST['pg'] === "20" && isset($_GET['all']))?'<a href="index.php?pg=20" style="color:#fff;text-decoration:none; padding-left:10px;align: left;" align="left"> Today</a>':''?>
						</li>
					</ul>
				</div>
			</div>
		<?endif;?>
			<div id="content">
			<?
			//print_r($_REQUEST,1);
			if($_REQUEST['pg'] === "" || !isset($_REQUEST['pg']))
			{
				if(empty($_SESSION['user']) || !isset($_SESSION['user'])):
					include_once "login.php";
				else:
					header("Location: manageorders.php");
					die;
				endif;
			}
			if($_REQUEST['pg'] === "1") include_once "createusers.php";
			if($_REQUEST['pg'] === "2") include_once "listusers.php";
			if($_REQUEST['pg'] === "3")
			{
				$id = $_REQUEST['id'];
				include_once "editusers.php";
			}
			if($_REQUEST['pg'] === "4")
			{
				$id=$_REQUEST['id'];
				include_once "deleteusers.php";
			}
			if($_REQUEST['pg'] === "5") include_once "emailmanagment.php";
			if($_REQUEST['pg'] === "6") include_once "pdfmanagment.php";
			if($_REQUEST['pg'] === "7") include_once "dbmanagment.php";
			if($_REQUEST['pg'] === "8") include_once "createprocedure.php";
			if($_REQUEST['pg'] === "9") include_once "listprocedure.php";
			if($_REQUEST['pg'] === "10")
			{
				$id=$_REQUEST['id'];
				include_once "editprocedure.php";
			}
			if($_REQUEST['pg'] === "11")
			{
				$id=$_REQUEST['id'];
				include_once "deleteprocedure.php";
			}
			if($_REQUEST['pg'] === "12") include_once "createfacility.php";
			if($_REQUEST['pg'] === "13") include_once "listfacility.php";
			if($_REQUEST['pg'] === "14")
			{
				$id=$_REQUEST['id'];
				include_once "editfacility.php";
			}
			if($_REQUEST['pg'] === "15")
			{
				$id=$_REQUEST['id'];
				include_once "deletefacility.php";
			}
			if($_REQUEST['pg'] === "16") include_once "addlist.php";
			if($_REQUEST['pg'] === "17") include_once "viewlists.php";
			if($_REQUEST['pg'] === "18")
			{
				$id=$_REQUEST['id'];
				include_once "editlist.php";
			}
			if($_REQUEST['pg'] === "19")
			{
				$id=$_REQUEST['id'];
				include_once "deletelist.php";
			}
			if($_REQUEST['pg'] === "20")
			{
				header("Location: manageorders.php");
				die;
			}
			if($_REQUEST['pg'] === "21")
			{
				$id=(isset($_REQUEST['id'])?$_REQUEST['id']:'');
				include_once "createorders.php";
			}
			if($_REQUEST['pg'] === "22")
			{
				$id=$_REQUEST['id'];
				include_once "authorizeorder.php";
			}
			if($_REQUEST['pg'] === "23")
			{
				$id=$_REQUEST['id'];
				include_once "editorders.php";
			}
			if($_REQUEST['pg'] === "24")
			{
				$id=$_REQUEST['id'];
				include_once "deleteorders.php";
			}
			if($_REQUEST['pg'] === "25")
			{
				$id=$_REQUEST['id'];
				include_once "dispatch.php";
			}
			if($_REQUEST['pg'] === "26")
			{
				$id=$_REQUEST['id'];
				include_once "undispatch.php";
			}
			if($_REQUEST['pg'] === "27")
			{
				$id=$_REQUEST['id'];
				include_once "verbal.php";
			}
			if($_REQUEST['pg'] === "28")
			{
				$id=$_REQUEST['id'];
				include_once "code.php";
			}
			if($_REQUEST['pg'] === "29")
			{
				$id=$_REQUEST['id'];
				include_once "orderdetails.php";
			}
			if($_REQUEST['pg'] === "30")
			{
				$id=$_REQUEST['id'];
				include_once "editorders1.php";
			}
			if($_REQUEST['pg'] === "31")
			{
				$id=$_REQUEST['id'];
				include_once "verbal.php";
			}
			if($_REQUEST['pg'] === "32")
			{
				$keyw=$_REQUEST['srch'];
				$key=strtoupper($keyw);
				$keyword=$_REQUEST['keyword'];
				include_once "searchres.php";
			}
			if($_REQUEST['pg'] === "33")
			{
				$keyw=$_REQUEST['srch'];
				$key=strtoupper($keyw);
				$keyword=$_REQUEST['keyword'];
				include_once "searchres1.php";
			}
			if($_REQUEST['pg'] === "34") include_once "legend.php";
			if($_REQUEST['pg'] === "35")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "appmnts.php";
			}
			if($_REQUEST['pg'] === "36") include_once "report.php";
			if($_REQUEST['pg'] === "37") include_once "reports.php";
			if($_REQUEST['pg'] === "38") include_once "mdet_main.php";
			if($_REQUEST['pg'] === "39") include_once "msum_main.php";
			if($_REQUEST['pg'] === "40")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "mdet.php";
			}
			if($_REQUEST['pg'] === "41") include_once "msum.php";
			if($_REQUEST['pg'] === "42") include_once "createneworders.php";
			if($_REQUEST['pg'] === "43") include_once "changepwd.php";
			if($_REQUEST['pg'] === "44") include_once "techrep_main.php";
			if($_REQUEST['pg'] === "45") include_once "facrep_main.php";
			if($_REQUEST['pg'] === "46")
			{
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "fac_report.php";
			}
			if($_REQUEST['pg'] === "47")
			{
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "tech_report.php";
			}
			if($_REQUEST['pg'] === "48") include_once "exception.php";
			if($_REQUEST['pg'] === "49") include_once "cdreq_main.php";
			if($_REQUEST['pg'] === "50")
			{
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "cdreq_report.php";
			}
			if($_REQUEST['pg'] === "51") include_once "parta_main.php";
			if($_REQUEST['pg'] === "52")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "partarpt.php";
			}
			if($_REQUEST['pg'] === "53") include_once "callrpt_main.php";
			if($_REQUEST['pg'] === "54")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "callrpt.php";
			}
			if($_REQUEST['pg'] === "55") include_once "billing.php";
			if($_REQUEST['pg'] === "56")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "billingdet.php";
			}
			if($_REQUEST['pg'] === "57") include_once "billpay.php";
			if($_REQUEST['pg'] === "58") include_once "facinvoice_main.php";
			if($_REQUEST['pg'] === "59")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "facinvoice.php";
			}
			if($_REQUEST['pg'] === "60")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "facinvoice.php";
			}
			if($_REQUEST['pg'] === "61") include_once "admin_fac_main.php";
			if($_REQUEST['pg'] === "62")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "admin_fac.php";
			}
			if($_REQUEST['pg'] === "63") include_once "facexp_main.php";
			if($_REQUEST['pg'] === "64")
			{
				$d=$_REQUEST['d'];
				$dt1=$_REQUEST['dt1'];
				$dt2=$_REQUEST['dt2'];
				include_once "facexp.php";
			}
			if($_REQUEST['pg'] === "65") include_once "admin_exp_main.php";
			if($_REQUEST['pg'] === "66") include_once "FTR_main.php";
			if($_REQUEST['pg'] === "67") include_once "forgotpassword.php";
			if($_REQUEST['pg'] === "71")
			{
				$id=$_REQUEST['id'];
				include_once "createorders2.php";
			}
			if($_REQUEST['pg'] === "72") include_once "dispatch_board.php";
			if($_REQUEST['pg'] === "73") include_once "facdisplay.php";
			if($_REQUEST['pg'] === "74") include_once "physicianmgt.php";
			if($_REQUEST['pg'] === "75") include_once "mapSettings.php";
			if($_REQUEST['pg'] === "76") include_once "map.php";
			if($_REQUEST['pg'] === "77") include_once "facilityOrders.php";
			
			?>
			</div>
		</div>
	</body>
</html>

