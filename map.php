<!DOCTYPE html>
<?php

    session_start();

    if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'dispatcher'))
    {
        header("Location:index.php");
        die;
    }

    require_once 'division_config.php';
    require_once 'config.php';
    require_once 'common.php';
    
    //get map address settings
    $mapSql = "select mapAddress, mapLatLong from tblsettings";
    $result = mysql_query($mapSql);
    while ($ms = mysql_fetch_assoc($result)) 
    {
    	$mapSettings = $ms;
    }

    $mainAddress = (!empty($mapSettings['mapAddress']))?$mapSettings['mapAddress']:'2795 Genesee St, Buffalo, NY, 14304';
    list($mainPoint1,$mainPoint2) = explode(',', !empty($mapSettings['mapLatLong'])?$mapSettings['mapLatLong']:"42.922695,-78.781077");
    $mainState   = 'ALL';


    $stateRes = getDBArray("tblstates", 'where active = 1 order by fldState');
    //die(print_r($stateRes,1));
    $states = ($stateRes['error_code'] == 0)? $stateRes['results']:die("An error has occured aquiring states");
    //die(print_r($states,1));
//  $userId = $_SESSION['userID'];
//  $query  = "SELECT fldMainState FROM tbluser WHERE fldID = '$userId'";
//  $result = mysql_query($query);
//  if($result && mysql_num_rows($result) > 0)
//  {
//      $row    = mysql_fetch_assoc($result);
//      if( $row['fldMainState'] == '' || strtoupper($row['fldMainState']) == 'AZ')
//      {
//          $mainAddress = '615 E. Palo Verde Dr.Phoenix, AZ 85012';
//          $mainPoint1  = '33.521942';
//          $mainPoint2  = '-112.065898';
//      }
//      else
//      {
//          $mainAddress = '7100 North Broadway Suite 1Q Denver, CO 80221';
//          $mainPoint1  = '39.826529';
//          $mainPoint2  = '-104.987621';
//      }
//
//      if(!$row['fldMainState'] == '') $mainState = $row['fldMainState'];
//  }

    if(!$row['fldMainState'] == '') $mainState = $row['fldMainState'];

    $types = $_POST['type'];

    //if not select any, use all
    if(empty($types)) $types = array('1');


    if(isset($_POST['state']))
    {
        $mainState = $_POST['state'];
    }

    $division = '';
    if(isset($_POST['division']))
    {
        $division = $_POST['division'];
    }

    $conditions = array();
    if($division != '')
    {
        $conditions[] = " FAC.fldDivisionName LIKE '%$division%' ";
    }

    if($mainState != 'ALL')
    {
        $conditions[] = " FAC.fldAddressState = '$mainState' ";
    }

    if(!empty($conditions))
    {
        $conditions = implode(' AND ', $conditions). ' AND ';
    }
    else
    {
        $conditions = '';
    }

    $numOfRecord = 0;

