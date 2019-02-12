import firebase from 'firebase';
import functions from 'firebase/functions';

class Firebase {
  constructor() {
    this.init();
  }

  init() {
    this.config();
    this.listen();
  }

  config() {
    const config = $('#config');
    const configFirebase = {
      apiKey: config.data('firebaseApiKey'),
      authDomain: config.data('firebaseProjectId') + ".firebaseapp.com",
      databaseURL: config.data('firebaseDatabaseUrl'),
      projectId: config.data('firebaseProjectId'),
      storageBucket: config.data('firebaseBucket'),
      messagingSenderId: config.data('firebaseSendId'),
    };
    firebase.initializeApp(configFirebase);
    this.database = firebase.database();

  }

  listen() {
    this.trigger();
  }

  trigger() {
    console.log("Hello");

    // this.database.ref('notifications').orderByChild('user_id').equalTo(1).on('value', snapshot => {
    //   console.log(snapshot.val())
    // }, errorObject => {
    //   console.log(errorObject);
    // })
    functions.database.ref('notifications/{noticeId}')
      .onWrite((change, context) => {
        console.log(context.params.noticeId);
        if (change.before.exists()) {
          return null;
        }
        // Exit when the data is deleted.
        if (!change.after.exists()) {
          return null;
        }
        // Grab the current value of what was written to the Realtime Database.
        const original = change.after.val();
        console.log('Uppercasing', context.params.pushId, original);
        const uppercase = original.toUpperCase();
        // You must return a Promise when performing asynchronous tasks inside a Functions such as
        // writing to the Firebase Realtime Database.
        // Setting an "uppercase" sibling in the Realtime Database returns a Promise.
        return change.after.ref.parent.child('uppercase').set(uppercase);
      })
  }
}

new Firebase();
