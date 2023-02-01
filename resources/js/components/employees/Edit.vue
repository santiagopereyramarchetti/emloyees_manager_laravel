<template>
    <div>
        <h1 class="mt-4">Employees</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Update
                        <router-link :to="{'name': 'EmployeesIndex'}" class="float-end">Back</router-link>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="updateEmployee">
                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>
                                <div class="col-md-6">
                                    <input v-model="form.first_name" id="first_name" type="text" class="form-control" name="first_name" required autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-end">Middle Name</label>
                                <div class="col-md-6">
                                    <input v-model="form.middle_name" id="middle_name" type="text" class="form-control" name="middle_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>
                                <div class="col-md-6">
                                    <input v-model="form.last_name" id="last_name" type="text" class="form-control" name="last_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                                <div class="col-md-6">
                                    <input v-model="form.address" id="address" type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="country" class="col-md-4 col-form-label text-md-end">Country</label>

                                <div class="col-md-6">
                                    <select v-model="form.country_id" @change="getStates()" id="country" class="form-select" name="country" required aria-label="Default select example">
                                        <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="state" class="col-md-4 col-form-label text-md-end">State</label>

                                <div class="col-md-6">
                                    <select v-model="form.state_id" @change="getCities()" class="form-select" name="state" required aria-label="Default select example">
                                        <option v-for="state in states" :key="state.id" :value="state.id">{{ state.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

                                <div class="col-md-6">
                                    <select v-model="form.city_id" id="city" class="form-select" name="city" required aria-label="Default select example">
                                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deparment" class="col-md-4 col-form-label text-md-end">Deparment</label>

                                <div class="col-md-6">
                                    <select v-model="form.deparment_id" id="deparment" class="form-select" name="deparment" required aria-label="Default select example">
                                        <option v-for="deparment in deparments" :key="deparment.id" :value="deparment.id">{{ deparment.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="zip_code" class="col-md-4 col-form-label text-md-end">Zip Code</label>
                                <div class="col-md-6">
                                    <input v-model="form.zip_code" id="zip_code" type="text" class="form-control" name="zip_code" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-md-4 col-form-label text-md-end">Birthday</label>
                                <div class="col-md-6">
                                    <Datepicker v-model="form.birthdate" class=""></Datepicker>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-md-4 col-form-label text-md-end">Date Hired</label>
                                <div class="col-md-6">
                                    <Datepicker v-model="form.date_hired" class=""></Datepicker>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</template>

<script>
    import Datepicker from '@vuepic/vue-datepicker';
    import moment from 'moment'

    export default {
        components: { 
            Datepicker 
        },
        data(){
            return{
                countries: [],
                states: [],
                cities: [],
                deparments: [],
                form:{
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    address: '',
                    country_id: '',
                    state_id: '',
                    city_id: '',
                    deparment_id: '',
                    zip_code: '',
                    birthdate: null,
                    date_hired: null,
                }
            }
        },
        created(){
            this.getEmployee()
            this.getCountries()
            this.getDeparments()
        },
        methods:{
            getEmployee(){
                axios.get('/api/employees/' + this.$route.params.id)
                    .then( res => {
                        this.form = res.data.data
                        this.getStates()
                        this.getCities()
                    })
                    .catch( error => {
                        console.log(error)
                    })              
            },
            getCountries(){
                axios.get('/api/employees/countries')
                    .then( res => {
                        this.countries = res.data
                    })
                    .catch( error => {
                        console.log(error)
                    })
            },
            getStates(){
                axios.get('/api/employees/'+ this.form.country_id + '/states')
                    .then( resp => {
                        this.states = resp.data
                    })
                    .catch( error => {
                        console.log(error)
                    })
            },
            getCities(){
                axios.get('/api/employees/'+ this.form.state_id + '/cities')
                    .then( resp => {
                        this.cities = resp.data
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
            updateEmployee(){
                axios.put('/api/employees/' + this.$route.params.id, {
                    'first_name': this.form.first_name,
                    'middle_name': this.form.middle_name,
                    'last_name': this.form.last_name,
                    'address': this.form.address,
                    'country_id': this.form.country_id,
                    'state_id': this.form.state_id,
                    'city_id': this.form.city_id,
                    'deparment_id': this.form.deparment_id,
                    'zip_code': this.form.zip_code,
                    'birthdate': this.format_date(this.form.birthdate),
                    'date_hired': this.format_date(this.form.date_hired)
                })
                .then( res => {
                    this.$router.push({'name': 'EmployeesIndex'})
                })
                .catch( error => {
                    console.log(error)
                })
            },
            format_date(value){
                if(value){
                    return moment(String(value)).format('YYYYMMDD')
                }
            }
        }
    }
</script>

<style>

</style>