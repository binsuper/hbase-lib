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

class THRegionInfo {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'regionId',
            'isRequired' => true,
            'type'       => TType::I64,
        ),
        2 => array(
            'var'        => 'tableName',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        3 => array(
            'var'        => 'startKey',
            'isRequired' => false,
            'type'       => TType::STRING,
        ),
        4 => array(
            'var'        => 'endKey',
            'isRequired' => false,
            'type'       => TType::STRING,
        ),
        5 => array(
            'var'        => 'offline',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        6 => array(
            'var'        => 'split',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        7 => array(
            'var'        => 'replicaId',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
    );

    /**
     * @var int
     */
    public $regionId = null;
    /**
     * @var string
     */
    public $tableName = null;
    /**
     * @var string
     */
    public $startKey = null;
    /**
     * @var string
     */
    public $endKey = null;
    /**
     * @var bool
     */
    public $offline = null;
    /**
     * @var bool
     */
    public $split = null;
    /**
     * @var int
     */
    public $replicaId = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['regionId'])) {
                $this->regionId = $vals['regionId'];
            }
            if (isset($vals['tableName'])) {
                $this->tableName = $vals['tableName'];
            }
            if (isset($vals['startKey'])) {
                $this->startKey = $vals['startKey'];
            }
            if (isset($vals['endKey'])) {
                $this->endKey = $vals['endKey'];
            }
            if (isset($vals['offline'])) {
                $this->offline = $vals['offline'];
            }
            if (isset($vals['split'])) {
                $this->split = $vals['split'];
            }
            if (isset($vals['replicaId'])) {
                $this->replicaId = $vals['replicaId'];
            }
        }
    }

    public function getName() {
        return 'THRegionInfo';
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
                    if ($ftype == TType::I64) {
                        $xfer += $input->readI64($this->regionId);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->tableName);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->startKey);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->endKey);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->offline);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->split);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->replicaId);
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
        $xfer += $output->writeStructBegin('THRegionInfo');
        if ($this->regionId !== null) {
            $xfer += $output->writeFieldBegin('regionId', TType::I64, 1);
            $xfer += $output->writeI64($this->regionId);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->tableName !== null) {
            $xfer += $output->writeFieldBegin('tableName', TType::STRING, 2);
            $xfer += $output->writeString($this->tableName);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->startKey !== null) {
            $xfer += $output->writeFieldBegin('startKey', TType::STRING, 3);
            $xfer += $output->writeString($this->startKey);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->endKey !== null) {
            $xfer += $output->writeFieldBegin('endKey', TType::STRING, 4);
            $xfer += $output->writeString($this->endKey);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->offline !== null) {
            $xfer += $output->writeFieldBegin('offline', TType::BOOL, 5);
            $xfer += $output->writeBool($this->offline);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->split !== null) {
            $xfer += $output->writeFieldBegin('split', TType::BOOL, 6);
            $xfer += $output->writeBool($this->split);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->replicaId !== null) {
            $xfer += $output->writeFieldBegin('replicaId', TType::I32, 7);
            $xfer += $output->writeI32($this->replicaId);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
