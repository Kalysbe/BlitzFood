select
       to_char(round(sum(nvl(t.price * t.infusion/1000000,0)),2),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as sumLastPriceEPQ
from ls.extra_enterprise t
where t.ind=1 and WWW.GETLSTYPE(t.name)='Категория А';