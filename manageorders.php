<?php
#MDI Demo
//ini_set('display_errors', 1);

if(!isset($_SESSION))
	session_start();

require_once 'config.php';

//check user logged
if(!isset($_SESSION['user']) || $_SESSION['user'] === '')
{
	header("Location:index.php");
	die;
}

//fix code for menu
if(isset($_GET['pg']))
{
	header("Location: index.php?pg=".$_GET['pg']);
	die;
}

//var_dump($_SESSION);

//get info
$role		= $_SESSION['role'];
$userState	= (isset($_SESSION['userState'])?$_SESSION['userState']:'');
$userName	= $_SESSION['user'];
$userId		= (isset($_SESSION['userID'])?$_SESSION['userID']:'');
$facility	= $_SESSION['facility'];
$action		= (isset($_REQUEST['action'])?$_REQUEST['action']:'');

if(empty($role))//if role not set in session var get role via db
{
	$getUserSql = "select * from tbluser where fldUserName = $userName";
	
	$userResult = mysql_query($getUserSql);
	
	if($userResult)
	{
		while($userInfo = mysql_fetch_assoc($userResult))
		{
			$role = $userInfo['fldRole'];
		}
	}
	else 
	{
		header("Location:index.php");
		die;
	}
}

if($role === 'biller')
{
	header("Location: index.php?pg=55");
	die;
}


//do process EsignAll, recode with optimized, just use a query
if($action === "ESignAllSelected")
{
	$selected_orders = $_REQUEST['selected_orders'];
	if(!empty($selected_orders))
	{
		$selected_orders = implode(', ', $selected_orders);
		$query = "UPDATE tblorderdetails
		SET fldAuthorized='1', fldAuthDate=now()
		WHERE fldID IN ($selected_orders)";
		mysql_query($query);
	}
}

//for divisions
require_once 'division_config.php';

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
			ORDER BY fldRealName";
}

$techCombo = array('<select id="tech" name="tech">');
$techCombo[] = '<option value="">Select</option>';

if($result = mysql_query($query))
{
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
}

$techCombo[] = '</select>';
$techCombo  = implode('', $techCombo);

//repair modality
$query = "SELECT DISTINCT(fldModality) AS name FROM tblproceduremanagment";
$modalityCombo = array('<select id="modality" name="modality">');
$modalityCombo[] = '<option value="">All</option>';
$result = mysql_query($query);
if(mysql_num_rows($result) > 0)
{
	while($row = mysql_fetch_assoc($result))
	{
		$modalityCombo[] = "<option value='{$row['name']}'>{$row['name']}</option>";
	}
}
$modalityCombo[] = '</select>';
$modalityCombo  = implode('', $modalityCombo);


?>
<!DOCTYPE html PUBLIC "-//W3C//Dth XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/Dth/xhtml1-strict.dth">
<html>
<head>
<title><?=PAGE_TITLE?></title>
<link href="menu/menu_style.css" rel="stylesheet" type="text/css" />
<link href='style.css' rel="stylesheet" type="text/css" />
<link href='tablesort_new.css' rel="stylesheet" type="text/css" />
<link href="paginate.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css"
	href="map_images/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link href="redmond/jquery-ui-1.8.6.custom.css" rel="stylesheet"
	type="text/css" />

<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"
	type="text/javascript"></script>
<script type="text/javascript" src="map_images/jquery.blockUI.js"></script>
<script type="text/javascript"
	src="map_images/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="map_images/jquery.marquee.js"></script>
<script type="text/javascript" src="common.js"></script>

<style>
body {
	font-size: 12px;
	font-family: sans-serif;
}

.fdtablePaginatorWrapTop {
	display: none;
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

#frmSearch {
	width: 100%;
}

#content {
	height: auto;
}
</style>
</head>
<body>
	<div id="top">
		<a href="index.php?pg=20" class="top1"><img src="images/home.png"/></a>
		<?php include 'top_nav.php';?>
		<a href="logout.php" class="top3"><img src="images/logout.png"/></a>
	</div>
	<div id="header">
		<img src="images/logo.png"/>
	</div>
