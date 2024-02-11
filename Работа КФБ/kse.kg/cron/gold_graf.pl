#!/usr/bin/perl -w
use Net::SMTP;
use DBI;
$database="kse";
$hostname="localhost";                               
$user="kseuser";          
$password='kseuserpass';

$dsn= "DBI:mysql:database=$database;host=$hostname";
$dbh = DBI->connect($dsn , $user, $password) || die print "Can't connect";

 system("mv gold_graf.xml gold_graf.xml.old");
 system("rm -f gold_graf.xml");

 $sql="select DATE_FORMAT((`cr_date`),'%d.%m.%Y') AS `cr_date`, `bid`, `ask` from `Blog_Entries_eng` where name='gold' order by cr_date ASC LIMIT 7";

 {open( FILE, ">gold_graf.xml" ) or die( "Could not open log.txt: $!" );

 print FILE "<graph bgcolor='000000' canvasBgColor='000000' baseFontColor='8B8B00' caption='' subcaption=''
hovercapbg='F47E00' divlinecolor='696969' hovercapborder='F47E00' formatNumberScale='3' decimalPrecision='2' showvalues='0' baseFontSize='15' decimalSeparator=',' 
numdivlines='10' numVdivlines='0' yaxisminvalue='1300' yaxismaxvalue='1700'  rotateNames='1' showLimits='1' showShadow='0' showAnchors='0'>\n<categories>\n";

    my $sth = $dbh->prepare($sql);
    $sth->execute();
    my @row;
    while (@row = $sth->fetchrow_array())
    {
        print FILE "  <category name='$row[0]'/>\n";
    }  
    print FILE "</categories>\n<dataset seriesName='BID' color='ffff00' anchorBorderColor='ffff00' anchorBgColor='ffff00'>\n";

    $sth->execute();
    my @row1;
    while (@row1 = $sth->fetchrow_array())
    {
      $mystr="  <set value='$row1[1]'/>\n";
      $mystr=~ s/,/./;
      print FILE $mystr;     
    }
	print FILE "</dataset>";
	
	print FILE "\n<dataset seriesName='ASK' color='ff0000' anchorBorderColor='ffff00' anchorBgColor='ffff00'>\n";

    $sth->execute();
    while (@row1 = $sth->fetchrow_array())
    {
      $mystr="  <set value='$row1[2]'/>\n";
      $mystr=~ s/,/./;
      print FILE $mystr;     
    }

    print FILE "</dataset>\n</graph>"; 

  close(FILE)};

  system("rm -f //var/www/www.kse.kg/monitor/data_for_chart/gold_graf.xml");
  system("cp /var/www/www.kse.kg/cron/gold_graf.xml /var/www/www.kse.kg/monitor/data_for_chart/gold_graf.xml");