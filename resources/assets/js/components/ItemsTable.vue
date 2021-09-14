<template>
    <div>
         <!-- Modal Update Items-->
        <div class="modal" :class="{showmodal:show_modal}"> 
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Item</h4>
                <button type="button" class="close" @click="closeModal()">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <label for="name">Item Name</label>
                <input v-model="item.name" type="text"  class="form-control" id="name">
                <label for="name">Item Price</label>
                <input v-model="item.price" type="number" :min="0" class="form-control" id="price">
                <label for="parent">Item Category</label>
                <select class="form-control" v-model="item.category_id" >
                    <option disabled value="">Choose Category</option>
                    <option v-for="option3 in categories" :key="option3.id" :value="option3.id">{{ option3.name }}</option>
                </select>
                <label for="parent">Item Location</label>
                <select class="form-control" v-model="item.location_id" >
                    <option disabled value="">Choose Location</option>
                    <option v-for="option4 in locations" :key="option4.id" :value="option4.id">{{ option4.name }}</option>
                </select>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="updateItems()">Save</button>
                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
            </div>

            </div>
        </div>
        </div>
        <form @submit.prevent="createItems">
            <div class="create-location-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input v-model="newItemName" type="text" class="form-control" placeholder="Item Name" />
                <input v-model="newItemPrice" type="number" :min="0" class="form-control" placeholder="Item Price" />
                 <select class="form-control" v-model="newItemCategory" >
                    <option v-for="option1 in categories" :key="option1.id" :value="option1.id">{{ option1.name }}</option>
                </select>
                 <select class="form-control" v-model="newItemLocation" >
                    <option v-for="option2 in locations" :key="option2.id" :value="option2.id">{{ option2.name }}</option>
                </select>
                    <button class="btn btn-primary">Create</button>
                
            </div>
        </form>
         <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Category</th>
                <th></th>
            </thead>
            <tbody>
                <tr v-for="(row, index) in items" :key="index">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.locations['name']}}</td>
                    <td>{{ row.categories['name']}}</td>
                    <td align="center"><button class="btn btn-primary btn-sm" @click="openModal(row)" ><i class="fa fa-pencil" /> Edit</button><button class="btn btn-danger btn-sm" @click.prevent="deleteItems(row.id)"><i class="fa fa-times" /> Delete</button></td>
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
            items: [],
            locations: [],
            newItemName: '',
            newItemPrice: 0,
            newItemCategory: '',
            newItemLocation: '',
            show_modal: 0,
            id:0,
            item:{
                name:'',
                price:'',
                location_id:'',
                category_id:'',
            },
        };
    },
    mounted() {
        this.getItems();
        this.getLocations();
        this.getCategories();
    },
    methods: {
        getLocations() {
            return axios.get('/api/locations')
                .then(response => {
                    this.locations = response.data;
                }).catch(console.error);
        },
        getCategories() {
            return axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                }).catch(console.error);
        },
        getItems() {
            return axios.get('/api/items')
                .then(response => {
                    this.items = response.data;
                }).catch(console.error);
        },
        createItems() {
            if (!this.newItemCategory){ // is null or zero
            alert("Please select a category");
            }else if (!this.newItemLocation){ // is null or zero
            alert("Please select a location");
            }
            else
            {
            return axios.post('/api/items', {name: this.newItemName, price: this.newItemPrice, category: this.newItemCategory, location: this.newItemLocation})
                .then(this.getItems)
                .then(() => this.newItemName = '')
                .then(() => this.newItemPrice = '')
                .catch(console.error);
                }
        },
        deleteItems(id) {
            return axios.post('/api/items/' + id, {_method: 'DELETE'})
                .then(this.getItems)
                .catch(console.error);
        },
        openModal(data={}){
            this.show_modal=1;
            this.id = data.id;
            this.item.name = data.name;
            this.item.price = data.price;
            this.item.category_id = data.category_id;
            this.item.location_id = data.location_id;
        },
        closeModal(){
            this.show_modal=0;
        },
        updateItems() {
            return axios.put('/api/items/'+this.id, this.item)
                .then(this.getItems)
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