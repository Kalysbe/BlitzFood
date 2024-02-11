
6.81  0.63  1.18  1.09 1.18 1.58 1.44 1.16 1.58 1.82 1.45 1.1 0.91 1.44 1.14 
24,51
55.44s 1.1 103s 1.16 103s 599s 95s 1.82 1.45 1.58 1.58 1.44 139s 96s 1.44 139s 126s 1.14 127s 0.91 160s 102s 100s 126s 79s 112s 127s 100s 99s 99s
13.62
// let arr = [
//     {
//         id:1,
//         summa:234150000,
//         doh: 14.98
//     },
//     {
//         id:2,
//         summa:686150000,
//         doh: 15.00
//     },
//     {
//         id:3,
//         summa:737034000,
//         doh: 16.00
//     },
//     {
//         id:4,
//         summa:837034000,
//         doh: 16.50
//     },
//     {
//         id:5,
//         summa:1137034000,
//         doh: 17.00
//     },
//     {
//         id:6,
//         summa:1437034000,
//         doh: 17.25
//     }
// ]

// const countArr = [];
// const newarr = [];
// for (t=0; t < arr.length;t++) {
//     newarr.push(
//         arr[0].doh*arr[0].summa
//     )
// }
// let count = newarr[0]
// for (let i =0; i < arr.length;i++) {
//     if(i > 0) {
//         count =+ (arr[i].summa-arr[i-1].summa)*arr[i].doh;
//     }
//     countArr.push(count)
// }
// for (let r = 1; r < arr.length;r++) {
//     newarr[r] = newarr[r-1] + countArr[r]
// }
// for ( let i = 0; i < arr.length;i++) {
//     console.log((Math.round(newarr[i]/arr[i].summa * 100)/100).toFixed(2))
// }

// const countArr = [];
// const newarr = [];
// let count = 0;
// let prevSum = 0;
// const firstVal = arr[0].doh * arr[0].summa;
// for (let i = 0; i < arr.length; i++) {
//     newarr.push(firstVal);
//     if (i > 0) {
//         count += (arr[i].summa - prevSum) * arr[i].doh;
//     }
//     countArr.push(count);
//     prevSum = arr[i].summa;
//     newarr[i] += countArr[i];
//     console.log(newarr[i])
//     console.log((Math.round(newarr[i] / arr[i].summa * 100) / 100).toFixed(2));
// }
let arr1 = [
    {
        id:1,
        type:'NeKonkurent',
        summa:77990000,
        doh: 7.55
    },
    {
        id:2,
        type:'Konkurent',
        summa:146700000,
        doh: 7.50
    },
    {
        id:3,
        type:'Konkurent',
        summa:686150000,
        doh: 15.00
    },
    {
        id:4,
        type:'Konkurent',
        summa:737034000,
        doh: 16.00
    },
    {
        id:5,
        type:'Konkurent',
        summa:837034000,
        doh: 16.50
    },
    {
        id:6,
        type:'Konkurent',
        summa:1137034000,
        doh: 17.00
    },
    {
        id:7,
        type:'Konkurent',
        summa:1437034000,
        doh: 17.25
    }
]
const arrKonkurent = [];
const arrNeKonkurent = [];

for (let i =0; i < arr1.length; i++) {
   if( arr1[i].type == 'NeKonkurent') {
    arr1[i]['doh2'] = arr1[i].doh
    arrNeKonkurent.push(arr1[i])
   } else {
    arrKonkurent.push(arr1[i])
   }
}
let arr = arrKonkurent
const newarr = [];
let count = 0;
let prevSum = 0;
const firstVal = arr[0].doh * arr[0].summa;

arr.forEach((item, i) => {
    newarr.push(firstVal);
    if (i > 0) {
        count += (item.summa - prevSum) * item.doh;
    }
    prevSum = item.summa;
    newarr[i] += count;
    item['doh2'] = (Math.round(newarr[i] / arr[i].summa * 100)/100).toFixed(2)
});

arr = [...arrNeKonkurent,...arr]




