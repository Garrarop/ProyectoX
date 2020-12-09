<template>
  <div v-if="localFriendshipStatus === 'pending'">
    <span v-text="sender.name"></span>  te ha enviado una solicitud de amistad
    <button @click="acceptFriendshipsRequest">Aceptar solicitud</button>
  </div>
  <div v-else>
    Tú y <span v-text="sender.name"></span> son amigos
  </div>
</template>

<script>
export default {
  props:{
    sender: {
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
    acceptFriendshipsRequest(){
      axios.post(`/accept-friendships/${this.sender.name}`)
        .then(res => {
          this.localFriendshipStatus = 'accepted'
        })
        .catch(err => {
          console.log(err.response.data);
        })
    }
  }
}
</script>

<style lang="css" scoped>
</style>
