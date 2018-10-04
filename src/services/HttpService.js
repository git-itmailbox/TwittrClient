import axios from 'axios'
export default {
  getTweets(success, error) {
    axios.get('http://localhost:8000')
      .then(response => {
        success(response.data);
      })
      .catch(e => {
        error(e)
      })
  },
  requestAddHashtag(success, error) {
    axios.get('http://localhost:8000/change_track/')
      .then(response => {
        success(response.data);
      })
      .catch(e => {
        error(e)
      })
  }


}
