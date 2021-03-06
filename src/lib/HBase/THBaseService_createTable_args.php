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

class THBaseService_createTable_args {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'desc',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TTableDescriptor',
        ),
        2 => array(
            'var'        => 'splitKeys',
            'isRequired' => false,
            'type'       => TType::LST,
            'etype'      => TType::STRING,
            'elem'       => array(
                'type' => TType::STRING,
            ),
        ),
    );

    /**
     * table descriptor for table
     *
     * @var TTableDescriptor
     */
    public $desc = null;
    /**
     * rray of split keys for the initial regions of the table
     *
     * @var string[]
     */
    public $splitKeys = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['desc'])) {
                $this->desc = $vals['desc'];
            }
            if (isset($vals['splitKeys'])) {
                $this->splitKeys = $vals['splitKeys'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_createTable_args';
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
                        $this->desc = new TTableDescriptor();
                        $xfer       += $this->desc->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::LST) {
                        $this->splitKeys = array();
                        $_size281        = 0;
                        $_etype284       = 0;
                        $xfer            += $input->readListBegin($_etype284, $_size281);
                        for ($_i285 = 0; $_i285 < $_size281; ++$_i285) {
                            $elem286            = null;
                            $xfer               += $input->readString($elem286);
                            $this->splitKeys [] = $elem286;
                        }
                        $xfer += $input->readListEnd();
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
        $xfer += $output->writeStructBegin('THBaseService_createTable_args');
        if ($this->desc !== null) {
            if (!is_object($this->desc)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('desc', TType::STRUCT, 1);
            $xfer += $this->desc->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->splitKeys !== null) {
            if (!is_array($this->splitKeys)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('splitKeys', TType::LST, 2);
            $output->writeListBegin(TType::STRING, count($this->splitKeys));
            foreach ($this->splitKeys as $iter287) {
                $xfer += $output->writeString($iter287);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
