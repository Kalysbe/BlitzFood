select '<a target=_blank class="link" href=listing/' || (select min(tt.shortname) from ls.extra_security tt where tt.enterprise=t.id) || '.shtml>' || t.name || '</a>' as name,
       WWW.GETTYPEOFSECS(t.name) as typeofsecs,
       to_char(round(nvl(t.price,0),4),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as LastPrice,
       to_char(round(nvl(t.price* t.infusion/1000000,0),2),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as LastPriceEPQ,
       to_char(infusion,'fm999G999G990', 'nls_numeric_characters='', ''''') as infusion,
       '<a href=listing\' || (select min(tt.shortname) from ls.extra_security tt where tt.enterprise=t.id) || '.pdf><img src="img\pdf.gif" border=0></a>' as doc
from ls.extra_enterprise t
where t.ind=1 and WWW.GETLSTYPE(t.name)='Категория SU';