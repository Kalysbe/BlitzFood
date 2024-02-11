#!/bin/sh
cp /home/monitor/for_chart/*.xml /var/www/www.kse.kg/monitor/data_for_chart/

cd /var/www/www.kse.kg/cron
/usr/bin/php quotes_update.php
