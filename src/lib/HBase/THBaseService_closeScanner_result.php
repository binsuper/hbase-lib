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

class THBaseService_closeScanner_result {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var'        => 'io',
            'isRequired' => false,
            'type'       => TType::STRUCT,
            'class'      => 'TIOError',
        ),
        2 => array(
            'var'        => 'ia',
            'isRequired' => false,
            'type'       => TType::STRUCT,
            'class'      => 'TIllegalArgument',
        ),
    );

    /**
     * @var TIOError
     */
    public $io = null;
    /**
     * if the scannerId is invalid
     *
     * @var TIllegalArgument
     */
    public $ia = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['io'])) {
                $this->io = $vals['io'];
            }
            if (isset($vals['ia'])) {
                $this->ia = $vals['ia'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_closeScanner_result';
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
                        $this->io = new TIOError();
                        $xfer     += $this->io->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRUCT) {
                        $this->ia = new TIllegalArgument();
                        $xfer     += $this->ia->read($input);
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
        $xfer += $output->writeStructBegin('THBaseService_closeScanner_result');
        if ($this->io !== null) {
            $xfer += $output->writeFieldBegin('io', TType::STRUCT, 1);
            $xfer += $this->io->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->ia !== null) {
            $xfer += $output->writeFieldBegin('ia', TType::STRUCT, 2);
            $xfer += $this->ia->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
