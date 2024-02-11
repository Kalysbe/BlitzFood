select max(t.emission_num) as emiss, www.formatnumber(sum(t.emission_quan)) as quantity,
      www.dot(t.nominal) as nominal, www.formatnumber(round(sum(t.emission_quan*t.nominal/1000000),2)) as total
from LS.extra_security t
where SHORTNAME like '%JELK%' and t.emission_num=(select max(emission_num) from LS.extra_security where SHORTNAME like '%JELK%')
group by t.nominal