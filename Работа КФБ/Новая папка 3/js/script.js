window.onload=function(){
update_status();
}

function createHttpRequest() {
   var httpRequest;
   var browser = navigator.appName;

   if (browser == "Microsoft Internet Explorer")
   {
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
   }
   else
   {
   httpRequest = new XMLHttpRequest();
   }

   return httpRequest;
}

function sendRequest(file, _resultId, getRequestProc) {
   resultId = _resultId;
   httpRequest.open('get', file);
   httpRequest.onreadystatechange = getRequestProc;
   httpRequest.send(null);
}

function getRequest() {
   if (httpRequest.readyState == 4)
   {
      document.getElementById(resultId).innerHTML = httpRequest.responseText;
   }
}

var httpRequest = createHttpRequest();
var statusRequest = createHttpRequest();
var ordersRequest = createHttpRequest();
var resultId = '';
var wait_please = '<table width="100%" height="100%"><tr><td  align="center" valign="middle"><img src="./img/progress.gif" alt="Progress"><br>«агрузка...</td></tr></table>';
var old_status = -1;

function my_getbyid(id)
{
        itm = null;

        if (document.getElementById)
        {
                itm = document.getElementById(id);
        }
        else if (document.all)
        {
                itm = document.all[id];
        }
        else if (document.layers)
        {
                itm = document.layers[id];
        }

        return itm;
}

function confirm_del(url)
{
   if (confirm("¬ы действительно хотите удалить запись?"))
   {document.location=url;}
}

function conf_true_ord(url)
{
   if (confirm("¬ы действительно хотите подтвердить запись?"))
   {document.location=url;}
}

function conf_false_ord(url)
{
   if (confirm("¬ы действительно хотите отклонить запись?"))
   {document.location=url;}
}

function end_auction(url)
{
   if (confirm("¬ы действительно хотите завершить аукцион?"))
   {document.location=url;}
}

function clean_auction(url)
{
   if (confirm("ѕосле очистки все данные по текущему аукциону будут удалены. ¬ы действительно хотите очистить аукцион?"))
   {document.location=url;}
}

function auction_estimate(url)
{
   if (confirm("¬ы действительно хотите произвести предварительные расчеты?"))
   {document.location=url;}
}

function auction_confirmer_go(url)
{
   if (confirm("«авершить этап подтвержени€ конфирмеров?"))
   {document.location=url;}
}

function auction_reestimate(url)
{
   if (confirm("¬ы действительно хотите пересчитать предварительные расчеты?"))
   {document.location=url;}
}

