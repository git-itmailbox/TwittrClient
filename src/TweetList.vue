<template>
  <b-list-group>
    <b-list-group-item v-for="(tweet, key) in tweets" :key="key">
      <div class="row">
        <div class="col-2 col-md-1"><img :src="tweet.user.profile_image_url" alt=""></div>
        <div class="col-10 col-md-11">{{tweet.text}}
          <br />
          <small>@{{tweet.user.screen_name}} ({{tweet.user.name}})</small>
          <br />
          <small>{{tweet.created_at}}</small>
        </div>
      </div>
    </b-list-group-item>
  </b-list-group>
</template>

<script>
export default {

  props:{
    tweets : Array
  },
  data(){
    return {
    }
  }
}
</script>
