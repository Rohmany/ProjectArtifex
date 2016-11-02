<?php
/*
 * Developed by Spera Automation Systems
 * https://Spera.Systems
 * Under GPL
 */
class Artifex {
    private $prvt_DBHOST;
    private $prvt_DBNAME;
    private $prvt_DBUSER;
    private $prvt_DBPASS;
    private $CONNECTION_SUCCESS;
    private $CONNECTION_STRING;
    public function __construct() {
        $this->prvt_DBHOST = ""; // database host name/ip
        $this->prvt_DBNAME = ""; // database name
        $this->prvt_DBUSER = ""; // database username
        $this->prvt_DBPASS = ""; // database password
        $this->CONNECTION_SUCCESS = FALSE;
    }
    public function connect() {
        $connection = mysqli_connect($this->prvt_DBHOST, $this->prvt_DBUSER, $this->prvt_DBPASS, $this->prvt_DBNAME);
        if(!mysqli_connect_errno()) {
            $this->CONNECTION_SUCCESS = TRUE;
            $this->CONNECTION_STRING = $connection;
            return $connection;
        }else {
            return FALSE;
        }
    }
    public function execute($SQL_STATEMENT) {
        if($this->CONNECTION_SUCCESS == TRUE) {
            $value = $this->CONNECTION_STRING->query($SQL_STATEMENT);
            return $value;
        }else {
            return FALSE;
        }
    }
    public function insert($table_name, $assoc_array) { // function to insert in database
	$sql_q = "INSERT INTO ".$table_name." ("; // sql query begins (string processing)
	foreach($assoc_array as $key => $value) { // loop over keys and insert them into query string
            $sql_q .= "".$key."" . " ,";
	}
	$sql_q = rtrim($sql_q, ","); // remove last ',' from the string
	$sql_q .=" ) VALUES ( "; // end keys placement
	foreach($assoc_array as $key => $value) { // loop over values and insert them into query string
            $sql_q .= "'".$value."'" . " ,";
	}
	$sql_q = rtrim($sql_q, ","); // remove last ',' from the string
        $sql_q .= ")"; // finalize query string
	return $this->execute($sql_q); // call executer
    }
    public function edit($table_name, $skey_name, $skey_value, $assoc_array) { // update function
	$sql_q = "UPDATE ".$table_name." SET "; // begin query
	foreach($assoc_array as $key => $value) { // loop over values and set them into the query string
            $sql_q .= $key . " = " . "'". $value . "',";
	}
	$sql_q = rtrim($sql_q, ","); // remove the last ','
	$sql_q .= " WHERE ".$skey_name." = '".$skey_value."'"; // add where condition based on key & value parameters
        echo $sql_q;
        return $this->execute($sql_q); // call executer
        
    }
    public function fetch_all($table_name) {
        $sql_q = "SELECT * FROM ".$table_name;
        $list = $this->execute($sql_q);
        return $list;
    }
    public function find_one($table_name, $key, $value) {
        $sql_q = "SELECT * FROM ".$table_name." WHERE ".$key." = '".$value."'";
        $reply = $this->execute($sql_q);
        $replyable = $reply->fetch_assoc();
        return $replyable;
    }
    public function Delete($table_name, $key, $value) {
        $sql_q = "DELETE FROM ".$table_name." WHERE ".$key." = ".$value;
        return $this->execute($sql_q);
    }
    public function find($table_name, $key, $value) {
        $sql_q = "SELECT * FROM ".$table_name." WHERE ".$key." = '".$value."'";
        $reply = $this->execute($sql_q);
        return $reply;
    }
}
