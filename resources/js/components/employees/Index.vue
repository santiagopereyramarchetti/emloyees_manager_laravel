<template>
    
    <div>
        <h1 class="mt-4">Employees</h1>
        <div class="card p-0">
            <div>
                <div v-if="showMessage" class="alert alert-success">
                    {{ message }}
                </div>
            </div>
            <div class="card-header">
                <form class="row gy-2 gx-3 align-items-center d-inline-flex">
                    <div class="col-auto">
                        <label class="visually-hidden" for="autoSizingInput">Search</label>
                        <input v-model.lazy="search" type="search" name="search" class="form-control" id="autoSizingInput" placeholder="Name or Code">
                    </div>
                    <div class="col-auto">
                        <select v-model="selectedDeparment" id="deparment" class="form-select" name="deparment" required aria-label="Default select example">
                            <option v-for="deparment in deparments" :key="deparment.id" :value="deparment.id">{{ deparment.name }}</option>
                        </select>
                    </div>
                </form>
                <router-link :to="{name: 'EmployeesCreate'}" class="btn btn-primary float-end">Create</router-link>
            </div>
            <div class="card-body">
                <table class="table table-light table-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Department</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in employees" :key="employee.id">
                            <th scope="row">{{ employee.id }}</th>
                            <td>{{ employee.first_name }}</td>
                            <td>{{ employee.last_name }}</td>
                            <td>{{ employee.address }}</td>
                            <td>{{ employee.deparment }}</td>
                            <td>
                                <router-link :to="{'name': 'EmployeesEdit', 'params': { 'id' : employee.id }}" class="btn btn-success me-2">Edit</router-link>
                                <button class="btn btn-danger" @click="deleteEmployee(employee.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
        

</template>

<script>
    export default{
        data(){
            return {
                employees: [],
                deparments: [],
                showMessage: false,
                message: '',
                search: null,
                selectedDeparment: null,
            }
        },
        created(){
            this.getEmployees()
            this.getDeparments()
        },
        watch: {
            search(){
                this.getEmployees()
            },
            selectedDeparment(){
                this.getEmployees()
            }
        },
        methods:{
            getEmployees(){
                axios.get('/api/employees', {params: {
                    search: this.search,
                    deparment_id: this.selectedDeparment
                }})
                    .then( res => {
                        this.employees = res.data.data
                    })
                    .catch( error => {
                        console.log(error)
                    })
            },
            getDeparments(){
                axios.get('/api/employees/deparments')
                    .then( resp => {
                        this.deparments = resp.data
                    })
                    .catch( error => {
                        console.log(error)
                    })
            },
            deleteEmployee(id){
                axios.delete('/api/employees/' + id)
                    .then( res => {
                        this.message = res.data
                        this.showMessage = true
                        this.getEployees()
                    })
                    .catch( error => {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style>

</style>