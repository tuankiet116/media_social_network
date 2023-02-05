<template>
  <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Mọi người yêu thích bài viết</p>
        <button class="delete" @click="$emit('close')" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <p v-if="likes.length == 0">Hiện chưa có người yêu thích bài viết.</p>
        <template v-else v-for="like, index in likes">
          <router-link class="box is-flex mb-1 p-2 is-bordered"
            :to="{ name: 'profile_list_post', params: { id: like.user.id } }">
            <figure class="image is-64x64">
              <img class="is-rounded avatar-image" :src="like.user.image" />
            </figure>
            <div class="content is-flex is-justify-content-center is-align-items-center ml-2 mb-0">
              <h5>{{ like.user.name }} <span v-if="user.id == like.user.id"> ({{ $t('you') }}) </span></h5>
            </div>
            <div v-if="like.user.isFollowed && user.id !== like.user.id"
              class="is-flex justify-content-center is-align-items-center" style="margin-left: auto">
              <button class="button is-info is-rounded">
                {{ $t('user_page.followed') }}
              </button>
            </div>
          </router-link>
        </template>
        <ObserverComponent @intersect="getUserLike"/>
      </section>
    </div>
  </div>
</template>
<script>
import { getReactPostAPI } from '../../../api/post';
import ObserverComponent from '../../Common/ObserverComponent.vue';

export default {
  props: ['post'],
  components: { ObserverComponent },
  data() {
    return {
      offset: 0,
      likes: []
    }
  },
  mounted() {
    this.getUserLike();
  },
  computed: {
    user() {
      return this.$store.getters.getUser;
    }
  },
  methods: {
    getUserLike() {
      getReactPostAPI(this.post.id, this.offset).then(result => {
        this.likes = result.data.likes;
        this.offset = result.data.offset;
      });
    }
  }
}
</script>