<?php

use Drupal\Component\Utility\Timer;
use Drupal\node\Entity\Node;

$template1 = '[current-date:custom:Y]';
$template2 = '[node:title]';
$token_service = \Drupal::token();
$node = Node::create(['type' => 'page', 'title' => 'Test node']);

// Static cache warm up
echo 'template1 result: ' . $token_service->replace($template1, ['node' => $node]) . PHP_EOL;
echo 'template2 result: ' . $token_service->replace($template2, ['node' => $node]) . PHP_EOL;

// Test [current-date:custom:Y]
Timer::start('template1');
for ($i = 0; $i < 1000; $i++) {
  $token_service->replace($template1 . ' ' . $i, ['node' => $node]);
}
echo '[current-date:custom:Y] time: ' . Timer::read('template1') . ' ms' . PHP_EOL;

// Test [node:title]
Timer::start('template2');
for ($i = 0; $i < 1000; $i++) {
  $token_service->replace($template2 . ' ' . $i, ['node' => $node]);
}
echo '[node:title] time: ' . Timer::read('template2') . ' ms' . PHP_EOL;
