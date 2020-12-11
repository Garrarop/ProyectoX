<template>
  <div class="">
    <div v-if="localFriendshipStatus === 'pending'">
      <span v-text="sender.name"></span>  te ha enviado una solicitud de amistad
      <button @click="acceptFriendshipsRequest">Aceptar solicitud</button>
      <button dusk="deny-friendship" @click="denyFriendshipsRequest">Denegar solicitud</button>
    </div>
    <div v-else-if="localFriendshipStatus === 'accepted'">
      Tú y <span v-text="sender.name"></span> <span>son amigos</span>
    </div>
    <div v-else-if="localFriendshipStatus === 'denied'">
      Solicitud denegada a <span v-text="sender.name"></span>
    </div>
    <div v-if="localFriendshipStatus === 'deleted'">Solicitud eliminada</div>
    <button v-else dusk="delete-friendship" @click="deleteFriendship">Eliminar</button>
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
          this.localFriendshipStatus = res.data.friendship_status
        })
        .catch(err => {
          console.log(err.response.data);
        })
    },
    denyFriendshipsRequest(){
      axios.delete(`/accept-friendships/${this.sender.name}`)
        .then(res => {
          this.localFriendshipStatus = res.data.friendship_status
        })
        .catch(err => {
          console.log(err.response.data);
        })
    },
    deleteFriendship(){
      axios.delete(`/friendships/${this.sender.name}`)
        .then(res => {
          this.localFriendshipStatus = res.data.friendship_status
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
