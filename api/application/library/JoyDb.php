<?php
class JoyDb {
	private static $conn = null;

	private static function init() {
		$opt = array (PDO::ATTR_PERSISTENT => true);
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		self::$conn = new PDO ($config->database->uri,
			$config->database->username, $config->database->password, $opt);
    }

	/**
	 * @return PDO
	 */
	public static function getInstance($dbName = 'db_qq') {
	if ($dbName == 'db_qq' || !$dbName){
    		self::init();
    	}else{
    		self::getDb($dbName);
    	}
    	return self::$conn;
    }
    public static function getDb($dbName) {
    	$opt = array (PDO::ATTR_PERSISTENT => true);
    	$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		self::$conn = new PDO ($config->database->uri2.$dbName,
			$config->database->username, $config->database->password, $opt);
    }

    static function exception($stmt,$sql=null) {
    	$info_array = $stmt->errorInfo();
//     	throw new Exception("PDO ERROR: " . $info_array[2]);
    	error_log("PDO ERROR: " . json_encode($info_array));
    	error_log("PDO ERROR sql: " . $sql);
    }

	public static function query($sql,$dbName='db_qq') {
		$conn = JoyDb::getInstance($dbName);
		$stmt = $conn->prepare($sql);
		$params = array(1);
		if($stmt->execute($params)) {
			//$result = $stmt->fetch(PDO::FETCH_ASSOC); //fetchOne
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll
			return $result;
		} else {
			JoyDb::exception($stmt,$sql);
		}
        return false;
	}


    //sample,  cannot callerd!

    public static function insert($sql,$params=array(1)) {
    	$conn = JoyDb::getInstance();
    	$stmt = $conn->prepare($sql);
    	if($stmt->execute($params)) {
    		return $conn->lastInsertId();//如果想取自增长id
    	} else {
    		JoyDb::exception($stmt,$sql);
    	}
    	return false;
    }

	function update($sql,$params=array(1)) {
		$conn = JoyDb::getInstance();
		$stmt = $conn->prepare($sql);
		if($stmt->execute($params)) {
			return true;
		} else {
			JoyDb::exception($stmt,$sql);
		}
		return false;
	}

	function queryNew($sql,$dbName='db_qq'){
		$conn = JoyDb::getInstance($dbName);
		$stmt = $conn->query($sql);
		return $stmt->rowCount();
	}

	public function delete($sql,$params=array(1)) {
		$conn = JoyDb::getInstance();
		$stmt = $conn->prepare($sql);
		if($stmt->execute($params)) {
			return true;
		} else {
			JoyDb::exception($stmt,$sql);
		}
	}
}
