<?php session_start(); 
//docHead
#require Login
if(!isset($_SESSION['username'])){
	header('Location:index.php');	
}
require_once 'ajax/runQuery.php';
require_once 'inc/docHead.php';
?>

<body>
<div class="bkgrd"></div>
<div class='page'>
<div class="gridContainer clearfix" >


<?php require_once 'inc/header.php'; 

require_once 'inc/mainMenu.php';

require_once 'tables/flexTotals.php';
require_once 'tables/flexRegister.php';

?>

	<div id="CollapsiblePanel1" class="CollapsiblePanel">
		<div class="CollapsiblePanelTab" tabindex="0">Response:</div>
		<div class="CollapsiblePanelContent">Response:</div>
	</div>
	
</div>
</div>

<script type="text/javascript">
	var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
	var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
</script>

<script type="application/javascript" src="js/enderFinance.js"></script>
</div>

</body>
</html>
