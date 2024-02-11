select USD, www.getdiff_mon(usdCng) as USDPicture, to_char(USDCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as USDCng,
       EUR, www.GETDIFF_mon(eurCng) as EURPicture, to_char(EURCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as EURCng,
       RUB, www.GETDIFF_mon(rubCng) as RUBPicture, to_char(RUBCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as RUBCng,
       date1
from (select USD, www.prevUSD(t.date0) as USDCng,
       EUR, www.prevEUR(t.date0) as EURCng,
       RUB, www.prevRUB(t.date0) as RUBCng,
       ts.makedate(date0) as date1
     from ls.cur t
     where t.date0=(select max(t1.date0) from ls.cur t1))

