# What is TextMagic? #

TextMagic's application programming interface (API) provides the communication link
between your application and TextMagic’s SMS Gateway, allowing you to send and receive text messages
and to check the delivery status of text messages you’ve already sent.

http://api.textmagic.com/en

All these commands can be executed only if you provide a valid username and API password [get it here](https://www.textmagic.com/app/wt/account/api/cmd/password) in your requests.

# Requirements #

* CodeIgniter 2.1.0+
* PHP 5.2.0+
* PHP extension: openssl, pcre, json, curl

# Usage #

## Install From getSparks ##

Please visit URL: http://getsparks.org/packages/TextMagic-SMS-API/show

    // install from getSparks website
    $ php tools/spark install -v1.0.1 TextMagic-SMS-API
    // include TextMagic Library to controller
    $this->load->spark('TextMagic-SMS-API/1.0.1');

### Send API ###

    // set message text
    $text = 'Hi, I am appleboy';
    // phone number can be string or array.
    $phone = array('xxxxxxx', 'xxxxxxx');
    $response = $this->textmagic->send($text, $phone);
    print_r($response);

### Account API ###

    $response = $this->textmagic->get_balance();
    print_r($response);

### Message Status API ###

    $ids = array('xxxxxxx', 'xxxxxxx');
    $response = $this->textmagic->get_message_status($ids);
    print_r($response);

### Receive API ###

    $ids = 'xxxxxxx';
    $response = $this->textmagic->receive($ids);
    print_r($response);

### Delete reply API ###

    $ids = array('xxxxxxx', 'xxxxxxx');
    $response = $this->textmagic->delete_reply($ids);
    print_r($response);

### Check number API ###

    $phones = array('xxxxxxx', 'xxxxxxx');
    $response = $this->textmagic->check_number($phones);
    print_r($response);

# Change Log #

Please vist [API documentation](http://api.textmagic.com/en) first

Date: 2012-05-01 (Developer API)

* Send API
* Account API
* Message Status API
* Receive API
* Delete reply API
* Check number API

License
=======================

http://www.opensource.org/licenses/bsd-license.php New BSD license

Copyright (C) 2012 Bo-Yi Wu ( appleboy AT gmail.com )

