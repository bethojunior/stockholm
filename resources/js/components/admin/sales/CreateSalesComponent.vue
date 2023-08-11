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
                <button @click="addToBag(product)" class="btn btn-success ml-2">Adicionar a sacola</button>
            </div>
        </div>
    </div>

    <button @click="openModalBag()" id="my-items" class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-my-products">
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
                            <tr v-for="item in bagItems">
                                <th scope="row">{{ item.item.item.name }}</th>
                                <td>{{ item.amount }}</td>
                                <td>R$ {{ item.item.item.value }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-if="moreInformations" id="more-informations">
                        <div class="form-group">
                            <label for="">Nome do cliente</label>
                            <input v-model="client.name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Numero do cliente</label>
                            <input v-model="client.phone" type="number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Forma de pagamento</label>
                            <select class="form-control" v-model="sale.payment_method">
                                <option value="pix">Pix</option>
                                <option value="cash">Dinheiro</option>
                                <option value="credit">Crédito</option>
                                <option value="debit">Débito</option>
                            </select>
                        </div>

                        <button class="btn btn-success col-sm-12" @click="store">Finalizar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeModalSales" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button @click="getMoreInformations" type="button" class="btn btn-primary">Adicionar dados do cliente</button>
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
            'bag' : [],
            'bagItems': [],
            'moreInformations' : false,
            'client' : {
                'name' : null,
                'phone' : null
            },
            'sale' : {
                'payment_method' : null,
                'value' : null,
                'user_id' : null,
                'products' : null
            }
        }
    },

    methods: {

        pathImage()
        {
            if(window.location.origin === 'http://localhost:8000')
                return window.location.origin + '/storage/';
            return window.location.origin + '/public/storage/';
        },

        addToBag(product)
        {
            this.bag.push({
                'amount' : 1,
                'item' : {
                    'name' : product.name,
                    'product_id': product.id,
                    'amount': 1,
                    'value' : product.value
                }
            });

            //todo add information toast says products added
        },

        getMoreInformations() {
            this.moreInformations = true;
        },

        store()
        {
            let value_total = 0;

            this.bagItems.map(item => {
                value_total += item.item.item.value;
            });

            let params = {};

            params.user_id = this.logged.id;
            params.value = value_total;
            params.payment_method = this.sale.payment_method;
            params.client = this.client;
            params.products = this.bag;


            axios.post('/api/sales', params, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }
            })
            .then(response => {
                this.$swal.fire('Venda criada com sucesso');
            })
            .catch(error => {
                this.$swal.fire('Erro ao abrir venda', 'Contate o suporte', 'error')
            });

            this.bag = [];
            this.client = {};
            this.sale = {};
            this.moreInformations = true;
            document.getElementById('closeModalSales').click()
            this.$forceUpdate();
        },

        openModalBag()
        {
            this.findObj(this.bag).map(item => {
                this.bagItems.push(item)
            })
            this.$forceUpdate();
        },

        findObj(array)
        {
            const amount = new Map();
            const duplicates = [];

            for (const item of array) {
                const _object_ = JSON.stringify(item);

                if (amount.has(_object_)) {
                    const amount_ = amount.get(_object_);
                    amount.set(_object_, amount_ + 1);
                } else {
                    amount.set(_object_, 1);
                }
            }

            for (const [object_, _amount] of amount.entries()) {
                if (_amount > 1) {
                    const itemDuplicated = JSON.parse(object_);
                    duplicates.push({
                        item: itemDuplicated,
                        amount: _amount - 1
                    });
                }
            }

            for (const itemDuplicated of duplicates) {
                const index = array.findIndex(item =>
                    JSON.stringify(item) === JSON.stringify(itemDuplicated.item)
                );
                if (index !== -1) {
                    array.splice(index, 1);
                }
            }

            return duplicates;
        }

    }
}
</script>
