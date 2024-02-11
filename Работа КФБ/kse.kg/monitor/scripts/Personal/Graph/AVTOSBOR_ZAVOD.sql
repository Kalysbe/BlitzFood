select distinct  d,
(select www.sel_article('Собственный капитал%',t.name, tab.d) as SK
from ls.companies t
where t.id=206) as "Собственный капитал",
(select www.sel_article('Валовая прибыль%',t.name, tab.d) as VP
from ls.companies t
where t.id=206) as "Валовый доход",
(select www.sel_article('Чистая прибыль%',t.name, tab.d) as CP
from ls.companies t
where t.id=206) as "Чистая прибыль"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=206)) tab