//  if(isset($_POST['submit']))
//  {
        $currentDate = date('Y-m-d');

        $query = array();

        //build query
        foreach($types as $type)
        {
            switch($type)
            {
                case '0': //all
                    $query[] = "SELECT FAC.*, CONCAT(ORD.fldLastName,' ',ORD.fldFirstName) AS patientName,
                                    ORD.fldDispatched,
                                    DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                    ORD.fldExamDate,
                                    ORD.fldID AS recordId,
                                    ORD.fldStat AS stat,
                                    ORD.fldOrderType,
                                    ORD.fldPrivateAddressLine1,
                                    ORD.fldPrivateAddressLine2,
                                    ORD.fldPrivateAddressCity,
                                    ORD.fldPrivateAddressState,
                                    ORD.fldPrivateAddressZip
                                FROM tblorderdetails AS ORD
                                INNER JOIN tblfacility AS FAC
                                    ON ORD.fldFacilityName = FAC.fldFacilityName
                                WHERE $conditions
                                        fldSchDate = '$currentDate'";
                break;

                case '1': //undispatched
                    $query[] = "SELECT FAC.*, CONCAT(ORD.fldLastName,' ',ORD.fldFirstName) AS patientName,
                                    ORD.fldDispatched,
                                    DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                    ORD.fldExamDate,
                                    ORD.fldID AS recordId,
                                    ORD.fldStat AS stat,
                                    ORD.fldOrderType,
                                    ORD.fldPrivateAddressLine1,
                                    ORD.fldPrivateAddressLine2,
                                    ORD.fldPrivateAddressCity,
                                    ORD.fldPrivateAddressState,
                                    ORD.fldPrivateAddressZip
                                FROM tblorderdetails AS ORD
                                INNER JOIN tblfacility AS FAC
                                    ON ORD.fldFacilityName = FAC.fldFacilityName
                                WHERE $conditions
                                        ORD.fldDispatched = 0
                                        AND fldSchDate = '$currentDate'";
                break;

                case '2': //dispatched but in-completed
                    $query[] = "SELECT FAC.*, CONCAT(ORD.fldLastName,' ',ORD.fldFirstName) AS patientName,
                                    ORD.fldDispatched,
                                    DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                    ORD.fldExamDate,
                                    ORD.fldID AS recordId,
                                    ORD.fldStat AS stat,
                                    ORD.fldOrderType,
                                    ORD.fldPrivateAddressLine1,
                                    ORD.fldPrivateAddressLine2,
                                    ORD.fldPrivateAddressCity,
                                    ORD.fldPrivateAddressState,
                                    ORD.fldPrivateAddressZip
                                FROM tblorderdetails AS ORD
                                INNER JOIN tblfacility AS FAC
                                    ON ORD.fldFacilityName = FAC.fldFacilityName
                                WHERE $conditions
                                        ORD.fldDispatched = 1
                                        AND fldTechComplete = 0
                                        AND fldSchDate = '$currentDate'";
                break;

                case '3': //dispatched completed
                    $query[] = "SELECT FAC.*, CONCAT(ORD.fldLastName,' ',ORD.fldFirstName) AS patientName,
                                    ORD.fldDispatched,
                                    DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                    ORD.fldExamDate,
                                    ORD.fldID AS recordId,
                                    ORD.fldStat AS stat,
                                    ORD.fldOrderType,
                                    ORD.fldPrivateAddressLine1,
                                    ORD.fldPrivateAddressLine2,
                                    ORD.fldPrivateAddressCity,
                                    ORD.fldPrivateAddressState,
                                    ORD.fldPrivateAddressZip
                                FROM tblorderdetails AS ORD
                                INNER JOIN tblfacility AS FAC
                                    ON ORD.fldFacilityName = FAC.fldFacilityName
                                WHERE $conditions
                                        ORD.fldDispatched = 1
                                        AND fldTechComplete = 1
                                        AND fldSchDate = '$currentDate'";
                break;
            }
        }

        $query = implode (' UNION ', $query);


        $result = mysql_query($query);

        if(!$result)
        {
            die('Query error. Query is '.$query);
        }

        //echo '<p>Query is <i>'.$query.'</i></p>';

        $undispatchedAddressArray = array();
        $dispatchedIncompletedAddressArray = array();
        $dispatchedCompletedAddressArray = array();

        $hiddenElementsArray = array();

        $finalArray = array();

        $numOfRecord = mysql_num_rows($result);
        if( $numOfRecord == 0)
        {
            echo '<font color="red">No order found</font>';
        }
        else
        {
            while($row = mysql_fetch_assoc($result))
            {
                if($row['fldOrderType'] != '3')
                    $address = $row['fldAddressLine1']." ".$row['fldAddressLine2']." ".$row['fldAddressCity']." ".$row['fldAddressState']." ".$row['fldAddressZip'];
                else
                    $address = $row['fldPrivateaAddressLine1']." ".$row['fldPrivateAddressLine2']." ".$row['fldPrivateAddressCity']." ".$row['fldPrivateAddressState']." ".$row['fldPrivateAddressZip'];

                $info = array();
                $info[] = '<b>Order #:</b> '.$row['recordId'];
                $info[] = "<a class='showPopup additionContent' rel='{$row['recordId']}' href='map_process.php?action=show_additional_details&id={$row['recordId']}'>additional Details</a>";
                $info[] = $row['fldFacilityName'];
                $info[] = $address;
                $info[] = "<a class='showPopup patientInfo' rel='{$row['recordId']}' href='map_process.php?action=show_patient&id={$row['recordId']}'>{$row['patientName']}</a>";

                //for tooltip
                $hiddenElementsArray[] = "<div style='display: none;' id='additionContent{$row['recordId']}'>".getAdditionContent($row['recordId'])."</div>";
                $hiddenElementsArray[] = "<div style='display: none;' id='patientInfo{$row['recordId']}'>".getPatientInfo($row['recordId'])."</div>";

                if($row['stat'] == '1') $info[] = '<font color="#FF0000">STAT</font>';

                if($row['fldDispatched'] == '0')//if undispatched
                {
                    $info[] = 'undispatched';
                    $info[] = "<a href='#' onclick='javascript:doChangeStatus({$row['recordId']}, 1)'>Click to Dispatch</a>";
                    $info   = implode('<br>', $info);

                    if(!isset($undispatchedAddressArray[$address]))
                    {
                        $undispatchedAddressArray[$address] = array(
                                                                array('address' => $address,
                                                                    'info'      => $info,
                                                                    'id'        => $row['recordId'],
                                                                    'type'      => '1')
                                                            );
                    }
                    else
                    {
                        $undispatchedAddressArray[$address][] = array('address' => $address,
                                                            'info'      => $info,
                                                            'id'        => $row['recordId'],
                                                            'type'      => '1');
                    }

                    if(!isset($finalArray[$address]))
                    {
                        $finalArray[$address] = array(
                                                                array('address' => $address,
                                                                    'info'      => $info,
                                                                    'id'        => $row['recordId'],
                                                                    'type'      => '1')
                                                            );
                    }
                    else
                    {
                        $finalArray[$address][] = array('address'   => $address,
                                                            'info'      => $info,
                                                            'id'        => $row['recordId'],
                                                            'type'      => '1');
                    }

                }
                else
                {
                    //if($row['fldExamDate'] == '' || $row['fldExamDate'] == '00:00:00')
                    if($row['fldTechComplete'] == 0)
                    {
                        $info[] = 'Dispatched incompleted';
                        $info[] = "<a href='#' onclick='javascript:doChangeStatus({$row['recordId']}, 0)'>Click to Undispatch</a>";
                        $info   = implode('<br>', $info);

                        if(!isset($dispatchedIncompletedAddressArray[$address]))
                        {
                            $dispatchedIncompletedAddressArray[$address] = array(
                                                                    array('address' => $address,
                                                                        'info'      => $info,
                                                                        'id'        => $row['recordId'],
                                                                        'type'      => '2')
                                                                );
                        }
                        else
                        {
                            $dispatchedIncompletedAddressArray[$address][] = array('address'    => $address,
                                                                'info'      => $info,
                                                                'id'        => $row['recordId'],
                                                                'type'      => '2');
                        }

                        if(!isset($finalArray[$address]))
                        {
                            $finalArray[$address] = array(
                                                                    array('address' => $address,
                                                                        'info'      => $info,
                                                                        'id'        => $row['recordId'],
                                                                        'type'      => '2')
                                                                );
                        }
                        else
                        {
                            $finalArray[$address][] = array('address'   => $address,
                                                                'info'      => $info,
                                                                'id'        => $row['recordId'],
                                                                'type'      => '2');
                        }

                    }
                    else
                    {
                        $info[] = 'Dispatched completed';
                        $info[] = "<a href='#' onclick='javascript:doChangeStatus({$row['recordId']}, 0)'>Click to Undispatch</a>";
                        $info   = implode('<br>', $info);

                        if(!isset($dispatchedCompletedAddressArray[$address]))
                        {
                            $dispatchedCompletedAddressArray[$address] = array(
                                                                    array('address' => $address,
                                                                        'info'      => $info,
                                                                        'id'        => $row['recordId'],
                                                                        'type'      => '3')
                                                                );
                        }
                        else
                        {
                            $dispatchedCompletedAddressArray[$address][] = array('address'  => $address,
                                                                'info'      => $info,
                                                                'id'        => $row['recordId'],
                                                                'type'      => '3');
                        }

                        if(!isset($finalArray[$address]))
                        {
                            $finalArray[$address] = array(
                                                                    array('address' => $address,
                                                                        'info'      => $info,
                                                                        'id'        => $row['recordId'],
                                                                        'type'      => '3')
                                                                );
                        }
                        else
                        {
                            $finalArray[$address][] = array('address'   => $address,
                                                                'info'      => $info,
                                                                'id'        => $row['recordId'],
                                                                'type'      => '3');
                        }

                    }
                }

            }
        //}


    }

