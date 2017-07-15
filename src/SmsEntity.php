<?php

namespace mp091689;

/**
 * Class SmsEntity
 * @package mp091689
 */
class SmsEntity
{
    /**
     * id integer
     * Чтение
     * Автоинкрементное поле, хранит ID сообщения для быстрого поиска
     */
    private $id;

    /**
     * msg_id string (36)
     * Чтение
     * ID сообщения в системе. По данному ID Вы можете узнавать статус доставки
     */
    private $msg_id;

    /**
     * number string (21)
     * Полный
     * Номер получателя, задаётся в международном формате, только цифры
     */
    private $number;

    /**
     * sign string (11)
     * Полный
     * Альфаимя (подпись отправителя)
     */
    private $sign;

    /**
     * message string (1530)
     * Полный
     * Текст сообщения
     */
    private $message;

    /**
     * wappush string (128)
     * Полный
     * Ссылка WapPush, включая http://
     */
    private $wappush;

    /**
     * is_flash bool
     * Полный
     * Флаг flash сообщения (1 - да, 0 - нет)
     */
    private $is_flash;

    /**
     * cost decimal(4,2)
     * Чтение
     * Стоимость сообщения в кредитах системы
     */
    private $cost;

    /**
     * balance decimal(10,2)
     * Чтение
     * Остаток кредитов на балансе пользователя после обработки
     */
    private $balance;

    /**
     * added timestamp
     * Чтение
     * Дата и время добавления записи в таблицу
     * ГГГГ-ММ-ДД ЧЧ:ММ, учитывается установленный часовой пояс соединения
     */
    private $added;

    /**
     * send_time timestamp
     * Полный
     * Дата и время запланированной отправки сообщения
     * ГГГГ-ММ-ДД ЧЧ:ММ, учитывается установленный часовой пояс соединения
     */
    private $send_time;

    /**
     * sended timestamp
     * Чтение
     * Дата и время фактической отправки сообщения
     * ГГГГ-ММ-ДД ЧЧ:ММ, учитывается установленный часовой пояс соединения
     */
    private $sended;

    /**
     * received timestamp
     * Чтение
     * Дата и время обновления статуса
     * ГГГГ-ММ-ДД ЧЧ:ММ, учитывается установленный часовой пояс соединения
     */
    private $received;

    /**
     * error_code string (3)
     * Чтение
     * Код ошибки при обработке
     */
    private $error_code;

    /**
     * status string
     * Чтение
     * Статус доставки по спецификации протокола SMPP v3.4
     */
    private $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMsgId()
    {
        return $this->msg_id;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getWappush()
    {
        return $this->wappush;
    }

    /**
     * @return mixed
     */
    public function getisFlash()
    {
        return $this->is_flash;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return mixed
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @return mixed
     */
    public function getSendTime()
    {
        return $this->send_time;
    }

    /**
     * @return mixed
     */
    public function getSended()
    {
        return $this->sended;
    }

    /**
     * @return mixed
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $wappush
     */
    public function setWappush($wappush)
    {
        $this->wappush = $wappush;
    }

    /**
     * @param mixed $is_flash
     */
    public function setIsFlash($is_flash)
    {
        $this->is_flash = $is_flash;
    }

    /**
     * @param mixed $send_time
     */
    public function setSendTime($send_time)
    {
        $this->send_time = $send_time;
    }
}