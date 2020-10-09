<template>
  <div class="shadow-sm" v-if="isAuthenticated">
    <form @submit.prevent="submit" >
      <div class="card-body">
          <textarea v-model="body" class="form-control border-0 bg-light"
                    :placeholder="`¿Qué estas pensando ${currentUser.name}?`" name="body"></textarea>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" id="create-status">
          <i class="fa fa-paper-plane mr-1"></i>
          Publicar</button>
      </div>
    </form>
  </div>
  <div v-else class="card-body shadow-sm">
    <a href="/login" class="btn btn-success">Debes hacer login</a>
  </div>
</template>

<script>

  export default {
    data(){
      return{
        body: '',
      }
    },

    methods: {
      submit(){
        axios.post('/statuses', {body: this.body})
        .then(res => {
          EventBus.$emit('status-created', res.data.data)
          this.body = ''
        })
        .catch(err => {
          console.log(err.response.data)
        })
      }
    }
  }
</script>

<style scoped>

</style>
