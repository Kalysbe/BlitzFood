# [ROAD ASSET MANAGEMENT SYSTEM](https://sirway.fi)

![version](https://img.shields.io/badge/version-1.1-blue.svg)

## Table of Contents

- [File Structure](#file-structure)
- [Technical Support or Questions](#technical-support-or-questions)
- [Social Media](#social-media)

## Menu and File Structure

```
MENU
├── Dashboard (/pages/Dashboard/Dashboard.vue)
│   └── DashboardPanel (/components/DashboardPanel)
│       └── ChartistPlugin (/components/ChartistPlugin)
├── WebGis (/pages/Dashboard/Maps/Country.vue)
│   ├── OlMap (/components/OlMap)
│   │   ├── chartistBackgroundPlugin (/components/OlMap/chartistBackgroundPlugin)
│   │   ├── chartistLabelPlugin (/components/OlMap/chartistLabelPlugin)
│   │   ├── helper (/components/OlMap/helper.js)
│   │   ├── olMap (/components/OlMap/olMap.js)
│   │   └── popups (/components/OlMap/popups)
│   ├── FilterBox (/components/FilterBox)
│   └── RoadDetails (/components/OlMap/road-details)
├── Reports (/pages/Dashboard/Reports)
│   └── ReportTable (/components/viewReport)
└── Localisation (/pages/Dashboard/translate)
    └──TranslateProfileForm (/pages/Dashboard/translate/translateProfileForm)

APP STATE AND REQUEST TO BACKEND
└── Vuex (/store)
    └── Actions 
        └── Axios (/api)

APP ROUTE MAP
└── VueRouter (/routes)

APP LOCALISATION
└── i18n (/i18n.js) 
    └── messages (/store/i18n/messages/) and downloading from backend
```

## Technical-support-or-questions

If you have questions or need help integrating the product please [contact us](https://www.sirway.fi/#section-8) instead of opening an issue.

## Social Media

Twitter: <https://twitter.com/Sirway_Ltd>

Facebook: <https://www.facebook.com/sirwayltd/>

Instagram: <https://www.instagram.com/sirway_ltd/>
