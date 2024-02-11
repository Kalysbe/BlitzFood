#!/bin/sh

cg=`links -dump http://www.kitconet.com/scripts/stocks/viewminingstockprecious.pl?id=10065 | sed -n '3p' | awk '{print $3}'`
echo $cg;
user="kseuser"
pass="kseuserpass"
db="kse"
sql="INSERT INTO cg (price) VALUES ('$cg')"
mysql -u "$user" -p"$pass"  <<EOF
  use $db;
  $sql;
EOF