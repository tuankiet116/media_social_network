<template>
  <div>
    <div class="box group-container pl-0 pr-0 pt-0">
      <div class="m-0 background-img"></div>
      <figure class="image is-64x64 group-brand">
        <img class="is-rounded" src="../../../images/defaults/brand.png" />
      </figure>
      <div class="content p-2 mt-5">
        <p>
          Your personal Reddit frontpage. Come here to check in with your
          favorite communities.
        </p>
      </div>
      <div v-if="user" class="buttons">
        <a class="button btn-create is-info mr-2 ml-2">Create Post</a>
        <a
          class="button btn-create is-info m-2 mt-1 js-modal-trigger"
          data-target="modal-create-group"
          @click="isCreateGroup = true"
        >
          Create Comunity
        </a>
      </div>
    </div>
    <div
      v-if="user"
      id="modal-create-group"
      class="modal"
      :class="{ 'is-active': isCreateGroup }"
    >
      <div class="modal-background"></div>
      <div class="modal-content">
        <div class="box">
          <div class="content">
            <h3>Create Your Own Community</h3>
          </div>
          <div class="field">
            <label>Your Community Name:</label>
            <input class="input" type="text" v-model="groupName" />
          </div>
          <div class="field is-grouped">
            <div class="control">
              <button class="button is-success" @click="createCommunity">
                Create
              </button>
            </div>
            <div class="control">
              <button class="button" @click="isCreateGroup = false">
                Cancel
              </button>
            </div>
          </div>
          <button
            class="modal-close is-large"
            @click="isCreateGroup = false"
            aria-label="close"
          ></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { createCommunityAPI } from '../../api/community'
export default {
  props: ['group'],
  data() {
    return {
      isCreateGroup: false,
      groupName: '',
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
        community_name: this.groupName,
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
  position: fixed;
  width: 20rem;
}

.btn-create {
  width: 100%;
}
</style>
