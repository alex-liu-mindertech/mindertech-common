<?php
/**
 * Created by PhpStorm.
 * User: alex.liu (alex.liu@mindertech.co.uk)
 * Date: 2020/7/1
 * Date: 19:34
 */

namespace MinderTech\Queue\Activemq;


class SendHelper
{
    /**
     * @param $destination
     * @param $body
     */
    public static function send($destination, $body)
    {
        $client = new Stomp\Client(config('activemq.broker_uri'));
        $client->setLogin(config('activemq.username'), config('activemq.password'));

        $stomp = new Stomp\StatefulStomp($client);
        $stomp->begin();

        $stomp->send('/queue/' . $destination, new Stomp\Transport\Message(json_encode($body), array('persistent' => 'true'))); //持久化消息内容

        $stomp->commit();

        $client->disconnect();
    }
}
