/** @type {import('next').NextConfig} */
const nextConfig = {
  experimental: {
    appDir: true,
  },
}
const withCSS = require('@zeit/next-css')
module.exports = withCSS()
module.exports = nextConfig
