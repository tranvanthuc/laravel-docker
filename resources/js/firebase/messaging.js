import InitFirebase from './init'
import _ from "lodash"



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
    this.element = {
      btn: $('#btn')
    }
  }

  listen() {
    this.sendMessage()
    this.pushAllMessage()
    this.test();
  }

  test() {
    console.log('test');
    this.firestore.collection('tokens').get().then(querySnapshot => {
      querySnapshot.forEach(doc => {
        console.log(doc.data())
      })
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

  pushAllMessage() {
    const self = this
    self.element.btn.on('click', () => {
      self.firestore.collection('posts')
        .add({
          title: "Hello " + Math.random(),
          content: "Content"
        })
        .catch(function (error) {
          console.log("Error getting documents: ", error)
        })
    })
  }
}

new Index()
