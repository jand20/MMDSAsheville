<!DOCTYPE html>
<?php

    session_start();

//  if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'dispatcher'))
//  {
//      die('Access denined');
//   test for DP 
//  }

    require_once 'division_config.php';
    require_once 'config.php';

    //default is AZ
    $mainAddress = '615 E. Palo Verde Dr.Phoenix, AZ 85012';
    $mainPoint1  = '33.521942';
    $mainPoint2  = '-112.065898';

    $userId = $_SESSION['userID'];
    $query  = "SELECT fldMainState FROM tbluser WHERE fldID = '$userId'";
    $result = mysql_query($query);
    if($result && mysql_num_rows($result) > 0)
    {
        $row    = mysql_fetch_assoc($result);
        var_dump($row);
        if( $row['fldMainState'] == '' || strtoupper($row['fldMainState']) == 'AZ')
        {
            $mainAddress = '615 E. Palo Verde Dr.Phoenix, AZ 85012';
            $mainPoint1  = '33.521942';
            $mainPoint2  = '-112.065898';
        }
        else
        {
            $mainAddress = '7100 North Broadway Suite 1Q Denver, CO 80221';
            $mainPoint1  = '39.826529';
            $mainPoint2  = '-104.987621';
        }
    }

    $type = 1;
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
    }

    $division = '';
    if(isset($_POST['division']))
    {
        $division = $_POST['division'];
    }

    $divisionCondition = '';
    if($division != '')
    {
        $divisionCondition = "FAC.fldDivisionName LIKE '%$division%' AND ";
    }

    $numOfRecord = 0;

//  if(isset($_POST['submit']))
//  {
        $currentDate = date('Y-m-d');

        //build query
        switch($type)
        {
            case '0': //all
                $query = "SELECT FAC.*, CONCAT(ORD.fldFirstName,' ',ORD.fldLastName) AS patientName,
                                ORD.fldDispatched,
                                DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                ORD.fldExamDate,
                                ORD.fldID AS recordId,
                                ORD.fldStat AS stat
                            FROM tblorderdetails AS ORD
                            INNER JOIN tblfacility AS FAC
                                ON ORD.fldFacilityName = FAC.fldFacilityName
                            WHERE $divisionCondition
                                    fldSchDate = '$currentDate'";
            break;

            case '1': //undispatched
                $query = "SELECT FAC.*, CONCAT(ORD.fldFirstName,' ',ORD.fldLastName) AS patientName,
                                ORD.fldDispatched,
                                DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                ORD.fldExamDate,
                                ORD.fldID AS recordId,
                                ORD.fldStat AS stat
                            FROM tblorderdetails AS ORD
                            INNER JOIN tblfacility AS FAC
                                ON ORD.fldFacilityName = FAC.fldFacilityName
                            WHERE $divisionCondition
                                    ORD.fldDispatched = 0
                                    AND fldSchDate = '$currentDate'";
            break;

            case '2': //dispatched but in-completed
                $query = "SELECT FAC.*, CONCAT(ORD.fldFirstName,' ',ORD.fldLastName) AS patientName,
                                ORD.fldDispatched,
                                DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                ORD.fldExamDate,
                                ORD.fldID AS recordId,
                                ORD.fldStat AS stat
                            FROM tblorderdetails AS ORD
                            INNER JOIN tblfacility AS FAC
                                ON ORD.fldFacilityName = FAC.fldFacilityName
                            WHERE $divisionCondition
                                    ORD.fldDispatched = 1
                                    AND (fldExamDate IS NULL OR fldExamDate = '00:00:00')
                                    AND fldSchDate = '$currentDate'";
            break;

            case '3': //dispatched completed
                $query = "SELECT FAC.*, CONCAT(ORD.fldFirstName,' ',ORD.fldLastName) AS patientName,
                                ORD.fldDispatched,
                                DATE_FORMAT(ORD.fldSchDate,'%m-%d-%Y') AS fldSchDateMDY,
                                ORD.fldExamDate,
                                ORD.fldID AS recordId,
                                ORD.fldStat AS stat
                            FROM tblorderdetails AS ORD
                            INNER JOIN tblfacility AS FAC
                                ON ORD.fldFacilityName = FAC.fldFacilityName
                            WHERE $divisionCondition
                                    ORD.fldDispatched = 1
                                    AND (fldExamDate <> '00:00:00' AND fldExamDate IS NOT NULL)
                                    AND fldSchDate = '$currentDate'";
            break;
        }


        $result = mysql_query($query);

        if(!$result)
        {
            die('Query error. Query is '.$query);
        }

        //echo '<p>Query is <i>'.$query.'</i></p>';

        $undispatchedAddressArray = array();
        $dispatchedIncompletedAddressArray = array();
        $dispatchedCompletedAddressArray = array();

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
                $address = $row['fldAddressLine1']." ".$row['fldAddressLine2']." ".$row['fldAddressCity']." ".$row['fldAddressState'];

                $info = array();
                $info[] = '<b>Order #:</b> '.$row['recordId'];
                $info[] = $row['fldFacilityName'];
                $info[] = $address;
                $info[] = $row['patientName'];

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
                    if($row['fldExamDate'] == '' || $row['fldExamDate'] == '00:00:00')
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
$query = "SELECT fldRealName AS name FROM tbluser WHERE fldRole = 'technologist' AND fldStatus='Enabled' ";
$techCombo = array('<select id="tech" name="tech">');
$techCombo[] = '<option value="">Select</option>';
$result = mysql_query($query);
if(mysql_num_rows($result) > 0)
{
    while($row = mysql_fetch_assoc($result))
    {
        $techCombo[] = "<option value='{$row['name']}'>{$row['name']}</option>";
    }
}
$techCombo[] = '</select>';
$techCombo  = implode('', $techCombo);

