<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-32x32">
                <img class="is-rounded" :src="comment.users.image">
            </p>
        </figure>
        <div class="media comment-box">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{{ comment.users.name }}</strong> <small>{{ createTime }}</small>
                        <br>
                    </p>
                    <div class="content box is-rounded">
                        {{ comment.content }}
                    </div>
                </div>
                <nav v-if="user" class="level is-mobile">
                    <div class="level-left">
                        <a class="level-item">
                            <span class="icon is-small">
                                <i class="fa-regular fa-thumbs-up"></i>
                            </span>
                        </a>
                        <a class="level-item" @click="handleDisplayReply">
                            <span class="icon is-small"><i class="fas fa-reply"></i></span>
                        </a>
                    </div>
                </nav>
                <article v-if="displayReply && user" class="media sub-comment">
                    <figure class="media-left">
                        <p class="image is-32x32">
                            <img class="is-rounded" :src="user.image">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea class="textarea" ref="comment_reply" autofocus></textarea>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <a class="button is-info is-rounded is-small">Submit</a>
                                </div>
                                <div class="level-item">
                                    <a @click="displayReply = false" class="button is-light is-small is-rounded">Cancel</a>
                                </div>
                            </div>
                            <div class="level-left">
                            </div>
                        </nav>
                    </div>
                </article>
            </div>

            <figure class="media-right dots-container is-rounded">
                <button class="button is-rounded">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
            </figure>
            <div href="#" class="arrow-box box"> 
                <a class="navbar-item">
                    <span>Delete</span>
                </a>
            </div>
        </div>
    </article>
</template>

<script>
import { calculateTime } from '../../../helpers/common';

export default {
    props: ['comment'],
    data() {
        return {
            displayReply: false,
            isShowDetail: false
        }
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        },
        createTime() {
            return calculateTime(this.comment.created_at, this);
        }
    },
    methods: {
        handleDisplayReply() {
            this.displayReply = !this.displayReply;
            this.$emit('displayReply');
        }
    }

}
</script>

<style scoped>
textarea {
    height: 4em;
    min-height: 4em !important;
}

.media {
    margin-right: 0.5rem;
    border: none !important;
    margin-top: 0;
    padding-top: 0.5rem;
}

.comment-box {
    width: 100%;
    position: relative;
}

.arrow-box{
  position: absolute;
  width:220px;
  background: #19B3E6;
  line-height: 40px;
  margin-bottom:30px; 
  text-align:center;
  color:black;
  right: 2rem;
  padding: 0;
}

.arrow-box:before{
    content: "";
    position: absolute;
    right: -7px;
    top: 7px;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid #19B3E6;
}

.dots-container {
}
</style>