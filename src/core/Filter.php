<?php


namespace Gino\EasyHBase;


class Filter {

    const OP_LT  = '<';
    const OP_LE  = '<=';
    const OP_EQ  = '=';
    const OP_NEQ = '!=';
    const OP_GT  = '>';
    const OP_GE  = '>=';

    const COMPARE_BINARY        = 'binary';         // compare by dictionary sort, support LT, LS, QE, NEQ, GT, GE
    const COMPARE_BINARY_PREFIX = 'binaryprefix';   // compare prefix by dictionary sort, support LT, LS, QE, NEQ, GT, GE
    const COMPARE_SUBSTRING     = 'substring';      // compare by substring, support QE, NEQ
    const COMPARE_REGEXSTRING   = 'regexstring';    // compare by regex string, support QE, NEQ

    /**
     * @var array map[]
     */
    public $filters = [];


    public function __toString() {
        return $this->formatString($this->filters);
    }

    /**
     * @return string
     */
    public function toString() {
        return (string)$this;
    }

    /**
     * @return static
     */
    public static function create() {
        return new static();
    }

    /**
     * @param array $filters
     * @param string $glue
     *
     * @return string
     */
    public static function formatString(array $filters, string $glue = 'AND'): string {
        $stack = [];

        foreach ($filters as $val) {
            if (is_array($val)) {
                list($op, $val) = $val;
            }
            if (isset($op) && in_array((string)$op, ['AND', 'OR'])) {
                $stack[] = '(' . static::formatString($val, $op) . ')';
            } else {
                $stack[] = $val;
            }

            unset($op);
        }

        return implode(" {$glue} ", $stack);
    }

    /**
     * @param callback $callback arg#1 is an object of Filter
     *
     * @return $this
     */
    public function glueAnd($callback) {
        $obj = new self();

        call_user_func($callback, $obj);

        if (!empty($obj->filters)) {
            $this->filters[] = ['AND', $obj->filters];
        }

        return $this;
    }

    /**
     * @param callback $callback arg#1 is an object of Filter
     *
     * @return $this
     */
    public function glueOr($callback) {
        $obj = new self();

        call_user_func($callback, $obj);

        if (!empty($obj->filters)) {
            $this->filters[] = ['OR', $obj->filters];
        }

        return $this;
    }

    /**
     * rowkey prefix match
     *
     * @param string|string[] $prefix
     *
     * @return $this
     */
    public function prefixRowkey($prefix) {
        if (is_array($prefix)) {
            foreach ($prefix as $node) {
                static::prefixRowkey($node);
            }
        } else {
            $this->filters[] = sprintf("PrefixFilter('%s')", $prefix);
        }
        return $this;
    }

    /**
     * column prefix match
     *
     * @param string $prefix column name, not family
     *
     * @return $this
     */
    public function prefixColumn(string $prefix) {
        $this->filters[] = sprintf("ColumnPrefixFilter('%s')", $prefix);
        return $this;
    }

    /**
     * multiple column prefix match
     *
     * @param array $prefixs column name list, not family
     *
     * @return $this
     */
    public function prefixMutipleColumn(array $prefixs) {
        $this->filters[] = sprintf("MultipleColumnPrefixFilter(%s)", "'" . implode("','", $prefixs) . "'");
        return $this;
    }

    /**
     * match the column name(only name, not column family)
     *
     * @param string $name         column name, it's not contain the column family
     * @param string $opertor      default is EQ
     * @param string $compare_type supoort COMPARE_BINARY, COMPARE_BINARY_PREFIX, COMPARE_SUBSTRING, COMPARE_REGEXSTRING
     *
     * @return $this
     */
    public function qualifier(string $name, string $opertor = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("QualifierFilter(%s, '%s:%s')", $opertor, $compare_type, $name);
        return $this;
    }

    /**
     * filter the value in result
     *
     * @param string $name         column name, it's not contain the column family
     * @param string $opertor      default is EQ
     * @param string $compare_type supoort COMPARE_BINARY, COMPARE_BINARY_PREFIX, COMPARE_SUBSTRING, COMPARE_REGEXSTRING
     *
     * @return $this
     */
    public function valueFilter(string $name, string $opertor = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("ValueFilter(%s, '%s:%s')", $opertor, $compare_type, $name);
        return $this;
    }

    /**
     * filter the family in result
     *
     * @param string $name         column name, it's not contain the column family
     * @param string $opertor      default is EQ
     * @param string $compare_type supoort COMPARE_BINARY, COMPARE_BINARY_PREFIX, COMPARE_SUBSTRING, COMPARE_REGEXSTRING
     *
     * @return $this
     */
    public function familyFilter(string $name, string $opertor = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("FamilyFilter(%s, '%s:%s')", $opertor, $compare_type, $name);
        return $this;
    }

