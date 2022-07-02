'use strict';

const ElementStyle = require('../Repository/ElementStyle');

/**
 * Class FadeIn
 * @package Partitura.Genesis.Main.Effect
 */
class FadeIn
{
    /** @var {HTMLElement} */
    #element;

    /** @var {int} */
    #opacity;

    constructor(element, delay = 0)
    {
        this.#element = element;

        if (delay < 0)
        {
            delay = 0;
        }

        setTimeout(this.run, delay);
    }

    /**
     * Runs fading-in.
     */
    run = () => {
        this.#opacity = 0;
        this.#delay();
    }

    #handle = () => {
        this.#opacity++;

        const style = new ElementStyle(this.#element);

        if (this.#opacity < 100)
        {
            style
                .setStyle("opacity", this.#opacity+"%")
                .apply();

            this.#delay();

            return;
        }

        style.removeStyle("opacity").apply();
    }

    #delay = () => {
        setTimeout(this.#handle, 10);
    }
}

module.exports = FadeIn;
