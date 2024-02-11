select  distinct d,
(select www.sel_article('Всего собственный капитал%',t.name, tab.d) as SK
from ls.companies t
where t.id=1) as "Собственный капитал",
(select www.sel_article('Процентные доходы банка%',t.name, tab.d) as VP
from ls.companies t
where t.id=1) as "Валовый доход",
(select www.sel_article('Чистая прибыль банка%',t.name, tab.d) as CP
from ls.companies t
where t.id=1) as "Чистая прибыль"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=1)) tab
