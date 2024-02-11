select sh,nm,
       nvl(WWW.GETOPENPRC(sh),0) as OpenPrice,
       nvl(WWW.GETMAXPRC(sh,(select max(t1.date0) as date1 from sys.deal2 t1)),0) as MaxPrice,
       nvl(WWW.GETMINPRC(sh,(select max(t1.date0) as date1 from sys.deal2 t1)),0) as MinPrice,
       nvl(www.GETCLOSEPRC(sh),0) as ClosePrice,
       round(nvl(www.getprccng(sh),0),2) as PrcCng,
       round(nvl(www.gettotal(sh,(select max(t1.date0) as date1 from sys.deal2 t1))/1000000,0),4) as Total,
       nvl(www.getmark(sh,(select max(t1.date0) as date1 from sys.deal2 t1)),0) as Mark,
       nvl(www.getvolume(sh,(select max(t1.date0) as date1 from sys.deal2 t1)),0) as Volume,
       nvl(www.getmp(sh,(select max(t1.date0) as date1 from sys.deal2 t1)),'=õª') as MP
from
       (select distinct shortname as sh, namerus as nm from ts.f1a_q2
where date0=(select max(t1.date0) from sys.deal2 t1)
--where date0=(select ts.makelongdate(to_char(sysdate,'DD/MM/YYYY')) from dual) 
      and ascii(direct)=1)