//          $addressArray = array(
//              '343 Hickory Ln Central Square NY 13036',
//              '662 S. Main st. Central Square NY 13036',
//              '5560 Bartel Road Brewerton NY 13029-9998',
//              '60 U.S. 11 Central Sq NY 13036'
//          );

//$newArray = array_merge($undispatchedAddressArray, $dispatchedIncompletedAddressArray, $dispatchedCompletedAddressArray);

//var_dump($undispatchedAddressArray);
//var_dump($dispatchedIncompletedAddressArray);
//var_dump($dispatchedCompletedAddressArray);
//var_dump($finalArray);

//repair tech
if($role == 'dispatcher')
{
    $query = "SELECT
                fldUserName AS value,
                fldRealName AS name,
                fldOnline AS online
                FROM tbluser
            WHERE fldRole = 'technologist'
                AND fldMainState = '$userState'
                AND fldStatus='Enabled' 
            ORDER BY fldRealName
                ";
}
elseif($role == 'admin')
{
    $query = "SELECT
                    fldUserName AS value,
                    fldRealName AS name,
                    fldOnline AS online
                    FROM tbluser
            WHERE fldRole = 'technologist'
                AND fldStatus='Enabled' 
            ORDER BY fldRealName
            ";
}

$techCombo = array('<select id="tech" name="tech">');
$techCombo[] = '<option value="">Select</option>';
$result = mysql_query($query);
if(mysql_num_rows($result) > 0)
{
    while($row = mysql_fetch_assoc($result))
    {
        if($row['online'] == 1)
            $techCombo[] = "<option value='{$row['value']}'>{$row['name']}*</option>";
        else
            $techCombo[] = "<option value='{$row['value']}'>{$row['name']}</option>";
    }
}
$techCombo[] = '</select>';
$techCombo  = implode('', $techCombo);

