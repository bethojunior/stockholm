<template>
    <div class="card">

        <div class="card card-solid">
            <div class="card-body">
                <div class="row" v-for="product in products">
                    <div class="col-12 col-sm-12">
                        <h3 class="d-inline-block d-sm-none">{{ product.name }}</h3>
                        <div class="col-12">
                            <img :src="this.pathImage() + product.image" class="product-image" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <h3 class="my-3">{{ product.name }}</h3>
                        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
                        <hr>
                        <div class="bg-green py-2 px-3 mt-4">
                            <h2 class="mb-0">
                                R$ {{ product.value }}
                            </h2>
                        </div>
                        <div class="py-2 px-3 mt-4">
                            <div class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Adicionar ao carrinho
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name : 'ListProductsComponent',

    props: ['logged', 'token', 'products'],

    data(){
        return{
            'logged' : this.logged,
            'products' : this.products
        }
    },

    beforeMount() {

    },

    mounted() {
        console.log()
        this.products.map(product => {
            console.log(product)
        })
    },

    methods: {

        pathImage(){
            const uri = window.location.host;
            return 'https://' + uri + '/public/storage/';
        },

        create(){

            let params = {};

            params.name = this.name;
            params.value = this.value.replace(/[^\d,]/g, '').replace(',', '.');
            params.image = this.image;

            const URL = '/api/products';

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
