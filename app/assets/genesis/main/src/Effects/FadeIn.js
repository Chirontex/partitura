'use strict';

const StyleHandler = require('../Handlers/StyleHandler');

/**
 * Class FadeIn
 * @package Partitura.Genesis.Main.Effects
 */
class FadeIn
{
    /** @var {HTMLElement} */
    #element;

    /** @var {int} */
    #opacity;

    constructor(element)
    {
        this.#element = element;
        this.run();
    }

    run = () => {
        this.#opacity = 0;
        this.#delay();
    }

    #handle = () => {
        this.#opacity++;

        const style = StyleHandler
            .explodeStyle(this.#element.getAttribute("style"));

        if (this.#opacity < 100)
        {
            style["opacity"] = this.#opacity+"%";

            this.#element.setAttribute("style", StyleHandler.implodeStyle(style));
            this.#delay();

            return;
        }
        
        let newStyle = {};
        const styleKeys = Object.keys(style);

        for (let i = 0; i < styleKeys.length; i++)
        {
            let key = styleKeys[i];
            let value = style[styleKeys[i]];

            if (key == "opacity")
            {
                continue;
            }

            newStyle[key] = value;
        }

        this.#element.setAttribute("style", StyleHandler.implodeStyle(newStyle));
    }

    #delay = () => {
        setTimeout(this.#handle, 100);
    }
}

module.exports = FadeIn;
