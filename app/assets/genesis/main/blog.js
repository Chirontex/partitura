import './blog.css'

const FadeIn = require('./src/Effects/FadeIn');

(() => {
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
