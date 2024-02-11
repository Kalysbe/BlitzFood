const type_json = {'Content-Type': 'application/json'}
const type_form = {'Content-Type': 'application/x-www-form-urlencoded'}
const type_multipart_form = {'Content-Type': 'multipart/form-data'}

function encode(val) {
    return encodeURIComponent(val)
        .replace(/%3A/gi, ':')
        .replace(/%24/g, '$')
        .replace(/%2C/gi, ',')
        .replace(/%20/g, '+')
        .replace(/%5B/gi, '[')
        .replace(/%5D/gi, ']')
}

const paramsSerializer = function(params) {
    const parts = []
    Object.keys(params).forEach((item) => {
        let val = params[item]
        if (val === null || typeof val === 'undefined') {
            return
        }

        if (Array.isArray(val)) {
            item = item + ''
        } else {
            val = [val]
        }

        val.forEach((elem) => {
            if (elem instanceof Date && !isNaN(elem.valueOf())) {
                elem = elem.toISOString()
            } else if (typeof elem === 'object') {
                elem = JSON.stringify(elem)
            }

            parts.push(encode(item) + '=' + elem)
        })
    })

    return parts.join('&')
    // return a query string
}

export {paramsSerializer, type_json, type_form, type_multipart_form}