import './blog.css'

const FadeIn = require('../main/src/Effects/FadeIn');

(() => {
    const posts = document.getElementsByClassName("blog-post");
    const paginations = document.getElementsByClassName("blog-pagination");
    let lastFade;

    for (let i = 0; i < posts.length; i++)
    {
        lastFade = 500 * i;
        (new FadeIn(posts[i], lastFade));
    }

    for (let i = 0; i < paginations.length; i++)
    {
        (new FadeIn(paginations[i], lastFade));
    }
})()
