import {en, la, report} from "@/locales/i18n.report";
const mapKey = {}
report.missingKeys.forEach(item => {
    const _val = item.path.split(".")
    const val = [_val.shift(), _val.join('|')]

    const enVal = en[val[0]] && en[val[0]][val[1]] ? en[val[0]][val[1]] : ""
    const laVal = la[val[0]] && la[val[0]][val[1]] ? la[val[0]][val[1]] : ""

    mapKey[item.path] = {category: val[0], key: val[1], en: enVal, la: laVal}
})

const data = Object.keys(mapKey).map(val => mapKey[val])
console.log({data})
//Desired headers in the .csv. Other fields are ignored
let headers = ["category", "key", "en", 'la']
const seperator = ",";

//Prepare csv with a header row and our data
const csv = [headers.join(seperator),
    ...data.map(row => headers.map(field => `${row[field]}`).join(seperator))
]

//Export our csv in rows to a csv file
let csvContent = "data:text/csv;charset=utf-8,"
    + csv.join("\n");
var encodedUri = encodeURI(csvContent);
window.open(encodedUri);

this.refreshDashboard()