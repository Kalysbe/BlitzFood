select distinct d,
(select to_char(www.sel_article('Собственный капитал%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as SK
from ls.companies t
where t.id=206) as "Собственный капитал",
(select to_char(www.sel_article('Валовая прибыль%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as VP
from ls.companies t
where t.id=206) as "Валовый доход",
(select to_char(www.sel_article('Чистая прибыль%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as CP
from ls.companies t
where t.id=206) as "Чистая прибыль"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=206)) tab
