select date1, to_char(sum(sTotal)/1000,'fm999G999G990D0', 'nls_numeric_characters='', ''''') as sTotal,
to_char(sum(sVolume),'fm999G999G990', 'nls_numeric_characters='', ''''') as sVolume,
to_char(sum(sMark),'fm999G999G990', 'nls_numeric_characters='', ''''') as sMark,
to_char(sum(sRazm)/1000,'fm999G999G990D0', 'nls_numeric_characters='', ''''') as sRazm,
to_char(sum(sSecond)/1000,'fm999G999G990D0', 'nls_numeric_characters='', ''''') as sSecond,
to_char(sum(sList)/1000,'fm999G999G990D0', 'nls_numeric_characters='', ''''') as sList,
to_char(sum(sUnList)/1000,'fm999G999G990D0', 'nls_numeric_characters='', ''''') as sUnList
from

        (select WWW.GETMONTH(ts.makedate(t.date0)) as date1,
               sum(t.volume)/2 as sVolume,
               sum(t.price/t.price)/2 as sMark,
               sum(t.price*t.volume)/2 as sTotal,
               nvl(www.srazm(t.date0),0) as sRazm,
               sum(t.price*t.volume)/2-nvl(www.srazm(t.date0),0) as sSecond,
               nvl(www.slist(t.date0),0) as sList,
               sum(t.price*t.volume)/2-nvl(www.slist(t.date0),0) as sUnList
         from sys.deal2 t
         where date0>=(select max(t1.date0)-65536+240 from sys.deal2 t1)
         group by date0)
group by date1
order by to_number(substr(date1,(instr(date1,'/')+1)))*65536 +
to_number(substr(date1,1,instr(date1,'/')-1))*256
