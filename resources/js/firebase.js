import firebase from "firebase";

class Firebase {
    constructor() {
        this.init();
    }

    init() {
        this.config();
        this.listen();
    }

    config() {
        const config = $("#config");
        const configFirebase = {
            apiKey: config.data("firebaseApiKey"),
            authDomain: config.data("firebaseProjectId") + ".firebaseapp.com",
            databaseURL: config.data("firebaseDatabaseUrl"),
            projectId: config.data("firebaseProjectId"),
            storageBucket: config.data("firebaseBucket"),
            messagingSenderId: config.data("firebaseSendId")
        };
        firebase.initializeApp(configFirebase);
        this.database = firebase.database();
        this.firestore = firebase.firestore();
    }

    listen() {
        this.trigger();
    }

    trigger() {
        this.firestore
            .collection("users")
            .add({
                first: "thuc",
                last: "tran",
                gender: "male"
            })
            .then(function(docRef) {
                console.log("Document written with ID: ", docRef.id);
            })
            .catch(function(error) {
                console.error("Error adding document: ", error);
            });
    }
}

new Firebase();
