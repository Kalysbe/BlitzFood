import Link from 'next/link'
import { RiWhatsappFill } from 'react-icons/ri'
export function Footer() {
    return (
        <div className="w-full bg-primary pt-8 mt-10">
            <div className="container mx-auto flex justify-between text-white">
                <div className="flex flex-col">
                    <h5 className="text-2xl font-md">Полезные ссылки</h5>
                    <Link href='/'>Расписание аукционов по ГЦБ</Link>
                    <Link href='/'>Итоги последних торгов</Link>
                    <Link href='/'>Котировки по ЦБ</Link>
                    <Link href='/'>Центр раскрытия информации</Link>
                </div>
                <div className="flex flex-col">
                    <h5 className="text-2xl font-md">О нас</h5>
                    <Link href='/'>Общая информация</Link>
                    <Link href='/'>Контакты</Link>
                    <Link href='/'>Руководство</Link>
                    <Link href='/'>Наши партнеры</Link>
                </div>
                <div className="flex flex-col">
                    <h5 className="text-2xl font-md">Контакты</h5>
                    <Link href='/'>+996 312 31 14 84</Link>
                    <div className="flex items-center">
                        <Link href='/'>+996 551 31 14 84</Link>
                        <Link href='/'>
                            <RiWhatsappFill className="text-[#128C7E] text-2xl"/>
                        </Link>
                        <Link href='/'></Link>
                    </div>
                    <Link href=''>office@kse.kg</Link>
                </div>
            </div>
            <div className="border-t border-[#a7a8aa] mt-10">
                <p className="text-center text-sm text-white py-5">Все права защищены © 2004-2022 Копирование материалов – только с письменного разрешения. Лицензия №37 НКРЦБ от 30.11.2000 г.</p>
            </div>
        </div>
    )
}