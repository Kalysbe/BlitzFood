select e.name as typ,max(t.emission_num) as emiss, www.formatnumber(sum(t.emission_quan)) as quantity,
      www.dot(t.nominal) as nominal, www.formatnumber(round(sum(t.emission_quan*t.nominal/1000000),2)) as total
from LS.extra_security t,ls.extra_typeofsec e 
where SHORTNAME like '%KNEF%' and t.typeofsec=e.id
group by t.nominal,e.name