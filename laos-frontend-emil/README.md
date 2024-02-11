# RAMS FRONTEND

## Installation

To install a local copy of the project, the following steps are required:

- Install Vue.js at least version 2.x;
- Install packages npm (>=6.4.1)
- Go to project folder and install dependencies: `npm install`;
- If you want to start the test server, then run: `npm run serve`;
- If you want to build, then run: `npm run build`;

You should put an environment file ".env.local" in the project root folder.

This file should contain the project constant:

    VUE_APP_BACK_SERVER='https://<"URL_TO_BACKEND">'

This constant is required for Axios (/api)

`const {VUE_APP_BACK_SERVER: API_ROOT} = process.env`

## Documentation

> See [RAMS menu and modules](./README_RAMS.md).

> See [Vue Material Dashboard PRO Documentation](./README_VMD.md).
