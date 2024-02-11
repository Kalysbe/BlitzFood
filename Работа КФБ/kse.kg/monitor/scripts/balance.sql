select extra_enterprise.NAME,
       substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as D,
       t.artgroup,
       t.ARTICLE,
       t.VALUE1
  from ls.balance t,
       ls.extra_enterprise
 where extra_enterprise.id = t.compid and rates=0
 and substr(ts.makedate(date0),(length(ts.makedate(date0))-3))=[FBISAPI:BALANSE_T]
 and extra_enterprise.NAME like '[FBISAPI:COMPANIES]';
