<?php

$setting = include dirname(__DIR__).'/config/queue.php';

$conf = new RdKafka\Conf();
$conf->set('sasl.mechanisms', 'PLAIN');
$conf->set('api.version.request', 'true');
$conf->set('sasl.username', $setting['sasl_plain_username']);
$conf->set('sasl.password', $setting['sasl_plain_password']);
$conf->set('security.protocol', 'SASL_SSL');
$conf->set('ssl.ca.location', dirname(__DIR__) . '/cert/ca-cert');
$conf->set('message.send.max.retries', 5);

$producer = new RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);
$producer->addBrokers($setting['bootstrap_servers']);

$topic = $producer->newTopic($setting['topic_name']);

$topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode([
    'fromId' => 1,
    'message' => 'Hello Asuna',

]));

$topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode([
    'fromId' => 1,
    'message' => 'Hello Asuna2',

]));

$producer->poll(0);
while ($producer->getOutQLen() > 0) {
    $producer->poll(50);
}

echo "send succ" . PHP_EOL;