<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);
//$connect=mysqli_connect("velixerphptest.cafe24.com","velixerphptest","pancoat!@") or die("DB 연결에 실패했습니다.");
//$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

class Db_conn {
	
	protected $connect;
	
	function __construct(){
	
		$this->setConnection();
	}
	
	function getConnection (){
		syslog(LOG_INFO, "Call getConnection" );
		return $this->connect;
	}
	
	function setConnection(){
		syslog(LOG_INFO, "Call setConnection");
		
		$this->connect=mysqli_connect("velixerphptest.cafe24.com","velixerphptest","pancoat!@","velixerphptest");
		mysqli_query($this->connect,"SET CHARACTER SET 'UTF-8'");//클라이언트에서 한글깨짐 방지를 위한 쿼리
	
		syslog(LOG_INFO, "DB_Connection");
	}
	
	
	//$connect=mysql_connect("velixerphptest.cafe24.com","velixerphptest","pancoat!@") or die("DB 연결에 실패했습니다.");
	//mysql_select_db("velixerphptest",$connect);
	//mysqli_query($connect,"SET CHARACTER SET 'UTF-8'");//클라이언트에서 한글깨짐 방지를 위한 쿼리
}
/*
$connect=mysqli_connect("velixerphptest.cafe24.com","velixerphptest","pancoat!@","velixerphptest");
mysqli_query($connect,"SET CHARACTER SET 'UTF-8'");//클라이언트에서 한글깨짐 방지를 위한 쿼리
*/
?>
