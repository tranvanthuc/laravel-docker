class Follow {
  constructor() {
    this.init();
  }

  init(){
    this.config();
    this.listen();
  }

  config() {
    this.input = {
      userId: $('#user-id')
    }
  }

  listen() {
    this.getNotice()
  }

  getNotice() {
    console.log("Notice");
    const userId = this.input.userId.val();
    console.log('userId', userId);
    if (window.Echo &&  userId) {
      console.log('Start notice');
      window.Echo.private(`App.User.${userId}`)
        .listen('UserFollowed', e => {
          console.log(e);
        });
    }

  }
}

new Follow();
