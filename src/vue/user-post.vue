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
          <p class="title is-5"><router-link ref="usernameLink" :to="userProfile">{{ data.firstName }} {{ data.lastName }} (@{{ data.username }})</router-link></p>
          <p class="subtitle is-6"><router-link ref="usernameLink" :to="userProfile">{{ data.time }}</router-link></p>
        </div>
      </div>

      <div class="content">
        <pre>{{ data.message }}</pre>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
  export default {
    props: ['data'],
    data () {
      return {
      }
    },
    computed: {
      userProfile: function () {
        return '/profile/' + this.data.username;
      }
    }
  }
</script>

<style>
  .content pre {
    background-color: inherit;
  }
</style>
