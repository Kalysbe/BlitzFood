select * from 
(select rownum as rm, bb.* from
(
select tc.shortname as name, tc.namerus,ts.makedate(tc.zakdate),(case when ts.makedate(tc.zakdate) like '-' then '' else concat(', ���� �������� ',to_char(ts.makedate(tc.zakdate))) end) as dt,
       (select (max(ts.makeb(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as b,
       (select sum(volume)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select max(ts.makeb(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as bv,
       (select (min(ts.makes(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as s,
       (select sum(volume)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select max(ts.makes(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as sv
  from ts.ts_currinstrument_arcts tc
 ) bb
 where b is not null or s is not null )
 where rm between 15 and 30
 