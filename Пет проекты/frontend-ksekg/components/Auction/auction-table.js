import { PrimaryTitle } from "../elements/primary-title"
export function AuctionTable() {
    return (
        <div className="w-full">
            <PrimaryTitle title="ГКВ (млн сом)"/>
            <table border="1">
                <tbody>
                    <tr>
                        <th>Дата аукциона</th>
                        <th>Дата выпуска</th>
                        <th>Регистрационный номер</th>
                        <th>Срок обращения</th>
                        <th>Объем выпуска ГКВ</th>
                    </tr>
                    <tr>
                        <td>02.02.2023</td>
                        <td>06.02.2023</td>
                        <td>GD052240205</td>
                        <td>12 мес.</td>
                        <td>60,0</td>
                    </tr>
                    <tr>
                        <td>09.02.2023 </td>
                        <td>13.02.2023 </td>
                        <td>GD052240212 </td>
                        <td>12 мес.</td>
                        <td>60,0</td>
                    </tr>
                    <tr>
                        <td colspan="4">Итого ГКВ:</td>
                        <td>120,0</td>
                    </tr>
                </tbody>
            </table>
            <PrimaryTitle title="ГКО (млн сом)"/>
            <table className="w-full">
                <tbody>
                    <tr>
                        <th>Дата аукциона</th>
                        <th>Дата выпуска</th>
                        <th>Регистрационный номер</th>
                        <th>Ставка купона</th>
                        <th>Срок обращения</th>
                        <th>Объем выпуска ГКО</th>
                    </tr>		<tr>
                        <td>10.02.2023</td>
                        <td>13.02.2023</td>
                        <td>GBA07300213</td>
                        <td>7%</td>
                        <td>7 лет</td>
                        <td>1100,0</td>
                    </tr>
                    <tr>
                        <td>17.02.2023</td>
                        <td>20.02.2023</td>
                        <td>GBA05280220 </td>
                        <td>6%</td>
                        <td>5 лет</td>
                        <td>350,0</td>
                    </tr>
                    <tr>
                        <td>24.02.2023</td>
                        <td>27.02.2023 </td>
                        <td>GBA02250227</td>
                        <td>5%</td>
                        <td>2 год</td>
                        <td>300,0</td>
                    </tr>
                    <tr>
                        <td colspan="5">Итого ГКО:</td>
                        <td>1 750,0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    )
}