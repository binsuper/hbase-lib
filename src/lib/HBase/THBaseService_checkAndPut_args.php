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

class THBaseService_checkAndPut_args {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'table',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        2 => array(
            'var'        => 'row',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        3 => array(
            'var'        => 'family',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        4 => array(
            'var'        => 'qualifier',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        5 => array(
            'var'        => 'value',
            'isRequired' => false,
            'type'       => TType::STRING,
        ),
        6 => array(
            'var'        => 'tput',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TPut',
        ),
    );

    /**
     * to check in and put to
     *
     * @var string
     */
    public $table = null;
    /**
     * row to check
     *
     * @var string
     */
    public $row = null;
    /**
     * column family to check
     *
     * @var string
     */
    public $family = null;
    /**
     * column qualifier to check
     *
     * @var string
     */
    public $qualifier = null;
    /**
     * the expected value, if not provided the
     * check is for the non-existence of the
     * column in question
     *
     * @var string
     */
    public $value = null;
    /**
     * the TPut to put if the check succeeds
     *
     * @var TPut
     */
    public $tput = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['table'])) {
                $this->table = $vals['table'];
            }
            if (isset($vals['row'])) {
                $this->row = $vals['row'];
            }
            if (isset($vals['family'])) {
                $this->family = $vals['family'];
            }
            if (isset($vals['qualifier'])) {
                $this->qualifier = $vals['qualifier'];
            }
            if (isset($vals['value'])) {
                $this->value = $vals['value'];
            }
            if (isset($vals['tput'])) {
                $this->tput = $vals['tput'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_checkAndPut_args';
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
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->row);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->family);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->qualifier);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->value);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::STRUCT) {
                        $this->tput = new TPut();
                        $xfer       += $this->tput->read($input);
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
        $xfer += $output->writeStructBegin('THBaseService_checkAndPut_args');
        if ($this->table !== null) {
            $xfer += $output->writeFieldBegin('table', TType::STRING, 1);
            $xfer += $output->writeString($this->table);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->row !== null) {
            $xfer += $output->writeFieldBegin('row', TType::STRING, 2);
            $xfer += $output->writeString($this->row);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->family !== null) {
            $xfer += $output->writeFieldBegin('family', TType::STRING, 3);
            $xfer += $output->writeString($this->family);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->qualifier !== null) {
            $xfer += $output->writeFieldBegin('qualifier', TType::STRING, 4);
            $xfer += $output->writeString($this->qualifier);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->value !== null) {
            $xfer += $output->writeFieldBegin('value', TType::STRING, 5);
            $xfer += $output->writeString($this->value);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->tput !== null) {
            if (!is_object($this->tput)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('tput', TType::STRUCT, 6);
            $xfer += $this->tput->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}