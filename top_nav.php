<?
$html = "<span class='top2'>User {$_SESSION['user']} | ";

if($_SESSION['role'] ==='admin' || $_SESSION['role'] ==='dispatcher' || $_SESSION['role'] ==='coder'):
	$html.= "<a href='?pg=36'>Report </a> | ";
endif;

$html .= "<a href='?pg=34'>Legend</a> | ";

if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'dispatcher'):
	$html .= "<a href='?pg=76'>Map It</a> | <a href='?pg=72'>Techs</a> | ";
endif;

if( $_SESSION['role'] === 'admin' || $_SESSION['role'] === 'technologist' || $_SESSION['role'] === 'dispatcher' || $_SESSION['role'] ==='coder' ):
	$html .= "<a href='?pg=73'>Facilities  </a> | ";
endif;

if( $_SESSION['role'] === 'admin' || $_SESSION['role'] === 'dispatcher'):
	$html .= "<a href='?pg=74'>MD MGT  </a> | ";
endif;

$html .= "<a href='?pg=43'>Change Password</a>";

if( $_SESSION['role'] === 'facilityuser' ):
	$html .= " | <a href='?pg=45'>Facility Report </a>";
endif;

$html .= "</span>";

echo $html;
?>
