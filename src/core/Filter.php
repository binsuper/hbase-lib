<?php


namespace Gino\EasyHBase;


class Filter {

    const OP_LT  = '<';
    const OP_LE  = '<=';
    const OP_EQ  = '=';
    const OP_NEQ = '!=';
    const OP_GT  = '>';
    const OP_GE  = '>=';

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
     * match the column name(only name, not column family)
     *
     * @param string $name column name, it's not contain the column family
     * @param string $opertor support LT, LS, QE, NEQ, GT, GE
     * @return $this
     */
    public function binaryQualifier(string $name, string $opertor = self::OP_EQ) {
        $this->filters[] = sprintf("QualifierFilter(%s, 'binary:%s')", $opertor, $name);
        return $this;
    }

    /**
     * match the column name(only name, not column family)
     *
     * @param string $name column name, it's not contain the column family
     * @param string $opertor support LT, LS, QE, NEQ, GT, GE
     * @return $this
     */
    public function binaryPrefixQualifier(string $name, string $opertor = self::OP_EQ) {
        $this->filters[] = sprintf("QualifierFilter(%s, 'binaryprefix:%s')", $opertor, $name);
        return $this;
    }

    /**
     * match the column name(only name, not column family)
     *
     * @param string $name column name, it's not contain the column family
     * @param string $opertor support QE, NQE
     * @return $this
     */
    public function substringQualifier(string $name, string $opertor = self::OP_EQ) {
        $this->filters[] = sprintf("QualifierFilter(%s, 'substring:%s')", $opertor, $name);
        return $this;
    }

    /**
     * match the column name(only name, not column family)
     *
     * @param string $name column name, it's not contain the column family
     * @param string $opertor support QE, NQE
     * @return $this
     */
    public function regexQualifier(string $name, string $opertor = self::OP_EQ) {
        $this->filters[] = sprintf("QualifierFilter(%s, 'regexstring:%s')", $opertor, $name);
        return $this;
    }

}