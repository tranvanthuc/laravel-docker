import Init from "./init"

class Authenticate extends Init {
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
      input: {
        email   : $('#txtEmail'),
        password: $('#txtPassword')
      },
      btn  : {
        login : $('#btnLogin'),
        signUp: $('#btnSignUp'),
        logout: $('#btnLogOut'),
        loginFacebook: $('#withFacebook'),
        loginGoogle: $('#withGoogle'),
        loginTwitter: $('#withTwitter'),
        loginGithub: $('#withGithub')
      }
    }
  }

  listen() {
    this.authenticate()
    this.loginWithFacebook()
    this.loginWithGithub()
    this.loginWithGoogle()
    this.loginWithTwitter()
  }

  loginWithFacebook() {
    // login fb
    const self = this;
    this.element.btn.loginFacebook.on('click', () => {
      console.log('login with fb')
      const provider = new this.firebase.auth.FacebookAuthProvider();
      this.auth.signInWithPopup(provider)
          .then(({ additionalUserInfo: {providerId, profile } }) => {
            const user = {
              name: profile.name,
              avatar: profile.picture.data.url,
              email: profile.email,
              providerId
            }
            self.addUser(user)
            console.log('login facebook success!')
          })
          .catch(e => console.log(e))
    })
  }

  loginWithGoogle() {
    // login gg
    const self = this;
    this.element.btn.loginGoogle.on('click', () => {
      console.log('login with gg')
      const provider = new this.firebase.auth.GoogleAuthProvider();
      this.auth.signInWithPopup(provider)
          .then(({ additionalUserInfo: {providerId, profile } }) => {
            const user = {
              name: profile.name,
              avatar: profile.picture,
              email: profile.email,
              providerId
            }
            self.addUser(user)
            console.log('login google success!')
          })
          .catch(e => console.log(e))
    })
  }

  loginWithTwitter() {
    // login twitter
    const self = this;
    this.element.btn.loginTwitter.on('click', () => {
      console.log('login with twitter')
      const provider = new this.firebase.auth.TwitterAuthProvider();
      this.auth.signInWithPopup(provider)
          .then(({ additionalUserInfo: {providerId, profile } }) => {
            const user = {
              name: profile.name,
              avatar: profile.profile_image_url_https,
              providerId
            }
            self.addUser(user)
            console.log('login twitter success!')
          })
          .catch(e => console.log(e))
    })
  }

  loginWithGithub() {
    // login github
    const self = this;
    this.element.btn.loginGithub.on('click', () => {
      console.log('login with github')
      const provider = new this.firebase.auth.GithubAuthProvider();
      this.auth.signInWithPopup(provider)
          .then(({ additionalUserInfo: {providerId, profile } }) => {
            const user = {
              name: profile.name,
              avatar: profile.avatar_url,
              providerId
            }
            self.addUser(user)
            console.log('login github success!')
          })
          .catch(e => console.log(e))
    })
  }

  addUser(user) {
    this.firestore.collection('users').add(user)
  }

  authenticate() {

    const { input: { email, password }, btn: {login: btnLogin, signUp: btnSignUp, logout: btnLogout } } = this.element

    // log in
    btnLogin.on('click', () => {
      this.auth.signInWithEmailAndPassword(email.val(), password.val()).catch(err => console.log(err))

    })

    // log out
    btnLogout.on('click', () => {
      this.auth.signOut().catch(e => console.log(e))
      console.log('Logged out')
    })

    // sign up
    btnSignUp.on('click', () => {
      console.log('signup')
      this.auth.createUserWithEmailAndPassword(email.val(), password.val()).then(() => console.log('Create user success!')).catch(e => console.log(e))
    })


    this.auth.onAuthStateChanged(user => {
      if (user) {
        console.log(user.uid)
        btnLogout.removeClass('hide')
      } else {
        btnLogout.addClass('hide')
      }
    })
  }
}

new Authenticate()
