<template>
  <div>
    <div class="box group-container pl-0 pr-0 pt-0">
      <div class="m-0 background-img" v-if="community"
        :style="{ 'background-image': 'url(' + community.background + ')' }"></div>
      <div class="m-0 background-img" v-else></div>

      <figure class="image is-64x64 group-brand">
        <img v-if="community" class="is-rounded avatar-image" :src="community.image" />
        <img v-else class="is-rounded" src="../../../images/defaults/brand.png" />
      </figure>

      <div class="content p-2 mt-5">
        <h2 class="ml-2" v-if="community">{{ community.community_name }}</h2>
        <p v-if="community">{{ $t('community.your_page_in_1') }} {{ community.community_name }} {{
          $t('community.your_page_in_2')
        }}</p>
        <p v-else>
          {{ $t('community.your_page_in_home') }}
        </p>
      </div>

      <div v-if="community && community.rule" class="content p-2 mt-5">
        <hr />
        <p style="word-break: break-word;" v-html="community.rule">
        </p>
      </div>

      <div v-if="user" class="buttons">
        <a class="button btn-create is-info mr-2 ml-2" @click="redirectCreatePost">{{ $t('create_post_text') }}</a>
        <a class="button btn-create is-info m-2 mt-1 js-modal-trigger" data-target="modal-create-group"
          @click="isCreateGroup = true" v-if="community == null">
          {{ $t('community.create') }}
        </a>
      </div>
    </div>
    <div v-if="user && community == null" id="modal-create-group" class="modal" :class="{ 'is-active': isCreateGroup }">
      <div class="modal-background"></div>
      <div class="modal-content">
        <div class="box">
          <div class="content">
            <h3>{{ $t('community.create_own') }}</h3>
          </div>
          <div class="field">
            <label>{{ $t('community_setting.name') }}</label>
            <input class="input" type="text" v-model="communityName" />
          </div>
          <div class="field is-grouped">
            <div class="control">
              <button class="button is-success" @click="createCommunity">
                {{ $t('create') }}
              </button>
            </div>
            <div class="control">
              <button class="button" @click="isCreateGroup = false">
                {{ $t('cancel') }}
              </button>
            </div>
          </div>
          <button class="modal-close is-large" @click="isCreateGroup = false" aria-label="close"></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { createCommunityAPI } from '../../api/community'
export default {
  props: ['community'],
  data() {
    return {
      isCreateGroup: false,
      communityName: '',
    }
  },
  computed: {
    user() {
      return this.$store.state.user
    },
  },
  methods: {
    createCommunity() {
      let data = {
        community_name: this.communityName,
      }
      createCommunityAPI(data).then((result) => {
        if (result.data) {
          this.$router.push({
            name: 'community_page',
            params: {
              id: result.data.id,
            },
          })
        }
      })
    },
    redirectCreatePost() {
      if (this.community) {
        this.$router.push({
          name: 'create_post', query: {
            community: this.community.id
          }
        })
      }
      this.$router.push({ name: 'create_post' })
    }
  },
}
</script>

<style scoped>
.background-img {
  height: 5rem;
  width: 100%;
  background-image: url('../../../images/defaults/universe.jpg');
  background-position: center;
}

.group-brand {
  position: absolute;
  top: 3rem;
  left: 1rem;
}

.group-brand img {
  background-color: rgb(236, 236, 250);
  border-radius: 100%;
  padding: 0.5rem;
}

.group-container {
  max-width: 20rem;
}

.btn-create {
  width: 100%;
}

.avatar-image {
  height: 64px !important;
}
</style>
