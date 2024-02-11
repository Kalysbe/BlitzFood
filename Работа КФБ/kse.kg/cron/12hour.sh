#!/bin/sh
cd /var/www/www.kse.kg/cron
/usr/bin/php listing_update.php
/usr/bin/php update_index.php
/usr/bin/php new_index_update.php
/usr/bin/php import_last_rating.php
#/usr/local/apache/php/bin/php tradestat_update.php
#/usr/local/apache/php/bin/php import_full_rating.php
