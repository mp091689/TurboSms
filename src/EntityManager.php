<?php

namespace Mp091689\TurboSms;

use PDO;


/**
 * Class EntityManager
 * @package Mp091689\TurboSms
 */
class EntityManager
{
    /**
     * @var PDO $db
     */
    private $db;

    /**
     * @var
     */
    private $table;

    /**
     * EntityManager constructor.
     * @param PDO $db
     * @param $table
     */
    public function __construct(PDO $db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * @param SmsEntity $sms
     * @return bool|SmsEntity
     */
    public function create(SmsEntity $sms)
    {
        $name = $sms->getNumber();
        $sign = $sms->getSign();
        $message = $sms->getMessage();
        $wappush = $sms->getWappush();
        $is_flash = $sms->getisFlash() ? 1 : 0;
        $send_time = $sms->getSendTime();
        $stmt = $this->db->prepare("INSERT INTO $this->table (number, sign, message, wappush, is_flash, send_time) VALUES (:number, :sign, :message, :wappush, :is_flash, :send_time)");
        $stmt->bindParam(':number', $name);
        $stmt->bindParam(':sign', $sign);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':wappush', $wappush);
        $stmt->bindParam(':is_flash', $is_flash);
        $stmt->bindParam(':send_time', $send_time);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        if ($id) {
            return $this->findById($id);
        }
        return false;
    }

    /**
     * @param SmsEntity $sms
     * @return bool
     */
    public function delete(SmsEntity $sms)
    {
        $id = $sms->getId();
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
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
        $_conditions = '';
        if ($conditions) {
            $_conditions = $this->collectConditions($conditions);
        }
        $_orderBy = '';
        if ($orderBy) {
            $_orderBy = $this->collectOrderBy($orderBy);
        }
        $_limit = '';
        if ($limit) {
            $_limit = $this->collectLimit($limit);
        }

        $_offset = '';
        if ($limit && $page) {
            $_offset = $this->collectPage($page);
        }

        $sql = "SELECT * FROM " . $this->table . $_conditions . $_orderBy . $_limit . $_offset;
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'mp091689\TurboSms\SmsEntity');
        }
        return null;
    }

    /**
     * @param $id
     * @return null|SmsEntity
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = " . $id;
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            return $this->db->query($sql)->fetchObject('mp091689\TurboSms\SmsEntity');
        }
        return null;
    }

    /**
     * @param array $conditions
     * @return string
     */
    private function collectConditions(array $conditions)
    {
        $collection = [];
        foreach ($conditions as $key => $value) {
            $column = $key;
            $proviso = ' = ';
            $keyParts = explode(' ', $key);
            if (count($keyParts) >= 2) {
                $column = $keyParts[0];
                $proviso = $keyParts[1];
            }
            $collection[] = $column . ' ' . $proviso . " '" . $value . "'";
        }
        return ' WHERE ' . implode(' AND ', $collection);
    }

    /**
     * @param array $orderBy
     * @return string
     */
    private function collectOrderBy(array $orderBy)
    {
        $value = reset($orderBy);
        $key = key($orderBy);
        if (is_numeric($key)) {
            return ' ORDER BY ' . $value . ' ASC';
        }
        return ' ORDER BY ' . $key . ' ' . $value;
    }

    /**
     * @param $limit
     * @return string
     */
    private function collectLimit($limit)
    {
        return ' LIMIT ' . $limit;
    }

    /**
     * @param $page
     * @return string
     */
    private function collectPage($page)
    {
        if ($page > 1) {
            $factor = $page - 1;
            $offset = $page * $factor;
            return ' OFFSET ' . $offset;
        }
        return '';
    }
}