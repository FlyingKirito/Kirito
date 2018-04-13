<?php

namespace Kirito\Service\Implement;

use Kirito\Service\MessageService;

class MessageServiceImpl extends BaseServiceImpl implements MessageService
{
    public function kiritoTopic($message)
    {
        $message = $this->validTopicMessage($message);
        $this->getChatMessageDao()->create($message);
    }

    private function validTopicMessage($message)
    {
        //TODO 完成验证类
//        $this->getValidator()->validate($message, [
//
//        ]);

        return $message;
    }

    private function getChatMessageDao()
    {
        return $this->kernel->dao('ChatMessageDao');
    }
}