import axios from 'axios';

class Article {
  constructor() {
    this.axios = axios;
    this.config();
    this.listen();
  }

  config() {
    this.apiUrl = 'http://localhost:8080/api/'
    this.element = {
      input: {
        search: $('#search')
      },
      body: $('.panel-body')
    }
  }

  listen() {
    this.search();
  }

  search() {
    const {apiUrl, element: {body, input}} = this;
    let inputSearch = input.search;
    inputSearch.keyup(async ({target: {value}}) => {
      axios({
        method: 'get',
        url: apiUrl + 'article',
        params: {
          q: value
        }
      }).then(({data}) => {
        body.html(data)
      })
        .catch(error => {
          console.log(error);
        })
    })
  }
}

new Article();
