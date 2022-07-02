'use strict';

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

    constructor(element, classTag)
    {
        this.#element = element;
        this.#classTag = classTag;
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
            .apply();
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
            .apply();
    }
}

module.exports = Highlighter;
