'use strict';

const OnSubmitFormButtonSpinner = require('../../../main/src/Effect/OnSubmitFormButtonSpinner');

/**
 * Class LoginHandler
 * @package Partitura.Genesis.Admin.Handler
 */
class LoginHandler
{
    constructor()
    {
        this.#handle();
    }

    #handle = () => {
        (new OnSubmitFormButtonSpinner("login_form", "login_submit_button"));
    }
}

module.exports = LoginHandler;
