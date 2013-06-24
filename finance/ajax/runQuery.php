<?php 

class sqlConnect{
	private $db = array();
	private $active_group;
	private $con;
	
public function __construct() {

	$this->set_db('test');

	$base_url = "http://".$_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	$this->con = new MySQLi(
			$this->db[$this->active_group]['hostname'],
			$this->db[$this->active_group]['username'],
			$this->db[$this->active_group]['password'],
			$this->db[$this->active_group]['database']
	);
	
	if($this->con->connect_error){
		print 'Error connecting to database';
	}

}

public function set_db($active){
		$this->db['test']['hostname'] = "localhost";
		$this->db['test']['username'] = 'ender';
		$this->db['test']['password'] = "8U8TE9PJeCQcT6SF";
		$this->db['test']['database'] = "finance";

		$this->db['live']['hostname'] = 'localhost';
		$this->db['live']['username'] = 'enders_finance';
		$this->db['live']['password'] = 'b58mP3ytjnRHS2My';
		$this->db['live']['database'] = 'finance';
	
		$this->active_group = $active;
}

public function runSQL($rsql) {
	//print $rsql;
	$result = $this->con->query($rsql) or die ('query failed');
	return $result;
}

public function runMultiSQL($rsql) {
	$result = $this->con->msqli_multi_query($rsql) or die ('multiquery failed');
	return $result;
}

public function closeSQL(){
	$this->con->close();
}

public function countRec($fname,$tname) {
	$sql = "SELECT count($fname) FROM $tname ";
	$result = $this->runSQL($sql);
	while ($row = $result->fetch_array(MYSQLI_NUM)) {
		return $row[0];
	}
}

public function sanitize($string){
	return $this->con->real_escape_string($string);
}

}
?>