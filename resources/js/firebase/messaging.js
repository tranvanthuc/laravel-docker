import InitFirebase from './init'

class Index extends InitFirebase {
  constructor(){
    super()
    this.sendMessage()
  }

  sendMessage(){
    this.messaging.requestPermission().then(function () {
      console.log('Notification permission granted.')
      // TODO(developer): Retrieve an Instance ID token for use with FCM.
      // ...
    }).catch(function (err) {
      console.log('Unable to get permission to notify.', err)
    })
    this.messaging.getToken().then(function (currentToken) {
      if (currentToken) {
        console.log(currentToken)
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.')
        // Show permission UI.
      }
    }).catch(function (err) {
      console.log('An error occurred while retrieving token. ', err)
    })
  }
}

new Index()
