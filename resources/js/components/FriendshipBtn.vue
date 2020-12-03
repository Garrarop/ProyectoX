<template>
  <button
    @click="toggleFriendshipStatus"
    dusk="request-friendship"
  >
  {{ getText }}
  </button>
</template>

<script>
  export default {
    props: {
      recipient: {
        type: Object,
        required: true
      },
      friendshipStatus: {
        type: String,
        required: true
      }
    },
    data(){
      return {
        localFriendshipStatus: this.friendshipStatus
      }
    },
    methods: {
      toggleFriendshipStatus(){
        let method = this.getMethod();

        axios[method](`friendships/${this.recipient.name}`)
        .then(res => {
          this.localFriendshipStatus = res.data.friendship_status;
        })
        .catch(err => {
          console.log(err.response.data)
        })
      },
      getMethod(){
        if (this.localFriendshipStatus === 'pending'){
          return 'delete';
        }
        return 'post';
      }
    },
    computed: {
      getText(){
        if (this.localFriendshipStatus === 'pending')
        {
          return 'Cancelar solicitud';
        }
        return 'Solicitar amistad';
      }
    }
  }
</script>

<style scoped>
</style>
