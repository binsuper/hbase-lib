<?php

require_once __DIR__ . '/../vendor/autoload.php';

use HBase\TTableDescriptor;
use HBase\TTableName;
use \Gino\EasyHBase\Filter;
use \Gino\EasyHBase\ScanQuery;

$a = [1];
$b = $a;
$b[] = 2;
var_dump($a, $b);

//print_r(diff_month_list(strtotime('2020-03-04'), strtotime('2020-08-02'), 'Ym'));

/*
$host = '192.168.1.60';
$port = 9090;
$socket = new \Thrift\Transport\TSocket($host, $port);
$transport = new \Thrift\Transport\TBufferedTransport($socket);
$protocol = new \Thrift\Protocol\TBinaryProtocol($transport);
$client = new \HBase\THBaseServiceClient($protocol);
$transport->open();


$scanId = $client->openScanner('test2', new \HBase\TScan());

$numRows = 100;
$resultList = [];
while (true) {
    $arr = $client->getScannerRows($scanId, $numRows);
    $resultList = array_merge($resultList, $arr);
    if (count($arr) < $numRows) {
        break;
    }
}
$client->closeScanner($scanId);

print_r($resultList);
*/

$conn = new \Gino\EasyHBase\Connection([
    'host'         => '192.168.1.60',
    'port'         => 9090,
    'auto_connect' => true
]);

//$conn->connect();
$tb = $conn->getHandler()->table('test');
//$result = $tb->put('r3', ['cf:age' => 16])
//             ->put('r3', ['cf:name' => 'huang1'])
//             ->put('r4', ['cf:age' => '22'])
//             ->put('r4', ['cf:name' => 'ren']);

$tb->put('r3', [
    'cf:name' => 'huang',
    'cf:age'  => [
        'value' => 18,
        'timestamp' => 1611648673 * 2 - time()
    ]
]);

//$tb->put('r3', [
//    'cf:age' => [
//        'value'     => 20,
//        'timestamp' => time2mills(strtotime('+10sec'))
//    ],
//    'cf:name' => 'huang2'
//], ['timestamp' => time2mills(strtotime('-10sec'))]);

var_dump($tb->get('r3'));

//$tb->put('r3', ['cf:age' => 17]);
//
//var_dump($tb->get('r3'));


//$result = $conn->getHandler()->gets('test', [
//    ['rowkey' => 'r1'],
//    ['rowkey' => 'r2'],
//]);
//$result = $conn->getHandler()->table('test')->get('r3');
//$result = $conn->getHandler()->table('test')->gets(['r1', 'r2']);
//$conn->getHandler()
//    ->table('test')
//               ->scan(\Gino\EasyHBase\ScanQuery::create()->betweenRow('r1', 'r3'), function ($data) {
//                        var_dump($data);
//                   });
//$result = $conn->getHandler()->tables('repo');


//$f = Filter::create()->multiCall('rowFilter', [['a', 'b', 'd'], [Filter::OP_EQ, Filter::OP_GE, Filter::OP_GT], Filter::COMPARE_BINARY]);
//$filter = Filter::create()->glueOr(function ($f){
//    $f->prefixRowkey(['r','b']);
//});
//var_dump($filter->toString());

//$filter = Filter::create()->prefixRowkey('2')->regexQualifier('');
//$result = $conn->getHandler()->table('test')
//               ->scanResult(ScanQuery::create()->filter($filter)->limit(100));

// $conn->getHandler()->deleteOne('test', 'r3');
// $conn->getHandler()->deleteRows('test', ['r3', 'r4']);
// $conn->getHandler()->deleteColumns('test', ['r3', 'r4'], ['cf:name', 'cf:age']);

//$filter = new Filter();

//$result = $filter->prefixRowkey('r')
//                 ->glueAnd(function (Filter $filter) {
//                     $filter->prefixRowkey('e')
//                            ->prefixRowkey('f');
//                 })
//                 ->glueOr(function (Filter $filter) {
//                     $filter->prefixRowkey('a')
//                            ->prefixRowkey('b')
//                            ->glueAnd(function (Filter $filter) {
//                                $filter->prefixRowkey('c');
//                                $filter->prefixRowkey('d');
//                            });
//                 })
//                 ->binaryQualifier(Filter::OP_GE, 'r')
//                 ->binaryPrefixQualifier(Filter::OP_LT, 'r')
//                 ->substringQualifier(Filter::OP_EQ, '2')
//                 ->regexQualifier(Filter::OP_NEQ, 'r')
//                 ->toString();

//print_r($result);


//$tdesc            = new TTableDescriptor();
//$tdesc->tableName = \Gino\EasyHBase\Convert::toTTable($conn->getHandler()->table('repo:user-event'));
//$tdesc->columns   = [new \HBase\TColumnFamilyDescriptor(['name' => 'cf'])];
//$conn->getHandler()->getClient()->createTable($tdesc, []);
//print_r($conn->getHandler()->table('repo:user-event')->describe());

//echo sprintf('%04x', 65536);

//$checksum  =  crc32 ( "The quick brown fox jumped over the lazy dog.1" );
//echo $checksum . PHP_EOL;
//printf ( "%u\n" ,  $checksum );

//$rowkey = '300000DV5f1996ef000001';
//$data = '{"cf:issue_company":"zs","cf:event":"device","cf:plt_app_no":"3","cf:plt_user_id":"6219946","cf:plt_channel_no":"10301201","cf:device_os":"android","cf:device_dpi":"2240\u00d71400","cf:device_id":"43e1891d-f1da-3bc7-8be4-3dc61ab90cb9","cf:device_model":"SCM-AL09","cf:network_ip":"49.81.175.236","cf:network_mac":"02:00:00:00:00:00","cf:record_time":1595512559}';
//$conn->getHandler()->table('repo:user-event')->put($rowkey, json_decode($data, true));
//var_dump($conn->getHandler()->table('repo:user-event')->getNs());

//$client = $conn->getHandler()->getClient();
////
////$tput = new \HBase\TPut();
////$tput->row = 'r1';
////$tput->columnValues = [new \HBase\TColumnValue(['family' => 'cf', 'qualifier' => 'issue_company', 'value' => 'zs'])];
////
////$client->put('repo:user-event', $tput);

//$result = $conn->getHandler()->table('repo:user-event')->get('300000DV5f1aa98f000001');
//
//print_r(json_encode($result, JSON_UNESCAPED_UNICODE));

