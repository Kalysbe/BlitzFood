<template>
    <div class="md-layout" >
        <div v-for="item in getClothes" :key="item.id">
            <clothes-item :data="item"></clothes-item>
        </div>
    </div>
   
  </template>
  
  <script>
  import {} from '@/components'
  import {Pagination} from '@/components'
  import {mapActions, mapGetters} from 'vuex'
  import ClothesItem from './ClothesItem.vue'
  export default {
    // name: 'MultipleSelect',
    name: 'TableSearch',
    components: {ClothesItem},
    props: {},
    data() {
      return {
        selectValue: [],
        limit: 15,
        page: 1,
        perPage: 1,
        searchQuery: this.$route.query.search,
        total: 0,
        companyArr: []
      }
    },
    computed: {
      ...mapGetters('clothes', [ 'getClothes'])
    },
    methods: {
      ...mapActions('clothes', ['GET_CLOTHES'])
    },
    async mounted() {
      //this.companyList(this.limit, this.page)
      
      //let search = this.$route.query.search
      if (this.getClothes.length == 0) {
        await this.GET_CLOTHES({
          limit: this.limit,
          page: 1
        })
      } else {
        this.page = +this.getPage
      }
      //this.page = +this.$route.query.page ? +this.$route.query.page : 1
      
      
      //if (search && search != '') this.searchCompany(search)
    },
    watch: {
      page: function (val) {
        let search = this.$route.query.search
        this.$router.push({query: {page: val, search}})
        //this.GET_COMPANY_LIST(this.limit, this.$route.query.page)
        if (search !== undefined && search != '') {
          this.SEARCH_COMPANY({
              search: search.toLowerCase(),
              page: +this.$route.query.page,
              limit: this.limit
            })
        } else {
          this.GET_CLOTHES({
              limit: this.limit,
              page: 1
            })
        }
      }
    }
  }
  </script>
  
  <style lang="scss" scoped>
  .listing-company {
    color: #42a5af;
  }
  .listing-company:hover {
    color: grey;
  }
  .title-list-company {
    font-size: 32px;
    color: #42a5af;
    margin: 0px;
    margin-bottom: 10px;
    padding: 0px;
  }
  .search-button {
     background: #d2d4d5;
     color: white;
     font-size: 16px;
     border: 1px solid #acafb2;
  }
  .pagination > .page-item.active > a {
    background-color: #42a5af;
  }
  .pagination > .page-item.active > a:hover {
    background-color: rgb(66, 165, 175, 0.9);
  }
  thead {
    background: rgb(210, 212, 213, 0.8);
  }
  </style>
  