<template>
    <md-dialog :md-active.sync="showDialog" md-fullscreen>
    <md-dialog-title style="height:20px;font-family:phetsarath_ot;" :style="{'color': getTitleColor()}">{{ formTitle }}</md-dialog-title>
        <md-card>
            <md-card-content>
            <RoadPhotos :items="urls"></RoadPhotos>
            </md-card-content>

            <md-dialog-actions>
                <md-button class="md-blue" @click.native="closeForm">{{ $t('contract.close') }}</md-button>
            </md-dialog-actions>
        </md-card>
    </md-dialog>
</template>

<script>
    import {mapActions, mapState} from 'vuex'
    import RoadPhotos from '@/components/_remove_ImageManager/CropGram.vue'
    export default {
        name: 'NewRoadPhoto',
        components: { RoadPhotos },
        props: ['showForm', 'urls'],
        computed: {
            ...mapState('Contract', [
                'show_new_roadphoto_form'
            ]),
            showDialog(){
                return this.show_new_roadphoto_form
            },
            formTitle () {
                return "Add/Remove Photos";
            },
        },
        watch: {
            
        },
        methods: {
            ...mapActions('Contract',[
                'showRoadPhotoForm'
            ]),
            getTitleColor() {
                return '#345DA6';
            },
            closeForm(){
                this.showRoadPhotoForm(false)
            },
        },
        mounted() {

        },
        create(){
            
        }
    }
</script>

<style lang="scss" scoped>
// here replace /deep/ by ::v-deep
    .md-dialog ::v-deep .md-dialog-container {
        max-width: 1800px;
        min-width: 700px;
        min-height: 380px;
    }
    .md-dialog-actions{
        margin-top:12px;
        margin-right:12px;
    }
    .cropper-wrapper{
        width: 100%;
    }
    .cp-view{
        height: 300px;
    }
    .cropper-container{
        width: 100%;
    }
    @media (min-width: 576px){
        .cropper-wrapper{
            width: auto;
        }

        .cp-view{
            width: 300px;
        }
    }

</style>