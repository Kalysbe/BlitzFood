select 
     ts.maketime(t.time0) as time1, t.ind 
from 
     ts.capitalisation_hour t
where date0>=ts.getcurrdate
order by time0 asc
--t.date0>=(select max(t2.date0)-500 from ts.capitalisation t2) and date0<=(select max(t3.date0) from ts.capitalisation t3)
--order by date0 asc;