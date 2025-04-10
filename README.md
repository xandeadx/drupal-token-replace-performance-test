1. Clone this repo to `snippets` subfolder on your Drupal installation:

```bash
git clone https://github.com/xandeadx/drupal-token-replace-performance-test.git snippets
```

2. Run tests:

```bash
vendor/bin/drush php:script snippets/token-performance-test.php
vendor/bin/drush php:script snippets/current-date-performance-test.php
vendor/bin/drush php:script snippets/inline-template-performance-test.php
```
