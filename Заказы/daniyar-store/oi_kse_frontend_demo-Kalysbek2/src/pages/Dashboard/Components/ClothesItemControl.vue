<template>
    <div  class="md-layout">
        <!-- <div class="" style="
        border:1px solid #aaa;
        margin:0 5px
        ">
        
            <h4>{{ data.name }}</h4>
            <span>{{ data.price }}</span>
            <span>{{ data.type }}</span>
            <span>{{ data.subcategory }}</span>
            <span>{{ data.id }}</span>
        </div> -->
        <div class="bg-white group cursor-pointer rounded-xl border p-3 space-y-4" style="border:1px solid red;margin:0 5px;">
            <div class="aspect-square rounded-xl bg-gray-100 relative">
                <img alt="" loading="lazy" decoding="async" data-nimg="fill" class="aspect-square object-cover rounded-md" style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" sizes="100vw" 
                
                src="">
                <div class="opacity-0 group-hover:opacity-100 transition absolute w-full px-6 bottom-5">
                    <div class="flex gap-x-6 justify-center">
                        <button class="rounded-full flex items-center justify-center bg-white border shadow-md p-2 hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                                <path d="m21 21-6-6m6 6v-4.8m0 4.8h-4.8"></path>
                                <path d="M3 16.2V21m0 0h4.8M3 21l6-6"></path>
                                <path d="M21 7.8V3m0 0h-4.8M21 3l-6 6"></path>
                                <path d="M3 7.8V3m0 0h4.8M3 3l6 6"></path>
                            </svg>
                        </button>
                        <button class="rounded-full flex items-center justify-center bg-white border shadow-md p-2 hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <p class="font-semibold text-lg">White Shirt</p>
                <p class="text-sm text-gray-500">Shirts</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="font-semibold">$59.00</div>
            </div>
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
    props: {
        data:Object
    },
   
  }
  </script>
  
  <style lang="scss" scoped>
 
  </style>
  