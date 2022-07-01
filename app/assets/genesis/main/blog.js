import './blog.css'

const BlogClient = require('./src/Client/BlogClient');
const BlogHandler = require('./src/Handler/BlogHandler');

const limit = 3;
const requestPosts = (page = undefined, limit = undefined) => {
    (new BlogClient(
        (new BlogHandler(page))
            .setLimit(limit)
            .setRequestPostsFunc(requestPosts)
            .handleBlog
    ))
        .setPage(page)
        .setLimit(limit)
        .requestPosts();
};

requestPosts(1, limit);
