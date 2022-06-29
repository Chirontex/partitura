'use strict';

/**
 * Class BlogClient
 * @package Partitura.Genesis.Main.Client
 */
class BlogClient
{
    #blogApiUri = "/api/blog/";
    #page;
    #limit;

    /** @var {callback} */
    #handler;

    constructor(handler)
    {
        this.#handler = handler;
    }

    /**
     * @returns {undefined|int}
     */
    getPage = () => {
        return this.#page;
    }

    /**
     * @param {undefined|int} page
     * @returns {this}
     */
    setPage = (page) => {
        this.#page = page;

        return this;
    }

    /**
     * @returns {undefined|int}
     */
    getLimit = () => {
        return this.#limit;
    }

    /**
     * @param {undefined|int} limit
     * @returns 
     */
    setLimit = (limit) => {
        this.#limit = limit;

        return this;
    }

    requestPosts = async () => {
        const args = {page: this.#page, limit: this.#limit};
        const argsKeys = Object.keys(args);
        let uri = this.#blogApiUri;
        let concatArgToUri = (uri, argKey, argValue) => {
            uri += uri == this.#blogApiUri ? "?" : "&";
            uri += argKey+"="+argValue;

            return uri;
        };
        let argKey;
        let argValue;

        for (let i = 0; i < argsKeys.length; i++)
        {
            argKey = argsKeys[i];
            argValue = args[argKey];

            if (argValue == undefined)
            {
                continue;
            }

            uri = concatArgToUri(uri, argKey, argValue);
        }

        await fetch(uri)
            .then(
                (response) => {
                    return response.json();
                },
                () => {
                    return {posts: [], pages: 0};
                }
            )
            .then((data) => {
                this.#handler(data);
            });
    }
}

module.exports = BlogClient;
