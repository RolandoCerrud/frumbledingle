<template>
     
    <div>
         <!-- Modal Update Locations-->
        <div class="modal" :class="{showmodal:show_modal}"> 
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Location</h4>
                <button type="button" class="close" @click="closeModal()">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <label for="name">LocationName</label>
                <input v-model="location.name" type="text"  class="form-control" id="name">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="updateLocations()">Save</button>
                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
            </div>

            </div>
        </div>
        </div>
        <form @submit.prevent="createLocation">
            <div class="create-location-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nombre</span>
                </div>
                <input v-model="newLocationName" type="text" class="form-control" placeholder="Location Name" />
                <div class="input-group-append">
                    <button class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Nombre</th>
                <th></th>
            </thead>
            <tbody>
                <tr v-for="row in locations" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td align="center"><button class="btn btn-primary btn-sm" @click="openModal(row)" ><i class="fa fa-pencil" /> Edit</button><button class="btn btn-danger btn-sm" @click.prevent="deleteLocation(row.id)"><i class="fa fa-times" /> Delete</button></td>
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
            locations: [],
            newLocationName: '',
            show_modal: 0,
            id:0,
            location:{
                name:'',
            },
        };
    },
    mounted() {
        this.getLocations();
    },
    methods: {
        getLocations() {
            return axios.get('/api/locations')
                .then(response => {
                    this.locations = response.data;
                }).catch(console.error);
        },
        createLocation() {
            return axios.post('/api/locations', {name: this.newLocationName})
                .then(this.getLocations)
                .then(() => this.newLocationName = '')
                .catch(console.error);
        },
        deleteLocation(id) {
            return axios.post('/api/locations/' + id, {_method: 'DELETE'})
                .then(this.getLocations)
                .catch(console.error);
        },
        openModal(data={}){
            this.show_modal=1;
            this.id = data.id;
            this.location.name = data.name;
        },
        closeModal(){
            this.show_modal=0;
        },
        updateLocations() {
            return axios.put('/api/locations/'+this.id, this.location)
                .then(this.getLocations)
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
.create-location-form {
    margin-bottom: 10px;
}
</style>