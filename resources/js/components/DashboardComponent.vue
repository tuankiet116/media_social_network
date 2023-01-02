<template>
  <div id="post-container" class="columns">
    <div class="column is-7">
      <LoadingComponent v-if="loading" />
      <div id="create-post" class="post">
        <div
          v-if="user"
          class="box post-box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5 is-flex is-align-items-center"
        >
          <img class="image is-32x32 mr-2" :src="user?.image" />
          <input
            @click="$router.push({ name: 'create_post' })"
            class="input"
            placeholder="Create Post"
          />
        </div>
        <div
          v-else
          @click="redirectLogin"
          class="box post-box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5 is-flex is-align-items-center"
        >
          <input class="input" placeholder="Create Post" />
        </div>
      </div>
      <div class="post">
        <PostComponent
          @post-deleted="handleRemovePost"
          v-for="post in posts"
          :post="post"
        />
      </div>
    </div>
    <div class="column">
      <CommunityCardComponent class="card_community" />
    </div>
  </div>
</template>

<script>
import { getPosts } from '../api/post'
import authMixin from '../mixins'
import PostComponent from './Post/Children/PostComponent.vue'
import LoadingComponent from './Common/LoadingComponent.vue'
import { mapGetters } from 'vuex'
import CommunityCardComponent from './Community/CommunityCardComponent.vue'

export default {
  components: {
    PostComponent,
    LoadingComponent,
    CommunityCardComponent,
  },
  mixins: [authMixin],
  data() {
    return {
      loading: true,
      isLoadMore: false,
      outOfPost: false,
      offset: 0,
      posts: [],
    }
  },
  computed: {
    ...mapGetters({
      user: 'getUser',
    }),
  },
  mounted() {
    this.fetchPost()
    this.loading = false
    document.addEventListener('scroll', this.handleLoadPost)
  },
  methods: {
    fetchPost() {
      let _this = this
      getPosts(this.offset)
        .then((result) => {
          _this.posts.push(...result.data.data)
          if (result.data.data.length == 0) this.outOfPost = true
          this.offset = result.data.offset
          this.isLoadMore = true
        })
        .catch((err) => {
          console.log(err)
        })
    },
    handleLoadPost(e) {
      if (
        window.innerHeight + window.scrollY >=
          document.body.offsetHeight - 100 &&
        this.isLoadMore &&
        !this.outOfPost
      ) {
        this.isLoadMore = false
        this.fetchPost()
      }
    },
    handleRemovePost(postID) {
      let postIndex = this.posts.findIndex((p) => {
        return p.id == postID
      })
      this.posts.splice(postIndex, 1)
    },
    redirectLogin() {
      window.location.replace('user/login')
    },
  },
  beforeUnmount() {
    document.removeEventListener('scroll', this.handleLoadPost)
  },
}
</script>

<style scoped>
#create-post .box {
  margin-left: auto;
  margin-right: auto;
  max-width: 600px;
  margin-bottom: 2rem;
}

#create-post .box textarea {
  height: 50px;
}

#post-container {
  margin-top: 2rem;
}

.card_community {
  position: sticky;
  top: 8rem;
}

/deep/ .post-box {
  margin-right: 1rem !important;
}
</style>