<?if( $_SESSION['role'] == 'admin' ):
	include_once 'nav/nav.php';
endif;?>
	<div style="float: left; width: 100%">
		<form id="frmSearch">
			<table style="width: 100%;">
				<thead>
					<tr>
					<?if($role === 'admin' || $role === 'dispatcher'):
						echo '<th>
								<table>
									<tr>
										<td class="searchlabel">Select division</td>
									</tr>
									<tr>
										<td style="background: #CAE8EA;">
											<select'; divisionList('5');
						echo 				'</select>
										</td>
									</tr>
								</table
							</th>';
					endif;

					echo '
						<th>
							<table>
								<tr>
									<td class="searchlabel">Keyword 1</td>
								</tr>
								<tr>
									<td style="background: #CAE8EA;">
										<input id="keyword" name="keyword" />
										<select id="keywordType" name="keywordType">
											<option value="fldLastName">Last Name</option>
											<option value="fldPatientSSN">Patient SSN</option>
											<option value="fldFirstName">First Name</option>
											<option value="fldDate">Order Date</option>
											<option value="fldSchDate">Exam Date</option>
											<option value="fldFacilityName">Facility</option>
										</select>
										<br/>
									</td>
								</tr>
								<tr>
									<td class="searchlabel">Keyword 2<br/></td>
								</tr>
								<tr>
									<td style="background: #CAE8EA;">
										<input id="keyword2" name="keyword2" />
										<select id="keywordType2" name="keywordType2">
											<option value="fldLastName">Last Name</option>
											<option value="fldPatientSSN" selected="selected">Patient SSN</option>
											<option value="fldFirstName">First Name</option>
											<option value="fldDate">Order Date</option>
											<option value="fldSchDate">Exam Date</option>
											<option value="fldFacilityName">Facility</option>
										</select>
									</td>
								</tr>
							</table>
						</th>
						<th>
							<table>
								<tr>
									<td class="searchlabel" style="background: #CAE8EA;">
										<input type="checkbox" value="1" name="lab1" id="lab1" />NH<br/>
										<input type="checkbox" value="2" name="lab2" id="lab2" />CF<br/>
										<input type="checkbox" value="3" name="lab3" id="lab3" />HB<br/>
										<input type="checkbox" value="4" name="lab4" id="lab4" />Lab
									</td>
								</tr>
							</table>
						</th>';?>
						
						<th>
							<table>
								<tr>
					<?if($role === 'admin'):?>
									<td class="searchlabel">State</td>
									<td style="background: #CAE8EA;">
										<select id="state" name="state"><?
						
										$sql="SELECT DISTINCT fldAddressState FROM tblfacility"/* TODO where statement can be edited to narrow results later WHERE fldListName='division' "*/;
	
										$result = mysql_query($sql);
	
										//print_r(mysql_fetch_array($result));
	
										while($row = mysql_fetch_array($result))://print_r($row);?>
											<option value='<?=$row['fldAddressState']?>'>
												<?=strtoupper($row['fldAddressState'])?>
											</option>
										<?endwhile;?>
										</select>
									</td>
								</tr>
						<?else:
							//if not admin, just use fixed hidden state,
							echo '<input type="hidden" value="'.$userState.'" name="state" />';
						endif;?>
								<tr>
									<td class="searchlabel">Modality</td>
									<td style="background: #CAE8EA;"><?=$modalityCombo?></td>
								</tr>
								<tr>
									<td class="searchlabel">Order Status</td>
									<td style="background: #CAE8EA;">
										<select id="status" name="status">
											<option value="default">Default</option>
											<option value="all">All</option>
											<option value="nondist">Pending</option>
											<option value="dist_notcomplete">Dispatched</option>
											<option value="completed">Completed</option>
											<option value="canceled">Canceled</option>
										</select>
									</td>
								</tr>
							</table>
						</th>
						<th>
							<table cellspacing="0" cellpadding="0">
								<tr>
									<th>Time</th>
									<th>
										<select id="time" name="time">
											<option value="">Date Range</option>
											<option selected="selected" value="today">Today</option>
											<option value="yesterday">Yesterday</option>
											<option value="tomorrow">Tomorrow</option>
											<option value="week">This Week</option>
											<option value="month">This Month</option>
											<option value="all">Show All</option>
										</select>
									</th>
								</tr>
								<tr id="timeSelect" style="display: none">
									<th>From Date:</th>
									<th><input name="fromDate" id="fromDate" value="<?=date('m/d/Y')?>" /></th>
								</tr>
								<tr id="timeSelect1" style="display: none">
									<th>To Date:</th>
									<th><input name="toDate" id="toDate" value="<?=date('m/d/Y')?>" /></th>
								</tr>
							</table>
						</th>
						<th>
							<table>
								<tr>
									<td style="background: #CAE8EA;"><input type="button" id="doSearch" value="LOAD" /></td>
								</tr>
								<tr>
									<td style="background: #CAE8EA;"><input type="button" id="doReset" value="RESET" /></td>
								</tr>
								<tr>
									<td class="searchlabel"><span id="resultCount"></span></td>
								</tr>
							</table>
						</th>
						<th>
							<table>
								<tr>
									<td style="background: #CAE8EA;"><a href=<?=($role !== "facilityuser" || $role !== "orderingphysician")?"index.php?pg=21":"index.php?pg=77"?>><img src="images/neworderbtn.png"></a></td>
								</tr>
							</table>
						</th>
					</tr>
				</thead>
			</table>
		</form>
		<div id="mainAlert" style="width: 100%"></div>
		<div id="mainList" style="width: 100%"></div>
	</div>
	<div style="display: none;">
		<img src="map_images/ajax_loader.gif" /> <img
			src="map_images/fancybox/fancybox.png" />
	</div>

	<div style="display: none;">
		<div id="popupTech" style="width: 300px; height: 100px;">
			<p>
				Select Technologist
				<?php echo $techCombo; ?>
			</p>
			<p>
				<input type="button" value="Dispatch" id="doDispatch" />
				<input type="button" value="Close" class="closePopup" />
			</p>
		</div>
	</div>

	<div style="display: none;">
		<div id="popupCancel" style="width: 400px; height: 200px;">
			<p>Cancel order - Notes</p>
			<p>
				<textarea style="width: 80%; height: 80%" name="cancelNotes"
					id="cancelNotes"></textarea>
			</p>
			<p>
				<input type="button" value="Do Cancel" id="doCancel" /> <input
					type="button" value="Close" class="closePopup" />
			</p>
		</div>
	</div>

