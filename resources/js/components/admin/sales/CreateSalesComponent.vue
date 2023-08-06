<style scoped>
    #my-items{
        position: fixed;
        bottom: 0;
        right: 0;
        margin: 2vw;
        border-radius: 20vw;
        height: 5vh;
    }
</style>
<template>
    <div class="row col-lg-12 col-sm-12">
        <input type="text" class="form-control mt-1 mb-1" placeholder="Buscar produto">
        <div v-for="product in products" class="card pt-2 pb-2">
            <div class="col-lg-12 col-sm-8">
                <span>{{ product.name }}</span><br>
                <span>Em estoque: {{ product.amount.amount }}</span><br>
                <span>{{ product.description }}</span><br>
                <span>Valor: <b>R${{ product.value }}</b></span><br>
            </div>
            <div class="col-lg-12 col-sm-4">
                <img class="col-lg-12 col-sm-12" :src="this.pathImage() + product.image" alt="">
            </div>
            <div class="drp-buttons">
                <button @click="addToBag(product)" class="btn btn-success">Adicionar a sacola</button>
            </div>
        </div>
    </div>
    <button id="my-items" class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-my-products">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
        </svg>
    </button>

    <div class="modal" tabindex="-1" id="modal-my-products">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meu carrinho</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in bag">
                                <th scope="row">{{ item.name }}</th>
                                <td>{{ item.amount }}</td>
                                <td>{{ item.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button @click="store" type="button" class="btn btn-primary">Finalizar compra</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {

    name: 'CreateSalesComponent',

    props: ['logged', 'token', 'products'],

    data() {
        return {
            'logged': this.logged,
            'token': this.token,
            'products': this.products,
            'bag' : []
        }
    },

    beforeMount() {

    },

    mounted() {
    },

    methods: {

        pathImage()
        {
            return window.location.origin + '/storage/';
        },

        addToBag(product)
        {
            this.bag.push({
                'name' : product.name,
                'product_id': product.id,
                'amount': 1,
                'value' : product.value
            });

            //todo add information toast says products added
        },

        store()
        {

            let value_total = 0;

            this.bag.map(item => {
                value_total += item.value;
            });

            let params = {};

            params.user_id = this.logged.id;
            params.value = value_total;
            params.payment_method = 'payment_method';
            params.products = this.bag;

            return console.log(params)

            const URL = '/api/sales';

            axios.post(URL, params, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }
            })
            .then(response => {
                this.$swal.fire('Venda criada com sucesso', 'success');
            })
            .catch(error => {
                console.warn(error);
                this.$swal.fire('Erro ao abrir venda', 'Contate o suporte', 'error')
            });
        }

    }
}
</script>
