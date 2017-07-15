<?php

namespace mp091689;


include 'Db.php';
include 'SmsEntity.php';
include 'EntityManager.php';

/**
 * Class TurboSms
 * @package mp091689
 */
class TurboSms
{
    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * TurboSms constructor.
     * @param $db_host
     * @param $db_name
     * @param $db_user
     * @param $db_password
     */
    public function __construct($db_host, $db_name, $db_user, $db_password)
    {
        $db = Db::getInstance($db_host, $db_name, $db_user, $db_password);
        $this->em = new EntityManager($db, $db_user);
    }

    /**
     * @param $number
     * @param $message
     * @param string $sign
     * @param null $time
     * @param string $wappush
     * @param bool $is_flash
     * @return bool|SmsEntity
     */
    public function send($number, $message, $sign = 'Msg', $time = null, $wappush = '', $is_flash = false)
    {
        $sms = new SmsEntity();
        $sms->setNumber($this->handleNumber($number));
        $sms->setMessage($message);
        $sms->setSign($sign);
        $sms->setSendTime($time);
        $sms->setWappush($wappush);
        $sms->setIsFlash($is_flash);
        return $this->em->create($sms);
    }

    private function handleNumber($number)
    {
        return preg_replace("/[^0-9]/", '', $number);
    }

    /**
     * @param array $conditions
     * @param array $orderBy
     * @param null $limit
     * @param null $page
     * @return null|SmsEntity[]
     */
    public function find(array $conditions = [], array $orderBy = [], $limit = null, $page = null)
    {
        return $this->em->find($conditions, $orderBy, $limit, $page);
    }

    /**
     * @param $id
     * @return SmsEntity
     */
    public function findById($id)
    {
        $result = $this->em->find(['id' => $id]);
        return array_shift($result);
    }

    /**
     * @param SmsEntity $sms
     * @return bool
     */
    public function delete(SmsEntity $sms)
    {
        return $this->em->delete($sms);
    }
}