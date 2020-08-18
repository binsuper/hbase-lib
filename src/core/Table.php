<?php


namespace Gino\EasyHBase;


use HBase\TColumnValue;
use HBase\TIllegalArgument;
use HBase\TIOError;
use HBase\TResult;

class Table {

    /**
     * @var Connection
     */
    protected $_conn = null;

    /**
     * table namespace
     *
     * @var string
     */
    protected $_ns = 'default';

    /**
     * table name
     *
     * @var string
     */
    protected $_name = null;

    /**
     * 表结构
     *
     * @var array
     */
    protected $_schema = [];

    public function __construct(string $table, Connection $conn) {
        $arr = explode(':', $table);
        if (count($arr) == 2) {
            $table = $arr[1];
            $this->setNs($arr[0]);
        }
        $this->_name = $table;
        $this->_conn = $conn;
    }

    /**
     * @param string $ns
     * @return $this
     */
    public function setNs(string $ns) {
        $this->_ns = $ns;
        return $this;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection {
        return $this->_conn;
    }

    /**
     * @return string
     */
    public function getNs(): string {
        return $this->_ns;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getFullName(): string {
        return $this->getNs() . ':' . $this->getName();
    }

    /**
     * get the table describe
     *
     * @return array
     * @throws TIOError
     */
    public function describe(): array {
        return $this->getConnection()->getHandler()->describe($this, true);
    }

    /**
     * set data
     *
     * @param string $row_key
     * @param array $map
     * @param array $params
     * @return $this
     * @throws TIOError
     */
    public function put(string $row_key, array $map, array $params = []) {
        $this->getConnection()->getHandler()->put($this, $row_key, $map, $params);
        return $this;
    }

    /**
     * set multi data
     *
     * @param array $rows [[rowkey=>$string, data=>$map, params=>$params]]
     * @return $this
     * @throws TIOError
     */
    public function puts(array $rows) {
        $this->getConnection()->getHandler()->puts($this, $rows);
        return $this;
    }

    /**
     * get one row
     *
     * @param string $rowkey
     * @param array $cols
     * @param array $params
     * @return array
     * @throws TIOError
     */
    public function get(string $rowkey, array $cols = [], array $params = []): array {
        $row = $this->getConnection()->getHandler()->get($this, $rowkey, $cols, $params);
        return Convert::listByTResult($row);
    }

    /**
     * get multi row
     *
     * @param array $rowkeys
     * @param array $cols
     * @param array $params
     * @return array
     * @throws TIOError
     */
    public function gets(array $rowkeys, array $cols = [], $params = []): array {

        $args = [];

        foreach ($rowkeys as $rowkey) {
            $args[] = [
                'rowkey'  => $rowkey,
                'columns' => $cols,
                'params'  => $params
            ];
        }

        $list = $this->getConnection()->getHandler()->gets($this, $args);
        return Convert::listByTResults($list);
    }

    /**
     * scan with query and get result data
     *
     * @param ScanQuery $query
     * @param int $num_rows how much rows will be get
     * @return array
     * @throws TIOError
     */
    public function scanResult(ScanQuery $query, int $num_rows = 1) {
        $list = $this->getConnection()->getHandler()->getScan($this, $query, $num_rows);
        return Convert::listByTResults($list);
    }

    /**
     * scan with query and invoke callback
     *
     * @param ScanQuery $query
     * @param callable $callback arg#1 is the data list, if the callable return false, processing will be broken
     * @param int $per_num_rows
     * @param int $total_num_rows zero is unlimited
     * @throws TIOError
     * @throws TIllegalArgument
     */
    public function scan(ScanQuery $query, $callback, int $per_num_rows = 1, int $total_num_rows = 0) {
        $this->getConnection()->getHandler()->scan($this, $query, function ($list) use ($callback) {
            /**
             * @var TResult[] $list
             */
            if (is_callable($callback)) {
                return call_user_func($callback, Convert::listByTResults($list));
            }
        }, $per_num_rows, $total_num_rows);
    }

}