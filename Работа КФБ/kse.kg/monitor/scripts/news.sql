select companies.name,
       t.date0,
       t.event
  from ls.news t,
       ls.companies
 where companies.id = t.comp_id
 and ls.companies.NAME like '[FBISAPI:COMPANIES]';