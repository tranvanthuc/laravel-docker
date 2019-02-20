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
        logout: $('#btnLogOut')
      }
    }
  }

  listen() {
    this.authen()
  }

  authen() {
    const { input: { email, password }, btn: { login: btnLogin, signUp: btnSignUp, logout: btnLogout } } = this.element

    // log in
    btnLogin.on('click', () => {
      this.auth.signInWithEmailAndPassword(email.val(), password.val()).catch(err => console.log(err))
      this.auth.onAuthStateChanged(user => {
        if (user) {
          console.log(user.uid)
          btnLogout.removeClass('hide')
        } else {
          btnLogout.addClass('hide')
        }
      })
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
  }
}

new Authenticate()