mysql_close();

function getFilterCombo($types)
{
    $combo = array('<select name="type[]" size="4" multiple="multiple">');

    $items = array(
        '1' => 'Un-dispatched',
        '2' => 'Dispatched but in-completed',
        '3' => 'Dispatched completed'
    );

    foreach($items as $value => $text)
    {
        if(in_array($value, $types))
            $combo[] = "<option value='$value' selected='selected' >$text</option>";
        else
            $combo[] = "<option value='$value' >$text</option>";
    }
    $combo[] = '</select>';

    return implode('', $combo);
}

?>
<!-- 
<html>
    <head>
        <title>MD Imaging  - Order Mapping system</title>
        <link href="menu/menu_style.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="map_images/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="map_images/jquery.tooltip.css" media="screen" />
        <style>
            body{
                font-size: 12px; font-family: sans-serif;
            }
#top1 {
  background: url(top.png);
  position: absolute;
  top: 0px;
  left: 0px;
  width: 10%;
  height: 22px;
  padding-left:5px;
}
#top2 {
  background: url(top.png);
  position: absolute;
  top: 0px;
  left: 76px;
  width: 90%;
  height: 22px;
  vertical-align:middle;
}
#top2a {
  position: absolute;
  top: 5px;
  left: 0px;
  width: 100%;
  height: 17px;
  vertical-align:middle;
}
#top3 {
  background: url(top.png);
  position: absolute;
  left: 95%;
  top: 0px;
  width: 64px;
  height: 22px;
}

#header1 {
  background: url(bg.png);
  position: absolute;
  top: 22px;
  vertical-align: top;
  left: 0px;
  width: 100%;
  height: 79px;
}

