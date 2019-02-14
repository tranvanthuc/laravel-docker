import axios from "axios";

class Article {
    constructor() {
        this.config();
        this.listen();
        this.size = 10;
        this.count = 0;
    }

    config() {
        this.apiUrl = "http://localhost:8080/api/";
        this.element = {
            input: {
                search: $("#search")
            },
            button: {
                loadMore: $("#load-more")
            },
            body: $(".panel-body"),
            list: $("#list-article")
        };
    }

    listen() {
        this.search(this.size);
        this.loadMore();
        this.handleOnScroll();
    }

    upCount() {
        this.count++;
    }

    resetCount() {
        this.count = 0;
    }

    checkScrolledOnBottom() {
        const scrollTop = $(window).scrollTop();
        const documentHeight = $(document).height();
        const windowHeight = $(window).height();
        const offsetBottom = 400;
        const scrolledToBottom =
            scrollTop >= documentHeight - windowHeight - offsetBottom;
        return scrolledToBottom;
    }

    handleOnScroll() {
        const self = this;
        window.onscroll = function() {
            const {
                element: {
                    input: { search: inputSearch }
                }
            } = self;
            const value = inputSearch.val();
            // scroll load more
            if (self.checkScrolledOnBottom()) {
                self.upCount();
                if (self.count === 1) {
                    self.size += 10;
                    self.fetchArticles(value, self.size);
                }
            }
        };
    }

    loadMore() {
        const {
            element: {
                input: { search: inputSearch },
                button: { loadMore: btnLoadMore }
            }
        } = this;
        const value = inputSearch.val();
        // click load more
        btnLoadMore.click(() => {
            this.size += 10;
            this.fetchArticles(value, this.size);
        });
    }

    fetchArticles(value, size) {
        const self = this;
        const {
            apiUrl,
            element: { body }
        } = this;
        axios({
            method: "get",
            url: apiUrl + "article",
            params: {
                query: value,
                size: size
            }
        })
            .then(({ data }) => {
                body.html(data);
                self.resetCount();
            })
            .catch(error => {
                console.log(error);
            });
    }

    search(size) {
        const {
            element: { input }
        } = this;
        let inputSearch = input.search;
        inputSearch.keydown(e => {
            if (e.keyCode === 13) {
                const {
                    target: { value }
                } = e;
                this.size = 10;
                this.fetchArticles(value, size);
            }
        });
    }
}

new Article();
