<template>
  <div>

    <nav class="level">
      <div class="level-item has-text-centered">
        <p class="title">You have {{ friendText }}</p>
      </div>
    </nav>

    <div id="friends">
      <div class="columns" v-if="allFriends !== null">
        <div class="column is-one-quarter multiline" v-for="friend in allFriends">
          <friend-card v-bind:username="friend.username" v-bind:email="friend.email"></friend-card>
        </div>
      </div>

      <div v-else>
        <p>Oh no, you don't have any friends yet! Hey, did you unfriend <router-link to="/profile/cmdaly">Cornell</router-link> too? How rude!</p>
      </div>
    </div>

  </div>
</template>

<script type="text/babel">
  import FriendCard from './friend-card.vue'

  export default {
    components: { FriendCard },
    data () {
      return {
        allFriends: null
      }
    },
    computed: {
      userProfile: function () {
        return '/profile/' + this.username;
      },
      friendText: function () {
        var text = '';

        if (this.allFriends === null || this.allFriends.length === 0) {
          text = 'no friends. :\'('
        }
        else if (this.allFriends.length == 1) {
          text = '1 friend.';
        }
        else {
          text = this.allFriends.length + ' friends!';
        }

        return text;
      }
    },
    mounted () {
      // if we're not logged in, redirect to the login page
      if (sessionStorage.getItem('loggedIn') === null) {
        this.$router.push('/login');
      }
      else {
        this.allFriends = null;

        var successCallback = function (response) {
          var data;
          try {
            data = JSON.parse(response.body);

            if (data.length  > 0) {
              this.allFriends = data;
            }
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

        this.$http.post(phpLocation + 'retrieveFriends.php', params).then(successCallback, errorCallback);
      }
    },
    watch: {
      $route () {
        this.allFriends = null;

        var successCallback = function (response) {
          var data;
          try {
            data = JSON.parse(response.body);

            if (data.length  > 0) {
              this.allFriends = data;
            }
          }
          catch (exception) {
            console.log(exception);
          }
        }.bind(this);

        var errorCallback = function (response) {
          console.log(response);
        }.bind(this);

        var user = this.$route.params["user"];
        var params = {"user": user};

        this.$http.post(phpLocation + 'retrieveFriends.php', params).then(successCallback, errorCallback);
      }
    }
  }
</script>

<style>
</style>
