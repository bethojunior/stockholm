<style scoped>

</style>

<template>
    <div class="card">

        <div class="row col-lg-12 pt-3 pb-3">

            <div class="form-group col-lg-4 col-sm-12">
                <label for="">Selecione o produto</label>
                <select v-model="product_id" class="form-control" name="" id="">
                    <option v-for="product in products" :value="product.id">{{ product.name }}</option>
                </select>
            </div>

            <div class="form-group col-lg-4 col-sm-12">
                <label for="">Quantidade</label>
                <input v-model="amount" class="form-control" type="number"/>
            </div>

            <div class="col-lg-12 col-sm-12">
                <button @click="create" class="btn btn-success col-sm-12 col-lg-1">Salvar</button>
            </div>

        </div>
    </div>
</template>


<script>
export default {

    name: 'CreateStockComponent',

    props: ['logged', 'token', 'products'],

    data(){
        return{
            'products' : this.products,
            'product_id' : null,
            'amount' : null
        }
    },

    mounted() {
    },

    methods: {

        create(){

            let params = {};

            params.amount = this.amount;
            params.product_id = this.product_id;

            const URL = '/api/stock';

            axios.post(URL, params, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.$swal.fire('Produto criado com sucesso', params.name + ' foi criado', 'success');
            })
            .catch(error => {
                this.$swal.fire('Erro ao criar produto', 'Contate o suporte', 'error')
            });

        }
    }
}
</script>