#header2 {
  background: url(bg.png);
  position: absolute;
  top: 22px;
  left: 500px;
  width: 550px;
  height: 79px;
}
</style>
    </head>
    <body>
            <div id="top1">
                <img src="home.png" border="0" usemap="#Map" />
                <map name="Map">
                    <area shape="rect" coords="3,3,46,19" href="index.php?pg=20">
                </map>
            </div>
            <div id="top2">
                <?php
                    include 'top_nav.php';
                ?>
            </div>
            <div id="top3"><a href="logout.php"><img src="logout.png" border="0" /></a></div>
            <div id="header1"><img src="logo.png" align="left" /></div>

<!--            <div class="header2" id="header2">
              <div align="center" class="banner">
                <blockquote>
                  <p align="right"></p>
                  </blockquote>
              </div>
            </div>-->

<div style="float: left;width: 100%; padding-top: 100px; padding-bottom: 100px;">
        <h3>MD Imaging  - Order Mapping system</h3>
        <form id="formData" method="post" action="">
            <table>
                <tr>
                    <td>Filter</td>
                    <td>
                        <?php
                            echo getFilterCombo($types);
                        ?>
                    </td>
                    <td>State</td>
                    <td>
                    	<select id="state" name="state">
					<?php
					$selected = ($sql_values_fetch['fldAddressState'] === 'NY')?'selected="selected"':'';
					echo "<option value='NY' $selected>NY</option>";
					
					/*
					if(is_array($states[0])):
						foreach ($states as $state):
							$selected = ($sql_values_fetch['fldAddressState'] === $state['fldState'])?'selected="selected"':'';
							echo "<option value='{$state['fldSt']}' $selected>{$state['fldState']}</option>";
						endforeach;
					else:
						echo "<option value='{$states['fldSt']}' selected='selected'>{$states['fldState']}</option>";
					endif;*/
					?>
						</select>
                    </td>
                    <td>Division</td>
                    <td>
                        <?php
                            echo getDivisionCombo($division);
                        ?>
                    </td>
                    <td></td>
                    <td>
                        <input type="submit" value="MAP IT" name="submit" />
                    </td>
                </tr>
            </table>
        </form>
        <br/>
        <div style="width: 100%; float:left; text-align: center" id="divProcessing">

        </div>
        <div style="width:100%">
            <div style="float:left;width:20%;height: 960px;overflow: scroll">
                <h4>Order list of <?php echo date('m-d-Y');?></h4>
                <?php
                    if($numOfRecord > 0)
                    {
                        $i = 0;
                        if(isset($undispatchedAddressArray) && !empty($undispatchedAddressArray))
                        {
                            echo '<span style="color:#0000FF;font-weight:bold;size:16px;">Undispatched</span><br>';
                            foreach($undispatchedAddressArray as $key => $child)
                            {
                                $info = array();
                                foreach($child as $property)
                                {
                                    $info[] = $property['info'];
                                }
                                $info = implode('<br><br>', $info);

                                echo $info.'<br/><br/>';
                            }
                        }

                        $i = 0;
                        if(isset($dispatchedIncompletedAddressArray) && !empty($dispatchedIncompletedAddressArray))
                        {
                            echo '<span style="color:#0000FF;font-weight:bold;size:16px;">Dispatched Incompleted</span><br>';
                            foreach($dispatchedIncompletedAddressArray as $key => $child)
                            {
                                $info = array();
                                foreach($child as $property)
                                {
                                    $info[] = $property['info'];
                                }
                                $info = implode('<br><br>', $info);

                                echo $info.'<br/><br/>';
                            }
                        }

                        $i = 0;
                        if(isset($dispatchedCompletedAddressArray) && !empty($dispatchedCompletedAddressArray))
                        {
                            echo '<span style="color:#0000FF;font-weight:bold;size:16px;">Dispatched Completed</span><br>';
                            foreach($dispatchedCompletedAddressArray as $key => $child)
                            {
                                $info = array();
                                foreach($child as $property)
                                {
                                    $info[] = $property['info'];
                                }
                                $info = implode('<br><br>', $info);

                                echo $info.'<br/><br/>';
                            }
                        }

                    }
                    else
                    {
                        echo 'no order';
                    }
                ?>
            </div>
            <div style="float:left;width:80%">
                <div id="map_canvas" style="width: 100%px; height: 960px;"></div>
            </div>
        </div>
        <div style="display:none"><img src="map_images/ajax_loader.gif" /></div>
        <div style="display: none;">
            <div id="popupTech" style="width:300px;height:100px;">
                <p>Select Technologist <?php echo $techCombo; ?></p>
                <p>
                    <input type="button" value="Dispatch" id="doDispatch" />
                    <input type="button" value="Cancel" id="closeDispatch" />
                </p>
            </div>
        </div>

        <?php
            echo implode('', $hiddenElementsArray);
        ?>
