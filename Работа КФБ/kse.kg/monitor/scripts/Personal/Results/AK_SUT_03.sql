select www.sel_article('����������� �������%',t.name,'2003') as SK, 
www.sel_article('������� �������%',t.name,'2003') as VP, 
www.sel_article('������ �������%',t.name,'2003') as CP
from LS.companies t
where t.id=196