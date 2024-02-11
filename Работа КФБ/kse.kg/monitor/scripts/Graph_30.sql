select 
     www.makedate(t.date0) as date1, t.ind 
from 
     ts.capitalisation_20 t
where date0>=ts.mkld_tmp(to_char(to_date(ts.makedate(ts.getcurrdate),'dd/mm/yy')-200,'DD/MM/YYYY'))
order by date0 asc
--t.date0>=(select max(t2.date0)-500 from ts.capitalisation t2) and date0<=(select max(t3.date0) from ts.capitalisation t3)
--order by date0 asc;