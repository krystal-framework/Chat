<?php

namespace Chat\Service;

use Krystal\Application\Model\AbstractService;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Date\TimeHelper;
use Chat\Storage\MySQL\MessageMapper;

final class MessageService extends AbstractService
{
    /**
     * Any compliant mapper
     * 
     * @var \Chat\Storage\MySQL\MessageMapper
     */
    private $messageMapper;

    /**
     * State initialization
     * 
     * @param \Chat\Storage\MySQL\MessageMapper $messageMapper     
     * @return void
     */
    public function __construct(MessageMapper $messageMapper)
    {
        $this->messageMapper = $messageMapper;
    }

    /**
     * Mark all messages as read
     * 
     * @param int $senderId An id of sender
     * @param int $receiverId An id of receiver
     * @return boolean
     */
    public function markAsRead($senderId, $receiverId)
    {
        return $this->messageMapper->markAsRead($senderId, $receiverId);
    }

    /**
     * Count amount of new messages
     * 
     * @param int $ownerId Profile id
     * @return int
     */
    public function countNew($ownerId)
    {
        return $this->messageMapper->countNew();
    }

    /**
     * Sends a message
     * 
     * @param int $senderId An id of sender
     * @param int $receiverId An id of receiver
     * @param string $message
     * @return boolean
     */
    public function sendMessage($senderId, $receiverId, $message)
    {
        $data = array(
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'datetime' => TimeHelper::getNow(),
            'read' => '0'
        );

        return $this->messageMapper->persist($data);
    }

    /**
     * Deletes a dialog between two users
     * 
     * @param int $senderId An id of sender
     * @param int $receiverId An id of receiver
     * @return boolean
     */
    public function deleteDialog($senderId, $receiverId)
    {
        return $this->messageMapper->deleteDialog($senderId, $receiverId);
    }

    /**
     * Fetch message receivers
     * 
     * @param int $senderId An id of sender
     * @return array
     */
    public function fetchReceivers($senderId)
    {
        return $this->messageMapper->fetchReceivers($senderId);
    }

    /**
     * Fetch a dialog of two users
     * 
     * @param int $senderId An id of sender
     * @param int $receiverId An id of receiver
     * @return array
     */
    public function fetchDialog($receiverId, $senderId)
    {
        return $this->messageMapper->fetchDialog($senderId, $receiverId);
    }
}
