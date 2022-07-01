'use strict';

const FadeIn = require('../Effect/FadeIn');
const ClassHandler = require('./ClassHandler');

/**
 * Class BlogHandler
 * @package Partitura.Genesis.Main.Handler
 */
class BlogHandler
{
    /** @var {HTMLElement} */
    #main;

    /** @var {number} */
    #page;

    /** @var {number} */
    #limit;

    /** @var {Function} */
    #requestPostsFunc;

    /** @var {string} */
    static preloader = "";

    constructor(page)
    {
        this.#page = page;
        this.#initializeMain();
    }

    /**
     * @param {number} limit
     * @returns {this}
     */
    setLimit = (limit) => {
        this.#limit = limit;

        return this;
    }

    /**
     * @param {string} requestPostsFuncName
     * @returns {this}
     */
    setRequestPostsFunc = (requestPostsFunc) => {
        this.#requestPostsFunc = requestPostsFunc;

        return this;
    }

    /**
     * @param {object} blogResponse
     */
    handleBlog = (blogResponse) => {
        const posts = this.#handlePostCollection(blogResponse.posts);

        if (posts.length == 0)
        {
            this.#setEmptyBlog();

            return;
        }

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

    #setEmptyBlog = () => {
        const message = document.createElement("p");
        message.setAttribute("class", "blog-empty");
        message.setAttribute("style", "opacity: 0%");
        message.innerHTML = "Записи не найдены.";

        const mainClasses = ClassHandler.explodeClass(this.#main.getAttribute("class"));
        mainClasses.push("text-center");

        this.#main.setAttribute("class", ClassHandler.implodeClass(mainClasses));
        this.#main.appendChild(message);
        (new FadeIn(message));
    }

    /**
     * @param {object[]} postCollection 
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
         * @param {string} content
         * @param {number} pageLink
         * @returns {HTMLElement}
         */
        const createLi = (isActive, isDisabled, content, pageLink) => {
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

            if (!isActive && !isDisabled)
            {
                a.setAttribute("href", "javascript:void(0)");
                a.onclick = () => {
                    const mainClasses = ClassHandler.explodeClass(this.#main.getAttribute("class"));
                    mainClasses.push("text-center");
                    this.#main.setAttribute("class", ClassHandler.implodeClass(mainClasses));
                    this.#main.innerHTML = BlogHandler.preloader;

                    this.#requestPostsFunc(pageLink, this.#limit);
                };
            }

            a.setAttribute("class", aClass);
            a.innerHTML = content;

            li.setAttribute("class", liClass);
            li.appendChild(a);

            return li;
        };

        ul.appendChild(createLi(false, page == 1, "«", page - 1));

        for (let i = 1; i <= pages; i++)
        {
            ul.appendChild(createLi(i == page, false, i, i));
        }

        ul.appendChild(createLi(false, page == pages, "»", page + 1));
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

        const mainClass = ClassHandler.explodeClass(this.#main.getAttribute("class"));

        this.#main.setAttribute(
            "class",
            ClassHandler.implodeClass(mainClass.filter(
                (value) => {
                    return value != "text-center";
                }
            )));
        BlogHandler.preloader = this.#main.innerHTML;
        this.#main.innerHTML = "";
    }
}

module.exports = BlogHandler;
