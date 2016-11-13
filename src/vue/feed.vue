<template xmlns:v-on="http://www.w3.org/1999/xhtml">
  <div>

    <nav class="level">
      <div class="level-item has-text-centered">
        <p class="title">Feed</p>
      </div>
    </nav>

    <div id="posts">
      <user-post v-if="allPosts !== null" v-for="post in allPosts" v-bind:data="post"></user-post>
      <div v-else>
        <p>Sorry, no one has posted anything on this user's feed. Why not be the first?</p>
      </div>
    </div>

    <!--
    <div v-if="!isCurrentUser">
      <br>

      <other-post></other-post>
    </div>
    -->

  </div>
</template>

<script type="text/babel">
  import Vue from 'vue'
  import UserPost from './user-post.vue'
  import OtherPost from './other-post.vue'

  export default {
    components: { UserPost, OtherPost },
    data () {
      return {
        allPosts: null
      }
    },
    computed: {
      isCurrentUser: function () {
        if (typeof this.$route.params['user'] === 'undefined') {
          return true;
        }
        else if (sessionStorage.getItem('username') === this.$route.params['user']) {
          return true;
        }

        return false;
      }
    },
    methods: {
      addPost: function (event) {
        var successCallback = function (response) {
          if (response.body === 'success') {
            this.loadMessages();
          }
          else {
            console.log(response.body);
          }
        };

        var errorCallback = function (response) {
          console.log(response);
        };

        var message = $('textarea[name="message"]').val();
        var recipientName = this.$route.params["user"];

        var valid = true;

        if (message === '' || recipientName === '') {
          valid = false;
        }

        if (valid) {
          var params = {"message": message, "recipientName": recipientName};

          this.$http.post(phpLocation + 'addPost.php', params).then(successCallback, errorCallback);
        }
      },
      loadMessages: function (event) {
        this.allPosts = null;

        var successCallback = function (response) {
          var data;
          try {
            data = JSON.parse(response.body);

            this.allPosts = data;
          }
          catch (exception) {
            console.log(exception);
          }
        }.bind(this);

        var errorCallback = function (response) {
          console.log(response);
        }.bind(this);

        var params = { "user": null };

        if (typeof this.$route.params["user"] !== 'undefined') {
          params["user"] = this.$route.params["user"];
        }

        this.$http.post(phpLocation + 'retrieveFeed.php', params).then(successCallback, errorCallback);
      },
      messagePosted: function (event) {
        this.loadMessages();
        $('textarea[name="message"]').val('');
      }
    },
    mounted () {
      this.loadMessages();

      this.$events.on('messagePosted', this.messagePosted);
    },
    watch: {
      $route () {
        this.loadMessages();
      }
    }
  }
</script>

<style>
</style>
