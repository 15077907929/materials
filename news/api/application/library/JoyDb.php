<?php
class JoyDb {

	private static $conn = null;

    /**
     * 初始化PDO连接
     */
	private static function init() {
	    if (is_null(self::$conn)){
            $opt = array (PDO::ATTR_PERSISTENT => true);
            $config = new Yaf_Config_Ini(CONFIG_INI, 'product');
            self::$conn = new PDO ($config->database->uri,
                $config->database->username, $config->database->password, $opt);
        }
    }

    /**
     * 得到PDO实例
     * 默认数据库
     * @param string $dbName
     * @return PDO
     */
	public static function getInstance($dbName = 'h5api') {
	if ($dbName == 'h5api' || !$dbName){
    		self::init();
    	}else{
    		self::getDb($dbName);
    	}
    	return self::$conn;
    }

    /**
     * 获得一个数据库连接
     * 数据库名称
     * @param $dbName
     */
    public static function getDb($dbName) {
    	$opt = array (PDO::ATTR_PERSISTENT => true);
    	$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		self::$conn = new PDO ($config->database->uribase.$dbName,
			$config->database->username, $config->database->password, $opt);
    }

    /**
     * 数据库异常
     * @param $stmt
     * @param null $sql
     */
    public static function exception($stmt,$sql=null) {
    	$info_array = $stmt->errorInfo();
    	error_log("PDO ERROR: " . json_encode($info_array));
    	error_log("PDO ERROR sql: " . $sql);
    }

    /**
     * 查询数据库
     * @param $sql
     * @param array $params
     * @return array|bool
     */
	public static function query($sql,$params=array(1)) {
		$conn = JoyDb::getInstance();
		$stmt = $conn->prepare($sql);
		if($stmt->execute($params)) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll
			return $result;
		} else {
			JoyDb::exception($stmt,$sql);
		}
        return false;
	}

    /**
     * 插入数据库
     * @param $sql
     * @param array $params
     * @return bool|string
     */
    public static function insert($sql,$params=array(1)) {
    	$conn = JoyDb::getInstance();
    	$stmt = $conn->prepare($sql);
    	if($stmt->execute($params)) {
            //如果想取自增长id
    		return $conn->lastInsertId();
    	} else {
    		JoyDb::exception($stmt,$sql);
    	}
    	return false;
    }

    /**
     * 更新数据库
     * @param $sql
     * @param array $params
     * @return bool
     */
	public function update($sql,$params=array(1)) {
		$conn = JoyDb::getInstance();
		$stmt = $conn->prepare($sql);
		if($stmt->execute($params)) {
			return true;
		} else {
			JoyDb::exception($stmt,$sql);
		}
		return false;
	}

    /**
     * 影响的行数
     * @param $sql
     * @return int
     */
	public function queryNew($sql){
		$conn = JoyDb::getInstance();
		$stmt = $conn->query($sql);
		return $stmt->rowCount();
	}

    /**
     * 删除数据
     * @param $sql
     * @param array $params
     * @return bool
     */
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
