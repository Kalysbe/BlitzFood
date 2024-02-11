<table class='new-report short' border='1'>
<tr class='info'>
      <td class='info'>Дата аукциона</td>
      <td class='info'><b>".$date."</b></td>
</tr>
<tr class='info'>
      <td class='info'>Вид ГЦБ</td>
      <td class='info'></td>
</tr>
<tr class='info'>
      <td class='info'>Срок обращения ГЦБ</td>
      <td class='info'></td>
</tr>
<tr class='info'>
      <td class='info'>Регистрационный номер</td>
      <td class='info'>".$shname."</td>
</tr>
<tr class='info'>
      <td class='info'>Количество ГЦБ (в штуках)</td>
      <td class='info'>".number_format($grand_volume_vs, 0, ',', ' ')."</td>
</tr>
<tr class='info'>
       <td class='info'>Объем предложения</td>
       <td class='info'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
</tr>
<tr>
        <td>Купонная ставка (%)</td>
        <td></td>
</tr>
<tr>
        <td>Количество участников <br/> Из них: </td>
        <td>".$cnt_users."</td>
</tr>
<tr>
        <td>Финансовые институты</td>
        <td></td>
</tr>
<tr>
        <td>Институциональные инвесторы</td>
        <td></td>
</tr>
<tr>
        <td>Инвесторы <br/> резидент/Нерезидент</td>
        <td></td>
</tr>
</table>   ";