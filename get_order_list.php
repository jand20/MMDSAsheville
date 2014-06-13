<?php

    function factoryResult($data, $result = true)
    {
        return json_encode(array(
            'data'      => $data,
            'result'    => $result
        ));
    }

    session_start();

    //check user logged
    if(!isset($_SESSION['user']) || $_SESSION['user'] == '')
    {
        echo factoryResult('TIME_OUT');
        die;
    }

    //get info
    $role       = $_SESSION['role'];
    $userState  = $_SESSION['userState'];
    $userName   = $_SESSION['user'];
    $userId     = $_SESSION['userID'];
    $facility   = $_SESSION['facility'];

    require_once 'config.php';

    //get user infos
    $query  = "SELECT * FROM tbluser WHERE fldUserName = '$userName' ";
    $result = mysql_query($query);
    $row    = mysql_fetch_assoc($result);
    $orphy  = mysql_real_escape_string($row['fldRealName']);
    $facid  = $row['fldID'];

//    //repair modality
//    $query = "SELECT fldModality AS modality, fldDescription AS name FROM tblproceduremanagment";
//    $modalityCached = array();
//    $result = mysql_query($query);
//    if(mysql_num_rows($result) > 0)
//    {
//        while($row = mysql_fetch_assoc($result))
//        {
//            $modalityCached[$row['name']] = $row['modality'];
//        }
//    }

    //cache form conditions
    $_SESSION['formCached'] = $_POST['formCached'];


    //get conditions
    $where = array();

    //required
    if($role === 'orderingphysician')
    {
    	$where[] = "tblorderdetails.fldAuthorized = '0'";
    }

    //keyword
    if($_POST['keyword'] != '')
    {
        $text = str_replace("*", "%", $_POST['keyword']);
        $where[] = "tblorderdetails.".$_POST['keywordType']." LIKE '".  mysql_real_escape_string($text)."'";
    }

	//keyword 2
    if($_POST['keyword2'] != '')
    {
        $text = str_replace("*", "%", $_POST['keyword2']);
        $where[] = "tblorderdetails.".$_POST['keywordType2']." LIKE '".  mysql_real_escape_string($text)."'";
    }

    //lab
    if(isset($_POST['lab']))
    {
        $childWhere = array();
        foreach($_POST['lab'] as $lab)
        {
            $childWhere[] = "tblorderdetails.fldordertype = '".mysql_real_escape_string($lab)."'";
        }
        $where[] = '('.implode(' OR ', $childWhere).')';
    }

    //division
    if(isset($_POST['division']) && $_POST['division'] != '')
    {
        $divisionList = $_POST['division'];
        $childWhere = array();
        foreach($divisionList as $division)
        {
            $childWhere[] = "tblfacility.fldDivisionName = '".mysql_real_escape_string($division)."'";
        }
        $where[] = '('.implode(' OR ', $childWhere).')';
    }

    //state only show for select for ADMIN, others will be fixed as hidden element
    //so no need check admin logged or others :).
    if(isset($_POST['state']) && $_POST['state'] != '')
    {
        $where[] = "tblfacility.fldAddressState = '".  mysql_real_escape_string($_POST['state'])."'";
    }

    //orderstatus
    $status = $_POST['status'];
    switch($status)
    {
        case 'nondist':
            $where[] = "tblorderdetails.fldDispatched = 0";
        break;

        case 'dist_notcomplete':
            $where[] = "tblorderdetails.fldDispatched = 1 AND fldTechComplete = 0";
        break;

        case 'completed':
            $where[] = "tblorderdetails.fldDispatched = 1 AND fldTechComplete = 1";
        break;

        case 'canceled':
            $where[] = "tblorderdetails.fldStatus = 1";
        break;

        case 'default': //excluded canceled
            $where[] = "tblorderdetails.fldStatus <> 1";
        break;

        case 'all': //we don't do date check with all, get all
        break;
    }

    //modality
    if(isset($_POST['modality']) && $_POST['modality'] != '')
    {
        $modality = mysql_real_escape_string($_POST['modality']);
        $childQuery = "SELECT DISTINCT(fldDescription) FROM tblproceduremanagment WHERE fldModality = '$modality'";

        $childWhere = array();
        for($i = 1; $i <= 10 ;$i++)
        {
            $childWhere[] = "tblorderdetails.fldProcedure{$i} IN ($childQuery)";
        }

        $where[] = '('.implode(' OR ', $childWhere).')';
    }

    //type create records
    $time = $_POST['time'];
    switch($time)
    {
        case 'today':
                //what will we do for today?
            $currentDate = date('Y-m-d');
            $sdate = $currentDate.' 00:00:00';
            $edate= $currentDate.' 23:59:59';

            $where[] = "tblorderdetails.fldSchDate >= '$sdate' and tblorderdetails.fldSchDate <= '$edate'";
        break;

        case 'yesterday':
            $date   = date("Y-m-d", strtotime("-1 day"));
            $sdate  = $date.' 00:00:00';
            $edate  = $date.' 23:59:59';

            $where[] = "tblorderdetails.fldSchDate >= '$sdate' and tblorderdetails.fldSchDate <= '$edate'";
        break;

        case 'tomorrow':
            $date   = date("Y-m-d", strtotime("1 day"));
            $sdate  = $date.' 00:00:00';
            $edate  = $date.' 23:59:59';

            $where[] = "tblorderdetails.fldSchDate >= '$sdate' and tblorderdetails.fldSchDate <= '$edate'";
        break;


        case 'week':
            //old code
            $stdate=date('c',strtotime(date('Y')."W".date('W')."0"));
            $etdate=date('c',strtotime(date('Y')."W".date('W')."7"));
            $sdate = strftime("%Y-%m-%d", strtotime($stdate));
            $edate = strftime("%Y-%m-%d", strtotime($etdate));
            $sdate .=" 00:00:00";
            $edate .=" 23:59:59";

            $where[] = "tblorderdetails.fldSchDate >= '$sdate' and tblorderdetails.fldSchDate <= '$edate'";

        break;

        case 'month':
            //old code
            $curtime = date("Y-m-d",time());
            $sDate   = split('-', $curtime);
            $num = cal_days_in_month(CAL_GREGORIAN, $sDate[1], $sDate[0]) ;
            $stdate=$sDate[0].'-'.$sDate[1].'-01 00:00:00';
            $enddate=$sDate[0].'-'.$sDate[1].'-'.$num. ' 23:59:59';

            $where[] = "tblorderdetails.fldSchDate >= '$stdate' and tblorderdetails.fldSchDate <= '$enddate'";


        break;

        case 'all': //we don't do date check with all, get all
        break;
    }

    //use date range
    if($time == '')
    {
        //fromDate
        if($_POST['fromDate'] != '')
        {
            $fromDate   = date("Y-m-d", strtotime($_POST['fromDate']));
            $where[]    = "DATE(tblorderdetails.fldSchDate) >= '$fromDate'";
        }

        //toDate
        if($_POST['toDate'] != '')
        {
            $toDate     = date("Y-m-d", strtotime($_POST['toDate']));
            $where[]    = "DATE(tblorderdetails.fldSchDate) <= '$toDate'";
        }
    }

    //other rule ?

    if($role == 'orderingphysician')
    {
        $where[] = "tblorderdetails.fldOrderingPhysicians = '$orphy'";
    }
    elseif($role =='dispatcher' || $role =='coder')
    {
        //no condition?
    }
    elseif($role =='facilityuser')
    {
        //need ask required each facility will assigned for 1 user or not ?
        //should use subquery, not required each user will have facility assigned
        $where[] = "tblorderdetails.fldFacilityName IN(SELECT DISTINCT fldFacility FROM tbluserfacdetails WHERE tbluserfacdetails.flduserid = '$facid')";

    }
    elseif($role =='technologist')
    {
        $where[] = "tblorderdetails.fldTechnologist = '$userName'";
    }

    //build where
    if(!empty($where))
    {
        $where = "WHERE " .implode(" AND " ,$where);
    }
    else
    {
        $where = '';
    }

    if($_POST['initView'] == '1')
    {
        //init view
        $order = $_POST['sortField'];
    }
    else
    {
        $sortField = array(
            '1' => 'tblorderdetails.fldDate ' . $_POST['sortBy'],
            '2' => 'tblorderdetails.fldSchDate '.$_POST['sortBy'],
            '3' => 'tblorderdetails.fldPatientID '.$_POST['sortBy'],
            '4' => 'fldLastName '.$_POST['sortBy'].' , fldFirstName '.$_POST['sortBy'],
            '5' => 'fldProcedure1 '.$_POST['sortBy'].', fldProcedure2 '.$_POST['sortBy'].', fldProcedure3 '.$_POST['sortBy'].', fldProcedure4 '.$_POST['sortBy'],
            '6' => 'modality1 '.$_POST['sortBy'].', '.'modality2 '.$_POST['sortBy']
                    .', modality3 '.$_POST['sortBy'].', modality4 '.$_POST['sortBy']
                    .', modality5 '.$_POST['sortBy'].', modality6 '.$_POST['sortBy']
                    .', modality7 '.$_POST['sortBy'].', modality8 '.$_POST['sortBy']
                    .', modality9 '.$_POST['sortBy'].', modality10 '.$_POST['sortBy'],
            '7' => 'tblfacility.fldDivisionName '.$_POST['sortBy'],
            '8' => 'tblorderdetails.fldFacilityName '.$_POST['sortBy'].', fldStation '.$_POST['sortBy'],
            '9' => 'tblorderdetails.fldDOB '.$_POST['sortBy'],
            '10'=> 'tblorderdetails.fldTechnologist '.$_POST['sortBy'],
            '11'=> 'tblorderdetails.fldRequestedBy '.$_POST['sortBy'],
            '12' => 'tblorderdetails.fldOrderingPhysicians '.$_POST['sortBy']
        );

        $order = $sortField[$_POST['sortField']];
    }

    //#4  put orders where fldTechCompleted to "1"   last!
    $order .= " , fldTechComplete";

    //page
    $current_page   = $_POST['page'];
    $viewBy         = $_POST['viewBy'];

    $selectField = "select tblorderdetails.fldID,
                                tblorderdetails.fldFacilityName,
                                fldSchDate,
                                fldOrderingPhysicians,
                                fldAuthorized,
                                tblorderdetails.fldTechnologist,
                                fldDate,
                                fldAfterhours,
                                fldTechComplete,
                                fldStat,
                                fldDispatched,
                                fldPatientID,
                                fldLastName,
                                fldFirstName,
                                fldProcedure1,
                                fldProcedure2,
                                fldProcedure3,
                                fldProcedure4,
                                fldProcedure5,
                                fldProcedure6,
                                fldProcedure7,
                                fldProcedure8,
                                fldProcedure9,
                                fldProcedure10,
                                fldplr1,
                                fldplr2,
                                fldplr3,
                                fldplr4,
                                fldplr5,
                                fldplr6,
                                fldplr7,
                                fldplr8,
                                fldplr9,
                                fldplr10,
                                fldRequestedBy,
                                fldVerbal,
                                fldCoded,
                                fldException1,
                                fldException2,
                                fldException3,
                                fldStation,
                                fldDOB,
                                fldSymptoms,
                                fldHistory,
                                tblfacility.fldDivisionName,
                                tblorderdetails.fldStatus AS cancelStatus,
                                countNotes.totalNotes,
                                t1.fldModality AS modality1,
                                t2.fldModality AS modality2,
                                t3.fldModality AS modality3,
                                t4.fldModality AS modality4,
                                t5.fldModality AS modality5,
                                t6.fldModality AS modality6,
                                t7.fldModality AS modality7,
                                t8.fldModality AS modality8,
                                t9.fldModality AS modality9,
                                t10.fldModality AS modality10
                                ";

    if($viewBy == 'page')
    {

        $query = "$selectField
                    FROM tblorderdetails
                        INNER JOIN tblfacility
                                ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName

                        LEFT JOIN
                            (SELECT COUNT(1) AS totalNotes, order_id
                            FROM order_notes
                            GROUP BY order_id) AS countNotes
                            ON countNotes.order_id = tblorderdetails.fldID

                        LEFT JOIN tblproceduremanagment AS t1
                            ON t1.fldDescription = tblorderdetails.fldProcedure1
                        LEFT JOIN tblproceduremanagment AS t2
                            ON t2.fldDescription = tblorderdetails.fldProcedure2
                        LEFT JOIN tblproceduremanagment AS t3
                            ON t3.fldDescription = tblorderdetails.fldProcedure3
                        LEFT JOIN tblproceduremanagment AS t4
                            ON t4.fldDescription = tblorderdetails.fldProcedure4
                        LEFT JOIN tblproceduremanagment AS t5
                            ON t5.fldDescription = tblorderdetails.fldProcedure5
                        LEFT JOIN tblproceduremanagment AS t6
                            ON t6.fldDescription = tblorderdetails.fldProcedure6
                        LEFT JOIN tblproceduremanagment AS t7
                            ON t7.fldDescription = tblorderdetails.fldProcedure7
                        LEFT JOIN tblproceduremanagment AS t8
                            ON t8.fldDescription = tblorderdetails.fldProcedure8
                        LEFT JOIN tblproceduremanagment AS t9
                            ON t9.fldDescription = tblorderdetails.fldProcedure9
                        LEFT JOIN tblproceduremanagment AS t10
                            ON t10.fldDescription = tblorderdetails.fldProcedure10

                    $where
                    ORDER BY $order";
       //echo factoryResult($query);die;
//die('<pre>'.print_r($query,1).'</pre>');
        $result     = mysql_query($query);
        $total_row  = mysql_num_rows($result);

        if($total_row == '0')
        {
            mysql_close();
            $data;

            if($_REQUEST['keywordType'] == 'fldPatientSSN' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&ssn=$ssn'>Add Nursing Home Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&ssn=$ssn'>Add Correctional Facility Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&ssn=$ssn'>Add Home Bound Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&ssn=$ssn'>Add Lab Order for SSN : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldLastName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&lname=$ssn'>Add Nursing Home Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&lname=$ssn'>Add Correctional Facility Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&lname=$ssn'>Add Home Bound Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&lname=$ssn'>Add Lab Order for Last Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFirstName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fname=$ssn'>Add Nursing Home Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fname=$ssn'>Add Correctional Facility Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fname=$ssn'>Add Home Bound Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fname=$ssn'>Add Lab Order for First Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFacilityName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fclty=$ssn'>Add Nursing Home Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fclty=$ssn'>Add Correctional Facility Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fclty=$ssn'>Add Home Bound Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fclty=$ssn'>Add Lab Order for Facility : $ssn</option>";
                $data .= '</select>';
            }

 /*
            else if($_REQUEST['keywordType'] == 'fldDate' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&flddate=$ssn'>Add Nursing Home Order for Order Date : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&flddate=$ssn'>Add Correctional Facility Order for Order Date : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&flddate=$ssn'>Add Home Bound Order for Order Date : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&flddate=$ssn'>Add Lab Order for Order Date : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldSchDate' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&exmdate=$ssn'>Add Nursing Home Order for Exam Date : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&exmdate=$ssn'>Add Correctional Facility Order for Exam Date : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&exmdate=$ssn'>Add Home Bound Order for Order Exam : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&exmdate=$ssn'>Add Lab Order for Order Exam : $ssn</option>";
                $data .= '</select>';
            }
 */

            echo json_encode(array(
                'result'    => true,
                'data'      => 'NO RECORD FOUND '.$data,
                'total'     => '0'
            ));
            die;
        }

        require_once 'PagingHelper.php';

        $total_page = ceil($total_row/FRONT_END_ROW_PER_PAGE);
        if ($current_page > $total_page)
        {
            $current_page = $total_page;
        }
        $offset = ( $current_page - 1 ) * FRONT_END_ROW_PER_PAGE;
        $limit = FRONT_END_ROW_PER_PAGE;

        $query = "$selectField
                    FROM tblorderdetails
                        INNER JOIN tblfacility
                                ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
                        LEFT JOIN
                            (SELECT COUNT(1) AS totalNotes, order_id
                            FROM order_notes
                            GROUP BY order_id) AS countNotes
                            ON countNotes.order_id = tblorderdetails.fldID

                        LEFT JOIN tblproceduremanagment AS t1
                            ON t1.fldDescription = tblorderdetails.fldProcedure1
                        LEFT JOIN tblproceduremanagment AS t2
                            ON t2.fldDescription = tblorderdetails.fldProcedure2
                        LEFT JOIN tblproceduremanagment AS t3
                            ON t3.fldDescription = tblorderdetails.fldProcedure3
                        LEFT JOIN tblproceduremanagment AS t4
                            ON t4.fldDescription = tblorderdetails.fldProcedure4
                        LEFT JOIN tblproceduremanagment AS t5
                            ON t5.fldDescription = tblorderdetails.fldProcedure5
                        LEFT JOIN tblproceduremanagment AS t6
                            ON t6.fldDescription = tblorderdetails.fldProcedure6
                        LEFT JOIN tblproceduremanagment AS t7
                            ON t7.fldDescription = tblorderdetails.fldProcedure7
                        LEFT JOIN tblproceduremanagment AS t8
                            ON t8.fldDescription = tblorderdetails.fldProcedure8
                        LEFT JOIN tblproceduremanagment AS t9
                            ON t9.fldDescription = tblorderdetails.fldProcedure9
                        LEFT JOIN tblproceduremanagment AS t10
                            ON t10.fldDescription = tblorderdetails.fldProcedure10

                    $where
                    ORDER BY $order
                    LIMIT $offset,$limit ";
        //echo factoryResult($query);die;

        $result = mysql_query($query);
        $paging = PagingHelper::getPagingFront($total_page, $current_page);

        if(mysql_num_rows($result) == 0)
        {
            mysql_close();
            $data;

            if($_REQUEST['keywordType'] == 'fldPatientSSN' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&ssn=$ssn'>Add Nursing Home Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&ssn=$ssn'>Add Correctional Facility Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&ssn=$ssn'>Add Home Bound Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&ssn=$ssn'>Add Lab Order for SSN : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldLastName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&lname=$ssn'>Add Nursing Home Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&lname=$ssn'>Add Correctional Facility Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&lname=$ssn'>Add Home Bound Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&lname=$ssn'>Add Lab Order for Last Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFirstName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fname=$ssn'>Add Nursing Home Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fname=$ssn'>Add Correctional Facility Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fname=$ssn'>Add Home Bound Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fname=$ssn'>Add Lab Order for First Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFacilityName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fclty=$ssn'>Add Nursing Home Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fclty=$ssn'>Add Correctional Facility Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fclty=$ssn'>Add Home Bound Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fclty=$ssn'>Add Lab Order for Facility : $ssn</option>";
                $data .= '</select>';
            }
            echo json_encode(array(
                'result'    => true,
                'data'      => 'NO RECORD FOUND '.$data,
                'total'     => '0'
            ));
            die;
        }




    }
    else
    {
        $query = "$selectField
                    FROM tblorderdetails
                        INNER JOIN tblfacility
                                ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
                        LEFT JOIN
                            (SELECT COUNT(1) AS totalNotes, order_id
                            FROM order_notes
                            GROUP BY order_id) AS countNotes
                            ON countNotes.order_id = tblorderdetails.fldID

                        LEFT JOIN tblproceduremanagment AS t1
                            ON t1.fldDescription = tblorderdetails.fldProcedure1
                        LEFT JOIN tblproceduremanagment AS t2
                            ON t2.fldDescription = tblorderdetails.fldProcedure2
                        LEFT JOIN tblproceduremanagment AS t3
                            ON t3.fldDescription = tblorderdetails.fldProcedure3
                        LEFT JOIN tblproceduremanagment AS t4
                            ON t4.fldDescription = tblorderdetails.fldProcedure4
                        LEFT JOIN tblproceduremanagment AS t5
                            ON t5.fldDescription = tblorderdetails.fldProcedure5
                        LEFT JOIN tblproceduremanagment AS t6
                            ON t6.fldDescription = tblorderdetails.fldProcedure6
                        LEFT JOIN tblproceduremanagment AS t7
                            ON t7.fldDescription = tblorderdetails.fldProcedure7
                        LEFT JOIN tblproceduremanagment AS t8
                            ON t8.fldDescription = tblorderdetails.fldProcedure8
                        LEFT JOIN tblproceduremanagment AS t9
                            ON t9.fldDescription = tblorderdetails.fldProcedure9
                        LEFT JOIN tblproceduremanagment AS t10
                            ON t10.fldDescription = tblorderdetails.fldProcedure10
                    $where
                    ORDER BY $order ";
        //echo factoryResult($query);die;

        $result = mysql_query($query);
        $paging = '';
        $total_row = mysql_num_rows($result);

        if($total_row == 0)
        {
            mysql_close();
            $data;

            if($_REQUEST['keywordType'] == 'fldPatientSSN' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&ssn=$ssn'>Add Nursing Home Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&ssn=$ssn'>Add Correctional Facility Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&ssn=$ssn'>Add Home Bound Order for SSN : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&ssn=$ssn'>Add Lab Order for SSN : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldLastName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&lname=$ssn'>Add Nursing Home Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&lname=$ssn'>Add Correctional Facility Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&lname=$ssn'>Add Home Bound Order for Last Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&lname=$ssn'>Add Lab Order for Last Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFirstName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fname=$ssn'>Add Nursing Home Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fname=$ssn'>Add Correctional Facility Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fname=$ssn'>Add Home Bound Order for First Name : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fname=$ssn'>Add Lab Order for First Name : $ssn</option>";
                $data .= '</select>';
            }
            else if($_REQUEST['keywordType'] == 'fldFacilityName' ){
                $ssn = $_REQUEST['keyword'];
                $data = '<select onchange="window.location.href=this.value;">';
                $data .= "<option value=''>< - - SELECT - - ></option>";
                $data .= "<option value='index.php?pg=21&order_type=1&fclty=$ssn'>Add Nursing Home Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=2&fclty=$ssn'>Add Correctional Facility Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=3&fclty=$ssn'>Add Home Bound Order for Facility : $ssn</option>";
                $data .= "<option value='index.php?pg=21&order_type=4&fclty=$ssn'>Add Lab Order for Facility : $ssn</option>";
                $data .= '</select>';
            }

            echo json_encode(array(
                'result'    => true,
                'data'      => 'NO RECORD FOUND '.$data,
                'total'     => '0'
            ));
            die;
        }
    }


