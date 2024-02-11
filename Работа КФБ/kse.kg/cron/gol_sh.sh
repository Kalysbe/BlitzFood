#!/bin/sh

rrr=`links -dump http://www.forexpf.ru/_informer_/comod.php?id=017864523 | sed -e 's/ if(flg==1){//g' |sed -e 's/;/;\n/g' | grep document.getElementById | sed -e 's/document.getElementById("//g' | sed -e 's/").innerHTML//g' | sed -e 's/  //g'  | sed -e 's/"//g'| sed -e 's/;//g' | awk -F '=' '{ printf("%s-%s;",$1,$2)}'`;
echo $rrr;
cgoldb=`expr match $rrr "cgoldb-\([0-9\.]*\);*"`;
cgolda=`expr match $rrr ".*;cgolda-\([0-9\.]*\);*"`;
cbrentb=`expr match $rrr ".*;cbrentb-\([0-9\.]*\);*"`;
cbrenta=`expr match $rrr ".*;cbrenta-\([0-9\.]*\);*"`;
clightb=`expr match $rrr ".*;clightb-\([0-9\.]*\);*"`;
clighta=`expr match $rrr ".*;clighta-\([0-9\.]*\);*"`;

user="kseuser"
pass="kseuserpass"
db="kse"

sql2="INSERT INTO Blog_Entries_eng (name,bid,ask) VALUES ('Brent','$cbrentb','$cbrenta')"
sql3="INSERT INTO Blog_Entries_eng (name,bid,ask) VALUES ('Light','$clightb','$clighta')"
sql="INSERT INTO Blog_Entries_eng (name,bid,ask) VALUES ('Gold','$cgoldb','$cgolda')"
mysql -u "$user" -p"$pass"  <<EOF
  use $db;
 
  $sql2;
  $sql3;
   $sql;
EOF