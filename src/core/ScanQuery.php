<?php


namespace Gino\EasyHBase;


use HBase\TColumn;
use HBase\TScan;
use HBase\TTimeRange;

class ScanQuery {


    /**
     * @var TScan
     */
    public $scan = null;

    /**
     * @var TColumn[]
     */
    private $__columns = [];

    public function __construct(?TScan $scan = null) {
        if ($scan) {
            $this->scan = $scan;
        } else {
            $this->scan = new TScan();
        }
        $this->prepare();
    }

    /**
     * @return static
     */
    public static function create() {
        return new static();
    }

    /**
     * @return $this
     */
    public function prepare() {
        if (!empty($this->scan->columns)) {
            foreach ($this->scan->columns as $column) {
                $this->__columns[sprintf('%s:%s', $column->family, $column->qualifier)] = $column;
            }
        }
        return $this;
    }

    /**
     * @return TScan
     */
    public function getScan(): TScan {
        return $this->scan;
    }

    /**
     * row_key >= val
     *
     * @param string $val
     * @return $this
     */
    public function startRow(string $val) {
        $this->scan->startRow = $val;
        return $this;
    }

    /**
     * row_key < val
     *
     * @param string $val
     * @return $this
     */
    public function stopRow(string $val) {
        $this->scan->stopRow = $val;
        return $this;
    }

    /**
     * @param string $start_row
     * @param string $stop_row
     * @return $this
     */
    public function betweenRow(string $start_row, string $stop_row) {
        $this->startRow($start_row);
        $this->stopRow($stop_row);
        return $this;
    }

    /**
     * add scan column
     *
     * @param string|array $column
     * @return $this
     */
    public function column($column) {
        if (is_string($column)) {
            $column = explode(',', $column);
        }

        if (!is_array($column)) {
            throw new \InvalidArgumentException('column type must be array');
        }

        array_walk($column, function (&$val) {
            $val = trim($val);
        });


        $tcols = Convert::list2TColumn($column);

        foreach ($tcols as $tcol) {
            /**
             * @var TColumn $tcol
             */

            $this->__columns[sprintf('%s:%s', $tcol->family, $tcol->qualifier)] = $tcol;
        }

        $this->scan->columns = array_values($this->__columns);

        return $this;
    }

    /**
     * how many records will be receive in per rpc request, default value is 1.
     * it was helpful for performance optimization, but will make the transfer to be slower.
     *
     * @param int $num
     * @return $this
     */
    public function caching(int $num) {
        $this->scan->caching = $num;
        return $this;
    }

    /**
     * how many columns will be receive in per results, default value is 1.
     *
     * @param int $size
     * @return $this
     */
    public function batchSize(int $size) {
        $this->scan->batchSize = $size;
        return $this;
    }

    /**
     * set the attribute
     *
     * @param string|array $key if value type is array, ignore argument#2
     * @param string $val
     * @return $this
     */
    public function attribute($key, string $val = '') {
        if (is_null($this->scan->attributes)) {
            $this->scan->attributes = [];
        }
        if (is_array($key)) {
            $this->scan->attributes = array_merge($this->scan->attributes, $key);
        } else {
            $this->scan->attributes[$key] = $val;
        }
        return $this;
    }

    /**
     * set the authorization
     *
     * @param string|array $label
     * @return $this
     */
    public function authorization($label) {
        if (is_null($this->scan->authorizations)) {
            $this->scan->authorizations = [];
        }
        if (is_array($label)) {
            $this->scan->authorizations = array_unique(array_merge($this->scan->attributes, $label));
        } else {
            $this->scan->attributes[] = $label;
        }

        return $this;
    }

    /**
     * scan by reversed
     *
     * @param bool $reversed
     * @return $this
     */
    public function reversed(bool $reversed = true) {
        $this->scan->reversed = $reversed;
        return $this;
    }

    /**
     * set block cache is true, hbase will store the request result.
     * it can promote the performance of reading data .
     * default setting is true .
     *
     * @param bool $cache
     * @return $this
     */
    public function cacheBlocks(bool $cache) {
        $this->scan->cacheBlocks = $cache;
        return $this;
    }

    /**
     * read data from multi version.
     * default setting is 1, always read the newest data.
     *
     * @param int $max_versions
     * @return $this
     */
    public function maxVersion(int $max_versions) {
        $this->scan->maxVersions = $max_versions;
        return $this;
    }

    /**
     * column timestamp >= millisecond
     *
     * @param string $millisecond
     * @return $this
     */
    public function startTime(string $millisecond) {
        if (is_null($this->scan->timeRange)) {
            $this->scan->timeRange = new TTimeRange();
        }
        $this->scan->timeRange->minStamp = $millisecond;
        return $this;
    }

    /**
     * column timestamp < millisecond
     *
     * @param string $millisecond
     * @return $this
     */
    public function stopTime(string $millisecond) {
        if (is_null($this->scan->timeRange)) {
            $this->scan->timeRange = new TTimeRange();
        }
        $this->scan->timeRange->maxStamp = $millisecond;
        return $this;
    }

    /**
     * @param string $start_ms
     * @param string $stop_ms
     * @return $this
     */
    public function betweenTime(string $start_ms, string $stop_ms) {
        $this->scan->timeRange = new TTimeRange(['minStamp' => $start_ms, 'maxStamp' => $stop_ms]);
        return $this;
    }

    /**
     * @param Filter $filter
     * @return $this
     */
    public function filter(Filter $filter) {
        return $this->filterString($filter->toString());
    }

    /**
     *
     * 1、FilterList代表一个过滤器列表
     * FilterList.Operator.MUST_PASS_ALL -->and
     * FilterList.Operator.MUST_PASS_ONE -->or
     * eg、FilterList list = new FilterList(FilterList.Operator.MUST_PASS_ONE);
     * 2、SingleColumnValueFilter
     * 3、ColumnPrefixFilter用于指定列名前缀值相等
     * 4、MultipleColumnPrefixFilter和ColumnPrefixFilter行为差不多，但可以指定多个前缀。
     * 5、QualifierFilter是基于列名的过滤器。
     * 6、RowFilter
     * 7、RegexStringComparator是支持正则表达式的比较器。
     * 8、SubstringComparator用于检测一个子串是否存在于值中，大小写不敏感。
     *
     * @param string $filter_string
     * @return $this
     */
    public function filterString(string $filter_string) {
        $this->scan->filterString = $filter_string;
        return $this;
    }

    /**
     * DEFAULT, STREAM, PREAD ??
     *
     * @param int $type
     * @return $this
     */
    public function readType(int $type) {
        $this->scan->readType = $type;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit) {
        $this->scan->limit = $limit;
        return $this;
    }

    /**
     * @param int $consistency
     * @return $this
     */
    public function consistency(int $consistency) {
        $this->scan->consistency = $consistency;
        return $this;
    }

    /**
     * @param int $targetReplicaId
     * @return $this
     */
    public function targetReplicaId(int $targetReplicaId) {
        $this->scan->targetReplicaId = $targetReplicaId;
        return $this;
    }

    /**
     * @param string $filter
     * @return $this
     */
    public function filterBytes(string $filter) {
        $this->scan->filterBytes = $filter;
        return $this;
    }

}