mysql_close();

?>
<html>
    <head>
        <title>MD Imaging  - Order Mapping system</title>
        <link href="menu/menu_style.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="map_images/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
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
                <div class="top" id="top2a" align="left">User <?echo $_SESSION['user'];?>  |<?
                if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='coder') {?>
                <a href="?pg=36" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Report  </a> |
                <? } ?>
                <?
                if( $_SESSION['role'] == 'admin' ) {?>
                <a href="?pg=55" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">  </a> |
                <? } ?>
                <a href="?pg=34" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Legend  </a> |
                <?php
                    if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'dispatcher' || 1)
                    {
                        echo '<a href="map.php" target="_blank" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Map It  </a> |';
                    }
                ?>
                <a href="?pg=43" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Change Password</a>
                <? if( $_SESSION['role'] == 'technologist' ) {?>
                 | <a href="?pg=44" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Tech Report  </a><? } ?>
                 <? if( $_SESSION['role'] == 'facilityuser' ) {?>
                 | <a href="?pg=45" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">Facility Report  </a>
                  | <a href="?pg=63" style="color:#fff;text-decoration:none; padding-left:10px;align: left;">  </a>
                 <? } ?>
              </div>
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
        <form id="formData" method="POST" action="map.php">
            <table>
                <tr>
                    <td>Filter</td>
                    <td>
                        <select id="type" name="type">
                            <option value="0" <?php echo ($type == '0' ? "selected='selected'" : '') ?> >All</option>
                            <option value="1" <?php echo ($type == '1' ? "selected='selected'" : '') ?> >Un-dispatched</option>
                            <option value="2" <?php echo ($type == '2' ? "selected='selected'" : '') ?> >Dispatched but in-completed</option>
                            <option value="3" <?php echo ($type == '3' ? "selected='selected'" : '') ?> >Dispatched completed</option>
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
</div>
    </body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="map_images/jquery.blockUI.js"></script>
<script type="text/javascript" src="map_images/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
    var geocoder;
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
        //var marker = new GMarker(latlng);
        var marker = new google.maps.Marker({
                        map: map,
                        position: latlng
//                      icon: image,
//                      shadow: shadow,
//                      shape: shape
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

                    map.setCenter(results[0].geometry.location);

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
                    });

                } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                    alert(status);
                    wait = true;
                    setTimeout("wait = false", 1000);
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
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
                        data: 'id='+ id + '&status=' + status + '&tech=' + $('#tech').val(),
                        dataType: 'json',
                        timeout: 600000,
                        beforeSend: function(){
                                //$('#divProcessing').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(data){
                                alert('Canot process. Error :' + data);
                        },
                        success: function(returnData) {
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