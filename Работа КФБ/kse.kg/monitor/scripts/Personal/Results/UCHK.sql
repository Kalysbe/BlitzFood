select www.sel_article('����������� �������%',t.name,'2004') as SK, 
www.sel_article('������� �������%',t.name,'2004') as VP, 
www.sel_article('������ �������%',t.name,'2004') as CP
from LS.companies t
where t.id=26