select ts.makedate(t.date0) as date1, t.ind from ts.STOTAL t
where t.date0>=(select max(t2.date0)-14 from ts.STOTAL t2) and date0<=(select max(t3.date0) from ts.STOTAL t3);