#!/bin/sh
cd /var/www/www.kse.kg

wget -q -O ./index_last.csv http://192.168.0.25/xmls/index_last.csv
wget -q -O ./index_all.csv http://192.168.0.25/xmls/index_all.csv