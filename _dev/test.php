<?php session_start();
include "config.php";
?>
<?
$sql_del="DELETE FROM fldproc where 1";
$result_del = mysql_query($sql_del);

  $sql="select * from tblorderdetails where 1";
  $result = mysql_query($sql);
  while($row = mysql_fetch_array($result))
  {
	$fac=$row['fldFacilityName'];
    $examdate=$row['fldSchDate'];
    $sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldFacilityName='$fac'"));
	$rate=$sql_fac['fldRate'];
	$rvalue=$sql_fac['fldRateValue'];
	$zone=$sql_fac['fldZone'];
	$rcode=$sql_fac['fldRcode'];
    $con=$sql_fac['fldContract'];
    $id=$row['fldID'];

	if($row['fldProcedure1']!='')
	{
        $proc=$row['fldProcedure1'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");
	}
	if($row['fldProcedure2']!='')
	{
		$proc=$row['fldProcedure2'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");
	}
	if($row['fldProcedure3']!='')
	{
		$proc=$row['fldProcedure3'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");

	}
	if($row['fldProcedure4']!='')
	{
		$proc=$row['fldProcedure4'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");
	}
	if($row['fldProcedure5']!='')
	{
		$proc=$row['fldProcedure5'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");
	}
	if($row['fldProcedure6']!='')
	{
		$proc=$row['fldProcedure6'];
		if($rate=='Flat')
		{
		$famount=$rvalue;
		}
		else
		{
        	$sql_proc=mysql_fetch_array(mysql_query("SELECT * FROM tblproceduremanagment where fldDescription ='$proc'"));
		if($zone==1)
                $amount=$sql_proc['fldz1amount'];
		if($zone==2)
                $amount=$sql_proc['fldz2amount'];
		if($zone==3)
                $amount=$sql_proc['fldz3amount'];
		if($zone==4)
                $amount=$sql_proc['fldz4amount'];
		if($zone==5)
                $amount=$sql_proc['fldz5amount'];
		if($zone==6)
                $amount=$sql_proc['fldz6amount'];
		if($zone==7)
                $amount=$sql_proc['fldz7amount'];
		if($zone==8)
                $amount=$sql_proc['fldz8amount'];
		if($zone==9)
                $amount=$sql_proc['fldz9amount'];
		if($zone==10)
                $amount=$sql_proc['fldz10amount'];
                $famount=$amount * $rvalue;
		}
		echo 'TEST' . $sql_proc['fldCategory'] . '<br/>';
		$sql_insert = mysql_query("insert into fldproc set
		facility='".strip_tags(addslashes($con))."',
		examdate='".strip_tags(addslashes($examdate))."',
		proc='".strip_tags(addslashes($proc))."',
		rate='".strip_tags(addslashes($rate))."',
		amount='".strip_tags(addslashes($famount))."',
		facname='".strip_tags(addslashes($fac))."',
		category='".strip_tags(addslashes($sql_proc['fldCategory']))."',
		cpt='".strip_tags(addslashes($sql_proc['fldCBTCode']))."',
		id='".strip_tags(addslashes($id))."'
		");
	}
  }
?>