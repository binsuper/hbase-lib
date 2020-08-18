<?php


namespace Gino\EasyHBase;


use Gino\EasyHBase\Contracts\IHandler;
use HBase\TDelete;
use HBase\THBaseServiceClient;
use HBase\TIllegalArgument;
use HBase\TIOError;
use HBase\TPut;
use HBase\TResult;

class Handler implements IHandler {

    public $a;

    /**
     * @var Connection
     */
    protected $_conn = null;

    /**
     * @var THBaseServiceClient|null
     */
    protected $_client = null;

    public function __construct(Connection $conn) {
        $this->_conn   = $conn;
        $this->_client = new THBaseServiceClient($conn->getProtocol());
    }

    /**
     * @inheritDoc
     */
    public function getClient(): THBaseServiceClient {
        return $this->_client;
    }

    /**
     * @param string|Table $table
     * @return Table
     */
    protected function _getTable($table) {
        if (!($table instanceof Table)) {
            if (is_string($table)) {
                $table = new Table($table, $this->_conn);
            } else {
                throw new \InvalidArgumentException(sprintf('arguments must be string or Table Object'));
            }
        }
        return $table;
    }

    /**
     * return all table name in the namespace
     *
     * @param string $ns namespace match, if empty string given, it will match all namespaces
     * @return \HBase\TTableName[]|mixed
     * @throws TIOError
     */
    public function tables(string $ns = 'default') {
        return $this->getClient()->getTableNamesByNamespace($ns);
    }

    /**
     * @param string $table
     * @return Table
     */
    public function table(string $table) {
        return new Table($table, $this->_conn);
    }


    /**
     * check the table exsits or not
     *
     * @param string|Table $table
     * @return bool
     * @throws TIOError
     */
    public function tableExists($table): bool {
        $table = $this->_getTable($table);
        return $this->getClient()->tableExists(Convert::toTTable($table));
    }

    /**
     * get the table describe
     *
     * @param $table
     * @param bool $toArr
     * @return array
     * @throws TIOError
     */
    public function describe($table, $toArr = true): array {
        $table = $this->_getTable($table);
        $ret   = $this->getClient()->getTableDescriptor(Convert::toTTable($table));
        if ($toArr) {
            return Convert::object2Arr($ret);
        }
        return $ret;
    }

    /**
     * get the table describe
     *
     * @param array $tables
     * @param bool $toArr
     * @return array
     * @throws TIOError
     */
    public function describes(array $tables, $toArr = true): array {
        array_walk($tables, function (&$table) {
            $table = Convert::toTTable($this->_getTable($table));
        });
        $ret = $this->getClient()->getTableDescriptors($tables);
        if ($toArr) {
            return Convert::object2Arr($ret);
        }
        return $ret;
    }

    /**
     * get the table describe
     *
     * @param string $ns
     * @param bool $toArr
     * @return array
     * @throws TIOError
     */
    public function describeByNs(string $ns, $toArr = true): array {
        $ret = $this->getClient()->getTableDescriptorsByNamespace($ns);
        if ($toArr) {
            return Convert::object2Arr($ret);
        }
        return $ret;
    }

    /**
     * put data to table
     *
     * @param string|Table $table
     * @param string $rowkey
     * @param array $datamap key/value map, example ['family:key' => 'val']
     * @param array $params example ['attributes' => Map[], 'durability' => int, 'cellVisibility' => string]
     * @throws TIOError
     */
    public function put($table, string $rowkey, array $datamap, array $params = []) {

        $put   = Convert::createTPut($rowkey, $datamap, $params);
        $table = $this->_getTable($table);
        $this->getClient()->put($table->getFullName(), $put);
    }

    /**
     * put datas to table
     *
     * @param string|Table $table
     * @param array $rows [[rowkey=>string, data=>map, params=>[]]], see the docs of put method
     * @throws TIOError
     */
    public function puts($table, array $rows) {
        $puts = [];
        foreach ($rows as $row) {
            $puts[] = Convert::createTPut($row['rowkey'], $row['data'], $row['params'] ?? []);
        }

        $table = $this->_getTable($table);
        $this->getClient()->putMultiple($table->getFullName(), $puts);
    }

