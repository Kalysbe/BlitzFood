#!/bin/sh
cd /var/www/www.kse.kg/cron
/usr/bin/php trade_last.php
/usr/bin/php tradestat_update.php
