select distinct  d,
(select www.sel_article('����������� �������%',t.name, tab.d) as SK
from ls.companies t
where t.id=206) as "����������� �������",
(select www.sel_article('������� �������%',t.name, tab.d) as VP
from ls.companies t
where t.id=206) as "������� �����",
(select www.sel_article('������ �������%',t.name, tab.d) as CP
from ls.companies t
where t.id=206) as "������ �������"
from 
(select substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d 
from
(select distinct date0 from ls.balance t
where compid=206)) tab
