const data = [
    {
        id: 18560,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Первомайский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
    {
        id: 18561,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Первомайский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
    {
        id: 18562,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Свердловский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
    {
        id: 18563,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Октябрьский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
    {
        id: 18564,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Ленинский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    }
    ,
    {
        id: 18565,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Ленинский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
    {
        id: 18566,
        created_At: '2022-01-26T09:21:34.516513',
        side1_Name: 'Ленинский районный суд г.Бишкек',
        side1_Room: 'Зал №1',
        side2_Name: 'Исправительная колония №3 Чуйской области с. Новопокровка',
        side2_Room: 'Зал №1',
        side3_Name: null,
        side3_Room: null,
        side4_Name: null,
        side4_Room: null,
        date: '2022-02-01T00:00:00',
        start_Time: '13:30',
        end_Time: '14:30',
        case_Details: null,
        fullname: 'Бегалиев Тилек Ишеналиевич'
    },
]

const categories = Array.from(new Set(data.map(item => item.side1_Name)));
    const SelectOrder = document.getElementById('select-order');
    categories.forEach(category => {
    const count = data.filter(item => item.side1_Name === category).length;
    const Card = document.createElement('option');
    Card.value = category
    Card.innerHTML = category 
    
         
 
       
    

    SelectOrder.addEventListener('change', (e) => {
            if(e.target.value === 'Все заявки') {
                updateList(data)
            } else {
                const filteredItems = data.filter(item => item.side1_Name === e.target.value);
                updateList(filteredItems)
            }
     
    });
    SelectOrder.appendChild(Card);
    });








function updateList(newData) {
    const tableBody = document.getElementById('table')
    let predTr = document.querySelectorAll('.parse')
     predTr.forEach(item => {
        item.parentNode.removeChild(item)
     })
    for (let item of newData) {
       
        const row = document.createElement('tr');
        row.style.width = 100 + '%'
        row.classList.add('table-light','parse')
        row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.date.slice(0, 10)}</td>
                <td>${item.side1_Name} - ${item.side1_Room}</td>
                <td align="right">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="ViewDetails(${item.id})">
                   Открыть
                </button>
                </td>
                `;
        tableBody.appendChild(row);
    }


}
function ViewDetails(id) {
    const ModalBody = document.getElementById('modal-body')
    ModalBody.innerHTML = ''
    data.forEach(item => {

        if (item.id == id) {
           
            let body = `
         
            <div><b>Номер приказа: </b> ${item.id}</div>
            <div><b>Дата создания приказа: </b>${item.created_At.slice(0, 10)}</div>
       
                <div>
                    <b>Место проведения: </b>
                    ${item.side2_Name ? item.side2_Name + ' - ' : ''}  ${item.side2_Room ? item.side2_Room : ''}
                </div>
                <div>
                    ${item.side3_Name ? item.side3_Name + ' - ' : ''}  ${item.side3_Room ? item.side3_Room : ''}
                </div>
                <div>
                    ${item.side4_Name ? item.side4_Name + ' - ' : ''}  ${item.side4_Room ? item.side4_Room : ''}
                </div>
         

            <div><b>Дата:</b> ${item.date.slice(0, 10)}</div>
            <div><b>Начало:</b> ${item.start_Time}</span>   
            <div><b>Конец:</b> ${item.end_Time}</div>       
        </div>
        <span>
        ${item.case_Details ? item.case_Details : ''}    
        <span>
        <div>
        <span><b>Ф И О:</b> ${item.fullname}</span>    
        </div>    
        </div>
            `
            ModalBody.insertAdjacentHTML('afterbegin', body)
        }
    })


 
}


updateList(data)

const key = "68909dc31ae0b122e1e951c4431a2dfe"
let message = ''
function pushMessageTelegram() {
    if (localStorage.getItem('lengthData') < data.length) {
        localStorage.setItem('lengthData', data.length)
        message = `Поступила новая заявка в ${data.at(-1).side1_Name} с номером: ${data.at(-1).id}`
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", `http://pushmebot.ru/send?key=${key}&message=${message}`, true)
        xhttp.send()
        updateList(data)
    }
    else if (localStorage.getItem('lengthData') > data.length) {
        localStorage.setItem('lengthData', data.length)
        updateList(data)
    }
}
setInterval(pushMessageTelegram, 5000)
