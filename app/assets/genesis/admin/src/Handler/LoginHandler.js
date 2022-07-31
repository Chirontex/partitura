'use strict';

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
        const form = document.getElementById("login_form");

        if (form == null)
        {
            throw new Error("Login form was not found.");
        }

        form.onsubmit = () => {
            const button = document.getElementById("login_submit_button");

            if (button == null)
            {
                throw new Error("Submit button was not found.");
            }

            button.innerHTML = "";

            button.setAttribute("disabled", "true");

            const spinner = document.createElement("div");
            spinner.setAttribute("class", "spinner-grow spinner-grow-sm text-light");
            spinner.setAttribute("role", "status");

            const loading = document.createElement("span");
            loading.setAttribute("class", "visually-hidden");
            loading.innerHTML = "Loading...";

            spinner.appendChild(loading);

            button.appendChild(spinner);
        };
    }
}

module.exports = LoginHandler;
