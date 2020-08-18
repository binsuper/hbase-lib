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
 * org.apache.hadoop.hbase.client.ColumnFamilyDescriptor
 */
class TColumnFamilyDescriptor {

    static public $isValidate = false;

    static public $_TSPEC = array(
        1  => array(
            'var'        => 'name',
            'isRequired' => true,
            'type'       => TType::STRING,
        ),
        2  => array(
            'var'        => 'attributes',
            'isRequired' => false,
            'type'       => TType::MAP,
            'ktype'      => TType::STRING,
            'vtype'      => TType::STRING,
            'key'        => array(
                'type' => TType::STRING,
            ),
            'val'        => array(
                'type' => TType::STRING,
            ),
        ),
        3  => array(
            'var'        => 'configuration',
            'isRequired' => false,
            'type'       => TType::MAP,
            'ktype'      => TType::STRING,
            'vtype'      => TType::STRING,
            'key'        => array(
                'type' => TType::STRING,
            ),
            'val'        => array(
                'type' => TType::STRING,
            ),
        ),
        4  => array(
            'var'        => 'blockSize',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        5  => array(
            'var'        => 'bloomnFilterType',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        6  => array(
            'var'        => 'compressionType',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        7  => array(
            'var'        => 'dfsReplication',
            'isRequired' => false,
            'type'       => TType::I16,
        ),
        8  => array(
            'var'        => 'dataBlockEncoding',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        9  => array(
            'var'        => 'keepDeletedCells',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        10 => array(
            'var'        => 'maxVersions',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        11 => array(
            'var'        => 'minVersions',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        12 => array(
            'var'        => 'scope',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        13 => array(
            'var'        => 'timeToLive',
            'isRequired' => false,
            'type'       => TType::I32,
        ),
        14 => array(
            'var'        => 'blockCacheEnabled',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        15 => array(
            'var'        => 'cacheBloomsOnWrite',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        16 => array(
            'var'        => 'cacheDataOnWrite',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        17 => array(
            'var'        => 'cacheIndexesOnWrite',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        18 => array(
            'var'        => 'compressTags',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        19 => array(
            'var'        => 'evictBlocksOnClose',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
        20 => array(
            'var'        => 'inMemory',
            'isRequired' => false,
            'type'       => TType::BOOL,
        ),
    );

    /**
     * @var string
     */
    public $name = null;
    /**
     * @var array
     */
    public $attributes = null;
    /**
     * @var array
     */
    public $configuration = null;
    /**
     * @var int
     */
    public $blockSize = null;
    /**
     * @var int
     */
    public $bloomnFilterType = null;
    /**
     * @var int
     */
    public $compressionType = null;
    /**
     * @var int
     */
    public $dfsReplication = null;
    /**
     * @var int
     */
    public $dataBlockEncoding = null;
    /**
     * @var int
     */
    public $keepDeletedCells = null;
    /**
     * @var int
     */
    public $maxVersions = null;
    /**
     * @var int
     */
    public $minVersions = null;
    /**
     * @var int
     */
    public $scope = null;
    /**
     * @var int
     */
    public $timeToLive = null;
    /**
     * @var bool
     */
    public $blockCacheEnabled = null;
    /**
     * @var bool
     */
    public $cacheBloomsOnWrite = null;
    /**
     * @var bool
     */
    public $cacheDataOnWrite = null;
    /**
     * @var bool
     */
    public $cacheIndexesOnWrite = null;
    /**
     * @var bool
     */
    public $compressTags = null;
    /**
     * @var bool
     */
    public $evictBlocksOnClose = null;
    /**
     * @var bool
     */
    public $inMemory = null;

    public function __construct($vals = null) {
        if (is_array($vals)) {
            if (isset($vals['name'])) {
                $this->name = $vals['name'];
            }
            if (isset($vals['attributes'])) {
                $this->attributes = $vals['attributes'];
            }
            if (isset($vals['configuration'])) {
                $this->configuration = $vals['configuration'];
            }
            if (isset($vals['blockSize'])) {
                $this->blockSize = $vals['blockSize'];
            }
            if (isset($vals['bloomnFilterType'])) {
                $this->bloomnFilterType = $vals['bloomnFilterType'];
            }
            if (isset($vals['compressionType'])) {
                $this->compressionType = $vals['compressionType'];
            }
            if (isset($vals['dfsReplication'])) {
                $this->dfsReplication = $vals['dfsReplication'];
            }
            if (isset($vals['dataBlockEncoding'])) {
                $this->dataBlockEncoding = $vals['dataBlockEncoding'];
            }
            if (isset($vals['keepDeletedCells'])) {
                $this->keepDeletedCells = $vals['keepDeletedCells'];
            }
            if (isset($vals['maxVersions'])) {
                $this->maxVersions = $vals['maxVersions'];
            }
            if (isset($vals['minVersions'])) {
                $this->minVersions = $vals['minVersions'];
            }
            if (isset($vals['scope'])) {
                $this->scope = $vals['scope'];
            }
            if (isset($vals['timeToLive'])) {
                $this->timeToLive = $vals['timeToLive'];
            }
            if (isset($vals['blockCacheEnabled'])) {
                $this->blockCacheEnabled = $vals['blockCacheEnabled'];
            }
            if (isset($vals['cacheBloomsOnWrite'])) {
                $this->cacheBloomsOnWrite = $vals['cacheBloomsOnWrite'];
            }
            if (isset($vals['cacheDataOnWrite'])) {
                $this->cacheDataOnWrite = $vals['cacheDataOnWrite'];
            }
            if (isset($vals['cacheIndexesOnWrite'])) {
                $this->cacheIndexesOnWrite = $vals['cacheIndexesOnWrite'];
            }
            if (isset($vals['compressTags'])) {
                $this->compressTags = $vals['compressTags'];
            }
            if (isset($vals['evictBlocksOnClose'])) {
                $this->evictBlocksOnClose = $vals['evictBlocksOnClose'];
            }
            if (isset($vals['inMemory'])) {
                $this->inMemory = $vals['inMemory'];
            }
        }
    }

    public function getName() {
        return 'TColumnFamilyDescriptor';
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
                        $xfer += $input->readString($this->name);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::MAP) {
                        $this->attributes = array();
                        $_size126         = 0;
                        $_ktype127        = 0;
                        $_vtype128        = 0;
                        $xfer             += $input->readMapBegin($_ktype127, $_vtype128, $_size126);
                        for ($_i130 = 0; $_i130 < $_size126; ++$_i130) {
                            $key131                    = '';
                            $val132                    = '';
                            $xfer                      += $input->readString($key131);
                            $xfer                      += $input->readString($val132);
                            $this->attributes[$key131] = $val132;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::MAP) {
                        $this->configuration = array();
                        $_size133            = 0;
                        $_ktype134           = 0;
                        $_vtype135           = 0;
                        $xfer                += $input->readMapBegin($_ktype134, $_vtype135, $_size133);
                        for ($_i137 = 0; $_i137 < $_size133; ++$_i137) {
                            $key138                       = '';
                            $val139                       = '';
                            $xfer                         += $input->readString($key138);
                            $xfer                         += $input->readString($val139);
                            $this->configuration[$key138] = $val139;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->blockSize);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->bloomnFilterType);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->compressionType);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == TType::I16) {
                        $xfer += $input->readI16($this->dfsReplication);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 8:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->dataBlockEncoding);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 9:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->keepDeletedCells);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 10:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->maxVersions);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 11:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->minVersions);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 12:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->scope);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 13:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->timeToLive);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 14:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->blockCacheEnabled);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 15:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->cacheBloomsOnWrite);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 16:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->cacheDataOnWrite);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 17:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->cacheIndexesOnWrite);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 18:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->compressTags);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 19:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->evictBlocksOnClose);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 20:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->inMemory);
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
        $xfer += $output->writeStructBegin('TColumnFamilyDescriptor');
        if ($this->name !== null) {
            $xfer += $output->writeFieldBegin('name', TType::STRING, 1);
            $xfer += $output->writeString($this->name);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->attributes !== null) {
            if (!is_array($this->attributes)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('attributes', TType::MAP, 2);
            $output->writeMapBegin(TType::STRING, TType::STRING, count($this->attributes));
            foreach ($this->attributes as $kiter140 => $viter141) {
                $xfer += $output->writeString($kiter140);
                $xfer += $output->writeString($viter141);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->configuration !== null) {
            if (!is_array($this->configuration)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('configuration', TType::MAP, 3);
            $output->writeMapBegin(TType::STRING, TType::STRING, count($this->configuration));
            foreach ($this->configuration as $kiter142 => $viter143) {
                $xfer += $output->writeString($kiter142);
                $xfer += $output->writeString($viter143);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->blockSize !== null) {
            $xfer += $output->writeFieldBegin('blockSize', TType::I32, 4);
            $xfer += $output->writeI32($this->blockSize);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->bloomnFilterType !== null) {
            $xfer += $output->writeFieldBegin('bloomnFilterType', TType::I32, 5);
            $xfer += $output->writeI32($this->bloomnFilterType);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->compressionType !== null) {
            $xfer += $output->writeFieldBegin('compressionType', TType::I32, 6);
            $xfer += $output->writeI32($this->compressionType);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->dfsReplication !== null) {
            $xfer += $output->writeFieldBegin('dfsReplication', TType::I16, 7);
            $xfer += $output->writeI16($this->dfsReplication);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->dataBlockEncoding !== null) {
            $xfer += $output->writeFieldBegin('dataBlockEncoding', TType::I32, 8);
            $xfer += $output->writeI32($this->dataBlockEncoding);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->keepDeletedCells !== null) {
            $xfer += $output->writeFieldBegin('keepDeletedCells', TType::I32, 9);
            $xfer += $output->writeI32($this->keepDeletedCells);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->maxVersions !== null) {
            $xfer += $output->writeFieldBegin('maxVersions', TType::I32, 10);
            $xfer += $output->writeI32($this->maxVersions);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->minVersions !== null) {
            $xfer += $output->writeFieldBegin('minVersions', TType::I32, 11);
            $xfer += $output->writeI32($this->minVersions);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->scope !== null) {
            $xfer += $output->writeFieldBegin('scope', TType::I32, 12);
            $xfer += $output->writeI32($this->scope);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->timeToLive !== null) {
            $xfer += $output->writeFieldBegin('timeToLive', TType::I32, 13);
            $xfer += $output->writeI32($this->timeToLive);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->blockCacheEnabled !== null) {
            $xfer += $output->writeFieldBegin('blockCacheEnabled', TType::BOOL, 14);
            $xfer += $output->writeBool($this->blockCacheEnabled);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->cacheBloomsOnWrite !== null) {
            $xfer += $output->writeFieldBegin('cacheBloomsOnWrite', TType::BOOL, 15);
            $xfer += $output->writeBool($this->cacheBloomsOnWrite);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->cacheDataOnWrite !== null) {
            $xfer += $output->writeFieldBegin('cacheDataOnWrite', TType::BOOL, 16);
            $xfer += $output->writeBool($this->cacheDataOnWrite);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->cacheIndexesOnWrite !== null) {
            $xfer += $output->writeFieldBegin('cacheIndexesOnWrite', TType::BOOL, 17);
            $xfer += $output->writeBool($this->cacheIndexesOnWrite);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->compressTags !== null) {
            $xfer += $output->writeFieldBegin('compressTags', TType::BOOL, 18);
            $xfer += $output->writeBool($this->compressTags);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->evictBlocksOnClose !== null) {
            $xfer += $output->writeFieldBegin('evictBlocksOnClose', TType::BOOL, 19);
            $xfer += $output->writeBool($this->evictBlocksOnClose);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->inMemory !== null) {
            $xfer += $output->writeFieldBegin('inMemory', TType::BOOL, 20);
            $xfer += $output->writeBool($this->inMemory);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }

}