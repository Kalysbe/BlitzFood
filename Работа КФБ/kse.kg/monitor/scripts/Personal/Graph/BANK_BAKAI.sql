select distinct  distinct d,
(select www.sel_article('Всего  Капитал%',t.name, tab.d) as SK
from ls.companies t
where t.id=84) as "Собственный капитал",
(select www.sel_article('Всего процентные доходы%',t.name, tab.d) as VP
from ls.companies t
where t.id=84) as "Валовый доход",
(select www.sel_article('Чистая Прибыль (Убытки)%',t.name, tab.d) as CP
from ls.companies t
where t.id=84) as "Чистая прибыль"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=84)) tab
