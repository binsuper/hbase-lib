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

class THBaseService_exists_args {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'table',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        2 => array(
            'var'        => 'tget',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TGet',
        ),
    );

    /**
     * the table to check on
     *
     * @var string
     */
    public $table = null;
    /**
     * the TGet to check for
     *
     * @var TGet
     */
    public $tget = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['table'])) {
                $this->table = $vals['table'];
            }
            if (isset($vals['tget'])) {
                $this->tget = $vals['tget'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_exists_args';
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
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->table);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRUCT) {
                        $this->tget = new TGet();
                        $xfer       += $this->tget->read($input);
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
        $xfer += $output->writeStructBegin('THBaseService_exists_args');
        if ($this->table !== null) {
            $xfer += $output->writeFieldBegin('table', TType::STRING, 1);
            $xfer += $output->writeString($this->table);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->tget !== null) {
            if (!is_object($this->tget)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('tget', TType::STRUCT, 2);
            $xfer += $this->tget->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
