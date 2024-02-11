export function TradingResults() {
    const data = [
        {id:0,icon:'/icons/Group 793.png',title:'Объем торгов',value:'2.4595',result:'436.8'},
        {id:1,icon:'/icons/Group 796.png',title:'Первичный',value:'2.4595',result:'1026.3'},
        {id:2,icon:'/icons/Group 797.png',title:'Вторичный',value:'2.4595',result:'32'},
        {id:3,icon:'/icons/Group 798.png',title:'Листинг',value:'2.4595',result:'32'},
        {id:4,icon:'/icons/Group 799.png',title:'Нелистинг',value:'2.4595',result:'376'}
    ]
    return (
        <div className="border border-[#E1E5E8] rounded-lg p-3">
                <span className="text-primary">Итоги торгов за 10.1.2023</span>
                <div className="flex">
                    <span className="w-[40%]"></span>
                    <span className="w-[30%] text-center">Млн.сом</span>
                    <span className="w-[20%] text-center">%</span>
                </div>
                <div>
                {data.map((item,index) => (
                     <div key={item.id} className="flex items-center mb-3">
                        <div className="flex items-center w-[40%]">
                            <span>{item.title}</span>
                        </div>
                        <div className="w-[30%] text-center">
                           <span>{item.value}</span> 
                        </div>
                        <div className="flex justify-center items-center w-[20%]">
                                <img src='icons/Vector.png' className="mr-1"/>
                                <span>{item.result}</span>
                        </div>
                     </div>
                ))}
                </div>
        </div>
    )
}