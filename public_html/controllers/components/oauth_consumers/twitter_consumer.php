<?php
// app/controllers/components/oauth_consumers/twitter_consumer.php

Configure::load('Snsapi.snsapi');

class TwitterConsumer extends AbstractConsumer {
    public function __construct() {
//        parent::__construct('YOUR_CONSUMER_KEY', 'YOUR_CONSUMER_SECRET');
//        parent::__construct('BB8Tzvgl8rS75L3WU9edw', 'zIuAg0eyC4yySCaDzmJKN5DmtodOb7VqphYmoj8LI0');
				parent::__construct(Configure::read('Snsapi.Twitter.key'), Configure::read('Snsapi.Twitter.secret'));

    }
}
?>