    /**
     * get data from table
     *
     * @param string|Table $table
     * @param string $rowkey
     * @param array $columns keys list, example ['family:key1', 'family:key2']
     * @param array $params
     * @return TResult|mixed
     * @throws TIOError
     */
    public function get($table, string $rowkey, array $columns = [], array $params = []) {

        $get = Convert::createTGet($rowkey, $columns, $params);

        $table = $this->_getTable($table);
        return $this->getClient()->get($table->getFullName(), $get);

    }

    /**
     * get multi data from table
     *
     * @param string|Table $table
     * @param array $params map<rowkey, columns, params, callback>
     * @return TResult[]|mixed
     * @throws TIOError
     */
    public function gets($table, array $params) {
        $gets = [];
        foreach ($params as $info) {

            $rowkey   = $info['rowkey'];
            $columns  = $info['columns'] ?? [];
            $params   = $info['params'] ?? [];
            $callback = $info['callback'] ?? null;

            $get = Convert::createTGet($rowkey, $columns, $params);

            if (is_callable($callback)) {
                call_user_func($callback, $get);
            }

            $gets[] = $get;
        }

        $table = $this->_getTable($table);
        return $this->getClient()->getMultiple($table->getFullName(), $gets);

    }

    /**
     * get query result data
     *
     * @param string|Table $table
     * @param ScanQuery $query
     * @param int $num_rows
     * @return TResult[]|mixed
     * @throws TIOError
     */
    public function getScan($table, ScanQuery $query, int $num_rows = 1) {
        $table = $this->_getTable($table);
        return $this->getClient()->getScannerResults($table->getFullName(), $query->scan, $query->scan->limit ?: $num_rows);
    }

    /**
     * scan with query and invoke callback
     *
     * @param string|Table $table
     * @param ScanQuery $query
     * @param callable $callback arg#1 is the data list(TResult[]), if the callable return false, processing will be broken
     * @param int $per_num_rows
     * @param int $total_scan_rows zero is unlimited
     * @throws TIOError
     * @throws TIllegalArgument
     */
    public function scan($table, ScanQuery $query, $callback, int $per_num_rows = 1, int $total_scan_rows = 0) {
        $table = $this->_getTable($table);
        try {
            $scan_id = $this->getClient()->openScanner($table->getFullName(), $query->scan);
            while (true) {
                $list = $this->getClient()->getScannerRows($scan_id, $per_num_rows);

                // EOF
                if (empty($list)) {
                    break;
                }

                // callback
                if (is_callable($callback)) {
                    if (false === call_user_func($callback, $list)) {
                        break;
                    }
                }

                // total scan rows
                if ($total_scan_rows !== 0) {
                    $total_scan_rows -= count($list);
                    if ($total_scan_rows <= 0) {
                        break;
                    }
                }
            }
        } finally {
            if (isset($scan_id)) {
                $this->getClient()->closeScanner($scan_id);
            }
        }
    }

    /**
     * @param string|Table $table
     * @param string|string[] $rowkey
     * @param string[] $columns
     * @param array $params
     * @throws TIOError
     */
    public function delete($table, $rowkey, array $columns = [], array $params = []) {
        $table = $this->_getTable($table);

        if (is_array($rowkey)) {
            foreach ($rowkey as $key) {
                $deletes[] = Convert::createTDelete($key, $columns, $params);
            }

            if (empty($deletes)) {
                return;
            }

            $this->getClient()->deleteMultiple($table->getFullName(), $deletes);
        } else {
            $delete = Convert::createTDelete($rowkey, $columns, $params);
            $this->getClient()->deleteSingle($table->getFullName(), $delete);
        }
    }

    /**
     * delete one row or multi rows
     *
     * @param string|Table $table
     * @param string|array $rowkey
     * @throws TIOError
     */
    public function deleteRow($table, $rowkey) {
        $this->delete($table, $rowkey);
    }

    /**
     * delete columns
     *
     * @param string|Table $table
     * @param string|array $rowkey
     * @param array $columns
     * @throws TIOError
     */
    public function deleteColumns($table, $rowkey, array $columns) {
        $this->delete($table, $rowkey, $columns);
    }

}