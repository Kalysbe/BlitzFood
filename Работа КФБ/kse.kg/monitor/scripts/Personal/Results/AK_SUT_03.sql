select www.sel_article('Собственный капитал%',t.name,'2003') as SK, 
www.sel_article('Валовая прибыль%',t.name,'2003') as VP, 
www.sel_article('Чистая прибыль%',t.name,'2003') as CP
from LS.companies t
where t.id=196