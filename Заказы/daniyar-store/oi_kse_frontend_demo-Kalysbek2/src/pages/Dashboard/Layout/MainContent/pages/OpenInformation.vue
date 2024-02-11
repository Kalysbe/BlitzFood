<template>
  <div  class="md-layout">
    <div class="md-layout md-layout-item md-size-100">
      <md-card class="md-card-plain">

          <div style="width: 100%; padding: 20px 0">
              <h1 class="title-list-company">{{$t('pageOpenInfo.title')}}</h1>
            <md-field style="font-size: 24px">
              <label style="font-size: 16px">{{$t('pageOpenInfo.placeholderSearch')}}</label>
              <md-input
                v-on:keyup.enter="searchCompany()"
                v-model="searchQuery"
              ></md-input>
              <button
              class="search-button">
                <md-icon class="material-icons" style="color: white">
                  search
                </md-icon>
              </button>
            </md-field>
          </div>
          <pagination
            class="pagination-no-border"
            style="color: green"
            v-model="page"
            :per-page="perPage"
            :total="getTotalCompany"
          ></pagination>
      
        <md-card-content style="padding-top: 0px; padding-left: 0px">
          <md-table v-model="getCompanyList">
            <md-table-row 
              class="md-info listing-company"
              slot="md-table-row"
              slot-scope="{item}"
              md-selectable="single"
              @click.native="viewСompany(item.kod)">
              <template v-if="item.opforma.length"> 
              <md-table-cell class="md-info" :md-label="$t('pageOpenInfo.tableLabel1')" md-sort-by="code" style="width:10%;">
                {{ item.symbol }} 
              </md-table-cell>
              <md-table-cell class="md-info" :md-label="$t('pageOpenInfo.tableLabel2')">
                {{ item.name }}
              </md-table-cell>
              </template>
            </md-table-row>
          </md-table>
        </md-card-content>

        <md-card-actions md-alignment="space-between">
          <pagination
            class="pagination-no-border"
            style="color: green"
            v-model="page"
            :per-page="perPage"
            :total="getTotalCompany">
          </pagination>
        </md-card-actions>
      </md-card>
    </div>
  </div>
</template>

<script>
import {} from '@/components'
import {Pagination} from '@/components'
import {mapActions, mapGetters} from 'vuex'
export default {
  // name: 'MultipleSelect',
  name: 'TableSearch',
  components: {Pagination},
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
    ...mapGetters('company', ['getSearchResult', 'getCompanyList', 'getTotalCompany', 'getPage']),
  },
  methods: {
    ...mapActions('company', ['GET_COMPANY_LIST', 'SEARCH_COMPANY']),
    viewСompany(kod) {
      this.$router.push({path: '/' + this.$i18n.locale + '/openinformation/company/' + kod})
    },
    searchCompany(search = '') {
      search = this.searchQuery
      this.$router.push({query: {page: 1, search}})
      this.SEARCH_COMPANY({
          search: search.toLowerCase(),
          page: 1,
          limit: this.limit
        })
    }
  },
  async mounted() {
    //this.companyList(this.limit, this.page)
    
    //let search = this.$route.query.search
    if (this.getCompanyList.length == 0) {
      await this.GET_COMPANY_LIST({
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
        this.GET_COMPANY_LIST({
            limit: this.limit,
            page: +this.$route.query.page
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
