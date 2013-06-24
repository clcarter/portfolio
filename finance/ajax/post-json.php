<?php

session_start();
require_once 'runQuery.php';
$first_iteration = empty($_SESSION['category']) ? true : false;
$c = new sqlConnect();

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'item_id';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
$addRow = isset($_POST['add']) ? true: false;

$usingSQL = true;

$cat_join = "JOIN category AS cat ON bal.catId = cat.catId ";
$acc_join = "JOIN from_account AS acc ON bal.fromId = acc.fromId";
$ttl_join = "JOIN totals AS ttl ON ttl.fromId = acc.fromId";

$sort = "ORDER BY $sortname $sortorder";
$start = (($page-1) * $rp);
$table = 'balance_sheet AS bal';
$limit = "LIMIT $start, $rp";

$where = "";
if ($query) $where = " WHERE $qtype LIKE '%".$c->sanitize($query)."%' ";

$sql = "SELECT * FROM $table $cat_join $acc_join $ttl_join $where $sort $limit";
//$tq = "SELECT * FROM totals
		//JOIN from_account AS acc ON totals.fromId = acc.fromId ORDER BY ttlId";
		
$result = $c->runSQL($sql);
$num_rows = $c->countRec("item_id","$table $where");

function select($selected, $col, $col_id, $table, $n){
	global $first_iteration, $c;
	$html = "<select id=".$col."_select_".$n." disabled class='a $col' name='".$col_id."_$n' onchange='javascript:edit_form(\"#".$col."_select_".$n."\");'>
		<option value='' selected>-------------</option>";
	
	if($first_iteration){
		$sql = "SELECT $col, $col_id FROM $table ORDER BY $col_id";
		$result = $c->runSQL($sql);
		$i = 0;
		while($row = $result->fetch_assoc()){
			if($row[$col_id] != 6 && $row[$col_id] != 7){
				$html .= $row[$col] == $selected 
						? "<option value='".$row[$col_id]."' selected>".$row[$col]."</option>" 
						: "<option value='".$row[$col_id]."'>".$row[$col]."</option>";
				$_SESSION[$col][$i] = $row[$col];
				$_SESSION[$col_id][$i] = $row[$col_id];
				++$i;
			}
		}
	}
	else{
		foreach($_SESSION[$col] as $key => $val){
			$adjust = $key+1;
			$html .= $val == $selected 
					? "<option value='".$adjust ."' selected>".$val."</option>" 
					: "<option value='".$adjust ."'>".$val."</option>";
		}
	}
	return $html."</select>";
}

header("Content-type: application/json");
$jsonData = array('page'=>$page,'total'=>$num_rows,'rows'=>array());

while($row = $result->fetch_assoc()){
	$n = $row['item_id'];
	$entry_live = array('id'=>'_'.$row['item_id'],
		'cell'=>array(
			'row_id'=>$row['item_id'],
			'date'=>'<input disabled class="a ignore date" id="date_'.$n.'" onchange="javascript:edit_form(\'#date_'.$n.'\');" name="date_'.$n.'" type="date" value="'.$row['date'].'" />',
			'purchase'=>"<input disabled class='a required purchase' id='trans_$n' onchange='javascript:edit_form(\"#trans_$n\");' name='purchase_$n' type='text' value='".$row['purchase']."' />",
			'entity'=>"<input disabled class='a required entity' id='entity_".$n."' onchange='javascript:edit_form(\"#entity_".$n."\");' name='entity_$n' type='text' value='".$row['entity']."' />",
			'category'=>select($row['category'],'category', 'catId','category',$n),
			'account'=>select($row['account'],'account','fromId','from_account',$n),
			'amount'=>"\$<input disabled class='a required amount' id='amount_".$n."' onchange='javascript:edit_form(\"#amount_".$n."\");' name='amount_$n' type='text' value='".$row['amount']."' />",
		),
	);

	$jsonData['rows'][] = $entry_live;
}
$c->closeSQL();


echo json_encode($jsonData);