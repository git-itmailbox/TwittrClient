<template>

  <div class="container">
    <b-alert :show="dismissCountDown"
             dismissible
             variant="success"
             @dismissed="dismissCountDown=0"
             @dismiss-count-down="countDownChanged">
      <p>Successfully added</p>
      <b-progress variant="success"
                  :max="dismissSecs"
                  :value="dismissCountDown"
                  height="4px">
      </b-progress>
    </b-alert>
    <div class="row">
        <b-col sm="4"><label for="newHashtag">Listen to new hashtag:</label></b-col>
        <b-col sm="8"><b-form-input id="newHashtag" type="text"  v-model="newHashtag"></b-form-input></b-col>
      <b-col sm="4" offset="4">
        <b-button class="form-control" size="sm" variant="secondary" v-on:click="addHashtag">
          Add new
        </b-button>
      </b-col>
    </div>
    <div class="row">
      <div class="col">
       <h3>Real-time twitter client for hashtags: {{hashtags.toString()}}</h3>
        <b-form-group>
          <b-form-checkbox-group v-model="selectedHashtags" name="flavour1" :options="hashtags">
          </b-form-checkbox-group>
        </b-form-group>

        <tweet-list :tweets="tweets"></tweet-list>
      </div>
    </div>
  </div>

</template>

<script>
  import TweetList from './TweetList'
  import axios from 'axios'

  import HttpService from './services/HttpService'
  const Pusher = require('pusher-js');

  const socket = new Pusher('b33fef1f27e4946a4e83', {
    cluster: 'eu',
  });



  export default {
    data() {
      return {
        tweets: [],
        hashtags: [],
        newHashtag: '',
        dismissCountDown: 0,
        dismissSecs: 5,
        selectedHashtags:[]
      }
    },
    components: {
      TweetList: TweetList
    },
    created: function(){
      const channel = socket.subscribe('my-channel');
      channel.bind('my-event', (data) => {

        console.log(JSON.stringify(data));

        this.tweets = data.tweets

        this.hashtags = data.hashtags
      });

    },

    methods: {
      addHashtag: function() {
        axios.get('http://localhost:8000/add_track/'+this.newHashtag)
          .then(response => {
            this.dismissCountDown = this.dismissSecs
            console.log(this.selectedHashtags)
            this.newHashtag = ''
          })
          .catch(e => {
            console.log(e)
          })
      },
      countDownChanged (dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
    }
  }
</script>
