'use strict';

const ClassHandler = require('../Handler/ClassHandler');

/**
 * Class ElementClass
 * @package Partitura.Genesis.Main.Repository
 */
class ElementClass
{
    /** @var {HTMLElement} */
    #element;

    /** @var {string[]} */
    #classList;

    constructor(element)
    {
        this.#element = element;
        this.#classList = ClassHandler.explodeClass(element.getAttribute("class"));
    }

    /**
     * @param {string} className
     * @returns {this}
     */
    addClass = (className) => {
        for (let i = 0; i < this.#classList.length; i++)
        {
            if (this.#classList[i] == className)
            {
                return this;
            }
        }

        this.#classList.push(className);

        return this;
    }

    /**
     * @param {string} className
     * @returns {this}
     */
    removeClass = (className) => {
        const newClassList = this.#classList.filter(
            (value) => {
                return value != className;
            }
        );

        this.#classList = newClassList;

        return this;
    }

    /**
     * @returns {string}
     */
    toString = () => {
        return ClassHandler.implodeClass(this.#classList);
    }

    /**
     * Applies stored class list to the element.
     */
    apply = () => {
        this.#element.setAttribute("class", this.toString());
    }
}

module.exports = ElementClass;
