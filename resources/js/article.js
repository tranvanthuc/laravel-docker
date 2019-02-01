import axios from 'axios';

class Article {
  constructor() {
    this.config();
    this.listen();
    this.size = 10;
  }

  config() {
    this.apiUrl = 'http://localhost:8080/api/';
    this.element = {
      input: {
        search: $('#search')
      },
      button: {
        loadMore: $('#load-more')
      },
      body: $('.panel-body')
    };
  }

  listen() {
    this.search(this.size);
    this.loadMore();
    this.handleOnScroll();
  }

  handleOnScroll() {
    const self = this;
    window.onscroll = function () {
      const { element: { input: { search: inputSearch }} } = self;
      const value = inputSearch.val();
      let scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
      let scrollHeight = (document.documentElement && document.documentElement.scrollHeight) || document.body.scrollHeight;
      let clientHeight = document.documentElement.clientHeight || window.innerHeight;
      let scrolledToBottom = Math.ceil(scrollTop + clientHeight) >= scrollHeight;

      // scroll load more
      if (scrolledToBottom) {
        self.size += 10;
        self.fetchArticles(value, self.size)
      }
    }
  }

  loadMore() {
    const { element: { input: { search: inputSearch }, button: { loadMore: btnLoadMore } } } = this;
    const value = inputSearch.val();
    // click load more
    btnLoadMore.click(() => {
      this.size += 10;
      this.fetchArticles(value, this.size)
    });

  }

  fetchArticles(value, size) {
    const { apiUrl, element: { body } } = this;
    axios({
      method: 'get',
      url: apiUrl + 'article',
      params: {
        query: value,
        size: size
      }
    }).then(({ data }) => {
      body.html(data)
    })
      .catch(error => {
        console.log(error);
      })
  }

  search(size) {
    const { element: { input } } = this;
    let inputSearch = input.search;
    inputSearch.keydown((e) => {
      if (e.keyCode === 13) {
        const { target: { value } } = e;
        this.size = 10;
        this.fetchArticles(value, size)
      }
    })
  }
}

new Article();
