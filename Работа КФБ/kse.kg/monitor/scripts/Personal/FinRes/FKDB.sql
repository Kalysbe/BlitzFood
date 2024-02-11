select distinct d,
(select to_char(www.sel_article('Всего собственный капитал%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as SK
from ls.companies t
where t.id=647) as "Собственный капитал",
(select to_char(www.sel_article('Процентные доходы банка%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as VP
from ls.companies t
where t.id=647) as "Валовый доход",
(select to_char(www.sel_article('Чистая прибыль банка%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as CP
from ls.companies t
where t.id=647) as "Чистая прибыль"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=647)) tab
