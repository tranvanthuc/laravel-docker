import InitFirebase from './init'
import faker from "faker"

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
      btn: $('#btn-create-post')
    }
  }

  listen() {
    this.createPost()
    this.receieveMessage();
  }

  receieveMessage () {
    this.messaging.onMessage(payload => {
      console.log('Message received. ', payload);
    })
  }

  createPost() {
    const self = this
    self.element.btn.on('click', () => {

      const data = {
        author: faker.name.firstName(1),
        title: faker.lorem.sentence(),
        content: faker.lorem.sentences()
      }
      self.firestore.collection('posts')
        .add(data)
        .then(doc => console.log('Article id: ' + doc.id))
        .catch(function (error) {
          console.log("Error getting documents: ", error)
        })
    })
  }
}

new Index()
