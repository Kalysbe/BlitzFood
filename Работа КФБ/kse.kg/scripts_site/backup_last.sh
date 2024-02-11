#!/bin/sh -xv

echo 'Stat backup...'

INCLFILE="/home/mnazaraliev/backup/backup_last.include"
BACKPATH="/home/mnazaraliev/arch/last"

NOW=`date +%Y-%m-%d`
BACKNAME=$BACKPATH/last_back_site[$NOW].tar.gz
LOGNAME="/home/mnazaraliev/arch/log/backup.log"
FILEFORDELETE="/home/mnazaraliev/arch/last/file.delete"
FILEFLAG="/home/mnazaraliev/arch/last/file.flag"
FLAG=`cat $FILEFLAG`

if [ $FLAG -eq 3 ]; then
    exit
fi

echo 2 > $FILEFLAG

OLDDATE=`cat $FILEFORDELETE`
OLDBACKFILE="/home/mnazaraliev/arch/last/last_back_site[$OLDDATE].tar.gz"

echo $NOW >> $LOGNAME

echo 'Create .tar.gz....'
cd /
###tar czvf $BACKNAME . -X $EXCLFILE 1> /dev/null 2>> $LOGNAME
tar -T $INCLFILE -czf $BACKNAME 1> /dev/null 2>> $LOGNAME

if [ $?=0 ]; then                #backup file has been created successlasty
        cp $OLDBACKFILE /home/mnazaraliev/arch/last/old/last_back_site[$OLDDATE].tar.gz > /dev/null 2>&1
        if [ $?=0 ]; then
            rm -rf $OLDBACKFILE > /dev/null 2>&1         #deleting old backup file
            lf=`ls /home/mnazaraliev/arch/last/old | grep last_back_site*tar.gz | sort`
            count=`ls /home/mnazaraliev/arch/last/old | grep last_back_site*tar.gz | awk '{tot+=1}; END { print tot}'`
            for i in $lf
            do
                if [ $count -gt 2 ]; then
                    rm -f /home/mnazaraliev/arch/last/old/$i
                    count=`expr $count - 1`
                fi
            done
        fi

        echo $NOW > $FILEFORDELETE              #wri
#        echo 0 > $FILEFLAG
        
	rm -rf /home/mnazaraliev/arch/last/last_back_site*.flag
	echo 0 > /home/mnazaraliev/arch/last/last_back_site[$NOW].flag
	#============= put backup to ftp ================================
	echo 'Put to ftp...'
	cd /home/mnazaraliev/arch/last
	ftp 192.168.0.23 <<EOD
	bin
	cd site
	put last_back_site[$NOW].tar.gz
	put last_back_site[$NOW].flag
	quit
EOD
	echo 'End backup'
else
        echo "ERROR !!!" | mail root
fi
