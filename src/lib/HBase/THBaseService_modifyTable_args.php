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

class THBaseService_modifyTable_args {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'desc',
            'isRequired' => true,
            'type'       => TType::STRUCT,
            'class'      => 'TTableDescriptor',
        ),
    );

    /**
     * the descriptor of the table to modify
     *
     * @var TTableDescriptor
     */
    public $desc = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['desc'])) {
                $this->desc = $vals['desc'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_modifyTable_args';
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
        $xfer += $output->writeStructBegin('THBaseService_modifyTable_args');
        if ($this->desc !== null) {
            if (!is_object($this->desc)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('desc', TType::STRUCT, 1);
            $xfer += $this->desc->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
