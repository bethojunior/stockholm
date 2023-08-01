<template>
    <div class="card">

        <div class="row col-lg-12 pt-3 pb-3">

            <div class="form-group col-lg-4 col-sm-12">
                <label for="">Nome do produto</label>
                <input v-model="name" type="text" class="form-control">
            </div>

            <div class="form-group col-lg-4 col-sm-12">
                <label for="">Imagem do produto</label>
                <input class="form-control" type="file" @input="image = $event.target.files[0]" />
            </div>

            <div class="form-group col-lg-4 col-sm-12">
                <label for="">Valor</label>
                <input id="value" v-model="value" type="text" class="form-control">
            </div>

            <div class="col-lg-12 col-sm-12">
                <button @click="create" class="btn btn-success col-sm-12 col-lg-1">Salvar</button>
            </div>

        </div>
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
            'value' : null,
            'image' : null,
        }
    },

    beforeMount() {

    },

    mounted() {
        const valorInput = document.getElementById('value');
        valorInput.addEventListener('input', this.formatCurrency);
    },

    methods: {

        formatCurrency(event) {
            const input = event.target;
            const value = input.value.replace(/\D/g, '');

            const numericValue = Number(value) / 100;

            input.value = numericValue.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        },

        create(){

            let params = new FormData();

            params.append('name', this.name);
            params.append('value', this.value.replace(/[^\d,]/g, '').replace(',', '.'));
            params.append('image', this.image);

            const URL = '/api/products';
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            axios.post(URL, params, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                console.log(response);
                this.$swal.fire('Produto criado com sucesso', params.get('name') + ' foi criado', 'success');
            })
            .catch(error => {
                console.log(error);
                this.$swal.fire('Erro ao criar produto', 'Contate o suporte', 'error');
            });


        }
    }
}
</script>
