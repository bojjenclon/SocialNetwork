<template xmlns:v-on="http://www.w3.org/1999/xhtml">
  <div>

    <hero-header title="Login" buttonsDisabled="true"></hero-header>

    <section class="section">
      <div class="container">

        <div class="content">
          <label class="label">Username</label>
          <p id="usernameControl" class="control has-icon">
            <input class="input" type="text" placeholder="Username" name="username">
            <i class="fa fa-user"></i>
          </p>

          <label class="label">Password</label>
          <p id="passwordControl" class="control has-icon">
            <input class="input" type="password" placeholder="Password" name="password">
            <i class="fa fa-lock"></i>
          </p>

          <div class="columns">
            <div class="column">
              <a class="button is-success is-fullwidth" v-on:click="login">Login</a>
            </div>

            <div class="column">
              <router-link class="button is-info is-fullwidth" to="/register">Register</router-link>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>
</template>

<script type="text/babel">
  import HeroHeader from './hero-header.vue';

  export default {
    components: { HeroHeader },
    data () {
      return {
      }
    },
    methods: {
      clearWarning: function(control) {
        control.removeClass('has-icon-right');

        control.children('i.fa-warning').remove();
        control.children('i').show();

        control.children('span').remove();
        control.children('input').removeClass('is-danger');
      },
      showWarning: function(control, text) {
        control.addClass('has-icon-right');

        control.children('i').hide();
        control.append($('<i class="fa fa-warning"></i>'));

        var helper = $('<span class="help is-danger"></span>');
        helper.text(text);
        control.append(helper);

        control.children('input').addClass('is-danger');
      },
      login: function(event) {
        var inputControls = {
          "username": $('#usernameControl'),
          "password": $('#passwordControl')
        };

        for (var key in inputControls) {
          if (inputControls.hasOwnProperty(key)) {
            this.clearWarning(inputControls[key]);
          }
        }

        sessionStorage.removeItem('loggedIn');

        var successCallback = function (response) {
          if (response.body === 'success') {
            sessionStorage.setItem('loggedIn', true);

            this.$nextTick(function () {
              this.$router.push('/profile/');
            });
          }
          else {
            sessionStorage.removeItem('username');

            this.showWarning(inputControls['password'], 'Whoops, something went wrong! Please check your spelling and try again.');
          }
        };

        var errorCallback = function (response) {
          sessionStorage.removeItem('username');

          console.log(response);
        };

        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();

        var valid = true;

        if (username === '') {
          valid = false;

          this.showWarning(inputControls['username'], 'This field is required.');
        }
        else if (password === '') {
          valid = false;

          this.showWarning(inputControls['password'], 'This field is required.');
        }

        if (valid) {
          sessionStorage.setItem('username', username);

          var params = {"username": username, "password": password};

          this.$http.post(phpLocation + 'login.php', params).then(successCallback, errorCallback);
        }
      }
    }
  }
</script>

<style>
</style>