function auction_estimate_go(url)
{
   if (confirm("¬ы действительно хотите подтвердить предварительные расчеты?"))
   {document.location=url;}
}

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
	switch(algorithm_calculation)
	{
		case 1:
			var chk=my_getbyid('comp');
			if (chk.checked){ return; }  // если стоит чек на неконкурентых то выходим
		
			var frm_profit=my_getbyid('profit').value;		// доход (желаемый доход, поле из формы ввода)
	
			var frm_instr=my_getbyid('currinstrument').value; // выбраный инструмент 
			for(var key in data) 
			{
				if (key == frm_instr)
				{
				//alert(key + ': ' + data[key]['settlement_date']);
					var settlement_date = new Date(makeDateToJSDate(data[key]['settlement_date']));      // дата расчетов за покупку
					var repayment_date = new Date(makeDateToJSDate(data[key]['repayment_date']));   	 // дата погашени€
					var coupon_annual_rate = data[key]['coupon_annual_rate']; 							 // ставка
					var	amount_ratio = data[key]['amount_ratio']; 										 // цена погашени€
					var freq_payments = data[key]['freq_payments']; 							 		 // частота выплат в год
				}
			}

			var first_comp = 0;
			var second_comp = 0;
			var third_comp = 0;

			var dateFirstCoupon = new Date(settlement_date);    
			dateFirstCoupon.setMonth(dateFirstCoupon.getMonth() + (12/freq_payments));   // дата первой выплоты по купону
	
			var dsc_f = diff2Date(settlement_date, dateFirstCoupon, 'day');     		// DSC дл€ 1 скобки
			var N = diff2Date(settlement_date, repayment_date, 'year')*freq_payments;   // количество оплачиваемых купонов между датой соглашени€ и датой расчета
			var E_f = diff2Date(settlement_date, dateFirstCoupon, 'day');         		// количество дней в периоде купона, на который приходитс€ дата расчета
			var A_f = 0;         														// количество дней от начала периода купона до даты соглашени€

			first_comp = amount_ratio / Math.pow((1+(frm_profit/100/freq_payments)),(N-1)+(dsc_f/E_f));   // расчет первой скобки
	
			for (var i = 1; i < N+1; i++) {
				var chislitel = 100*((coupon_annual_rate/100)/freq_payments);
				var DSC_i = 1;
				var E_i = 1;
				var znamenatel = Math.pow((1 + ((frm_profit/100)/freq_payments)),((i-1)+(DSC_i/E_i)));
				var second_comp_i = (chislitel/znamenatel);
				second_comp = second_comp + second_comp_i;
				//alert(second_comp_i);		
			}

			third_comp = 100 * ((coupon_annual_rate/freq_payments)*(A_f/E_f)); 	// расчет третьей скобки
		
			//alert(second_comp);
			
			var price = first_comp + second_comp - third_comp;
			var frm_price = my_getbyid('price');
			
			frm_price.value = price.toFixed(2);
		break;
		
		case 2:
		
			var chk=my_getbyid('comp');
			if (chk.checked){ return; }  // если стоит чек на неконкурентых то выходим
			
			var frm_profit=my_getbyid('profit').value;		// доход (желаемый доход, поле из формы ввода)
			var frm_instr=my_getbyid('currinstrument').value; // выбраный инструмент 
			for(var key in data) 
			{
				if (key == frm_instr)
				{
				//alert(key + ': ' + data[key]['settlement_date']);
					var settlement_date = new Date(makeDateToJSDate(data[key]['settlement_date']));      // дата расчетов за покупку
					var repayment_date = new Date(makeDateToJSDate(data[key]['repayment_date']));   	 // дата погашени€
				}
			}
			var p = 0;
			var T = diff2Date(settlement_date,repayment_date, 'day'); 
			
			frm_profit = frm_profit / 100;
			
			p = (100 / (1 + (frm_profit / (360 / T ) ) ) ); 	// формула расчета √ ¬
			
			var frm_price = my_getbyid('price');
			
			frm_price.value = p.toFixed(2);
		
		break;
		
		default: alert ('Ќе выбрал');
	}
	
}

function checkint() {
   var n;
   n=event.keyCode;
   if( (n >= 48 && n <= 57) || n==13 ) return n
   else return false
}

function checkfloat() {
   var n;
   n=event.keyCode;
   if( (n >= 48 && n <= 57) || n==46 || n==13) 
   {
    return n;
   }
   else return false
}

function close_porting() {
   var prt_a=my_getbyid('porting_alert');
   var prt=my_getbyid('porting');
   prt.innerHTML='';
   prt_a.style.display='none';
}

function add_lot()
{
   var prt=my_getbyid('porting');
   prt.style.width=460;
   prt.style.height=260;
   prt.style.background='#ffffff';
   prt.innerHTML=wait_please;
   var prt_a=my_getbyid('porting_alert');
   prt_a.style.display='block';
   sendRequest('./index.php?op&action=add_lot', 'porting', getRequest);
}

function show_issue_prop(val)
{
   var prt=my_getbyid('porting');
   prt.style.width=460;
   prt.style.height=520;
   prt.style.background='#ffffff';
   prt.innerHTML=wait_please;
   var prt_a=my_getbyid('porting_alert');
   prt_a.style.display='block';
   sendRequest('./index.php?op&action=show_issue_prop&issue='+val, 'porting', getRequest);
}

function add_order()
{
   var prt=my_getbyid('porting');
   prt.style.width=450;
   prt.style.height=190;
   prt.style.background='#ffffff';
   prt.innerHTML=wait_please;
   var prt_a=my_getbyid('porting_alert');
   prt_a.style.display='block';
   sendRequest('./index.php?op&action=add_order', 'porting', getRequest);
}

function show_orders()
{
   if (ordersRequest.readyState == 4)
   {
      var resp1=ordersRequest.responseText;
      var ord1=my_getbyid("ord_list");
      if (ord1!=null)
      {
         ord1.innerHTML=resp1;
      }
   }
}

