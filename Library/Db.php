<?php
/**
 * 数据库操作类
 *
 * Created    : 2014-10-24
 * Modified   : 2014-10-31
 * @link      : http://www.binchi.net/
 * @copyright : © 2014 BINCHI.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <me@binchi.net>
 */
class Db
{
    /**
     * 是否生产环境
     * @var boolean
     */
    public static $isProduction = true;
    
    /**
     * 默认连接
     * @var string
     */
    const DEFAULT_CONNECTION = 'default';
    
    /**
     * 默认配置
     * @var array
     */
    protected static $defaultConfig = [
        'connection_string' => 'mysql:host=localhost;dbname=',
        'pk_column' => 'id',
        'error_mode' => PDO::ERRMODE_EXCEPTION,
        'username' => null,
        'password' => null,
        'charset' => 'utf8',
        'driver_options' => null,
        'return_result_sets' => false,
    ];
    
    /**
     * 所有链接的配置项
     * @staticvar array
     */
    protected static $config = [];
    
    /**
     * 
     * @staticvar array
     */
    protected static $instances = [];
    
    /**
     * 当前实例使用的连接名
     * @var string
     */
    protected $connectionName = 'default';
    
    /**
     * PDO实例
     * @var PDO
     */
    protected $pdo = null;
    
    /**
     * PDOStatement 对象实例
     * @var PDOStatement
     */
    protected $lastStatement = null;
    
    /**
     * 当前操作对象关联的主表
     * @var string
     */
    protected $tableName = '';
    
    /**
     * 当前操作对象关联表的别名
     * @var string
     */
    protected $tableAlias = '';
    
    /**
     * 设置主键字段名
     * @var string
     */
    protected $pkColumn = 'id';
    
    /**
     * 对象记录是否新记录
     * @var boolean
     */
    protected $isNew = true;
    
    /**
     * 是否原生SQL语句(当前要查询的SQL查询语句)
     * @var boolean
     */
    protected $isRawQuery = false;
    
    /**
     * SQL查询语句
     * @var string
     */
    protected $rawQuery = '';
    
    /**
     * 原生SQL查询语句绑定的参数
     * @var array
     */
    protected $rawParams = [];
    
    /**
     * SQL查询语句绑定的参数
     * @var array
     */
    protected $queryParams = [];
    
    /**
     * 上次执行的SQL语句
     * @var string
     */
    protected $lastQuery = '';
    
    /**
     * SELECT查询的字段列表
     * @var array
     */
    protected $selectColumns = '*';
    
    /**
     * 设置JOIN
     * @var array
     */
    protected $join = [];
    
    /**
     * 设置where查询条件
     * @var array
     */
    protected $where = [];
    
    /**
     * order by 
     * @var array
     */
    protected $orderBy = [];
    
    /**
     * offset
     * @var int
     */
    protected $offset = null;
    
    /**
     * limit
     * @var int
     */
    protected $limit = null;
    
    /**
     * 获取行的结果方式,默认关联数组
     * @var int
     */
    protected $fetchStyle = PDO::FETCH_ASSOC;
    
    /**
     * 是否抛出错误
     * @var boolean
     */
    protected static $throwError = false;
    
    /**
     * 错误信息
     * @var array
     */
    public $errorInfo = [];
    
    /**
     * 记录对应的数据
     * @var array
     */
    protected $metaData = [];
    
    /**
     * 修改过的字段数据
     * @var array
     */
    protected $dirtyData = [];
    
    /**
     * 设置链接的属性项
     * @param string|array $key
     * @param string|null $val
     * @param string $connectionName
     */
    public static function configure($key, $val=null, $connectionName=self::DEFAULT_CONNECTION) 
    {
        self::setDbConfig($connectionName);
        if (is_array($key)) {
        	foreach ($key as $k => $v) {
        		self::configure($k, $v, $connectionName);
        	}
        } else {
        	if (is_null($val)) {
        		$val = $key;
        		$key = 'connection_string';
        	}
        	self::$config[$connectionName][$key] = $val;
        }
    }
    
