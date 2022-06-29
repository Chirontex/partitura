'use strict'

const FadeIn = require('../Effect/FadeIn');

/**
 * Class BlogHandler
 * @package Partitura.Genesis.Main.Handler
 */
class BlogHandler
{
    /** @var {HTMLElement} */
    #main;
    #page;

    constructor(page)
    {
        this.#page = page;
        this.#initializeMain();
    }

    /**
     * @param {object} blogResponse
     */
    handleBlog = (blogResponse) => {
        const posts = this.#handlePostCollection(blogResponse.posts);
        const pagination = this.#createPagination(this.#page, blogResponse.pages);
        let lastPostDelay;

        for (let i = 0; i < posts.length; i++)
        {
            this.#main.appendChild(posts[i]);
            lastPostDelay = 500 * i;
            (new FadeIn(posts[i], lastPostDelay));
        }

        this.#main.appendChild(pagination);
        (new FadeIn(pagination, lastPostDelay));
    }

    /**
     * @param {*} postCollection 
     * @returns {HTMLElement[]}
     */
    #handlePostCollection = (postCollection) => {
        const blogPostCollection = [];

        for (let i = 0; i < postCollection.length; i++)
        {
            blogPostCollection.push(this.#createBlogPostElement(postCollection[i]));
        }

        return blogPostCollection;
    }

    /**
     * 
     * @param {object} postObject 
     * @returns {HTMLElement}
     */
    #createBlogPostElement = (postObject) => {
        const blogPost = document.createElement("div");
        blogPost.setAttribute("class", "blog-post");
        blogPost.setAttribute("style", "opacity: 0%");

        const postHeader = document.createElement("h1");
        postHeader.innerHTML = postObject.title;

        const postPreview = document.createElement("p");
        postPreview.setAttribute("class", "main-text blog-text");
        postPreview.innerHTML = postObject.preview;

        blogPost.appendChild(postHeader);
        blogPost.appendChild(postPreview);

        return blogPost;
    }

    /**
     * @param {number} page 
     * @param {number} pages 
     * @returns {HTMLElement}
     */
    #createPagination = (page, pages) => {
        const nav = document.createElement("nav");
        nav.setAttribute("aria-label", "Blog pagination");
        nav.setAttribute("class", "blog-pagination");
        nav.setAttribute("style", "opacity: 0%");

        const ul = document.createElement("ul");
        ul.setAttribute("class", "pagination justify-content-center");

        /**
         * @param {boolean} isActive 
         * @param {boolean} isDisabled 
         * @param {*} content 
         * @returns {HTMLElement}
         */
        const createLi = (isActive, isDisabled, content) => {
            const li = document.createElement("li");
            let liClass = "page-item";
            const a = document.createElement("a");
            let aClass = "page-link";

            if (isActive)
            {
                aClass += " page-active";
            }

            if (isDisabled)
            {
                liClass += " disabled";
                aClass += " page-disabled";
            }

            a.setAttribute("class", aClass);
            a.innerHTML = content;

            li.setAttribute("class", liClass);
            li.appendChild(a);

            return li;
        };

        ul.appendChild(createLi(false, page == 1, "«"));

        for (let i = 1; i <= pages; i++)
        {
            ul.appendChild(createLi(i == page, false, i));
        }

        ul.appendChild(createLi(false, page == pages, "»"));

        nav.appendChild(ul);

        return nav;
    }

    /**
     * @throws {Error}
     */
    #initializeMain = () => {
        const mainCollection = document.getElementsByTagName("main");
        this.#main = mainCollection[0];

        if (this.#main == null || this.#main == undefined)
        {
            throw new Error("Main block not found.");
        }

        this.#main.setAttribute("class", "main-blog");
        this.#main.innerHTML = "";
    }
}

module.exports = BlogHandler;
