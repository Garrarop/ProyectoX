<template>
  <div class="card mb-3 border-0 shadow-sm" >
    <div class="card-body d-flex flex-column ">
      <div class="d-flex align-items-center mb-3">
        <img class="rounded mr-3 shadow-sm" width="40px" :src="status.user.avatar" :alt="status.user.name" border="0">
        <div class="">
          <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
          <div class="small text-muted" v-text="status.ago"></div>
        </div>
      </div>
      <p class="card-text text-secondary" v-text="status.body"></p>
    </div>
    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
      <LikeBtn
      dusk="like-btn"
      :model="status"
      :url="`/statuses/${status.id}/likes`"
      ></LikeBtn>
      <div class="mr-2 text-secondary">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">{{ status.likes_count }}</span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments" class="mb-3">
        <div class="d-flex">
          <img height="34px" class="mr-2 rounded shadow-sm" :src="comment.user.avatar" :alt="comment.user.name">
          <div class="flex-grow-1">
            <div class="card border-0 shadow-sm">
              <div class="card-body pt-2 pl-2 pr-2 pb-0 text-secondary">
                <a :href="comment.user.link"><strong>{{ comment.user.name }}</strong></a>
                {{ comment.body }}
              </div>
              <div class="">
                <LikeBtn class="comments-like-btn" dusk="comment-like-btn" :model="comment" :url="`/comments/${comment.id}/likes`"></LikeBtn>
                <small class="badge badge-primary badge-pill float-right pt-1 px-2 mr-1" dusk="comment-likes-count">{{ comment.likes_count }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img width="34px" class="mr-2 rounded shadow-sm" src="https://i.ibb.co/HtZWgQj/default-avatar.jpg" :alt="currentUser.name">
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
