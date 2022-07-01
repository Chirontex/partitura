'use strict';

/**
 * Class ClassHandler
 * @package Partitura.Genesis.Main.Handler
 */
class ClassHandler
{
    /**
     * Splits element class string by spaces.
     * @param {string} classContent
     * @returns {string[]}
     */
    static explodeClass = (classContent) => {
        if (classContent == "" || classContent == null)
        {
            return {};
        }

        return classContent.split(" ");
    }

    /**
     * Compile classes string from list.
     * @param {string[]} classes
     * 
     * @return {string}
     */
    static implodeClass = (classes) => {
        let result = "";

        if (classes.length == 0)
        {
            return result;
        }

        for (let i = 0; i < classes.length; i++)
        {
            result += result == "" ? classes[i] : " "+classes[i];
        }

        return result;
    }
}

module.exports = ClassHandler;
