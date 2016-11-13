<template xmlns:v-on="http://www.w3.org/1999/xhtml">
  <div>

    <hero-header title="Friends"></hero-header>

    <section class="section">
      <div class="container">

        <friend-list></friend-list>

      </div>
    </section>

  </div>
</template>

<script type="text/babel">
  import Vue from 'vue'
  import HeroHeader from './hero-header.vue'
  import FriendList from './friend-list.vue'

  export default {
    components: {HeroHeader, FriendList},
    data () {
      return {}
    },
    computed: {
      username: function () {
        if (typeof this.$route.params['user'] !== 'undefined') {
          return this.$route.params['user'];
        }

        return sessionStorage.getItem('username');
      }
    }
  }
</script>

<style>
</style>
