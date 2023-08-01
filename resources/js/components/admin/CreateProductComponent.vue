<template>
    <div class="card row col-lg-12 pt-2">

        <div class="form-group col-lg-4 col-sm-12">
            <label for="">Nome do produto</label>
            <input v-model="name" type="text" class="form-control">
        </div>

<!--        <div class="form-group col-lg-4 col-sm-12">-->
<!--            <label for="">Imagem do produto</label>-->
<!--            <input v-model="name" type="file" class="form-control">-->
<!--        </div>-->

        <b-form-file
            v-model="image"
            :state="Boolean(image)"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
        ></b-form-file>
        <div class="mt-3">Selected file: {{ image ? image.name : '' }}</div>

    </div>
</template>

<script>
export default {
    name : 'CreateProductsComponent',

    props: ['logged'],

    data(){
        return{
            'logged' : this.logged,
            'name' : null,
            'image' : null
        }
    },

    mounted() {
        console.log('Component create product mounted.')
    },

    methods: {

        create(){

            let params = {};
            const URL = '/api/products';
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            axios.post('product', params, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => {
                this.$swal.fire('Task criada', 'A task foi criada com sucesso', 'success');
            })
            .catch(error => {
                this.$swal.fire('Erro ao criar task', 'Contate o suporte', 'error')
            });

        }
    }
}
</script>
