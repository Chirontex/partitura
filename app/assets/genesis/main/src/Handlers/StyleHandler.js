'use strict';

/**
 * Class StyleHandler
 * @package Partitura.Genesis.Main.Handlers
 */
class StyleHandler
{
    /**
     * 
     * @param {string} styleContent 
     * 
     * @returns {object}
     */
    static explodeStyle = (styleContent) => {
        if (styleContent == "" || styleContent == null)
        {
            return {};
        }

        const content = styleContent.split(";");
        const result = {};

        for (let keyValue in content)
        {
            [key, value] = keyValue.split(":")
                .map(entry => entry.trim());

            result[key] = value;
        }

        return result;
    }

    /**
     * 
     * @param {object} style
     * 
     * @returns {string}
     */
    static implodeStyle = (style) => {
        const styleKeys = Object.keys(style);
        const styleList = [];

        for (let i = 0; i < styleKeys.length; i++)
        {
            styleList.push(styleKeys[i]+":"+style[styleKeys[i]]);
        }

        let result = "";

        for (let i = 0; i < styleList.length; i++)
        {
            result += result == "" ? styleList[i] : ";"+styleList[i];
        }

        return result;
    }
}

module.exports = StyleHandler;