function show_controls()
{
if (statusRequest.readyState == 4)
   {
      var resp=statusRequest.responseText;

      if (resp>=3)
      {
         var rnd;
         rnd = parseInt(Math.random()*10000);
         sendRequest("./index.php?op="+rnd+"&action=deals", "deals", getRequest);
      }
      else
      {
         var dl=my_getbyid("deals");
         if (dl!=null)
         {
            dl.innerHTML='';
         }
      }

      var ord=my_getbyid("add_order_btn");
      if (ord!=null)
      {
         if (resp.length!=0)
         {
            var vs='hidden';
            if (resp=='0')
            {
               vs='visible';
            }
            ord.style.visibility=vs;
            var i=0;
            for (i=0;i<document.links.length;i++)
            {
               if (document.links[i].href.indexOf('del_orders')>=0)
               {
                  document.links[i].style.visibility=vs;
               }
            }
         }
      }
   }
}

function update_status()
{
   var rnd;
   rnd = parseInt(Math.random()*10000);

   var st=my_getbyid("a_status");
   if (st!=null)
   {
      sendRequest("./index.php?op="+rnd+"&action=status", "a_status", getRequest);

      statusRequest.open('get', "./index.php?op="+rnd+"&action=status&numeric");
      statusRequest.onreadystatechange = show_controls;
      statusRequest.send(null);

      ordersRequest.open('get', "./index.php?op="+rnd+"&action=orders");
      ordersRequest.onreadystatechange = show_orders;
      ordersRequest.send(null);
      setTimeout("update_status();",30000);  //60000
   }
}

function show_nocomp()
{
   var chk=my_getbyid('comp');
   var dv=my_getbyid('nocomp');
   if (!chk.checked)
   {
      dv.style.display='block';
   }
   else
   {
      dv.style.display='none';
   }
}

function block_field()
{
   var chk=my_getbyid('comp');
   var dv=my_getbyid('profit');
   var dp=my_getbyid('price');
   if (!chk.checked)
   {
	  dv.readOnly = false;
   }
   else
   {
      dp.value='0.00'
	  dv.value='';
	  dv.readOnly = true;
   }
}

function report_options(val)
{
   var rnd;
   rnd = parseInt(Math.random()*10000);

   alert(val);
   var ro=my_getbyid("report_options");
   ro.innerHTML='<br>«агрузка...<br><br>';

   sendRequest("./index.php?op="+rnd+"&action=report_options&r="+val, "report_options", getRequest);
}
function user_report_options(val)
{
	
   var rnd;
   rnd = parseInt(Math.random()*10000);

   var ro=my_getbyid("user_report_options");
   ro.innerHTML='<br>«агрузка...<br><br>';

   sendRequest("./index.php?op="+rnd+"&action=user_report_options&r="+val, "user_report_options", getRequest);
}
function minfin_report_options(val)
{
   var rnd;
   rnd = parseInt(Math.random()*10000);

   var ro=my_getbyid("user_report_options");
   ro.innerHTML='<br>«агрузка...<br><br>';

   sendRequest("./index.php?op="+rnd+"&action=user_report_options&r="+val, "user_report_options", getRequest);
}

function print_version() {
   var css = document.getElementById("css_print");
   css.media='all';
}

function normal_version() {
   var css = document.getElementById("css_print");
   css.media='print';
}

function selid(curr_id) {
  var obj=my_getbyid('but1');
  var nProfit=my_getbyid('nProfit');
  var nVolume_Nocomp_NBKR=my_getbyid('nVolume_Nocomp_NBKR');
  var nVolume_NBKR=my_getbyid('nVolume_NBKR');
  //var adr='index.php?go=databese&page=3&arg='+obj.value;
 // document.location='index.php?go=databese&page=4&arg='+obj.value+'?id=';
 //https://maint/auction/?minfin&go=database&page=1811732
 //alert('./index.php?minfin.php?go=databese&page='+curr_id+'&arg='+obj.value+'&id='+curr_id+'&nProfit='+nProfit.value+'&nVolume_NBKR='+nVolume_NBKR.value+'&nVolume_nocomp_NBKR='+nVolume_nocomp_NBKR.value);
 document.location='./index.php?minfin.php?go=databese&page='+curr_id+'&arg='+obj.value+'&id='+curr_id+'&nProfit='+nProfit.value+'&nVolume_NBKR='+nVolume_NBKR.value+'&nVolume_Nocomp_NBKR='+nVolume_Nocomp_NBKR.value;
}
function test(val) {
  var obj=my_getbyid('but1');
  obj.value=val;
  //alert(obj.value);
}