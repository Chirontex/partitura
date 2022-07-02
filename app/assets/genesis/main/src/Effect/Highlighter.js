'use strict';

const ElementClass = require('../Repository/ElementClass');
const ElementStyle = require('../Repository/ElementStyle');

/**
 * Class Highlighter
 * @package Partitura.Genesis.Main.Effect
 */
class Highlighter
{
    /** @var {HTMLElement} */
    #element;

    /** @var {string} */
    #classTag;

    /** @var {string} */
    #elementFooter = "";

    constructor(element, classTag)
    {
        this.#element = element;
        this.#classTag = classTag;
    }

    /**
     * @param {string} footerContent 
     * @returns {this}
     */
    setFooterContent = (footerContent) => {
        this.#elementFooter = footerContent;

        return this;
    }

    /**
     * Highlight the element.
     */
    invoke = () => {
        const elementCollection = document.getElementsByClassName(this.#classTag);

        for (let i = 0; i < elementCollection.length; i++)
        {
            (new ElementStyle(elementCollection[i]))
                .setStyle("opacity", "30%")
                .apply();
        }

        (new ElementStyle(this.#element))
            .removeStyle("opacity")
            .setStyle("transform", "scale(1.1)")
            .setStyle("-webkit-transform", "scale(1.1)")
            .setStyle("cursor", "pointer")
            .apply();

        const footer = document.createElement("p");
        (new ElementClass(footer))
            .addClass("main-text")
            .addClass("blog-post-footer")
            .apply();
        footer.innerHTML = this.#elementFooter;

        this.#element.appendChild(footer);
    }

    /**
     * Remove the highlighting.
     */
    revoke = () => {
        const elementCollection = document.getElementsByClassName(this.#classTag);

        for (let i = 0; i < elementCollection.length; i++)
        {
            (new ElementStyle(elementCollection[i]))
                .removeStyle("opacity")
                .apply();
        }

        (new ElementStyle(this.#element))
            .removeStyle("transform")
            .removeStyle("-webkit-transform")
            .removeStyle("cursor")
            .apply();

        const footerCollection = this.#element.getElementsByClassName("blog-post-footer");

        for (let i = 0; i < footerCollection.length; i++)
        {
            this.#element.removeChild(footerCollection[i]);
        }
    }
}

module.exports = Highlighter;
