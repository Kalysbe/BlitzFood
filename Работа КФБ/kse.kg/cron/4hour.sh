#!/bin/sh
cd /var/www/www.kse.kg/cron
#/usr/local/apache/php/bin/php update_indeces.php
#/usr/bin/php update_currency.php не работчий код
/usr/bin/php update_currency_new.php
/usr/bin/php update_index.php
