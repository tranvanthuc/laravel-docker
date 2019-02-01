import Echo from "laravel-echo";

class Notice {
  constructor() {
    this.config();
    this.listen();
  }

  config() {
    this.btn = $('#btn-js')
  }

  listen() {
    this.btn.on('click', function () {
      window.axios({
        method: "get",
        url: location.origin + "/messages",
      }).then(res => console.log(res))
    });


    console.log("notice");
    if (!window.Echo) {
      window.Pusher = require('pusher-js');
      window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true
      });
    }

    console.log("ASdasd");
    window.Echo.channel('messages')
      .listen('.newMessage', (message) => {
        console.log(message)
      });
    console.log("Fuck csadkasdkasd");
  }
}

new Notice();
