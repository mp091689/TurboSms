#Installation

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require mp091689/turbosms
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#Usage
Create new instance of TurboSms lib
to send sms, check status, receive list, delete scheduled sms.
TurboSms server is `94.249.146.189`, database `users`, the table name same as
login of gateway connection.
```
new \mp091689\TurboSms\TurboSms($host, $db_name, $user, $password);
```
##Sending

Send sms to specified number with specified text.
```
send(string $number, string $message, string $sign = 'Msg', timestamp $time = null, string $wappush = '', boolean $is_flash = false);
```
Returns an object that contains params of sent message.

######Arguments

**number** - string, contains phone number in international format
 only digits _(38050123456789)_.

**message** - string, the text of sent message.
[Read the rules of composing messages](https://turbosms.ua/guide.html).

**sign** - string, alpha-name must be registered on the service.

**time** - timestamp, the sms will be sent at the set time.
The datetime format 'YYYY-MM-DD HH:MM'.

**wappush** - string, link WapPush, including http://

**is_flash** - boolean, flash flag of the message

######Response

Returns an object with the parameters of the sent message.

```
object(mp091689\TurboSms\SmsEntity)
  private 'id' => string '856' (length=3)
  private 'msg_id' => null
  private 'number' => string '380501234567' (length=12)
  private 'sign' => string 'Msg' (length=3)
  private 'message' => string 'Hello world!' (length=12)
  private 'wappush' => string '' (length=0)
  private 'is_flash' => string '0' (length=1)
  private 'cost' => null
  private 'balance' => null
  private 'added' => string '2017-07-14 18:42:50' (length=19)
  private 'send_time' => string '2017-07-14 18:45' (length=19)
  private 'sended' => null
  private 'received' => null
  private 'error_code' => null
  private 'status' => null
```
* The fields are populated by the server after the message is processed.
If NULL is specified in the field values, then processing has not yet been performed.

* Some phone models do not support wappush and flash messages.

* Date format for all datetime fields: YYYY-MM-DD HH:MM,
 the time zone based on connection.

######Examples
```
// Create new TurboSms instance
$turbo = new \mp091689\TurboSms\TurboSms('94.249.146.189', 'users', '<LOGIN>', '<PASSWORD>');

// Send sms
$result = $turbo->send('380507095075', 'Hello world!');

// Send sms with specified alpha-name
$result = $turbo->send('380507095075', 'Hello world!', 'Msg');

// Send sms at set time
$result = $turbo->send('380507095075', 'Hello world!', 'Msg', '2017-07-14 18:50');
```

##Retrieving data

###Find one instance of sms by id.

```
findById(integer $id)
```
Returns an object of sms.

######Arguments

**id** - integer, identifier of wanted instance.

######Response

```
object(mp091689\TurboSms\SmsEntity)
  private 'id' => string '1' (length=2)
  private 'msg_id' => string '499514b3-56c7-e1f4-5159-e607425c776c' (length=36)
  private 'number' => string '380501234567' (length=12)
  private 'sign' => string 'Msg' (length=10)
  private 'message' => string 'Hello World!' (length=12)
  private 'wappush' => string '' (length=0)
  private 'is_flash' => string '0' (length=1)
  private 'cost' => string '1.00' (length=4)
  private 'balance' => string '139.00' (length=6)
  private 'added' => string '2017-07-14 20:50:08' (length=19)
  private 'send_time' => null
  private 'sended' => string '2016-02-19 20:56:09' (length=19)
  private 'received' => string '2016-02-19 20:56:15' (length=19)
  private 'error_code' => string '0' (length=1)
  private 'status' => string 'DELIVRD' (length=7)
```

######Examples

```
// Create new TurboSms instance
$turbo = new \mp091689\TurboSms\TurboSms('94.249.146.189', 'users', '<LOGIN>', '<PASSWORD>');

// Find sms by id
$result = $turbo->find(1);
```

###Find list of sms by conditions.

```
find(array $conditions = [], array $orderBy = [], integer $limit = null, integer $page = null)
```
Returns an array of an objects.

######Arguments

**conditions** - array, the associative array `$key => $value`
where the `$key` is equals to column name in the table
and `$value` is wanted string.

**orderBy** - array, the associative array `$key => $value`
where the `$key` is equals to column name in the table for ordering
and `$value` is method of ordering `ASC/DESC`.

**limit** - integer, limit the number of records returned based on a limit value.

**page** - integer, for pagination, works only if limit is specified.

######Response

```
[
  ...,
  object(mp091689\TurboSms\SmsEntity),
  ...
]
```

######Examples

```php
<?php

// Create new TurboSms instance
$turbo = new \mp091689\TurboSms\TurboSms('94.249.146.189', 'users', '<LOGIN>', '<PASSWORD>');

// Find all sms
$results = $turbo->find();

// Find list of sms by phone number
$results = $turbo->find(['number' => '380501234567']);

// Find list of sms that were set to specified operator code
$results = $turbo->find(['number LIKE' => '38050%']);

// Find list of sms by phone number and not delivered
$results = $turbo->find(['number' => '380501234567', 'status !=' => 'DELIVRD']);

// Find list of sms by phone number and orderBy error_code
$results = $turbo->find(['number' => '380501234567'], ['error_code']);
// or
$results = $turbo->find(['number' => '380501234567'], ['error_code' => 'DESC']);

// Find list of sms by phone number without ordering
// and set limit to 5 records
$results = $turbo->find(['number' => '380501234567'], [], 5);

// Find list of sms by phone number without ordering
// and set limit to 5 records and set third page
$results = $turbo->find(['number' => '380501234567'], [], 5, 3);
```

##Deleting

```
delete(object $sms)
```
If for some reason you do not want to send a scheduled SMS you can simply delete it.

######Arguments

**sms** - object, instance of SmsEntity.

######Response

`true` - success, `false` - failed

######Examples

```php
<?php

// Create new TurboSms instance
$turbo = new \mp091689\TurboSms\TurboSms('94.249.146.189', 'users', '<LOGIN>', '<PASSWORD>');

// First we need to get the sms
$sms = $turbo->findById(1);

// Now we can delete sms
$result = $turbo->delete($sms);
```

##DESCRIPTION OF STATUS FIELD VALUES
status | description
--- | --- 
NULL | Message not yet processed
ACCEPTD | Message accepted for processing
ENROUTE | Message sent to mobile network
DELIVRD | Message delivered to recipient
EXPIRED | Message expired
DELETED | Removed by operator
UNDELIV | Not delivered
REJECTD | Message rejected
UNKNOWN | Unknown status

##DESCRIPTION OF ERROR_CODE FIELD VALUES

error_code | description
--- | ---
0 | No errors
2 | Failed to save data, contact support if error persists
23 | Errors in the recipient's number
34 | Country of the recipient is not supported, additional activation is required
36 | Failed to send the message, contact the support department if the error is repeated
40 | There is not enough credit on the balance sheet
46 | Number of recipient in the stop-list
69 | Alpha-name (sender's signature) is prohibited by the administrator
83 | Duplicate messages
84 | Missing message text
85 | Invalid alpha-name (sender's signature)
86 | The text of the message contains forbidden words
87 | Message text is too long
88 | Your account is blocked for violations, contact the support department
999 | Specific error of a particular operator, it is necessary to specify more

#Additional information

* Description of work with the TURBOSMS gateway using SQL connection [link](https://turbosms.ua/sql.html)

RULES OF BROADCASTING:
* [Rules of using the service](https://turbosms.ua/guide.html#1)
* [Requirements for the contents of SMS](https://turbosms.ua/guide.html#2)
* [SMS message length](https://turbosms.ua/guide.html#3)
* [Rules for adding a sender's signature](https://turbosms.ua/guide.html#4)