    /**
     * 设置数据连接配置
     * @param unknown $connectionName
     */
    public static function setDbConfig($connectionName)
    {
        if (!isset(self::$config[$connectionName])) {
            self::$config[$connectionName] = self::$defaultConfig;
        }
    }
    
    /**
     * 是否抛出错误
     * @param boolean $isThrow
     */
    public static function isThrowError($isThrow=null)
    {
        if (!is_null($isThrow)) {
            self::$throwError = $isThrow;
        }
        return self::$throwError;
    }
    
    /**
     * 构造函数
     * @param array|null $params
     * @param string $connectionName
     */
    public function __construct($config=null, $connectionName=self::DEFAULT_CONNECTION)
    {
        if (is_array($config) && $config) {
            self::$config[$connectionName] = $config;
        } else if (isset(self::$config[$connectionName])) {
            $config = self::$config[$connectionName];
        } else {
            $cfg = Yaf_Registry::get('config');
            $dbCfg = $cfg->database->$connectionName;
            self::setDbConfig($connectionName);
            $dsn = 'mysql:host='.$dbCfg->host.';dbname='.$dbCfg->dbname.';charset='.$dbCfg->charset;
            self::$config[$connectionName]['connection_string'] = $dsn;
            self::$config[$connectionName]['username'] = $dbCfg->username;
            self::$config[$connectionName]['password'] = $dbCfg->password;
            $config = self::$config[$connectionName];
        }
        $dsn = $config['connection_string'];
        $options = [
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
        ];
        if (false === strpos($dsn, 'charset') && $config['charset']) {
            $dsn .= ';charset='.$config['charset'];
        }
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
            $this->connectionName = $connectionName;
            $this->setPkColumn($config['pk_column']);
        } catch (PDOException $e) {
            if (!self::$isProduction) {
                header('content-type:text/plain;charset=utf-8;');
                echo $e->getMessage();
                echo "\n";
                var_dump($dsn);
                echo "\n";
                debug_print_backtrace();
                exit;
            }
            echo 'Connect to mysql server error!';
            exit;
        }
    }
    
    /**
     * 指定查询的表名
     * @param strintableName
     * @param string $tableAlias
     * @return Db
     */
    public static function table($tableName, $tableAlias='', $connectionName=self::DEFAULT_CONNECTION)
    {
        $db = new self(null, $connectionName);
        $db->tableName = $tableName;
        if ($tableAlias) {
            $db->tableAlias = $tableAlias;
        }
        
        return $db;
    }
    
    /**
     * 执行SQL查询
     * @param string $query
     * @param array $params
     * @param string $connectionName
     */
    public function execute($query, $params=[], $connectionName=self::DEFAULT_CONNECTION)
    {
        $this->lastQuery = $query;
        $statement = $this->pdo->prepare($query);
        $result = $statement->execute($params);
        if (!$result && self::$throwError) {
            $info = $statement->errorInfo();
            $errorMsg = join('#*#', $statement->errorInfo());
            throw new PDOException($info[2], $info[1]);
        }
        $this->lastStatement = $statement;
        return $result;
    }
    
    /**
     * 重置对象属性为初始化属性
     */
    protected function resetProperties()
    {
        $this->isRawQuery = false;
        $this->rawQuery = '';
        $this->rawParams = [];
        $this->queryParams = [];
        $this->selectColumns = '*';
        $this->join = [];
        $this->where = [];
        $this->orderBy = [];
        $this->offset = 0;
        $this->limit = 10;
        $this->fetchStyle = PDO::FETCH_ASSOC;
    }
    
    /**
     * 执行SQL查询,并返回结果集
     * @return multitype:mixed
     */
    protected function run()
    {
        $query = $this->buildSelect();
        
        $result = self::execute($query, $this->queryParams, $this->connectionName);
        if (!$result)
        {
            return false;
        }
        $statement = $this->lastStatement;
        
        $rows = [];
        $rows = ($this->limit==1)
                    ? $statement->fetch($this->fetchStyle) 
                    : $statement->fetchAll($this->fetchStyle);
        
        
        $this->resetProperties();
        
        // 取完数据要关闭游标,避免表被锁定
        $statement->closeCursor();
        
        return $rows;
    }
    
    /**
     * 创建inser语句
     */
    protected function buildInsert()
    {
        $query = [];
        $query[] = 'insert into';
        $query[] = $this->tableName;
        $fieldList = array_keys($this->dirtyData);
        $query[] = '('.join(', ', $fieldList).')';
        $query[] = 'values';
        $placeholders = [];
        foreach ($this->dirtyData as $k => $v) {
            $placeholders[] = ':'.$k;
        }
        $query[] = '('.join(', ', $placeholders).')';

        return join(' ', $query);
    }
    
    /**
     * 创建update语句
     */
    protected function buildUpdate()
    {
        $query = [];
        $query[] = 'update '.$this->tableName.' set';
        $fieldList = [];
        foreach ($this->dirtyData as $k => $v) {
            $fieldList[] = $k.'=:'.$k;
        }
        $query[] = join(',', $fieldList);
        $query[] = $this->addPkCondition();

        return join(' ', $query);
    }
    
    /**
     * 创建select查询语句
     * @return string
     */
    protected function buildSelect()
    {
        if ($this->isRawQuery) {
            $this->queryParams = $this->rawParams;
            return $this->rawQuery;
        }
        
        return join(
            ' ', 
            [
                $this->buildSelectStart(),
                $this->buildJoin(),
                $this->buildWhere(),
                $this->buildOrderBy(),
                $this->buildLimit(),
                $this->buildOffset()
            ]
        );
    }
    
    /**
     * 创建SELECT查询语句起始部分
     * @return string
     */
    protected function buildSelectStart()
    {
        $columns = is_string($this->selectColumns) ? $this->selectColumns : join(',', $this->selectColumns);
        $fragment = 'select '.$columns.' from '.$this->tableName;
        if ($this->tableAlias) {
            $fragment .= ' as '.$this->tableAlias;
        }
        return $fragment;
    }
    
    /**
     * 创建查询语句的join部分
     * @return string
     */
    protected function buildJoin()
    {
        return join(' ', $this->join);
    }
    
    /**
     * 创建查询语句的where部分
     * @return string
     */
    protected function buildWhere()
    {
        if (count($this->where) == 0) {
            return '';
        }
        return 'where '.join(' and ', $this->where);
    }
    
    /**
     * 创建查询语句的order by部分
     * @return string
     */
    protected function buildOrderBy()
    {
        if (count($this->orderBy) == 0) {
            return '';
        }
        return 'order by '.join(',', $this->orderBy);
    }
    
    /**
     * 创建查询语句的limit部分
     * @return string
     */
    protected function buildLimit()
    {
        if ($this->limit)
        {
            return 'limit '.$this->limit;
        } else {
            return '';
        }
    }
    
    /**
     * 创建查询语句的offset部分
     * @return string
     */
    protected function buildOffset()
    {
        if (is_null($this->offset) || !$this->limit)
        {
            return '';
        } else {
            return 'offset '.$this->offset;
        }
    }
    
    /**
     * 添加主键WHERE条件子句
     */
    protected function addPkCondition()
    {
        $where = 'where '.$this->getPkColumn().'=:'.$this->getPkColumn();
        
        return $where;
    }
    
    /**
     * 设置要执行的SQL查询语句
     * @param string $query
     * @param array $params
     * @return Db
     */
    public function rawQuery($query, $params=[])
    {
        $this->isRawQuery = true;
        $this->rawQuery = $query;
        $this->rawParams = $params;
        return $this;
    }
    
    /**
     * 添加join关联子句
     * @return Db
     */
    public function join($tableName, $constraint, $tableAlias=null, $joinType='left') 
    {
        if (!is_null($tableAlias)) {
            $tableName .= ' as '.$tableAlias;
        }
        $this->join[] = $joinType.' join '.$tableName.' on '.$constraint;
        return $this;
    }
    
    /**
     * where条件语句
     * @param string $condition
     * @param string $params
     */
    public function whereRaw($condition, $params=null)
    {
        $this->where[] = $condition;
        return $this;
    }
    
    /**
     * 设置主键ID的过滤条件
     * @param int|string $id
     */
    public function whereIdIs($id)
    {
        return $this->where($this->getPkColumn(), $id);
    }
    
    /**
     * 添加where条件
     * @param string $column
     * @param string|int $val
     * @param string $type
     * @return Db
     */
    public function where($column, $val, $type='=')
    {
        if (false !== strpos($column, '.')) {
            $key = explode('.', $column);
            $key = $key[1];
        } else {
            $key = $column;
        }
        if ($this->tableAlias) {
            $column = $this->tableAlias.'.'.$column;
        }
        $this->where[] = $column.' '.$type.' :'.$key.' ';
        $this->queryParams[$key] = $val;
        return $this;
    }
    
    /**
     * 添加一个含有or关系的where子句
     * @param array $values
     * @return Db
     */
    public function whereOr($values)
    {
        $condition = [];
        foreach ($values as $item) {
            if (false !== strpos($item[0], '.')) {
                $key = explode('.', $item[0]);
                $key = $key[1];
            } else {
                $key = $item[0];
            }
            $condition[] = $item[0].' '.$item[1].' :'.$key;
            $this->queryParams[$key] = $item[2];
        }
        $this->where[] = '('.join(' or ', $condition).')';
        return $this;
    }
    
    /**
     * where column in 条件子句
     * @param string $column
     * @param array $arr
     * @return Db
     */
    public function whereIn($column, $arr) 
    {
        $key = $column;
        if ($this->tableAlias) {
            $column = $this->tableAlias.'.'.$column;
        }
        $where= $column.' in (';
        $in = [];
        foreach ($arr as $i => $v) {
            $in[] = ':'.$key.$i;
            $this->queryParams[$key.$i] = $v;
        }
        $this->where[] = $where.join(',', $in).')';
        return $this;
    }
    
    /**
     * like 查询条件
     * @param string $column
     * @param string $val
     * @return Db
     */
    public function whereLike($column, $val) 
    {
        $key = $column;
        if ($this->tableAlias) {
            $column = $this->tableAlias.'.'.$column;
        }
        $this->where[] = $column.' like :'.$key.' ';
        $this->queryParams[$key] = $val;
        return $this;
    }
    
    /**
     * order by 
     * @param string $order
     * @param string $type
     */
    public function orderBy($order, $type='asc')
    {
        if (is_null($type)) {
            $this->orderBy[] = $order;
        } else {
            $this->orderBy[] = $order.' '.$type;
        }
        return $this;
    }
    
    /**
     * limit
     * @param int $limit
     * @return Db
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * offset
     * @param int $offset
     * @return Db
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * SELECT查询要提取的字段列表
     * @param array|string $columns
     * @return Db
     */
    public function selectColumns($columns)
    {
        $this->selectColumns = $columns;
        return $this;
    }
    
    /**
     * 选择数据记录中指定字段的值
     * @param string $columnName
     * @param string $id
     * @return boolean|multitype:mixed
     */
    public function findColumn($column=null, $id=null)
    {
        if (!is_null($id)) {
            $this->whereIdIs($id);
        }
        if ($column) {
            $this->selectColumns($column);
        }
        $this->limit(1);
        $this->fetchStyle = PDO::FETCH_COLUMN;
        $rows = $this->run();
        
        if (empty($rows)) {
            return false;
        }
        return $rows[0];
    }
    
    /**
     * 查询一条记录为对象
     * @param string $id
     * @param int $returnType
     * @return boolean|array|Db
     */
    public function findOne($id=null, $returnModel=true)
    {
        $row = $this->findOneArray($id);
        if (!$row)
        {
            return false;
        }
        
        return ($returnModel)
                ? $this->createInstanceFromRow($row)
                : (object)$row;
    }

    /**
     * 查询一条记录为数组
     * @param string $id
     * @param int $returnType
     * @return boolean|array|Db
     */
    public function findOneArray($id=null)
    {
        if (is_bool($id)) {
            $returnModel = $id;
            $id = null;
        } elseif (is_array($id)) {
            $column = $id[0];
            $value = $id[1];
            $this->where($column, $value);
            $id = null;
        }
        if (!is_null($id)) {
            $this->whereIdIs($id);
        }
        $this->limit(1);
        $this->fetchStyle = PDO::FETCH_ASSOC;
        $row = $this->run();

        if (empty($row)) {
            return false;
        }
        
        return $row;
    }
    
    /**
     * 获取所有记录
     * @param string $condition
     * @param int $returnType
     * @return boolean|array|Db
     */
    public function findAll($condition=null, $returnType=1) 
    {
        if (is_int($condition) || ctype_digit($condition)) {
            $returnType = $condition;
            $condition = null;
        } else if (is_string($condition)) {
            $this->where[] = $condition;
        }
        
        $this->fetchStyle = PDO::FETCH_ASSOC;
        $rows = $this->run();
        
        if (empty($rows)) {
            return [];
        }
        return ($returnType>0) 
                ? ($returnType==1 ? json_decode(json_encode($rows)) : $rows) 
                : array_map(array($this, 'createInstanceFromRow'), $rows);
    }
    
    /**
     * 获取所有记录(数组格式）
     * @param string $condition
     * @return boolean|array|Db
     */
    public function findArray($condition=null)
    {
        return $this->findAll($condition, 2);
    }
    
    /**
     * 数据库COUNT统计总记录数
     * @param string $column
     * @return Ambigous <boolean, multitype:mixed >
     */
    public function count($column = '*')
    {
        return $this->setPkColumn('uid')->findColumn('count('.$column.')');
    }
    
    /**
     * 返回对象数据的数组
     * @return array
     */
    public function asArray()
    {
        return $this->metaData;
    }
    
    /**
     * 插入数据
     * @param unknown $data
     * @return boolean
     */
    public function insert($data)
    {
        $this->resetProperties();
        
        foreach ($data as $field => $value) {
            $this->__set($field, $value);
        }
        
        $this->isNew = true;
        
        return $this->save();
    }
    
    /**
     * 保存对象中已更新的字段属性
     * @return boolean
     */
    public function save()
    {
        $params = [];
        
        if ($this->isNew) {
            $query = $this->buildInsert();
        } elseif (!$this->dirtyData) {
            return true;
        } else {
            $query = $this->buildUpdate();
            $params[$this->getPkColumn()] = $this->metaData[$this->pkColumn];
        }
        
        foreach ($this->dirtyData as $k => $v) {
            $params[$k] = $v;
        }
        
        $success = $this->execute($query, $params, $this->connectionName);
        
        if ($this->isNew) {
            $this->isNew = false;
            $this->metaData[$this->pkColumn] = $this->getLastInsertId();
        }
        
        $this->dirtyData = [];
        
        return $success;
    }
    
    /**
     * 删除一条记录
     * @param null|int $pkVal
     * @return boolean
     */
    public function delete($pkVal=null)
    {
        $pk = $this->getPkColumn();
        if ($pkVal) {
            $this->where($pk, $pkVal);
        } else if ($this->isNew && empty($this->where)) {
            return true;
        } else if (!$this->$pk && empty($this->where)) {
            return false;
        }
        if (empty($this->where)) {
            $condition = $this->addPkCondition();
            $params = [$pk=>$this->$pk];
        } else {
            $condition = $this->buildWhere();
            $params = $this->queryParams;
        }
        
        $this->resetProperties();
        
        $query = 'delete from '.$this->tableName.' '.$condition;
        return $this->execute($query, $params);
    }
    
    /**
     * UPDATE
     * @param array $data
     * @param string $pkVal
     * @return boolean
     */
    public function update($data, $pkVal=null)
    {
        $this->resetProperties();
        
        $sets = [];
        foreach ($data as $column => $val) {
            $sets[] = $column.'=:'.$column;
            $params[$column] = $val;
        }
        $sets = join(',', $sets);
        
        if ($pkVal)
        {
            $this->where($this->getPkColumn(), $pkVal);
        }
        $params = array_merge($params, $this->queryParams);
        
        $query = 'update '.$this->tableName.' set '.$sets.' '.$this->buildWhere();
        return $this->execute($query, $params);
    }
    
    /**
     * 对字段进行加减值操作
     * 如果是减操作，$val为负值
     * 如果要对多个字段同时进行计算，则$column为数组，$val为null，数组格式为[字段=>值（正负）, 字段=>值...]
     * @param string|column $column
     * @param int $val
     * @return boolean
     */
    public function plus($column, $val=null)
    {
        $this->resetProperties();
        
        if (is_array($column)) {
            $data = $column;
        } else {
            $data = [$column=>$val];
        }
        $sets = [];
        foreach ($data as $column => $val) {
            $val = (int)$val;
            $operator = $val>0 ? '+' : '-';
            $sets[] = $column.'='.$column.$operator.$val;
        }
        $sets = join(',', $sets);
        
        $query = 'update '.$this->tableName.' set '.$sets.' '.$this->buildWhere();
        return $this->execute($query);
    }
    
    /**
     * 设置多个字段值
     * @param string|array $property
     * @param string $value
     * @return Db
     */
    public function set($property, $value=null)
    {
        if (is_array($property)) {
            $data = $property;
        } else {
            $data = [$property => $value];
        }
        foreach ($data as $prop => $val) {
            $this->__set($prop, $val);
        }
        return $this;
    }
    
    /**
     * 是否新对象
     * @return boolean
     */
    public function isNew() 
    {
        return $this->isNew;
    }
    
    /**
     * 获取最近一次执行的SQL脚本命令
     * @return string
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }
    
    /**
     * 获取最近一次insert插入的自增ID
     * @return string
     */
    public function getLastInsertId() 
    {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * 设置主键字段名
     * @param string $columnName
     */
    public function setPkColumn($columnName)
    {
        $this->pkColumn = $columnName;
        return $this;
    }
    
    /**
     * 获取主键字段名
     * @return string
     */
    public function getPkColumn()
    {
        return $this->pkColumn;
    }
    
    /**
     * 设置主键值
     * @param string $val
     */
    public function setPkId($val)
    {
        $this->metaData[$this->pkColumn] = $val;
    }
    
    /**
     * 获取主键值
     * @return Ambigous <NULL, multitype:>
     */
    public function getPkId()
    {
        return isset($this->metaData[$this->pkColumn]) ? $this->metaData[$this->pkColumn] : null;
    }
    
    /**
     * 获取行的结果方式
     * @param int $style
     */
    public function setFetchStyle($style) 
    {
        $this->fetchStyle = $style;
        return $this;
    }
    
    /**
     * 从一行记录创建一个对象
     * @param array $row
     * @return Db
     */
    public function createInstanceFromRow($row)
    {
        $instance = self::table($this->tableName, '', $this->connectionName);
        $instance->setPkColumn($this->getPkColumn());
        $instance->metaData = $row;
        $instance->isNew = false;
        return $instance;
    }
    
    /**
     * 设置或返回错误信息
     */
    public function errorInfo($errorInfo=null)
    {
        if (is_null($errorInfo)) {
            return $this->errorInfo;
        } else {
            $this->errorInfo = $errorInfo;
            return $errorInfo;
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see PDO::beginTransaction()
     */
    public function beginTransaction()
    {
        if (!$this->pdo->inTransaction) {
            $this->pdo->beginTransaction();
        }
        return true;
    }
    
    /**
     * (non-PHPdoc)
     * @see PDO::commit()
     */
    public function commit()
    {
        if ($this->pdo->inTransaction) {
            $this->pdo->commit();
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see PDO::commit()
     */
    public function rollBack()
    {
        if ($this->pdo->inTransaction) {
            $this->pdo->rollBack();
            return true;
        } else {
            return false;
        }
    }
    
    public function __set($property, $value)
    {
        $this->metaData[$property] = $value;
        $this->dirtyData[$property] = $value;
    }
    
    public function __get($property)
    {
        return isset($this->metaData[$property]) ? $this->metaData[$property] : null;
    }
    
}