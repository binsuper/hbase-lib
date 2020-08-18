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

class THBaseService_getTableDescriptorsByPattern_result {

    static public $isValidate = false;

    static public $_TSPEC = array(
        0 => array(
            'var'        => 'success',
            'isRequired' => false,
            'type'       => TType::LST,
            'etype'      => TType::STRUCT,
            'elem'       => array(
                'type'  => TType::STRUCT,
                'class' => 'TTableDescriptor',
            ),
        ),
        1 => array(
            'var'        => 'io',
            'isRequired' => false,
            'type'       => TType::STRUCT,
            'class'      => 'TIOError',
        ),
    );

    /**
     * @var TTableDescriptor[]
     */
    public $success = null;
    /**
     * @var TIOError
     */
    public $io = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['success'])) {
                $this->success = $vals['success'];
            }
            if (isset($vals['io'])) {
                $this->io = $vals['io'];
            }
        }
    }

    public function getName() {
        return 'THBaseService_getTableDescriptorsByPattern_result';
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
                case 0:
                    if ($ftype == TType::LST) {
                        $this->success = array();
                        $_size253      = 0;
                        $_etype256     = 0;
                        $xfer          += $input->readListBegin($_etype256, $_size253);
                        for ($_i257 = 0; $_i257 < $_size253; ++$_i257) {
                            $elem258          = null;
                            $elem258          = new TTableDescriptor();
                            $xfer             += $elem258->read($input);
                            $this->success [] = $elem258;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 1:
                    if ($ftype == TType::STRUCT) {
                        $this->io = new TIOError();
                        $xfer     += $this->io->read($input);
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
        $xfer += $output->writeStructBegin('THBaseService_getTableDescriptorsByPattern_result');
        if ($this->success !== null) {
            if (!is_array($this->success)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('success', TType::LST, 0);
            $output->writeListBegin(TType::STRUCT, count($this->success));
            foreach ($this->success as $iter259) {
                $xfer += $iter259->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->io !== null) {
            $xfer += $output->writeFieldBegin('io', TType::STRUCT, 1);
            $xfer += $this->io->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}
