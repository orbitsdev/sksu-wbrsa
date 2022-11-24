







<template>
    <div class="mx-auto bg-red-200">

                    
                    <BaseTableSpinner v-if="isLoading"/>
            <table class="tble w-100 " >
                <thead class="th">
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-5 "> No .</th>
                        <th class="px-4 py-2 "> School </th>
                        <th class="px-4 py-2 "> Address</th>
                        <th class="px-4 py-2 "> Images</th>
                        <th class="px-4 py-2 "> </th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(school , index) in schools" :key="school.id">
                        <td class="px-4 py-2 border"> {{ index+=1 }}</td>
                        <td class="px-4 py-2 border"> {{ school.name }}</td>
                        <td class="px-4 py-2 border"> {{ school.address }}</td>
                        <td class="px-4 py-2 border"> {{ school.name }}</td>
                        <td class="px-4 py-2 border"> <slot :school="school"></slot></td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script>
import BaseTableSpinner from '../../../components/BaseTableSpinner.vue';
    export default {

        components: {
           BaseTableSpinner,
        },

        props: {
            schools:{
                type: Array,
                required:false,
                default: [],
            },
            isLoading: {
                type: Boolean,
                default: false,
                required: false,

            }
        }

        
    }
</script>

<style scoped>


.th{
    background: rgb(235, 236, 240);
}
.table-bordered{
    width: 100%;
}

div{
    transition: all 0.3s ease-in;
    position: relative;

}


</style>