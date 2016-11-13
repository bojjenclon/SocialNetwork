<template>

  <div class="user-info">

    <nav class="level">
      <div class="level-item has-text-centered">
        <p class="title">User</p>
      </div>
    </nav>

    <div class="card is-fullwidth">
      <div class="card-content">

        <nav class="level">
          <div class="level-left">
            <div class="level-item">
              <strong>Name:</strong>
            </div>
          </div>

          <div class="level-right">
            <div class="level-item">
              {{ firstName }} {{ lastName }} (@{{ username }})
            </div>
          </div>
        </nav>

        <nav class="level">
          <div class="level-left">
            <div class="level-item">
              <strong>Email:</strong>
            </div>
          </div>

          <div class="level-right">
            <div class="level-item">
             {{ email }}
            </div>
          </div>
        </nav>

      </div>
    </div>

    <friend-button v-if="!isCurrentUser"></friend-button>

  </div>

</template>

<script type="text/babel">
  import FriendButton from './friend-button.vue';

  export default {
    components: { FriendButton },
    props: [],
    data () {
      return {
        firstName: null,
        lastName: null,
        email: null
      }
    },
    computed: {
      username: function () {
        if (typeof this.$route.params['user'] !== 'undefined') {
          return this.$route.params['user'];
        }

        return sessionStorage.getItem('username');
      },
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
      loadUserInfo: function (event) {
        // if we're not logged in, redirect to the login page
        if (sessionStorage.getItem('loggedIn') === null) {
          this.$router.push('/login');
        }
        else {
          var successCallback = function (response) {
            var data;
            try {
              data = JSON.parse(response.body);

              this.firstName = data["firstName"];
              this.lastName = data["lastName"];
              this.email = data["email"];
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

          this.$http.post(phpLocation + 'retrieveUserInfo.php', params).then(successCallback, errorCallback);
        }
      }
    },
    mounted () {
      this.loadUserInfo();
    },
    watch: {
      $route () {
        this.loadUserInfo();
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
