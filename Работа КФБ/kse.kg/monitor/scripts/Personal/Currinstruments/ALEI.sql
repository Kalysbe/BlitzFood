select max(t.emission_num) as emiss, sum(t.emission_quan) as quantity,
      www.dot(t.nominal) as nominal, round(sum(t.emission_quan*t.nominal/1000000),2) as total
from LS.extra_security t
where SHORTNAME like '%ALEI%'
group by t.nominal