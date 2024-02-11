<template>
  <footer class="footer">
    <div class="container">
      <nav>
        <ul>
          <li>
            <router-link :to="'/' + $i18n.locale + '/' + `dashboard/home`">Центр раскрытия информации </router-link>
          </li>
        </ul>
      </nav>
      <div class="copyright text-center">
        &copy; {{ new Date().getFullYear() }}
        <a href="https://www.kse.kg/" target="_blank">
          Kyrgyz Stock Exchange
        </a>
      </div>
    </div>
  </footer>
</template>
<script>
export default {}
</script>
<style></style>
