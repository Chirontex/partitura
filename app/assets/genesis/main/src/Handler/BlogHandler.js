'use strict';

const ElementClass = require('../Repository/ElementClass');
const ElementStyle = require('../Repository/ElementStyle');
const FadeIn = require('../Effect/FadeIn');
const Highlighter = require('../Effect/Highlighter');

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
        (new ElementClass(message)).addClass("blog-empty").apply();
        (new ElementStyle(message)).setStyle("opacity", "0%").apply();
        message.innerHTML = "Записи не найдены.";

        (new ElementClass(this.#main)).addClass("text-center").apply();

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
        (new ElementClass(blogPost)).addClass("blog-post").apply();
        (new ElementStyle(blogPost)).setStyle("opacity", "0%").apply();

        const postHeader = document.createElement("h1");
        postHeader.innerHTML = postObject.title;

        const postPreview = document.createElement("p");
        (new ElementClass(postPreview))
            .addClass("main-text")
            .addClass("blog-text")
            .apply();

        postPreview.innerHTML = postObject.preview;

        blogPost.appendChild(postHeader);
        blogPost.appendChild(postPreview);

        blogPost.onmouseenter = () => {
            (new Highlighter(blogPost, "blog-post"))
                .setFooterContent("Читать далее →")
                .invoke();
        };
        blogPost.onmouseleave = () => {
            (new Highlighter(blogPost, "blog-post")).revoke();
        };
        blogPost.onclick = () => {
            window.location = postObject.uri;
        }

        blogPost.appendChild(this.#createPostFooter(postObject));

        return blogPost;
    }

    /**
     * @param {object} postObject 
     * @returns {HTMLElement}
     */
    #createPostFooter = (postObject) => {
        const postFooter = document.createElement("div");
        (new ElementClass(postFooter)).addClass("row").apply();

        const authorCol = document.createElement("div");
        (new ElementClass(authorCol))
            .addClass("col-xs-12")
            .addClass("col-sm-12")
            .addClass("col-md-auto")
            .addClass("col-lg-auto")
            .apply();

        const authorPar = document.createElement("p");
        (new ElementClass(authorPar)).addClass("main-text").apply();
        authorPar.innerHTML = "Автор: "+postObject.author;

        authorCol.appendChild(authorPar);
        postFooter.appendChild(authorCol);

        const dateCreatedCol = document.createElement("div");
        (new ElementClass(dateCreatedCol))
            .addClass("col-xs-12")
            .addClass("col-sm-12")
            .addClass("col-md-auto")
            .addClass("col-lg-auto")
            .apply();

        const dateCreatedPar = document.createElement("p");
        (new ElementClass(dateCreatedPar)).addClass("main-text").apply();
        dateCreatedPar.innerHTML = "Дата публикации: "+postObject.date_created;

        dateCreatedCol.appendChild(dateCreatedPar);
        postFooter.appendChild(dateCreatedCol);

        return postFooter;
    }

    /**
     * @param {number} page 
     * @param {number} pages 
     * @returns {HTMLElement}
     */
    #createPagination = (page, pages) => {
        const nav = document.createElement("nav");
        nav.setAttribute("aria-label", "Blog pagination");
        (new ElementClass(nav)).addClass("blog-pagination").apply();
        (new ElementStyle(nav)).setStyle("opacity", "0%").apply();

        const ul = document.createElement("ul");
        (new ElementClass(ul))
            .addClass("pagination")
            .addClass("justify-content-center")
            .apply();

        /**
         * @param {boolean} isActive
         * @param {boolean} isDisabled
         * @param {string} content
         * @param {number} pageLink
         * @returns {HTMLElement}
         */
        const createLi = (isActive, isDisabled, content, pageLink) => {
            const li = document.createElement("li");
            let liClass = (new ElementClass(li)).addClass("page-item");
            const a = document.createElement("a");
            let aClass = (new ElementClass(a)).addClass("page-link");

            if (isActive)
            {
                aClass.addClass("page-active");
            }

            if (isDisabled)
            {
                liClass.addClass("disabled");
                aClass.addClass("page-disabled");
            }

            if (!isActive && !isDisabled)
            {
                a.setAttribute("href", "javascript:void(0)");
                a.onclick = () => {
                    (new ElementClass(this.#main))
                        .addClass("text-center")
                        .apply();

                    this.#main.innerHTML = BlogHandler.preloader;
                    this.#requestPostsFunc(pageLink, this.#limit);
                };

                aClass.addClass("text-dark");
            }

            aClass.apply();
            a.innerHTML = content;

            liClass.apply();
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

        (new ElementClass(this.#main)).removeClass("text-center").apply();

        BlogHandler.preloader = this.#main.innerHTML;
        this.#main.innerHTML = "";
    }
}

module.exports = BlogHandler;
