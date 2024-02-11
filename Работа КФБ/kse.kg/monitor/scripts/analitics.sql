select extra_enterprise.name,
       substr(ts.makedate(date0),(length(ts.makedate(date0))-3)) as d,
       t.artgroup, 
       t.article,  
       t.value1  
  from ls.balance t,
       ls.extra_enterprise
 where extra_enterprise.id = t.compid and rates=1
 and substr(ts.makedate(date0),(length(ts.makedate(date0))-3))=2003
 and extra_enterprise.id=1;