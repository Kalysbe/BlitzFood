#!/bin/sh

user="kseuser";
pass="kseuserpass";
db="kse";

for (( i=1; $i<4; i=$i+1 ));
do
  echo $i;
  max_base_date=`echo "select distinct dayofmonth(date) + (month(date)*256) + (year(date)*65536) from gkv_3 where date=(select max(date) from gkv_3) and type=$i;" | mysql -ukseuser -pkseuserpass -Dkse | sed '/date/d'`;

  res_nbkr_site=`links -dump "http://www.nbkr.kg/index1.jsp?item=119&lang=RUS&period_id=$i" | grep "|" | grep '.*|[0-9.]|*'| awk -F "|" '{print $2";"$3";"$4";"$5";"$6";"$7}' | sed 's/ //g' | awk -v pDate=$max_base_date ' split($1,a,".") {}; pDate < a[1]+a[2]*256+a[3]*65536 {print $1}'`;

echo $res_nbkr_site;
  for item in $res_nbkr_site; do
    cur_row=`echo $item |sed -e 's/;/,/g'| sed "s/^/STR_TO_DATE(\'/g" | sed "s/,/\',\'\%d.\%m.\%Y\'),/" | sed "s/-/0/g"`;
    echo "INSERT INTO gkv_3 (date,ask,bid,min_percent,max_percent,average, type) VALUES ($cur_row, $i);" | mysql -ukseuser -pkseuserpass -Dkse; 
    done;
done;