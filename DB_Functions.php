<?php

include "Db_conn.php";

error_reporting(E_ALL);

ini_set("display_errors", 1);


class DB_Functions extends Db_conn {

	public $db_conn;
	
	
	function __construct(){
		$this->db_conn = new Db_conn;
	
	}
	
	
	function exec_qry($qry){
		
		syslog(LOG_INFO, "Call In exec_qry");  //"Call In exec_qry </p>";
		syslog(LOG_INFO, $qry);

		$connect = $this->db_conn->getConnection();

		return mysqli_query($connect,$qry);
	}
	
	
	function num_rows($rlt){
		return @mysql_num_rows($rlt);
	}
	function fetch_array($rlt){
		return @mysql_fetch_array($rlt);
	}
	
	function qry_fetch($qry){
		$rlt=exec_qry($qry);
		return fetch_array($rlt);
	}
	
	function db_insert(&$kv,$table){
		for(reset($kv);$key=key($kv);next($kv)){
			$val=$kv[$key];
			add_null($val);
			$keys.=$key.",";
			$vals.=$val.",";
		}
		$keys=substr($keys,0,strlen($keys)-1);
		$vals=substr($vals,0,strlen($vals)-1);
		$query="insert into $table ($keys) values ($vals)";
		exec_qry($query);
	
		return mysql_insert_id();
	}
	
	function db_replace(&$kv,$table,$updatewhere,$increcolname){
		$row=qry_fetch("select $increcolname from $table $updatewhere",0,0);
		$updated=$row[$increcolname];
	
		if(!$updated){	//기존 값이 없으므로 인서트해야함
			return db_insert($kv,$table);
		}else{
			for(reset($kv);$key=key($kv);next($kv)){
				$val=$kv[$key];
				add_null($val);
				$str.="$key=$val,";
			}
			$str=substr($str,0,strlen($str)-1);
			$query="update $table set $str $updatewhere";
			$result=exec_qry($query);
			if($updated) return $updated;
		}
	}
	
	function qry_result($qry){
		$rlt=exec_qry($qry);
		return @mysql_result($rlt,0);
	}
	
	function add_null(&$text){
		$text=str_replace("'"," ",$text);
		//$text=htmlspecialchars($text);
		$text=($text=='')?'NULL':"'$text'";
	}
	
	function get_result_for_page($table,$fields="*",$where,$orderby,$num_per_page,$pre_link,&$page,
								&$totalnum,&$pageselector,&$result,&$total_page_num,
								&$prevpage,&$nextpage,&$vnum) {
		$result=exec_qry("select $fields from $table $where $orderby");
		$totalnum=num_rows($result);
		//echo "select $fields from $table $where $orderby <br> $totalnum";
	}
	
	function db_fetch_array($qhandle,$errdie=0,$errprint=0) {
		if (db_numrows($qhandle))	return @mysql_fetch_array($qhandle);
		else {
			if ($errprint) 
				echo "<br><font color=red style='font-size:12'>에러가 발생했습니다.<br>에러: DB결과가 없는 상황에서 fetch_array를 시도했습니다.</font><br><br>";
			if ($errdie) exit;
			return array();
		}
	}
	
	function db_numrows($qhandle) {
		// return only if qhandle exists, otherwise 0
		if ($qhandle) {
			return @mysql_numrows($qhandle);
		} else {
			return 0;
		}
	}
	
	
	function db_close($db){
		@mysql_free_result($db);
		@mysql_close($db);
	}
	
/*
	if(!$conn){
		$conn=@mysql_connect("velixerphptest.cafe24.com","velixerphptest","pancoat!@") or die("Database Connection Error");
		@mysql_select_db("valixerphptest",$conn) or die("Database Select Error");
	}
	mysql_query("SET CHARACTER SET 'UTF-8'");//클라이언트에서 한글깨짐 방지를 위한 쿼리
*/
}
?>