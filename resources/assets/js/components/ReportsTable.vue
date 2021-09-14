<template>
    <div>
        <form @submit.prevent="getReport">
            <div class="report-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Price</span>
                </div>
                <input v-model="price" type="text" class="form-control" placeholder="Set price for search" />
                <div class="input-group-append">
                    <button class="btn btn-primary">Generate</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>Location</th>
                <th>Parent Category</th>
                <th>Category</th>
                <th>Count</th>
            </thead>
            <tbody>
                <tr v-for="(row, index) in report" :key="index">
                    <td>{{ row.location }}</td>
                    <td>{{ row.parent }}</td>
                    <td>{{ row.category }}</td>
                    <td>{{ row.count }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            report: [],
            price: 0,
        };
    },
    mounted() {
        this.getReport();
    },
    methods: {
        getReport() {
            return axios.post('/api/report', {price: this.price})
                .then(response => {
                    this.report = response.data;
                }).catch(console.error);
        }
    }
}
</script>

<style>
.report-form {
    margin-bottom: 10px;
}
</style>