</body>

<script type="text/javascript">

    /*----------- Old functions -------------------*/
    function show_confirm()
    {
        return confirm("Are you sure you want  to delete this Order");
    }

    function unselectCheckall()
    {
        document.getElementById("checkAllCheckbox").checked = false;
    }

    function selectAll()
    {
        var x =document.getElementsByName('selected_orders[]');
        var status = document.getElementById("checkAllCheckbox").checked;
        for(i=0;i<x.length;i++)
        {
            x[i].checked = status;
        }
    }

    function selectAllButton()
    {
        document.getElementById("checkAllCheckbox").checked = true;
        selectAll();
    }

    function eSignAll()
    {
        if(confirm("Are you sure you want to E-Sign all selected orders?"))
        {
            var args;
            var x=document.getElementsByName('selected_orders[]');
            for(i=0;i<x.length;i++)
            {
                if(x[i].checked == true )
                {
                    args +="&selected_orders[]="+x[i].value;
                }
            }
            window.location.href="manageorders.php?action=ESignAllSelected&"+args;
        }
    }

    /*----------- End old functions -------------------*/
    var timeOutValue = 600000;
    var ajaxObject = null;

    var currentPage = 1;

    <?php
        if(isset($_SESSION['formCached']))
        {
            echo "var formCached = JSON.parse('{$_SESSION['formCached']}')";
        }
        else
        {
            echo "var formCached = null";
        }
    ?>


    var viewBy = 'page';
    var backupRecordPerPage = <?php echo FRONT_END_ROW_PER_PAGE; ?>;
    var clock = null;

    //init sort is : undispatch, dispatched incompleted, dispatched completed
    var sortField   = 'tblorderdetails.fldDispatched, tblorderdetails.fldExamDate, tblorderdetails.fldStatus, tblorderdetails.fldSchDate';
    var sortBy      = 'ASC';
    var initView    = 1;

    var batchDispatch = new Array;
    var batchMarkComplete = new Array;

    var recordIdCancel = null;

    var formOriginBackup = null;

    $(document).ready(function(){

            //reload for 5 min
            //clock = setInterval("list()", 300000);

            //reload for 5 min
            clockAlert = setInterval("loadAlert()", 300000);

            loadAlert();

            //backup form, used for reload
            formOriginBackup = exportForm('frmSearch');

            //init is today
            $('#time').val('today');
            checkTime();

            list();

            $('#doSearch').click(function(){
                formCached = exportForm('frmSearch');
                //click to search, override init view rule
                //sortField = 2; //Exam Date
                //initView = 0;
                list();
            });

            $('#doReset').click(function(){
                importForm('frmSearch', formOriginBackup);
                formCached = formOriginBackup;
                list();
            });

            //do dispatch button of dispatch popup window
            $('#doDispatch').click(function(){
                if(batchDispatch.length == 0)
                {
                    alert('No order# selected');
                    return false;
                }
                if($('#tech').val() == '')
                {
                    alert('Please select Technologist');
                    return false;
                }

                doBatchDispatch();
                batchDispatch = new Array;

                $.fancybox.close();

                return false;
            });

            //do cancel button of cancel popup window
            $('#doCancel').click(function(){
                if(recordIdCancel == null)
                {
                    alert('No order# selected');
                    return false;
                }
                if($('#cancelNotes').val() == '')
                {
                    alert('Please enter notes');
                    return false;
                }

                doBatchCancel(recordIdCancel);
                recordIdCancel = null;

                $.fancybox.close();

                return false;
            });

            //cancel button of dispatch popup window
            $('input.closePopup').click(function(){
                $.fancybox.close();
                //clock = setInterval("list()", 120000);
            })

            $('#time').change(function(){
                checkTime();
            })

            $('#fromDate').datepicker({autoSize: true,
                            changeMonth: true,
                            changeYear: true,
                            closeText: 'Close',
                            currentText: 'Now',
                            dateFormat: 'mm/dd/yy',
                            gotoCurrent: true,
                            showButtonPanel: true,
                            showWeek: true,
                            weekHeader: 'Week'
            });

            $('#toDate').datepicker({autoSize: true,
                                    changeMonth: true,
                                    changeYear: true,
                                    closeText: 'Close',
                                    currentText: 'Now',
                                    dateFormat: 'mm/dd/yy',
                                    gotoCurrent: true,
                                    showButtonPanel: true,
                                    showWeek: true,
                                    weekHeader: 'Week'
            });

            $('a.showPopup').fancybox();
    });

    function checkTime()
    {
        if($('#time').val() == '')
        {
            $('#timeSelect').show();
            $('#timeSelect1').show();
        }
        else
        {
            $('#timeSelect').hide();
            $('#timeSelect1').hide();
        }
    }

    function loadAlert()
    {
        //load alert
        $('#mainAlert').load('announcement.php');
    }

    function list()
    {
        if(ajaxObject != null)
        {
            ajaxObject.abort();
        }

        //for long load, should clear interval
        //clearInterval(clock);

        $('#resultCount').html('');

        if(formCached != null)
        {
            importForm('frmSearch', formCached);
            checkTime();
        }
        else
        {
            formCached = exportForm('frmSearch');
        }


        //assign current vars form search
        var form = $('#frmSearch').serializeArray();
        form[form.length] = {name : 'page' , value : currentPage};
        form[form.length] = {name : 'sortField' , value : sortField};
        form[form.length] = {name : 'sortBy' , value : sortBy};
        form[form.length] = {name : 'initView' , value : initView};
        form[form.length] = {name : 'viewBy' , value : viewBy};

        form[form.length] = {name : 'formCached' , value : JSON.stringify(formCached)};

        var lab = new Array;
        var i = 1;
        for(i = 1 ; i <= 4 ; i++)
        {
            if($('#lab' + i).is(':checked'))
            {
                form[form.length] = {name : 'lab[]' , value : $('#lab' + i).val()};
            }
        }

        ajaxObject = $.ajax({
                        url: 'get_order_list.php',
                        type: 'POST',
                        data: form,
                        dataType: 'json',
                        timeout: timeOutValue,
                        beforeSend: function(){
                                $('#mainList').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(request, status, error) {
                           if(request.statusText == 'abort' || request.statusText == 'Unknown') return;

                           if(error.name == 'NS_ERROR_NOT_AVAILABLE' || request.readyState==0){
                               alert('Request is interrupted unexpectedly');
                           }else if(error.search('TIME_OUT')>=0){
                                alert('TimeOut');
                                window.location = 'login.php';
                           }else{
                               //alert(request.responseText);
                           }
                        },
                        success: function(returnData) {

                            if(returnData.data == null || returnData == null)
                            {
                                $('#mainList').html('Data return is null');
                                return;
                            }

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            $('#mainList').html(returnData.data);

                            $('#resultCount').html(returnData.total + ' orders');

                            $('a.sortColumn').click(function(){
                                sortField = $(this).attr('rel');
                                //if sort colum, we override init view order rule
                                initView = 0;
                                if(sortBy == 'ASC') sortBy = 'DESC';
                                else sortBy = 'ASC';

                                list();
                            })

                            $('a.paging').click(function(){
                                //click paging to view next page, so should keep the order
                                currentPage = $(this).attr('rel');
                                list();
                            })

                            $('a.markCompleted').click(function(){
                                doMarkComplete($(this).attr('rel'));
                                return false;
                            })

                            $('a.showPopup').fancybox({
                                'showNavArrows' : false,
                                'onComplete' : function(){
                                    $('#doAddOrderNotes').click(function(){
                                        if($('#orderNotes').val() == '')
                                        {
                                            alert('Please enter Notes');
                                            $('#orderNotes').focus();
                                            return false;
                                        }

                                        doAddOrderNotes($('#orderRecordId').val(),$('#orderNotes').val());
                                        return false;
                                    })
                                }
                            });

                            $('#selectAllBatchDispatch').click(function(){
                                if($(this).val() == 'Check All Non-dispatched')
                                {
                                    $('input[name="selectedOrders[]"]').each(function()
                                    {
                                        if($(this).parent().hasClass("blue") || $(this).parent().hasClass("red"))
                                        {
                                        	$(this).attr('checked',true);
                                        }
                                    });
                                    $(this).val('Uncheck All Non-dispatched');
                                }
                                else
                                {
	                                $('input[name="selectedOrders[]"]').each(function()
	                                {
	                                    if($(this).parent().hasClass("blue") || $(this).parent().hasClass("red"))
	                                    {
	                                    	$(this).attr('checked',false);
	                                    }
                                    });
                                    $(this).val('Check All Non-dispatched');
                                }
                            });

                            $('#doBatchDispatch').click(function(){
                                $('input[name="selectedOrders[]"]:checked').each(function(){
                                  batchDispatch.push($(this).val());
                                });

                                if(batchDispatch.length == 0)
                                {
                                    alert('No record selected');
                                    return;
                                }

                                //popup
                                $.fancybox({
                                    'titlePosition'     : 'inside',
                                    'transitionIn'      : 'none',
                                    'transitionOut'     : 'none',
                                    'href'              : '#popupTech',
                                    'modal'             : true,
                                    'showCloseButton'   : false
                                });

                                //should clear interval
                                //clearInterval(clock);
                            });

                            $('#selectAllBatchMarkComplete').click(function(){
                                if($(this).val() == 'Check All Incompleted')
                                {
                                    $('input[name="selectedOrders[]"]').each(function(){
                                    	if($(this).parent().not(".black") && $(this).parent().not(".esigned"))
	                                    {
	                                    	$(this).attr('checked',true);
	                                    }
                                    });
                                    $(this).val('Uncheck All Incompleted');
                                }
                                else
                                {
                                    $('input[name="selectedOrders[]"]').each(function(){
                                    	if($(this).parent().not(".black") && $(this).parent().not(".esigned"))
	                                    {
	                                    	$(this).attr('checked',false);
	                                    }
                                    });
                                    $(this).val('Check All Incompleted');
                                }
                            });

                            $('#doBatchMarkComplete').click(function(){
                                $('input[name="selectedOrders[]"]:checked').each(function(){
                                  batchMarkComplete.push($(this).val());
                                });

                                if(batchMarkComplete.length == 0)
                                {
                                    alert('No record selected');
                                    return;
                                }

                                doMarkComplete(batchMarkComplete.join(','));
                                batchMarkComplete = new Array;

                            });

                            $('#selectAll').click(function(){
	                                $('input[name="selectedOrders[]"]').each(function(){
	                                    $(this).attr("checked", false);
	                                });
	                                $("#selectAllBatchMarkComplete").val("Check All Incompleted");
	                                $("#selectAllBatchDispatch").val("Check All Incompleted");
                            });

                            $('a.viewPage').click(function(){
                                viewBy      = 'page';
                                currentPage = 1;
                                list();
                            });

                            $('a.viewAll').click(function(){
                                viewBy      = 'all';
                                currentPage = 1;
                                list();
                            });

                            //reset interval
                            //clock = setInterval("list()", 120000);

                            $('a.showCancel').click(function(){

                                recordIdCancel = $(this).attr('rel');

                                //popup
                                $.fancybox({
                                    'titlePosition'     : 'inside',
                                    'transitionIn'      : 'none',
                                    'transitionOut'     : 'none',
                                    'href'              : '#popupCancel',
                                    'modal'             : true,
                                    'showCloseButton'   : false
                                });

                                //should clear interval
                                clearInterval(clock);
                            });
                        }
        });

        return false;
    }

    // can be single string, or concat id with , : 1,2,3 or 1
    function doMarkComplete(id)
    {
        //should clear interval
        //clearInterval(clock);

        if(!confirm('Are you sure?'))
        {
            //clock = setInterval("list()", 120000);
            return;
        }

        if(ajaxObject != null)
        {
            ajaxObject.abort();
        }

        ajaxObject = $.ajax({
                        url: 'ajax_process_order_record.php',
                        type: 'POST',
                        data: 'id=' + id + '&action=mark_completed',
                        dataType: 'json',
                        timeout: timeOutValue,
                        beforeSend: function(){
                                $('#mainList').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(request, status, error) {
                           if(request.statusText == 'abort' || request.statusText == 'Unknown') return;

                           if(error.name == 'NS_ERROR_NOT_AVAILABLE' || request.readyState==0){
                               alert('Request is interrupted unexpectedly');
                           }else if(error.search('TIME_OUT')>=0){
                                alert('TimeOut');
                                window.location = 'login.php';
                           }else{
                               //alert(request.responseText);
                           }
                        },
                        success: function(returnData) {
                            if(returnData.data == null || returnData == null)
                            {
                                $('#mainList').html('Data return is null');
                                return;
                            }

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            alert(returnData.data);

                            list();

                        }
        });
    }

    function doBatchDispatch()
    {
        if(ajaxObject != null)
        {
            ajaxObject.abort();
        }

        var stringIds = batchDispatch.join(',');

        ajaxObject = $.ajax({
                        url: 'ajax_process_order_record.php',
                        type: 'POST',
                        data: 'id=' + stringIds + '&tech=' + $('#tech').val() + '&action=batch_dispatch',
                        dataType: 'json',
                        timeout: timeOutValue,
                        beforeSend: function(){
                                $('#mainList').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(request, status, error) {
                           if(request.statusText == 'abort' || request.statusText == 'Unknown') return;

                           if(error.name == 'NS_ERROR_NOT_AVAILABLE' || request.readyState==0){
                               alert('Request is interrupted unexpectedly');
                           }else if(error.search('TIME_OUT')>=0){
                                alert('TimeOut');
                                window.location = 'login.php';
                           }else{
                               //alert(request.responseText);
                           }
                        },
                        success: function(returnData) {
                            if(returnData.data == null || returnData == null)
                            {
                                $('#mainList').html('Data return is null');
                                return;
                            }

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            alert(returnData.data);

                            list();

                        }
        });

        return false;
    }

    function doBatchCancel(id)
    {
        if(ajaxObject != null)
        {
            ajaxObject.abort();
        }

        ajaxObject = $.ajax({
                        url: 'ajax_process_order_record.php',
                        type: 'POST',
                        data: 'id=' + id + '&notes=' + $('#cancelNotes').val() + '&action=do_cancel',
                        dataType: 'json',
                        timeout: timeOutValue,
                        beforeSend: function(){
                                $('#mainList').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(request, status, error) {
                           if(request.statusText == 'abort' || request.statusText == 'Unknown') return;

                           if(error.name == 'NS_ERROR_NOT_AVAILABLE' || request.readyState==0){
                               alert('Request is interrupted unexpectedly');
                           }else if(error.search('TIME_OUT')>=0){
                                alert('TimeOut');
                                window.location = 'login.php';
                           }else{
                               //alert(request.responseText);
                           }
                        },
                        success: function(returnData) {
                            if(returnData.data == null || returnData == null)
                            {
                                $('#mainList').html('Data return is null');
                                return;
                            }

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            alert(returnData.data);

                            list();

                        }
        });

        return false;
    }


    function doAddOrderNotes(id, notes)
    {
        if(ajaxObject != null)
        {
            ajaxObject.abort();
        }

        //close fancybox
        $.fancybox.close();

        var sTag = '<font color="#FF0000" size="16">Please wait...</font>';

        $.blockUI({
            overlayCSS: {backgroundColor: ''},
            css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
            },
            message: '<img src="map_images/ajax_loader.gif" /><br>' + sTag
        });

        ajaxObject = $.ajax({
                        url: 'ajax_process_order_record.php',
                        type: 'POST',
                        data: 'id=' + id + '&notes=' + notes + '&action=do_add_notes',
                        dataType: 'json',
                        timeout: timeOutValue,
                        beforeSend: function(){
                                $('#mainList').html('<img src="map_images/ajax_loader.gif" />');
                        },
                        error: function(request, status, error) {
                           if(request.statusText == 'abort' || request.statusText == 'Unknown') return;

                           if(error.name == 'NS_ERROR_NOT_AVAILABLE' || request.readyState==0){
                               alert('Request is interrupted unexpectedly');
                           }else if(error.search('TIME_OUT')>=0){
                                alert('TimeOut');
                                window.location = 'login.php';
                           }else{
                               //alert(request.responseText);
                           }
                        },
                        success: function(returnData) {
                            if(returnData.data == null || returnData == null)
                            {
                                $('#mainList').html('Data return is null');
                                return;
                            }

                            if(returnData.data == 'TIME_OUT')
                            {
                                alert('TIME OUT. Please relogin');
                                window.location = 'logout.php';
                                return;
                            }

                            $.unblockUI();

                            alert(returnData.data);

                            list();

                        }
        });

        return false;
    }


</script>
</html>
<?php
mysql_close();
?>