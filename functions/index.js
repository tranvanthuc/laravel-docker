const faker = require('faker')
const functions = require('firebase-functions')
const admin = require('firebase-admin')

admin.initializeApp()

exports.modifyUser = functions.firestore
  .document('posts/{postId}')
  .onWrite((change, context) => {
    // Get an object with the current document value.
    // If the document does not exist, it has been deleted.
    const document = change.after.exists ? change.after.data() : null
    console.log('document', document)

    change.after.ref.firestore.collection('tokens').get().then(querySnapshot => {
      const tokens = []

      const payload = {
        notification: {
          title: document.author + " have a new article",
          body: faker.lorem.sentences(),
          icon: faker.internet.avatar(),
          click_action: faker.internet.avatar()
        }
      }
      querySnapshot.forEach(doc => {
        tokens.push(doc.data().token)
      })
      return admin.messaging().sendToDevice(tokens, payload)
    }).catch(err => {
      console.log(err)
    })


    // perform desired operations ...
  })

// // Create and Deploy Your First Cloud Functions
// // https://firebase.google.com/docs/functions/write-firebase-functions
//
// exports.helloWorld = functions.https.onRequest((request, response) => {
//  response.send("Hello from Firebase!");
// });
