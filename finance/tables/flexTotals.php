<div id="LayoutDiv4">

<?php 
$header = array();
$account = array();

#Connect to the Database
$c = new sqlConnect();

#Get account names
$result = $c->runSQL('SELECT account 
							 FROM from_account AS acc
							 ORDER BY fromId');

#Begin Totals table								
print '<table class="flexme"><thead><tr>';

#insert row names into flexigrid table header
while($row = $result->fetch_assoc()){
		print '<th width="80">'.$row['account'].'</th>';
				
		array_push($header,$row['account']);
}
$result->free();

#End table header
print '</tr></thead><tr>';

#Get account values		
$result = $c->runSQL('SELECT * FROM totals AS ttl ORDER BY fromId');
		
while($row = $result->fetch_assoc()){
		print '<td id="Acc'.$row['fromId'].'">$'.$row['grand_total'].'</td>';
		$_SESSION['from'.$row['fromId']]=$row['grand_total'];
		array_push($account,$row['grand_total']);
}
$result->free();
		
print '</tr></table>';
		
$c->closeSQL();
?>

</div>