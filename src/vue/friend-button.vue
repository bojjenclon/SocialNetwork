<template xmlns:v-on="http://www.w3.org/1999/xhtml">

  <a v-if="isFriend" class="button is-danger is-fullwidth" v-on:click="removeFriend">Remove Friend</a>
  <a v-else class="button is-success is-fullwidth" v-on:click="addFriend">Add Friend</a>

</template>

<script type="text/babel">
  export default {
    props: [],
    data () {
      return {
        isFriend: false
      }
    },
    methods: {
      checkIsFriend: function (event) {
        // if we're not logged in, redirect to the login page
        if (sessionStorage.getItem('loggedIn') === null) {
          this.$router.push('/login');
        }
        else {
          this.isFriend = false;

          var successCallback = function (response) {
            if (response.body === 'true') {
              this.isFriend = true;
            }
            else if (response.body === 'false') {
              this.isFriend = false;
            }
            else {
              console.log(response.body);
            }
          }.bind(this);

          var errorCallback = function (response) {
            console.log(response);
          }.bind(this);

          if (typeof this.$route.params["user"] !== 'undefined') {
            var params = { "friendName": this.$route.params["user"] };

            this.$http.post(phpLocation + 'checkIsFriend.php', params).then(successCallback, errorCallback);
          }
        }
      },
      addFriend: function(event) {
        var successCallback = function (response) {
          if (response.body === 'true') {
            this.isFriend = true;
          }
          else {
            console.log(response.body);
          }
        }.bind(this);

        var errorCallback = function (response) {
          console.log(response);
        }.bind(this);

        if (typeof this.$route.params["user"] !== 'undefined') {
          var params = { "friendName": this.$route.params["user"] };

          this.$http.post(phpLocation + 'addFriend.php', params).then(successCallback, errorCallback);
        }
      },
      removeFriend: function(event) {
        var successCallback = function (response) {
          if (response.body === 'true') {
            this.isFriend = false;
          }
          else {
            console.log(response.body);
          }
        }.bind(this);

        var errorCallback = function (response) {
          console.log(response);
        }.bind(this);

        if (typeof this.$route.params["user"] !== 'undefined') {
          var params = { "friendName": this.$route.params["user"] };

          this.$http.post(phpLocation + 'removeFriend.php', params).then(successCallback, errorCallback);
        }
      }
    },
    mounted () {
      this.checkIsFriend();
    },
    watch: {
      $route () {
        this.checkIsFriend();
      }
    }
  }
</script>

<style>
  .user-info .card .level {
    margin-top: 5px;
    margin-bottom: 5px;
  }
</style>
