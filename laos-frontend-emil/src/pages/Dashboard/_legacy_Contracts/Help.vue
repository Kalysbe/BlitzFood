<template>
<div>
    <p>top: {{ $t("message") }}</p>
    <div class="md-layout-item md-size-100 md-gutter">
        <md-card> 
            <p>{{ $t("language") }}</p>
            <p v-if="$te('language')">{{ $t('language') }}</p>
            <p v-else>NO....</p>
            <div class="md-layout-item md-size-15">
                <md-field>
                    <label for="languages">Change Language</label>
                    <!-- label="item.value" -->
                    <!-- @md-selected="onLangChanged" -->
                    <md-select v-model="selectedLang" name="languages" id="languages" @md-selected="onLangChanged">
                        <md-option
                            v-for="item in languages"
                            :key="item.key"
                            label="item.value"
                            :value="item.key"
                            
                        >
                            {{ item.value }}
                        </md-option>
                    </md-select>
                </md-field>
            </div>
        </md-card>
        <md-card>
            <md-card-content>
                <h3>HELP Swagger Docs</h3>
                <pre>{{docs}}</pre>
            </md-card-content>
        </md-card>
    </div>
</div>
</template>
<script>

// import {ReportTable} from '@/components/viewReport'
export default {
    name: 'help',
    props: {domain: {type: String}},
    data() {
        return {
            docs: [],
            selectedLang: null,
            current_lang: null,
            languages: [
                {
                    key: "en", 
                    value: "en"
                },
                {
                    key: "la", 
                    value: "la"
                }
            ]
        }
    },
    computed: {
        lang(){
            return localStorage.getItem('lang') || 'en'
        }
    },
    methods: {
        onLangChanged(){
            console.log("Lang changed", this.selectedLang)
            localStorage.setItem("lang", this.selectedLang)
            window.location.reload
            this.current_lang = localStorage.getItem("lang")
            // console.log("Current lang changed", this.lang)
            // this.$i18n.locale = "en"
            this.$i18n.locale = this.current_lang 
            // this.$i18n.locale = localStorage.getItem("lang").toString()
            console.log("this.$i18n.locale = ", this.$i18n.locale)
        }
    },
    async mounted() {
        this.docs = await this.$store.dispatch('LOAD_SWAGGER_DOCS', this.domain)
        // this.docs = await this.$store.dispatch('LOAD_CONTRACT_DATA_REPORT', this.domain)
        // console.log("HELP-DATA:", this.regtabledata.length)
    }
    
}
</script>
