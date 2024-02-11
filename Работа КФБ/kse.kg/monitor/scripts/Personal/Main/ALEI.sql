select ls_cat.cat,
       WWW.MAKESHORTNAME(t.name) as shname,
       ls.field.name as field,
       t.job,
       t.date_ls,
       t.fio_director,
       t.post,
       t.address,
       t.tel_fax,
       auditor.name as auditor,
       registrar.name as registrar,
       market_maker.name as market_maker
  from ls.companies t,
       ls.ls_cat,
       ls.field,
       ls.auditor,
       ls.registrar,
       ls.market_maker
 where WWW.MAKESHORTNAME(t.name) like '%ALEI%'
       and ls_cat.id = t.category
       and ls.field.id=t.field
       and auditor.id = t.auditor
       and registrar.id = t.registrar
       and market_maker.id = t.market_maker