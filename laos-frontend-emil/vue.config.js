const path = require('path')
const host = '0.0.0.0'
const port = 8082


module.exports = {
    devServer: {
        host: host,
        client: {
            webSocketURL: 'auto://0.0.0.0:8082/ws',
        },
        port: port,
        liveReload: false,
        allowedHosts: "all",
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept'
        }
    },
    css: {
        loaderOptions: {
            sass: {
                sassOptions: {
                    // quieted vue-material issues
                    // https://sass-lang.com/documentation/breaking-changes/slash-div
                    quietDeps: true
                }
            },
        },
    },
    pluginOptions: {
        i18n: {
            locale: 'en',
            fallbackLocale: 'en',
            localeDir: 'locales',
            enableInSFC: false,
            enableBridge: false
        }
    },
//   css: {
//     loaderOptions: {
//       sass: {
//         data: `@import "@/assets/scss/material-dashboard.scss";`
//       }
//     }
//   }
}
