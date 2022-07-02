'use strict';

const StyleHandler = require('../Handler/StyleHandler');

/**
 * Class ElementStyle
 * @package Partitura.Genesis.Main.Repository
 */
class ElementStyle
{
    /** @var {HTMLElement} */
    #element;

    /** @var {object} */
    #styleObject;

    constructor(element)
    {
        this.#element = element;
        this.#styleObject = StyleHandler.explodeStyle(element.getAttribute("style"));
    }

    /**
     * @param {string} key
     * @param {string} value
     * @returns {this}
     */
    setStyle = (key, value) => {
        this.#styleObject[key] = value;

        return this;
    }

    /**
     * @param {string} key 
     * @returns {this}
     */
    removeStyle = (key) => {
        const newStyleObject = {};
        const keys = Object.keys(this.#styleObject).filter(
            (existKey) => {
                return key != existKey;
            }
        );

        for (let i = 0; i < keys.length; i++)
        {
            newStyleObject[keys[i]] = this.#styleObject[keys[i]];
        }

        this.#styleObject = newStyleObject;

        return this;
    }

    /**
     * @returns {string}
     */
    toString = () => {
        return StyleHandler.implodeStyle(this.#styleObject);
    }

    /**
     * Applies stored style to the element.
     */
    apply = () => {
        this.#element.setAttribute("style", this.toString());
    }
}

module.exports = ElementStyle;