$data = array();

$data[] = '
    <table id="orders" aligh="left" cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th width="7%" class="sortable-text"><a href="#" class="sortColumn" rel="1">Order Date</a></th>
        <th width="7%" class="sortable-text"><a href="#" class="sortColumn" rel="2">Exam Date</a></th>
        <th width="6%" class="sortable-text"><a href="#" class="sortColumn" rel="3">Patient ID</a></th>
        <th width="8%" class="sortable-text"><a href="#" class="sortColumn" rel="4">Patient Name</a></th>
        <th width="9%" class="sortable-text"><a href="#" class="sortColumn" rel="5">Procedure</a></th>
        <th width="10%" class="sortable-text"><a href="#" class="sortColumn" rel="6">Modality</a></th>
        <th width="8%" class="sortable-text"><a href="#" class="sortColumn" rel="7">Division</a></th>
        <th width="8%" class="sortable-text"><a href="#" class="sortColumn" rel="8">Facility</a></th>
        <th width="8%" class="sortable-text"><a href="#" class="sortColumn" rel="10">Tech</a></th>
        <th width="10%" class="sortable-text"><a href="#" class="sortColumn" rel="11" >Ordered by</a></th>
		<th width="10%" class="sortable-text"><a href="#" class="sortColumn" rel="12" >Orderedering Physician</a></th>';


    if($role == 'orderingphysician')
    {
        $data[] = '
        <th width="6%" class="sortable-text"><a href="#" class="sortColumn" rel="9">DOB</a></th>
        <th width="6%"><input type="checkbox" id="checkAllCheckbox" name="checkall" onClick="selectAll();"></th>';
    }

    $data[] = "<th colspan='15'></th>";

    $data[] = '</thead><tbody>';


	while($row = mysql_fetch_assoc($result))
	{
		//order status class/color
		//new order
		if($row['fldDispatched'] === '0'):
			$tdclass = 'neworder';
		//dispatched
		elseif($row['fldDispatched'] === '1'):
			$tdclass = 'dispatched';
			//tech completed
			if($row['fldTechComplete'] === '1'):
				$tdclass = 'techcomplete';
				//study completed (report recieved)
				if(!empty($row['fldReportDate']) && $row['fldReportDate'] !== '0000-00-00 00:00:00'):
					$tdclass = 'studycomplete';
				endif;
			endif;
		endif;
		
		//if stat order append css class with stat
		if($row['fldStat'] > 0):
			$tdclass .= 'STAT';
		endif;
		
		//if e-signed add secondary esigned class
		if($row['fldAuthorized'] > 0):
			$tdclass .= ' esigned';
		endif;
		
		/****old code for reference
		
		if($row['fldAuthorized'] == 1 && $row['fldTechComplete'] == 1):
			$tdclass = "esigned";
		elseif($row['fldTechComplete'] == 1):
			$tdclass = "black";
		elseif($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 0):
			$tdclass = "blue";
		elseif($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 1):
			$tdclass = "green";
		elseif($row['fldStat'] == 1 && $row['fldDispatched'] == 0):
			$tdclass = "red";
		elseif($row['fldDispatched'] == 1 && $row['fldStat'] == 1):
			$tdclass = "orange";
		endif;
		*/

        for($i=1;$i<= 10 ;$i++){
            if( $row['fldProcedure'.$i]){
                $sql = "SELECT * FROM tblproceduremanagment WHERE fldDescription='".$row['fldProcedure'.$i]."'";
                $resultChild = mysql_query($sql);
                $dt = mysql_fetch_assoc($resultChild);
                $row['fldCBTCode'.$i] = $dt['fldCBTCode'];
                $dt = '';
            }
        }
        preg_match("/(\d\d\d\d)\-(\d\d)\-(\d\d)/", $row['fldDOB'], $matches);
        $row['fldDOB'] = $matches[2]."-".$matches[3]."-".$matches[1];

//        $modality = array();
//        for($i = 1 ; $i <= 10 ; $i++)
//        {
//            if($row['fldProcedure'.$i] != '' && isset($modalityCached[$row['fldProcedure'.$i]]))
//            {
//                $modality[] = $modalityCached[$row['fldProcedure'.$i]];
//            }
//
//        }
//        $modality = implode('<br/>',$modality);

        $modality = array();
        for($i = 1 ; $i <= 10 ; $i++)
        {
            if($row['modality'.$i] != '')
            {
                $modality[] = $row['modality'.$i];
            }

        }
        $modality = implode('<br/>',$modality);

        $data[] = "
             <tr>
                <td class='$tdclass'>".strftime("%m-%d-%Y %H:%M", strtotime($row['fldDate']))."</td>
                <td class='$tdclass'>".strftime("%m-%d-%Y", strtotime($row['fldSchDate']))."</td>
                <td class='$tdclass'>{$row['fldPatientID']}</td>
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_patient&id={$row['fldID']}'>
                        {$row['fldLastName']}, {$row['fldFirstName']}
                    </a>
                </td>
                <td class='$tdclass'>{$row['fldProcedure1']} , {$row['fldplr1']}".
                ($row['fldProcedure2']!='' ? "<br />{$row['fldProcedure2']} , {$row['fldplr2']}" : '').
                ($row['fldProcedure3']!='' ? "<br />{$row['fldProcedure3']} , {$row['fldplr3']}" : '').
                ($row['fldProcedure4']!='' ? "<br />{$row['fldProcedure4']} , {$row['fldplr4']}" : '').
                ($row['fldProcedure5']!='' ? "<br />{$row['fldProcedure5']} , {$row['fldplr5']}" : '').
                ($row['fldProcedure6']!='' ? "<br />{$row['fldProcedure6']} , {$row['fldplr6']}" : '').
                ($row['fldProcedure7']!='' ? "<br />{$row['fldProcedure7']} , {$row['fldplr7']}" : '').
                ($row['fldProcedure8']!='' ? "<br />{$row['fldProcedure8']} , {$row['fldplr8']}" : '').
                ($row['fldProcedure9']!='' ? "<br />{$row['fldProcedure9']} , {$row['fldplr9']}" : '').
                ($row['fldProcedure10']!='' ? "<br />{$row['fldProcedure10']} , {$row['fldplr10']}" : '').
                "</td>
                <td class='$tdclass'>".$modality."</td>
                <td class='$tdclass'>{$row['fldDivisionName']}</td>
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_fac&id={$row['fldID']}'>
                        {$row['fldFacilityName']}-{$row['fldStation']}
                    </a>
                </td>
                <td class='$tdclass'>{$row['fldTechnologist']}</td>
                <td class='$tdclass'>{$row['fldRequestedBy']}</td>";

        if($role =='orderingphysician')
        {
            $data[] ="
                    <td width='6%' class='$tdclass'>{$row['fldDOB']}</td>
                    <td width='6%' class='$tdclass'><input type='checkbox' name='selected_orders[]' value='{$row['fldID']}' onClick='unselectCheckall();'></td>";
        }

        $data[] = "<td class='$tdclass'>{$row['fldOrderingPhysicians']}</td>";
        $data[] = "<td class='$tdclass'>";

    	if($role == 'admin' || $role =='coder')
        {
        	if($row['fldAuthorized'] == '0')
        	{
        		$data[] = "<a href='index.php?pg=21&id={$row['fldID']}'>Edit</a>
        		<a class='$tdclass' href='index.php?pg=29&id={$row['fldID']}'>Details</a>
        		<a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>";
        	}
        	elseif($row['fldAuthorized'] == '1')
        	{

        		if($role === "admin")
        			$data[] = "<a href='index.php?pg=21&id={$row['fldID']}'>Edit</a><br/>";
        		
        		$data[] = "<nobr><a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_esign_info&id={$row['fldID']}'> E-Signed</a></nobr>
        		<a class='$tdclass' href='index.php?pg=29&id={$row['fldID']}'>Details</a>
        		<a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>";
        	}
        }

        if($role =='dispatcher'|| $role =='technologist' || $role =='facilityuser')
        {
        	if($row['fldAuthorized'] == '0')
        	{
        		$data[] = "<a href='index.php?pg=21&id={$row['fldID']}>Edit</a>
        		<a class='$tdclass' href='index.php?pg=29&id={$row['fldID']}'>Details</a>
        		<a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>";
        	}
        	elseif($row['fldAuthorized'] == '1')
        	{
        		$data[] = "<nobr>E-Signed</nobr>
        		<a class='$tdclass' href='index.php?pg=29&id={$row['fldID']}'>Details</a>
        		<a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>";
        	}
        }

        $data[] = '</td>';

        if($role =='admin' || $role =='dispatcher' || $role =='technologist')
        {
            $data[] = "<td width='6%' class='$tdclass'>";

            if($row['fldVerbal'] == '1')
            {
                $data[] = "Confirm / <a class='$tdclass' href='index.php?pg=31&id={$row['fldID']}'>workflow</a>";
            }
            else if($row['fldVerbal'] == '2')
            {
                $data[] = "Received / <a class='$tdclass' href='index.php?pg=31&id={$row['fldID']}'>workflow</a>";
            }
            else
            {
                $data[] = "<a class='$tdclass' href='index.php?pg=27&id={$row['fldID']}'>workflow</a>";
            }
            $data[] = '</td>';
        }

        if($role =='coder')
        {
            $data[] = "<td width='6%' class='$tdclass'>";
            if($row['fldCoded'] == '1')
                $data[] = "Coded";
            else
                $data[] = "<a class='$tdclass' href='index.php?pg=28&id={$row['fldID']}'>Not Coded</a>";
            $data[] = '</td>';
        }

        if($role =='orderingphysician')
        {
            $data[] = "
                <td width='6%' class='$tdclass'>
                <a class='$tdclass' href='index.php?pg=22&id={$row['fldID']}'>E-Sign</a>
                </td>";
        }


        if($role =='admin' || $role =='dispatcher')
        {
            $data[] = "<td width='6%' class='$tdclass'>";
            if($row['fldDispatched'] == '1')
            {
                $data[] = $row['fldTechnologist']." / <a class='$tdclass' href='index.php?pg=26&id={$row['fldID']}'>Undispatch</a>";
            }
            else
            {
                $data[] = "<a class='$tdclass' href='index.php?pg=25&id={$row['fldID']}'>Dispatch</a>";
            }
            $data[] = '</td>';
        }

        if($role =='admin' || $role =='dispatcher')
        {
            $data[] = "<td width='6%' class='$tdclass'>";
            if($row['fldDispatched'] == '1' && $row['fldTechComplete'] == '1')
            {
                $data[] = "&nbsp;";
            }
            else
            {
                $data[] = "<input type='checkbox' value='{$row['fldID']}' name='selectedOrders[]' />";
            }
            $data[] = '</td>';
        }


        if($role =='facilityuser')
        {
            $data[] = "<td width='6%' class='$tdclass'>";
            if($row['fldDispatched'] == 1)
            {
                $data[] = $row['fldTechnologist'];
            }
            else
            {
                $data[] = "To be Dispatched";
            }
            $data[] = '</td>';
        }
        /*
         if($role =='admin' || $role =='coder'|| $role =='dispatcher')
         {
        $data[] = "<td class='$tdclass'>
        <a class='$tdclass' href='index.php?pg=29&id={$row['fldID']}'>Details</a>
        <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>
        </td>";
        }
        else
        {
        $data[] = "<td class='$tdclass'>
        <a class='$tdclass' href='index.php?pg=22&id={$row['fldID']}'>Details</a>
        <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_history&id={$row['fldID']}' rel='{$row['fldID']}'>History</a>
        </td>";
        }

        if($role =='admin' || $role =='dispatcher' || $role =='technologist' || $role =='facilityuser')
        {
        $exp='';
        if($row['fldException1']!='' && $row['fldException2']=='')
        	$exp='';
        else if($row['fldException1']!='' && $row['fldException2']!='' && $row['fldException3']=='')
        	$exp='';
        else if($row['fldException3']!='')
        	$exp='';

        $data[] = "<td class='$tdclass'>{$exp}</td>";
        }
        */
        if($role =='admin' || $role =='dispatcher')
        {
            if($row['fldTechComplete'] != '1')
            {
                $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass markCompleted' href='#' rel='{$row['fldID']}'>Mark completed</a>
                </td>";/*
                <td class='$tdclass'>
                    <input type='checkbox' value='{$row['fldID']}' name='batchMarkComplete[]' />
                </td>";*/
            }
            else
            {
                $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_completed_info&id={$row['fldID']}' rel='{$row['fldID']}'>Completed</a>
                </td>";
            }
        }

        //check either fldSymtoms or count on order_notes
        if($row['fldSymptoms'] != '' || intval($row['totalNotes']) > 0)
        {
            $totalNotes = ($row['fldSymptoms'] != '' ? intval($row['totalNotes']) + 1 : intval($row['totalNotes'])) ;
                $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_note&id={$row['fldID']}' rel='{$row['fldID']}'><b>Notes($totalNotes)</b></a>
                </td>";
        }
        else
        {
            $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_note&id={$row['fldID']}' rel='{$row['fldID']}'>Notes</a>
                </td>";
        }

//        if($role =='admin' || $role =='dispatcher' || $role =='technologist')
//        {
//            $data[] = "
//            <td class='$tdclass'>
//                <a class='$tdclass' href='index.php?pg=24&id={$row['fldID']}' onclick='return show_confirm()' value='Delete Confirmation'>Delete</a>
//            </td>";
//        }

        if($role =='admin' || $role =='dispatcher')
        {
            if($row['cancelStatus'] == '0')
            {
                $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass showCancel' rel='{$row['fldID']}' href='#' >Cancel</a>
                </td>";
            }
            else
            {
                $data[] = "
                <td class='$tdclass'>
                    <a class='$tdclass showPopup' href='ajax_process_order_record.php?action=show_cancel_info&id={$row['fldID']}' rel='{$row['fldID']}'>Canceled</a>
                </td>";
            }
        }

        $data[] = '</tr>';
    }//while

    if($role =='orderingphysician')
    {
        $data[] = '
        <tr>
            <td colspan="13" align="right"><input type="button" value="Select All" onclick="selectAllButton();"><input type="button" name="action" value="E-Sign All Selected" onClick="eSignAll();"></td>
        <tr>';
    }

    if($role =='admin' || $role == 'dispatcher')
    {
        $data[] = '
        <tr>
            <td colspan="25" align="center">
                <input type="button" value="Check All Non-dispatched" id="selectAllBatchDispatch"/>
        		<input type="button" id="doBatchDispatch" value="Dispatch selected" />
                <input type="button" value="Check All Incompleted" id="selectAllBatchMarkComplete"/>
        		<input type="button" id="doBatchMarkComplete" value="Mark Selected as Complete" />
        		<input type="button" id="selectAll" value="Uncheck All" />
            </td>
        <tr>';
    }


    $data[] = '</tbody></table>';

    //paging
    if($viewBy == 'page')
    {
        $data[] = "<p align='center'>$paging</p>";
        $data[] = "<p align='cente'><a href='#' class='viewAll'>View All</a></p>";
    }
    else
    {
        $data[] = "<p align='center'>$total_row records</p>";
        $data[] = "<p align='center'><a href='#' class='viewPage'>View Page</a></p>";
    }


    mysql_close();
    echo json_encode(array(
            'result'    => true,
            'data'      => implode('', $data),
            'total'     => $total_row
        ));