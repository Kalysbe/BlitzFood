select sum(t.mark)/2 as sMark from ts.f1a_q1 t
where t.date0>=ts.makelongdate('%1') and t.date0<=ts.makelongdate('%2')