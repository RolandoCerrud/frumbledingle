<template>
    <div>
        <!-- Modal Update Categories-->
        <div class="modal" :class="{showmodal:show_modal}"> 
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Category</h4>
                <button type="button" class="close" @click="closeModal()">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <label for="name">Category Name</label>
                <input v-model="category.name" type="text"  class="form-control" id="name">
                <label for="parent">Parent Category</label>
                <select class="form-control" v-model="category.parent_id" >
                    <option disabled value="">Choose Parent Category(Optional)</option>
                    <option v-for="option in categories" :key="option.id" :value="option.id">{{ option.name }}</option>
                </select>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="updateCategories()">Save</button>
                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
            </div>

            </div>
        </div>
        </div>
        <form @submit.prevent="createCategories">
            <div class="create-category-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input v-model="newCategoryName" type="text" class="form-control" placeholder="New category name" />
                <select class="form-control" v-model="newCategoryParent">
                    <option disabled value="0">Choose Parent Category(Optional)</option>
                    <option v-for="option in categories" :key="option.id" :value="option.id">{{ option.name }}</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th>ParentID</th>
                <th></th>
            </thead>
            <tbody>
                 <tr v-for="(row, index) in categories" :key="index">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.parents['name']}}</td>
                    <td align="center"><button class="btn btn-primary btn-sm" @click="openModal(row)" ><i class="fa fa-pencil" /> Edit</button><button class="btn btn-danger btn-sm" @click.prevent="deleteCategories(row.id)"><i class="fa fa-times" /> Delete</button></td>
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
            categories: [],
            newCategoryName: '',
            newCategoryParent:'0',
            show_modal: 0,
            id:0,
            category:{
                name:'',
                parent_id:'',
            },
        };
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            return axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                }).catch(console.error);
        },
        createCategories() {
            return axios.post('/api/categories', {name: this.newCategoryName, parent_id: this.newCategoryParent})
                .then(this.getCategories)
                .then(() => this.newCategoryName = '')
                .catch(console.error);
        },
        deleteCategories(id) {
            return axios.post('/api/categories/' + id, {_method: 'DELETE'})
                .then(this.getCategories)
                .catch(console.error);
        },
        openModal(data={}){
            this.show_modal=1;
            this.id = data.id;
            this.category.name = data.name;
            this.category.parent_id = data.parent_id;
        },
        closeModal(){
            this.show_modal=0;
        },
        updateCategories() {
            return axios.put('/api/categories/'+this.id, this.category)
                .then(this.getCategories)
                .then(this.closeModal)
                .catch(console.error);
        },
    }
}
</script>

<style>
.showmodal{
    opacity: 1;
    display: list-item;
    background: gray;
}

.create-category-form {
    margin-bottom: 10px;
}
</style>