select  round(Ind,2) as ind, www.getdiff_mon(indchng) as IndPicture, www.getdiff_mon(capchng) as CapPicture, www.formatchange(Indchng) as Indchng, round(cap/1000000,2) as cap 
from (select t.ind,t.cap, (ind/(select t2.ind from ts.capitalisation t2 where t2.date0=
       (select max(t1.date0) as maxdate from ts.capitalisation t1 where t1.date0<t.date0)
       )-1)*100 as indchng,
      (cap/(select t2.cap from ts.capitalisation t2 where t2.date0=
       (select max(t1.date0) as maxdate from ts.capitalisation t1 where t1.date0<t.date0)
       )-1)*100 as capchng
   from ts.capitalisation t
   where t.date0=(select max(t2.date0) from ts.capitalisation t2)
   order by  t.date0)