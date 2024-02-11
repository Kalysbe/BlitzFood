select www.makedate(t.date0) as date1, t.ind from ts.capitalisation t
where t.date0>=(select max(t2.date0)-494 from ts.capitalisation t2) and date0<=(select max(t3.date0) from ts.capitalisation t3);