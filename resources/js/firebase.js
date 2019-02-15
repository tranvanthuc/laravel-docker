import firebase from 'firebase';

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
      messagingSenderId: "" +config.data('firebaseSenderId'),
    };
    try {
      console.log(configFirebase);
      firebase.initializeApp(configFirebase);

      this.database = firebase.database();
      this.messaging = firebase.messaging();
      this.messaging.usePublicVapidKey(config.data('firebasePublicKey'));
      this.firestore = firebase.firestore();

    } catch (e) {
      console.log(e)
    }
    this.btn = {
      testFirestore: $('#btn-test')
    }
  }

  listen() {
    this.realTime();
    this.message();
  }

  async realTime() {
    console.log("Hello");

    // const citiesRef = await this.firestore.collection("cities");
    //
    // citiesRef.doc("SF").set({
    //   name: "San Francisco", state: "CA", country: "USA",
    //   capital: false, population: 860000,
    //   regions: ["west_coast", "norcal"]
    // });
    // citiesRef.doc("LA").set({
    //   name: "Los Angeles", state: "CA", country: "USA",
    //   capital: false, population: 3900000,
    //   regions: ["west_coast", "socal"]
    // });
    // citiesRef.doc("DC").set({
    //   name: "Washington, D.C.", state: null, country: "USA",
    //   capital: true, population: 680000,
    //   regions: ["east_coast"]
    // });
    // citiesRef.doc("TOK").set({
    //   name: "Tokyo", state: null, country: "Japan",
    //   capital: true, population: 9000000,
    //   regions: ["kanto", "honshu"]
    // });
    // citiesRef.doc("BJ").set({
    //   name: "Beijing", state: null, country: "China",
    //   capital: true, population: 21500000,
    //   regions: ["jingjinji", "hebei"]
    // });

    // ## pagination
    // const first = this.firestore.collection("cities")
    //   .limit(3).get().then(snapshot => {
    //     console.log(_.last(snapshot.docs).data())
    //   });

    //
    // const self = this;
    //
    // const fuck = await first.get().then(function (documentSnapshots) {
    //   // Get the last visible document
    //   var lastVisible = documentSnapshots.docs[documentSnapshots.docs.length - 1];
    //   console.log("last", lastVisible.data());
    //
    //   // Construct a new query starting at this document,
    //   // get the next 25 cities.
    //   var next = self.firestore.collection("cities")
    //     .orderBy("population")
    //     .startAfter(lastVisible)
    //     .limit(3);
    //   console.log(next);
    // });
    // console.log("fuck", fuck)

    // this.database.ref('notifications').on('value', snapshot => {
    //   console.log(snapshot.val())
    // }, errorObject => {
    //   console.log(errorObject);
    // }).
     const usersRef = this.firestore.collection('/users');
    // usersRef.orderBy("first").limit(3).get()
    //  // usersRef.where("first", "==", "thuc").get()
    //    .then(function(querySnapshot) {
    //      querySnapshot.forEach(function(doc) {
    //        // doc.data() is never undefined for query doc snapshots
    //        console.log(doc.id, " => ", doc.data());
    //      });
    //    })
    //    .catch(function(error) {
    //      console.log("Error getting documents: ", error);
    //    });
    //  this.btn.testFirestore.on('click', async function () {
    //
    //    const user = {
    //      first: "Manh " + Math.random(),
    //      last: "tien",
    //      gender: "female"
    //    };
    //    const userRef = await usersRef.add(user);
    //    console.log(userRef.id);
    //  });
    // //
    //  usersRef.onSnapshot({ includeMetadataChanges: true }, snapshot => {
    //    snapshot.docChanges().forEach(change => {
    //      if (change.type === "added") {
    //        console.log("New city: ", change.doc.data());
    //      }
    //      if (change.type === "modified") {
    //        console.log("Modified city: ", change.doc.data());
    //      }
    //      if (change.type === "removed") {
    //        console.log("Removed city: ", change.doc.data());
    //      }
    //    })
    //  })
  }

  message() {

    this.messaging.requestPermission().then(function() {
      console.log('Notification permission granted.');
      // TODO(developer): Retrieve an Instance ID token for use with FCM.
      // ...
    }).catch(function(err) {
      console.log('Unable to get permission to notify.', err);
    });
    this.messaging.getToken().then(function(currentToken) {
      if (currentToken) {
        console.log(currentToken)
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
      }
    }).catch(function(err) {
      console.log('An error occurred while retrieving token. ', err);
    });
  }
}

new Firebase();
