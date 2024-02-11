import { useState, useEffect } from 'react'
import { AiOutlineArrowRight, AiOutlineArrowLeft } from 'react-icons/ai'

export function Carousel() {
    const [items, setItems] = useState([
        { 
          id: 1, 
          src: '/images/carousel-img-1.jpeg', 
          alt: 'Image 1' ,
          title:'Товарно сырьевой сектор',
          text:'Объявляет о возобновление своей деятельности,находите новые сделки, новых партнёров!' ,
          button:'Посмотреть'
         },
        { id: 2,
          src: '/images/carousel-img-2.jpg', 
          alt: 'Image 2',
          title:'Open Information Service',
          text:'Встречайте обновленную версию сервиса, теперь подавать отчеты стало еще удобнее и приятнее!',
          button:'Посмотреть'
        },
      ])
    const [activeIndex, setActiveIndex] = useState(0)
    const [paused, setPaused] = useState(false)
    useEffect(() => {
      let interval
      if (!paused) {
        interval = setInterval(() => {
          setActiveIndex((activeIndex + 1) % items.length)
        }, 3000)
      }
      return () => clearInterval(interval)
    }, [paused, activeIndex]) 
    return (
        <div 
        onMouseEnter={() => setPaused(true)}
        onMouseLeave={() => setPaused(false)}>
  <div className="relative overflow-hidden  h-[400px] w-full">
    {items.map((item, index) => (
      <div key={item.id} className={`transition duration-500 ease-in-out ${index === activeIndex ? 'opacity-100 z-10' : 'opacity-0 z-0'}`}>
      <img
        src={item.src}
        alt={item.alt}
        className={`absolute inset-0 object-cover w-full h-full `}
      />
      <div className="absolute top-0 left-0 w-full h-full bg-littleTransparent z-20">
        <div className="mt-[5%] container mx-auto">
            <h2 className="text-primary font-sans text-3xl">
              {item.title}
            </h2>
            <p className="text-white not-italic max-w-[400px] my-4">
              {item.text}
            </p>
            {item.button ?
              <button className="text-white rounded-full py-1 px-10 bg-primary mt-2">
                {item.button}
              </button> : ''
            }
        </div>
      </div>
      </div>
    ))}
      <div className="absolute bottom-8 right-5 z-20">
      <button
          onClick={() => setActiveIndex((activeIndex + items.length - 1) % items.length)}
          className="mt-6 mr-1 ml-6 bg-lightTransparent text-white rounded-full shadow-md p-2">
            <AiOutlineArrowLeft/>
          </button>
          <button
            onClick={() => setActiveIndex((activeIndex + items.length + 1 )% items.length)}
            className="mt-6 ml-1 mr-6 bg-lightTransparent text-white rounded-full shadow-md p-2">
              <AiOutlineArrowRight/>
          </button>
      </div>  
      <div className="absolute bottom-8 left-0 right-0 mt-4 flex justify-center z-20">
    {items.map((item, index) => (
      <button
        key={item.id}
        onClick={() => setActiveIndex(index)}
        className={`w-4 h-2 duration-200 mx-1 rounded-full bg-gray-300 ${
          index === activeIndex ? 'bg-gray-900 w-8' : 'bg-gray-300'
        }`}
      />
    ))}
  </div>
  </div>
</div>
    )
}