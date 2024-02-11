#!/bin/sh
cd /var/www/www.kse.kg/cron
/usr/bin/php TradeArchive.php
/usr/bin/php tradestat_update.php
#/usr/bin/php new_index_update.php
