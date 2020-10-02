<template>
  <div>
    <div class="card mb-3 border-0 shadow-sm" v-for="status in statuses">
      <div class="card-body d-flex flex-column ">
        <div class="d-flex align-items-center mb-3">
          <img class="rounded mr-3 shadow-sm" width="40px" src="https://i.ibb.co/HtZWgQj/default-avatar.jpg" alt="default-avatar" border="0">
          <div class="">
            <h5 class="mb-1">Gary M</h5>
            <div class="small text-muted">Hace una hora</div>
          </div>
        </div>
        <p class="card-text text-secondary" v-text="status.body"></p>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          statuses: []
        }
      },
      mounted(){
        axios.get('/statuses')
          .then(res => {
            this.statuses = res.data.data
          })
          .catch(err => {
            console.log(err.response.data);
          });
        EventBus.$on('status-created', status =>  {
          this.statuses.unshift(status);
        })
      }
    }
</script>

<style scoped>

</style>
