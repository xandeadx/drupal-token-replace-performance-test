<?php

use Drupal\Component\Utility\Timer;
use Drupal\node\Entity\Node;

$template = 'site name "[site:name]", current year "[current-date:custom:Y]", node label "[node:title]"';
$token_service = \Drupal::token();
$site_config = \Drupal::config('system.site');
$node = Node::create(['type' => 'page', 'title' => 'Test node']);

// Static cache warm up
echo 'strtr result: ' . strtr($template, [
  '[site:name]' => $site_config->get('name'),
  '[current-date:custom:Y]' => date('Y'),
  '[node:title]' => $node->label(),
]) . PHP_EOL;
echo 'token result: ' . $token_service->replace($template, ['node' => $node]) . PHP_EOL;

// strtr
Timer::start('strtr');
for ($i = 0; $i < 1000; $i++) {
  strtr($template . ' ' . $i, [
    '[site:name]' => $site_config->get('name'),
    '[current-date:custom:Y]' => date('Y'),
    '[node:title]' => $node->label(),
  ]);
}
echo 'strtr time: ' . Timer::read('strtr') . ' ms' . PHP_EOL;

// token
Timer::start('token');
for ($i = 0; $i < 1000; $i++) {
  $token_service->replace($template . ' ' . $i, ['node' => $node]);
}
echo 'token time: ' . Timer::read('token') . ' ms' . PHP_EOL;
