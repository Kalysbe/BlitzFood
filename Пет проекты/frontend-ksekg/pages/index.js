import Link from 'next/link'
import Head from 'next/head'
import dynamic from 'next/dynamic';

import { MainLayout } from '../components/MainLayout'
import { Carousel } from '../components/Carousel/Carousel'
import { TradingResults } from '../components/TradingResults/TradingResults'
import { Indices } from '../components/Indices/Indices'
import { NewsList } from '../components/News/News-List'
import { AuctionTable } from '../components/Auction/auction-table'
// elements
import { BlackTitle } from '../components/elements/black-title'
import { PrimaryTitle } from '../components/elements/primary-title'

const IndexChart = dynamic(() => import('../components/IndexChart/IndexChart'), { ssr: false });
const CapitalizationChart = dynamic(() => import('../components/CapitalizationChart/CapitalizationChart'), {ssr: false});
export default function Home() {
  return (
      <MainLayout>
        <Head>
          <title>Next Title</title>
          <meta name="keywords" content="next"/>
          <meta charSet='utf-8'/>
        </Head>
        <main className="w-full">
          
        <Carousel/>
      <div className="container mx-auto h-[400px] mt-5 flex ">
          <div className="w-[50%] mr-1 flex flex-col justify-between">
            <TradingResults/>
            <Indices/>
          </div>
          <div className="w-[50%] ml-1 flex flex-col">
            <div className="h-[240px] mb-4 border border-[#E1E5E8] p-3 rounded-lg">
              <span className="text-primary block">Индекс</span>
              <IndexChart/>
            </div>
            <div className="h-[240px] border border-[#E1E5E8] p-3 rounded-lg">
              <span className="text-primary">Капитализация</span>
              <CapitalizationChart/>
            </div>
          </div>
          </div>
          <div className="container mx-auto mt-7">
            <BlackTitle title="Новости"/>
            <div className="flex justify-between">
              <div className="mr-4">
                  <PrimaryTitle title="Новости биржи:"/>
                  <NewsList/>
              </div>
              <div className="ml-4">
                  <PrimaryTitle title="Новости сайта:"/>
                  <NewsList/>
              </div>
            </div>
          </div>
          <div className="container mx-auto mt-10">
            <BlackTitle title="Расписание аукционов ГЦБ на декабрь 2022 года"/>
            <div className="flex flex-wrap">
             <AuctionTable />
            </div>
          </div>
        </main>
      </MainLayout>
  )

  
}


