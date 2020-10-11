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
      <form @submit.prevent="addComment">
        <textarea name="comment" v-model="newComment"></textarea>
        <button dusk="comment-btn">Enviar</button>
      </form>
      <div v-for="comment in comments">
        {{ comment.user_name }}
        {{ comment.body }}
      </div>
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
      }
    }
  }
</script>

<style scoped>

</style>
