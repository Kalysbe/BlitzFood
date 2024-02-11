#!/usr/bin/perl -w
use Net::SMTP;
use DBI;
$database="kse";
$hostname="localhost";                               
$user="kseuser";          
$password='kseuserpass';

$dsn= "DBI:mysql:database=$database;host=$hostname";
$dbh = DBI->connect($dsn , $user, $password) || die print "Can't connect";

 system("mv not_graf.xml not_graf.xml.old");
 system("rm -f not_graf.xml");

 $sql="select date, average from nbkr_not where type='3' and average >'0' order by date ASC";
 $sql_1="select date, average from nbkr_not where type='5' and average >'0' order by date ASC";
 $sql_2="select date, average from nbkr_not where type='4' and average >'0' order by date ASC";

 {open( FILE, ">not_graf.xml" ) or die( "Could not open log.txt: $!" );

 print FILE "<graph bgcolor='000000' canvasBgColor='000000' baseFontColor='8B8B00' caption='' subcaption=''
hovercapbg='F47E00' divlinecolor='696969' hovercapborder='F47E00' formatNumberScale='3' decimalPrecision='2' showvalues='0' baseFontSize='15' decimalSeparator=',' 
numdivlines='10' numVdivlines='0' yaxisminvalue='1' yaxismaxvalue='20'  rotateNames='1' showLimits='1' showShadow='0' showAnchors='0'>\n<categories>\n";

    my $sth = $dbh->prepare($sql);
	my $sth_1 = $dbh->prepare($sql_1);
	my $sth_2 = $dbh->prepare($sql_2);
    $sth->execute();
    my @row;
    while (@row = $sth->fetchrow_array())
    {
        print FILE "  <category name='$row[0]'/>\n";
    }  
    print FILE "</categories>\n<dataset seriesName='28 дней' color='ffff00' anchorBorderColor='ffff00' anchorBgColor='ffff00'>\n";

    $sth->execute();
    my @row1;
    while (@row1 = $sth->fetchrow_array())
    {
      $mystr="  <set value='$row1[1]'/>\n";
      $mystr=~ s/,/./;
      print FILE $mystr;     
    }
	print FILE "</dataset>";
	
	print FILE "\n<dataset seriesName='14 дней' color='20B2AA' anchorBorderColor='ffff00' anchorBgColor='ffff00'>\n";

    $sth_1->execute();
    while (@row1 = $sth_1->fetchrow_array())
    {
      $mystr="  <set value='$row1[1]'/>\n";
      $mystr=~ s/,/./;
      print FILE $mystr;     
    }
	print FILE "</dataset>";
	
	
	print FILE "\n<dataset seriesName='7 дней' color='ff0000' anchorBorderColor='ffff00' anchorBgColor='ffff00'>\n";
    $sth_2->execute();
    while (@row1 = $sth_2->fetchrow_array())
    {
	
      $mystr="  <set value='$row1[1]'/>\n";
      $mystr=~ s/,/./;
	  
      print FILE $mystr;    
	  
    }
	
	
	
    print FILE "</dataset>\n</graph>"; 

  close(FILE)};

  system("rm -f //var/www/www.kse.kg/monitor/data_for_chart/not_graf.xml");
  system("cp /var/www/www.kse.kg/cron/not_graf.xml /var/www/www.kse.kg/monitor/data_for_chart/not_graf.xml");