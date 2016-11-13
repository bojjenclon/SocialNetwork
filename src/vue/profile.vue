<template xmlns:v-on="http://www.w3.org/1999/xhtml">
  <div>

    <hero-header title="Profile"></hero-header>

    <section class="section">
      <div class="container">

        <div v-if="userExists">

          <div class="columns">

            <div class="column is-one-quarter">
              <user-info></user-info>
            </div>

            <div class="column">
              <self-post v-if="isMainPage"></self-post>
              <other-post v-else></other-post>

              <br>

              <feed></feed>
            </div>

          </div>

        </div>

        <div v-else>

          <nav class="level">
            <div class="level-item has-text-centered">
              <p class="title">We're sorry, the user @{{ username }} doesn't exist.</p>
            </div>
          </nav>

        </div>

      </div>
    </section>

  </div>
</template>

<script type="text/babel">
  import Vue from 'vue'
  import HeroHeader from './hero-header.vue'
  import UserInfo from './user-info.vue'
  import SelfPost from './self-post.vue'
  import OtherPost from './other-post.vue'
  import Feed from './feed.vue'

  export default {
    components: {HeroHeader, UserInfo, SelfPost, OtherPost, Feed},
    data () {
      return {
        userExists: true
      }
    },
    computed: {
      username: function () {
        if (typeof this.$route.params['user'] !== 'undefined') {
          return this.$route.params['user'];
        }

        return sessionStorage.getItem('username');
      },
      isMainPage: function() {
        if (typeof this.$route.params['user'] === 'undefined') {
          return true;
        }

        return this.$route.params['user'] === sessionStorage.getItem('username');
      }
    },
    methods: {
      checkUserExists: function (event) {
        // if we're not logged in, redirect to the login page
        if (sessionStorage.getItem('loggedIn') === null) {
          this.$router.push('/login');
        }
        else {
          var successCallback = function (response) {
            if (response.body == 'true') {
              this.userExists = true;
            }
            else {
              this.userExists = false;

              console.log(response.body);
            }
          }.bind(this);

          var errorCallback = function (response) {
            console.log(response);
          }.bind(this);

          if (typeof this.$route.params["user"] !== 'undefined') {
            var params = { "username": this.$route.params["user"] };

            this.$http.post(phpLocation + 'checkUserExists.php', params).then(successCallback, errorCallback);
          }
        }
      }
    },
    mounted () {
      this.checkUserExists();
    },
    watch: {
      $route () {
        this.checkUserExists();
      }
    }
  }
</script>

<style>
</style>
