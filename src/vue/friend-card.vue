<template>
  <div class="card is-fullwidth">
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <figure class="image is-32x32">
            <router-link ref="usernameLink" :to="userProfile"><img src="http://placehold.it/64x64" alt="Image"></router-link>
          </figure>
        </div>

        <div class="media-content">
          <p class="title is-5"><router-link ref="usernameLink" :to="userProfile">{{ username }}</router-link></p>
          <p class="subtitle is-6"><router-link ref="usernameLink" :to="userProfile">{{ email }}</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
  export default {
    props: ['username', 'email'],
    data () {
      return {
      }
    },
    computed: {
      userProfile: function () {
        return '/profile/' + this.username;
      }
    }
  }
</script>

<style>
</style>
