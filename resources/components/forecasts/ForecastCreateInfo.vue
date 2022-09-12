<template>
    <div>
        <h3 class="text-center">Forecast Info</h3>
        <div>
            <span>No Forecast data</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>
                        Forecast - Company Name
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product</td>
                    <td>Billboard</td>
                </tr>
                <tr>
                    <td>Amount (RM)</td>
                    <td>50000</td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>A1</td>
                </tr>
                <tr>
                    <td>Forecast Date</td>
                    <td>2022-08-28</td>
                </tr>
            </tbody>
        </table>
    </div>

    <GoBack />
    <div>
        <h3 class="text-center">Create Forecast</h3>
        <GoBack />
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="createForecast">
                    <div class="form-group">
                        <label>Product</label>
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.product" @change="getProduct">
                            <option value="">Please select product</option>

                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.amount" />
                    </div>

                    <div class="form-group">
                        <label>Product</label>
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.forecast_type" @change="getType">
                            <option value="">Please select type</option>

                            <option v-for="forecast_type in types" :key="forecast_type.id" :value="forecast_type.id">
                                {{ forecast_type.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Forecast Date</label>
                        <input type="date"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.forecast_date" />
                    </div>


                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from '../utils/GoBack.vue';
export default {
    data() {
        return {
            form: {
                product: '',
                amount: '',
                forecast_type: '',
                forecast_date: '',
            },
        };
    },
    methods: {
        createForecast() {
            axios
                .post("/api/forecast/store", {
                    product: this.form.product,
                    amount: this.form.amount,
                    forecast_type: this.form.forecast_type,
                    forecast_date: this.form.forecast_date,
                })
                .then((res) => {
                    this.$router.push({ name: "forecast_index" });
                });
        },
    },
    components: { GoBack }
};
</script>