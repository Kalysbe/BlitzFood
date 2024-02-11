select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
                 t.volume*t.price as total,
                 (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
                 (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
                 (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
                 (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
                 (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
                 c.shortname,t.status,  
                 i.profit_nocomp_avg as profit,t.profit as ord
              from ls.auction_orders t, currinstrument c,ls.auction_issue i 
              where t.status != 2 and t.curr_id=c.id and t.curr_id = i.curr_id
              order by shortname ASC,t.price DESC