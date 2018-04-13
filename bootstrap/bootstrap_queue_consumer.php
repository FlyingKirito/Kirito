<?php

$setting = include dirname(__DIR__).'/config/queue.php';

$conf = new RdKafka\Conf();
$conf->set('sasl.mechanisms', 'PLAIN');
$conf->set('api.version.request', 'true');
$conf->set('sasl.username', $setting['sasl_plain_username']);
$conf->set('sasl.password', $setting['sasl_plain_password']);
$conf->set('security.protocol', 'SASL_SSL');
$conf->set('ssl.ca.location', dirname(__DIR__) . '/cert/ca-cert');
$conf->set('group.id', $setting['consumer_id']);
$conf->set('metadata.broker.list', $setting['bootstrap_servers']);

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.offset.reset', 'smallest');

$conf->setDefaultTopicConf($topicConf);

$consumer = new RdKafka\KafkaConsumer($conf);
$consumer->subscribe([$setting['topic_name']]);

echo "Waiting for partition assignment... (make take some time when\n";
echo "quickly re-joining the group after leaving it.)\n";

$kernel = include dirname(__DIR__).'/bootstrap/bootstrap_web.php';

$messageService = $kernel->service('MessageService');
while (true) {
    $message = $consumer->consume(120 * 1000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
//            var_dump($message->payload);
//            $messageService->{sprintf('%sTopic', $message->topic_name)}(json_decode($message->payload, true));
            echo 'topic_name: '; var_dump($message->topic_name);
            echo 'partition: ';var_dump($message->partition);
            echo 'payload: ';var_dump($message->payload);
            echo 'key: ';var_dump($message->key);
            echo 'offset: ';var_dump($message->offset);
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), 'error: ' . $message->err);
            break;
    }
}
