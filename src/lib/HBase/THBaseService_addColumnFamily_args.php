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

class THBaseService_addColumnFamily_args {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'tableName',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TTableName',
        ),
        2 => array(
            'var'        => 'column',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TColumnFamilyDescriptor',
        ),
    );

    /**
     * the tablename to add column family to
     *
     * @var TTableName
     */
    public $tableName = null;
    /**
     * column family descriptor of column family to be added
     *
     * @var TColumnFamilyDescriptor
     */
    public $column = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['tableName'])) {
                $this->tableName = $vals['tableName'];
            }
            if (isset($vals['column'])) {
                $this->column = $vals['column'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_addColumnFamily_args';
    }


    public function read($input) {
        $xfer  = 0;
        $fname = null;
        $ftype = 0;
        $fid   = 0;
        $xfer  += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == TType::STOP) {
                break;
            }
            switch ($fid) {
                case 1:
                    if ($ftype == TType::STRUCT) {
                        $this->tableName = new TTableName();
                        $xfer            += $this->tableName->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRUCT) {
                        $this->column = new TColumnFamilyDescriptor();
                        $xfer         += $this->column->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }

    public function write($output) {
        $xfer = 0;
        $xfer += $output->writeStructBegin('THBaseService_addColumnFamily_args');
        if ($this->tableName !== null) {
            if (!is_object($this->tableName)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('tableName', TType::STRUCT, 1);
            $xfer += $this->tableName->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->column !== null) {
            if (!is_object($this->column)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('column', TType::STRUCT, 2);
            $xfer += $this->column->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
