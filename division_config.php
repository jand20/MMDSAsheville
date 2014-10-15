<?php
//for db usage
// include "config.php";

//define folder contain logo, in this case is currentfolder/logos
define('LOGO_FOLDER','logos/');

//hard code array divisions
//will left out the phone and fax info for speed, can easily be put back

$divisionArray = array(
        "North Carolina" => "North Carolina",
        "Kingsport" => "Kingsport",
        "Asheville" => "Asheville");
    /* "CENTRAL AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"DENVER NE" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"DENVER NW" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"DENVER SE" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"DENVER SW" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"DENVER WEST" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"EAST AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"HOME HEALTH" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"NORTH AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"NORTH FT COLLINS" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"NORTH GREELEY" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"NORTH LONGMONT" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"NORTH LOVELAND" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"SCOTTSDALE AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"SOUTH AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"SOUTH PUEBLO" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"SOUTH SPRINGS" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"TUCSON AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"WEST AZ" => array(
        'phone' => '800-395-6535',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo1.png'
    ),
	"WEST SLOPE"   => array(
        'phone' => '866-771-1801',
        'fax'   => '816-671-1802',
        'logo'  => LOGO_FOLDER.'logo2.png'
    ) */

function getDivisionCombo($selected = null, $class = '', $multiple = null, $useAll = true)
{
	global $divisionArray;

	if($multiple)
		$combo = array("<select name='division[]' size='$multiple' multiple='$multiple' class='$class'>");
	else
		$combo = array("<select name='division' id='division' class='$class'>");

	if($useAll)	$combo[] = '<option value="">All</option>';

	foreach($divisionArray as $division => $propeties)
	{
		if($selected != null && $division == $selected)
			$combo[] = "<option value='$division' selected='selected'>$division</option>";
		else
			$combo[] = "<option value='$division'>$division</option>";
	}

	$combo[] = '</select>';

	return implode('', $combo);
}

function divisionList($multiSelect = null) //dynamicaly pull division listing based on customer w.o have to hardcode
{
    if($multiSelect != null)
    {
        $html = " id='division' name='division[]' multiple = $multiSelect>";
    }
    else
    {
        $html = "name='division' id='division'>";
    }
    
    $sql="SELECT * FROM tbllists
    		WHERE fldListName = 'division' AND fldActiveValue > 0";
    
    $result = mysql_query($sql);
    
    //print_r(mysql_fetch_array($result));
    
    while($row = mysql_fetch_array($result))://print_r($row);
        $html .= "<option value='{$row['fldValue']}'>";
        $html .= strtoupper($row['fldValue']);
        $html .= "</option>";
    endwhile;
    
    echo $html;
}



