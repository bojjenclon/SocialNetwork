<template xmlns:v-on="http://www.w3.org/1999/xhtml">
  <div>

    <nav class="level">
      <div class="level-item has-text-centered">
        <p class="title">Say something to @{{ username }}!</p>
      </div>
    </nav>

    <div class="card is-fullwidth">

      <header class="card-header">
        <p class="card-header-title">
          Post Message
        </p>
      </header>

      <div class="card-content" id="self-post-content">
        <div class="content">
          <p class="control">
            <textarea name="message" class="textarea" id="message" placeholder="Message"></textarea>
          </p>
        </div>
      </div>

      <footer class="card-footer">
        <a class="card-footer-item" v-on:click="createPost">Post</a>
      </footer>

    </div>

  </div>

</template>

<script type="text/babel">
  export default {
    data () {
      return {
      }
    },
    computed: {
      username: function () {
        if (typeof this.$route.params['user'] !== 'undefined') {
          return this.$route.params['user'];
        }

        return '';
      }
    },
    methods: {
      createPost: function(event) {
        var successCallback = function (response) {
          if (response.body === 'success') {
            this.$events.emit('messagePosted');
          }
          else {
            console.log(response.body);
          }
        };

        var errorCallback = function (response) {
          console.log(response);
        };

        var message = $('textarea[name="message"]').val();
        var recipientName = this.username;

        var valid = true;

        if (message === '' || recipientName === '') {
          valid = false;
        }

        if (valid) {
          var params = {"message": message, "recipientName": recipientName};

          this.$http.post(phpLocation + 'addPost.php', params).then(successCallback, errorCallback);
        }
      }
    }
  }
</script>

<style>
  #message {
    border: none;
    box-shadow: none;
  }

  #self-post-content {
    padding: 0;
  }
</style>
