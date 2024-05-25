<?php
require './library/Pusher/vendor/autoload.php';

$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    '6cb0dc56f5ed27c15171',
    'c460faf87f477aad2e0a',
    '1808591',
    $options
);

try {
    $pusher->trigger('test_channel', 'test-connection', array('message' => 'hello world'));
} catch (Pusher\PusherException $e) {
    view('errors.500');
    exit;
}