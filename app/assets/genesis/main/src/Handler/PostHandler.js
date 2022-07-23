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
        const mainCollection = document.getElementsByTagName("main");
        const main = mainCollection[0];

        this.#fadeInElementCollection(main.children);
    }

    /**
     * @param {HTMLCollectionOf<Element>} collection
     * @param {number} delay
     * 
     * @return {number} last delay
     */
    #fadeInElementCollection = (collection, delay = 0) => {
        let lastDelay = delay;
        for (let i = 0; i < collection.length; i++)
        {
            new FadeIn(collection[i], lastDelay);

            lastDelay = 500 * i;
        }

        return lastDelay;
    }
}

module.exports = PostHandler;
