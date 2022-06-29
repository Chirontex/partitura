import './blog.css'

const BlogClient = require('./src/Client/BlogClient');
const FadeIn = require('./src/Effect/FadeIn');

const requestPosts = (page = undefined, limit = undefined) => {
    // TODO: добавить обработчик и заменить им консоль
    (new BlogClient(console.log))
        .setPage(page)
        .setLimit(limit)
        .requestPosts();
};

requestPosts();

(() => {
    // TODO: Убрать после добавления обработчика
    const posts = document.getElementsByClassName("blog-post");
    const paginations = document.getElementsByClassName("blog-pagination");
    let lastDelay;

    for (let i = 0; i < posts.length; i++)
    {
        lastDelay = 500 * i;
        (new FadeIn(posts[i], lastDelay));
    }

    for (let i = 0; i < paginations.length; i++)
    {
        (new FadeIn(paginations[i], lastDelay));
    }
})()
