<?php

include 'config.php';

$query	= "SELECT DATE_FORMAT(date_created,'%m-%d-%Y %H:%i') AS dateCreated,
			content
			FROM announcement
			ORDER BY date_created DESC";
$result	= mysql_query($query);

$announcementContent = '';
if(mysql_num_rows($result))
{
	$temp = array();
	$i = 1;
	while($row = mysql_fetch_assoc($result))
	{
		$temp[] = '<span class="announcement anc'.$i.'">'.$row['dateCreated']
				.'</span>'.htmlspecialchars($row['content'], ENT_QUOTES, 'ISO-8859-1');
		$i++;
		if($i == 4) $i = 1;
	}

	$announcementContent = implode('', $temp);
}

mysql_close();
?>
<style>
	.announcement {
		color: #FFFFFF;
		font-weight: bold;
		margin: 0 0.3em 0 1.2em;
		padding: 0 0.5em;
	}
	.anc1 {
		background-color: #7FB51A;
	}
	.anc2 {
		background-color: #FFAA00;
	}
	.anc3 {
		background-color: #0088FF;
	}
	#TICKER {
		background-color: #FFFFFF;
/*		border-bottom: 1px solid #CCCCCC;
		border-top: 1px solid #CCCCCC;*/
/*		color: #444444;*/
		display: block;
		font-family: Arial;
		font-size: 11px;
		overflow: hidden;
		width: 100%;
	}
</style>
<div id="TICKER" class="myAlert"><?php echo $announcementContent; ?></div>
<div style="width:100%;height: 10px;">&nbsp;</div>
<script type="text/javascript">
	if($('#TICKER').html() != '')
	{
		$('div.myAlert').marquee('pointer').mouseover(function () {
		  $(this).trigger('stop');
		}).mouseout(function () {
		  $(this).trigger('start');
		}).mousemove(function (event) {
		  if ($(this).data('drag') == true) {
			this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
		  }
		}).mousedown(function (event) {
		  $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
		}).mouseup(function () {
		  $(this).data('drag', false);
		});
	}
</script>