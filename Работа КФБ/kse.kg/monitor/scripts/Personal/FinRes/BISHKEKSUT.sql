select distinct d,
(select to_char(www.sel_article('����������� �������%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as SK
from ls.companies t
where t.id=174) as "����������� �������",
(select to_char(www.sel_article('������� �������%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as VP
from ls.companies t
where t.id=174) as "������� �����",
(select to_char(www.sel_article('������ �������%',t.name, tab.d),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as CP
from ls.companies t
where t.id=174) as "������ �������"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as d
from
(select distinct date0 from ls.balance t
where compid=174)) tab
