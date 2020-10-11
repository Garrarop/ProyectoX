<template>
  <div class="card mb-3 border-0 shadow-sm" >
    <div class="card-body d-flex flex-column ">
      <div class="d-flex align-items-center mb-3">
        <img class="rounded mr-3 shadow-sm" width="40px" src="https://i.ibb.co/HtZWgQj/default-avatar.jpg" alt="default-avatar" border="0">
        <div class="">
          <h5 class="mb-1" v-text="status.user_name"></h5>
          <div class="small text-muted" v-text="status.ago"></div>
        </div>
      </div>
      <p class="card-text text-secondary" v-text="status.body"></p>
    </div>
    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
      <LikeBtn :status="status"></LikeBtn>
      <div class="mr-2 text-secondary">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">{{ status.likes_count }}</span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments" class="mb-3">
        <img width="34px" class="mr-2 rounded shadow-sm float-left" :src="comment.user_avatar" :alt="comment.user_name">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-2 text-secondary">
            <a href="#"><strong>{{ comment.user_name }}</strong></a>
            {{ comment.body }}
          </div>
        </div>
      </div>
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img width="34px" class="mr-2 rounded shadow-sm" src='https://i.ibb.co/HtZWgQj/default-avatar.jpg' :alt="currentUser.name">
          <div class="input-group">
            <textarea class="form-control border-0 shadow-sm" required placeholder="Escribe un comentario" name="comment" rows="1" v-model="newComment"></textarea>
            <div class="input-group-append">
              <button class="btn btn-primary" dusk="comment-btn">Enviar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import LikeBtn from './LikeBtn'

  export default{
    components: {
      LikeBtn
    },
    props: {
      status: {
        type: Object,
        required: true
      },
    },
    data (){
      return{
        newComment: '',
        comments: this.status.comments
      }
    },
    methods: {
      addComment(){
        axios.post(`/statuses/${this.status.id}/comments`, {body: this.newComment})
          .then(res =>{
            this.newComment = '';
            this.comments.push(res.data.data);
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
