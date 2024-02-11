select date1,
to_char(sum(sTotal)/1000,'fm999G999G999G990D0', 'nls_numeric_characters='', ''''') as sTotal,
to_char(sum(sVolume),'fm999G999G990', 'nls_numeric_characters='', ''''') as sVolume,
to_char(sum(sMark),'fm999G999G990', 'nls_numeric_characters='', ''''') as sMark,
to_char(sum(sRazm)/1000,'fm999G999G999G990D0', 'nls_numeric_characters='', ''''') as sRazm,
to_char((sum(sTotal)-sum(sRazm))/1000,'fm999G999G999G990D0', 'nls_numeric_characters='', ''''') as sSecond,
to_char(sum(sList)/1000,'fm999G999G999G990D0', 'nls_numeric_characters='', ''''') as sList,
to_char((sum(sTotal)-sum(sList))/1000,'fm999G999G999G990D0', 'nls_numeric_characters='', ''''') as sUnList
from
        (--select '2003' as date1, 20933204 as svolume, 673 as smark, 215715900 as stotal, 10790900 as srazm,
       --20496620 as slist from ts.usertrader
       --where rownum=1

       --union all

        select WWW.GETYEAR(ts.makedate(t.date0)) as date1,
               sum(t.volume)/2 as sVolume,
               sum(t.price/t.price)/2 as sMark,
               sum(t.price*t.volume)/2 as sTotal,
               max(nvl(r.total,0)) as sRazm,
               max(nvl(l.total,0)) as sList
         from sys.deal2 t,ls.srazm r,ls.slist l
         where t.date0>=131140630 and t.date0=r.date0(+) and t.date0=l.date0(+)
         group by t.date0)
group by date1
order by date1