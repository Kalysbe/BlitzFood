select round(Ind,2) as ind, www.getdiff(indchng) as IndPicture,Indchng
from (select t.ind, round(ind/(select t2.ind from ts.capitalisation t2 where t2.date0=
       (select max(t1.date0) as maxdate from ts.capitalisation t1 where t1.date0<t.date0)
       )-1,2) as indchng
   from ts.capitalisation t
   where t.date0>=ts.makelongdate('%1') and t.date0<=ts.makelongdate('%2')
   order by  t.date0)


