<?//navigation bar?>
<script>
	var el = document.getElementsByTagName("body")[0];
	el.className = "";
</script>
<noscript>  
<!--[if IE]>  
	<link rel="stylesheet" href="css/ie.css">  
<![endif]-->  
</noscript> 
<link rel="stylesheet" href="nav/css/nav.css">
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<nav id="topNav" class="no-js">
	<nobr>
		<ul>
			<li><a href="index.php" title="Home">Home</a></li>
			<li><a href="#" title="Manage Users">Manage Users</a>
				<ul>
					<li><a href="index.php?pg=1" title="Add User">Add User</a></li>
					<li class="last"><a href="index.php?pg=2" title="Edit User">Manage Users</a></li>
				</ul>
			</li>
			<li><a href="" title="Settings">Settings</a>
				<ul>
					<li><a href="index.php?pg=75" title="Map">Map Settings</a></li>
					<li><a href="index.php?pg=5" title="Email">Email</a></li>
					<li><a href="index.php?pg=6" title="PDF">PDF</a></li>
					<li class="last"><a href="index.php?pg=7" title="MWL">Dicom MWL</a></li>
				</ul>
			</li>
			<li><a href="#" title="Procedure Management">Procedure Management</a>
				<ul>
					<li><a href="index.php?pg=8" title="Add Procedure">Add Procedure</a></li>
					<li class="last"><a href="index.php?pg=9" title="Manage Procedures">Manage Procedures</a></li>
				</ul>
			</li>
			<li><a href="#" title="Facility Management">Facility Management</a>
				<ul>
					<li><a href="index.php?pg=12" title="Add Facility">Add Facility</a></li>
					<li class="last"><a href="index.php?pg=13" title="Manage Facilities">Manage Facilities</a></li>
				</ul>
			</li>
			<li><a href="#" title="List Management">List Management</a>
				<ul>
					<li><a href="index.php?pg=16" title="Add List/Item">Add List/Item</a></li>
					<li class="last"><a href="index.php?pg=17" title="Manage Lists">Manage Lists</a></li>
				</ul>
			</li>
		</ul>
		</nobr>
	</nav>
	<!-- <script src="nav/js/jquery-1.8.1.js"></script> -->
	<script src="nav/js/modernizr.custom.69568.js"></script>
	<script>  
		(function($){
			          
			//cache nav  
			var nav = $("#topNav");  
			          
			//add indicators and hovers to submenu parents  
			nav.find("li").each(function() {  
				if ($(this).find("ul").length > 0) {
					
					$("<span>").text("").appendTo($(this).children(":first"));  
					
					//show subnav on hover  
					$(this).mouseenter(function() {  
					    $(this).find("ul").stop(true, true).slideDown();  
					});  
					          
					//hide submenus on exit  
					$(this).mouseleave(function() {  
					    $(this).find("ul").stop(true, true).slideUp();  
					});  
				}  
			});  
		})(jQuery);  
	</script>
