<?php

/**
 * hbase connection class
 */

namespace Gino\EasyHBase;

use Gino\EasyHBase\Contracts\IHandler;
use HBase\THBaseServiceClient;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Protocol\TCompactProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;

/**
 * Class Connection
 *
 * @package Gino\EasyHBase
 */
class Connection {

    /**
     * @var array
     */
    protected $_config = [];

    /**
     * debug mode
     * if debug is true, it will call the debug_handler function when error
     *
     * @var bool
     */
    protected $_debug = false;

    /**
     * @var TSocket
     */
    protected $_socket = null;

    /**
     * @var TBufferedTransport|TFramedTransport
     */
    protected $_transport = null;

    /**
     * @var TBinaryProtocolAccelerated|TBinaryProtocol|TCompactProtocol
     */
    protected $_protocol = null;

    /**
     * @var Handler
     */
    protected $_handler = null;


    public function __construct(array $config) {
        $this->_initConfig($config);

        $this->debug($this->_config['debug']);

        if ($this->_config['auto_connect']) {
            $this->connect();
        }
    }

    public function __destruct() {
        $this->close();
    }

    /**
     * init config data
     *
     * @param array $config
     */
    protected function _initConfig(array $config) {
        $this->_config = array_merge([
            'host'          => 'localhost',
            'port'          => '9090',
            'persist'       => false,       // 长连接
            'auto_connect'  => false,       // 自动连接
            'debug'         => false,       // debug mode
            'debug_handler' => null,        // Function to call for error logging in debug mode
            'send_timeout'  => 10000,      // the send timeout in milliseconds
            'recv_timeout'  => 10000,      // the receive timeout in milliseconds
            'transport'     => TBufferedTransport::class,
            'protocol'      => TBinaryProtocol::class,
            'handler'       => Handler::class
        ], $config);

        if (!class_exists($this->_config['transport'])) {
            throw new \InvalidArgumentException(sprintf('invalid transport class "%s"', $this->_config['transport']));
        }

        if (!class_exists($this->_config['protocol'])) {
            throw new \InvalidArgumentException(sprintf('invalid protocol class "%s"', $this->_config['protocol']));
        }

        if (!class_exists($this->_config['handler']) || !in_array(IHandler::class, class_implements($this->_config['handler']))) {
            throw new \InvalidArgumentException(sprintf('invalid handler class "%s"', $this->_config['handler']));
        }
    }

    /**
     * open a connection with hbase
     */
    public function connect() {

        // create socket object
        if (is_array($this->_config['host'])) {
            $this->_socket = new TSocketPool($this->_config['host'], $this->_config['port'], $this->_config['persist'], $this->_config['debug_handler']);
        } else {
            $this->_socket = new TSocket($this->_config['host'], $this->_config['port'], $this->_config['persist'], $this->_config['debug_handler']);
        }

        $this->_socket->setSendTimeout($this->_config['send_timeout']);
        $this->_socket->setRecvTimeout($this->_config['recv_timeout']);

        // create transport object
        switch ($this->_config['transport']) {
            case TBufferedTransport::class:
                $this->_transport = new TBufferedTransport($this->_socket);
                break;
            case TFramedTransport::class:
                $this->_transport = new TFramedTransport($this->_socket);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('unsupported transport class "%s"', $this->_config['transport']));
        }

        // create protocol object
        switch ($this->_config['protocol']) {
            case TBinaryProtocol::class:
                $this->_protocol = new TBinaryProtocol($this->_transport);
                break;
            case TBinaryProtocolAccelerated::class:
                $this->_protocol = new TBinaryProtocolAccelerated($this->_transport);
                break;
            case TCompactProtocol::class:
                $this->_protocol = new TCompactProtocol($this->_transport);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('unsupported protocol class "%s"', $this->_config['protocol']));
        }

        // client
        $this->setHandler(new $this->_config['handler']($this));

        // socket is open
        if ($this->_transport->isOpen()) {
            return;
        }

        try {
            $this->_transport->open();
        } catch (\Exception $ex) {
            $this->_transport->close();
            throw new \RuntimeException("can\'t connect to hbase", 0, $ex);
        }

    }

    /**
     * 检测连接是否正常
     *
     * @return bool
     */
    public function isConnected(): bool {
        return !empty($this->_transport) && $this->_transport->isOpen();
    }

    /**
     * 重连
     *
     * @throws \Thrift\Exception\TTransportException
     */
    public function reconnect() {
        if ($this->isConnected()) {
            return;
        }
        $this->_transport->open();
    }

    /**
     * close connection
     */
    public function close() {
        if ($this->_transport === null || !$this->_transport->isOpen()) {
            return;
        }
        $this->_transport->close();
        $this->_transport = null;
    }

    /**
     * get the config array
     *
     * @return array
     */
    public function getConfig(): array {
        return $this->_config;
    }

    /**
     * set debug mode before connect
     *
     * @param bool $state
     *
     * @return $this
     */
    public function debug(bool $state) {
        $this->_debug = $state;
        return $this;
    }

    /**
     * @param IHandler $handler
     *
     * @return $this
     */
    public function setHandler(IHandler $handler) {
        $this->_handler = $handler;
        return $this;
    }

    /**
     * @return Handler|null
     */
    public function getHandler(): ?Handler {
        return $this->_handler;
    }

    /**
     * @return TBufferedTransport|TFramedTransport
     */
    public function getTransport() {
        return $this->_transport;
    }

    /**
     * @return TBinaryProtocol|TBinaryProtocolAccelerated|TCompactProtocol
     */
    public function getProtocol() {
        return $this->_protocol;
    }

}