import  Link  from 'next/link'
import { AiOutlineArrowRight } from 'react-icons/ai'

const newsData = [
    {id:'0',date:'30.12.2022',title:'График работы ЗАО "Кыргызская фондовая биржа" в период новогодних праздников.'},
    {id:'1',date:'30.12.2022',title:'С Наступающим Новым 2023 годом!'},
    {id:'2',date:'26.12.2022',title:'Кабинет Министров КР выпустило Постановление "О реализации драгоценных металлов на площадке КФБ"'}
]

export function NewsList() {
    return (
        <ul>
            {newsData.map((item,index) => (
            <li key={item.id} className="border-b">
                <span className="text-gray-400 text-sm font-semibold">{item.date}</span>
                <Link href={'/'}><h4>{item.title}</h4></Link>
            </li>
            ))}
            <li className="mt-3">
                <Link href='/'>
                    <span className="flex justify-between w-[120px] hover:w-[125px] ml-[80%] duration-150 items-center text-primary font-md">
                        Все новости
                        <AiOutlineArrowRight/>
                    </span>
                </Link>
            </li>
        </ul>
    )
}