var sortId = 1;

Vue.component('paginate', VuejsPaginate);

const app = new Vue({
    el: '#app',
    data: {
        news: null,
        newsItemEditable: null,
        hasLoadedImage: false,
        uploadedImage: null,
        allNewsCount: null,
        newsOnPage: 4,
        pagesCount: 1,
        activePage: 1,
        isNewItem: false,
        fileMaxSizeMB: 5,
    },
    async created () {
        const data = await this.getNews();
        // сортируем новости, чтобы при добавлении новых оставлять текущий порадок без запросов к бд


    },
    methods: {
        async getNews() {
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                body: JSON.stringify({page: this.activePage - 1})
            };

            fetch("/getData", requestOptions)
                .then(async response => {
                    var data = await response.json();

                    if (!response.ok || data.error != undefined) {
                        const error = (data && data.message) || response.status;
                        return Promise.reject(data.error);
                    }

                    data.news.forEach(e => {
                        e.sortId = sortId++;
                    });
                    this.news = data.news;
                    this.newsOnPage = data.newsOnPage;
                    this.fileMaxSizeMB = data.fileMaxSizeMB;
                    this.allNewsCount = data.allNewsCount;
                    this.pagesCount = Math.ceil(this.allNewsCount / this.newsOnPage);
                    if (this.pagesCount == 0) {
                        this.pagesCount = 1;
                    }
                })
                .catch(error => {
                    // this.errorMessage = error;
                    alert('Ошибка при запросе данных! ' + error.message);
                });
        },
        addNews: function (addAndEdit = false) {
            this.newsItemEditable = {
                title: 'Новая новость',
                isDraft: true,
                sortId: sortId++,
            };
            this.isNewItem = true;
            if (addAndEdit) {
                var modal = this.$refs['modal'];
                modal.showModal();
            } else {
                this.saveNewsItem(this.newsItemEditable);
            }
        },
        editNews: function (e) {
            this.newsItemEditable = Object.assign({}, e);
            var modal = this.$refs['modal'];
            modal.showModal();
        },
        async deleteNews(e) {
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                body: JSON.stringify({newsData: e})
            };
            const response = await fetch("/deleteData", requestOptions);
            if (response.status != 200) {
                return false;
            }
            if (this.news.length == 1) {
                this.activePage--;
            }
            await this.getNews();

        },
        async saveModal() {
            if (await this.saveNewsItem()) {
                this.closeModal();
            }
        },
        async saveNewsItem () {
            var that = this;
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                body: JSON.stringify({newsData: that.newsItemEditable, hasNewImage: this.hasLoadedImage})
            };
            var res = fetch("/saveData", requestOptions)
                .then(async response => {
                    var data = await response.json();

                    if (!response.ok || data.error != undefined) {
                        const error = (data && data.message) || response.status;
                        return Promise.reject(data.error);
                    }

                    var savedNews = data;

                    if (! that.isNewItem) {
                        that.addItemToNewsCollection(savedNews);
                    } else if (that.activePage < that.pagesCount) {
                        that.activePage = that.pagesCount;
                        await that.getNews();
                        that.isNewItem = false;
                        return true;
                    } else if (that.activePage == that.pagesCount) {
                        if (that.news.length < that.newsOnPage) {
                            that.addItemToNewsCollection(savedNews);
                        } else {
                            that.pagesCount++;
                            that.allNewsCount = 1;
                            that.activePage = that.pagesCount;
                            that.news = [savedNews];
                        }
                    }

                    that.isNewItem = false;
                    return true;
                })
                .catch(error => {
                    alert("Ошибка при сохранении формы: " + error.message);
                    return false;
                });

            return res;
        },
        addItemToNewsCollection: function (newsItem) {
            this.news = this.news.filter(obj => obj.id != newsItem.id);
            newsItem.sortId = this.newsItemEditable.sortId;
            this.newsItemEditable.image = newsItem.image;
            this.news.push(newsItem);
            this.news.sort((a, b) => {
                return a.sortId - b.sortId;
            });
        },
        closeModal: function () {
            var modal = this.$refs['modal'];
            this.hasLoadedImage = false;
            modal.close();
        },
        uploadFile: function () {
            var that = this;
            var file = that.$refs['modalFile'].files[0];
            if (file.size > that.fileMaxSizeMB * 1024 * 1024) {
                //todo: тут нужно сделать так, чтобы в форме в загрузке файла не подтягивалось имя неправильно загруженного
                alert("Файл должен быть меньше " + that.fileMaxSizeMB + " Мб. У вас " + (file.size / (1024 * 1024)).toFixed(2) + " Мб");
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            that.uploadedImage = file;
            reader.onload = function () {
                that.hasLoadedImage = true;
                that.newsItemEditable.image = reader.result;
            };
            return true;
        },
        clickCallback: function (pageNum) {
            this.activePage = pageNum;
            this.getNews();
        },
    }
});