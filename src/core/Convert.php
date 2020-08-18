<?php


namespace Gino\EasyHBase;


use HBase\TAuthorization;
use HBase\TColumn;
use HBase\TColumnValue;
use HBase\TDelete;
use HBase\TGet;
use HBase\TPut;
use HBase\TResult;
use HBase\TTableName;
use HBase\TTimeRange;

class Convert {

    /**
     * convert object to array
     *
     * @param object|array $obj
     * @return array
     */
    public static function object2Arr($obj) {
        if (is_object($obj)) {
            $vars = get_object_vars($obj);
        } else if (is_array($obj)) {
            $vars = $obj;
        }
        array_walk_recursive($vars, function (&$val) {
            if (is_object($val)) {
                $val = static::object2Arr($val);
            }
        });
        return $vars;
    }

    /**
     * @param Table $table
     * @return TTableName
     */
    public static function toTTable(Table $table): TTableName {
        return new TTableName(['ns' => $table->getNs(), 'qualifier' => $table->getName()]);
    }

    /**
     * @param TTableName $tt
     * @param Connection $conn
     * @return Table
     */
    public static function fromTTable(TTableName $tt, Connection $conn): Table {
        $table = new Table($tt->qualifier, $conn);
        $table->setNs($tt->ns);
        return $table;
    }

    /**
     * @param string $family
     * @param string $col
     * @param string $val
     * @param int|null $timestamp
     * @return TColumnValue
     */
    public static function createTColumnValue(string $family, string $col, string $val, ?int $timestamp = null): TColumnValue {
        $args = [
            'family'    => $family,
            'qualifier' => $col,
            'value'     => $val
        ];

        if (!empty($timestamp)) {
            $args['timestamp'] = $timestamp;
        }

        return new TColumnValue($args);
    }

    /**
     * @param array $map
     * @return array
     */
    public static function map2TColumnValue(array $map): array {
        $ret = [];
        foreach ($map as $key => $val) {
            list($family, $col) = explode(':', $key);
            $ret[] = static::createTColumnValue($family, $col, strval($val));
        }
        return $ret;
    }

    /**
     * @param string $family
     * @param string $col
     * @param int|null $timestamp
     * @return TColumn
     */
    public static function createTColumn(string $family, string $col, ?int $timestamp = null): TColumn {
        $args = [
            'family'    => $family,
            'qualifier' => $col
        ];

        if (!empty($timestamp)) {
            $args['timestamp'] = $timestamp;
        }

        return new TColumn($args);
    }

    /**
     * @param array $list
     * @return array
     */
    public static function list2TColumn(array $list): array {
        $ret = [];
        foreach ($list as $val) {
            list($family, $col) = explode(':', $val);
            $ret[] = static::createTColumn($family, $col);
        }
        return $ret;
    }

    /**
     * @param string $row
     * @param array $map key/value map, example ['family:key' => 'val']
     * @param array $params example ['attributes' => Map[], 'durability' => int, 'cellVisibility' => string]
     * @return TPut
     */
    public static function createTPut(string $row, array $map, array $params = []): TPut {
        $columnsValue = static::map2TColumnValue($map);
        $args         = [
            'row'          => $row,
            'columnValues' => $columnsValue
        ];

        if (isset($params['timestamp'])) $args['timestamp'] = $params['timestamp'];
        if (isset($params['attributes'])) $args['attributes'] = $params['attributes'];
        if (isset($params['durability'])) $args['durability'] = $params['durability'];
        if (isset($params['cellVisibility'])) $args['cellVisibility'] = ['expression' => $params['cellVisibility']];

        return new TPut($args);
    }


    /**
     * @param string $row
     * @param array $list keys list, example ['family:key1', 'family:key2']
     * @param array $params
     * @return TGet
     */
    public static function createTGet(string $row, array $list, array $params = []): TGet {
        $columns = static::list2TColumn($list);
        $args    = [
            'row'     => $row,
            'columns' => $columns
        ];

        if (isset($params['timestamp'])) $args['timestamp'] = $params['timestamp']; // millisecond
        if (isset($params['time_range'])) $args['timeRange'] = new TTimeRange(array_combine(['minStamp', 'maxStamp'], $params['time_range'])); // list, time is millisecond
        if (isset($params['max_versions'])) $args['maxVersions'] = $params['max_versions']; // int
        if (isset($params['filter'])) $args['filterString'] = $params['filter']; // string
        if (isset($params['attributes'])) $args['attributes'] = $params['attributes']; // map<string, string>
        if (isset($params['auth'])) $args['auth'] = new TAuthorization(['labels' => $params['auth']]); // list
        if (isset($params['consistency'])) $args['consistency'] = $params['consistency']; // int
        if (isset($params['target_replid'])) $args['targetReplicaId'] = $params['target_replid']; // int
        if (isset($params['cache_blocks'])) $args['cacheBlocks'] = $params['cache_blocks']; // bool
        if (isset($params['store_limit'])) $args['storeLimit'] = $params['store_limit']; // int
        if (isset($params['store_offset'])) $args['storeOffset'] = $params['store_offset']; // int
        if (isset($params['existence_only'])) $args['existence_only'] = $params['existence_only']; // bool
        if (isset($params['filter_bytes'])) $args['filterBytes'] = $params['filter_bytes']; // string

        return new TGet($args);
    }

    /**
     * @param string $row
     * @param array $list keys list, example ['family:key1', 'family:key2']
     * @param array $params
     * @return TDelete
     */
    public static function createTDelete(string $row, array $list, array $params = []): TDelete {
        $columns = static::list2TColumn($list);
        $args    = [
            'row'     => $row,
            'columns' => $columns
        ];

        if (isset($params['timestamp'])) $args['timestamp'] = $params['timestamp']; // millisecond
        if (isset($params['delete_type'])) $args['deleteType'] = $params['delete_type']; // int
        if (isset($params['attributes'])) $args['attributes'] = $params['attributes']; // map<string, string>
        if (isset($params['durability'])) $args['durability'] = $params['durability']; // int

        return new TDelete($args);
    }

    /**
     * @param TResult $row
     * @return array
     */
    public static function listByTResult(TResult $row): array {
        $node = ['row' => $row->row];
        foreach ($row->columnValues as $colval) {
            /**
             * @var TColumnValue $colval
             */
            $key        = sprintf('%s:%s', $colval->family, $colval->qualifier);
            $node[$key] = $colval->value;
        }

        return $node;
    }

    /**
     * @param TResult[] $list
     * @return array
     */
    public static function listByTResults(array $list): array {
        $ret = [];
        foreach ($list as $tr) {
            $ret[$tr->row] = static::listByTResult($tr);
        }
        return $ret;
    }

}