</div>
    </body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="map_images/jquery.blockUI.js"></script>
<script type="text/javascript" src="map_images/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="map_images/jquery.tooltip.js"></script>
<script type="text/javascript">
    var geocoder = new google.maps.Geocoder();
    var map;
    var infowindow;
    var gmarkers;
    var i=0;
    var wait = false;
    var selectedId = null;
    var mainAddress = '<?php echo $mainAddress; ?>';
    var mainPoint1 = <?php echo $mainPoint1; ?>;
    var mainPoint2 = <?php echo $mainPoint2; ?>;

    function initialize() {
        var latlng = new google.maps.LatLng(mainPoint1, mainPoint2);
        var myOptions = {
            zoom: 8,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        map.setCenter(latlng, 13);

        var image = new google.maps.MarkerImage(
            'map_images/center.png',
            new google.maps.Size(30,47),
            new google.maps.Point(0,0),
            new google.maps.Point(15,47)
        );

        var shadow = new google.maps.MarkerImage(
            'map_images/center_shadow.png',
            new google.maps.Size(58,47),
            new google.maps.Point(0,0),
            new google.maps.Point(15,47)
        );

        var shape = {
            coord: [29,1,29,2,29,3,29,4,29,5,29,6,29,7,29,8,29,9,29,10,29,11,29,12,29,13,29,14,29,15,29,16,29,17,29,18,29,19,29,20,29,21,27,22,25,23,2,24,2,25,2,26,2,27,2,28,2,29,2,30,2,31,2,32,2,33,2,34,2,35,2,36,2,37,2,38,2,39,2,40,2,41,2,42,2,43,2,44,2,45,2,46,0,46,0,45,0,44,0,43,0,42,0,41,0,40,0,39,0,38,0,37,0,36,0,35,0,34,0,33,0,32,0,31,0,30,0,29,0,28,0,27,0,26,0,25,0,24,0,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,4,2,5,1,29,1],
            type: 'poly'
        };

        var marker = new google.maps.Marker({
                        map: map,
                        position: latlng,
                        icon: image,
                        shadow: shadow,
                        shape: shape
        });

        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(mainAddress);
            infowindow.open(map, this);
        });

        <?php
            if(isset($finalArray) && !empty($finalArray))
            {
                foreach($finalArray as $key => $child)
                {
                    $address = addslashes($key);
                    $info = array();
                    $image = array();

                    foreach($child as $property)
                    {
                        $info[] = addslashes($property['info']);
                        $image[$property['type']] = true;
                    }
                    $info = implode('<hr>', $info);
                    ksort($image);

                    $temp = '';
                    foreach($image as $index => $value)
                    {
                        $temp .= $index;
                    }

                    echo "codeAddress('$address','$info', '$temp');";
                }
            }
        ?>
    }

    function codeAddress(address,info, number) {

        var image = new google.maps.MarkerImage(
          'map_images/'+ number +'.png',
            new google.maps.Size(30,52),
            new google.maps.Point(0,0),
            new google.maps.Point(0,52)
        );

        var shadow = new google.maps.MarkerImage(
          'map_images/shadow.png',
            new google.maps.Size(60,52),
            new google.maps.Point(0,0),
            new google.maps.Point(0,52)
        );

        var shape = {
          coord: [19,0,21,1,23,2,24,3,25,4,26,5,27,6,27,7,28,8,28,9,29,10,29,11,29,12,29,13,29,14,29,15,29,16,29,17,29,18,29,19,29,20,28,21,28,22,27,23,27,24,26,25,25,26,24,27,24,28,23,29,22,30,22,31,21,32,21,33,20,34,20,35,20,36,19,37,19,38,18,39,18,40,18,41,17,42,17,43,17,44,17,45,17,46,16,47,16,48,16,49,16,50,16,51,14,51,13,50,13,49,13,48,13,47,13,46,12,45,12,44,12,43,12,42,12,41,11,40,11,39,11,38,10,37,10,36,9,35,9,34,9,33,8,32,8,31,7,30,6,29,6,28,5,27,4,26,4,25,3,24,2,23,2,22,1,21,1,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,1,8,1,7,2,6,3,5,3,4,4,3,6,2,7,1,9,0,19,0],
          type: 'poly'
        };

        if(geocoder)
        {
            while (wait) { /* Just wait. This is a nasty way to do it, you may want a
            more elaborate one that won't "freeze" your browser. */ };

            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    //map.setCenter(results[0].geometry.location);

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: image,
                        shadow: shadow,
                        shape: shape
                    });

                    infowindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(info);
                        infowindow.open(map, this);

                        //for tooltip & popup
                        $('a.showPopup').fancybox({
                            showNavArrows : false
                        });

                        $("a.additionContent").tooltip({
                            bodyHandler: function() {
                                return $('#additionContent' + $(this).attr("rel")).html();
                            },
                            showURL: false
                        })

                        $("a.patientInfo").tooltip({
                            bodyHandler: function() {
                                return $('#patientInfo' + $(this).attr("rel")).html();
                            },
                            showURL: false
                        })
                    });

                } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                    wait = true;
                    setTimeout("wait = false", 1000);
                } else {
                    alert("Geocode was not successful for the following reason: " + status + '. Address is ' + address);
                }
            });
        }
    }

    function focusPin(index)
    {
        gmarkers[index].openInfoWindowHtml();
        return false;
    }

    $(document).ready(function(){
        $('#formData').submit(function(){

            if($('#zoom_value').val() == '' || $('#zoom_value').val() < 1)
            {
                alert('Please enter valid zoom value');
                return false;
            }

            return true;
        });

        initialize();

        $('#doDispatch').click(function(){
            if(selectedId == null)
            {
                alert('No order# selected');
                return false;
            }
            if($('#tech').val() == '')
            {
                alert('Please select Technologist');
                return false;
            }

            processChange(selectedId, 1);
            selectedId = null;

            $.fancybox.close();

            return false;
        });

        $('#closeDispatch').click(function(){
            $.fancybox.close();
        })

        $('a.showPopup').fancybox({
            showNavArrows : false
        });

        $("a.additionContent").tooltip({
            bodyHandler: function() {
                return $('#additionContent' + $(this).attr("rel")).html();
            },
            showURL: false
        })

        $("a.patientInfo").tooltip({
            bodyHandler: function() {
                return $('#patientInfo' + $(this).attr("rel")).html();
            },
            showURL: false
        })

    })

    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    function doChangeStatus(id, status)
    {
        if(status == 1)
        {
            selectedId = id;
            //popup for select tech
            $.fancybox({
                'titlePosition'     : 'inside',
                'transitionIn'      : 'none',
                'transitionOut'     : 'none',
                'href'              : '#popupTech'
            });
            return false;
        }
        else
        {
            return processChange(id, status);
        }
    }

    function processChange(id, status)
    {
//      var sTag = '<font color="#FF0000" size="16">Please wait...</font>';
//
//      $.blockUI({
//          overlayCSS: {backgroundColor: ''},
//          css: {
//          border: 'none',
//          padding: '15px',
//          backgroundColor: '#000',
//          '-webkit-border-radius': '10px',
//          '-moz-border-radius': '10px',
//          opacity: .5,
//          color: '#fff'
//          },
//          message: '<img src="map_images/ajax_loader.gif" /><br>' + sTag
//      });
//      set

        $.ajax({
                        url: 'map_process.php',
                        type: 'POST',
                        data: 'action=do_dispatch' + '&id='+ id + '&status=' + status + '&tech=' + $('#tech').val(),
                        dataType: 'json',
                        timeout: 600000,
                        beforeSend: function(){
                                //$('#divProcessing').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(data){
                                alert('Canot process. Error :' + data);
                        },
                        success: function(returnData) {

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            alert(returnData.data);

                            if(returnData.result)
                            {
                                location.reload(true);
                            }

                        }
        });

        return false;
    }

</script>
</html>