<?php 

session_start();
require_once 'runQuery.php';
$c = new sqlConnect();
$j_form = isset($_POST['j_form']) ? $_POST['j_form'] : false;
$delrow = isset($_POST['delrow']) ? $c->sanitize($_POST['delrow']) : false;
$updateAmt = !empty($_POST['updateAmt']) ? $_POST['updateAmt'] : false;
$updateAcc = !empty($_POST['updateAcc']) ? $_POST['updateAcc'] : false;
$json_response = array();


$table = 'balance_sheet';

$joins = array(
					"JOIN from_account AS acc ON ".$table.".fromId = acc.fromId",
					"JOIN totals AS ttl ON acc.fromId = ttl.fromId"
					);
					 
$limit = " LIMIT 1";
$value = ' VALUES(';
$insert = $value;
$sql = '';
$item_id = false;
$new_key;

if(!empty($delrow)){
	$sql = "DELETE FROM $table WHERE item_id = $delrow $limit";
	$result = $c->runSQL($sql);
	$json_response['delrow'] = "$result Row DELETED";	
}

if(!empty($j_form)){

	foreach($j_form as $key => $val){
		$j_form = $j_form[$key];
	}
	
	foreach($j_form as $key => $val){
		$item_id = explode('_',$key);
		
		if($item_id[0] == end($item_id)){
			$item_id = false;
		}
		else{	
			$new_key = $item_id[0];
		//	print $new_key.' , ';
		//	print $val;
			$j_form[$new_key] = $c->sanitize($val);
			$item_id = end($item_id);
			unset($j_form[$key]);
		}
	}
		
	if(!empty($updateAmt)){
		updateTotal($item_id, '', $j_form[$new_key], $table, $joins);
	}
	elseif(!empty($updateAcc)){
		//$json_response['j_form_data'] = $j_form['fromId'];
		updateTotal($item_id, $j_form[$new_key], '', $table, $joins);
	}
	
	//$updateAcc = false;
	//$updateAmt = false;

	$sql = $item_id !='new' ? "UPDATE $table SET " : "INSERT INTO $table(";

	if($item_id != 'new'){
		$where = " WHERE item_id = ". $item_id;

		foreach($j_form as $key => $val){
			$sql .= "$key = '$val', ";
			$json_response['cell'] = "CELL ($key) value changed to '$val' <br />";
		}

		$sql = substr($sql,0,-2);
		$sql .= $where.$limit;
	}
	else{
		foreach($j_form as $key => $val){
			$sql .= "$key, " ;
			$insert .= "CURDATE(), ";
			$json_response['cell'] = "Row ADDED";
		}
		
		$sql = substr($sql,0,-2);
		$insert = substr($insert,0,-2);
		$sql .= ") ".$insert. ") ";
	}
	
	$result = $c->runSQL($sql);
	

	//print_r($sql);
	$json_response['change'] = "$result Row Changed in the Database";
	$c->closeSQL();
}


/*** Update Totals ***/
function updateTotal($item_id, $acc, $amt, $table, $joins){
	global $c, $json_response;
	
	$sql = "SELECT * FROM $table ";
	foreach($joins as $join){
		$sql.= $join.' ';
}
	
	$sql.= "WHERE item_id = $item_id LIMIT 1";
	
	$result = $c->runSQL($sql);

	while($row = $result->fetch_assoc()){

		if(!empty($acc)){
		//	print $row['grand_total'].' , '.$row['amount'].' , '.$row['fromId'];
			$prevAccTtl = $row['grand_total'] - $row['amount'];
			
			$_SESSION['from'.$row['fromId']] = $prevAccTtl;
			$_SESSION['from'.$acc] += $row['amount'];
			
			$msql = "UPDATE totals SET grand_total = ".$prevAccTtl." WHERE fromId = ".$row['fromId']." LIMIT 1";
			$response = $c->runSQL($msql);
			$json_response['prev_Acc'.$row['fromId']] = $prevAccTtl;
			$msql = "UPDATE totals SET grand_total = ".$_SESSION['from'.$acc]." WHERE fromId = ".$acc." LIMIT 1"; 

			$json_response['new_Acc'.$acc] = $_SESSION['from'.$acc];
		}
		else{
			$_SESSION['from'.$row['fromId']] += $amt - $row['amount'];
			$msql = "UPDATE totals SET grand_total = ".$_SESSION['from'.$row['fromId']]." WHERE fromId = ".$row['fromId']." LIMIT 1";
			$json_response['new_Acc'.$row['fromId']] = $_SESSION['from'.$row['fromId']];	
		}
		$response = $c->runSQL($msql);
		
		
	}
	$result->free();
}

print json_encode($json_response);

?>
