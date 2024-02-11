import Link from 'next/link'
import Head from 'next/head'
import { MainLayout } from '../layout/MainLayout'


export default function Home() {

  const carouselItems = [
    {
      title:"Товарно-сырьевой сектор КФБ",
      text:"Объявляет о возобновление своей деятельности,находите новые сделки, новых партнёров!",
      button:"Посмотреть",
      img:"bg-[url('/images/carousel-img-1.jpg')]"
    },
    {
      title:"Товарно-сырьевой сектор КФБ",
      text:"Объявляет о возобновление своей деятельности,находите новые сделки, новых партнёров!",
      button:"Посмотреть",
      img:"bg-[url('/images/carousel-img-2.jpg')]"
    },
    {
      title:"Товарно-сырьевой сектор КФБ",
      text:"Объявляет о возобновление своей деятельности,находите новые сделки, новых партнёров!",
      button:"Посмотреть",
      img:"bg-[url('/images/carousel-img-3.jpg')]"
    },
  ]

  return (
      <MainLayout>
        <Head>
          <title>Next Title</title>
          <meta name="keywords" content="next"/>
          <meta charSet='utf-8'/>
        </Head>
        <div className="h-56 sm:h-64 xl:h-80 2xl:h-96">
        
        </div>
      </MainLayout>
  )
}
