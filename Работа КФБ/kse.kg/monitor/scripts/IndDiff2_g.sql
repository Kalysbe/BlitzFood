select round(Ind,2) as ind, cap, date1
from (select t.ind, www.formatnumber(round(cap/1000000,2)) as cap, ts.makedate(date0) as date1
   from ts.capitalisation_gen t
   where t.date0=(select max(t2.date0) from ts.capitalisation_gen t2)
   order by  t.date0)