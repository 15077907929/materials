<?php
/**
 *
 * 封装Cache的操作
 *
 * Use PHP 5.3.0 or newer
 *
 * @package        Library
 * @author        Smart Lee <ismtlee@gmail.com>
 * @copyright    Copyright (c) 2008 - 2012, Joymeng, Inc.
 * @since        Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 *
 * JoyCache
 *
 * 封装Cache的操作
 *
 * @package Library
 * @author Smart Lee <ismtlee@gmail.com>
 * @version $Revision 2.0 2012-11-19 上午9:10:16
 * @see https://github.com/nicolasff/phpredis
 */
class JoyCache
{
    // lifetime definition.
    const FOREVER = 0;
    const DAY = 86400;
    const HALF_DAY = 43200;
    const SHORT = 180;
    const NORMAL = 480;
    const LONG = 600;

    // result code definition.
    const RES_NOTFOUND = 13;
    const RES_SUCCESS = 0;

    private static $instance;
    public $cache;
    public static $result;

    /**
     * @see https://github.com/nicolasff/phpredis
     * @return Redis
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new JoyCache();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->cache = new Redis();
        $config = new Yaf_Config_Ini(CONFIG_INI, 'product');
        self::$result = $this->cache->connect($config->cache->uri, $config->cache->port, $config->cache->timeout);
    }

    /**
     * Set the string value in argument as value of the key.
     * @param string $key
     * @param string $value
     * @param int $lifetime seconds.
     * @return bool: true when success.
     */
    public function set($key, $value, $lifetime = 0)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if ($lifetime == 0) {
            return $this->cache->set($key, $value);
        }
        return $this->cache->setex($key, $lifetime, $value);
    }

    /**
     * Adds a value to the hash stored at key. If this value is already in the hash, FALSE is returned.
     *
     * @param string $key
     * @param string $subKey
     * @param string $value
     * @param int $lifetime
     * @return long 1 if value didn't exist and was added successfully, 0 if the value was already present and was replaced, FALSE if there was an error.
     */
    public function hSet($key, $subKey, $value, $lifetime = 0)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $rs = $this->cache->hSet($key, $subKey, $value);
        $lifetime > 0 && $this->cache->setTimeout($key, $lifetime);
        return $rs;
    }

    /**
     * Gets a value from the hash stored at key. If the hash table doesn't exist, or the key doesn't exist, FALSE is returned.
     * @param string $key
     * @param string $subKey
     * @return string
     */
    public function hGet($key, $subKey)
    {
        $data = $this->cache->hGet($key, $subKey);
        $data_temp = json_decode($data, true);
        if (is_array($data_temp)) {
            $data = $data_temp;
        }
        return $data;
    }

    /**
     * Removes a value from the hash stored at key. If the hash table doesn't exist, or the key doesn't exist, FALSE is returned.
     * @param string $key
     * @param string $subKey
     * @return bool
     */
    public function hDel($key, $subKey)
    {
        return $this->cache->hDel($key, $subKey);
    }

    /**
     * Returns the whole hash, as an array of strings indexed by strings.
     * @param string $key
     * @return array
     */
    public function hGetAll($key)
    {
        return $this->cache->hGetAll($key);
    }

    /**
     * Adds the string value to the head (left) of the list. Creates the list if the key didn't exist. If the key exists and is not a list, FALSE is returned.
     * @param string $key
     * @param string $value
     * @return long The new length of the list in case of success, FALSE in case of Failure.
     */
    public function lPush($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->cache->lPush($key, $value);
    }

    /**
     * Return and remove the first element of the list.
     * @param string $key
     * @return string STRING if command executed successfully BOOL FALSE in case of failure (empty list)
     */
    public function lPop($key)
    {
        return $this->cache->lPop($key);
    }

    /**
     * Adds the string value to the tail (right) of the list. Creates the list if the key didn't exist. If the key exists and is not a list, FALSE is returned.
     * @param string $key
     * @param string $value
     * @return long The new length of the list in case of success, FALSE in case of Failure.
     */
    public function rPush($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->cache->rPush($key, $value);
    }

    /**
     * Returns and removes the last element of the list.
     * @param string $key
     * @return string if command executed successfully BOOL FALSE in case of failure (empty list).
     */
    public function rPop($key)
    {
        return $this->cache->rPop($key);
    }

    /**
     * Returns the specified elements of the list stored at the specified key in the range [start, end]. start and stop are interpretated as indices: 0 the first element, 1 the second ... -1 the last element, -2 the penultimate ...
     * @param string $start
     * @param string $end
     * @return array  containing the values in specified range.
     */
    public function lRange($key, $start, $end)
    {
        // lRange('key', 0, -1) get the all elements.
        return $this->cache->lRange($key, $start, $end);
    }

    /**
     * Get the value related to the specified key.
     * @param string $key
     * @return string|bool: If key didn't exist, FALSE is returned.
     *        Otherwise, the value related to this key is returned.
     */
    public function get($key)
    {
        $data = $this->cache->get($key);
        $data_temp = json_decode($data, true);
        if (is_array($data_temp)) {
            $data = $data_temp;
        }
        if ($data == "[]") {
            return null;
        }
        return $data;
    }

    /**
     * Remove specified key.
     * @param string $key
     * @return int: 1 success.
     */
    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    /**
     *
     * @
     * @
     */
    public function hKeys($key)
    {
        return $this->cache->hKeys($key);
    }

    /**
     * Verify if the specified key exists.
     * @param string $key
     * @return bool: If the key exists, return TRUE, otherwise return FALSE.
     */
    public function exists($key)
    {
        return $this->cache->exists($key);
    }

    /**
     * Increment the number stored at key by one. If the second argument is filled, it will be used as the integer value of the increment.
     * @param string $key
     * @param string $value value that will be added to key, default is one.
     * @return int: The new value.
     */
    public function incr($key, $value = 1)
    {
        return $this->cache->incr($key);
    }

    /**
     * Decrement the number stored at key by one. If the second argument is filled, it will be used as the integer value of the decrement.
     * @param string $key
     * @param string $value value that will be substracted to key, default is one.
     * @return int: The new value.
     */
    public function decr($key, $value = 1)
    {
        return $this->cache->decr($key);
    }

    /**
     * Remove specified keys.
     * @param array $keys
     * @return long: Number of keys deleted.
     */
    public function delMulti(array $keys)
    {
        return $this->cache->delete($keys);
    }

    /**
     * Get the values of all the specified keys. If one or more keys dont exist, the array will contain FALSE at the position of the key.
     * @param array $keys
     * @return array:Array containing the values related to keys in argument.
     */
    public function getMulti(array $keys)
    {
        return $this->cache->mget($keys);
    }

    public function info()
    {
        return $this->cache->info();
    }

    /**
     * Sets an expiration date (a timeout) on an item.
     * @param string $key
     * @param int $expire_time
     * @return bool: TRUE in case of success, FALSE in case of failure.
     */
    public function setExpireTime($key, $expire_time)
    {
        return $this->cache->setTimeout($key, $expire_time);
    }

    public function getLastTime($key)
    {
        return $this->cache->ttl($key);
    }

    //将一个或多个 member 元素及其 score 值加入到有序集 key 当中。
    public function zadd($key, $score, $member)
    {
        return $this->cache->zadd($key, $score, $member);
    }

    //返回有序集 key 中，指定区间内的成员。其中成员的位置按 score 值递增(从小到大)来排序。
    public function zrange($key, $start, $end, $type = "WITHSCORES")
    {
        return $this->cache->zrange($key, $start, $end, $type);
    }

    //返回有序集 key 中成员 member 的排名。其中有序集成员按 score 值递增(从小到大)顺序排列。
    public function zrank($key, $member)
    {
        return $this->cache->zrank($key, $member);
    }

    //移除一个成员
    public function zrem($key, $member)
    {
        return $this->cache->zrem($key, $member);
    }

    //返回有序集 key 中，指定区间内的成员。其中成员的位置按 score 值递增(从大到小)来排序。
    public function zrevrange($key, $start, $end, $type = "WITHSCORES")
    {
        return $this->cache->zrevrange($key, $start, $end, $type);
    }

    //返回有序集 key 中成员 member 的排名。其中有序集成员按 score 值递增(从大到小)顺序排列。
    public function zrevrank($key, $member)
    {
        return $this->cache->zrevrank($key, $member);
    }

    //返回有序集 key 中，成员 member 的 score 值。
    public function zscore($key, $member)
    {
        return $this->cache->zscore($key, $member);
    }

    //返回有序集 key 中，成员 member 的 score 值。
    public function zincrby($key, $increment, $member)
    {
        return $this->cache->zincrby($key, $increment, $member);
    }

    //返回有序集 key 中的成员数。
    public function zcard($key)
    {
        return $this->cache->zcard($key);
    }

    //返回有序集 key 中， score 值在 min 和 max 之间(默认包括 score 值等于 min 或 max )的成员的数量。
    public function zcount($key, $min, $max)
    {
        return $this->cache->zcount($key, $min, $max);
    }


    //返回有序集 key 中，所有 score 值介于 min 和 max 之间(包括等于 min 或 max )的成员。有序集成员按 score 值递增(从小到大)次序排列。
    public function zrangebyscore($key, $min = "-inf", $max = "+inf", $offset = 0, $limit = 20, $type = "WITHSCORES")
    {
        return $this->cache->zrangebyscore($key, $min, $max, $type, "limit $offset $limit");
    }

    //返回有序集 key 中，所有 score 值介于 min 和 max 之间(包括等于 min 或 max )的成员。有序集成员按 score 值递增(从小到大)次序排列。
    public function zrevrangebyscore($key, $max = "+inf", $min = "-inf", $offset = 0, $limit = 20, $type = "WITHSCORES")
    {
        return $this->cache->zrevrangebyscore($key, $max, $min, $type, "limit $offset $limit");
    }


    //时间复杂度中的N表示Sorted-Set中成员的数量，M则表示被删除的成员数量。删除分数在min和max之间的所有成员，即满足表达式min <= score <= max的所有成员。对于min和max参数，可以采用开区间的方式表示，具体规则参照ZCOUNT。 。
    public function zremrangebyscore($key, $min, $max)
    {
        return $this->cache->zremrangebyscore($key, $min, $max);
    }

    //返回集合 key 中的所有成员。不存在的 key 被视为空集合。
    public function smembers($key)
    {
        return $this->cache->smembers($key);
    }

    //判断 member 元素是否集合 key 的成员。
    public function sismember($key, $member)
    {
        return $this->cache->sismember($key, $member);
    }

    //将一个或多个 member 元素加入到集合 key 当中，已经存在于集合的 member 元素将被忽略。
    public function sadd($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->cache->sadd($key, $value);
    }

    //返回集合 key 的基数(集合中元素的数量)。
    public function scard($key)
    {
        return $this->cache->scard($key);
    }

    //移除集合 key 中的一个或多个 member 元素，不存在的 member 元素会被忽略
    public function srem($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->cache->srem($key, $value);
    }

    //移除并返回集合中的一个随机元素。
    public function spop($key)
    {
        $data = $this->cache->sPop($key);
        $data_temp = json_decode($data, true);
        if (is_array($data_temp)) {
            $data = $data_temp;
        }
        return $data;
    }

    /**
     * 返回列表 key 的长度。
     * 如果 key 不存在，则 key 被解释为一个空列表，返回 0 .
     * 如果 key 不是列表类型，返回一个错误。
     */
    public function llen($key)
    {
        return $this->cache->llen($key);
    }


    /**根据参数 count 的值，移除列表中与参数 value 相等的元素。
     * count 的值可以是以下几种：
     * count > 0 : 从表头开始向表尾搜索，移除与 value 相等的元素，数量为 count 。
     * count < 0 : 从表尾开始向表头搜索，移除与 value 相等的元素，数量为 count 的绝对值。
     * count = 0 : 移除表中所有与 value 相等的值。
     */
    public function lrem($key, $value, $count = 0)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->cache->lrem($key, $value, $count);
    }

    //对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
    //举个例子，执行命令 LTRIM list 0 2 ，表示只保留列表 list 的前三个元素，其余元素全部删除。
    public function ltrim($key, $start, $stop)
    {
        return $this->cache->ltrim($key, $start, $stop);
    }


    //如果命令执行时，只提供了 key 参数，那么返回集合中的一个随机元素。
    //如果 count 为正数，且小于集合基数，那么命令返回一个包含 count 个元素的数组，数组中的元素各不相同。如果 count 大于等
    public function srandmember($key)
    {
        $data = $this->cache->srandmember($key);
        $data_temp = json_decode($data, true);
        if (is_array($data_temp)) {
            $data = $data_temp;
        }
        return $data;
    }

    //返回列表 key 中，下标为 index 的元素。
    //下标(index)参数 start 和 stop 都以 0 为底，也就是说，以 0 表示列表的第一个元素，以 1 表示列表的第二个元素，以此类推。
    public function lindex($key, $value)
    {
        $data = $this->cache->lindex($key, $value);
        $data_temp = json_decode($data, true);
        if (is_array($data_temp)) {
            $data = $data_temp;
        }
        return $data;
    }

//	为哈希表 key 中的域 field 的值加上增量 increment 。
    public function hincrBy($key, $value, $count = 1)
    {
        return $this->cache->hincrBy($key, $value, $count);
    }

    //	为哈希表 key 中的域 field 的值加上增量 increment 。
    public function hexists($key, $value)
    {
        return $this->cache->hexists($key, $value);
    }


    //setnx 将 key 的值设为 value ，当且仅当 key 不存在
    public function setnx($key, $value = 1)
    {
        return $this->cache->setnx($key, $value);
    }

}
