import './blog.css'

const BlogClient = require('./src/Client/BlogClient');
const BlogHandler = require('./src/Handler/BlogHandler');

const requestPosts = (page = undefined, limit = undefined) => {
    (new BlogClient((new BlogHandler(page)).handleBlog))
        .setPage(page)
        .setLimit(limit)
        .requestPosts();
};

requestPosts(1);
