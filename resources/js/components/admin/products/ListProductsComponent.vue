<template>
    <div class="card">
        <div class="card card-solid">
            <div class="card-body">
                <div class="row" v-for="product in products">
                    <div class="col-lg-6 col-sm-12">
                        <h3 class="d-inline-block d-sm-none">{{ product.name }}</h3>
                        <div class="col-12">
                            <img :src="this.pathImage() + product.image" class="product-image" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <p>
                            {{ product.description }}
                        </p>
                        <p>
                            <b>Em estoque : {{ product.amount.amount }}</b>
                        </p>
                        <hr>
                        <div class="bg-green py-2 px-3 mt-4">
                            <h2 class="mb-0">
                                R$ {{ product.value }}
                            </h2>
                        </div>
                        <div class="pt-2">
                            <button class="btn btn-default col-sm-12">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                            <button @click="destroy(product.id)" class="btn btn-danger col-sm-12 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                            </button>
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

    },

    methods: {

        pathImage(){
            const uri = window.location.host;
            return 'http://' + uri + '/storage/';
        },

        destroy(id){

            const URL = '/api/products/' + id;

            axios.delete(URL, '', {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.$swal.fire('Produto excluido com sucesso', 'O produto não aparecerá mais na listagem', 'success');
            })
            .catch(error => {
                this.$swal.fire('Erro ao excluir produto', 'Contate o suporte', 'error')
            });

        }
    }
}
</script>