    /**
     * filter the rowkey in result
     *
     * @param string $name         column name, it's not contain the column family
     * @param string $opertor      default is EQ
     * @param string $compare_type supoort COMPARE_BINARY, COMPARE_BINARY_PREFIX, COMPARE_SUBSTRING, COMPARE_REGEXSTRING
     *
     * @return $this
     */
    public function rowFilter(string $name, string $opertor = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("RowFilter(%s, '%s:%s')", $opertor, $compare_type, $name);
        return $this;
    }

    /**
     * instead of stopRow
     *
     * @TODO this method dose not working correct
     *
     * @param string $row_key      columns count will be get
     * @param string $compare_type supoort COMPARE_BINARY, COMPARE_BINARY_PREFIX, COMPARE_SUBSTRING, COMPARE_REGEXSTRING
     *
     * @return $this
     */
    public function inclusiveStopFilter(string $row_key, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("InclusiveStopFilter('%s:%s')", $compare_type, $row_key);
        return $this;
    }

    /**
     * only get the rowkey、family and column name, does not contain the value.
     * it can promote the transfer speed
     *
     * @return $this
     */
    public function keyOnlyFilter() {
        $this->filters[] = 'KeyOnlyFilter()';
        return $this;
    }

    /**
     * only get the first column with per row
     *
     * @return $this
     */
    public function firstKeyOnlyFilter() {
        $this->filters[] = 'FirstKeyOnlyFilter()';
        return $this;
    }

    /**
     * match the timestamp
     *
     * @param array $tsl millsecond times list, liks ['1598518470410', '1598518470411']
     *
     * @return $this
     */
    public function timestampsFilter(array $tsl) {
        $this->filters[] = sprintf('TimestampsFilter(%s)', implode(',', $tsl));
        return $this;
    }

    /**
     * how many columns will be get in result
     *
     * @param int $count columns count will be get
     *
     * @return $this
     */
    public function columnCountGetFilter(int $count) {
        $this->filters[] = sprintf('ColumnCountGetFilter(%d)', $count);
        return $this;
    }

    /**
     * match the column value.
     * !!! ScanQuery must be add the scan column, otherwise it will be geting a wrong result
     *
     * @param string $family       family name
     * @param string $col_name     column name
     * @param string $val          column value
     * @param string $operator     default is QE
     * @param string $compare_type default is binary
     *
     * @return $this
     */
    public function singleColumnValueFilter(string $family, string $col_name, string $val, string $operator = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("SingleColumnValueFilter('%s', '%s', %s, '%s:%s')", $family, $col_name, $operator, $compare_type, $val);
        return $this;
    }

    /**
     * always it was used like singleColumnValueFilter.
     * but this kind will not return the column which being filter
     *
     * @param string $family       family name
     * @param string $col_name     column name
     * @param string $val          column value
     * @param string $operator     default is QE
     * @param string $compare_type default is binary
     *
     * @return $this
     */
    public function singleColumnValueExcludeFilter(string $family, string $col_name, string $val, string $operator = self::OP_EQ, string $compare_type = self::COMPARE_BINARY) {
        $this->filters[] = sprintf("SingleColumnValueExcludeFilter('%s', '%s', %s, '%s:%s')", $family, $col_name, $operator, $compare_type, $val);
        return $this;
    }

    /**
     * get column in the range of the start column and stop column
     *
     * @param string $starcol start column
     * @param bool $s1
     * @param string $stopcol end column
     * @param bool $s2
     *
     * @return $this
     */
    public function columnRangeFilter(string $starcol, bool $s1, string $stopcol, bool $s2) {
        $this->filters[] = sprintf("ColumnRangeFilter('%s', %s, '%s', %s)", $starcol, $s1 ? 'true' : 'false', $stopcol, $s2 ? 'true' : 'false');
        return $this;
    }

    /**
     * how many count of rows will be get in one page
     *
     * @param int $page
     *
     * @return $this
     */
    public function pageFilter(int $page) {
        $this->filters[] = sprintf("PageFilter(%d)", $page);
        return $this;
    }

    /**
     * how many count of columns will be get in one page
     *
     * @param int $offset
     * @param int $len
     *
     * @return $this
     */
    public function columnPaginationFilter(int $offset, int $len) {
        $this->filters[] = sprintf("ColumnPaginationFilter(%d, %d)", $len, $offset);
        return $this;
    }

}