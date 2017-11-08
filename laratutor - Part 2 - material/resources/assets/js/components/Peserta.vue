<template>
  <div>
    <form @submit.prevent="createPeserta" type="post" v-show="!editState">
      <div class="form-group" :class="{'has-error': errors.name}">
        <input type="text" v-model="peserta.name" placeholder="Name" class="form-control">
        <span class="help-block" v-for="error in errors.name" :key="error.key">{{ error }}</span>
      </div>
      <div class="form-group" :class="{'has-error': errors.email}">
        <input type="email" v-model="peserta.email" placeholder="Email" class="form-control">
        <span class="help-block" v-for="error in errors.email" :key="error.key">{{ error }}</span>
      </div>
      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    <form @submit.prevent="updatePeserta" type="post" v-show="editState">
      <div class="form-group" :class="{'has-error': errorsEdit.name}">
        <input type="text" v-model="pesertaEdit.name" placeholder="Name" class="form-control">
        <span class="help-block" v-for="error in errorsEdit.name" :key="error.key">{{ error }}</span>
      </div>
      <div class="form-group" :class="{'has-error': errorsEdit.email}">
        <input type="email" v-model="pesertaEdit.email" placeholder="Email" class="form-control">
        <span class="help-block" v-for="error in errorsEdit.email" :key="error.key">{{ error }}</span>
      </div>
      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" @click="batalEdit">Batal</button>
      </div>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="peserta in pesertas" :key="peserta.key">
          <td>{{ peserta.name }}</td>
          <td>{{ peserta.email }}</td>
          <td>
            <button type="button" class="btn btn-info" @click="getEdit(peserta)">Edit</button>
            <button type="button" class="btn btn-danger" @click="hapusPeserta(peserta)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data(){
    return {
      peserta:{
        name: '',
        email: ''
      },
      pesertas: [],
      editState: false,
      pesertaEdit: {
        name: '',
        email: ''
      },
      errors: [],
      errorsEdit: []
    };
  },
  created() {
    //do something after creating vue instance
    this.fetchPeserta();
  },
  methods: {
    fetchPeserta() {
      axios.get('/pesertas').then(respo => {
        this.pesertas = respo.data.data;
      })
    },
    createPeserta(){
      axios.post('/pesertas',this.peserta).then(respon => {
        this.pesertas.push(respon.data.peserta);
        this.peserta = {
          name: '',
          email: ''
        };
        this.errors = [];
      }).catch(respon => {
        this.errors = respon.response.data.errors;
      });
    },
    getEdit(edit){
      this.editState = true;
      this.pesertaEdit = edit;
    },
    batalEdit(){
      this.editState = false;
      this.pesertaEdit = {
        name: '',
        email: ''
      };
    },
    updatePeserta(){
      axios.patch('/pesertas/'+this.pesertaEdit.id,this.pesertaEdit).then(respon => {
        this.editState = false;
        this.pesertaEdit = {
          name: '',
          email: ''
        };
      }).catch(respon => {
        this.errorsEdit = respon.response.data.errors;
      });
    },
    hapusPeserta(peserta){
      axios.delete('/pesertas/'+peserta.id).then(respo => {
        let index = this.pesertas.indexOf(peserta);
        this.pesertas.splice(index,1);
      });
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
