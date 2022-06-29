'use strict';

/**
 * Class StyleHandler
 * @package Partitura.Genesis.Main.Handler
 */
class StyleHandler
{
    /**
     * Splits element style string by semicolons.
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
            keyValue = keyValue.split(":")
                .map(entry => entry.trim());

            if (keyValue[0] == undefined || keyValue[1] == undefined)
            {
                continue;
            }

            result[keyValue[0]] = keyValue[1];
        }

        return result;
    }

    /**
     * Compile style string from object.
     * 
     * @param {object} style
     * 
     * @returns {string}
     */
    static implodeStyle = (style) => {
        if (style == {})
        {
            return "";
        }

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
