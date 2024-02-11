#!/bin/sh
user="kseuser"
pass="kseuserpass"
db="kse"
sql_1="SELECT date FROM gkv_3 ORDER BY date DESC LIMIT 1"
per_2=`awk -v date_mysql=sql_1 ' split(date_mysql,a,"-") {}; {print a[1]*65536+a[2]*256+a[3]}'`
per=`links -dump " http://www.nbkr.kg/index1.jsp?item=119&lang=RUS " | grep "|" | grep '.*|[0-9.]|*'| awk -F "|" '{print $2";"$3";"$4";"$5";"$6";"$7";"}' | sed 's/ //g' | awk -v per_3=per_2 ' split($1,a,".") {}; per_3 < a[1]+a[2]*256+a[3]*65536 {print $1}'`
echo "$per | sed -e 's/;//g'"
sql="INSERT INTO gkv_3 (date,ask,bid,min_percent,max_percent,average) VALUES ($per)"
mysql -u "$user" -p"$pass"  <<EOF
  use $db;
   $sql;
   $sql_1;
EOF