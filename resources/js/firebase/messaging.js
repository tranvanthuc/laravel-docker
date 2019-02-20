import InitFirebase from './init'

class Index extends InitFirebase {
  constructor() {
    super()
    this.init()
  }

  init() {
    this.config()
    this.listen()
  }

  config() {
  }

  listen() {
    this.sendMessage()
    this.receieveMessage()
  }

  receieveMessage () {
    this.messaging.onMessage(payload => {
      console.log('Message received. ', payload);
    })
  }


  sendMessage() {
    const self = this
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
        self.firestore.collection('tokens')
          .where('token', "==", currentToken)
          .get()
          .then(function (querySnapshot) {

            if (querySnapshot.size === 0) {
              self.firestore.collection('tokens').add({
                token: currentToken
              })
                .then(function (docRef) {
                  console.log("Document written with ID: ", docRef.id)
                })
                .catch(function (error) {
                  console.error("Error adding document: ", error)
                })
            }
          })
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
