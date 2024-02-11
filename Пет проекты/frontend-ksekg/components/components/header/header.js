import Link from 'next/link';
import { CiLogin , CiLight } from 'react-icons/ci';
import { MdDarkMode } from 'react-icons/md'
import { RxHamburgerMenu } from 'react-icons/rx'
import { AiOutlineClose } from 'react-icons/ai'
import HamburgerMenu from './hamburger-menu'
import { useTheme } from 'next-themes';
import { useState, useEffect } from 'react';
export function Header() {
    const {theme, setTheme } = useTheme();
    const [mounted, setMounted] = useState(false);
    const [hamburger, setHamburger] = useState(false)
    useEffect(() => setMounted(true), []);
    if (!mounted) return null;
    return (
        <>
        <div className="flex mt-5 container mx-auto">
            <div className="md:min-w-[40%]">
            <Link href={'/'}>
                <img className="max-w-[300px]" src="/images/logo_KSE.png"/>
            </Link>
            </div>
            <div className="flex justify-between items-center w-full">
                    <Link href={'/'}>
                    <button 
                       className='
                      sm:hidden
                      max-sm:hidden
                      md:block
                        border
                      border-primary
                        text-primary
                        rounded-md
                        py-1 px-6
                        dark:text-white
                        dark:bg-primary

                        '>
                        Финансовый рынок KG
                    </button>
                    </Link>
                    <input className="border rounded-md py-1 px-2 sm:hidden
                      max-sm:hidden
                      md:block" placeholder='Поиск'/>
                    <select className="border">
                        <option className="bg-[url('/icons/russia.png')] ">RU</option>
                        <option>KG</option>
                        <option>ENG</option>
                    </select>
                    <button
                        className="w-8 h-8 rounded-lg text-2xl flex items-center justify-center hover:ring-2 ring-primary transition-all duration-300 focus:outline-none"
                        onClick={() => setTheme(theme === 'light' ? 'dark' : 'light')}
                        aria-label="Toggle Dark Mode"
                        >
                        {
                        theme === 'light' ? (<MdDarkMode/>) : (<CiLight/>)
                        }
                    </button>
                    <button className="border border-primary rounded-xl py-0.5 px-4">
                        <CiLogin className="text-primary text-3xl"/>
                    </button>
            </div>
        </div>
        <hr className="container mx-auto my-5"/>
        <div className="container mx-auto flex justify-between">
            <div className="flex w-auto overflow-auto whitespace-nowrap pb-2 py-1">
                <Link href={'/'} className="break-normal mr-2">О Бирже</Link>
                <Link href={'/'} className="break-normal mx-2">Листинг</Link>
                <Link href={'/'} className="break-normal mx-2 overflow-x-auto">Статистика торгов</Link>
                <Link href={'/'} className="break-normal mx-2">Котировки по ЦБ</Link>
                <Link href={'/'} className="break-normal mx-2">Центр раскрытия информации</Link>
                <Link href={'/'} className="break-normal mx-2">Контакты</Link>
            </div>
            <div className="ml-5">
                <button className="flex text-2xl" onClick={() => setHamburger(hamburger ? false : true)}>
                    {
                    hamburger ?
                    <AiOutlineClose/> 
                    :
                    <RxHamburgerMenu/>
                    }
                </button>
            </div>
        </div>
        {hamburger ? <HamburgerMenu/> : null}
        </>
    )
}