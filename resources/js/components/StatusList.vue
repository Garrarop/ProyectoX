<template>
  <div @click="redirectIfGuest">
    <StatusListItem v-for="status in statuses" :status="status" :key="status.id"></StatusListItem>
  </div>
</template>

<script>
    import StatusListItem from './StatusListItem'

    export default {
      components: {
        StatusListItem
      },
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
