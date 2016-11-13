<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
  <section class="hero is-primary">
    <div class="hero-head">
      <header class="nav">
        <div class="container">

          <div class="nav-left">
            <router-link class="nav-item" to="/profile/">
              LOGO HERE
            </router-link>
          </div>

          <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
          </span>

          <div class="nav-right nav-menu">
            <span class="nav-item">
              <router-link class="button is-primary is-inverted" :class="{ 'is-disabled': areButtonsDisabled }" to="/profile/">
                <span class="icon">
                  <i class="fa fa-user"></i>
                </span>
                <span>Profile</span>
              </router-link>
            </span>

            <span class="nav-item">
              <router-link class="button is-primary is-inverted" :class="{ 'is-disabled': areButtonsDisabled }" to="/friends/">
                <span class="icon">
                  <i class="fa fa-users"></i>
                </span>
                <span>Friends</span>
              </router-link>
            </span>

            <span class="nav-item">
              <a class="button is-primary is-inverted" :class="{ 'is-disabled': areButtonsDisabled }" v-on:click="logout">
                <span class="icon">
                  <i class="fa fa-sign-out"></i>
                </span>
                <span>Logout</span>
              </a>
            </span>
          </div>

        </div>
      </header>
    </div>

    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          {{title}}
        </h1>
        <h2 class="subtitle">
          {{username}}
        </h2>
      </div>
    </div>
  </section>
</template>

<script type="text/babel">
  export default {
    props: ['title', 'buttonsDisabled'],
    data () {
      return {}
    },
    computed: {
      username: function () {
        if (typeof this.$route.params['user'] !== 'undefined') {
          return this.$route.params['user'];
        }

        return sessionStorage.getItem('username');
      },
      areButtonsDisabled: function() {
        if (typeof this.buttonsDisabled === 'undefined') {
          return false;
        }

        return this.buttonsDisabled;
      }
    },
    methods: {
      logout: function(event) {
        var successCallback = function (response) {
          if (response.body === 'success') {
            sessionStorage.removeItem('loggedIn');
            sessionStorage.removeItem('username');

            this.$router.push('/login');
          }
          else {
            console.log(response.body);
          }
        };

        var errorCallback = function (response) {
          console.log(response);
        };

        this.$http.post(phpLocation + 'logout.php').then(successCallback, errorCallback);
      }
    }
  }
</script>

<style>
</style>
