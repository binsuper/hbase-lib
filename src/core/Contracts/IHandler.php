<?php


namespace Gino\EasyHBase\Contracts;


use Gino\EasyHBase\Connection;
use HBase\THBaseServiceClient;

interface IHandler {

    public function __construct(Connection $client);

    /**
     * get client object
     *
     * @return THBaseServiceClient|null
     */
    public function getClient(): ?THBaseServiceClient;

}