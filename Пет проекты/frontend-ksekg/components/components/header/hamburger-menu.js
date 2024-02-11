import Link from 'next/link'

export default function HamburgerMenu() {
    return (
        <div className="z-30 bg-littleTransparent border border-red-500 overflow-y-hidden h-full absolute w-screen scroll-smooth">
        <div className="bg-white dark:bg-black">
        <div className="container mx-auto w-full h-[400px] flex justify-between pt-5">
            <div className="flex flex-col">
                <span className="text-primary font-semibold">О Нас</span>
                <Link href={'/'}>Общая информация</Link>
                <Link href={'/'}>Акционеры</Link>
                <Link href={'/'}>Руководство</Link>
                <Link href={'/'}>Ревизионная комиссия</Link>
                <Link href={'/'}>Комитеты</Link>
                <Link href={'/'}>Участники торгов</Link>
                <Link href={'/'}>Наши партнеры</Link>
                <Link href={'/'}>Cтратегия развития</Link>
                <Link href={'/'}>Корпоративные документы</Link>
                <Link href={'/'}>Контакты</Link>
            </div>
            <div className="flex flex-col">
                <span className="text-primary font-semibold">Направления</span>
                <Link href={'/'}>Товарно-сырьевой сектор</Link>
                <Link href={'/'}>Листинг</Link>
                <Link href={'/'}>Центр раскрытия информации</Link>
                <Link href={'/'}>Тарифы</Link>
                <Link href={'/'}>Аналитика</Link>
                <Link href={'/'}>Финансовый рынок KG</Link>
                <Link href={'/'}>Пресс-клуб</Link>
                <Link href={'/'}>25 лет ЗАО КФБ</Link>
            </div>
            <div className="flex flex-col">
                <span className="text-primary font-semibold">Нормативная база</span>
                <Link href={'/'}>Биржевая деятельность</Link>
                <Link href={'/'}>Депозитарная деятельность</Link>
                <Link href={'/'}>Центр раскрытия информации</Link>
            </div>
            <div className="flex flex-col">
                <span className="text-primary font-semibold">Статистика торгов</span>
                <Link href={'/'}>Итоги последних торгов</Link>
                <Link href={'/'}>Архив торгов</Link>
                <Link href={'/'}>Индекс и капитализация</Link>
                <Link href={'/'}>Котировки по ЦБ</Link>
                <Link href={'/'}>Котировки по драг.металлам</Link>
                <Link href={'/'}>Расписание аукционов по ГЦБ</Link>
            </div>
            <div className="flex flex-col">
                <span className="text-primary font-semibold">Учебный центр</span>
                <Link href={'/'}>Общая информация</Link>
                <Link href={'/'}>План работы на год</Link>
            </div>
        </div>
        </div>
        </div>
    )
}