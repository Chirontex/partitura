'use strict';

const FadeIn = require('../Effect/FadeIn');

/**
 * Class PostHandler
 * @package Partitura.Genesis.Main.Handler
 */
class PostHandler
{
    constructor()
    {
        this.#handlePost();
    }

    #handlePost = () => {
        const headers = document.getElementsByTagName("h1");
        const metadata = document.getElementsByClassName("post-metadata");
        const content = document.getElementsByClassName("post-content");

        let delay = this.#fadeInElementCollection(headers);
        delay = this.#fadeInElementCollection(metadata, delay);

        this.#fadeInElementCollection(content, delay);
    }

    /**
     * @param {HTMLCollectionOf<Element>} collection
     * @param {number} delay
     * 
     * @return {number} last delay
     */
    #fadeInElementCollection = (collection, delay = 0) => {
        for (let i = 0; i < collection.length; i++)
        {
            new FadeIn(collection[i], delay);

            delay = 500 * i;
        }

        return delay;
    }
}

module.exports = PostHandler;
