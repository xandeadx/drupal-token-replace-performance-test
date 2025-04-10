<?php

use Drupal\Component\Utility\Timer;
use Drupal\node\Entity\Node;

$template = "site name '{{ site.get('name') }}', current year '{{ 'now'|date('Y') }}', node label '{{ node.label }}'";
$site_config = \Drupal::config('system.site');
$node = Node::create(['type' => 'page', 'title' => 'Test node']);
$renderer = \Drupal::service('renderer');

// Static cache warm up
$build = [
  '#type' => 'inline_template',
  '#template' => $template,
  '#context' => [
    'site' => $site_config,
    'node' => $node,
  ],
];
echo 'inline_template result: ' . $renderer->renderRoot($build) . PHP_EOL;

// Test
Timer::start('inline_template');
for ($i = 0; $i < 1000; $i++) {
  $build = [
    '#type' => 'inline_template',
    '#template' => $template . ' ' . $i,
    '#context' => [
      'site' => $site_config,
      'node' => $node,
    ],
  ];
  $renderer->renderRoot($build) . PHP_EOL;
}
echo 'inline_template time: ' . Timer::read('inline_template') . ' ms' . PHP_EOL;
