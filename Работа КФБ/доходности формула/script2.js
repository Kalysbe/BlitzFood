function makeDateToJSDate(strDate)			// перевод даты из дд/мм/гггг в формат JS
{
   var dateParts = strDate.split("/");
   var result_date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
   return result_date; 
}
function diff2Date(startDate, endDate, format)      // разница между датами
{
   switch (format) {
      case 'day':
         var diff = ((endDate - startDate) / 86400000) 
      break
      case 'year':
         var diff = endDate.getFullYear() - startDate.getFullYear();
      break
}
   
   return diff;
}
function recalcPrice(data,algorithm_calculation)
{
        
         // var frm_profit=my_getbyid('profit').value;		// доход (желаемый доход, поле из формы ввода)
         var frm_profit=15;
               var settlement_date = new Date(makeDateToJSDate('12/12/2022'));      // дата расчетов за покупку
               var repayment_date = new Date(makeDateToJSDate('12/12/2024'));   	 // дата погашения
               var coupon_annual_rate = 5; 							 // ставка
               var amount_ratio = 100; 										 // цена погашения
               var freq_payments = 2; 							 		 // частота выплат в год
         
      

         var first_comp = 0;
         var second_comp = 0;
         var third_comp = 0;

         var dateFirstCoupon = new Date(settlement_date);    
         dateFirstCoupon.setMonth(dateFirstCoupon.getMonth() + (12/freq_payments));   // дата первой выплоты по купону
   
         var dsc_f = diff2Date(settlement_date, dateFirstCoupon, 'day');     		// DSC для 1 скобки
         var N = diff2Date(settlement_date, repayment_date, 'year')*freq_payments;   // количество оплачиваемых купонов между датой соглашения и датой расчета
         var E_f = diff2Date(settlement_date, dateFirstCoupon, 'day');         		// количество дней в периоде купона, на который приходится дата расчета
         var A_f = 0;         														// количество дней от начала периода купона до даты соглашения
         first_comp = amount_ratio / Math.pow((1+(frm_profit/100/freq_payments)),(N-1)+(dsc_f/E_f));   // расчет первой скобки
         for (var i = 1; i < N+1; i++) {
            var chislitel = 100*((coupon_annual_rate/100)/freq_payments);
            var znamenatel = Math.pow((1 + ((frm_profit/100)/freq_payments)),i);
            var second_comp_i = (chislitel/znamenatel);

            console.log(chislitel/znamenatel)
            second_comp = second_comp + second_comp_i;
          
         }
         
         third_comp = 100 * ((coupon_annual_rate/freq_payments)*(A_f/E_f)); 	// расчет третьей скобки
          
         //alert(second_comp);
         
         var price = first_comp + second_comp ;
       
       
    
    
   
}

recalcPrice()
