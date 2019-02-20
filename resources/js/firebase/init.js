import firebase from 'firebase/app'
import 'firebase/firestore'
import 'firebase/database'
import 'firebase/messaging'
import 'firebase/auth'

class Index {
  constructor() {
    try {
      const configFirebase = {
        apiKey           : "AIzaSyBfEQBNWYykyhecmxcdneKUa2bKsljEjbk",
        authDomain       : "fir-demo-7d357.firebaseapp.com",
        databaseURL      : "https://fir-demo-7d357.firebaseio.com",
        projectId        : "fir-demo-7d357",
        storageBucket    : "fir-demo-7d357.appspot.com",
        messagingSenderId: "51341052467"
      }
      firebase.initializeApp(configFirebase)

      this.database  = firebase.database()
      this.messaging = firebase.messaging()
      this.firestore = firebase.firestore()
      this.auth      = firebase.auth()

      this.messaging.usePublicVapidKey('BMRNtXh908y6yXIz2yr-qs7bWm26Jn6Q7aUP5ummPPEhYUXv0wHmafkZrYfmYqhYZpTVKJK2-RNeD9gpfwrsSso')

    } catch (e) {
      console.log(e)
    }
  }
}

export default Index
