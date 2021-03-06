<?php
/**
 * Autogenerated by Thrift Compiler (0.13.0)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *
 * @generated
 */

namespace HBase;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;

/**
 * Thrift wrapper around
 * org.apache.hadoop.hbase.KeepDeletedCells
 */
final class TKeepDeletedCells {

    /**
     * Deleted Cells are not retained.
     */
    const FALSE = 0;

    /**
     * Deleted Cells are retained until they are removed by other means
     * such TTL or VERSIONS.
     * If no TTL is specified or no new versions of delete cells are
     * written, they are retained forever.
     */
    const TRUE = 1;

    /**
     * Deleted Cells are retained until the delete marker expires due to TTL.
     * This is useful when TTL is combined with MIN_VERSIONS and one
     * wants to keep a minimum number of versions around but at the same
     * time remove deleted cells after the TTL.
     */
    const TTL = 2;

    static public $__names = array(
        0 => 'FALSE',
        1 => 'TRUE',
        2 => 'TTL',
    );

}

