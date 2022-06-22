import './blog.css'

const FadeIn = require('../main/src/Effects/FadeIn');

(() => {
    const posts = document.getElementsByClassName("blog-post");

    for (let i = 0; i < posts.length; i++)
    {
        (new FadeIn(posts[i], 500 * i));
    }
})()
