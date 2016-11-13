<template xmlns:v-on="http://www.w3.org/1999/xhtml">

  <div>

    <hero-header title="Register" buttonsDisabled="true"></hero-header>

    <section class="section">
      <div class="container">
        <h1 class="title">Register</h1>
        <h2 class="subtitle">
          Please fill out all of the fields below and click "Confirm" to create a new account.
        </h2>

        <hr>

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

          <label class="label">Confirm Password</label>
          <p id="confirmPasswordControl" class="control has-icon">
            <input class="input" type="password" placeholder="Confirm Password" name="confirmPassword">
            <i class="fa fa-lock"></i>
          </p>

          <label class="label">First Name</label>
          <p id="firstNameControl" class="control has-icon">
            <input class="input" type="email" placeholder="First Name" name="firstName">
            <i class="fa fa-envelope"></i>
          </p>

          <label class="label">Last Name</label>
          <p id="lastNameControl" class="control has-icon">
            <input class="input" type="email" placeholder="Last Name" name="lastName">
            <i class="fa fa-envelope"></i>
          </p>

          <label class="label">Email</label>
          <p id="emailControl" class="control has-icon">
            <input class="input" type="email" placeholder="Email" name="email">
            <i class="fa fa-envelope"></i>
          </p>

          <a class="button is-success is-fullwidth" v-on:click="register">Confirm</a>
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
      register: function (event) {
        var inputControls = {
          "username": $('#usernameControl'),
          "password": $('#passwordControl'),
          "confirmPassword": $('#confirmPasswordControl'),
          "firstName": $('#firstNameControl'),
          "lastName": $('#lastNameControl'),
          "email": $('#emailControl')
        };

        for (var key in inputControls) {
          if (inputControls.hasOwnProperty(key)) {
            this.clearWarning(inputControls[key]);
          }
        }

        var successCallback = function (response) {
          if (response.body === 'success') {
            this.$router.push('/login');
          }
          else if (response.body === 'ERROR 6') {
            this.showWarning(inputControls['username'], 'Usernames must be between 6 and 255 characters long.');
          }
          else if (response.body === 'ERROR 7') {
            this.showWarning(inputControls['password'], 'Passwords must be between 6 and 255 characters long.');
          }
          else if (response.body === 'ERROR 8') {
            this.showWarning(inputControls['email'], 'Invalid email provided.');
          }
          else if (response.body === 'ERROR 10') {
            this.showWarning(inputControls['username'], 'This username is already taken.');
          }
          else {
            console.log(response.body);
          }
        };

        var errorCallback = function (response) {
          console.log(response);
        };

        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        var confirmPassword = $('input[name="confirmPassword"]').val();
        var firstName = $('input[name="firstName"]').val();
        var lastName = $('input[name="lastName"]').val();
        var email = $('input[name="email"]').val();

        var valid = true;

        if (username === '') {
          valid = false;

          this.showWarning(inputControls['username'], 'This field is required.');
        }
        else if (password === '') {
          valid = false;

          this.showWarning(inputControls['password'], 'This field is required.');
        }
        else if (firstName === '') {
          valid = false;

          this.showWarning(inputControls['firstName'], 'This field is required.');
        }
        else if (lastName === '') {
          valid = false;

          this.showWarning(inputControls['lastName'], 'This field is required.');
        }
        else if (email === '') {
          valid = false;

          this.showWarning(inputControls['email'], 'This field is required.');
        }
        else if (password !== confirmPassword) {
          valid = false;

          this.showWarning(inputControls['confirmPassword'], 'The entered passwords do not match.');
        }

        if (valid) {
          var params = {"username": username, "password": password, "firstName": firstName, "lastName": lastName, "email": email};

          this.$http.post(phpLocation + 'register.php', params).then(successCallback, errorCallback);
        }
        else {
          console.log('invalid info entered');
        }
      }
    }
  }
</script>

<style>
</style>
