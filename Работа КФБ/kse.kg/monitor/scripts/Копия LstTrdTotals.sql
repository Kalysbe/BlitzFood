select '<a class=link target=_blank href=listing/' || substr(sh,1,4) || '.shtml>' || sh || '</a>' as sh,
       nvl(WWW.GETOPENPRC(sh),0) as OpenPrice,
       nvl(WWW.GETMAXPRC(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),0) as MaxPrice,
       nvl(WWW.GETMINPRC(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),0) as MinPrice,
       nvl(www.GETCLOSEPRC(sh),0) as ClosePrice,
       round(nvl(www.getprccng(sh),0),2) as PrcCng,
       nvl(www.gettotal(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),0) as Total,
       nvl(www.getmark(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),0) as Mark,
       nvl(www.getvolume(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),0) as Volume,
       nvl(www.getmp(sh,(select max(t1.date0) as date1 from ts.sessiononline t1)),'Нет') as MP
from
       (select distinct min(t.shortname) as sh
         from ls.extra_security t,
         ls.extra_enterprise tt,
         ls.extra_typeofsec
         where tt.id = t.enterprise
         and tt.ind=1
         and extra_typeofsec.id = t.typeofsec
         group by  tt.name, extra_typeofsec.name
         order by sh)